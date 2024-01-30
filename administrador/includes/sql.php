<?php
require_once('load.php');

function find_all($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table));
  }
}

function find_all_order($table, $order)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table) . " ORDER BY " . $db->escape($order));
  }
}

/*---------------------------------------------------------------------------------*/
/* Funcion para encontrar el cargo de un detalle de usuario (trabajador) por su ID */
/*---------------------------------------------------------------------------------*/
function find_detalle_cargo($id)
{
  global $db;
  $result = array();
  $sql = "SELECT u.id_cargo, c.nombre_cargo ";
  $sql .= "FROM detalles_usuario u ";
  $sql .= "LEFT JOIN cargos c ";
  $sql .= "ON u.id_cargo=c.id_cargos WHERE u.id_det_usuario='{$db->escape($id)}'";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_cat_localidades()
{
  $sql = "SELECT * FROM cat_localidades WHERE estatus=1 ORDER BY descripcion ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_cat_municipios()
{
  $sql = "SELECT * FROM cat_municipios WHERE estatus=1 ORDER BY descripcion  ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_cat_entidad()
{
  $sql = "SELECT * FROM cat_entidad_fed WHERE estatus=1 ORDER BY descripcion  ASC";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para llevar a cabo queries */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_sql($sql)
{
  global $db;
  $result = $db->query($sql);
  $result_set = $db->while_loop($result);
  return $result_set;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*  Función para encontrar datos por su id en una tabla */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_id($table, $id, $nombre_id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE {$db->escape($nombre_id)}='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/*  Función para encontrar la información de un usuario por su id */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_id_user($table, $id, $nombre_id)
{
  global $db;
  $id = (int)$id;
  if (tableExists($table)) {
    $sql = $db->query("SELECT * FROM {$db->escape($table)} WHERE {$db->escape($nombre_id)}='{$db->escape($id)}' LIMIT 1");
    if ($result = $db->fetch_assoc($sql))
      return $result;
    else
      return null;
  }
}

function area_default($id)
{
  global $db;
  $sql = "UPDATE cargos SET id_area = 1";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para cuando se elimina un cargo, poner en los detalles de usuario que están "Sin cargo" */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function cargo_default($id)
{
  global $db;
  $sql = "UPDATE detalles_usuario SET id_cargo = 1";
  $sql .= " WHERE id_cargo=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() >= 1) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para eliminar datos de una tabla, por su ID */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function delete_by_id($table, $id, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "DELETE FROM " . $db->escape($table);
    $sql .= " WHERE " . $db->escape($nombre_id) . "=" . $db->escape($id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para in-activar datos de una tabla, por su ID */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function inactivate_by_id($table, $id, $campo_estatus, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE " . $db->escape($nombre_id) . "=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para in-activar un usuario por su ID */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function inactivate_by_id_user($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE id_detalle_user=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para in-activar cargos en función del area in-activada */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function inactivate_area_cargo($id)
{
  global $db;
  $sql = "UPDATE cargos SET estatus_cargo = 0";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para in-activar un grupo */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function inactivate_grupo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=0";
    $sql .= " WHERE nivel_grupo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para in-activar users en función del grupo in-activado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function inactivate_user_group($table, $nivel, $campo_estatus)
{
  global $db;

  $sql2 = "UPDATE " . $db->escape($table) . " SET ";
  $sql2 .= $db->escape($campo_estatus) . "=0";
  $sql2 .= " WHERE user_level=" . $db->escape($nivel);
  $db->query($sql2);

  return ($db->affected_rows() >= 0) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar datos de una tabla, por su ID */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_by_id($table, $id, $campo_estatus, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $campo_estatus . "=1";
    $sql .= " WHERE " . $db->escape($nombre_id) . "=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar un usuario, en función del trabajador que se activó */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_by_id_user($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_detalle_user=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar usuario en función del cargo activado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_cargo_user($table, $id, $campo_estatus)
{
  global $db;
  $id = (int)$id;
  $id_asig = "SELECT id_cargo FROM detalles_usuario WHERE id_cargo = '{$db->escape($id)}'";
  $id_buscado = find_by_sql($id_asig);

  foreach ($id_buscado as $id_encontrado) {
    $sql2 = "UPDATE " . $db->escape($table) . " SET ";
    $sql2 .= $db->escape($campo_estatus) . "=1";
    $sql2 .= " WHERE id_detalle_user=" . $db->escape($id_encontrado['id_cargo']);
    $db->query($sql2);
  }
  return ($db->affected_rows() >= 0) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar detalle de usuario en función del cargo activado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_cargo_trabajador($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE id_cargo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() > 0) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar cargos en función del area activada */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_area_cargo($id)
{
  global $db;
  $sql = "UPDATE cargos SET estatus_cargo = 1";
  $sql .= " WHERE id_area=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}

function activate_grupo($table, $id, $campo_estatus)
{
  global $db;
  if (tableExists($table)) {
    $sql = "UPDATE " . $db->escape($table) . " SET ";
    $sql .= $db->escape($campo_estatus) . "=1";
    $sql .= " WHERE nivel_grupo=" . $db->escape($id);
    $db->query($sql);
    return ($db->affected_rows() === 1) ? true : false;
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para activar users en función del grupo activada */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function activate_user_group($id)
{
  global $db;
  $sql = "UPDATE users SET status = 1";
  $sql .= " WHERE user_level=" . $db->escape($id);
  $db->query($sql);
  return ($db->affected_rows() > 0) ? true : false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para contar los ID de algún campo para saber su cantidad total */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function count_by_id($table, $nombre_id)
{
  global $db;
  if (tableExists($table)) {
    $sql    = "SELECT COUNT(" . $db->escape($nombre_id) . ") AS total FROM " . $db->escape($table);
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Determina si una tabla ya existe */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function tableExists($table)
{
  global $db;
  $table_exit = $db->query('SHOW TABLES FROM ' . DB_NAME . ' LIKE "' . $db->escape($table) . '"');
  if ($table_exit) {
    if ($db->num_rows($table_exit) > 0)
      return true;
    else
      return false;
  }
}
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Login con la información proporcionada en el $_POST, que proviene del formulario del login */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function authenticate($username = '', $password = '')
{
  global $db;
  $username = $db->escape($username);
  $password = $db->escape($password);
  $sql  = "SELECT id_user,username,password,user_level,status FROM users WHERE username = '{$username}' LIMIT 1";
  $result = $db->query($sql);
  if ($db->num_rows($result)) {
    $user = $db->fetch_assoc($result);
    $password_request = sha1($password);
    if ($password_request === $user['password'] && $user['status'] != 0) {
      return $user['id_user'];
    }
  }
  return false;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra el usuario logueado actualmente en la sesión por el ID de esta */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function current_user()
{
  static $current_user;
  if (!$current_user) {
    if (isset($_SESSION['user_id'])) :
      $user_id = intval($_SESSION['user_id']);
      $current_user = find_by_id_user('users', $user_id, 'id_user');
    endif;
  }
  return $current_user;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra todos los usuarios haciendo unión entre users con la tabla de grupo_usuarios */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_all_cuentas()
{
  $sql = "SELECT u.id_user, u.username, u.user_level, u.status, u.ultimo_login, g.nombre_grupo ";
  $sql .= "FROM users u ";
  $sql .= "LEFT JOIN grupo_usuarios g ";
  $sql .= "ON g.nivel_grupo=u.user_level ORDER BY u.username";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función que encuentra todos los cargos y se relaciona con la tabla areas, para obtener el nombre de esta en función del cargo */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_all_cargos()
{
  $sql = "SELECT u.id_cargos,u.nombre_cargo,u.id_area,u.estatus_cargo,a.nombre_area ";

  $sql .= "FROM cargos u ";
  $sql .= "LEFT JOIN area a ";
  $sql .= "ON u.id_area=a.id_area ORDER BY a.nombre_area";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_cargos2()
{
  $sql = "SELECT c.id_cargos, c.nombre_cargo, a.id_area, a.nombre_area ";
  $sql .= "FROM cargos as c LEFT JOIN area as a ON c.id_area = a.id_area ";
  $sql .= "ORDER BY c.nombre_cargo ";
  $result = find_by_sql($sql);
  return $result;
}


/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para actualizar la fecha del ultimo inicio de sesión de un usuario */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/

function updateLastLogIn($user_id)
{
  global $db;
  $date = make_date();
  $sql = "UPDATE users SET ultimo_login='{$date}' WHERE id_user ='{$user_id}' LIMIT 1";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra todos los nombres de grupos de usuarios */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_groupName($val)
{
  global $db;
  $sql = "SELECT nombre_grupo FROM grupo_usuarios WHERE nombre_grupo = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra todos los nombres de todas las areas de trabajo */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_areaName($val)
{
  global $db;
  $sql = "SELECT nombre_area FROM area WHERE nombre_area = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra todos los nombres de los cargos */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_cargoName($val)
{
  global $db;
  $sql = "SELECT nombre_cargo FROM cargos WHERE nombre_cargo = '{$db->escape($val)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Encuentra los niveles de grupo */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_by_groupLevel($level)
{
  global $db;
  $sql = "SELECT nivel_grupo, estatus_grupo FROM grupo_usuarios WHERE nivel_grupo = '{$db->escape($level)}' LIMIT 1 ";
  $result = $db->query($sql);
  return ($db->num_rows($result) === 0 ? true : false);
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para ver qué nivel de usuario tiene acceso a cada página */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function page_require_level($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //si el usuario no esta logueado
  if (!$session->isUserLoggedIn(true)) :
    $session->msg('d', 'Por favor, inicia sesión...');
    redirect('index.php', false);
  //si estatus de grupo de usuario esta desactivado
  elseif (@$login_level['estatus_grupo'] === 0) : //Si se quita el arroba muestra un notice
    $session->msg('d', 'Este nivel de usuario esta inactivo!');
    redirect('home.php', false);
  //checa si el nivel de usuario es menor o igual al requerido
  elseif ($current_user['user_level'] <= (int)$require_level) :
    return true;
  else :
    $session->msg("d", "¡Lo siento! no tienes permiso para ver la página.");
    redirect('home.php', false);
  endif;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para ver que nivel exacto de usuario tiene acceso a cada pagina */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function page_require_level_exacto($require_level)
{
  global $session;
  $current_user = current_user();
  $login_level = find_by_groupLevel($current_user['user_level']);
  //si el usuario no esta logueado
  if (!$session->isUserLoggedIn(true)) :
    $session->msg('d', 'Por favor, inicia sesión...');
    redirect('index.php', false);
  //si estatus de grupo de usuario esta desactivado
  elseif (@$login_level['estatus_grupo'] === 0) : //Si se quita el arroba muestra un notice
    $session->msg('d', 'Este nivel de usuario esta inactivo!');
    redirect('home.php', false);
  //checa si el nivel de usuario es menor o igual al requerido
  elseif ($current_user['user_level'] == $require_level) :
    return true;
  else :
    $session->msg("d", "¡Lo siento! no tienes permiso para ver la página.");
    redirect('home.php', false);
  endif;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para encontrar el detalle de usuario que le pertenece a un usuario */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function midetalle($id)
{
  $sql  = "SELECT d.id_det_usuario FROM detalles_usuario d INNER JOIN users u ON u.id_detalle_user = d.id_det_usuario WHERE u.id_user = {$id} LIMIT 1";
  return find_by_sql($sql);
}

function find_all_localidades($id)
{
  $sql = "SELECT * FROM cat_localidades WHERE id_cat_municipios = {$id} ORDER BY nnombre_localidad ASC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_areas()
{
  $sql = "SELECT * FROM area WHERE area_padre = 0 ORDER BY nombre_area ASC";
  $result = find_by_sql($sql);
  return $result;
}
function find_all_areas2($id)
{
  $sql = "SELECT * FROM area WHERE area_padre = '{$id}' ORDER BY nombre_area ASC";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para encontrar el ultimo id de folios para después sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function last_id_folios()
{
  $sql = "SELECT * FROM folios ORDER BY id_folio DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para encontrar el ultimo id de folios para después sumarle uno y que el nuevo registro tome ese valor */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function last_id_folios_general()
{
  $sql = "SELECT * FROM folios ORDER BY id_folio DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para obtener el grupo de usuario al que pertenece el usuario logueado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function area_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT g.nivel_grupo
                      FROM  grupo_usuarios g
                      LEFT JOIN users u ON u.user_level = g.nivel_grupo
                      WHERE u.id_user = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para obtener el grupo de usuario al que pertenece el usuario logueado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function nombre_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT d.nombre, d.apellidos
                      FROM  detalles_usuario d
                      LEFT JOIN users u ON u.user_level = d.id
                      WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para obtener el area a la que pertenece el usuario logueado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function area_usuario2($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT a.nombre_area, a.id_area
                      FROM detalles_usuario d
                      LEFT JOIN users u ON u.id_detalle_user = d.id_det_usuario
                      LEFT JOIN cargos c ON c.id_cargos = d.id_cargo
                      LEFT JOIN area a ON a.id_area = c.id_area
                      WHERE u.id_user = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para obtener el cargo al que pertenece el usuario logueado */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function cargo_usuario($id_usuario)
{
  global $db;
  $id_usuario = (int)$id_usuario;

  $sql = $db->query("SELECT c.nombre_cargo FROM  area g LEFT JOIN users u ON u.user_level = g.id LEFT JOIN detalles_usuario d ON u.id_detalle_user = d.id 
                      LEFT JOIN cargos c ON c.id = d.id_cargo LEFT JOIN area a ON a.id = c.id_area WHERE u.id = '{$db->escape($id_usuario)}' LIMIT 1");
  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para ver qué área tiene el usuario para tener acceso a cada pagina */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function page_require_area($require_area)
{
  global $session;
  $current_user = current_user();
  $area = area_usuario($current_user['id_user']);
  $id_area = $area['id_area'];
  // Le puse || $id_area==2, para que los que son de sistemas si puedan ver todos los módulos
  if (($id_area == $require_area) || ($id_area <= 2)) {
    return true;
  } else {
    $session->msg("d", "¡Lo siento! tu área no tiene permiso para ver esta página.");
    redirect('home.php', false);
  }
}

function insertAccion($user_id, $accion, $id_accion)
{
  global $db;
  $sql = "INSERT INTO registro_actividades (id_usuarios, fecha_accion, descripcion, accion) VALUES ({$user_id}, NOW(),'{$accion}', {$id_accion});";
  $result = $db->query($sql);
  return ($result && $db->affected_rows() === 1 ? true : false);
}

function notificacion()
{
  global $db;
  $sql    = "SELECT COUNT('notificacion') AS total FROM quejas_dates WHERE notificacion = 1";
  $result = $db->query($sql);
  return ($db->fetch_assoc($result));
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para sacar relación area-usuario
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_area_usuario()
{
  global $db;
  $sql  = "SELECT d.nombre, d.apellidos, a.nombre_area, a.id_area ";
  $sql .= "FROM detalles_usuario d ";
  $sql .= "LEFT JOIN cargos c ON d.id_cargo = c.id_cargos ";
  $sql .= "LEFT JOIN area a ON a.id_area = c.id_area ";
  $sql .= "ORDER BY d.nombre";
  return $db->query($sql);
}

function find_all_area_orden($table)
{
  global $db;
  if (tableExists($table)) {
    return find_by_sql("SELECT * FROM " . $db->escape($table) . " ORDER BY nombre_area");
  }
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función para encontrar el ultimo id la tabla */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function last_id_table($table, $nombre_id)
{
  $sql = "SELECT * FROM {$table} ORDER BY {$nombre_id} DESC LIMIT 1";
  $result = find_by_sql($sql);
  return $result;
}

/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
/* Función que encuentra la descripcion de un id */
/*------------------------------------------------------------------------------------------------------------------------------------------------------------*/
function find_campo_id($table, $id, $nombre_id, $columna)
{
  global $db;
  if (tableExists($table)) {
    $sql = ("SELECT {$db->escape($columna)} FROM {$db->escape($table)} WHERE {$db->escape($nombre_id)}='{$db->escape($id)}'");
    $result = $db->query($sql);
    return ($db->fetch_assoc($result));
  }
}

function find_all_osc()
{
  $sql = "SELECT o.id_osc, o.nombre, o.siglas, o.logo, o.ambito, o.objetivo, o.figura_juridica, o.fecha_constitucion, o.datos_escritura_const, 
  o.nombre_responsable, o.calle_num, o.colonia, o.cp, o.telefono, o.web_oficial, o.x, o.facebook, o.instagram, o.youtube, o.tiktok, o.correo_oficial, o.convenio_cedh, o.region, dv.descripcion as ambito_dv, a.descripcion as region_a , o.info_publica, o.estatus
  FROM osc o 
  LEFT JOIN cat_der_vuln dv ON dv.id_cat_der_vuln = o.ambito 
  LEFT JOIN cat_municipios a ON a.id_cat_mun = o.region ORDER BY o.nombre";
  $result = find_by_sql($sql);
  return $result;
}
function osc_by_id($id_osc)
{
  global $db;
  $sql = $db->query("SELECT o.id_osc, o.nombre, o.siglas, o.logo, o.ambito, o.objetivo, o.figura_juridica, o.fecha_constitucion, o.datos_escritura_const, 
            o.nombre_responsable, o.calle_num, o.colonia, o.cp, o.telefono, o.web_oficial, o.x, o.facebook, o.instagram, o.youtube, o.tiktok, o.correo_oficial, o.convenio_cedh, o.region, dv.descripcion as ambito_dv, a.descripcion as region_a , o.info_publica
            FROM osc o 
            LEFT JOIN cat_der_vuln dv ON dv.id_cat_der_vuln = o.ambito 
            LEFT JOIN cat_municipios a ON a.id_cat_mun = o.region
            WHERE o.id_osc = '{$db->escape($id_osc)}' ORDER BY o.nombre");

  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_all_eventos2()
{
  $sql = "SELECT e.id_evento, e.id_osc, e.fecha, e.hora, e.lugar, e.tema, SUBSTRING(e.tema,1,40) as temaCorto, o.nombre
          FROM eventos e
          LEFT JOIN osc o ON o.id_osc = e.id_osc
          ORDER BY e.fecha DESC";
  $result = find_by_sql($sql);
  return $result;

}
function find_all_eventos()
{
  $sql = "SELECT e.id_evento, e.id_osc, e.fecha, e.hora, e.lugar, e.tema, o.nombre
          FROM eventos e
          LEFT JOIN osc o ON o.id_osc = e.id_osc
          ORDER BY e.fecha DESC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_eventos_osc($id_osc)
{
  $sql = "SELECT e.id_evento, e.id_osc, e.fecha, e.hora, e.lugar, e.tema, o.nombre
          FROM eventos e
          LEFT JOIN osc o ON o.id_osc = e.id_osc
          WHERE e.id_osc = $id_osc
          ORDER BY e.fecha DESC";
  $result = find_by_sql($sql);
  return $result;
}

function evento_id($id_evento)
{
  global $db;
  $sql = $db->query("SELECT e.id_evento, e.id_osc, e.fecha, e.hora, e.lugar, e.tema, o.nombre 
            FROM eventos e
            LEFT JOIN osc o ON o.id_osc = e.id_osc
            WHERE e.id_evento = '{$db->escape($id_evento)}'");

  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}
function find_all_noticias()
{
  $sql = "SELECT n.id_noticia, n.id_osc, n.fecha, n.titulo_noticia, n.noticia, n.imagen, o.nombre
          FROM noticias n
          LEFT JOIN osc o ON o.id_osc = n.id_osc
          ORDER BY n.fecha DESC";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_noticias2()
{
  $sql = "SELECT n.id_noticia, n.id_osc, n.fecha, n.titulo_noticia, SUBSTRING(n.noticia,1,215) as noticia_all, n.imagen, o.nombre
          FROM noticias n
          LEFT JOIN osc o ON o.id_osc = n.id_osc
          ORDER BY n.fecha DESC LIMIT 3";
  $result = find_by_sql($sql);
  return $result;
}

function find_all_noticias_osc($id_osc)
{
  $sql = "SELECT n.id_noticia, n.id_osc, n.fecha, n.titulo_noticia, n.noticia, n.imagen, o.nombre
          FROM noticias n
          LEFT JOIN osc o ON o.id_osc = n.id_osc
          WHERE n.id_osc = $id_osc
          ORDER BY n.fecha DESC";
  $result = find_by_sql($sql);
  return $result;
}

function noticia_by_id($id_noticia)
{
  global $db;
  $sql = $db->query("SELECT n.id_noticia, n.id_osc, n.fecha, n.titulo_noticia, n.noticia, n.imagen, o.nombre 
            FROM noticias n
            LEFT JOIN osc o ON o.id_osc = n.id_osc
            WHERE n.id_noticia = '{$db->escape($id_noticia)}'");

  if ($result = $db->fetch_assoc($sql))
    return $result;
  else
    return null;
}

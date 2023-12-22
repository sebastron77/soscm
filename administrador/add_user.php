<?php
$page_title = 'Agregar usuarios';
require_once('includes/load.php');

page_require_level(1);
$groups = find_all('grupo_usuarios');
$user = current_user();
$cat_municipios = find_all_cat_municipios();
?>
<?php
if (isset($_POST['add_user'])) {
  if (empty($errors)) {
    $username   = remove_junk($db->escape($_POST['username']));
    $password   = remove_junk($db->escape($_POST['contraseña']));
    $user_level = (int)$db->escape($_POST['level']);
    $password = sha1($password);

    $nombre   = remove_junk($db->escape($_POST['nombre']));
    $apellidos   = remove_junk($db->escape($_POST['apellidos']));
    $sexo   = remove_junk($db->escape($_POST['sexo']));
    $correo   = remove_junk($db->escape($_POST['correo']));
    $municipio   = remove_junk($db->escape($_POST['municipio']));
    $estado   = remove_junk($db->escape($_POST['estado']));
    $telefono   = remove_junk($db->escape($_POST['telefono']));


    $conn = new PDO('mysql:host=localhost;dbname=soscm', 'suigcedh', '9DvkVuZ915H!');
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $query = "INSERT INTO detalles_usuario (";
    $query .= "nombre,apellidos,sexo,correo,municipio,estado,telefono,estatus_detalle";
    $query .= ") VALUES (";
    $query .= " '{$nombre}','{$apellidos}','{$sexo}','{$correo}','{$municipio}','{$estado}','{$telefono}','1'";
    $query .= ")";

    $conn->exec($query);
    $last_id = $conn->lastInsertId();

    $query2 = "INSERT INTO users (";
    $query2 .= "id_detalle_user,username,password,user_level,status";
    $query2 .= ") VALUES (";
    $query2 .= " '{$last_id}', '{$username}', '{$password}', '{$user_level}','1'";
    $query2 .= ")";

    if ($db->query($query2)) {
      //sucess
      $session->msg('s', " La cuenta de usuario ha sido creada con éxito.");
      insertAccion($user['id_user'], '"' . $user['username'] . '" agregó el usuario: ' . $username . '.', 1);
      redirect('add_user.php', false);
    } else {
      //failed
      $session->msg('d', ' No se pudo crear la cuenta.');
      redirect('add_user.php', false);
    }
  } else {
    $session->msg("d", $errors);
    redirect('add_user.php', false);
  }
}
?>
<?php include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
  <div class="panel panel-default">
    <div class="panel-heading">
      <strong>
        <span class="glyphicon glyphicon-th"></span>
        <span>Datos Generales del Usuario</span>
      </strong>
    </div>
    <div class="panel-body">
      <form method="post" action="add_user.php">
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required>
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="apellidos">Apellidos</label>
              <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" required>
            </div>
          </div>
          <div class="col-md-1">
            <div class="form-group">
              <label for="sexo">Género</label>
              <select class="form-control" name="sexo">
                <option value="">Escoge una Opción</option>
                <option value="M">Mujer</option>
                <option value="H">Hombre</option>
                <option value="LGBT">LGBTTTIQ+</option>
                <option value="NB">No Binario</option>
                <option value="Otro">Otro</option>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="telefono">Teléfono</label>
              <input type="text" class="form-control" name="telefono">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="correo">Correo</label>
              <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-md-2">
            <div class="form-group">
              <label for="municipio">Municipio</label>
              <select class="form-control" name="municipio">
                <option value="">Escoge una opción</option>
                <?php foreach ($cat_municipios as $id_cat_municipio) : ?>
                  <option value="<?php echo $id_cat_municipio['id_cat_mun']; ?>"><?php echo ucwords($id_cat_municipio['descripcion']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-2">
            <div class="form-group">
              <label for="estado">Estado</label>
              <input type="text" class="form-control" name="estado">
            </div>
          </div>
        </div>
        <strong><br>
          <span class="glyphicon glyphicon-th"></span>
          <span>DATOS DE CUENTA DEL USUARIO</span>
        </strong>
        <div class="row">
          <div class="col-md-3">
            <div class="form-group">
              <label for="username">Username</label>
              <input type="text" class="form-control" name="username" placeholder="Nombre de usuario">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="contraseña">Contraseña</label>
              <input type="password" class="form-control" name="contraseña" placeholder="Contraseña">
            </div>
          </div>
          <div class="col-md-3">
            <div class="form-group">
              <label for="level">Rol de usuario</label>
              <select class="form-control" name="level">
                <?php foreach ($groups as $group) : ?>
                  <option value="<?php echo $group['nivel_grupo']; ?>"><?php echo ucwords($group['nombre_grupo']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group clearfix">
          <a href="users.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
            Regresar
          </a>
          <button type="submit" name="add_user" class="btn btn-primary" style="background: #091d5d; border-color: #091d5d;">Guardar</button>
        </div>
      </form>
    </div>

  </div>

</div>
</div>

<?php include_once('layouts/footer.php'); ?>
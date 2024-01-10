<?php
$page_title = 'Agregar usuarios';
require_once('includes/load.php');

page_require_level(1);
$groups = find_all('grupo_usuarios');
$user = current_user();
$cat_municipios = find_all_cat_municipios();
$oscs  = find_all('osc');
?>
<?php
if (isset($_POST['add_user'])) {
  if (empty($errors)) {
    $username   = remove_junk($db->escape($_POST['username']));
    $password   = remove_junk($db->escape($_POST['contraseña']));
    $user_level = (int)$db->escape($_POST['level']);
    $id_osc = (int)$db->escape($_POST['id_osc']);
    $password = sha1($password);

    $query2 = "INSERT INTO users (";
    $query2 .= "username,password,user_level,osc,status";
    $query2 .= ") VALUES (";
    $query2 .= " '{$username}', '{$password}', '{$user_level}','{$id_osc}','1'";
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
          <div class="col-md-2">
            <div class="form-group">
              <label for="level">Rol de usuario</label>
              <select class="form-control" name="level">
                <?php foreach ($groups as $group) : ?>
                  <option value="<?php echo $group['nivel_grupo']; ?>"><?php echo ucwords($group['nombre_grupo']); ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          <div class="col-md-4">
            <div class="form-group">
              <label for="id_osc">OSC</label>
              <select class="form-control" name="id_osc">
                <?php foreach ($oscs as $osc) : ?>
                  <option value="<?php echo $osc['id_osc']; ?>"><?php echo ucwords($osc['nombre']); ?></option>
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
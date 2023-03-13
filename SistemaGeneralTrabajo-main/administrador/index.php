<?php
  ob_start();
  require_once('includes/load.php');
  if($session->isUserLoggedIn(true)) { redirect('home.php', false);}
?>
<div class="body2">
<div class="login-page">
  <div class="text-center">
    <h1 style="margin-top:25px; font-weight: bold; color:#3A3D56;">Bienvenido</h1>
    <!-- <i class="large material-icons">account_circle</i> -->
    <p style="font-size:16px; color:#3A3D56;">Iniciar sesión </p>
  </div>
  <?php echo display_msg($msg); ?>
  <form method="post" action="auth.php" class="clearfix">
    <div class="form-group">
      <label for="username" class="control-label">Usuario</label>
      <input type="name" style="background:#E3E3E3; color:#E3E3E3;" class="form-control" name="username" placeholder="Usuario">
    </div>
    <div class="form-group">
      <label for="Password" class="control-label">Contraseña</label>
      <input type="password" style="background:#E3E3E3; color:#E3E3E3;" name= "password" class="form-control" placeholder="Contraseña">
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-info  pull-right" style="background: #370494; border-color: #370494;">Entrar</button>
    </div>
  </form>
</div>
</div>
<?php include_once('layouts/header.php'); ?>

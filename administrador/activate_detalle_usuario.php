<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  $activate_id = activate_by_id('detalles_usuario',(int)$_GET['id'],'estatus_detalle','id_det_usuario');
  $activate_user = activate_by_id_user('users',(int)$_GET['id'],'status');

  if($activate_id){
      $session->msg("s","Trabajador activado");
      redirect('detalles_usuario.php');
  } else {
      $session->msg("d","Se ha producido un error en la activación del trabajador");
      redirect('detalles_usuario.php');
  }
?>

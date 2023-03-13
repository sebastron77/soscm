<?php
  require_once('includes/load.php');  
  page_require_level(1);
?>
<?php
  $inactivate_id = inactivate_by_id('detalles_usuario',(int)$_GET['id'],'estatus_detalle','id_det_usuario');
  $inactivate_user = inactivate_by_id_user('users',(int)$_GET['id'],'status');

  if($inactivate_id){
      $session->msg("s","Trabajador inactivado");
      redirect('detalles_usuario.php');
  } else {
      $session->msg("d","Se ha producido un error en la inactivación del trabajador");
      redirect('detalles_usuario.php');
  }
?>

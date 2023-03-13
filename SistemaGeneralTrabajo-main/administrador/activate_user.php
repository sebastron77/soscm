<?php
  require_once('includes/load.php');
  
   page_require_level(1);
?>
<?php
  //$delete_id = delete_by_id('users',(int)$_GET['id']);
  $inactivate_id = activate_by_id('users',(int)$_GET['id'],'status','id_user');
  if($inactivate_id){
      $session->msg("s","Usuario activado");
      redirect('users.php');
  } else {
      $session->msg("d","Se ha producido un error en la activación del usuario");
      redirect('users.php');
  }
?>

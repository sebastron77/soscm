<?php
  require_once('includes/load.php');
  
   if ($nivel == 1) {
    page_require_level_exacto(1);
}   
if ($nivel == 5) {
    page_require_level_exacto(5);
}
?>
<?php
  //Para que cuando se borre un área, los cargos que pertenecían a esta
  //ahora aparezcan como "Sin área"
  $cargo_area_default = area_default((int)$_GET['id']);
  $delete_id = delete_by_id('rel_queja_acuerdos',(int)$_GET['id'],'id_rel_queja_acuerdos');

  if($delete_id){
      $session->msg("s","Acuerdo Eliminado");
      redirect('acuerdos_queja.php?id='.(int)$_GET['q']);
  } else {
      $session->msg("d","Eliminación falló");
      redirect('acuerdos_queja.php?id='.(int)$_GET['q']);
  }
?>

<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Áreas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];

page_require_level(50);

?>

<?php
// $c_categoria     = count_by_id('categorias');
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<h1 style="color:#3A3D44; margin-left: 10px;">Áreas</h1>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>


<div class="row">
  <?php if (($otro == 5) || ($otro <= 2) || ($otro == 19) || ($otro == 20)): ?>
    <a href="solicitudes_quejas.php" class="col-md-3" style="height: 12.5rem;">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left"
          style="background: #7263F0;">
          <svg style="width:40px;height:62px" viewBox="0 0 24 24">
            <path fill="white"
              d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <p style="font-size: 16px; margin-top:8%; color:#3A3D44;">Registro de Quejas y Seguimiento</p>
          <div><br>
          </div>
        </div>
      </div>
    </a>
  <?php endif ?>
  
</div><br>
<?php include_once('layouts/footer.php'); ?>
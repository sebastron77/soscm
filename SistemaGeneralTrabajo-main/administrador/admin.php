<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Página de Inicio';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);

if ($nivel_user <= 2) {
  page_require_level(2);
}
if ($nivel_user == 7) {
  page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7):
  redirect('home.php');
endif;
if ($nivel_user > 7):
  redirect('home.php');
endif;
?>
<?php
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
$c_orientacion = count_by_id_orientacion('orientacion_canalizacion', 'id_or_can');
$c_canalizacion = count_by_id_canalizacion('orientacion_canalizacion', 'id_or_can');
$c_quejas = count_by_id('quejas_dates', 'id_queja_date');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
  <div class="col-md-12">
    <?php echo display_msg($msg); ?>
  </div>
</div>
<div class="row">
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="users.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="large material-icons">account_circle</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_user['total']; ?>
          </h2>
          <p>Cuentas de Usuario</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="detalles_usuario.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="glyphicon glyphicon-user"></i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_trabajadores['total']; ?>
          </h2>
          <p>Trabajadores</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="areas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet"">
        <i class=" large material-icons">business</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_areas['total']; ?>
          </h2>
          <p>Áreas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="cargos.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet">
          <i class="large material-icons">business_center</i>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_cargos['total']; ?>
          </h2>
          <p>Cargos</p>
        </div>
      </div>
    </a>
  </div>
</div>


<div class="row" style="margin-top: 5px;">

  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="quejas.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:64px" viewBox="0 0 24 24">
            <path fill="white"
              d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_quejas['total']; ?>
          </h2>
          <p>Quejas Registradas</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="orientaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:64px" viewBox="0 0 24 24">
            <path fill="white"
              d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_orientacion['total']; ?>
          </h2>
          <p>Orientaciones</p>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3" style="height: 12.5rem;">
    <a style="color: #333333;" href="canalizaciones.php">
      <div class="panel panel-box clearfix">
        <div class="panel-icon pull-left bg-violet" style="display: grid; place-content: center;">
          <svg style="width:40px;height:64px" viewBox="0 0 24 24">
            <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
          </svg>
        </div>
        <div class="panel-value pull-right">
          <h2 style="margin-top: 10%; font-size: 40px">
            <?php echo $c_canalizacion['total']; ?>
          </h2>
          <p>Canaliza-</p>
          <p style="margin-top: -6%;">ciones</p>
        </div>
      </div>
    </a>
  </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Quejas';
require_once('includes/load.php');
$user = current_user();
//$id_usuario = $user['id'];

$user = current_user();
$id_user = $user['id_user'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['nivel_grupo'];
$nivel = $user['user_level'];


if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}
if ($nivel == 19) {
    page_require_level_exacto(19);
}

if ($nivel > 2 && $nivel < 5):
    redirect('home.php');
endif;
if ($nivel > 5 && $nivel < 7):
    redirect('home.php');
endif;
if ($nivel > 7 && $nivel < 19):
    redirect('home.php');
endif;
?>

<?php
// $c_categoria     = count_by_id('categorias');
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color:#3A3D44">Procesos de Orientación Legal, Quejas y Seguimiento</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<a href="quejas.php" class="tile">
				<div class="tile-tittle">Quejas</div>
				<div class="tile-icon">
				<svg style="width:100px;height:100px" fill="#455a64"  xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><title>account-child</title><path d="M12,2A3,3 0 0,1 15,5A3,3 0 0,1 12,8A3,3 0 0,1 9,5A3,3 0 0,1 12,2M12,9C13.63,9 15.12,9.35 16.5,10.05C17.84,10.76 18.5,11.61 18.5,12.61V18.38C18.5,19.5 17.64,20.44 15.89,21.19V19C15.89,18.05 15.03,17.38 13.31,16.97C12.75,16.84 12.31,16.78 12,16.78C11.13,16.78 10.3,16.95 9.54,17.3C8.77,17.64 8.31,18.08 8.16,18.61C9.5,19.14 10.78,19.41 12,19.41L13,19.31V21.94L12,22C10.63,22 9.33,21.72 8.11,21.19C6.36,20.44 5.5,19.5 5.5,18.38V12.61C5.5,11.61 6.16,10.76 7.5,10.05C8.88,9.35 10.38,9 12,9M12,11A2,2 0 0,0 10,13A2,2 0 0,0 12,15A2,2 0 0,0 14,13A2,2 0 0,0 12,11Z" /></svg>
					<i class="fas fa-user-tie"></i>
				</div>
				
		</a>

<!-- <div class="row" style="margin-top: 10px;"> -->
<div class="row">
    <?php if (($otro == 5) || ($otro <= 2) && ($nivel != 20)): ?>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: #7263F0;">
                    <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                        <path fill="white"
                            d="M21,4H3A2,2 0 0,0 1,6V19A2,2 0 0,0 3,21H21A2,2 0 0,0 23,19V6A2,2 0 0,0 21,4M3,19V6H11V19H3M21,19H13V6H21V19M14,9.5H20V11H14V9.5M14,12H20V13.5H14V12M14,14.5H20V16H14V14.5Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 17px; margin-top:4%; color:#3A3D44; ">Quejas</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                            <a style="margin-top:5%;" href="add_queja.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:5%;" href="quejas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($nivel != 19 && $nivel != 20): ?>
            <div class="col-md-3" style="height: 13.5rem;">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #7263F0;">
                        <svg style="width:40px;height:72px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <title>bullhorn</title>
                            <path fill="white"
                                d="M12,8H4A2,2 0 0,0 2,10V14A2,2 0 0,0 4,16H5V20A1,1 0 0,0 6,21H8A1,1 0 0,0 9,20V16H12L17,20V4L12,8M21.5,12C21.5,13.71 20.54,15.26 19,16V8C20.53,8.75 21.5,10.3 21.5,12Z" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin-top:2%;  ">Orientación</p>
                        <div style="margin-top:-5%;">
                            <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                                <a style="margin-top:5%;" href="add_orientacion.php" class="btn btn-success btn-sm">Agregar</a>
                            <?php endif; ?>
                            <a style="margin-top:5%;" href="orientaciones.php" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($nivel != 19 && $nivel != 20): ?>
            <div class="col-md-3" style="height: 13.5rem;">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #7263F0;">
                        <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                            <path fill="white" d="M8,14V18L2,12L8,6V10H16V6L22,12L16,18V14H8Z" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin-top:2%;  ">Canalización</p>
                        <div style="margin-top:-5%;">
                            <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                                <a style="margin-top:5%;" href="add_canalizacion.php" class="btn btn-success btn-sm">Agregar</a>
                            <?php endif; ?>
                            <a style="margin-top:5%;" href="canalizaciones.php" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($nivel != 19 && $nivel != 20): ?>
            <div class="col-md-3" style="height: 13.5rem;">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #7263F0;">
                        <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                            <path fill="white"
                                d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin-top:2%; ">Quejosos</p>
                        <div style="margin-top:-5%;">
                            <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                                <a style="margin-top:5%;" href="add_quejoso.php" class="btn btn-success btn-sm">Agregar</a>
                            <?php endif; ?>
                            <a style="margin-top:5%;" href="quejosos.php" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($nivel != 19 && $nivel != 20): ?>
        <div class="row" style="margin-top:1%;">
            <div class="col-md-3" style="height: 13.5rem;">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: #7263F0;">
                        <svg style="width:40px;height:72px" viewBox="0 0 24 24">
                            <path fill="white"
                                d="M16.75 4.36C18.77 6.56 18.77 9.61 16.75 11.63L15.07 9.94C15.91 8.76 15.91 7.23 15.07 6.05L16.75 4.36M20.06 1C24 5.05 23.96 11.11 20.06 15L18.43 13.37C21.2 10.19 21.2 5.65 18.43 2.63L20.06 1M9 4C11.2 4 13 5.79 13 8S11.2 12 9 12 5 10.21 5 8 6.79 4 9 4M13 14.54C13 15.6 12.71 18.07 10.8 20.83L10 16L10.93 14.12C10.31 14.05 9.66 14 9 14S7.67 14.05 7.05 14.12L8 16L7.18 20.83C5.27 18.07 5 15.6 5 14.54C2.6 15.24 .994 16.5 .994 18V22H17V18C17 16.5 15.39 15.24 13 14.54Z" />
                        </svg>
                    </div>
                    <div>
                        <p style="font-size: 17px; margin-top:2%; ">Agraviados</p>
                        <div style="margin-top:-5%;">
                            <a style="margin-top:5%;" href="agraviados.php" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php endif; ?>
<?php endif ?>
<!-- </div><br> -->

<!-- <div class="row"> -->

<!-- </div> -->

<?php include_once('layouts/footer.php'); ?>
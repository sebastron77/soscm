<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Quejas';
require_once('includes/load.php');
$user = current_user();

$user = current_user();
$id_user = $user['id_user'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];


if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level(5);
}
if ($nivel_user == 7) {
    page_require_level(7);
}
if ($nivel_user == 21) {
    page_require_level(21);
}
if ($nivel_user == 19) {
    redirect('home.php');
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
if ($nivel_user > 19 && $nivel_user < 21) :
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

<div class="container-fluid">
    <div class="full-box tile-container">
        <a href="quejas.php" class="tile">
            <div class="tile-tittle">Quejas</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    book
                </span>
            </div>
        </a>
        <a href="orientaciones.php" class="tile">
            <div class="tile-tittle">Orientaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">psychology_alt</span>
                <i class="fas fa-user-tie"></i>
            </div>
        </a>
        <a href="canalizaciones.php" class="tile">
            <div class="tile-tittle">Canalizaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    transfer_within_a_station
                </span>
                <i class="fas fa-user-tie"></i>
            </div>
        </a>
        <a href="quejosos.php" class="tile">
            <div class="tile-tittle">Promoventes</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    record_voice_over
                </span>
            </div>
        </a>
        <a href="agraviados.php" class="tile">
            <div class="tile-tittle">Agraviados</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    voice_over_off
                </span>
            </div>
        </a>
        <a href="actuaciones.php" class="tile">
            <div class="tile-tittle">Actuaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    receipt_long
                </span>
            </div>
        </a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Estadísticas de Quejas';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    page_require_level(3);
}
if ($nivel == 4) {
    redirect('home.php');
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}



?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12" style="font-size: 40px; color: #3a3d44;">
        <?php echo 'Estadísticas de Quejas'; ?>
    </div>
</div>


<div class="container-fluid">
    <div class="full-box tile-container">
        <a href="estQ_med_pres.php" class="tileA">
            <div class="tileA-tittle">Medio Presentación</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    input_circle
                </span>
            </div>
        </a>
        <a href="estQ_area_asignada.php" class="tileA">
            <div class="tileA-tittle">Área Asignada</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    school
                </span>
            </div>
        </a>
        <a href="estQ_autoridad.php" class="tileA">
            <div class="tileA-tittle">Autoridad Responsable</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    diversity_3
                </span>
            </div>
        </a>
        <a href="estQ_derecho_vulnerado.php" class="tileA">
            <div class="tileA-tittle">Derecho Vulnerado</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    translate
                </span>
            </div>
        </a>
        <!-- <a href="estQ_estado_procesal.php" class="tileA">
            <div class="tileA-tittle">Estado Procesal</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    translate
                </span>
            </div>
        </a>
        <a href="estQ_tipo_resolucion.php" class="tileA">
            <div class="tileA-tittle">Tipo Resolución</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    groups_3
                </span>
            </div>
        </a>
        <a href="estQ_entidad.php" class="tileA">
            <div class="tileA-tittle">Entidad</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    location_on
                </span>
            </div>
        </a>
        <a href="estQ_municipio.php?id=1" class="tileA">
            <div class="tileA-tittle">Municipios</div>
            <div class="tileA-icon">
                <span class="material-symbols-rounded" style="font-size: 95px;">
                    location_chip
                </span>
            </div>
        </a> -->

    </div>
</div>


<?php include_once('layouts/footer.php'); ?>
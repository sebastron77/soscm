<?php
$page_title = 'Secretaría Técnica';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    page_require_level(7);
}
if ($nivel_user == 21) {
    page_require_level_exacto(21);
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
$c_user = count_by_id('users', 'id_user');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color: #3a3d44;"> Solicitudes Consejo</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tileO-container">
        <a href="consejo.php" class="tileO">
            <div class="tileO-tittle">Actas sesión de consejo</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    receipt_long
                </span>
            </div>
        </a>

        <a href="convenios.php" class="tileO">
            <div class="tileO-tittle">Convenios</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    description
                </span>
            </div>
        </a>
        <a href="gestiones.php" class="tileO">
            <div class="tileO-tittle">Gestión Jurisdiccional</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">send_time_extension</span>
            </div>
        </a>
        <a href="eventos.php" class="tile">
            <div class="tile-tittle">Eventos</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    event_available
                </span>
            </div>
        </a>
        <a href="informes_areas.php" class="tile">
            <div class="tile-tittle">Informe Actividades</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    task_alt
                </span>
            </div>
        </a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
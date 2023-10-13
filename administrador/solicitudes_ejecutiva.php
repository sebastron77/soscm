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
if ($nivel_user == 3) {
    page_require_level(3);
}
if ($nivel_user == 4) {
    redirect('home.php');
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 6) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}
?>

<?php
$c_user = count_by_id('users', 'id_user');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color: #3a3d44;"> Solicitudes Secretaría Ejecutiva</h1>


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
		
        <a href="informes_areas.php" class="tileO">
            <div class="tileO-tittle">Informe de Actividades</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    add_chart
                </span>
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
        <a href="env_correspondencia.php" class="tile">
            <div class="tile-tittle">Corresp. Int. Enviada</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    edit_document
                </span>
            </div>
        </a>
        <a href="correspondencia_recibida.php" class="tile">
            <div class="tile-tittle">Corresp. Int. Recibida</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    file_open
                </span>
            </div>
        </a>
        <a href="acciones_vinculacion.php" class="tile">
            <div class="tile-tittle">Acciones Vinculación</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    compare_arrows
                </span>
            </div>
        </a>
        <a href="solicitudes_cotrapem.php" class="tile">
            <div class="tile-tittle">COTRAPEM</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    balance
                </span>
            </div>
        </a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>

<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Agendas y Mecanismos';
require_once('includes/load.php');
$user = current_user();
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if (($nivel_user > 2 && $nivel_user < 7)) :
    redirect('home.php');
endif;
if (($nivel_user > 7 && $nivel_user < 17)) :
    redirect('home.php');
endif;
if ($nivel_user > 17) :
    redirect('home.php');
endif;

?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color:#3A3D44">Solicitudes de Agendas y Mecanismos</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tile-container">
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
</div><br>

<?php include_once('layouts/footer.php'); ?>
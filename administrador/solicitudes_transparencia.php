<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Transparencia';
require_once('includes/load.php');

$user = current_user();
$id_usuario = $user['id_user'];
$nivel = $user['user_level'];
$nivel_user = $user['user_level'];

if (($nivel_user > 2 && $nivel_user < 7)) :
    redirect('home.php');
endif;
if (($nivel_user > 7 && $nivel_user < 10)) :
    redirect('home.php');
endif;
if ($nivel_user > 10) :
    redirect('home.php');
endif;

?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color:#3A3D44">Solicitudes Transparencia</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tile-container">
        
        <a href="solicitudes_ut.php" class="tile">
            <div class="tile-tittle" style="font-size: 13px;">Solicitudes de Información</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
					contact_support
				</span>
                <i class="fas fa-user-tie"></i>
            </div>
        </a>
		<a href="recursos_ut.php" class="tile">
            <div class="tile-tittle">Recursos Revisión</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
					warning
				</span>
                <i class="fas fa-user-tie"></i>
            </div>
        </a>
        <a href="denuncias_ut.php" class="tile">
            <div class="tile-tittle">Denuncias</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    sync_problem
                </span>
                <i class="fas fa-user-tie"></i>
            </div>
        </a>
      
        <a href="capacitaciones.php" class="tile">
            <div class="tile-tittle">Capacitaciones</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    supervisor_account
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
        <a href="informes_areas.php?a=13" class="tile">
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
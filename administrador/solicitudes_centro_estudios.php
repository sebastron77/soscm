<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Centro de Estudios';
require_once('includes/load.php');
$user = current_user();
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if (($nivel_user > 2 && $nivel_user < 6)) :
    redirect('home.php');
endif;

if ($nivel_user > 7) :
    redirect('home.php');
endif;

?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color: #3a3d44;">Solicitudes de Centro de Estudios</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tileO-container">

		
	   
        <a href="informes_areas.php?a=35" class="tileO">
            <div class="tileO-tittle">Informe de Actividades</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    task_alt
                </span>
            </div>
        </a>

        <a href="capacitaciones.php" class="tileO">
            <div class="tileO-tittle">Capacitaciones</div>
            <div class="tileO-icon">
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
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
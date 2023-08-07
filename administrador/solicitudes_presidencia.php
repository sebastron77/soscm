<?php
$page_title = 'Presidencia';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];
$id_grupo=2;

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
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color: #3a3d44;">Solicitudes de Presidencia</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<?php if(($nivel_user <= 2) ){?>
<div class="container-fluid">
    <div class="full-box tileO-container">
        <a href="add_gestion.php?a=1" class="tileO">
            <div class="tileO-tittle">Acciones Incost.</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    gavel
                </span>
            </div>
        </a>
<?php }?>
       
        <a href="eventos_pres.php" class="tileO">
            <div class="tileO-tittle">Actividades</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    arrow_circle_right
                </span>
            </div>
        </a>
<?php if(($nivel_user <= 2) ){?>		
        <a href="add_gestion.php?a=3" class="tileO">
            <div class="tileO-tittle">Amicus Curiae</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    groups
                </span>
            </div>
        </a>
<?php }?>		
<?php if(($nivel_user <= 2) ){?>		
        <a href="#" class="tileO">
            <div class="tileO-tittle">Ámparo</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    balance
                </span>
            </div>
        </a>
<?php }?>		
<?php if(($nivel_user <= 2) ){?>		
        <a href="add_gestion.php?a=2" class="tileO">
            <div class="tileO-tittle">Controversia Const.</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    account_balance
                </span>
            </div>
        </a>
<?php }?>       
        <a href="gestiones.php" class="tileO">
            <div class="tileO-tittle">Gestión Jurisdiccional</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">send_time_extension</span>
            </div>
        </a>
		<!--
        <a href="#" class="tileO">
            <div class="tileO-tittle">Opinión Consultiva</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    psychology_alt
                </span>
            </div>
        </a>
		-->
        <a href="correspondencia.php" class="tileO">
            <div class="tileO-tittle">Oficios</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    history_edu
                </span>
            </div>
        </a>
        <a href="recomendaciones_generales.php" class="tileO">
            <div class="tileO-tittle">Recomendaciones</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    breaking_news_alt_1
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
        <a href="informes_areas.php?a=2" class="tile">
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
		
		<a href="competencia.php" class="tile">
            <div class="tile-tittle" style="font-size: 12px;">Conflictos Competenciales</div>
            <div class="tile-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    find_in_page
                </span>
            </div>
        </a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
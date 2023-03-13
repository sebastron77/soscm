<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Centro Servicios Técnicos';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
// $id_user = $user['id'];
// $busca_area = area_usuario($id_usuario);
// $otro = $busca_area['id'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 9) {
//     page_require_level_exacto(9);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
if (($nivel_user > 2 && $nivel_user < 7)) :
    redirect('home.php');
endif;
if (($nivel_user > 7 && $nivel_user < 9)) :
    redirect('home.php');
endif;
if ($nivel_user > 9) :
    redirect('home.php');
endif;

?>

<?php
$c_categoria     = count_by_id('categorias');
$c_user          = count_by_id('users');
$c_trabajadores          = count_by_id('detalles_usuario');
$c_areas          = count_by_id('area');
$c_cargos          = count_by_id('cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a>
<h1>Solicitudes de Servicios Técnicos</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row" style="margin-top: 10px;">
    <div class="col-md-3" style="height: 12.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:63px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:5%; color:#333333; line-height: 100%;">Correspon-<br>dencia</p>
                <div style="margin-top:-5%;">
                    <?php if (($nivel <= 2) || ($nivel == 18)) : ?>
                    <a style="margin-top:5%;" href="add_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>
                    <?php endif; ?>
                    <a style="margin-top:5%;" href="correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                </svg>
            </div>
            <div class="panel-value pull-right">
                <p style="font-size: 15px; margin-top:2%; color:#333333; line-height: 100%;">Envío de Correspon-<br>dencia Interna</p>
                <div style="margin-top:-5%;">
                    
                        <a style="margin-top:5%;" href="add_env_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>
                    
                    <a style="margin-top:5%;" href="env_correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3" style="height: 13.5rem;">
        <div class="panel panel-box clearfix">
            <div class="panel-icon pull-left" style="background: #114987; display: grid; place-content: center;">
                <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                    <path fill="white" d="M21,5C19.89,4.65 18.67,4.5 17.5,4.5C15.55,4.5 13.45,4.9 12,6C10.55,4.9 8.45,4.5 6.5,4.5C4.55,4.5 2.45,4.9 1,6V20.65C1,20.9 1.25,21.15 1.5,21.15C1.6,21.15 1.65,21.1 1.75,21.1C3.1,20.45 5.05,20 6.5,20C8.45,20 10.55,20.4 12,21.5C13.35,20.65 15.8,20 17.5,20C19.15,20 20.85,20.3 22.25,21.05C22.35,21.1 22.4,21.1 22.5,21.1C22.75,21.1 23,20.85 23,20.6V6C22.4,5.55 21.75,5.25 21,5M21,18.5C19.9,18.15 18.7,18 17.5,18C15.8,18 13.35,18.65 12,19.5V8C13.35,7.15 15.8,6.5 17.5,6.5C18.7,6.5 19.9,6.65 21,7V18.5Z" />
                </svg>
            </div>
            <div>
                <p style="font-size: 13px; margin-top:1%;">Agenda de Proyectos</p>
                <div style="margin-top:-3%;">
                    <a style="margin-top:1%" href="add_agenda.php" class="btn btn-success btn-sm">Agregar</a>
                    <a style="margin-top:1%" href="agendas.php" class="btn btn-primary btn-sm">Ver</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
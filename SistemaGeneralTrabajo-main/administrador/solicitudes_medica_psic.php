<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Solicitudes - Área Médica y Psicológica';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id'];

// $user = current_user();
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// if ($nivel_user <= 2) {
//     page_require_level(2);
// }
// if ($nivel_user == 4) {
//     page_require_level_exacto(4);
// }
// if ($nivel_user == 7) {
//     page_require_level_exacto(7);
// }
if ($nivel_user > 2 && $nivel_user < 4) :
    redirect('home.php');
endif;
if ($nivel_user > 4 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
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

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1>Subcoordinación de Servicios Técnicos</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<?php if (($otro == 4) || ($otro <= 2)) : ?>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M18,14H14V18H10V14H6V10H10V6H14V10H18M19,3H5C3.89,3 3,3.89 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5C21,3.89 20.1,3 19,3Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 15px; margin-top:3%;">Ficha (Área Médica)</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:3%;" href="add_ficha.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:3%;" href="fichas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M13 3C16.88 3 20 6.14 20 10C20 12.8 18.37 15.19 16 16.31V21H9V18H8C6.89 18 6 17.11 6 16V13H4.5C4.08 13 3.84 12.5 4.08 12.19L6 9.66C6.19 5.95 9.23 3 13 3M13 1C8.41 1 4.61 4.42 4.06 8.9L2.5 11L2.47 11L2.45 11.03C1.9 11.79 1.83 12.79 2.26 13.62C2.62 14.31 3.26 14.79 4 14.94V16C4 17.85 5.28 19.42 7 19.87V23H18V17.5C20.5 15.83 22 13.06 22 10C22 5.03 17.96 1 13 1M17.33 9.3L15.37 9.81L16.81 11.27C17.16 11.61 17.16 12.19 16.81 12.54S15.88 12.89 15.54 12.54L14.09 11.1L13.57 13.06C13.45 13.55 12.96 13.82 12.5 13.7C12 13.57 11.72 13.08 11.84 12.59L12.37 10.63L10.41 11.16C9.92 11.28 9.43 11 9.3 10.5C9.18 10.05 9.46 9.55 9.94 9.43L11.9 8.91L10.46 7.46C10.11 7.12 10.11 6.55 10.46 6.19C10.81 5.84 11.39 5.84 11.73 6.19L13.19 7.63L13.7 5.67C13.82 5.18 14.32 4.9 14.79 5.03C15.28 5.16 15.56 5.65 15.43 6.13L14.9 8.1L16.87 7.57C17.35 7.44 17.84 7.72 17.97 8.21C18.1 8.68 17.82 9.18 17.33 9.3Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 15px; margin-top:3%;">Ficha (Área Psicológica)</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:3%;" href="add_ficha_psic.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:3%;" href="fichas_psic.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M20,6C20.58,6 21.05,6.2 21.42,6.59C21.8,7 22,7.45 22,8V19C22,19.55 21.8,20 21.42,20.41C21.05,20.8 20.58,21 20,21H4C3.42,21 2.95,20.8 2.58,20.41C2.2,20 2,19.55 2,19V8C2,7.45 2.2,7 2.58,6.59C2.95,6.2 3.42,6 4,6H8V4C8,3.42 8.2,2.95 8.58,2.58C8.95,2.2 9.42,2 10,2H14C14.58,2 15.05,2.2 15.42,2.58C15.8,2.95 16,3.42 16,4V6H20M4,8V19H20V8H4M14,6V4H10V6H14M12,9A2.25,2.25 0 0,1 14.25,11.25C14.25,12.5 13.24,13.5 12,13.5A2.25,2.25 0 0,1 9.75,11.25C9.75,10 10.76,9 12,9M16.5,18H7.5V16.88C7.5,15.63 9.5,14.63 12,14.63C14.5,14.63 16.5,15.63 16.5,16.88V18Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 15px; margin-top:8%;">Jornadas</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:5%;" href="add_jornada.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:5%;" href="jornadas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M13 3C16.9 3 20 6.1 20 10C20 12.8 18.4 15.2 16 16.3V21H9V18H8C6.9 18 6 17.1 6 16V13H4.5C4.1 13 3.8 12.5 4.1 12.2L6 9.7C6.2 5.9 9.2 3 13 3M13 1C8.4 1 4.6 4.4 4.1 8.9L2.5 11C1.9 11.7 1.8 12.7 2.2 13.6C2.6 14.3 3.2 14.8 4 15V16C4 17.9 5.3 19.4 7 19.9V23H18V17.5C20.5 15.9 22 13.1 22 10C22 5 18 1 13 1M17 10H14V13H12V10H9V8H12V5H14V8H17V10Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 15px; margin-top:8%;">Capacitación</p>
                    <div style="margin-top:-5%;">
                        <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                            <a style="margin-top:5%;" href="add_capacitacion.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php endif; ?>
                        <a style="margin-top:5%;" href="capacitaciones.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 20px;">
        <?php if (($id_user <= 2) || ($id_user == 28) || ($id_user == 41)) : ?>
            <div class="col-md-3" style="height: 13.5rem;">
                <div class="panel panel-box clearfix">
                    <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                        <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                            <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                        </svg>
                    </div>
                    <div class="panel-value pull-right">
                        <p style="font-size: 15px; margin-top:5%; color:white; line-height: 100%;">Correspon-<br>dencia</p>
                        <div style="margin-top:-5%;">
                            <?php if (($nivel <= 2) || ($nivel == 4)) : ?>
                                <a style="margin-top:5%;" href="add_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>
                            <?php endif; ?>
                            <a style="margin-top:5%;" href="correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M17,4H7A5,5 0 0,0 2,9V20H20A2,2 0 0,0 22,18V9A5,5 0 0,0 17,4M10,18H4V9A3,3 0 0,1 7,6A3,3 0 0,1 10,9V18M19,15H17V13H13V11H19V15M9,11H5V9H9V11Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 15px; margin-top:2%; color:white; line-height: 100%;">Envío de Correspon-<br>dencia Interna</p>
                    <div style="margin-top:-5%;">

                        <a style="margin-top:5%;" href="add_env_correspondencia.php" class="btn btn-success btn-sm">Agregar</a>

                        <a style="margin-top:5%;" href="env_correspondencia.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M8,4A5,5 0 0,0 3,9V18H1V20H21A2,2 0 0,0 23,18V9A5,5 0 0,0 18,4H8M8,6A3,3 0 0,1 11,9V18H5V9A3,3 0 0,1 8,6M13,13V7H17V9H15V13H13Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 15px; margin-top:2%; color:white; line-height: 100%;">Correspon-<br>dencia Interna Recibida</p>
                    <div style="margin-top:-8%;">
                        <a style="margin-top:5%;" href="correspondencia_recibida.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M19,20H5V9H19M16,2V4H8V2H6V4H5A2,2 0 0,0 3,6V20A2,2 0 0,0 5,22H19A2,2 0 0,0 21,20V6A2,2 0 0,0 19,4H18V2M10.88,13H7.27L10.19,15.11L9.08,18.56L12,16.43L14.92,18.56L13.8,15.12L16.72,13H13.12L12,9.56L10.88,13Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 15px; margin-top:5%; color:white;">Eventos</p>
                    <div style="margin-top:-5%;">

                        <a style="margin-top:5%;" href="add_evento.php" class="btn btn-success btn-sm">Agregar</a>

                        <a style="margin-top:5%;" href="eventos.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
    <div class="row">
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 16px; margin-top:5%; color:white;">Informe Trimestral/<br>Anual</p>
                    <div style="margin-top:-10%;">
                        <?php //if ($nivel_user <= 2) : 
                        ?>
                        <a style="margin-top:5%;" href="add_informe.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php //endif; 
                        ?>
                        <a style="margin-top:5%;" href="informes.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M19,3H18V1H16V3H8V1H6V3H5A2,2 0 0,0 3,5V19A2,2 0 0,0 5,21H10V19H5V8H19V9H21V5A2,2 0 0,0 19,3M21.7,13.35L20.7,14.35L18.65,12.35L19.65,11.35C19.85,11.14 20.19,11.13 20.42,11.35L21.7,12.63C21.89,12.83 21.89,13.15 21.7,13.35M12,18.94L18.07,12.88L20.12,14.88L14.06,21H12V18.94Z" />
                    </svg>
                </div>
                <div class="panel-value pull-right">
                    <p style="font-size: 16px; margin-top:5%; color:white;">Informe de Actividades</p>
                    <div style="margin-top:-4%;">
                        <?php //if ($nivel_user <= 2) : 
                        ?>
                        <a style="margin-top:5%;" href="add_informe_areas.php" class="btn btn-success btn-sm">Agregar</a>
                        <?php //endif; 
                        ?>
                        <a style="margin-top:5%;" href="informes_areas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="white" d="M21,5C19.89,4.65 18.67,4.5 17.5,4.5C15.55,4.5 13.45,4.9 12,6C10.55,4.9 8.45,4.5 6.5,4.5C4.55,4.5 2.45,4.9 1,6V20.65C1,20.9 1.25,21.15 1.5,21.15C1.6,21.15 1.65,21.1 1.75,21.1C3.1,20.45 5.05,20 6.5,20C8.45,20 10.55,20.4 12,21.5C13.35,20.65 15.8,20 17.5,20C19.15,20 20.85,20.3 22.25,21.05C22.35,21.1 22.4,21.1 22.5,21.1C22.75,21.1 23,20.85 23,20.6V6C22.4,5.55 21.75,5.25 21,5M21,18.5C19.9,18.15 18.7,18 17.5,18C15.8,18 13.35,18.65 12,19.5V8C13.35,7.15 15.8,6.5 17.5,6.5C18.7,6.5 19.9,6.65 21,7V18.5Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 16px; margin-top:1%;">Agenda de Proyectos</p>
                    <div style="margin-top:-3%;">
                        <a style="margin-top:1%" href="add_agenda.php" class="btn btn-success btn-sm">Agregar</a>
                        <a style="margin-top:1%" href="agendas.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3" style="height: 13.5rem;">
            <div class="panel panel-box clearfix">
                <div class="panel-icon pull-left" style="background: rgb(0,95,255); background: linear-gradient(90deg, rgba(0,95,255,1) 0%, rgba(0,67,133,1) 50%, rgba(0,42,83,1) 100%); display: grid; place-content: center;">
                    <svg style="width:40px;height:73px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M16.75 22.16L14 19.16L15.16 18L16.75 19.59L20.34 16L21.5 17.41L16.75 22.16M3 7V5H5V4C5 2.89 5.9 2 7 2H13V9L15.5 7.5L18 9V2H19C20.05 2 21 2.95 21 4V13.8C20.12 13.29 19.09 13 18 13C14.69 13 12 15.69 12 19C12 20.09 12.29 21.12 12.8 22H7C5.95 22 5 21.05 5 20V19H3V17H5V13H3V11H5V7H3M5 5V7H7V5H5M5 19H7V17H5V19M5 13H7V11H5V13Z" />
                    </svg>
                </div>
                <div>
                    <p style="font-size: 14px; margin-top:5%;">Acuerdos y Resoluciones</p>
                    <div style="margin-top:-3%;">
                        <a style="margin-top:1%" href="add_acuerdo_res.php" class="btn btn-success btn-sm">Agregar</a>
                        <a style="margin-top:1%" href="acuerdos_res.php" class="btn btn-primary btn-sm">Ver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>

<?php include_once('layouts/footer.php'); ?>
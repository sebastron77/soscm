<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once('includes/load.php');
?>
<?php
$a_ss = find_by_id_ss((int)$_GET['id']);
$user = current_user();
$nivel = $user['user_level'];
$page_title = 'Ver Información - Servicio Social';

if ($nivel_user <= 3) {
    page_require_level(3);
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}
if ($nivel_user == 21) {
    redirect('home.php');
}
if ($nivel_user == 19) {
    redirect('home.php');
}
if ($nivel_user > 3 && $nivel_user < 5) :
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
<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Ver Información - Servicio Social</span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 2%;">Modalidad</th>
                            <th style="width: 5%;">Nombre Completo del Prestador</th>
                            <th style="width: 1%;">Género</th>
                            <th style="width: 1%;">Edad</th>
                            <th style="width: 1%;">Nacionalidad</th>
                            <th style="width: 4%;">Entidad</th>
                            <th style="width: 3%;">Municipio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_ss['modalidad'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['nombre_prestador'] . " " . $a_ss['paterno_prestador'] . " " . $a_ss['materno_prestador'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['genero'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['edad'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['nacionalidad'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['entidad'])) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ss['municipio']))) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 2%;">Escolaridad</th>
                            <th style="width: 1%;">Discapacidad</th>
                            <th style="width: 2%;">Tipo Discapacidad</th>
                            <th style="width: 1%;">Grupo Vuln.</th>
                            <th style="width: 3%;">Grupo Vuln. al que pertenece</th>
                            <th style="width: 1%;">Comunidad</th>
                            <th style="width: 3%">Comunidad que pertenece</th>
                        </tr>
                    </thead>
                    <tbody>
                        <td><?php echo remove_junk((($a_ss['escolaridad']))) ?></td>
                        <td><?php if ($a_ss['tiene_discapacidad'] == 0) {
                                echo 'No';
                            } else {
                                echo 'Sí';
                            } ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ss['discapacidad']))) ?></td>
                        <td><?php if ($a_ss['pertenece_gv'] == 0) {
                                echo 'No';
                            } else {
                                echo 'Sí';
                            } ?></td>
                        <td><?php echo remove_junk(ucwords(($a_ss['gv']))) ?></td>
                        <td>
                            <?php
                            if ($a_ss['pertenece_comunidad'] == 0) {
                                echo 'No';
                            } else {
                                echo 'Sí';
                            }
                            ?>
                        </td>
                        <td><?php echo remove_junk(ucwords(($a_ss['comunidad']))) ?></td>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 5%">Carrera</th>
                            <th style="width: 5%;">Institución</th>
                            <th style="width: 2%;">Fecha Inicio</th>
                            <th style="width: 2%;">Fecha Término</th>
                            <th style="width: 1%;">Hrs. Totales</th>
                            <th style="width: 5%;">Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords(($a_ss['carrera']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ss['institucion']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ss['fecha_inicio']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ss['fecha_termino']))) ?></td>
                            <td><?php echo remove_junk(ucwords(($a_ss['total_horas']))) ?></td>
                            <td><?php echo remove_junk(ucwords($a_ss['observaciones'])) ?></td>
                            <?php
                            $folio_editar = $a_ss['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <?php if ($a_ss['tipo_ficha'] == 1) : ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/fichastecnicas/medica/<?php echo $resultado . '/' . $a_ss['ficha_adjunto']; ?>"><?php echo $a_ss['ficha_adjunto']; ?></a></td>
                            <?php endif; ?>
                            <?php if ($a_ss['tipo_ficha'] == 2) : ?>
                                <td><a target="_blank" style="color: #23296B;" href="uploads/fichastecnicas/psic/<?php echo $resultado . '/' . $a_ss['ficha_adjunto']; ?>"><?php echo $a_ss['ficha_adjunto']; ?></a></td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 1%;">Carta Presentación</th>
                            <th style="width: 1%;">Oficio Aceptación</th>
                            <th style="width: 1%;">Informe Bim. 1</th>
                            <th style="width: 1%;">Informe Bim. 2</th>
                            <th style="width: 1%;">Informe Bim. 3</th>
                            <th style="width: 1%;">Informe Global</th>
                            <th style="width: 1%;">Evaluación U. Receptora</th>
                            <th style="width: 1%;">Oficio Terminación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <?php
                            $folio_editar = $a_ss['id_servicio_social'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['carta_presentacion']; ?>"><?php echo $a_ss['carta_presentacion']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['oficio_aceptacion']; ?>"><?php echo $a_ss['oficio_aceptacion']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['informe_bim1']; ?>"><?php echo $a_ss['informe_bim1']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['informe_bim2']; ?>"><?php echo $a_ss['informe_bim2']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['informe_bim3']; ?>"><?php echo $a_ss['informe_bim3']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['informe_global']; ?>"><?php echo $a_ss['informe_global']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['evaluacion_uReceptora']; ?>"><?php echo $a_ss['evaluacion_uReceptora']; ?>
                                </a>
                            </td>
                            <td>
                                <a target="_blank" style="color: #23296B;" href="uploads/servicioSocial/<?php echo $resultado . '/' . $a_ss['oficio_terminacion']; ?>"><?php echo $a_ss['oficio_terminacion']; ?>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="servicio_social.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Capacitaciones';
require_once('includes/load.php');
?>
<?php
$a_capacitacion = find_by_id('capacitaciones', (int)$_GET['id'], 'id_capacitacion');
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
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
                    <span>Información de la Capacitación <?php echo $a_capacitacion['folio'] ?></span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 3%;">Folio</th>
                            <th style="width: 10%;">Nombre de la Capacitación</th>
                            <th style="width: 3%;">Tipo de Evento</th>
                            <th style="width: 8%;">¿Quién Solicita?</th>
                            <th style="width: 3%;">Fecha</th>
                            <th style="width: 1%;">Hora</th>
                            <th style="width: 10%;">Lugar</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['folio'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['nombre_capacitacion'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['tipo_evento'])) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['quien_solicita']))) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['fecha'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['hora'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_capacitacion['lugar'])) ?></td>

                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 1%;">No. de Asistentes</th>
                            <th style="width: 1%;">Modalidad</th>
                            <th style="width: 3%;">Depto./ Org.</th>
                            <th style="width: 2%;">Capacitador</th>
                            <th style="width: 2%;">Curriculum</th>
                            <!-- <th style="width: 5%;">Constancia</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_capacitacion['no_asistentes'])) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['modalidad']))) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['depto_org']))) ?></td>
                            <td><?php echo remove_junk((ucwords($a_capacitacion['capacitador']))) ?></td>
                            <?php
                            $folio_editar = $a_capacitacion['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td>
                                <a target="_blank" style="color: #3D94FF;" href="uploads/capacitaciones/curriculums/<?php echo $resultado . '/' . $a_capacitacion['curriculum']; ?>"><?php echo $a_capacitacion['curriculum']; ?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="capacitaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Datos de Quejosos';
require_once('includes/load.php');
?>
<?php
$all_detalles = find_all_quejosos();
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;
?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<a href="solicitudes_quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
    Regresar
</a><br><br>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Quejosos</span>
                </strong>
                <?php if ($otro == 1 || $nivel_user == 1): ?>
                    <a href="add_quejoso.php" class="btn btn-info pull-right">Agregar quejoso</a>
                <?php endif ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 1%;">#</th>
                            <!--SE PUEDE AGREGAR UN LINK QUE TE LLEVE A EDITAR EL USUARIO, COMO EN EL PANEL DE CONTROL EN ULTIMAS ASIGNACIONES-->
                            <th style="width: 10%;">Nombre(s)</th>
                            <th style="width: 9%;">Apellido Paterno</th>
                            <th style="width: 9%;">Apellido Materno</th>
                            <th style="width: 5%;">Correo</th>
                            <th style="width: 5%;">Celular</th>
                            <th style="width: 15%;">Grupo Vuln.</th>
                            <!-- <th style="width: 1%;">Estatus</th> -->
                            <?php if ($otro == 1 || $nivel_user == 1): ?>
                                <th style="width: 5%;" class="text-center">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_detalles as $a_detalle): ?>
                            <tr>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['id_cat_quejoso'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['nombre'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['paterno'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['materno'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk($a_detalle['email']) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['telefono'])) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_detalle['grupo_vuln'])) ?>
                                </td>
                                <!-- <td class="text-center">
                                        <?php if ($a_detalle['estatus_detalle'] === '1'): ?>
                                                <span class="label label-success">
                                                    <?php echo "Activo"; ?>
                                                </span>
                                        <?php else: ?>
                                                <span class="label label-danger">
                                                    <?php echo "Inactivo"; ?>
                                                </span>
                                        <?php endif; ?>
                                    </td> -->
                                <?php if ($otro == 1 || $nivel_user == 1): ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_quejoso.php?id=<?php echo (int) $a_detalle['id_cat_quejoso']; ?>"
                                                class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <!-- <?php if ($nivel == 1): ?>
                                                            <?php if ($a_detalle['estatus_detalle'] == 0): ?>
                                                                    <a href="activate_detalle_usuario.php?id=<?php echo (int) $a_detalle['detalleID']; ?>"
                                                                        class="btn btn-success btn-md" title="Activar" data-toggle="tooltip">
                                                                        <span class="glyphicon glyphicon-ok"></span>
                                                                    </a>
                                                            <?php else: ?>
                                                                    <a href="inactivate_detalle_usuario.php?id=<?php echo (int) $a_detalle['detalleID']; ?>"
                                                                        class="btn btn-danger btn-md" title="Inactivar" data-toggle="tooltip">
                                                                        <span class="glyphicon glyphicon-ban-circle"></span>
                                                                    </a>
                                                            <?php endif; ?>
                                                    <?php endif; ?> -->
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
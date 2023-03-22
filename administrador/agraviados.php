<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Datos de Agraviados';
require_once('includes/load.php');
?>
<?php
$all_detalles = find_all_agraviados();
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
                    <span>Lista de Agraviados</span>
                </strong>
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
                            <th style="width: 15%;">PPL</th>
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
                                    <?php echo remove_junk(ucwords($a_detalle['id_cat_agrav'])) ?>
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
                                <td>
                                    <?php
                                    if ($a_detalle['ppl'] == 0) {
                                        echo 'No';
                                    } else {
                                        echo 'Sí';
                                    }
                                    ?>
                                </td>
                                <?php if ($otro == 1 || $nivel_user == 1): ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_agraviado.php?id=<?php echo (int) $a_detalle['id_cat_agrav']; ?>"
                                                class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_agraviado.php?id=<?php echo (int) $a_detalle['id_cat_agrav']; ?>"
                                                class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a> 
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
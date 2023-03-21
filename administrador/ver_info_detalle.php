<?php
$page_title = 'Datos trabajadores';
require_once('includes/load.php');
?>
<?php
header('Content-Type: text/html; charset=UTF-8');
page_require_level(2);
$e_detalle = find_by_id('detalles_usuario', (int) $_GET['id'], 'id_det_usuario');
$e_detalle_cargo = find_detalle_cargo((int) $_GET['id']);
$cargos = find_all('cargos');
$areas = find_all('area');
$user = current_user();
$nivel = $user['user_level'];
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
                    <span>Información completa de
                        <?php echo remove_junk(ucwords($e_detalle['nombre'])) ?>
                        <?php echo remove_junk(ucwords($e_detalle['apellidos'])) ?>
                    </span>
                </strong>
            </div>

            <div class="panel-body">

                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 12%;">ID Trabajador</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th style="width: 5%;">Sexo</th>
                            <th>CURP</th>
                            <th>RFC</th>
                            <th>Correo</th>
                            <th>Tel. casa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo remove_junk($e_detalle['id_det_usuario']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['nombre']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['apellidos']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['sexo']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['curp']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['rfc']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['correo']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['telefono_casa']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th style="width: 5%;">Celular</th>
                            <th>Calle y No.</th>
                            <th>Colonia</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th style="width: 8%;">País</th>
                            <th style="width: 20%;">Cargo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <?php echo remove_junk($e_detalle['telefono_celular']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['calle_numero']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['colonia']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['municipio']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['estado']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['pais']) ?>
                            </td>
                            <td>
                                <?php
                                foreach ($cargos as $cargo): foreach ($areas as $area):
                                        if ($cargo['id_cargos'] === $e_detalle['id_cargo'])
                                            if ($area['id_area'] === $cargo['id_area'])
                                                echo $cargo['nombre_cargo'] . " - " . $area['nombre_area'];
                                    endforeach;
                                endforeach;
                                ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-md-9">
                        <a href="detalles_usuario.php" class="btn btn-md btn-success" data-toggle="tooltip"
                            title="Regresar">
                            Regresar
                        </a>
                    </div>
                    <div class="col-md-3">
                        <a href="edit_detalle_usuario.php?id=<?php echo (int) $e_detalle['id_det_usuario']; ?>"
                            class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                            Editar
                        </a>
                        <?php if ($nivel == 1): ?>
                            <?php if ($e_detalle['estatus_detalle'] == 1): ?>
                                <a href="inactivate_detalle_usuario.php?id=<?php echo (int) $e_detalle['id_det_usuario']; ?>"
                                    class="btn btn-md btn-danger" data-toggle="tooltip" title="Inactivar">
                                    Inactivar
                                </a>
                            <?php endif; ?>
                            <?php if ($e_detalle['estatus_detalle'] == 0): ?>
                                <a href="activate_detalle_usuario.php?id=<?php echo (int) $e_detalle['id_det_usuario']; ?>"
                                    class="btn btn-md btn-success" data-toggle="tooltip" title="Activar">
                                    Activar
                                </a>
                            <?php endif; ?>
                            <!-- <a href="delete_detalle_usuario.php?id=<?php echo (int) $e_detalle['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro que deseas eliminar este trabajador? También se eliminarán su usuario, asignaciones y resguardos.');">
                                    Eliminar
                                </a> -->
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
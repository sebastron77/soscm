<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Correspondencia - Oficialia de Partes';
require_once('includes/load.php');
?>
<?php

$user = current_user();
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8) || ($nivel_user == 18)) {
    $all_correspondencia = find_all_correspondenciaAdmin();
} else {
    $all_correspondencia = find_all_correspondencia($area);
}


?>
<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Correspondencia - Oficialia de partes</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 18)) : ?>
                    <a href="add_correspondencia.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Correspondencia</a>
                <?php endif; ?>

            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th style="width: 3%;">Semáforo</th>
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 1%;">Fecha Recibido</th>
                            <th style="width: 1%;">Fecha espera respuesta</th>
                            <th style="width: 10%;">Remitente</th>
                            <th style="width: 10%;">Institución</th>
                            <th style="width: 5%;">Medio de Recepción</th>
                            <th style="width: 20%;">Área a la que se turnó</th>
                            <th style="width: 2%;" class="text-center">Acciones</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_correspondencia as $a_correspondencia) : ?>
                            <?php
                            $folio_editar = $a_correspondencia['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            date_default_timezone_set('America/Mexico_City');
                            $creacion = date('Y-m-d');
                            ?>
                            <tr>

                                <?php if ($a_correspondencia['fecha_espera_respuesta'] > $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="green">v</span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($a_correspondencia['fecha_espera_respuesta'] == $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="yellow">a</span>
                                    </td>
                                <?php endif; ?>
                                <?php if ($a_correspondencia['fecha_espera_respuesta'] < $creacion) : ?>
                                    <td class="text-center">
                                        <h1><span class="red">r</span>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_recibido'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_espera_respuesta'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['nombre_remitente'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_institucion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_recepcion']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_area']))) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_correspondencia']; ?>" title="Ver información">
                                            <img src="medios/ver_info.png" style="width: 31px; border-radius: 15%; ">
                                        </a>&nbsp;
                                        <?php if (/*($nivel_user <= 2) || ($nivel_user == 8)*/($nivel_user <= 50)) : ?>
                                            <a href="edit_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_correspondencia']; ?>" title="Editar">
                                                <img src="medios/editar2.png" style="width: 31px; border-radius: 15%;">
                                            </a>&nbsp;
                                            <a href="seguimiento_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_correspondencia']; ?>" title="Seguimiento">
                                                <img src="medios/resolucion2.png" style="width: 31px; border-radius: 15%; ">
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
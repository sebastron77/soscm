<?php
$page_title = 'Orientaciones';
require_once('includes/load.php');
?>
<?php
// page_require_level(5);
$all_orientaciones = find_all_orientaciones();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}
if ($nivel == 19) {
    page_require_level_exacto(19);
}
if ($nivel == 21) {
    page_require_level_exacto(21);
}
if ($nivel == 50) {
    page_require_level_exacto(50);
}

if ($nivel > 2 && $nivel < 5) :
    redirect('home.php');
endif;
if ($nivel > 5 && $nivel < 7) :
    redirect('home.php');
endif;
if ($nivel > 7 && $nivel < 19) :
    redirect('home.php');
endif;
if ($nivel > 19 && $nivel < 21) :
    redirect('home.php');
endif;

$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM orientacion_canalizacion WHERE tipo_solicitud=1";
$resultado = mysqli_query($conexion, $sql) or die;
$orientaciones = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $orientaciones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($orientaciones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=orientaciones.xls");
        $filename = "orientaciones.xls";
        $mostrar_columnas = false;

        foreach ($orientaciones as $resolucion) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($resolucion)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($resolucion)) . "\n";
        }
    } else {
        echo 'No hay datos a exportar';
    }
    exit;
}

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
                    <span>Lista de Orientaciones</span>
                </strong>
                <?php if (($nivel == 1) || ($nivel == 5) || ($nivel == 50)) : ?>
                    <a href="add_orientacion.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar
                        orientación</a>
                <?php endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead class="thead-purple">
                    <tr>
                        <th width="15%">Folio</th>
                        <th width="10%">Fecha creación</th>
                        <th width="10%">Medio presentación</th>
                        <th width="1%">Correo</th>
                        <th width="25%">Nombre Completo</th>
                        <th width="45%">Creador</th>
                        <?php if (($nivel <= 2) || ($nivel == 5) || ($nivel == 7) || ($nivel == 21) || ($nivel == 50)) : ?>
                            <th width="10%;" class="text-center">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_orientaciones as $a_orientacion) : ?>
                        <tr>
                            <td>
                                <?php echo remove_junk(ucwords($a_orientacion['folio'])) ?>
                            </td>
                            <?php
                            $folio_editar = $a_orientacion['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td>
                                <?php echo remove_junk(ucwords($a_orientacion['creacion'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($a_orientacion['medio_pres'])) ?>
                            </td>

                            <td>
                                <?php echo remove_junk(ucwords($a_orientacion['correo_electronico'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords(($a_orientacion['nombre_completo']))) ?>
                            </td>
                            <!-- <td><?php echo remove_junk(ucwords(($a_orientacion['ocupacion']))) ?></td> -->
                            <td>
                                <?php echo remove_junk($a_orientacion['nombre'] . " " . $a_orientacion['apellidos']) ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="ver_info_ori.php?id=<?php echo (int) $a_orientacion['idor']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                    <?php if (($nivel == 1) || ($nivel == 5) || ($nivel == 50)) : ?>
                                        <a href="edit_orientacion.php?id=<?php echo (int) $a_orientacion['idor']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($nivel == 1) : ?>
                                        <!-- <a href="delete_orientacion.php?id=<?php echo (int) $a_orientacion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
                                                <span class="glyphicon glyphicon-trash"></span>
                                            </a> -->
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
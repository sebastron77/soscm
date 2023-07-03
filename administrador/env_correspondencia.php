<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Correspondencia enviada';
require_once('includes/load.php');
?>
<?php
// page_require_level(200);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) {
    $all_correspondencia = find_all_env_correspondenciaAdmin();
} else {
    $all_correspondencia = find_all_env_correspondencia($area);
}

$conexion = mysqli_connect("localhost", "root", "");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "probar_antes_server");
if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) {
    $sql = "SELECT * FROM envio_correspondencia";
} else {
    $sql = "SELECT * FROM envio_correspondencia WHERE area_creacion='{$area}'";
}
$resultado = mysqli_query($conexion, $sql) or die;
$correspondencias = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $correspondencias[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($correspondencias)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=correspondencias.xls");

        $filename = "correspondencias.xls";
        $mostrar_columnas = false;

        foreach ($correspondencias as $correspondencia) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($correspondencia)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($correspondencia)) . "\n";
        }
    } else {
        echo 'No hay datos a exportar';
    }
    exit;
}

// page_require_level(15);

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
                    <span>Correspondencia Enviada</span>
                </strong>

                <a href="add_env_correspondencia.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Correspondencia</a>

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>

            <div class="panel-body">
                <table class="datatable table table-dark table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th style="width: 1%;">Estatus</th>
                            <th style="width: 5%;">Folio</th>
                            <th style="width: 5%;">Fecha en que se turna</th>
                            <th style="width: 3%;">Fecha espera respuesta</th>
                            <th style="width: 7%;">Asunto</th>
                            <th style="width: 5%;">Medio de Envío</th>
                            <th style="width: 5%;">Se turna</th>
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
                                            <!-- <button type="button" class="btn btn-primary" data-bs-toggle="popover" title="Popover Header" data-bs-content="Some content inside the popover">Toggle popover</button> -->
                                    </td>
                                <?php endif; ?>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_emision'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['fecha_espera_respuesta'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['asunto'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_envio']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['se_turna_a_area']))) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="seguimiento_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-secondary btn-md" title="Seguimiento" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                        </a>
                                        <!-- <a href="pdf2.php?id=<?php echo (int)$a_correspondencia['id']; ?>" class="btn btn-pdf btn-md" title="PDF" data-toggle="tooltip">
                                            <svg style="width:18px;height:18px" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M15,9H5V5H15M12,19A3,3 0 0,1 9,16A3,3 0 0,1 12,13A3,3 0 0,1 15,16A3,3 0 0,1 12,19M17,3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V7L17,3Z" />
                                            </svg>
                                        </a> -->
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
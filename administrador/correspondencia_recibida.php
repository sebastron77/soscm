<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Correspondencia recibida';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['id_area'];

if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) {
    $all_correspondencia = find_all_env_correspondenciaAdmin2();
} else {
    $all_correspondencia = find_all_env_correspondencia2($area);
}

$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");

if (($nivel_user <= 2) || ($nivel_user == 7) || ($nivel_user == 8)) {
    $sql = "SELECT * FROM envio_correspondencia";
} else {
    $sql = "SELECT * FROM envio_correspondencia WHERE se_turna_a_area='{$area}'";
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

        $filename = "correspondencia.xls";
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
                    <span>Correspondencia Interna Recibida</span>
                </strong>

                <a href="add_env_correspondencia.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Correspondencia</a>

                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 1%;">Semáforo</th>
                            <th class="text-center" style="width: 3%;">Folio</th>
                            <th class="text-center" style="width: 3%;">Fecha en que se turna</th>
                            <th class="text-center" style="width: 3%;">Fecha espera respuesta</th>
                            <th class="text-center" style="width: 7%;">Asunto</th>
                            <th class="text-center" style="width: 4%;">Medio de Envío</th>
                            <th class="text-center" style="width: 5%;">Área a la que se turna</th>
                            <th class="text-center" style="width: 1%;" class="text-center">Acciones</th>

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
                                <td class="text-center"><?php echo remove_junk(ucwords($a_correspondencia['fecha_en_que_se_turna'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_correspondencia['fecha_espera_respuesta'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_correspondencia['asunto'])) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['medio_envio']))) ?></td>
                                <td><?php echo remove_junk(ucwords(($a_correspondencia['nombre_area']))) ?></td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_env_corresp']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_env_corresp']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="seguimiento_env_correspondencia.php?id=<?php echo (int)$a_correspondencia['id_env_corresp']; ?>" class="btn btn-secondary btn-md" title="Seguimiento" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                        </a>
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
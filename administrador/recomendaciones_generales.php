<?php
$page_title = 'Recomendaciones Generales';
require_once('includes/load.php');
?>
<?php

$all_recomendaciones = find_all('recomendaciones_generales');
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
$user = current_user();
$nivel = $user['user_level'];

page_require_level(2);

$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM recomendaciones_generales";
$resultado = mysqli_query($conexion, $sql) or die;
$resoluciones = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $recomendaciones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($recomendaciones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=recomendaciones_generales.xls");
        $filename = "recomendaciones_generales.xls";
        $mostrar_columnas = false;

        foreach ($recomendaciones as $resolucion) {
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

<a href="solicitudes_presidencia.php" class="btn btn-success">Regresar a solicitudes</a>
<br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Recomendaciones Generales</span>
                </strong>
                <a href="add_recomendacion_general.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Recomendación</a>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead class="thead-purple">
                    <tr style="height: 10px;">
                        <th style="width: 10%;">Folio Recomendación</th>
                        <th style="width: 10%;">Folio Queja</th>
                        <th style="width: 7%;">Autoridad Responsable</th>
                        <th style="width: 5%;">Servidor Público</th>
                        <th style="width: 5%;">Fecha de Recomendación</th>
                        <th style="width: 2%;">Observaciones</th>
                        <th style="width: 5%;">Recomendación</th>
                        <th style="width: 5%;">Recomendación Pública</th>
                        <!-- <?php //if (($nivel <= 2)): ?> -->
                            <?php if (($nivel == 1)) : ?>
                            <th style="width: 3%;" class="text-center">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($all_recomendaciones as $a_recomendacion) : ?>
                        <tr>
                            <td><?php echo remove_junk(ucwords($a_recomendacion['folio_recomendacion_general'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_recomendacion['folio_queja'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_recomendacion['autoridad_responsable'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_recomendacion['servidor_publico'])) ?></td>
                            <td><?php echo remove_junk(ucwords($a_recomendacion['fecha_recomendacion'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($a_recomendacion['observaciones'])) ?></td>
                            <?php
                            $folio_editar = $a_recomendacion['folio_queja'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td><a target="_blank" style="color: #3D94FF;" href="uploads/recomendacionesGenerales/<?php echo $resultado . '/' . $a_recomendacion['recomendacion_adjunto']; ?>"><?php echo $a_recomendacion['recomendacion_adjunto']; ?></a></td>
                            <td><a target="_blank" style="color: #3D94FF;" href="uploads/recomendacionesGenerales/<?php echo $resultado . '/' . $a_recomendacion['recomendacion_adjunto_publico']; ?>"><?php echo $a_recomendacion['recomendacion_adjunto_publico']; ?></a></td>

                            <!-- <?php //if (($nivel <= 2)): ?> -->
                            <?php if (($nivel == 1)) : ?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="edit_recomendacion_general.php?id=<?php echo (int)$a_recomendacion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                    </div>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<?php include_once('layouts/footer.php'); ?>
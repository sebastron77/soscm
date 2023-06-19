<?php
$page_title = 'Informes de Actividades';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if (($nivel_user <= 2) || ($nivel_user == 7)) {
    $all_informe = find_all_informes_areasAdmin();
} else {
    $all_informe = find_all_informes_areas($area);
}

$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM informe_actividades_areas";
$resultado = mysqli_query ($conexion, $sql) or die;
$informe_sistemas = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $informe_sistemas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($informe_sistemas)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=informe_areas.xls");        
        $filename = "informe_areas.xls";
        $mostrar_columnas = false;

        foreach ($informe_sistemas as $resolucion) {
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
                    <span>Informes de Actividades <?php echo $area?></span>
                </strong>
                <?php //if ($nivel_user <= 2) : ?>
                    <a href="add_informe_areas.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar informe</a>
                <?php //endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style="width: 13%;">Folio</th>
                            <th style="width: 7%;">No. Informe</th>
                            <th style="width: 15%;">Oficio de Entrega</th>
                            <th style="width: 7%;">Fecha de Informe</th>
                            <th style="width: 7%;">Fecha de Entrega</th>
                            <th style="width: 15%;">Informe</th>
                            <?php //if ($nivel_user <= 2) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php //endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_informe as $a_informe) : ?>
                            <?php
                            $folio_editar = $a_informe['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_informe['folio'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_informe['no_informe'])) ?></td>
                                <td><a target="_blank" style="color: #3D94FF;" href="uploads/informesareas/<?php echo $resultado . '/' . $a_informe['oficio_entrega']; ?>"><?php echo $a_informe['oficio_entrega']; ?></a></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_informe['fecha_informe'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords(($a_informe['fecha_entrega']))) ?></td>
                                <td><a target="_blank" style="color: #3D94FF;" href="uploads/informesareas/<?php echo $resultado . '/' . $a_informe['informe_adjunto']; ?>"><?php echo $a_informe['informe_adjunto']; ?></a></td>
                                <?php //if ($nivel_user <= 2) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_informe_actividades_areas.php?id=<?php echo (int)$a_informe['id_info_act_areas']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                        </div>
                                    </td>
                                <?php //endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
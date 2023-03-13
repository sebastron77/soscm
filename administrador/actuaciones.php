<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Actuaciones';
require_once('includes/load.php');
?>
<?php

// $all_capacitaciones = find_all_capacitaciones();
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
// page_require_level(200);
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

// Identificamos a que área pertenece el usuario logueado
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];

if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7  && $nivel_user < 19) :
    redirect('home.php');
endif;

if (($nivel_user <= 2) || ($nivel_user == 7)) {
    $all_actuaciones = find_all_actuaciones();
} else {
    $all_actuaciones = find_all_actuaciones_area($area);
}

$conexion = mysqli_connect ("localhost", "root", "");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "probar_antes_server");
$sql = "SELECT * FROM actuaciones";
$resultado = mysqli_query ($conexion, $sql) or die;
$capacitaciones = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $capacitaciones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($capacitaciones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=capacitaciones.xls");        
        $filename = "capacitaciones.xls";
        $mostrar_columnas = false;

        foreach ($capacitaciones as $resolucion) {
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

<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a><br><br>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Actuaciones</span>
                </strong>
                <?php //if (($nivel <= 2) || ($nivel == 4) || ($nivel == 6) || ($nivel == 7)) : ?>
                    <a href="add_actuacion.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar actuación</a>
                <?php //endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-dark table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-info">
                            <th style="width: 10%;">Folio</th>
                            <th style="width: 10%;">Fecha de captura</th>
                            <th style="width: 5%;">Tipo de actuación</th>
                            <th style="width: 5%;">Descripción</th>
                            <th style="width: 2%;">Autoridades</th>
                            <th style="width: 5%;">Petición</th>
                            <th style="width: 5%;">Num. Exp. Origen</th>
                            <th style="width: 5%;">Adjunto</th>
                            <!-- <th style="width: 3%;">Constancia</th> -->
                            
                            <th style="width: 3%;" class="text-center">Acciones</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_actuaciones as $a_actuacion) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_actuacion['folio_actuacion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_actuacion['fecha_captura_acta'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_actuacion['catalogo'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_actuacion['descripcion'])) ?></td>
                                <?php if($a_actuacion['autoridades'] == ''):?>
                                    <td><?php echo remove_junk(ucwords($a_actuacion['nombre_autoridad'])) ?></td>
                                <?php else:?>
                                    <td><?php echo remove_junk(ucwords($a_actuacion['nombre_autoridad'])) ?></td>
                                <?php endif?>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_actuacion['peticion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_actuacion['num_exp_origen'])) ?></td>
                                <?php
                                $folio_editar = $a_actuacion['folio_actuacion'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #0094FF;" href="uploads/actuaciones/<?php echo $resultado . '/' . $a_actuacion['adjunto']; ?>"><?php echo $a_actuacion['adjunto']; ?></a></td>
                                
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_actuacion.php?id=<?php echo (int)$a_actuacion['id']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                                <span class="glyphicon glyphicon-edit"></span>
                                            </a>
                                            <?php if ($nivel == 1) : ?>
                                                <!-- <a href="delete_orientacion.php?id=<?php echo (int)$a_actuacion['id']; ?>" class="btn btn-delete btn-md" title="Eliminar" data-toggle="tooltip" onclick="return confirm('¿Seguro(a) que deseas eliminar esta orientación?');">
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
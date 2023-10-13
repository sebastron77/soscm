<?php
$page_title = 'Sesiones COTRAPEM';
require_once('includes/load.php');
?>
<?php

$all_fichas = find_all('cotrapem');
$user = current_user();
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 3) {
    page_require_level(3);
}
if ($nivel_user == 4) {
    redirect('home.php');
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 6) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}

$conexion = mysqli_connect ("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "suigcedh");
$sql = "SELECT * FROM cotrapem";
$resultado = mysqli_query ($conexion, $sql) or die;
$jornadas = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $jornadas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($jornadas)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=jornadas.xls");        
        $filename = "cotrapem.xls";
        $mostrar_columnas = false;

        foreach ($jornadas as $resolucion) {
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

<a href="solicitudes_ejecutiva.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Sesiones COTRAPEM</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                    <a href="add_sesionCotrapem.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Sesión</a>
                <?php endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data' value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th class="text-center" style="width: 2.5%;">Folio</th>
                            <th class="text-center" style="width: 3.5%;">Fecha de Sesión</th>
                            <th class="text-center" style="width: 10%;">Lugar de Sesión</th>
                            <th class="text-center" style="width: 15%;">Acuerdos</th>
                            <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                <th style="width: 0.2%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_fichas as $a_ficha) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_ficha['fecha'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['lugar'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_ficha['acuerdos'])) ?></td>
                                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_imagenesCotrapem.php?carpeta=<?php echo $a_ficha['carpeta']; ?>" class="btn btn-md btn-secondary" data-toggle="tooltip" title="Ver evidencia fotográfica">
                                                <i class="glyphicon glyphicon-picture"></i>
                                            </a>
                                            <a href="edit_sesionCotrapem.php?id=<?php echo (int)$a_ficha['id_sesion']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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
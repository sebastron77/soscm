<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Sintesis Diaria';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$nivel_user = $user['user_level'];
$sesiones = find_all('sintesis_diaria');

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 15) {
    page_require_level_exacto(15);
}
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7  && $nivel_user < 15) :
    redirect('home.php');
endif;
if ($nivel_user > 15) :
    redirect('home.php');
endif;

$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM sintesis_diaria";
$resultado = mysqli_query($conexion, $sql) or die;
$sintesis = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $sintesis[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($sintesis)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=sintesis.xls");
        $filename = "sintesis.xls";
        $mostrar_columnas = false;

        foreach ($sintesis as $sint) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($sint)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($sint)) . "\n";
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
                    <span>Síntesis Diaria</span>
                </strong>
                <?php if (($nivel == 1) || ($nivel == 15)) : ?>
                    <a href="add_sintesis_diaria.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Síntesis Diaria</a>
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
                        <th class="text-center" width="2%">Folio</th>
                        <th class="text-center" width="2%">Fecha</th>
                        <th class="text-center" width="2%">Tiempo de Sesión</th>
                        <th class="text-center" width="10%">Link</th>
                        <th class="text-center" width="1%">Aciones</th>
                    </tr>
                </thead>

                <tbody>
                <?php foreach ($sesiones as $sesion) : ?>
                    <tr>
                        <td class="text-center"><?php echo remove_junk(ucwords($sesion['folio'])) ?></td>
                        <td class="text-center"><?php echo remove_junk(ucwords($sesion['fecha'])) ?></td>
                        <td class="text-center"><?php echo remove_junk(ucwords($sesion['tipo'])) ?></td>
                        <td class="text-center"><?php echo remove_junk(ucwords($sesion['link'])) ?></td>

                        <td class="text-center">
                            <a href="edit_sintesis_diaria.php?id=<?php echo (int)$sesion['id_sintesis_diaria']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- </div> -->
<?php include_once('layouts/footer.php'); ?>
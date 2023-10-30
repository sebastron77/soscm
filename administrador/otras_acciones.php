<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Otras Acciones';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$nivel_user = $user['user_level'];
$all_difusion = find_all_otras_acciones();

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
$sql = "SELECT oa.id_otra_accion, oa.folio, oa.fecha, oa.accion, oa.tema, oa.area_solicita, oa.archivo, coa.descripcion as otra_ac, a.nombre_area
        FROM otras_acciones oa
        LEFT JOIN cat_otras_acciones coa ON coa.id_cat_otra_accion = oa.accion
        LEFT JOIN area a ON a.id_area = oa.area_solicita";
$resultado = mysqli_query($conexion, $sql) or die;
$difusiones = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $difusiones[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($difusiones)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=otras_acciones.xls");
        $filename = "otras_acciones.xls";
        $mostrar_columnas = false;

        foreach ($difusiones as $difusion) {
            if (!$mostrar_columnas) {
                echo implode("\t", array_keys($difusion)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($difusion)) . "\n";
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
                    <span>Otras Acciones</span>
                </strong>
                <?php if (($nivel == 1) || ($nivel == 15)) : ?>
                    <a href="add_otra_accion.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Otra Acción</a>
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
                        <th class="text-center" width="2%">Acción</th>
                        <th class="text-center" width="10%">Tema</th>
                        <th class="text-center" width="10%">Área Solicita</th>
                        <th class="text-center" width="10%">Archivo</th>
                        <th class="text-center" width="1%">Aciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($all_difusion as $datos) :
                        $nombre_area = find_campo_id('area', $datos['id_area_solicitud'], 'id_area', 'nombre_area');
                    ?>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($datos['folio'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($datos['fecha'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($datos['otra_ac'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($datos['tema'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($datos['nombre_area'])) ?></td>
                            <?php
                            $folio_editar = $datos['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            $carpeta = 'uploads/otras_acciones/' . $resultado;
                            ?>
                            <td class="text-center"><a target="_blank" style="color:#3D94FF" href="<?php echo $carpeta . '/' . $datos['archivo']; ?>"><?php echo $datos['archivo']; ?></a></td>

                            <td class="text-center">
                                <a href="edit_otra_accion.php?id=<?php echo (int)$datos['id_otra_accion']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
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
<?php
$page_title = 'Fichas Técnicas - Área Psicológica';
require_once('includes/load.php');
?>
<?php
// page_require_level(4);
$all_fichas = find_all_fichas2();
$user = current_user();
$nivel = $user['user_level'];
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 4) {
    page_require_level_exacto(4);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 4) :
    redirect('home.php');
endif;
if ($nivel_user > 4 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;


if (($nivel_user == 1) || ($nivel_user == 2) || ($nivel_user == 22) || ($nivel_user == 7)) {
    $all_fichas = find_all_fichas2();
} else {
    $all_fichas = find_all_fichasUser2($id_user);
}

$conexion = mysqli_connect ("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion,"utf8");
mysqli_select_db ($conexion, "suigcedh");
$sql = "SELECT * FROM fichas WHERE tipo_ficha=2";
$resultado = mysqli_query ($conexion, $sql) or die;
$fichas = array();
while( $rows = mysqli_fetch_assoc($resultado) ) {
    $fichas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($fichas)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=fichas.xls");        
        $filename = "fichas.xls";
        $mostrar_columnas = false;

        foreach ($fichas as $resolucion) {
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

<a href="solicitudes_servicios_tecnicos.php" class="btn btn-success">Regresar</a><br><br>

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
                    <span>Fichas técnicas - Área Psicológica</span>
                </strong>
                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                    <a href="add_ficha_psic.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar ficha</a>
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
                            <th style="width: 2%;">Folio</th>
                            <th style="width: 1%;">Función</th>
                            <th style="width: 1%;">No. Queja</th>
                            <th style="width: 1%;">Visitaduría</th>
                            <th style="width: 3%;">Área Solicitante</th>
                            <th style="width: 3%;">Autoridad Responsable</th>
                            <th style="width: 3%;">Adjunto</th>
                            <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_fichas as $a_ficha) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_ficha['folio'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['funcion'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['num_queja'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['visitaduria'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['area_solicitante'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_ficha['autoridad'])) ?></td>
                                <?php
                                $folio_editar = $a_ficha['folio'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td><a target="_blank" style="color: #3D94FF;" href="uploads/fichastecnicas/psic/<?php echo $resultado . '/' . $a_ficha['ficha_adjunto']; ?>"><?php echo $a_ficha['ficha_adjunto']; ?></a></td>
                                <?php if (($nivel_user <= 2) || ($nivel_user == 4)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_ficha.php?id=<?php echo (int)$a_ficha['id_ficha']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_ficha_psic.php?id=<?php echo (int)$a_ficha['id_ficha']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
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
<?php

use Dompdf\Css\Style;

error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas por ratificar';

require_once('includes/load.php');

$quejas_libro = find_all_quejasR();

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 19) {
    page_require_level_exacto(19);
}

if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 19) :
    redirect('home.php');
endif;
if ($nivel_user > 19) :
    redirect('home.php');
endif;

$conexion = mysqli_connect("localhost", "root", "");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "libroquejas2");
$sql = "SELECT q.id_queja_date_p, q.folio_queja_p, q.fecha_creacion, q.nombre, q.paterno, q.materno, cg.descripcion as genero, q.edad, ce.descripcion as escolaridad, 
co.descripcion as ocupacion, cgv.descripcion as grupo_vuln, cn.descripcion as nacionalidad, au.nombre_autoridad, q.correo, q.telefono, q.calle_queja, q.numero_queja, q.colonia_queja,
q.descripcion_hechos, q.entidad, cm.descripcion as municipio, q.localidad, q.archivo
FROM quejas_dates_public q 
-- LEFT JOIN cat_medio_pres mp ON mp.id_cat_med_pres = q.id_cat_med_pres
LEFT JOIN cat_autoridades au ON au.id_cat_aut = q.autoridad_responsable
INNER JOIN cat_genero cg ON cg.id_cat_gen = q.genero
INNER JOIN cat_nacionalidades cn ON cn.id_cat_nacionalidad = q.cat_nacionalidad
INNER JOIN cat_municipios cm ON cm.id_cat_mun = q.municipio
INNER JOIN cat_escolaridad ce ON ce.id_cat_escolaridad = q.cat_escolaridad
INNER JOIN cat_ocupaciones co ON co.id_cat_ocup = q.cat_ocupacion
INNER JOIN cat_grupos_vuln cgv ON cgv.id_cat_grupo_vuln = q.grupo_vulnerable";
$resultado = mysqli_query($conexion, $sql) or die;
$quejas = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $quejas[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($quejas)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=quejasR.xls");
        $filename = "quejasR.xls";
        $mostrar_columnas = false;

        foreach ($quejas as $resolucion) {
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
<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a><br><br>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<?php
require_once('includes/sql.php');

?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    <span>Lista de Quejas por Ratificar</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                    <a href="add_queja.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Queja</a>
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
                        <th width="10%">Folio</th>
                        <th width="3%">Fecha creación</th>
                        <th width="15%">Autoridad responsable</th>
                        <th width="15%">Quejoso</th>
                        <th width="10%">Grupo Vulnerable</th>
                        <th width="5%">Adjunto</th>
                        <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                            <th width="1%;" class="text-center">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quejas_libro as $queja) : ?>
                        <tr>
                            <td>
                                <?php echo remove_junk(ucwords($queja['folio_queja_p'])) ?>
                            </td>
                            <?php
                            $folio_editar = $queja['folio_queja_p'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td>
                                <?php echo remove_junk(ucwords($queja['fecha_creacion'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['nombre_autoridad'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['nombre'] . " " . $queja['paterno'] . " " . $queja['materno'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['grupo_vuln'])) ?>
                            </td>
                            <td><a target="_blank" style="color: #0094FF;" href="uploads/quejas_publicas/<?php echo $resultado . '/' . $queja['archivo']; ?>"><?php echo $queja['archivo']; ?></a></td>
                            <?php if (($nivel <= 2) || ($nivel == 5)) : ?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_quejaR.php?id=<?php echo (int) $queja['id_queja_date_p']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="add_quejaR.php?id=<?php echo (int) $queja['id_queja_date_p']; ?>" class="btn btn-md" title="Ir a agregar queja" data-toggle="tooltip" style="background: #F71E60">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="#FFFFFF" viewBox="0 0 24 24" width="20px" height="20px">
                                                <title>file-document-plus-outline</title>
                                                <path d="M23 18H20V15H18V18H15V20H18V23H20V20H23M6 2C4.89 2 4 2.9 4 4V20C4 21.11 4.89 22 6 22H13.81C13.45 21.38 13.2 20.7 13.08 20H6V4H13V9H18V13.08C18.33 13.03 18.67 13 19 13C19.34 13 19.67 13.03 20 13.08V8L14 2M8 12V14H16V12M8 16V18H13V16Z" />
                                            </svg>
                                        </a>
                                        <!-- <a href="edit_queja.php?id=<?php echo (int) $queja['id_queja_date_p']; ?>"
                                            class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a> -->
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
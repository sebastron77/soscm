<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Entregables';
require_once('includes/load.php');
?>
<?php

$all_engtregables = find_all_entregables();

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 17) {
    page_require_level_exacto(17);
}
if ($nivel_user > 3 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 17) :
    redirect('home.php');
endif;

if ($nivel_user > 17 && $nivel_user < 21) :
    redirect('home.php');
endif;


$conexion = mysqli_connect("localhost", "suigcedh", "9DvkVuZ915H!");
mysqli_set_charset($conexion, "utf8");
mysqli_select_db($conexion, "suigcedh");
$sql = "SELECT * FROM consejo";
$resultado = mysqli_query($conexion, $sql) or die;
$consejo = array();
while ($rows = mysqli_fetch_assoc($resultado)) {
    $consejo[] = $rows;
}

mysqli_close($conexion);

if (isset($_POST["export_data"])) {
    if (!empty($consejo)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=consejo.xls");
        $filename = "consejo.xls";
        $mostrar_columnas = false;

        foreach ($consejo as $resolucion) {
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
                    <span>Entregables</span>
                </strong>
				<?php if (($nivel_user <= 2) || ($nivel_user == 17) ) : ?>
                <a href="add_agenda_entregable.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Entregable</a>
				<?php endif; ?>
                
            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead class="thead-purple">
                    <tr style="height: 10px;">
                        <th class="text-center" >Folio</th>
                        <th class="text-center" >Tipo Entregable</th>
                        <th class="text-center" style="width: 20%;">Nombre Entragable</th>
                        <th class="text-center" >Eje Estratégico</th>
                        <th class="text-center" >Agenda</th>
                        <th class="text-center" >Accedo a Documento</th>
                        <th class="text-center" >ISBN</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                   <?php foreach ($all_engtregables as $engtregables) : ?>                     
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($engtregables['folio'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($engtregables['tipo_estregable'])) ?></td>
                            <td ><?php echo remove_junk(ucwords($engtregables['descripcion'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($engtregables['nombre_eje']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($engtregables['nombre_agenda']))) ?></td>
                            <td >
								<a target="_blank" style="color: #0094FF;" href="<?php echo $engtregables['liga_acceso']; ?>">
									<?php echo remove_junk(ucwords(($engtregables['liga_acceso']))) ?>
								</a>
							</td>                          
                            <td class="text-center"><?php echo remove_junk(ucwords(($engtregables['no_isbn']))) ?></td>                                                      
                            <td class="text-center">
                                <div class="btn-group">
								<a href="ver_info_entregable.php?id=<?php echo (int)$engtregables['id_entregables']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información completa">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>&nbsp;
										<?php if (($nivel_user <= 2) || ($nivel_user == 17) ) : ?>
                                    <a href="edit_agenda_entregable.php?id=<?php echo (int)$engtregables['id_entregables']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                        <span class="glyphicon glyphicon-edit"></span>
                                    </a>
									<?php endif ?>
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
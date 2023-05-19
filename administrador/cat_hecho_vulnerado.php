<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de Hechos Vulnerados';
require_once('includes/load.php');

// page_require_level(2);
$all_catalogo = find_all_order('cat_hecho_vuln', 'descripcion');
$user = current_user();
$nivel = $user['user_level'];

$user = current_user();
$id_user = $user['id_user'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
    redirect('home.php');
endif;




$datos_catalogo = find_catalogo('cat_hecho_vuln');



if (isset($_POST["export_data"])) {
    if (!empty($datos_catalogo)) {
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.ms-excel;charset=UTF-8');
        header("Content-Disposition: attachment; filename=cat_munidades_indigenas.xls");        
        $filename = "cat_munidades_indigenas.xls";
        $mostrar_columnas = false;
$arr = array('Hello','World!','Beautiful','Day!');

        foreach ($datos_catalogo as $resolucion) {
			echo implode("\t",$arr)."\n";
//			echo implode(" ",$resolucion);
/*		   if (!$mostrar_columnas) {
                echo implode("\t", array_keys($resolucion)) . "\n";
                $mostrar_columnas = true;
            }
            echo implode("\t", array_values($resolucion)) . "\n";
			*/
        }
		
    } else {
        echo 'No hay datos a exportar';
    }
    exit;
}

?>

?>
<?php header('Content-Type: text/html; charset=utf-8');
	include_once('layouts/header.php'); ?>

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
                    <span>Catálogo de Hechos Vulnerados<span>
                </strong>
                <?php if ($otro == 1 || $nivel == 1) : ?>
                    <a href="add_hechoVul.php" class="btn btn-info pull-right btn-md"> Agregar Hecho Vulnerado</a>
                <?php endif ?>
				
            </div>
            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 40%;">Nombre del Hecho Vulnerado</th>
                            <th class="text-center" style="width: 20%;">Estatus</th>
                            <?php if ($otro == 1 || $nivel == 1) : ?>
                                <th class="text-center" style="width: 15%;">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_catalogo as $a_catalogo) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_catalogo['descripcion'])) ?></td>
                                <td class="text-center">
                                    <?php if ($a_catalogo['estatus'] === '1') : ?>
                                        <span class="label label-success"><?php echo "Activa"; ?></span>
                                    <?php else : ?>
                                        <span class="label label-danger"><?php echo "Inactiva"; ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if ($otro == 1 || $nivel == 1) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <?php if ($otro == 1 || $nivel == 1) : ?>
                                                <a href="edit_hechoVul.php?id=<?php echo (int)$a_catalogo['id_cat_hecho_vuln']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                                    <i class="glyphicon glyphicon-pencil"></i>
                                                </a>
                                            <?php endif ?>
                                            <?php if (($nivel == 1) && ($a_catalogo['id_cat_hecho_vuln'] != 1)) : ?>

                                                <?php if ($a_catalogo['estatus'] == 0) : ?>
                                                    <a href="activate_hechoVul.php?id=<?php echo (int)$a_catalogo['id_cat_hecho_vuln']; ?>&a=0" class="btn btn-success btn-md" title="Activar" data-toggle="tooltip" onclick="return confirm('¿Seguro que deseas activar el Hecho Vulnerado? ');">
                                                        <span class="glyphicon glyphicon-ok"></span>
                                                    </a>
                                                <?php else : ?>
                                                    <a href="activate_hechoVul.php?id=<?php echo (int)$a_catalogo['id_cat_hecho_vuln']; ?>&a=1" class="btn btn-md btn-danger" data-toggle="tooltip" title="Inactivar" onclick="return confirm('¿Seguro que deseas desctivar el Hecho Vulnerado? ');">
                                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                                    </a>
                                                <?php endif; ?>                                               
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                <?php endif ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Visitas Web';
require_once('includes/load.php');

$all_vistas = find_all('visitas_web');
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id_user'];
$id_user = $user['id_user'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];


if ($nivel_user == 13) {
    page_require_level_exacto(13);
}
if ($nivel_user > 2 && $nivel_user < 13) :
    redirect('home.php');
endif;
if ($nivel_user > 13) :
    redirect('home.php');
endif;

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
                    <span>Visitas Web</span>
                </strong>
                <?php if ($otro == 1 || $id_user == 13) : ?>
                    <a href="add_visita_web.php" class="btn btn-info pull-right btn-md">Agregar visita</a>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead>
                        <tr class="thead-purple">
                            <th class="text-center" style="width: 1%;">Ejercicio</th>
                            <th class="text-center" style="width: 1%;">Mes</th>
                            <th class="text-center" style="width: 1%;">Desktop</th>
                            <th class="text-center" style="width: 1%;">Móvil</th>
                            <th class="text-center" style="width: 1%;">Tablet</th>
                            <th class="text-center" style="width: 1%;">Vistas Página</th>
                            <th class="text-center" style="width: 1%;">Total Vistas</th>
                            <?php if ($otro == 1 || $id_user == 13) : ?>
                                <th class="text-center" style="width: 1%;">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_vistas as $a_vistas) : ?>
                            <tr>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['ejercicio'])) ?></td>
                                <?php if($a_vistas['mes'] == 1):?><td class="text-center">Enero</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 2):?><td class="text-center">Febrero</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 3):?><td class="text-center">Marzo</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 4):?><td class="text-center">Abril</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 5):?><td class="text-center">Mayo</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 6):?><td class="text-center">Junio</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 7):?><td class="text-center">Julio</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 8):?><td class="text-center">Agosto</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 9):?><td class="text-center">Septiembre</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 10):?><td class="text-center">Octubre</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 11):?><td class="text-center">Noviembre</td><?php endif;?>
                                <?php if($a_vistas['mes'] == 12):?><td class="text-center">Diciembre</td><?php endif;?>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['desktop'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['movil'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['tablet'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['vistas_a_pag'])) ?></td>
                                <td class="text-center"><?php echo remove_junk(ucwords($a_vistas['total_vistas'])) ?></td>
                                <?php if ($otro == 1 || $id_user == 13) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_visita_web.php?id=<?php echo (int)$a_vistas['id_visitas']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
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
<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de autoridades';
require_once('includes/load.php');

$all_autoridades = find_all_autoridades();
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id_user'];
$id_user = $user['id_user'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];

if ($nivel_user > 2 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7):
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
                    <span>Catálogo de Autoridades</span>
                </strong>
                <?php if ($otro == 1) : ?>
                    <a href="add_autoridad.php" class="btn btn-info pull-right btn-md"> Agregar autoridad</a>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <table class="datatable table table-dark table-bordered table-striped">
                    <thead>
                        <tr class="table-info">
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 50%;">Nombre de la autoridad</th>
                            <th class="text-center" style="width: 30%;">Tipo de autoridad</th>
                            <?php if ($otro == 1) : ?>
                                <th class="text-center" style="width: 10%;">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_autoridades as $a_autoridad) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_autoridad['nombre_autoridad'])) ?></td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_autoridad['tipo'])) ?>
                                </td>
                                <?php if ($otro == 1) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_autoridad.php?id=<?php echo (int)$a_autoridad['id_cat_aut']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
                                                <i class="glyphicon glyphicon-pencil"></i>
                                            </a>
                                            <?php if (($nivel == 1)) : ?>
                                                <a href="delete_autoridad.php?id=<?php echo (int)$a_autoridad['id_cat_aut']; ?>" class="btn btn-md btn-delete" data-toggle="tooltip" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar esta autoridad?'">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </a>
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
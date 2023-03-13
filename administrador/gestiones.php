<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de gestiones jurisdiccionales';
require_once('includes/load.php');

// page_require_level(2);
$all_autoridades = find_all('gestiones_jurisdiccionales');
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id'];
$id_user = $user['id'];
$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel_user = $user['user_level'];
//@$level = find_user_level('users', (int)$_GET['id']);

if ($nivel_user <= 2) :
    page_require_level(2);
endif;
if ($nivel_user == 7) :
    page_require_level_exacto(7);
endif;
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
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
                    <span>Gestiones Jurisdiccionales</span>
                </strong>
                <?php if ($otro <= 2) : ?>
                    <a href="add_gestion.php" class="btn btn-info pull-right btn-md"> Agregar gestión</a>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <table class="datatable table table-dark table-bordered table-striped">
                    <thead>
                        <tr class="table-info">
                            <th class="text-center" style="width: 5%;">#</th>
                            <th style="width: 20%;">Tipo Gestión</th>
                            <th class="text-center" style="width: 30%;">Descripción</th>
                            <th class="text-center" style="width: 15%;">Archivo</th>
                            <th class="text-center" style="width: 30%;">Observaciones</th>
                            <?php if ($otro <= 2) : ?>
                                <th class="text-center" style="width: 10%;">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_autoridades as $a_autoridad) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_autoridad['tipo_gestion'])) ?></td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_autoridad['descripcion'])) ?>
                                </td>
                                <?php
                                    $folio_editar = $a_autoridad['id'];
                                ?>
                                <td class="text-center">
                                    <a target="_blank" style="color: #0094FF;" href="uploads/gestiones/<?php echo $folio_editar . '/' . $a_autoridad['documento']; ?>"><?php echo $a_autoridad['documento']; ?></a>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_autoridad['observaciones'])) ?>
                                </td>
                                <?php if ($otro <= 2) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_gestion.php?id=<?php echo (int)$a_autoridad['id']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
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
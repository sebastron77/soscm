<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Servicio Social';
require_once('includes/load.php');

// page_require_level(2);
$all_gestiones = find_all_ss();
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id_user'];
$busca_area = area_usuario($id_usuario);
$nivel_user = $user['user_level'];

if ($nivel_user <= 3) {
    page_require_level(3);
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}
if ($nivel_user == 21) {
    redirect('home.php');
}
if ($nivel_user == 19) {
    redirect('home.php');
}
if ($nivel_user > 3 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
if ($nivel_user > 19 && $nivel_user < 21) :
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
                    <span>Servicio Social</span>
                </strong>
                <?php if (($nivel_user <= 2)) : ?>
                    <a href="add_servicio_social.php" class="btn btn-info pull-right btn-md"> Agregar Servicio Social</a>
                <?php endif ?>
            </div>
            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th class="text-center" style="width: 1%;">#</th>
                            <th style="width: 25%;">Nombre Prestador</th>
                            <th class="text-center" style="width: 32%;">Carrera</th>
                            <th class="text-center" style="width: 32%;">Institución</th>
                            <th class="text-center" style="width: 35%;">Fecha Inicio</th>
                            <th class="text-center" style="width: 35%;">Fecha Término</th>
                            <?php if (($nivel_user <= 3)) : ?>
                                <th class="text-center" style="width: 1%;">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_gestiones as $a_gestion) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td>
                                    <?php echo remove_junk(ucwords($a_gestion['nombre_prestador'] . " " . $a_gestion['paterno_prestador'] . " " . $a_gestion['materno_prestador'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_gestion['carrera'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_gestion['institucion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_gestion['fecha_inicio'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($a_gestion['fecha_termino'])) ?>
                                </td>
                                <?php if (($nivel_user <= 2)) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_servicio_social.php?id=<?php echo (int)$a_gestion['id_servicio_social']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información completa">
                                                <i class="glyphicon glyphicon-eye-open"></i>
                                            </a>
                                            <a href="edit_servicio_social.php?id=<?php echo (int)$a_gestion['id_servicio_social']; ?>" class="btn btn-md btn-warning" data-toggle="tooltip" title="Editar">
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
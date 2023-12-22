<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Datos OSC';
require_once('includes/load.php');
?>
<?php
$all_osc = find_all('osc');
$user = current_user();
$nivel = $user['user_level'];

$id_usuario = $user['id'];
$id_user = $user['id'];

$nivel_user = $user['user_level'];

page_require_level(1);
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
                    <span>Lista de OSC</span>
                </strong>
                <?php if ($otro == 1 || $nivel_user == 1) : ?>
                    <a href="add_osc.php" class="btn btn-info pull-right">Agregar OSC</a>
                <?php endif ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;"">
                            <th style="width: 20%;">Nombre OSC</th>
                            <th style="width: 20%;">Web Oficial</th>
                            <th style="width: 20%;">Correo Oficial</th>
                            <th style="width: 4%;">Teléfono</th>
                            <th style="width: 20%;">Responsable</th>
                            <?php if ($otro == 1 || $nivel_user == 1) : ?>
                                <th style="width: 1%;" class="text-center">Acciones</th>
                            <?php endif ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_osc as $a_osc) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_osc['nombre'])) ?></td>
                                <td><a href="<?php echo remove_junk($a_osc['web_oficial']) ?>"target="_blank"><?php echo remove_junk($a_osc['web_oficial']) ?></a></td>
                                <td><?php echo remove_junk($a_osc['correo_oficial'])?></td>
                                <td><?php echo remove_junk(ucwords($a_osc['telefono'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_osc['nombre_responsable'])) ?></td>
                                <?php if ($otro == 1 || $nivel_user == 1) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="ver_info_osc.php?id=<?php echo (int)$a_osc['id_osc']; ?>" class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información" style="height: 40px">
                                                <span class="material-symbols-rounded" style="font-size: 20px; color: white; margin-top: 5px;">visibility</span>
                                            </a>
                                            <a href="edit_osc.php?id=<?php echo (int)$a_osc['id_osc']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip" style="height: 40px">
                                                <span class="material-symbols-rounded" style="font-size: 20px; color: black; margin-top: 5px;">edit</span>
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
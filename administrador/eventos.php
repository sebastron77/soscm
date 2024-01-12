<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Eventos';
require_once('includes/load.php');
?>
<?php

$user = current_user();

$id_usuario = $user['id'];
$id_user = $user['id'];
$id_osc = $user['osc'];
$nivel_user = $user['user_level'];

if ($nivel_user == 1) {
    $all_eventos = find_all_eventos();
} elseif ($nivel_user == 2) {
    $all_eventos = find_all_eventos_osc($id_osc);
}

page_require_level(2);
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
                    <span>Lista de Eventos</span>
                </strong>
                <?php if ($nivel_user <= 2) : ?>
                    <a href="add_evento.php" class="btn btn-info pull-right">Agregar Evento</a>
                <?php endif ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;">
                            <th style=" width: 1%;">#</th>
                            <th style=" width: 30%;">Nombre OSC</th>
                            <th style="width: 10%;">Fecha</th>
                            <th style="width: 2%;">Hora</th>
                            <th style="width: 30%;">Lugar</th>
                            <th style="width: 30%;">Tema</th>
                            <th style="width: 1%;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_eventos as $a_evento) : ?>
                            <tr>
                                <td class="text-center"><?php echo count_id(); ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['nombre'])) ?></td>
                                <td><?php echo $a_evento['fecha'] ?></td>
                                <td><?php echo substr($a_evento['hora'], 0, -3) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['lugar'])) ?></td>
                                <td><?php echo remove_junk(ucwords($a_evento['tema'])) ?></td>
                                <?php if ($nivel_user <= 2) : ?>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="edit_evento.php?id=<?php echo (int)$a_evento['id_evento']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip" style="height: 40px">
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
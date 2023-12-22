<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Noticias';
require_once('includes/load.php');
?>
<?php
$all_noticias = find_all_noticias();
$user = current_user();

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
                    <span>Lista de Noticias</span>
                </strong>
                <?php if ($otro == 1 || $nivel_user == 1) : ?>
                    <a href="add_noticia.php" class="btn btn-info pull-right">Agregar Noticia</a>
                <?php endif ?>
            </div>

            <div class="panel-body">
                <table class="datatable table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr style="height: 10px;"">
                            <th style=" width: 30%;">Nombre OSC</th>
                            <th style="width: 7%;">Fecha</th>
                            <th style="width: 25%;">Titulo de Noticia</th>
                            <th style="width: 30%;">Prev. Noticia</th>
                            <th style="width: 1%;" class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($all_noticias as $a_noticia) : ?>
                            <tr>
                                <td><?php echo remove_junk(ucwords($a_noticia['nombre'])) ?></td>
                                <td><?php echo remove_junk($a_noticia['fecha']) ?></td>
                                <td><?php echo remove_junk(ucwords($a_noticia['titulo_noticia'])) ?></td>
                                <td><?php $txt = substr($a_noticia['noticia'], 0, 200); echo $txt . '...'; ?></td>
                                <td class="text-center"><a href="<?php echo 'uploads/noticias/' . $a_noticia['titulo_noticia'] . '/' . $a_noticia['imagen']; ?>" class="btn btn-warning btn-md" title="Ver Imágen" data-toggle="tooltip" style="height: 40px; background: #1573ac; border-color: #1573ac;" target="_blank">
                                        <span class="material-symbols-outlined" style="font-size: 22px; color: white; margin-top: 4px;">
                                            image
                                        </span>
                                    </a>
                                    <?php if ($otro == 1 || $nivel_user == 1) : ?>
                                        <div class="btn-group">
                                            <a href="edit_noticia.php?id=<?php echo (int)$a_noticia['id_noticia']; ?>" class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip" style="height: 40px">
                                                <span class="material-symbols-rounded" style="font-size: 20px; color: black; margin-top: 5px;">edit</span>
                                            </a>
                                        </div>
                                    <?php endif ?>
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
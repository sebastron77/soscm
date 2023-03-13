<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Lista de quejas';

require_once('includes/load.php');

// page_require_level(1);
// page_require_level(5);
$quejas_libro = find_all_quejas();

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

if ($nivel_user > 2 && $nivel_user < 5):
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7):
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 19):
    redirect('home.php');
endif;

?>
<?php include_once('layouts/header.php'); ?>
<a href="solicitudes_quejas.php" class="btn btn-success">Regresar</a>
<a href="add_queja.php" class="btn btn-primary">Agregar Queja</a><br><br>
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
                    <span>Lista de Quejas</span>
                </strong>
                <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                    <a href="add_queja.php" style="margin-left: 10px" class="btn btn-info pull-right">Agregar Queja</a>
                <?php endif; ?>
                <form action=" <?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
                    <button style="float: right; margin-top: -20px" type="submit" id="export_data" name='export_data'
                        value="Export to excel" class="btn btn-excel">Exportar a Excel</button>
                </form>
            </div>
        </div>

        <div class="panel-body">
            <table class="datatable table table-bordered table-striped">
                <thead>
                    <tr class="table-primary">
                        <th width="5%">Folio</th>
                        <th width="10%">Fecha presentación</th>
                        <th width="10%">Medio presentación</th>
                        <th width="15%">Autoridad responsable</th>
                        <th width="10%">Adjunto</th>
                        <th width="10%">Quejoso</th>
                        <th width="1%">Estatus</th>
                        <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                            <th width="3%;" class="text-center">Acciones</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quejas_libro as $queja): ?>
                        <tr>
                            <td>
                                <?php echo remove_junk(ucwords($queja['folio_queja'])) ?>
                            </td>
                            <?php
                            $folio_editar = $queja['folio_queja'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td>
                                <?php echo remove_junk(ucwords($queja['fecha_presentacion'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['medio_pres'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['nombre_autoridad'])) ?>
                            </td>
                            <td><a target="_blank" style="color: #0094FF;"
                                    href="uploads/quejas/<?php echo $resultado . '/' . $queja['archivo']; ?>"><?php echo $queja['archivo']; ?></a></td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['nombre_quejoso'] . " " . $queja['paterno_quejoso'] . " " . $queja['materno_quejoso'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($queja['estatus_queja'])) ?>
                            </td>
                            <?php if (($nivel <= 2) || ($nivel == 5)): ?>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="ver_info_queja.php?id=<?php echo (int) $queja['id_queja_date']; ?>"
                                            class="btn btn-md btn-info" data-toggle="tooltip" title="Ver información">
                                            <i class="glyphicon glyphicon-eye-open"></i>
                                        </a>
                                        <a href="edit_queja.php?id=<?php echo (int) $queja['id_queja_date']; ?>"
                                            class="btn btn-warning btn-md" title="Editar" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-edit"></span>
                                        </a>
                                        <a href="seguimiento_queja.php?id=<?php echo (int) $queja['id_queja_date']; ?>"
                                            class="btn btn-secondary btn-md" title="Seguimiento" data-toggle="tooltip">
                                            <span class="glyphicon glyphicon-arrow-right"></span>
                                        </a>
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
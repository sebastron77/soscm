<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Queja';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id_queja((int) $_GET['id']);
$user = current_user();
$nivel = $user['user_level'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    redirect('home.php');
}
if ($nivel == 5) {
    page_require_level(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}

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
                    <span>Información de Queja</span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr style="height: 10px;" class="table-primary">
                            <th style="width: 2%;" class="text-center">Folio</th>
                            <th style="width: 3%;" class="text-center">Fecha Presentación</th>
                            <th style="width: 3%;" class="text-center">Medio de Presentación</th>
                            <th style="width: 7%;" class="text-center">Autoridad Responsable</th>
                            <th style="width: 5%;" class="text-center">Fecha avocamiento</th>
                            <th style="width: 3%;" class="text-center">Incompetencia</th>
                            <th style="width: 5%;" class="text-center">Causa Incompetencia</th>
                            <th style="width: 5%;" class="text-center">Fecha Acuerdo Incompetencia</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['folio_queja'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['fecha_presentacion'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['medio_pres'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['nombre_autoridad'])) ?>
                            </td>
                            <td class="text-center">
                                <?php if ($e_detalle['fecha_avocamiento'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['fecha_avocamiento']))) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['incompetencia'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['incompetencia']))) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['causa_incomp'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['causa_incomp']))) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['fecha_acuerdo_incomp'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['fecha_acuerdo_incomp']))) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="table-primary">
                                <th style="width: 1%;" class="text-center">Desechamiento</th>
                                <th style="width: 1%;" class="text-center">Razón Desechamiento</th>
                                <th style="width: 1%;" class="text-center">Forma Conclusión</th>
                                <th style="width: 1%;" class="text-center">Fecha Conclusión</th>
                                <th style="width: 3%;" class="text-center">Estado Procesal</th>
                                <th style="width: 2%;" class="text-center">Tipo Resolución</th>
                                <th style="width: 5%;" class="text-center">Num. Recomendación</th>
                                <th style="width: 5%;" class="text-center">Tipo Ámbito</th>
                                <th style="width: 5%;" class="text-center">Fecha termino</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                <?php if ($e_detalle['desechamiento'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['desechamiento'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['razon_desecha'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['razon_desecha'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['forma_conclusion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk($e_detalle['forma_conclusion']) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['fecha_conclusion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['fecha_conclusion'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['estado_procesal'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['estado_procesal'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['tipo_resolucion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['tipo_resolucion'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['num_recomendacion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['num_recomendacion'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['tipo_ambito'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['tipo_ambito'])) ?>
                                </td>
                                <td class="text-center">
                                <?php if ($e_detalle['fecha_termino'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['fecha_termino'])) ?>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr class="table-primary">
                                <th style="width: 10%;" class="text-center">Quejoso</th>
                                <th style="width: 10%;" class="text-center">Agraviado</th>
                                <th style="width: 2%;" class="text-center">Fecha Creación</th>
                                <th style="width: 1%;" class="text-center">Asignado a</th>
                                <th style="width: 5%;" class="text-center">Área asignada</th>
                                <th style="width: 3%;" class="text-center">Fecha Vencimiento</th>
                                <th style="width: 5%;" class="text-center">Estatus Queja</th>
                                <th style="width: 5%;" class="text-center">Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                <?php echo remove_junk(ucwords(($e_detalle['nombre_quejoso'] . " " . $e_detalle['paterno_quejoso'] . " " . $e_detalle['materno_quejoso']))) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['nombre_agraviado'] . " " . $e_detalle['paterno_agraviado'] . " " . $e_detalle['materno_agraviado'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['fecha_creacion'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords(($e_detalle['username']))) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords(($e_detalle['nombre_area']))) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($e_detalle['fecha_vencimiento'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk(ucwords($e_detalle['estatus_queja'])) ?>
                            </td>
                            <?php
                            $folio_editar = $e_detalle['folio_queja'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td class="text-center"><a target="_blank" style="color:#0094FF"
                                    href="uploads/quejas/<?php echo $resultado . '/' . $e_detalle['archivo']; ?>"><?php
                                    echo $e_detalle['archivo']; ?></a></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr class="table-primary">
                            <th style="width: 5%;" class="text-center">Calle</th>
                            <th style="width: 0.5%;" class="text-center">Núm.</th>
                            <th style="width: 5%;" class="text-center">Colonia</th>
                            <th style="width: 10%;" class="text-center">Descripción Hechos</th>
                            <th style="width: 10%;" class="text-center">Notas internas</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['dom_calle'])) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk($e_detalle['dom_numero']) ?>
                            </td>
                            <td class="text-center">
                                <?php echo remove_junk(ucwords($e_detalle['dom_colonia'])) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['descripcion_hechos']) ?>
                            </td>
                            <td>
                                <?php echo remove_junk($e_detalle['observaciones']) ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
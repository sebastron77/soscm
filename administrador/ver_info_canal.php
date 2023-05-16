<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Canalización';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id_canalizacion((int)$_GET['id']);
//$all_detalles = find_all_detalles_busqueda($_POST['consulta']);
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
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    page_require_level_exacto(7);
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
                    <span>Información de Canalización</span>
                </strong>
            </div>

            <div class="panel-body">
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <trstyle="height: 10px;">
                            <th style="width: 1%;" class="text-center">Folio</th>
                            <th style="width: 3%;" class="text-center">Fecha de Creación</th>
                            <th style="width: 3%;" class="text-center">Medio de presentación</th>
                            <th style="width: 7%;" class="text-center">Correo</th>
                            <!--SE PUEDE AGREGAR UN LINK QUE TE LLEVE A EDITAR EL USUARIO, COMO EN EL PANEL DE CONTROL EN ULTIMAS ASIGNACIONES-->
                            <th style="width: 5%;" class="text-center">Nombre Completo</th>
                            <th style="width: 3%;" class="text-center">Nivel de Estudios</th>
                            <th style="width: 5%;" class="text-center">Ocupación</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['folio'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['creacion'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['med'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['correo_electronico'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['nombre_completo']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['cesc']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['ocup']))) ?></td>
                        </tr>

                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th style="width: 1%;" class="text-center">Edad</th>
                            <th style="width: 1%;" class="text-center">Telefono</th>
                            <th style="width: 1%;" class="text-center">Extensión</th>
                            <th style="width: 1%;" class="text-center">Género</th>
                            <th style="width: 3%;" class="text-center">Grupo Vulnerable</th>
                            <th style="width: 2%;" class="text-center">Lengua</th>
                            <th style="width: 5%;" class="text-center">Calle-Num.</th>
                            <th style="width: 5%;" class="text-center">Colonia</th>
                            <th style="width: 2%;" class="text-center">Código Postal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['edad'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['telefono'])) ?></td>
                            <td class="text-center"><?php echo remove_junk($e_detalle['extension']) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['gen'])) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['grupo']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['lengua']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['calle_numero']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['colonia']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['codigo_postal'])) ?></td>
                        </tr>
                    </tbody>
                </table>
                <table class="table table-bordered table-striped">
                    <thead class="thead-purple">
                        <tr>
                            <th style="width: 5%;" class="text-center">Institución que se canaliza</th>
                            <!-- <th style="width: 2%;" class="text-center">Municipio</th> -->
                            <th style="width: 2%;" class="text-center">Localidad</th>
                            <th style="width: 2%;" class="text-center">Entidad</th>
                            <th style="width: 1%;" class="text-center">Nacionalidad</th>
                            <th style="width: 5%;" class="text-center">Observaciones</th>
                            <th style="width: 3%;" class="text-center">Acta de Canalización</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['aut'])) ?></td>                            
                            <!-- <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['municipio']))) ?></td> -->
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['municipio_localidad']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords(($e_detalle['ent']))) ?></td>
                            <td class="text-center"><?php echo remove_junk(ucwords($e_detalle['nac'])) ?></td>
                            <td><?php echo remove_junk(ucwords($e_detalle['observaciones'])) ?></td>
                            <?php
                            $folio_editar = $e_detalle['folio'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <td class="text-center"><a target="_blank" style="color: #0094FF;" href="uploads/orientacioncanalizacion/canalizacion/<?php echo $resultado . '/' . $e_detalle['adjunto']; ?>"><?php echo $e_detalle['adjunto']; ?></a></td>

                        </tr>
                    </tbody>
                </table>
                <a href="canalizaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
            </div>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
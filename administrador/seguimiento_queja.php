<?php
$page_title = 'Seguimiento de Queja';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id_queja((int) $_GET['id']);
if (!$e_detalle) {
    $session->msg("d", "ID de queja no encontrado.");
    redirect('quejas.php');
}
$user = current_user();
$nivel = $user['user_level'];

$cat_medios_pres = find_all_medio_pres();
$cat_autoridades = find_all_aut_res();
$cat_quejosos = find_all_quejosos();
$cat_agraviados = find_all('cat_agraviados');
$users = find_all('users');
$asigna_a = find_all_area_userQ();
$area = find_all_areas_quejas();
$cat_estatus_queja = find_all_estatus_queja();
$cat_municipios = find_all_cat_municipios();

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
    page_require_level(7);
}
?>
<?php
if (isset($_POST['seguimiento_queja'])) {
    if (empty($errors)) {
        $id = (int) $e_detalle['id_queja_date'];        
        $fecha_avocamiento = remove_junk($db->escape($_POST['fecha_avocamiento']));        
        $incompetencia = remove_junk($db->escape($_POST['incompetencia']));
        $causa_incomp = remove_junk($db->escape($_POST['causa_incomp']));
        $fecha_acuerdo_incomp = remove_junk($db->escape($_POST['fecha_acuerdo_incomp']));
        $desechamiento = remove_junk($db->escape($_POST['desechamiento']));
        $razon_desecha = remove_junk($db->escape($_POST['razon_desecha']));
        $forma_conclusion = remove_junk($db->escape($_POST['forma_conclusion']));
        $estado_procesal = remove_junk($db->escape($_POST['estado_procesal']));
        $fecha_vencimiento = remove_junk($db->escape($_POST['fecha_vencimiento']));
        $id_tipo_resolucion = remove_junk($db->escape($_POST['id_tipo_resolucion']));
        $num_recomendacion = remove_junk($db->escape($_POST['num_recomendacion']));
        $id_tipo_ambito = remove_junk($db->escape($_POST['id_tipo_ambito']));
        $fecha_termino = remove_junk($db->escape($_POST['fecha_termino']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_actualizacion = date('Y-m-d H:i:s');

        $sql = "UPDATE quejas_dates SET fecha_actualizacion='$fecha_actualizacion',fecha_avocamiento='$fecha_avocamiento'  WHERE id_queja_date='{$db->escape($id)}'";

        $result = $db->query($sql);

        if (($result && $db->affected_rows() === 1)) {
            $session->msg('s', "Información actualizada con su Seguimiento");
            redirect('quejas.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('seguimiento_queja.php?id=' . (int) $e_detalle['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('seguimiento_queja.php?id=' . (int) $e_detalle['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Seguimiento de queja
                    <?php echo $e_detalle['folio_queja']; ?>
                </span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="seguimiento_queja.php?id=<?php echo (int) $e_detalle['id_queja_date']; ?>"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_presentacion">Fecha de presentación</label>
                            <input type="datetime-local" class="form-control" name="fecha_presentacion"
                                value="<?php echo remove_junk($e_detalle['fecha_presentacion']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_cat_med_pres">Medio Presetación</label>
                            <input type="text" class="form-control" name="id_cat_med_pres"
                                value="<?php echo remove_junk($e_detalle['medio_pres']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="id_cat_aut">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="id_cat_aut"
                                value="<?php echo remove_junk($e_detalle['nombre_autoridad']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_quejoso">Quejoso</label>                            
                            <input type="text" class="form-control" name="id_cat_quejoso"
                                value="<?php echo remove_junk($e_detalle['nombre_quejoso'] . " " . $e_detalle['paterno_quejoso'] . " " . $e_detalle['materno_quejoso']); ?>"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_agraviado">Agraviado</label>
                            <input type="text" class="form-control" name="id_cat_agraviado"
                                value="<?php echo ucwords(remove_junk($e_detalle['nombre_agraviado'] . " " . $e_detalle['paterno_agraviado'] . " " . $e_detalle['materno_agraviado'])); ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_user_asignado">Se asigna a</label>
                            <input type="text" class="form-control" name="id_user_asignado"
                                value="<?php foreach ($asigna_a as $asigna):
                                    if ($asigna['id_det_usuario'] === $e_detalle['id_user_asignado'])
                                        echo $asigna['nombre'] . " " . $asigna['apellidos']; ?> <?php endforeach; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_area_asignada">Área a la que se asigna</label>
                            <input type="text" class="form-control" name="id_user_asignado"
                                value="<?php foreach ($area as $a):
                                    if ($a['id_area'] === $e_detalle['id_area_asignada'])
                                        echo $a['nombre_area'] ?> <?php endforeach; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_estatus_queja">Estatus de Queja</label>
                            <input type="text" class="form-control" name="id_user_asignado"
                                value="<?php foreach ($cat_estatus_queja as $estatus):
                                    if ($estatus['id_cat_est_queja'] === $e_detalle['id_estatus_queja'])
                                        echo ucwords($estatus['descripcion']) ?> <?php endforeach; ?>"
                                readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dom_calle">Calle</label>
                            <input type="text" class="form-control" name="dom_calle" placeholder="Calle"
                                value="<?php echo $e_detalle['dom_calle'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="dom_numero">Núm. ext/int</label>
                            <input type="text" class="form-control" name="dom_numero"
                                value="<?php echo $e_detalle['dom_numero'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="dom_colonia">Colonia</label>
                            <input type="text" class="form-control" name="dom_colonia" placeholder="Colonia"
                                value="<?php echo $e_detalle['dom_colonia'] ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_cat_mun">Municipio</label>
                            <input type="text" class="form-control" name="id_cat_mun"
                                value="<?php foreach ($cat_municipios as $municipio):
                                    if ($municipio['id_cat_mun'] === $e_detalle['id_cat_mun'])
                                        echo ucwords($municipio['descripcion']) ?> <?php endforeach; ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto</label>
                            <?php
                            $folio_editar = $e_detalle['folio_queja'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                                <label style="font-size:14px; color:#E3054F;">Archivo Actual: <a target="_blank" style="color:#0094FF"
                                    href="uploads/quejas/<?php echo $resultado . '/' . $e_detalle['archivo']; ?>"><?php echo $e_detalle['archivo']; ?></a></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion_hechos">Descripción de los hechos</label>
                            <textarea class="form-control" name="descripcion_hechos" id="descripcion_hechos" cols="30"
                                rows="5"
                                value="<?php echo $e_detalle['descripcion_hechos'] ?>" readonly><?php echo $e_detalle['descripcion_hechos'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Notas Internas</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="30" rows="5"
                                value="<?php echo $e_detalle['observaciones'] ?>" readonly><?php echo $e_detalle['observaciones'] ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="seguimiento_queja" class="btn btn-primary"
                        value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
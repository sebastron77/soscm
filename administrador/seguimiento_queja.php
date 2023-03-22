<?php
$page_title = 'Seguimiento de Queja';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id_queja((int) $_GET['id']);
// echo $e_detalle['id_queja_date'];
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
$cat_est_procesal = find_all('cat_est_procesal');
$cat_tipo_resolucion = find_all('cat_tipo_res');
$cat_tipo_ambito = find_all('cat_tipo_ambito');

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
        $incompetencia = remove_junk($db->escape($_POST['incompetencia']));
        $causa_incomp = remove_junk($db->escape($_POST['causa_incomp']));
        $fecha_acuerdo_incomp = remove_junk($db->escape($_POST['fecha_acuerdo_incomp']));
        $a_quien_se_traslada = remove_junk($db->escape($_POST['a_quien_se_traslada']));
        $desechamiento = remove_junk($db->escape($_POST['desechamiento']));
        $razon_desecha = remove_junk($db->escape($_POST['razon_desecha']));
        $estado_procesal = remove_junk($db->escape($_POST['estado_procesal']));
        $id_tipo_resolucion = remove_junk($db->escape($_POST['id_tipo_resolucion']));
        $num_recomendacion = remove_junk($db->escape($_POST['num_recomendacion']));
        $id_tipo_ambito = remove_junk($db->escape($_POST['id_tipo_ambito']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_actualizacion = date('Y-m-d H:i:s');

        if (($causa_incomp != '') && ($id_tipo_resolucion == 2)) {
            $sql = "UPDATE quejas_dates SET fecha_actualizacion='$fecha_actualizacion',incompetencia='1',causa_incomp='$causa_incomp',
                    fecha_acuerdo_incomp='$fecha_acuerdo_incomp',a_quien_se_traslada='$a_quien_se_traslada',desechamiento=0,razon_desecha='',
                    num_recomendacion='',estado_procesal='$estado_procesal',id_tipo_resolucion='$id_tipo_resolucion',id_tipo_ambito='$id_tipo_ambito' 
                    WHERE id_queja_date='{$db->escape($id)}'";
            $result = $db->query($sql);
        }
        if (($num_recomendacion != '') && ($id_tipo_resolucion == 5)) {
            $sql2 = "UPDATE quejas_dates SET fecha_actualizacion='$fecha_actualizacion',incompetencia='0',causa_incomp='',fecha_acuerdo_incomp=NULL,
                    a_quien_se_traslada='',desechamiento=0,razon_desecha='',num_recomendacion='$num_recomendacion',estado_procesal='$estado_procesal',
                    id_tipo_resolucion='$id_tipo_resolucion',id_tipo_ambito='$id_tipo_ambito' WHERE id_queja_date='{$db->escape($id)}'";
            $result2 = $db->query($sql2);
        }
        if (($razon_desecha != '') && ($id_tipo_resolucion == 6)) {
            $sql3 = "UPDATE quejas_dates SET fecha_actualizacion='$fecha_actualizacion',incompetencia='0',causa_incomp='',fecha_acuerdo_incomp=NULL,
                    a_quien_se_traslada='',desechamiento=1,razon_desecha='$razon_desecha',num_recomendacion='',estado_procesal='$estado_procesal',
                    id_tipo_resolucion='$id_tipo_resolucion',id_tipo_ambito='$id_tipo_ambito' WHERE id_queja_date='{$db->escape($id)}'";
            $result3 = $db->query($sql3);
        }

        if (($result && $db->affected_rows() === 1) || ($result2 && $db->affected_rows() === 1) || ($result3 && $db->affected_rows() === 1)) {
            $session->msg('s', "Queja actualizada con su Seguimiento");
            redirect('quejas.php', false);
        } else {
            $session->msg('d', ' Lo siento no se pudieron actualizar los datos.');
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
                <span>Queja
                    <?php echo $e_detalle['folio_queja']; ?>
                </span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="seguimiento_queja.php?id=<?php echo (int) $e_detalle['id_queja_date']; ?>"
                enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="id_cat_aut">Autoridad Responsable</label>
                            <input type="text" class="form-control" name="id_cat_aut"
                                value="<?php echo remove_junk($e_detalle['nombre_autoridad']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_quejoso">Nombre del Quejoso</label>
                            <input type="text" class="form-control" name="id_cat_quejoso"
                                value="<?php echo remove_junk($e_detalle['nombre_quejoso'] . " " . $e_detalle['paterno_quejoso'] . " " . $e_detalle['materno_quejoso']); ?>"
                                readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_area_asignada">Área a la que se asignó la queja</label>
                            <input type="text" class="form-control" name="id_user_asignado" value="<?php foreach ($area as $a){
                                if ($a['id_area'] === $e_detalle['id_area_asignada'])
                                    echo $a['nombre_area'];} ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_cat_mun">Municipio</label>
                            <input type="text" class="form-control" name="id_cat_mun" value="<?php foreach ($cat_municipios as $municipio){
                                if ($municipio['id_cat_mun'] === $e_detalle['id_cat_mun'])
                                    echo ucwords($municipio['descripcion']);} ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_estatus_queja">Estatus de Queja</label>
                            <input type="text" class="form-control" name="id_user_asignado" value="<?php foreach ($cat_estatus_queja as $estatus){
                                if ($estatus['id_cat_est_queja'] === $e_detalle['id_estatus_queja'])
                                    echo ucwords($estatus['descripcion']);}?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto</label>
                            <?php
                            $folio_editar = $e_detalle['folio_queja'];
                            $resultado = str_replace("/", "-", $folio_editar);
                            ?>
                            <label style="font-size:14px; color:#E3054F;">Archivo Actual: <a target="_blank"
                                    style="color:#0094FF"
                                    href="uploads/quejas/<?php echo $resultado . '/' . $e_detalle['archivo']; ?>"><?php echo $e_detalle['archivo']; ?></a></label>
                        </div>
                    </div>
                </div>

                <hr style="height: 1px; background-color: #370494; opacity: 1;">
                <strong>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#7263F0" width="25px" height="25px"
                        viewBox="0 0 24 24" style="margin-top:-0.3%;">
                        <title>arrow-right-circle</title>
                        <path
                            d="M22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2A10,10 0 0,1 22,12M6,13H14L10.5,16.5L11.92,17.92L17.84,12L11.92,6.08L10.5,7.5L14,11H6V13Z" />
                    </svg>
                    <span style="font-size: 20px; color: #7263F0">SEGUIMIENTO DE LA QUEJA</span>
                </strong>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_tipo_resolucion">Tipo de Resolución</label>
                            <select class="form-control" id="id_tipo_resolucion" name="id_tipo_resolucion"
                                onchange="showInp()">
                                <option value="">Escoge una opción</option>
                                <!-- <?php foreach ($cat_tipo_resolucion as $tipo_res): ?>
                                    <option value="<?php echo $tipo_res['id_cat_tipo_res']; ?>"><?php echo ucwords($tipo_res['descripcion']); ?></option>
                                <?php endforeach; ?> -->
                                <?php foreach ($cat_tipo_resolucion as $tipo_res): ?>
                                    <option <?php if ($tipo_res['id_cat_tipo_res'] === $e_detalle['id_tipo_resolucion'])
                                        echo 'selected="selected"'; ?> value="<?php echo $tipo_res['id_cat_tipo_res']; ?>"><?php echo ucwords($tipo_res['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if($e_detalle['id_tipo_resolucion'] == 2):?>
                        <div class="col-md-4" id="incompetencia2">
                    <?php endif;?>
                    <?php if($e_detalle['id_tipo_resolucion'] != 2):?>
                    <div class="col-md-4" id="incompetencia2" style="display: none">
                    <?php endif;?>
                        <div class="form-group">
                            <label for="causa_incomp">Causa Incompetencia (Si la hay)</label>
                            <textarea class="form-control" name="causa_incomp" id="causa_incomp" cols="40"
                                rows="3"><?php echo $e_detalle['causa_incomp'] ?></textarea>
                        </div>
                    </div>
                    <?php if($e_detalle['id_tipo_resolucion'] == 2):?>
                        <div class="col-md-2" id="incompetencia3">
                    <?php endif;?>
                    <?php if($e_detalle['id_tipo_resolucion'] != 2):?>
                    <div class="col-md-2" id="incompetencia3" style="display: none">
                    <?php endif;?>
                        <div class="form-group">
                            <label for="fecha_acuerdo_incomp">Fecha de Acuerdo de Incompetencia</label>
                            <input type="date" class="form-control" name="fecha_acuerdo_incomp"
                                value="<?php echo $e_detalle['fecha_acuerdo_incomp']; ?>">
                        </div>
                    </div>
                    <?php if($e_detalle['id_tipo_resolucion'] == 2):?>
                        <div class="col-md-4" id="incompetencia4">
                    <?php endif;?>
                    <?php if($e_detalle['id_tipo_resolucion'] != 2):?>
                    <div class="col-md-4" id="incompetencia4" style="display: none">
                    <?php endif;?>
                        <div class="form-group">
                            <label for="a_quien_se_traslada">¿A quién se traslada?</label>
                            <textarea class="form-control" name="a_quien_se_traslada" id="a_quien_se_traslada" cols="40"
                                rows="3"><?php echo $e_detalle['a_quien_se_traslada'] ?></textarea>
                        </div>
                    </div>
                    <?php if($e_detalle['id_tipo_resolucion'] == 5):?>
                        <div class="col-md-2" id="recomendacion">
                    <?php endif;?>
                    <?php if($e_detalle['id_tipo_resolucion'] != 5):?>
                    <div class="col-md-2" id="recomendacion" style="display: none">
                    <?php endif;?>
                        <div class="form-group">
                            <label for="num_recomendacion">Núm. Recomendación</label>
                            <input type="text" class="form-control" name="num_recomendacion"
                                value="<?php echo $e_detalle['num_recomendacion']; ?>">
                        </div>
                    </div>
                    <?php if($e_detalle['id_tipo_resolucion'] == 6):?>
                        <div class="col-md-4" id="desechamiento2">
                    <?php endif;?>
                    <?php if($e_detalle['id_tipo_resolucion'] != 6):?>
                    <div class="col-md-4" id="desechamiento2" style="display: none">
                    <?php endif;?>
                        <div class="form-group">
                            <label for="razon_desecha">Razón Desechamiento (Si la hay)</label>
                            <textarea class="form-control" name="razon_desecha" id="razon_desecha" cols="40"
                                rows="3"><?php echo $e_detalle['razon_desecha'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="estado_procesal">Estado Procesal</label>
                            <select class="form-control" name="estado_procesal">
                                <!-- <?php foreach ($cat_est_procesal as $est_pros): ?>
                                    <option value="<?php echo $est_pros['id_cat_est_procesal']; ?>"><?php echo ucwords($est_pros['descripcion']); ?></option>
                                <?php endforeach; ?> -->
                                <?php foreach ($cat_est_procesal as $est_pros): ?>
                                    <option <?php if ($est_pros['id_cat_est_procesal'] === $e_detalle['estado_procesal'])
                                        echo 'selected="selected"'; ?> value="<?php echo $est_pros['id_cat_est_procesal']; ?>">
                                        <?php echo ucwords($est_pros['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_tipo_ambito">Tipo Ámbito</label>
                            <select class="form-control" name="id_tipo_ambito">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_tipo_ambito as $ambito): ?>
                                    <option <?php if ($ambito['id_cat_tipo_ambito'] === $e_detalle['id_tipo_ambito'])
                                        echo 'selected="selected"'; ?> value="<?php echo $ambito['id_cat_tipo_ambito']; ?>"><?php echo ucwords($ambito['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2" style="display: none">
                        <div class="form-group">
                            <label for="incompetencia">Incompetencia</label>
                            <select class="form-control" name="incompetencia" id="incompetencia">
                            <?php if ($e_detalle['incompetencia'] == 0):?>
                                <option value="0">No</option>
                                <?php endif;?>
                                <?php if ($e_detalle['incompetencia'] == 1):?>
                                <option value="1">Sí</option>
                                <?php endif;?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2" style="display: none">
                        <div class="form-group">
                            <label for="desechamiento">Desechamiento</label>
                            <select class="form-control" name="desechamiento" id="desechamiento">
                            <?php if ($e_detalle['desechamiento'] == 0):?>
                                <option value="0">No</option>
                                <?php endif;?>
                                <?php if ($e_detalle['desechamiento'] == 1):?>
                                <option value="1">Sí</option>
                                <?php endif;?>
                            </select>
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
<script>
    function showInp() {
        var getSelectValue = document.getElementById("id_tipo_resolucion").value;
        console.log("ID: " + getSelectValue);

        if (getSelectValue == "2") { //Incompetencia
            document.getElementById("incompetencia2").style.display = "inline-block";
            document.getElementById("incompetencia3").style.display = "inline-block";
            document.getElementById("incompetencia4").style.display = "inline-block";
            document.getElementById("recomendacion").style.display = "none";
            document.getElementById("desechamiento2").style.display = "none";
        }
        if (getSelectValue == "5") { //Recomendación
            document.getElementById("recomendacion").style.display = "inline-block";
            document.getElementById("incompetencia2").style.display = "none";
            document.getElementById("incompetencia3").style.display = "none";
            document.getElementById("incompetencia4").style.display = "none";
            document.getElementById("desechamiento2").style.display = "none";
        }

        if (getSelectValue == "6") { //Desechamiento
            document.getElementById("desechamiento2").style.display = "inline-block";
            document.getElementById("recomendacion").style.display = "none";
            document.getElementById("incompetencia2").style.display = "none";
            document.getElementById("incompetencia3").style.display = "none";
            document.getElementById("incompetencia4").style.display = "none";
        }
    }

    if (document.getElementById("id_tipo_resolucion").value === "2") {
        document.getElementById("incompetencia2").addAttribute("required");
    }

    if (document.getElementById("id_tipo_resolucion").value === "5") {
        document.getElementById("recomendacion").addAttribute("required");
    }

    if (document.getElementById("id_tipo_resolucion").value === "6") {
        document.getElementById("desechamiento2").addAttribute("required");
    }
</script>
<?php include_once('layouts/footer.php'); ?>
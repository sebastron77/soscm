<?php
$page_title = 'Editar OSC';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$ambitos = find_all('cat_der_vuln');
$e_osc = osc_by_id((int)$_GET['id']);
$municipios = find_all('cat_municipios');

page_require_level(2);

if (!$e_osc) {
    $session->msg("d", "id de OSC no encontrado.");
    redirect('osc.php');
}
?>
<?php
if (isset($_POST['edit_osc'])) {
    $countfiles = count($_FILES['logo']['name']);
    if (empty($errors)) {
        $id = (int)$e_osc['id_osc'];
        $nombre = remove_junk($db->escape($_POST['nombre']));
        $siglas = remove_junk($db->escape($_POST['siglas']));
        $logo = remove_junk($db->escape($_POST['logo']));
        $ambito = remove_junk($db->escape($_POST['ambito']));
        $objetivo = remove_junk($db->escape($_POST['objetivo']));
        $figura_juridica = remove_junk($db->escape($_POST['figura_juridica']));
        $fecha_constitucion = remove_junk($db->escape($_POST['fecha_constitucion']));
        $datos_escritura_const = remove_junk($db->escape($_POST['datos_escritura_const']));
        $nombre_responsable = remove_junk($db->escape($_POST['nombre_responsable']));
        $calle_num = remove_junk($db->escape($_POST['calle_num']));
        $colonia = remove_junk($db->escape($_POST['colonia']));
        $cp = remove_junk($db->escape($_POST['cp']));
        $telefono   = remove_junk($db->escape($_POST['telefono']));
        $web_oficial = remove_junk($db->escape($_POST['web_oficial']));
        $x = remove_junk($db->escape($_POST['x']));
        $facebook = remove_junk($db->escape($_POST['facebook']));
        $instagram = remove_junk($db->escape($_POST['instagram']));
        $youtube = remove_junk($db->escape($_POST['youtube']));
        $tiktok = remove_junk($db->escape($_POST['tiktok']));
        $correo_oficial = remove_junk($db->escape($_POST['correo_oficial']));
        $convenio_cedh = remove_junk($db->escape($_POST['convenio_cedh']));
        $region = remove_junk($db->escape($_POST['region']));
        $info_publica = remove_junk($db->escape($_POST['info_publica']));

        $carpeta = 'uploads/logos_osc/' . $siglas;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Generamos el bucle de todos los archivos
        for ($i = 0; $i <= 1; $i++) {

            // Extraemos en variable el nombre de archivo
            $filename = $_FILES['logo']['name'][$i];

            // Designamos la carpeta de subida
            $target_file = 'uploads/logos_osc/' . $siglas . '/' . $filename;

            // Obtenemos la extension del archivo
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

            $file_extension = strtolower($file_extension);

            // Validamos la extensión de la imagen
            $valid_extension = array("png", "jpeg", "jpg");

            if (in_array($file_extension, $valid_extension)) {

                // Subimos la imagen al servidor
                move_uploaded_file($_FILES['logo']['tmp_name'][$i], $target_file);
            }
        }
        if($_FILES['logo']['name'][0] != ''){
        $sql = "UPDATE osc SET nombre='{$nombre}', siglas='{$siglas}', logo='{$_FILES['logo']['name'][0]}', ambito='{$ambito}', objetivo='{$objetivo}', 
                figura_juridica='{$figura_juridica}', datos_escritura_const='{$datos_escritura_const}', nombre_responsable='{$nombre_responsable}', 
                calle_num='{$calle_num}', colonia='{$colonia}', cp='{$cp}', telefono='{$telefono}', web_oficial='{$web_oficial}', x='{$x}', 
                facebook='{$facebook}', instagram='{$instagram}', youtube='{$youtube}', tiktok='{$tiktok}', correo_oficial='{$correo_oficial}', 
                convenio_cedh='{$convenio_cedh}', region='{$region}', info_publica='{$info_publica}'
                WHERE id_osc='{$db->escape($id)}'";
        }
        if($_FILES['logo']['name'][0] == ''){
            $sql = "UPDATE osc SET nombre='{$nombre}', siglas='{$siglas}', ambito='{$ambito}', objetivo='{$objetivo}', 
                    figura_juridica='{$figura_juridica}', datos_escritura_const='{$datos_escritura_const}', nombre_responsable='{$nombre_responsable}', 
                    calle_num='{$calle_num}', colonia='{$colonia}', cp='{$cp}', telefono='{$telefono}', web_oficial='{$web_oficial}', x='{$x}', 
                    facebook='{$facebook}', instagram='{$instagram}', youtube='{$youtube}', tiktok='{$tiktok}', correo_oficial='{$correo_oficial}', 
                    convenio_cedh='{$convenio_cedh}', region='{$region}', info_publica='{$info_publica}'
                    WHERE id_osc='{$db->escape($id)}'";
            }
        $result = $db->query($sql);
        if (($result && $db->affected_rows() === 1) || ($result && $db->affected_rows() === 0)) {
            $session->msg('s', "Información Actualizada ");
            insertAccion($user['id_user'], '"' . $user['username'] . '" editó la OSC: ' . $nombre . '.', 2);
            redirect('edit_osc.php?id=' . (int)$e_osc['id_osc'], false);
        } else {
            $session->msg('d', ' Lo sentimos, no se actualizó la información.');
            redirect('edit_osc.php?id=' . (int)$e_osc['id_osc'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_osc.php?id=' . (int)$e_osc['id_osc'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar OSC</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_osc.php?id=<?php echo $e_osc['id_osc']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre de OSC" value="<?php echo $e_osc['nombre']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="siglas">Siglas</label>
                            <input type="text" class="form-control" name="siglas" value="<?php echo $e_osc['siglas']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="logo">Adjuntar Logo</label>
                            <input type='file' class="custom-file-input form-control" id="inputGroupFile01" name='logo[]' value="<?php echo $e_osc['logo']; ?>" multiple />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ambito">Ámbito</label>
                            <select class="form-control" name="ambito" required>
                                <?php foreach ($ambitos as $ambito) : ?>
                                    <option <?php if ($ambito['id_cat_der_vuln'] == $e_osc['ambito']) echo 'selected="selected"'; ?> value="<?php echo $ambito['id_cat_der_vuln']; ?>"><?php echo ucwords($ambito['descripcion']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Objetivo</label>
                            <textarea class="form-control" name="objetivo" id="objetivo" cols="10" rows="4" value="<?php echo $e_osc['objetivo']; ?>"><?php echo $e_osc['objetivo']; ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="figura_juridica" required>Figura Jurídica</label>
                            <select class="form-control" name="figura_juridica">
                                <option value="">Escoge una Opción</option>
                                <option <?php if ($e_osc['figura_juridica'] == 'I.A.P') echo 'selected="selected"'; ?> value="I.A.P">I.A.P</option>
                                <option <?php if ($e_osc['figura_juridica'] == 'A.C.') echo 'selected="selected"'; ?> value="A.C.">A.C.</option>
                                <option <?php if ($e_osc['figura_juridica'] == 'S.C.') echo 'selected="selected"'; ?> value="S.C.">S.C.</option>
                                <option <?php if ($e_osc['figura_juridica'] == 'Colectivo') echo 'selected="selected"'; ?> value="Colectivo">Colectivo</option>
                                <option <?php if ($e_osc['figura_juridica'] == 'Red') echo 'selected="selected"'; ?> value="Red">Red</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_constitucion">Fecha de Constitución</label>
                            <input class="form-control" name="fecha_constitucion" type="date" value="<?php echo $e_osc['fecha_constitucion']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="datos_escritura_const">Datos de Escritura de Constitución</label>
                            <textarea class="form-control" name="datos_escritura_const" id="datos_escritura_const" cols="10" rows="4"><?php echo $e_osc['datos_escritura_const']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_responsable" required>Nombre del Responsable</label>
                            <input type="text" class="form-control" name="nombre_responsable" value="<?php echo $e_osc['nombre_responsable']; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle_num">Calle y Num.</label>
                            <input type="text" class="form-control" name="calle_num" value="<?php echo $e_osc['calle_num']; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia" value="<?php echo $e_osc['colonia']; ?>">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="cp">C.P.</label>
                            <input type="text" class="form-control" name="cp" value="<?php echo $e_osc['cp']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono" value="<?php echo $e_osc['telefono']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="web_oficial">Link de Web Oficial</label>
                            <input type="text" class="form-control" name="web_oficial" value="<?php echo $e_osc['web_oficial']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="x">Link de X</label>
                            <input type="text" class="form-control" name="x" value="<?php echo $e_osc['x']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook"> Link de Facebook</label>
                            <input type="text" class="form-control" name="facebook" value="<?php echo $e_osc['facebook']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="instagram">Link de Instagram</label>
                            <input type="text" class="form-control" name="instagram" value="<?php echo $e_osc['instagram']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="youtube">Link de Youtube</label>
                            <input type="text" class="form-control" name="youtube" value="<?php echo $e_osc['youtube']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tiktok">Link de TikTok</label>
                            <input type="text" class="form-control" name="tiktok" value="<?php echo $e_osc['tiktok']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo_oficial">Correo Oficial</label>
                            <input type="text" class="form-control" name="correo_oficial" value="<?php echo $e_osc['correo_oficial']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="convenio_cedh">Convenio con CEDH</label>
                            <select class="form-control" name="convenio_cedh">
                                <option value="">Escoge una Opción</option>
                                <option <?php if ($e_osc['convenio_cedh'] == '1') echo 'selected="selected"'; ?> value="1">Sí</option>
                                <option <?php if ($e_osc['convenio_cedh'] == '0') echo 'selected="selected"'; ?> value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="region">Región</label>
                            <select class="form-control" name="region">
                                <option value="">Escoge una Opción</option>
                                <?php foreach ($municipios as $municipio1) : ?>
                                    <option <?php if ($municipio1['id_cat_mun'] == $e_osc['region']) echo 'selected="selected"'; ?> value="<?php echo $municipio1['id_cat_mun']; ?>"><?php echo ucwords($municipio1['descripcion']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="info_publica">¿Deseas el domicilio de la OSC sea público?</label>
                            <select class="form-control" name="info_publica">
                                <option <?php if ($e_osc['info_publica'] == '1') echo 'selected="selected"'; ?> value="1">Sí</option>
                                <option <?php if ($e_osc['info_publica'] == '0') echo 'selected="selected"'; ?> value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="osc.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_osc" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
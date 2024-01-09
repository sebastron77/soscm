<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar OSC';
require_once('includes/load.php');

page_require_level(1);
$user = current_user();
$ambitos = find_all('cat_der_vuln');
$municipios = find_all('cat_municipios');
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_osc'])) {
    if (empty($errors)) {
        $nombre = remove_junk($db->escape($_POST['nombre']));
        $siglas = remove_junk($db->escape($_POST['siglas']));
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
        $web_oficial   = remove_junk($db->escape($_POST['web_oficial']));
        $x   = remove_junk($db->escape($_POST['x']));
        $facebook   = remove_junk($db->escape($_POST['facebook']));
        $instagram   = remove_junk($db->escape($_POST['instagram']));
        $youtube   = remove_junk($db->escape($_POST['youtube']));
        $tiktok   = remove_junk($db->escape($_POST['tiktok']));
        $correo_oficial   = remove_junk($db->escape($_POST['correo_oficial']));
        $convenio_cedh   = remove_junk($db->escape($_POST['convenio_cedh']));
        $municipio   = remove_junk($db->escape($_POST['municipio']));
        $info_publica   = remove_junk($db->escape($_POST['info_publica']));
        $creacion = date('Y-m-d');

        $carpeta = 'uploads/logos_osc/' . $siglas;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['logo']['name'];
        $size = $_FILES['logo']['size'];
        $type = $_FILES['logo']['type'];
        $temp = $_FILES['logo']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);


        $query = "INSERT INTO osc (";
        $query .= "nombre, siglas, logo, ambito, objetivo, figura_juridica, fecha_constitucion, datos_escritura_const, nombre_responsable, calle_num, 
                    colonia, cp, telefono, web_oficial, x, facebook, instagram, youtube, tiktok, correo_oficial, convenio_cedh, region, info_publica,
                    fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$nombre}', '{$siglas}', '{$name}', '{$ambito}', '{$objetivo}', '{$figura_juridica}', '{$fecha_constitucion}', '{$datos_escritura_const}',
                    '{$nombre_responsable}', '{$calle_num}', '{$colonia}', '{$cp}', '{$telefono}', '{$web_oficial}', '{$x}', '{$facebook}', '{$instagram}', 
                    '{$youtube}', '{$tiktok}', '{$correo_oficial}','{$convenio_cedh}','{$municipio}','{$info_publica}','{$creacion}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', " La OSC ha sido agregada con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó la OSC: ' . $nombre . '.', 1);
            redirect('osc.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la OSC.');
            redirect('add_osc.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_osc.php', false);
    }
}
?>

<style>
    .popup-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: #333;
        cursor: pointer;
    }

    .img-round {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        cursor: pointer;
    }
</style>

<script>
    function abrirPopup() {
        document.getElementById("popup").style.display = "block";
    }

    function cerrarPopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>

<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar OSC</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_osc.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre de OSC" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="siglas">Siglas</label>
                            <input type="text" class="form-control" name="siglas" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="logo">Adjuntar Logo</label>
                            <input type='file' class="custom-file-input form-control" name='logo'/>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ambito">Ámbito</label>
                            <select class="form-control" name="ambito" required>
                                <?php foreach ($ambitos as $ambito) : ?>
                                    <option value="<?php echo $ambito['id_cat_der_vuln']; ?>"><?php echo ucwords($ambito['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="logo">Objetivo</label>
                            <textarea class="form-control" name="objetivo" id="objetivo" cols="10" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="figura_juridica" required>Figura Jurídica</label>
                            <select class="form-control" name="figura_juridica">
                                <option value="">Escoge una Opción</option>
                                <option value="I.A.P">I.A.P</option>
                                <option value="A.C.">A.C.</option>
                                <option value="S.C.">S.C.</option>
                                <option value="Colectivo">Colectivo</option>
                                <option value="Red">Red</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_constitucion">Fecha de Constitución</label>
                            <input class="form-control" name="fecha_constitucion" type="date">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="datos_escritura_const">Datos de Escritura de Constitución</label>
                            <textarea class="form-control" name="datos_escritura_const" id="datos_escritura_const" cols="10" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_responsable" required>Nombre del Responsable</label>
                            <input type="text" class="form-control" name="nombre_responsable">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle_num">Calle y Num.</label>
                            <input type="text" class="form-control" name="calle_num">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="cp">C.P.</label>
                            <input type="text" class="form-control" name="cp">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="web_oficial">Link de Web Oficial</label>
                            <input type="text" class="form-control" name="web_oficial">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="x">Link de X</label>
                            <input type="text" class="form-control" name="x">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="facebook"> Link de Facebook</label>
                            <input type="text" class="form-control" name="facebook">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="instagram">Link de Instagram</label>
                            <input type="text" class="form-control" name="instagram">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="youtube">Link de Youtube</label>
                            <input type="text" class="form-control" name="youtube">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tiktok">Link de TikTok</label>
                            <input type="text" class="form-control" name="tiktok">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo_oficial">Correo Oficial</label>
                            <input type="text" class="form-control" name="correo_oficial">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="convenio_cedh">Convenio con CEDH</label>
                            <select class="form-control" name="convenio_cedh">
                                <option value="">Escoge una Opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio">Municipio</label>
                            <select class="form-control" name="municipio">
                                <option value="">Escoge una Opción</option>
                                <?php foreach ($municipios as $municipio1) : ?>
                                    <option value="<?php echo $municipio1['id_cat_mun']; ?>"><?php echo ucwords($municipio1['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="info_publica">¿Deseas el domicilio de la OSC sea público?</label>
                            <select class="form-control" name="info_publica">
                                <option value="">Escoge una Opción</option>
                                <option value="1">Sí</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                </div>
        </div><br>

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <div class="form-group clearfix">
            <a href="osc.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                Regresar
            </a>
            <button type="submit" name="add_osc" class="btn btn-primary">Guardar</button>
        </div>
        </form>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
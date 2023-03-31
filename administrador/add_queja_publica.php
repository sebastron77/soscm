<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Agregar Queja';
require_once('includes/load.php');
$user = current_user();
$id_queja = last_id_quejaR();
$id_folio = last_id_folios();

$cat_autoridades = find_all_aut_res();
$cat_municipios = find_all_cat_municipios();
$generos = find_all('cat_genero');
$escolaridades = find_all('cat_escolaridad');
$ocupaciones = find_all('cat_ocupaciones');
$grupos_vuln = find_all('cat_grupos_vuln');
$nacionalidades = find_all('cat_nacionalidades');
?>

<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_queja_publica'])) {

    $req_fields = array(
        'nombre', 'paterno', 'materno', 'genero', 'edad', 'cat_escolaridad', 'grupo_vulnerable', 'cat_nacionalidad',
        'correo', 'telefono', 'calle', 'colonia', 'descripcion_hechos', 'entidad', 'municipio', 'localidad',
        'autoridad_responsable'
    );
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre = remove_junk($db->escape($_POST['nombre']));
        $paterno = remove_junk($db->escape($_POST['paterno']));
        $materno = remove_junk($db->escape($_POST['materno']));
        $genero = remove_junk($db->escape($_POST['genero']));
        $edad = remove_junk($db->escape($_POST['edad']));
        $cat_escolaridad = remove_junk($db->escape($_POST['cat_escolaridad']));
        $cat_ocupacion = remove_junk($db->escape($_POST['cat_ocupacion']));
        $grupo_vulnerable = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $cat_nacionalidad = remove_junk($db->escape($_POST['cat_nacionalidad']));
        $correo = remove_junk($db->escape($_POST['correo']));
        $telefono = remove_junk($db->escape($_POST['telefono']));
        $calle = remove_junk($db->escape($_POST['calle']));
        $numero = remove_junk($db->escape($_POST['numero']));
        $colonia = remove_junk($db->escape($_POST['colonia']));
        $codigo_postal = remove_junk($db->escape($_POST['codigo_postal']));
        $descripcion_hechos = remove_junk($db->escape($_POST['descripcion_hechos']));
        $entidad = remove_junk($db->escape($_POST['entidad']));
        $municipio = remove_junk($db->escape($_POST['municipio']));
        $localidad = remove_junk($db->escape($_POST['localidad']));
        $autoridad_responsable = remove_junk($db->escape($_POST['autoridad_responsable']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_creacion = date('Y-m-d H:i:s');

        if (count($id_queja) == 0) {
            $nuevo_id_queja = 1;
            $no_folio = sprintf('%04d', 1);
        } else {
            foreach ($id_queja as $nuevo) {
                $nuevo_id_queja = (int) $nuevo['id'] + 1;
                $no_folio = sprintf('%04d', (int) $nuevo['id'] + 1);
            }
        }

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int) $nuevo['contador'] + 1;
                $no_folio1 = sprintf('%04d', (int) $nuevo['contador'] + 1);
            }
        }

        $year = date("Y");
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-Q';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-Q';
        $carpeta = 'uploads/quejas_publicas/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);

        $query = "INSERT INTO quejas_dates_public (folio_queja_p, fecha_creacion, nombre, paterno, materno, genero,edad, cat_escolaridad, cat_ocupacion, grupo_vulnerable, cat_nacionalidad,
                                correo, telefono, calle, numero, colonia, codigo_postal, descripcion_hechos, entidad, municipio, localidad, autoridad_responsable, archivo) 
                    VALUES ('$folio','{$fecha_creacion}','{$nombre}','{$paterno}','{$materno}','{$genero}','{$edad}','{$cat_escolaridad}','{$cat_ocupacion}','{$grupo_vulnerable}',
                            '{$cat_nacionalidad}','{$correo}','{$telefono}','$calle','{$numero}','$colonia','$codigo_postal','{$descripcion_hechos}','{$entidad}','{$municipio}',
                            '{$localidad}','{$autoridad_responsable}','{$name}')";

        $query3 = "INSERT INTO folios (";
        $query3 .= "folio, contador";
        $query3 .= ") VALUES (";
        $query3 .= " '{$folio}','{$no_folio1}'";
        $query3 .= ")";

        if ($db->query($query) && $db->query($query3)) {
            //sucess
            $session->msg('s', " Su queja ha sido agregada con éxito.");
            redirect('add_queja_publica.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar su queja. Vuelva a intentarlo.');
            redirect('add_queja_publica.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_queja_publica.php', false);
    }
}
?>
<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default" style="margin-left: -10%; margin-top: -6%;">
        <div class="panel-heading" style="margin-bottom: -25px">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Registrar Queja</span>
            </strong>
        </div>
        <div class="panel-body">
            <strong>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="25px" height="25px" fill="#7263F0">
                    <title>comment-text-multiple-outline</title>
                    <path d="M12,23A1,1 0 0,1 11,22V19H7A2,2 0 0,1 5,17V7A2,2 0 0,1 7,5H21A2,2 0 0,1 23,7V17A2,2 0 0,1 21,19H16.9L13.2,22.71C13,22.89 12.76,23 12.5,23H12M13,17V20.08L16.08,17H21V7H7V17H13M3,15H1V3A2,2 0 0,1 3,1H19V3H3V15M9,9H19V11H9V9M9,13H17V15H9V13Z" />
                </svg>
                <span style="font-size: 20px; color: #7263F0">HECHOS OCURRIDOS</span>
            </strong>
            <form method="post" action="add_queja_publica.php" enctype="multipart/form-data">
                <div class="row" style="margin-top: 10px;">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="descripcion_hechos">Descripción de los hechos</label>
                            <textarea class="form-control" name="descripcion_hechos" id="descripcion_hechos" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="entidad">Entidad Federativa</label>
                            <select class="form-control" name="entidad" required>
                                <option value="">Escoge una opción</option>
                                <option value="Michoacán">Michoacán</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="municipio">Municipio</label>
                            <select class="form-control" name="municipio">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_municipios as $id_cat_municipio) : ?>
                                    <option value="<?php echo $id_cat_municipio['id_cat_mun']; ?>"><?php echo ucwords($id_cat_municipio['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <input type="text" class="form-control" name="localidad" placeholder="Localidad" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad Responsable</label>
                            <select class="form-control" name="autoridad_responsable">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_autoridades as $autoridades) : ?>
                                    <option value="<?php echo $autoridades['id_cat_aut']; ?>"><?php echo ucwords($autoridades['nombre_autoridad']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 10px">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto (si es necesario)</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                </div>
                <strong>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="margin-top:-0.3%;" width="25px" height="25px" fill="#7263F0">
                        <title>account</title>
                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z" />
                    </svg>
                    <span style="font-size: 20px; color: #7263F0">DATOS QUEJOSO</span>
                </strong><br><br>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="paterno">Apellido Paterno</label>
                            <input type="text" class="form-control" name="paterno" placeholder="Apellido Paterno" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="materno">Apellido Materno</label>
                            <input type="text" class="form-control" name="materno" placeholder="Apellido Materno" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="genero">Género</label>
                            <select class="form-control" name="genero">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($generos as $genero) : ?>
                                    <option value="<?php echo $genero['id_cat_gen']; ?>"><?php echo ucwords($genero['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" min="1" max="130" maxlength="4" name="edad" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="cat_escolaridad">Escolaridad</label>
                            <select class="form-control" name="cat_escolaridad">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($escolaridades as $escolaridad) : ?>
                                    <option value="<?php echo $escolaridad['id_cat_escolaridad']; ?>"><?php echo ucwords($escolaridad['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cat_ocupacion">Ocupación</label>
                            <select class="form-control" name="cat_ocupacion">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($ocupaciones as $ocupacion) : ?>
                                    <option value="<?php echo $ocupacion['id_cat_ocup']; ?>"><?php echo ucwords($ocupacion['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($grupos_vuln as $grupo_vuln) : ?>
                                    <option value="<?php echo $grupo_vuln['id_cat_grupo_vuln']; ?>"><?php echo ucwords($grupo_vuln['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="cat_nacionalidad">Nacionalidad</label>
                            <select class="form-control" name="cat_nacionalidad">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($nacionalidades as $nacionalidad) : ?>
                                    <option value="<?php echo $nacionalidad['id_cat_nacionalidad']; ?>"><?php echo ucwords($nacionalidad['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" maxlength="10" name="telefono">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="correo">Email</label>
                            <input type="text" class="form-control" name="correo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle"> Calle</label>
                            <input type="text" class="form-control" name="calle">
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="numero">Núm.</label>
                            <input type="text" class="form-control" name="numero">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="codigo_postal">código Postal</label>
                            <input type="text" class="form-control" name="codigo_postal">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="quejas_publicas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button style="background: #300285; border-color:#300285;" type="submit" name="add_queja_publica" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Acción de Vinculación';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id_user'];
$id_folio = last_id_folios_general();
$nivel_user = $user['user_level'];
if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 3) {
    page_require_level(3);
}
if ($nivel_user == 4) {
    redirect('home.php');
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 6) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    redirect('home.php');
}
//page_require_area(4);
$id_user = $user['id_user'];
$busca_area = area_usuario($id_user);
$otro = $busca_area['id_area'];
$cat_autoridades = find_all_aut_res();

?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_accionV'])) {
    // Contamos la cantidad de imagenes
    $countfiles = count($_FILES['files']['name']);

    if (empty($errors)) {
        $fecha   = remove_junk($db->escape($_POST['fecha']));
        $lugar   = remove_junk($db->escape($_POST['lugar']));
        $nombre_actividad   = remove_junk($db->escape($_POST['nombre_actividad']));
        $descripcion   = remove_junk($db->escape($_POST['descripcion']));
        $participantes   = remove_junk($db->escape($_POST['participantes']));
        $inst_procedencia   = remove_junk($db->escape($_POST['inst_procedencia']));
        $modalidad   = remove_junk($db->escape($_POST['modalidad']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        date_default_timezone_set('America/Mexico_City');
        $creacion = date('Y-m-d');

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['contador'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['contador'] + 1);
            }
        }
        // Se crea el número de folio
        $year = date("Y");
        // Se crea el folio de convenio
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-AV';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-AV';
        $carpeta = 'uploads/accionesVinc/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        // Generamos el bucle de todos los archivos
        for ($i = 0; $i < $countfiles; $i++) {

            // Extraemos en variable el nombre de archivo
            $filename = $_FILES['files']['name'][$i];

            // Designamos la carpeta de subida
            $target_file = 'uploads/accionesVinc/' . $folio_carpeta . '/' . $filename;

            // Obtenemos la extension del archivo
            $file_extension = pathinfo($target_file, PATHINFO_EXTENSION);

            $file_extension = strtolower($file_extension);

            // Validamos la extensión de la imagen
            $valid_extension = array("png", "jpeg", "jpg");

            if (in_array($file_extension, $valid_extension)) {

                // Subimos la imagen al servidor
                move_uploaded_file($_FILES['files']['tmp_name'][$i], $target_file);
            }
        }

        $query = "INSERT INTO acciones_vinculacion (";
        $query .= "folio, fecha, lugar, nombre_actividad, descripcion, participantes, inst_procedencia, modalidad, observaciones, carpeta, creador, fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$fecha}','{$lugar}','{$nombre_actividad}','{$descripcion}','{$participantes}','{$inst_procedencia}','{$modalidad}',
                    '{$observaciones}','{$carpeta}','{$id_user}','{$creacion}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La acción de vinculación ha sido agregada con éxito.");
            redirect('acciones_vinculacion.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la acción de vinculación.');
            redirect('add_accionV.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_accionV.php', false);
    }
}
?>
<?php header('Content-type: text/html; charset=utf-8');
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Agregar Acción de Vinculación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_accionV.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha de la Actividad</label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lugar">Lugar de la Actividad</label>
                            <input type="text" class="form-control" name="lugar" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_actividad">Nombre de la Actividad</label>
                            <input type="text" class="form-control" name="nombre_actividad" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="participantes">Participantes</label>
                            <textarea class="form-control" name="participantes" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inst_procedencia">Institución de Procedencia</label>
                            <select class="form-control form-select" name="inst_procedencia" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_autoridades as $autoridades) : ?>
                                    <option value="<?php echo $autoridades['id_cat_aut']; ?>"><?php echo ucwords($autoridades['nombre_autoridad']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="modalidad">Modalidad</label>
                            <select class="form-control" name="modalidad">
                                <option value="">Escoge una opción</option>
                                <option value="Virtual">Virtual</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="files">Evidencia Fotográfica</label>
                            <input type='file' class="custom-file-input form-control" id="inputGroupFile01" name='files[]' multiple />
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="acciones_vinculacion.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_accionV" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
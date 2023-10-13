<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Sesión de COTRAPEM';
require_once('includes/load.php');
$user = current_user();
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
$id_user = $user['id_user'];

?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_sesionCotrapem'])) {
    // Contamos la cantidad de imagenes
    $countfiles = count($_FILES['files']['name']);

    if (empty($errors)) {
        $fecha   = remove_junk($db->escape($_POST['fecha']));
        $lugar   = remove_junk($db->escape($_POST['lugar']));
        $acuerdos   = remove_junk($db->escape($_POST['acuerdos']));
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
        
        $year = date("Y");
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-SCPM';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-SCPM';
        $carpeta = 'uploads/sesionCotrapem/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        // Generamos el bucle de todos los archivos
        for ($i = 0; $i < $countfiles; $i++) {

            // Extraemos en variable el nombre de archivo
            $filename = $_FILES['files']['name'][$i];

            // Designamos la carpeta de subida
            $target_file = 'uploads/sesionCotrapem/' . $folio_carpeta . '/' . $filename;

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

        $query = "INSERT INTO cotrapem (";
        $query .= "folio, fecha, lugar, acuerdos, carpeta, id_creador, fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$fecha}','{$lugar}','{$acuerdos}','{$carpeta}','{$id_user}','{$creacion}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " La sesión de COTRAPEM ha sido agregada con éxito.");
            redirect('cotrapem.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la sesión de COTRAPEM.');
            redirect('add_sesionCotrapem.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_sesionCotrapem.php', false);
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
                <span>Agregar Sesión de COTRAPEM</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_sesionCotrapem.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha de la Sesión</label>
                            <input type="date" class="form-control" name="fecha" required>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar">Lugar de la Sesión</label>
                            <input type="text" class="form-control" name="lugar" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="acuerdos">Acuerdos</label>
                            <textarea class="form-control" name="acuerdos" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-3">
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
                    <button type="submit" name="add_sesionCotrapem" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
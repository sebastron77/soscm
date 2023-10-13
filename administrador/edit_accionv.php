<?php
$page_title = 'Editar Acción de Vinculación';
require_once('includes/load.php');

$user = current_user();
$detalle = $user['id_user'];
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
$cat_autoridades = find_all_aut_res();
$accionV = find_by_accionV((int)$_GET['id']);
if (!$accionV) {
    $session->msg("d", "id de jornada no encontrado.");
    redirect('acciones_vinculacion.php');
}
?>
<?php
if (isset($_POST['edit_accionV'])) {
    $countfiles = count($_FILES['files']['name']);
    if (empty($errors)) {
        $id = (int)$accionV['id_accionV'];
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

        $folio_editar = $accionV['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/accionesVinc/' . $resultado;

        // Generamos el bucle de todos los archivos
        for ($i = 0; $i < $countfiles; $i++) {

            // Extraemos en variable el nombre de archivo
            $filename = $_FILES['files']['name'][$i];

            // Designamos la carpeta de subida
            $target_file = 'uploads/accionesVinc/' . $resultado . '/' . $filename;

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

        $sql = "UPDATE acciones_vinculacion SET fecha='{$fecha}', lugar='{$lugar}', nombre_actividad='{$nombre_actividad}', descripcion='{$descripcion}',
                participantes='{$participantes}', inst_procedencia='{$inst_procedencia}', modalidad='{$modalidad}', observaciones='{$observaciones}'
                WHERE id_accionV={$db->escape($id)}";

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('acciones_vinculacion.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('acciones_vinculacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_accionV.php?id=' . (int)$accionV['id_accionV'], false);
    }
}
?>
<?php
include_once('layouts/header.php'); ?>
<?php echo display_msg($msg); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar Acción de Vinculación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_accionV.php?id=<?php echo (int)$accionV['id_accionV']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha de la Actividad</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo $accionV['fecha'] ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="lugar">Lugar de la Actividad</label>
                            <input type="text" class="form-control" name="lugar" value="<?php echo $accionV['lugar'] ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="nombre_actividad">Nombre de la Actividad</label>
                            <input type="text" class="form-control" name="nombre_actividad" value="<?php echo $accionV['nombre_actividad'] ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="descripcion">Descripción</label>
                            <textarea class="form-control" name="descripcion" cols="10" rows="3"><?php echo $accionV['descripcion'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="participantes">Participantes</label>
                            <textarea class="form-control" name="participantes" cols="10" rows="3"><?php echo $accionV['participantes'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="inst_procedencia">Institución de Procedencia</label>
                            <select class="form-control" name="inst_procedencia">
                                <?php foreach ($cat_autoridades as $autoridad) : ?>
                                    <option <?php if ($autoridad['id_cat_aut'] == $accionV['inst_procedencia']) echo 'selected="selected"'; ?> value="<?php echo $autoridad['id_cat_aut']; ?>"><?php echo ucwords($autoridad['nombre_autoridad']); ?></option>
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
                                <option <?php if ($accionV['modalidad'] == 'Virtual') echo 'selected="selected"'; ?> value="Virtual">Virtual</option>
                                <option <?php if ($accionV['modalidad'] == 'Presencial') echo 'selected="selected"'; ?> value="Presencial">Presencial</option>
                                <option <?php if ($accionV['modalidad'] == 'Híbrido') echo 'selected="selected"'; ?> value="Híbrido">Híbrido</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" cols="10" rows="3"><?php echo $accionV['observaciones'] ?></textarea>
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
                    <button type="submit" name="edit_accionV" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
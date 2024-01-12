<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Evento';
require_once('includes/load.php');

page_require_level(2);
$user = current_user();
$id_user = $user['id_user'];
$oscs = find_all('osc');
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_evento'])) {
    if (empty($errors)) {
        $id_osc = remove_junk($db->escape($_POST['id_osc']));
        $fecha = remove_junk($db->escape($_POST['fecha']));
        $hora = remove_junk($db->escape($_POST['hora']));
        $lugar = remove_junk($db->escape($_POST['lugar']));
        $tema = remove_junk($db->escape($_POST['tema']));
        $creacion = date('Y-m-d');

        $query = "INSERT INTO eventos (";
        $query .= "id_osc, fecha, hora, lugar, tema, id_creador, fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$id_osc}', '{$fecha}', '{$hora}', '{$lugar}', '{$tema}', '{$id_user}', '{$creacion}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', " El evento ha sido agregado con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó el evento: ' . $tema . '.', 1);
            redirect('eventos.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el evento.');
            redirect('add_evento.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_evento.php', false);
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
                <span>Agregar OSC</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_evento.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_osc">OSC</label>
                            <select class="form-control" name="id_osc" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($oscs as $osc) : ?>
                                    <option value="<?php echo $osc['id_osc']; ?>"><?php echo ucwords($osc['nombre']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input class="form-control" type="date" name="fecha" id="fecha">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input class="form-control" type="time" name="hora" id="hora">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input class="form-control" type="text" name="lugar" id="lugar">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tema">Tema</label>
                            <textarea class="form-control" name="tema" id="tema" cols="10" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <a href="eventos.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a>
                <button type="submit" name="add_evento" class="btn btn-primary">Guardar</button>
        </div>
        </form>
    </div>
</div>
</div>
<?php include_once('layouts/footer.php'); ?>
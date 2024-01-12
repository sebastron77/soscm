<?php
$page_title = 'Editar Evento';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$e_evento = evento_id((int)$_GET['id']);
$oscs = find_all('osc');

page_require_level(2);

if (!$e_evento) {
    $session->msg("d", "id de evento no encontrado.");
    redirect('eventos.php');
}
?>
<?php
if (isset($_POST['edit_evento'])) {
    if (empty($errors)) {
        $id = (int)$e_evento['id_evento'];
        $id_osc = remove_junk($db->escape($_POST['id_osc']));
        $fecha = remove_junk($db->escape($_POST['fecha']));
        $hora = remove_junk($db->escape($_POST['hora']));
        $lugar = remove_junk($db->escape($_POST['lugar']));
        $tema = remove_junk($db->escape($_POST['tema']));

        $sql = "UPDATE eventos SET id_osc='{$id_osc}', fecha='{$fecha}', hora='{$hora}', lugar='{$lugar}', tema='{$tema}' WHERE id_evento='{$db->escape($id)}'";

        $result = $db->query($sql);
        if (($result && $db->affected_rows() === 1) || ($result && $db->affected_rows() === 0)) {
            $session->msg('s', "Información del evento Actualizada ");
            insertAccion($user['id_user'], '"' . $user['username'] . '" editó el evento: ' . $tema . '.', 2);
            redirect('eventos.php', false);
        } else {
            $session->msg('d', ' Lo sentimos, no se actualizó la información del evento.');
            redirect('eventos.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_evento.php?id=' . (int)$e_evento['id_evento'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar Evento</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_evento.php?id=<?php echo $e_evento['id_evento']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_osc">OSC</label>
                            <select class="form-control" name="id_osc" required>
                                <?php foreach ($oscs as $osc) : ?>
                                    <option <?php if ($osc['id_osc'] == $e_evento['id_osc']) echo 'selected="selected"'; ?> value="<?php echo $osc['id_osc']; ?>"><?php echo ucwords($osc['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input class="form-control" type="date" name="fecha" id="fecha" value="<?php echo $e_evento['fecha']; ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input class="form-control" type="time" name="hora" id="hora" value="<?php echo $e_evento['hora']; ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input class="form-control" type="text" name="lugar" id="lugar" value="<?php echo $e_evento['lugar']; ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tema">Tema</label>
                            <textarea class="form-control" name="tema" id="tema" cols="10" rows="5"><?php echo $e_evento['lugar']; ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="eventos.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_evento" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
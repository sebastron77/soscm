<?php
$page_title = 'Editar Noticia';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$e_noticia = noticia_by_id((int)$_GET['id']);
$oscs = find_all('osc');

page_require_level(1);

if (!$e_noticia) {
    $session->msg("d", "id de Noticia no encontrado.");
    redirect('osc.php');
}
?>
<?php
if (isset($_POST['edit_noticia'])) {
    $countfiles = count($_FILES['logo']['name']);
    if (empty($errors)) {
        $id = (int)$e_noticia['id_noticia'];
        $id_osc = remove_junk($db->escape($_POST['id_osc']));
        $fecha = remove_junk($db->escape($_POST['fecha']));
        $titulo_noticia = remove_junk($db->escape($_POST['titulo_noticia']));
        $noticia = remove_junk($db->escape($_POST['noticia']));
        $imagen = remove_junk($db->escape($_POST['imagen']));

        $titulo_noticia2 = str_replace(' ', '', $titulo_noticia);
        $carpeta = 'uploads/noticias/' . $id;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['imagen']['name'];
        $size = $_FILES['imagen']['size'];
        $type = $_FILES['imagen']['type'];
        $temp = $_FILES['imagen']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);
        
        if ($_FILES['imagen']['name'][0] != '') {
            $sql = "UPDATE noticias SET id_osc='{$id_osc}', fecha='{$fecha}', titulo_noticia='{$titulo_noticia}', noticia='{$noticia}', imagen='{$name}'
                WHERE id_noticia='{$db->escape($id)}'";
        }
        if ($_FILES['imagen']['name'][0] == '') {
            $sql = "UPDATE noticias SET id_osc='{$id_osc}', fecha='{$fecha}', titulo_noticia='{$titulo_noticia}', noticia='{$noticia}'
                WHERE id_noticia='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if (($result && $db->affected_rows() === 1) || ($result && $db->affected_rows() === 0)) {
            $session->msg('s', "Información Actualizada ");
            redirect('noticias.php', false);
        } else {
            $session->msg('d', ' Lo sentimos, no se actualizó la información.');
            redirect('noticias.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_noticia.php?id=' . (int)$e_noticia['id_noticia'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar Noticia</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_noticia.php?id=<?php echo $e_noticia['id_noticia']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="id_osc">OSC</label>
                            <select class="form-control" name="id_osc" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($oscs as $osc) : ?>
                                    <option <?php if ($osc['id_osc'] == $e_noticia['id_osc']) echo 'selected="selected"'; ?> value="<?php echo $osc['id_osc']; ?>"><?php echo ucwords($osc['nombre']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha">Fecha</label>
                            <input type="date" class="form-control" name="fecha" value="<?php echo $e_noticia['fecha']; ?>">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="titulo_noticia">Título de Noticia</label>
                            <input type='text' class="form-control" name='titulo_noticia' value="<?php echo $e_noticia['titulo_noticia'] ?>" />
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="noticia">Noticia</label>
                            <textarea class="form-control" name="noticia" id="noticia" cols="20" rows="10"><?php echo $e_noticia['noticia'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="imagen">Adjuntar Imágen</label>
                            <input type='file' class="form-control" id="imagen" name='imagen' value="<?php echo $e_noticia['imagen']; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="noticias.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_noticia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
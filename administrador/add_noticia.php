<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Noticia';
require_once('includes/load.php');

page_require_level(1);
$user = current_user();
$id_user = $user['id_user'];
$oscs = find_all('osc');
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_noticia'])) {
    $countfiles = count($_FILES['imagen']['name']);
    if (empty($errors)) {
        $id_osc = remove_junk($db->escape($_POST['id_osc']));
        $fecha = remove_junk($db->escape($_POST['fecha']));
        $titulo_noticia = remove_junk($db->escape($_POST['titulo_noticia']));
        $noticia = remove_junk($db->escape($_POST['noticia']));
        $imagen = remove_junk($db->escape($_POST['imagen']));
        $creacion = date('Y-m-d');

        $titulo_noticia2 = str_replace(' ', '', $titulo_noticia);
        $carpeta = 'uploads/noticias/' . $titulo_noticia2;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['imagen']['name'];
        $size = $_FILES['imagen']['size'];
        $type = $_FILES['imagen']['type'];
        $temp = $_FILES['imagen']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);

        $query = "INSERT INTO noticias (";
        $query .= "id_osc, fecha, titulo_noticia, noticia, imagen, id_creador, fecha_creacion";
        $query .= ") VALUES (";
        $query .= " '{$id_osc}','{$fecha}','{$titulo_noticia}','{$noticia}','{$name}','{$id_user}','{$creacion}'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', " La noticia ha sido agregada con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó la noticia: ' . $titulo_noticia . '.', 1);
            redirect('noticias.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la noticia.');
            redirect('add_noticia.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_noticia.php', false);
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
                <span>Agregar Noticia</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_noticia.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-5">
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
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="titulo_noticia">Título de Noticia</label>
                            <input class="form-control" type="text" name="titulo_noticia" id="titulo_noticia">
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="form-group">
                            <label for="noticia">Noticia</label>
                            <textarea class="form-control" name="noticia" id="noticia" cols="20" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="imagen">Adjuntar Imágen</label>
                            <input type='file' class="form-control" id="imagen" name='imagen' />
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="noticias.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_noticia" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
    <?php include_once('layouts/footer.php'); ?>
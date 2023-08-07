<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Recomendación';
require_once('includes/load.php');
$id_folio_acuerdo = last_id_folios();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    redirect('home.php');
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['add_recomendacion'])) {

    $req_fields = array('servidor_publico', 'fecha_recomendacion', 'observaciones');
    validate_fields($req_fields);

    if (empty($errors)) {
        $numero_recomendacion   = remove_junk($db->escape($_POST['numero_recomendacion']));
        $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_recomendacion']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $acuerdo_adjunto   = remove_junk(($db->escape($_POST['recomendacion_adjunto'])));

        //Se crea el número de folio
        $year = date("Y");
        $folio_carpeta = str_replace("/", "-", $numero_recomendacion);
        $carpeta = 'uploads/recomendaciones/' . $folio_carpeta . '/';

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['recomendacion_adjunto']['name'];
        $size = $_FILES['recomendacion_adjunto']['size'];
        $type = $_FILES['recomendacion_adjunto']['type'];
        $temp = $_FILES['recomendacion_adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['recomendacion_adjunto_publico']['name'];
        $size2 = $_FILES['recomendacion_adjunto_publico']['size'];
        $type2 = $_FILES['recomendacion_adjunto_publico']['type'];
        $temp2 = $_FILES['recomendacion_adjunto_publico']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        $nameRecSint = $_FILES['sintesis_rec']['name'];
        $sizeRecSint = $_FILES['sintesis_rec']['size'];
        $typeRecSint = $_FILES['sintesis_rec']['type'];
        $tempRecSint = $_FILES['sintesis_rec']['tmp_name'];

        $nameRecTrad = $_FILES['traduccion']['name'];
        $sizeRecTrad = $_FILES['traduccion']['size'];
        $typeRecTrad = $_FILES['traduccion']['type'];
        $tempRecTrad = $_FILES['traduccion']['tmp_name'];

        $nameRecLF = $_FILES['lectura_facil']['name'];
        $sizeRecLF = $_FILES['lectura_facil']['size'];
        $typeRecLF = $_FILES['lectura_facil']['type'];
        $tempRecLF = $_FILES['lectura_facil']['tmp_name'];

        $move3 =  move_uploaded_file($tempRecSint, $carpeta . "/" . $nameRecSint);
        $move4 =  move_uploaded_file($tempRecTrad, $carpeta . "/" . $nameRecTrad);
        $move5 =  move_uploaded_file($tempRecLF, $carpeta . "/" . $nameRecLF);

        if ($move && $name != '') {
            $query = "INSERT INTO recomendaciones (";
            $query .= "numero_recomendacion,folio_queja,servidor_publico,fecha_recomendacion,observaciones,recomendacion_adjunto,recomendacion_adjunto_publico,sintesis_rec,traduccion,lectura_facil";
            $query .= ") VALUES (";
            $query .= " '{$numero_recomendacion}','{$folio_queja}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}','{$name}','{$name2}','{$nameRecSint}','{$nameRecTrad}','{$nameRecLF}'";
            $query .= ")";
        } else {
            $query = "INSERT INTO recomendaciones (";
            $query .= "numero_recomendacion,folio_queja,servidor_publico,fecha_recomendacion,observaciones,sintesis_rec,traduccion,lectura_facil";
            $query .= ") VALUES (";
            $query .= " '{$numero_recomendacion}','{$folio_queja}','{$servidor_publico}','{$fecha_acuerdo}','{$observaciones}','{$nameRecSint}','{$nameRecTrad}','{$nameRecLF}'";
            $query .= ")";
        }
        if ($db->query($query)) {
            $session->msg('s', " La recomendación ha sido agregada con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó recomendación, Núm. Rec.: ' . $numero_recomendacion . '.', 1);
            redirect('recomendaciones_antes.php', false);
        } else {
            $session->msg('d', ' No se pudo agregar la recomendación.');
            redirect('add_recomendacion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_recomendacion.php', false);
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
                <span>Agregar Recomendación</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_recomendacion.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="folio_queja">Folio de Queja</label>
                            <input type="text" class="form-control" name="folio_queja">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="numero_recomendacion">Núm. Recomendación</label>
                            <input type="text" class="form-control" name="numero_recomendacion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" placeholder="Nombre Completo" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_recomendacion">Fecha de Recomendación</label><br>
                            <input type="date" class="form-control" name="fecha_recomendacion">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto">Adjuntar Recomendación</label>
                                <input id="recomendacion_adjunto" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto">
                            </span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto_publico">Adjuntar Recomendación Versión Pública</label>
                                <input id="recomendacion_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto_publico">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="sintesis_rec">Adjuntar Síntesis</label>
                                <input id="sintesis_rec" type="file" accept="application/pdf" class="form-control" name="sintesis_rec">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="traduccion">Adjuntar Traducción</label>
                                <input id="traduccion" type="file" accept="application/pdf" class="form-control" name="traduccion">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="lectura_facil">Adjuntar Lectura Fácil</label>
                                <input id="lectura_facil" type="file" accept="application/pdf" class="form-control" name="lectura_facil">
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="form-group clearfix">
                    <a href="recomendaciones_antes.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_recomendacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
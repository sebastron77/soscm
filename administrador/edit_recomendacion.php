<?php
$page_title = 'Editar Recomendación';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_recomendacion = find_by_id('recomendaciones', (int)$_GET['id'], 'id_recomendacion');
if (!$e_recomendacion) {
    $session->msg("d", "id de recomendación no encontrado.");
    redirect('recomendaciones.php');
}
$user = current_user();
$nivel = $user['user_level'];
$nivel_user = $user['user_level'];
$id_user = $user['id_user'];

if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
?>

<?php
if (isset($_POST['edit_recomendacion'])) {
    $req_fields = array('servidor_publico', 'fecha_acuerdo', 'observaciones');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_recomendacion['id_recomendacion'];
        $numero_recomendacion   = remove_junk($db->escape($_POST['numero_recomendacion']));
        $folio_queja   = remove_junk($db->escape($_POST['folio_queja']));
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_acuerdo']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $recomendacion_adjunto   = remove_junk(($db->escape($_POST['recomendacion_adjunto'])));

        $folio_editar = $e_recomendacion['numero_recomendacion'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/recomendaciones/' . $resultado;

        $folio_editar2 = $e_recomendacion['numero_recomendacion'];
        $resultado2 = str_replace("/", "-", $folio_editar2);
        $carpeta2 = 'uploads/recomendaciones/' . $resultado2;

        $name = $_FILES['recomendacion_adjunto']['name'];
        $size = $_FILES['recomendacion_adjunto']['size'];
        $type = $_FILES['recomendacion_adjunto']['type'];
        $temp = $_FILES['recomendacion_adjunto']['tmp_name'];

        $verifica = substr($e_recomendacion['folio_recomendacion'], 0, 4);
        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if ($verifica == 'CEDH') {
            if (is_dir($carpeta)) {
                $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            } else {
                mkdir($carpeta, 0777, true);
                $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
            }
        } elseif ($verifica != 'CEDH') {
            if (is_dir($carpeta2)) {
                $move =  move_uploaded_file($temp, $carpeta2 . "/" . $name);
            } else {
                mkdir($carpeta2, 0777, true);
                $move =  move_uploaded_file($temp, $carpeta2 . "/" . $name);
            }
        }

        $name2 = $_FILES['recomendacion_adjunto_publico']['name'];
        $size = $_FILES['recomendacion_adjunto_publico']['size'];
        $type = $_FILES['recomendacion_adjunto_publico']['type'];
        $temp = $_FILES['recomendacion_adjunto_publico']['tmp_name'];

        $verifica = substr($e_recomendacion['folio_recomendacion'], 0, 4);

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if ($verifica == 'CEDH') {
            if (is_dir($carpeta)) {
                $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
            } else {
                mkdir($carpeta, 0777, true);
                $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
            }
        } elseif ($verifica != 'CEDH') {
            if (is_dir($carpeta2)) {
                $move =  move_uploaded_file($temp, $carpeta2 . "/" . $name2);
            } else {
                mkdir($carpeta2, 0777, true);
                $move =  move_uploaded_file($temp, $carpeta2 . "/" . $name2);
            }
        }

        if ($name != '' && $name2 != '') {
            $sql = "UPDATE recomendaciones SET folio_queja='{$folio_queja}', numero_recomendacion='{$numero_recomendacion}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto='{$name}', recomendacion_adjunto_publico='{$name2}' WHERE id_recomendacion='{$db->escape($id)}'";
        }

        if ($name != '' && $name2 == '') {
            $sql = "UPDATE recomendaciones SET folio_queja='{$folio_queja}', numero_recomendacion='{$numero_recomendacion}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto='{$name}' WHERE id_recomendacion='{$db->escape($id)}'";
        }

        if ($name == '' && $name2 != '') {
            $sql = "UPDATE recomendaciones SET folio_queja='{$folio_queja}', numero_recomendacion='{$numero_recomendacion}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto_publico='{$name2}' WHERE id_recomendacion='{$db->escape($id)}'";
        }

        if ($name == '' && $name2 == '') {
            $sql = "UPDATE recomendaciones SET folio_queja='{$folio_queja}', numero_recomendacion='{$numero_recomendacion}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}' WHERE id_recomendacion='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            insertAccion($user['id_user'], '"' . $user['username'] . '" editó recomendación, Num. Rec.: ' . $numero_recomendacion . '.', 2);
            redirect('recomendaciones_antes.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_recomendacion.php?id=' . (int)$e_recomendacion['id_recomendacion'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_recomendacion.php?id=' . (int)$e_recomendacion['id_recomendacion'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar recomendación <?php echo $e_recomendacion['numero_recomendacion']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_recomendacion.php?id=<?php echo (int)$e_recomendacion['id_recomendacion']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="folio_queja">Folio de Queja</label>
                            <input type="text" class="form-control" name="folio_queja" value="<?php echo remove_junk($e_recomendacion['folio_queja']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="numero_recomendacion">Num. Recomendación</label>
                            <input type="text" class="form-control" name="numero_recomendacion" value="<?php echo remove_junk($e_recomendacion['numero_recomendacion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" value="<?php echo remove_junk($e_recomendacion['servidor_publico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_acuerdo">Fecha de Recomendación</label><br>
                            <input type="date" class="form-control" name="fecha_acuerdo" value="<?php echo remove_junk($e_recomendacion['fecha_recomendacion']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto">Recomendación Adjunto</label>
                                <input id="recomendacion_adjunto" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_recomendacion['recomendacion_adjunto']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto_publico">Recomendación Pública Adjunto</label>
                                <input id="recomendacion_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto_publico">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_recomendacion['recomendacion_adjunto_publico']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1" value="<?php echo remove_junk($e_recomendacion['observaciones']); ?>"><?php echo remove_junk($e_recomendacion['observaciones']); ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="recomendaciones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_recomendacion" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
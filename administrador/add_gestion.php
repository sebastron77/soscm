<?php
$page_title = 'Agregar gestión';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$id_folio = last_id_folios();

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    redirect('home.php');
}
if ($nivel_user == 7) {
    page_require_level(7);
}
if ($nivel_user == 21) {
    page_require_level_exacto(21);
}
if ($nivel_user == 19) {
    redirect('home.php');
}
if ($nivel_user > 2 && $nivel_user < 5) :
    redirect('home.php');
endif;
if ($nivel_user > 5 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
if ($nivel_user > 19 && $nivel_user < 21) :
    redirect('home.php');
endif;
?>
<?php
if (isset($_POST['add_gestion'])) {

    if (empty($errors)) {
        $tipo_gestion = remove_junk($db->escape($_POST['tipo_gestion']));
        $descripcion = remove_junk($db->escape($_POST['descripcion']));
        $observaciones = remove_junk($db->escape($_POST['observaciones']));
        date_default_timezone_set('America/Mexico_City');
        $fecha_subida = date('Y-m-d H:i:s');

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
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-GESTJ';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-GESTJ';
        $carpeta = 'uploads/gestiones/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $dbh = new PDO('mysql:host=localhost;dbname=libroquejas2', 'root', '');

        $query = "INSERT INTO gestiones_jurisdiccionales (";
        $query .= "folio,tipo_gestion, descripcion, documento, observaciones, fecha_subida";
        $query .= ") VALUES (";
        $query .= " '{$folio}','{$tipo_gestion}','{$descripcion}','{$name}','{$observaciones}','{$fecha_subida}'";
        $query .= ")";

        $query2 = "INSERT INTO folios (";
        $query2 .= "folio, contador";
        $query2 .= ") VALUES (";
        $query2 .= " '{$folio}','{$no_folio1}'";
        $query2 .= ")";
        // $dbh->exec($queryInsert3);

        //------------------BUSCA EL ID INSERTADO------------------
        $dbh->exec($query);
        $id_insertado = $dbh->lastInsertId();
        echo "AAAAAAAAAAAAA: " . $id_insertado;
        

        // $dbh = null;
        $dbh = null;       

        $query = "UPDATE gestiones_jurisdiccionales SET documento = '$name' WHERE id_gestion = '$id_insertado'";
        // $dbh->exec($queryUpdate);
        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', "Registro creado con éxito");
            insertAccion($user['id_user'], '"'.$user['username'].'" agregó registro en gestiones, Folio: '.$folio.'.', 1);
            redirect('add_gestion.php', false);
        } else {
            //failed
            $session->msg('d', 'Desafortunadamente no se pudo crear el registro.');
            redirect('add_gestion.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_gestion.php', false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page3">
    <div class="text-center">
        <h3 style="margin-top: 20px; margin-bottom: 30px;">Agregar nuevo registro</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="add_gestion.php" class="clearfix" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tipo_gestion" class="control-label">Tipo de Gestión Jurisdiccional</label>
            <select class="form-control" name="tipo_gestion" id="tipo_gestion">
                <option value="">Escoge una opción</option>
                <option value="Acciones de Inconstitucionalidad">Acciones de Inconstitucionalidad</option>
                <option value="Controversias Constitucionales">Controversias Constitucionales</option>
                <option value="Amicus Curiae">Amicus Curiae</option>
                <option value="Otros">Otros</option>
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" cols="10" rows="5"></textarea>
        </div>
        <div class="form-group">
            <label for="adjunto">Documento</label>
            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" name="observaciones" cols="10" rows="5"></textarea>
        </div>
        <div class="form-group clearfix">
            <a href="gestiones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                Regresar
            </a>
            <button type="submit" name="add_gestion" class="btn btn-info">Guardar</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
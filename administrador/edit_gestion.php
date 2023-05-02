<?php
$page_title = 'Editar Gestión';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) :
    page_require_level(2);
endif;
if ($nivel_user == 7) :
    page_require_level_exacto(7);
endif;
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7) :
    redirect('home.php');
endif;
?>
<?php
$e_detalle = find_by_id('gestiones_jurisdiccionales', (int) $_GET['id'], 'id_gestion');
if (!$e_detalle) {
    $session->msg("d", "id de la gestión no encontrado.");
    redirect('gestiones.php');
}
?>
<?php
if (isset($_POST['update'])) {

    if (empty($errors)) {
        $tipo_gestion = remove_junk($db->escape($_POST['tipo_gestion']));
        $descripcion = remove_junk($db->escape($_POST['descripcion']));
        $observaciones = remove_junk($db->escape($_POST['observaciones']));
        date_default_timezone_set('America/Mexico_City');

        $folio_editar = $e_detalle['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/gestiones/' . $e_detalle['folio'] . '/' . $resultado;

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }
        if($name != ''){
            $query = "UPDATE gestiones_jurisdiccionales SET ";
            $query .= "tipo_gestion='{$tipo_gestion}', descripcion='{$descripcion}', documento='{$name}', observaciones='{$observaciones}'";
            $query .= " WHERE id_gestion='{$db->escape($e_detalle['id_gestion'])}'";
        }
        if($name == ''){
            $query2 = "UPDATE gestiones_jurisdiccionales SET ";
            $query2 .= "tipo_gestion='{$tipo_gestion}', descripcion='{$descripcion}', observaciones='{$observaciones}'";
            $query2 .= " WHERE id_gestion='{$db->escape($e_detalle['id_gestion'])}'";
        }
        
        $result = $db->query($query);
        $result2 = $db->query($query2);

        if ($result && $db->affected_rows() === 1) {
            //sucess
            $session->msg('s', "Registro actualizado con éxito. ");
            insertAccion($user['id_user'], '"'.$user['username'].'" editó registro en gestiones, Folio: '.$folio_editar.'.', 1);
            redirect('gestiones.php', false);
        } else {
            //failed
            $session->msg('d', 'Lamentablemente no se ha actualizado el registro!');
            redirect('gestiones.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_gestion.php?id=' . (int) $e_detalle['id_gestion'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="login-page3">
    <div class="text-center">
        <h3>Editar Gestión</h3>
    </div>
    <?php echo display_msg($msg); ?>
    <form method="post" action="edit_gestion.php?id=<?php echo (int) $e_detalle['id_gestion']; ?>" class="clearfix" enctype="multipart/form-data">
        <div class="form-group">
            <label for="tipo_gestion" class="control-label">Tipo de Gestión Jurisdiccional</label>
            <select class="form-control" name="tipo_gestion" id="tipo_gestion">
                <option <?php if ($e_detalle['tipo_gestion'] === 'Acciones de Inconstitucionalidad')
                    echo 'selected="selected"'; ?> value="Acciones de Inconstitucionalidad">Acciones de Inconstitucionalidad
                </option>
                <option <?php if ($e_detalle['tipo_gestion'] === 'Controversias Constitucionales')
                    echo 'selected="selected"'; ?> value="Controversias Constitucionales">Controversias Constitucionales
                </option>
                <option <?php if ($e_detalle['tipo_gestion'] === 'Amicus Curiae')
                    echo 'selected="selected"'; ?>
                    value="Amicus Curiae">Amicus Curiae</option>
                <option <?php if ($e_detalle['tipo_gestion'] === 'Otros')
                    echo 'selected="selected"'; ?> value="Otros">
                    Otros</option>
            </select>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" name="descripcion" cols="10"
                rows="5"><?php echo $e_detalle['descripcion'] ?></textarea>
        </div>
        <div class="form-group">
            <label for="adjunto">Documento</label>
            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto"
                value="uploads/quejas/<?php echo $e_detalle['folio'] . "/" . $e_detalle['adjunto']; ?>">
            <label style="font-size:12px; color:#E3054F;">Archivo Actual:
                <?php echo remove_junk($e_detalle['documento']); ?>
            </label>
        </div>
        <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <textarea class="form-control" name="observaciones" cols="10"
                rows="5"><?php echo $e_detalle['observaciones'] ?></textarea>
        </div>
        <div class="form-group clearfix">
            <a href="gestiones.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                Regresar
            </a>
            <button type="submit" name="update" class="btn btn-info">Actualizar</button>
        </div>
    </form>
</div>

<?php include_once('layouts/footer.php'); ?>
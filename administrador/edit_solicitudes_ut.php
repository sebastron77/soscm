<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Editar Solicitud';
require_once('includes/load.php');


$solicitud = find_by_id('solicitudes_informacion', (int)$_GET['id'], 'id_solicitudes_informacion');
$cat_genero = find_all('cat_genero');
$cat_medio_presentacion = find_all('cat_medio_pres_ut');
$cat_tipo_solicitud = find_all('cat_tipo_solicitud');

$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 10) {
    page_require_level_exacto(10);
}

if ($nivel_user > 3 && $nivel_user < 7) :
    redirect('home.php');
	
endif;if ($nivel_user > 7 && $nivel_user < 10) :
    redirect('home.php');
endif;
if ($nivel_user > 10) :
    redirect('home.php');
endif;
?>
<?php header('Content-type: text/html; charset=utf-8');

if (isset($_POST['edit_solicitudes_ut'])) {

    if (empty($errors)) {
		
		$id = (int)$solicitud['id_solicitudes_informacion'];
        $folio_solicitud = remove_junk($db->escape($_POST['folio_solicitud']));
        $fecha_presentacion   = remove_junk($db->escape($_POST['fecha_presentacion']));
        $nombre_solicitante   = remove_junk($db->escape($_POST['nombre_solicitante']));
        $id_cat_gen   = remove_junk($db->escape($_POST['id_cat_gen']));
        $id_cat_med_pres_ut = remove_junk($db->escape($_POST['id_cat_med_pres_ut']));
        $id_cat_tipo_solicitud   = remove_junk(($db->escape($_POST['id_cat_tipo_solicitud'])));
        $informacion_solicitada   = remove_junk(($db->escape($_POST['informacion_solicitada'])));
		
		
        
            $sql = "UPDATE solicitudes_informacion SET 
			folio_solicitud='{$folio_solicitud}', 
			fecha_presentacion='{$fecha_presentacion}', 
			nombre_solicitante='{$nombre_solicitante}', 
			id_cat_gen='{$id_cat_gen}',  
			id_cat_med_pres_ut='{$id_cat_med_pres_ut}', 
			id_cat_tipo_solicitud='{$id_cat_tipo_solicitud}', 
			informacion_solicitada='{$informacion_solicitada}'			
			WHERE id_solicitudes_informacion='{$db->escape($id)}'";
			
			
			$result = $db->query($sql);
				if ($result && $db->affected_rows() === 1) {
				insertAccion($user['id_user'], '"' . $user['username'] . '" edito la Solicitud de Información('.$id.') de Folio: -' . $solicitud['folio_solicitud'], 2);
				$session->msg('s', " La Solicitud de Información con folio '" . $solicitud['folio_solicitud'] . "' ha sido acuatizado con éxito.");
				redirect('solicitudes_ut.php', false);
			} else {
				$session->msg('d', ' Lo siento no se actualizaron los datos, debido a que no se realizaron canmbios a la informacion.');
				redirect('edit_solicitudes_ut.php?id=' . (int)$solicitud['folio_solicitud'], false);
			}
       

    } else {
        $session->msg("d", $errors);
        redirect('solicitudes_ut.php', false);
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
                <span>Editar Solicitud de Información</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_solicitudes_ut.php?id=<?php echo (int)$solicitud['id_solicitudes_informacion']; ?>" >
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_presentacion">Fecha de Presentación<span style="color:red;font-weight:bold">*</span></label><br>
                            <input type="date" class="form-control" name="fecha_presentacion" value="<?php echo ucwords($solicitud['fecha_presentacion']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="folio_solicitud">Folio Solicitud<span style="color:red;font-weight:bold">*</span></label>
                            <input type="text" class="form-control" name="folio_solicitud" placeholder="Folio Solicitud" value="<?php echo ucwords($solicitud['folio_solicitud']); ?>" required>
                        </div>
                    </div>
					 <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_med_pres_ut">Medio de Presentación<span style="color:red;font-weight:bold">*</span></label>
                            <select class="form-control" name="id_cat_med_pres_ut" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_medio_presentacion as $datos) : ?>
                                    <option <?php if ($solicitud['id_cat_med_pres_ut'] === $datos['id_cat_med_pres_ut']) echo 'selected="selected"'; ?> value="<?php echo $datos['id_cat_med_pres_ut']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div> 
					
					<div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_tipo_solicitud">Tipo de Información Solicitada<span style="color:red;font-weight:bold">*</span></label>
                            <select class="form-control" name="id_cat_tipo_solicitud" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_tipo_solicitud as $datos) : ?>
                                    <option <?php if ($solicitud['id_cat_tipo_solicitud'] === $datos['id_cat_tipo_solicitud'] ) echo 'selected="selected"'; ?> value="<?php echo $datos['id_cat_tipo_solicitud']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
					
				</div>
                <div class="row">
					<div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_solicitante">Nombre Solicitante<span style="color:red;font-weight:bold">*</span></label>
                            <input type="text" class="form-control" name="nombre_solicitante" placeholder="Nombre Solicitante" value="<?php echo ucwords($solicitud['nombre_solicitante']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_gen">Género Solicitane <span style="color:red;font-weight:bold">*</span></label>
                            <select class="form-control" name="id_cat_gen" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_genero as $datos) : ?>
                                    <option <?php if ($solicitud['id_cat_gen'] === $datos['id_cat_gen']) echo 'selected="selected"'; ?> value="<?php echo $datos['id_cat_gen']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="form-group">
                            <label for="informacion_solicitada">Información Solicitada</label>
                            <textarea class="form-control" name="informacion_solicitada"  cols="10" rows="3" required><?php echo ucwords($solicitud['informacion_solicitada']); ?></textarea>
                        </div>
                    </div>

                   
                </div>

                
                <div class="row">
                    <div class="form-group clearfix">
                        <a href="solicitudes_ut.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                        <button type="submit" name="edit_solicitudes_ut" class="btn btn-primary" value="subir">Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
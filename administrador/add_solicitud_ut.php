<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Solicitud';
require_once('includes/load.php');

$id_folio = last_id_folios();
$id_convenio = last_id_convenio();
$cat_genero = find_all('cat_genero');
$cat_medio_presentacion = find_all('cat_medio_pres_ut');
$cat_tipo_institucion = find_all('cat_tipo_institucion');
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

if (isset($_POST['add_solicitud_ut'])) {

    if (empty($errors)) {

        $folio_solicitud = remove_junk($db->escape($_POST['folio_solicitud']));
        $fecha_presentacion   = remove_junk($db->escape($_POST['fecha_presentacion']));
        $nombre_solicitante   = remove_junk($db->escape($_POST['nombre_solicitante']));
        $id_cat_gen   = remove_junk($db->escape($_POST['id_cat_gen']));
        $id_cat_med_pres_ut = remove_junk($db->escape($_POST['id_cat_med_pres_ut']));
        $id_cat_tipo_solicitud   = remove_junk(($db->escape($_POST['id_cat_tipo_solicitud'])));
        $informacion_solicitada   = remove_junk(($db->escape($_POST['informacion_solicitada'])));

        $carpeta = 'uploads/solicitudes_informacion/' . $folio_solicitud;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }


            $query = "INSERT INTO solicitudes_informacion (";
            $query .= "folio_solicitud,fecha_presentacion,nombre_solicitante,id_cat_gen,id_cat_med_pres_ut,informacion_solicitada,id_cat_tipo_solicitud,user_creador,fecha_creacion";
            $query .= ") VALUES (";
            $query .= " '{$folio_solicitud}','{$fecha_presentacion}','{$nombre_solicitante}','{$id_cat_gen}','{$id_cat_med_pres_ut}','{$informacion_solicitada}','{$id_cat_tipo_solicitud}',";
            $query .= "{$id_user},NOW())";
           
            if ($db->query($query)) {
                //sucess
                insertAccion($user['id_user'], '"' . $user['username'] . '" dió de alta la Solicitud de Información con Folio: -' . $folio_solicitud . '-.', 1);
                $session->msg('s', " La Solicitud de Información con folio '{$folio_solicitud}' ha sido agregado con éxito.");
                redirect('solicitudes_ut.php', false);
            } else {
                //failed
                $session->msg('d', ' No se pudo agregar la solicitud de informacion.');
                redirect('add_solicitud_ut.php', false);
            }
       
    } else {
        $session->msg("d", $errors);
        redirect('add_solicitud_ut.php', false);
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
                <span>Agregar Solicitud de Información</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_solicitud_ut.php">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_presentacion">Fecha de Presentación<span style="color:red;font-weight:bold">*</span></label><br>
                            <input type="date" class="form-control" name="fecha_presentacion" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="folio_solicitud">Folio Solicitud<span style="color:red;font-weight:bold">*</span></label>
                            <input type="text" class="form-control" name="folio_solicitud" placeholder="Folio Solicitud" required>
                        </div>
                    </div>
					 <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_med_pres_ut">Medio de Presentación<span style="color:red;font-weight:bold">*</span></label>
                            <select class="form-control" name="id_cat_med_pres_ut" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_medio_presentacion as $datos) : ?>
                                    <option value="<?php echo $datos['id_cat_med_pres_ut']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
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
                                    <option value="<?php echo $datos['id_cat_tipo_solicitud']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>

                        </div>
                    </div>
					
				</div>
                <div class="row">
					<div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_solicitante">Nombre Solicitante<span style="color:red;font-weight:bold">*</span></label>
                            <input type="text" class="form-control" name="nombre_solicitante" placeholder="Nombre Solicitante" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_gen">Género Solicitane <span style="color:red;font-weight:bold">*</span></label>
                            <select class="form-control" name="id_cat_gen" required>
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_genero as $datos) : ?>
                                    <option value="<?php echo $datos['id_cat_gen']; ?>"><?php echo ucwords($datos['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
					<div class="col-md-4">
                        <div class="form-group">
                            <label for="informacion_solicitada">Información Solicitada</label>
                            <textarea class="form-control" name="informacion_solicitada"  cols="10" rows="3" required></textarea>
                        </div>
                    </div>

                   
                </div>

                
                <div class="row">
                    <div class="form-group clearfix">
                        <a href="solicitudes_ut.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                        <button type="submit" name="add_solicitud_ut" class="btn btn-primary" value="subir">Guardar</button>
                    </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
<?php
$page_title = 'Editar Datos de Trabajador';
require_once('includes/load.php');

page_require_level(1);
?>
<?php
$e_detalle = find_by_id('detalles_usuario', (int)$_GET['id'], 'id_det_usuario');
$cargos = find_all('cargos');
$areas = find_all('area');
if (!$e_detalle) {
    $session->msg("d", "id de usuario no encontrado.");
    redirect('detalles_usuario.php');
}
$user = current_user();
$nivel = $user['user_level'];
?>

<?php
//Actualiza informacion de los trabajadores
if (isset($_POST['update'])) {
    $req_fields = array('nombre', 'apellidos', 'sexo', 'curp', 'rfc', 'correo', 'tel-casa', 'tel-cel', 'calle-num', 'colonia', 'municipio', 'estado', 'pais', 'cargo');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_detalle['id_det_usuario'];
        $nombre   = $_POST['nombre'];
        $apellidos   = $_POST['apellidos'];
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $curp   = remove_junk(upper_case($db->escape($_POST['curp'])));
        $rfc   = remove_junk(upper_case($db->escape($_POST['rfc'])));
        $correo   = remove_junk($db->escape($_POST['correo']));
        $casa   = remove_junk($db->escape($_POST['tel-casa']));
        $cel   = remove_junk($db->escape($_POST['tel-cel']));
        $calle   = remove_junk($db->escape($_POST['calle-num']));
        $colonia   = $_POST['colonia'];
        $municipio   = $_POST['municipio'];
        $estado   = $_POST['estado'];
        $pais   = $_POST['pais'];
        $cargo = remove_junk((int)$db->escape($_POST['cargo']));
        $estatus = remove_junk((int)$db->escape($_POST['estatus']));

        $sql = "UPDATE detalles_usuario SET nombre='{$nombre}', apellidos='{$apellidos}', sexo='{$sexo}', curp='{$curp}', rfc='{$rfc}', correo='{$correo}', telefono_casa='{$casa}', telefono_celular='{$cel}', calle_numero='{$calle}', colonia='{$colonia}', municipio='{$municipio}', estado='{$estado}', pais='{$pais}', id_cargo={$cargo}, estatus_detalle={$estatus} WHERE id_det_usuario='{$db->escape($id)}'";
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('edit_detalle_usuario.php?id=' . (int)$e_detalle['id_det_usuario'], false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_detalle_usuario.php?id=' . (int)$e_detalle['id_det_usuario'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_detalle_usuario.php?id=' . (int)$e_detalle['id_det_usuario'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="col-md-12"> <?php echo display_msg($msg); ?> </div>
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <strong>
                    <span class="glyphicon glyphicon-th"></span>
                    Actualizar datos del trabajador <?php echo (ucwords($e_detalle['nombre'])); ?> <?php echo ($e_detalle['apellidos']); ?>
                </strong>
            </div>
            <div class="panel-body">
                <form method="post" action="edit_detalle_usuario.php?id=<?php echo (int)$e_detalle['id_det_usuario']; ?>" class="clearfix">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="nombre" class="control-label">Nombre</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo ($e_detalle['nombre']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="apellidos" class="control-label">Apellidos</label>
                                <input type="text" class="form-control" name="apellidos" value="<?php echo ($e_detalle['apellidos']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cargo">Cargo</label>
                                <select class="form-control" name="cargo">
                                    <?php foreach ($cargos as $cargo) : ?>
                                        <option <?php if ($cargo['id_cargos'] === $e_detalle['id_cargo']) echo 'selected="selected"'; ?> value="<?php echo $cargo['id_cargos'];?>">                                                            
                                                <?php foreach ($areas as $area) : ?>
                                                    <?php if ($area['id_area'] === $cargo['id_area']) 
                                                        echo ucwords($cargo['nombre_cargo']) . " - " . ucwords($area['nombre_area']); 
                                                    ?>
                                                <?php endforeach; ?>
                                            </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option <?php if ($e_detalle['sexo'] === 'H') echo 'selected="selected"'; ?>value="H">Hombre</option>
                                <option <?php if ($e_detalle['sexo'] === 'M') echo 'selected="selected"'; ?> value="M">Mujer</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="curp" class="control-label">CURP</label>
                                <input type="text" class="form-control" name="curp" value="<?php echo remove_junk($e_detalle['curp']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rfc" class="control-label">RFC</label>
                                <input type="text" class="form-control" name="rfc" value="<?php echo remove_junk($e_detalle['rfc']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <label for="correo" class="control-label">Correo</label>
                            <input type="text" class="form-control" name="correo" value="<?php echo remove_junk($e_detalle['correo']); ?>">
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tel-casa" class="control-label">Teléfono Casa</label>
                                <input type="text" class="form-control" name="tel-casa" value="<?php echo remove_junk($e_detalle['telefono_casa']); ?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tel-cel" class="control-label">Teléfono Celular</label>
                                <input type="text" class="form-control" name="tel-cel" value="<?php echo remove_junk($e_detalle['telefono_celular']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="calle-num" class="control-label">Calle y número</label>
                            <input type="text" class="form-control" name="calle-num" value="<?php echo ($e_detalle['calle_numero']); ?>">
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="colonia" class="control-label">Colonia</label>
                                <input type="text" class="form-control" name="colonia" value="<?php echo ($e_detalle['colonia']); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="municipio" class="control-label">Municipio</label>
                                <input type="text" class="form-control" name="municipio" value="<?php echo ($e_detalle['municipio']); ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="estado" class="control-label">Estado</label>
                            <input type="text" class="form-control" name="estado" value="<?php echo ($e_detalle['estado']); ?>">
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="pais" class="control-label">País</label>
                                <input type="text" class="form-control" name="pais" value="<?php echo ($e_detalle['pais']); ?>">
                            </div>
                        </div>
                        <?php if ($nivel <= 2) : ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="estatus">Estatus Trabajador</label>
                                    <select class="form-control" name="estatus">
                                        <option <?php if ($e_detalle['estatus_detalle'] === '1') echo 'selected="selected"'; ?> value="1"> Activo </option>
                                        <option <?php if ($e_detalle['estatus_detalle'] === '0') echo 'selected="selected"'; ?> value="0">Inactivo</option>
                                    </select>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                    <div class="form-group clearfix">
                        <a href="ver_info_detalle.php?id=<?php echo (int)$e_detalle['id_det_usuario']; ?>" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                        <button type="submit" name="update" class="btn btn-info">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
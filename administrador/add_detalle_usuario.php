<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar trabajador';
require_once('includes/load.php');

page_require_level(1);
$cargos = find_all_cargos2();
$user = current_user();
$cat_municipios = find_all_cat_municipios();
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_detalle_usuario'])) {

    $req_fields = array('nombre', 'apellidos', 'sexo', 'correo', 'cargo');
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre   = remove_junk($db->escape($_POST['nombre']));
        $apellidos   = remove_junk($db->escape($_POST['apellidos']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $correo   = remove_junk($db->escape($_POST['correo']));
        $cargo   = (int)$db->escape($_POST['cargo']);
        $telefono   = $db->escape($_POST['telefono']);
        $curp   = $db->escape($_POST['curp']);
        $rfc   = $db->escape($_POST['rfc']);
        $calle_num   = $db->escape($_POST['calle_num']);
        $colonia   = $db->escape($_POST['colonia']);
        $municipio   = $db->escape($_POST['municipio']);
        $estado   = $db->escape($_POST['estado']);

        $query = "INSERT INTO detalles_usuario (";
        $query .= "nombre,apellidos,sexo,correo,curp,rfc,calle_num,colonia,municipio,estado,telefono,id_cargo,estatus_detalle";
        $query .= ") VALUES (";
        $query .= " '{$nombre}','{$apellidos}','{$sexo}','{$correo}','{$curp}','{$rfc}','{$calle_num}','{$colonia}',
                    '{$municipio}','{$estado}','{$telefono}',{$cargo},'1'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', " El trabajador ha sido agregado con éxito.");
            insertAccion($user['id_user'], '"' . $user['username'] . '" agregó al trabajador(a): ' . $nombre . ' ' . $apellidos . '.', 1);
            redirect('detalles_usuario.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el trabajador.');
            redirect('add_detalles_usuario.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_detalle_usuario.php', false);
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
                <span>Agregar trabajador</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_detalle_usuario.php">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="apellidos">Apellidos</label>
                            <input type="text" class="form-control" name="apellidos" placeholder="Apellidos" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="level">Cargo</label>
                            <select class="form-control" name="cargo">
                                <?php foreach ($cargos as $cargo) : ?>
                                    <option value="<?php echo $cargo['id_cargos']; ?>"><?php echo ucwords($cargo['nombre_cargo'] . " | " . $cargo['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option value="M">Mujer</option>
                                <option value="H">Hombre</option>
                                <option value="LGBT">LGBTTTIQ+</option>
                                <option value="NB">No Binario</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" name="telefono">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="curp">CURP</label>
                            <input type="text" class="form-control" name="curp" placeholder="CURP">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="rfc">RFC</label>
                            <input type="text" class="form-control" name="rfc">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="calle_num">Calle y Núm.</label>
                            <input type="text" class="form-control" name="calle_num">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="municipio">Municipio</label>
                            <select class="form-control" name="municipio">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_municipios as $id_cat_municipio) : ?>
                                    <option value="<?php echo $id_cat_municipio['id_cat_mun']; ?>"><?php echo ucwords($id_cat_municipio['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" name="estado">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="detalles_usuario.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_detalle_usuario" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
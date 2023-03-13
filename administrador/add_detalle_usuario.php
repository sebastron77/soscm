<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar trabajador';
require_once('includes/load.php');

page_require_level(1);
$cargos = find_all_cargos2();
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_detalle_usuario'])) {

    $req_fields = array('nombre', 'apellidos', 'sexo', 'curp', 'rfc', 'correo', 'tel-casa', 'tel-cel', 'calle-num', 'colonia', 'municipio', 'estado', 'pais', 'cargo');
    validate_fields($req_fields);

    if (empty($errors)) {
        $nombre   = remove_junk($db->escape($_POST['nombre']));
        $apellidos   = remove_junk($db->escape($_POST['apellidos']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $curp   = remove_junk(upper_case($db->escape($_POST['curp'])));
        $rfc   = remove_junk(upper_case($db->escape($_POST['rfc'])));
        $correo   = remove_junk($db->escape($_POST['correo']));
        $casa   = remove_junk($db->escape($_POST['tel-casa']));
        $cel   = remove_junk($db->escape($_POST['tel-cel']));
        $calle   = remove_junk($db->escape($_POST['calle-num']));
        $colonia   = remove_junk($db->escape($_POST['colonia']));
        $municipio   = remove_junk($db->escape($_POST['municipio']));
        $estado   = remove_junk($db->escape($_POST['estado']));
        $pais   = remove_junk($db->escape($_POST['pais']));
        $cargo   = (int)$db->escape($_POST['cargo']);

        $query = "INSERT INTO detalles_usuario (";
        $query .= "nombre,apellidos,sexo,curp,rfc,correo,telefono_casa,telefono_celular,calle_numero,colonia,municipio,estado,pais,id_cargo,estatus_detalle";
        $query .= ") VALUES (";
        $query .= " '{$nombre}','{$apellidos}','{$sexo}','{$curp}','{$rfc}','{$correo}','{$casa}','{$cel}','{$calle}','{$colonia}','{$municipio}','{$estado}','{$pais}',{$cargo},'1'";
        $query .= ")";
        if ($db->query($query)) {
            //sucess
            $session->msg('s', " El trabajador ha sido agregado con éxito.");
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre" placeholder="Nombre(s)" required>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                                    <option value="<?php echo $cargo['id_cargos']; ?>"><?php echo ucwords($cargo['nombre_cargo']." | ".$cargo['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="sexo">Sexo</label>
                            <select class="form-control" name="sexo">
                                <option value="M">Mujer</option>
                                <option value="H">Hombre</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="curp">CURP</label>
                            <input type="text" class="form-control" name="curp" placeholder="CURP" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="rfc">RFC</label>
                            <input type="text" class="form-control" name="rfc" placeholder="RFC" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tel-casa">Teléfono Casa</label>
                            <input type="text" class="form-control" name="tel-casa" placeholder="Teléfono de casa" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tel-cel">Teléfono Celular</label>
                            <input type="text" class="form-control" name="tel-cel" placeholder="Teléfono Celular" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="calle-num">Calle y número</label>
                            <input type="text" class="form-control" name="calle-num" placeholder="Calle y número" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="colonia">Colonia</label>
                            <input type="text" class="form-control" name="colonia" placeholder="Colonia" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="municipio">Municipio</label>
                            <input type="text" class="form-control" name="municipio" placeholder="Municipio" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" name="estado" placeholder="Estado" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="pais">País</label>
                            <input type="text" class="form-control" name="pais" placeholder="País" required>
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
<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar trabajador';
require_once('includes/load.php');

page_require_level(1);
$cargos = find_all_cargos2();
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

        $query = "INSERT INTO detalles_usuario (";
        $query .= "nombre,apellidos,sexo,correo,id_cargo,estatus_detalle";
        $query .= ") VALUES (";
        $query .= " '{$nombre}','{$apellidos}','{$sexo}','{$correo}',{$cargo},'1'";
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
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control" name="correo" placeholder="ejemplo@correo.com" required>
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
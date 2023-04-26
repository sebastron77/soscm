<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios_general();
page_require_level(3);
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_consejo'])) {

    $req_fields = array('num_sesion', 'tipo_sesion', 'fecha_sesion', 'hora', 'lugar', 'num_asistentes');
    validate_fields($req_fields);

    if (empty($errors)) {
        $num_sesion   = remove_junk($db->escape($_POST['num_sesion']));
        $tipo_sesion   = remove_junk($db->escape($_POST['tipo_sesion']));
        $fecha_sesion   = remove_junk($db->escape($_POST['fecha_sesion']));
        $hora   = remove_junk($db->escape($_POST['hora']));
        $lugar   = remove_junk(upper_case($db->escape($_POST['lugar'])));
        $num_asistentes   = remove_junk(upper_case($db->escape($_POST['num_asistentes'])));
        $orden_dia   = remove_junk($db->escape($_POST['orden_dia']));
        $acta_acuerdos   = remove_junk($db->escape($_POST['acta_acuerdos']));

        //Suma el valor del id anterior + 1, para generar ese id para el nuevo resguardo
        //La variable $no_folio sirve para el numero de folio

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int)$nuevo['id'] + 1;
                $no_folio1 = sprintf('%04d', (int)$nuevo['id'] + 1);
            }
        }

        //Se crea el número de folio
        $year = date("Y");
        // Se crea el folio orientacion
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-CONS';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-CONS';
        $carpeta = 'uploads/consejo/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['orden_dia']['name'];
        $size = $_FILES['orden_dia']['size'];
        $type = $_FILES['orden_dia']['type'];
        $temp = $_FILES['orden_dia']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['acta_acuerdos']['name'];
        $size2 = $_FILES['acta_acuerdos']['size'];
        $type2 = $_FILES['acta_acuerdos']['type'];
        $temp2 = $_FILES['acta_acuerdos']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        if ($move && $name != '' && $name2 != '') {
            $query = "INSERT INTO consejo (";
            $query .= "folio,num_sesion,tipo_sesion,fecha_sesion,hora,lugar,num_asistentes,orden_dia,acta_acuerdos";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$num_sesion}','{$tipo_sesion}','{$fecha_sesion}','{$hora}','{$lugar}','{$num_asistentes}','{$name}','{$name2}'";
            $query .= ")";

            $query2 = "INSERT INTO folios_general (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El registro se ha agregado con éxito.");
            redirect('consejo.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el registro.');
            redirect('add_consejo.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_consejo.php', false);
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
                <span>Agregar</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_consejo.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_sesion"># de Sesión</label>
                            <input type="text" class="form-control" name="num_sesion" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="tipo_sesion">Tipo de sesión</label>
                            <select class="form-control" name="tipo_sesion">
                                <option value="Escoge una opción">Escoge una opción</option>
                                <option value="Ordinaria">Ordinaria</option>
                                <option value="Extraordinaria">Extraordinaria</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_sesion">Fecha de Sesión</label>
                            <input type="date" class="form-control" name="fecha_sesion" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="hora">Hora</label>
                            <input type="time" class="form-control" name="hora" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_asistentes">Número de asistentes</label>
                            <input type="number" class="form-control" min="1" name="num_asistentes" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="lugar">Lugar</label>
                            <input type="text" class="form-control" name="lugar" required>
                        </div>
                    </div>                   
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="orden_dia">Orden del día</label>
                            <input type="file" accept="application/pdf" class="form-control" name="orden_dia" id="orden_dia" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="acta_acuerdos">Acta de acuerdos (firmada)</label>
                            <input type="file" accept="application/pdf" class="form-control" name="acta_acuerdos" id="acta_acuerdos" required>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="consejo.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_consejo" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
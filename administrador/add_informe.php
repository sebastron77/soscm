<?php header('Content-type: text/html; charset=utf-8');
$page_title = 'Agregar Informe Trimestral/Anual';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id_user'];
$id_ori_canal = last_id_oricanal();
$id_folio = last_id_folios_general();
$user = current_user();
$nivel = $user['user_level'];
$id_user = $user['id_user'];
$nivel_user = $user['user_level'];

$areas = find_all('area');
$area_user = area_usuario2($id_user);
$area = $area_user['nombre_area'];
?>
<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_informe'])) {
    $req_fields = array('num_nom_informe', 'fecha_inicio_informe', 'fecha_fin_informe');
    validate_fields($req_fields);

    if (empty($errors)) {
        $num_nom_informe   = remove_junk($db->escape($_POST['num_nom_informe']));
        $fecha_inicio_informe   = remove_junk($db->escape($_POST['fecha_inicio_informe']));
        $fecha_fin_informe   = remove_junk($db->escape($_POST['fecha_fin_informe']));
        $fecha_entrega_informe   = remove_junk($db->escape($_POST['fecha_entrega_informe']));
        $institucion_a_quien_se_entrega   = remove_junk(($db->escape($_POST['institucion_a_quien_se_entrega'])));

        if (count($id_ori_canal) == 0) {
            $nuevo_id_ori_canal = 1;
            $no_folio = sprintf('%04d', 1);
        } else {
            foreach ($id_ori_canal as $nuevo) {
                $nuevo_id_ori_canal = (int) $nuevo['id'] + 1;
                $no_folio = sprintf('%04d', (int) $nuevo['id'] + 1);
            }
        }

        if (count($id_folio) == 0) {
            $nuevo_id_folio = 1;
            $no_folio1 = sprintf('%04d', 1);
        } else {
            foreach ($id_folio as $nuevo) {
                $nuevo_id_folio = (int) $nuevo['contador'] + 1;
                $no_folio1 = sprintf('%04d', (int) $nuevo['contador'] + 1);
            }
        }

        //Se crea el número de folio
        $year = date("Y");
        // Se crea el folio orientacion
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-INFTA';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-INFTA';
        $carpeta = 'uploads/informes/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['informe_adjunto']['name'];
        $size = $_FILES['informe_adjunto']['size'];
        $type = $_FILES['informe_adjunto']['type'];
        $temp = $_FILES['informe_adjunto']['tmp_name'];

        $move =  move_uploaded_file($temp, $carpeta . "/" . $name);

        $name2 = $_FILES['caratula_informe']['name'];
        $size2 = $_FILES['caratula_informe']['size'];
        $type2 = $_FILES['caratula_informe']['type'];
        $temp2 = $_FILES['caratula_informe']['tmp_name'];

        $move2 =  move_uploaded_file($temp2, $carpeta . "/" . $name2);

        if ($move && $name != '' && $name2 != '') {
            $query = "INSERT INTO informes (";
            $query .= "folio, num_nom_informe, fecha_inicio_informe, fecha_fin_informe, fecha_entrega_informe, institucion_a_quien_se_entrega, caratula_informe, informe_adjunto, area_creacion";
            $query .= ") VALUES (";
            $query .= " '{$folio}','{$num_nom_informe}','{$fecha_inicio_informe}','{$fecha_fin_informe}','{$fecha_entrega_informe}','{$institucion_a_quien_se_entrega}','{$name}','{$name2}','{$area}'";
            $query .= ")";

            $query2 = "INSERT INTO folios (";
            $query2 .= "folio, contador";
            $query2 .= ") VALUES (";
            $query2 .= " '{$folio}','{$no_folio1}'";
            $query2 .= ")";
        }

        if ($db->query($query) && $db->query($query2)) {
            //sucess
            $session->msg('s', " El informe ha sido agregada con éxito.");
            redirect('informes.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar el informe.');
            redirect('add_informe.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_informe.php', false);
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
                <span>Agregar Informe Trimestral/Anual</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_informe.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="num_nom_informe">Número/Nombre de Informe</label>
                            <input type="text" class="form-control" name="num_nom_informe" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_entrega_informe">Fecha de entrega del reporte</label>
                            <input type="date" class="form-control" name="fecha_entrega_informe" required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Periodo del informe</label>
                            <div class="input-group input-daterange">
                                <input type="date" style="width: 125px;" name="fecha_inicio_informe" class="form-control">
                                <div class="input-group-addon" style="width: 12px;">-</div>
                                <input type="date" style="width: 125px;" name="fecha_fin_informe" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="institucion_a_quien_se_entrega">Institución a quien se entrega reporte</label>
                            <select class="form-control" name="institucion_a_quien_se_entrega">
                                <option value="">Escoge una opción</option>
                                <option value="Consejo">Consejo</option>
                                <option value="Congreso">Congreso</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="caratula_informe">Caratula del Informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="caratula_informe" id="caratula_informe">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="informe_adjunto">Adjuntar informe</label>
                            <input type="file" accept="application/pdf" class="form-control" name="informe_adjunto" id="informe_adjunto">
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="informes.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="add_informe" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
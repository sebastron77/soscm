<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Agregar Queja';
require_once('includes/load.php');
$user = current_user();
$detalle = $user['id_user'];
$id_queja = last_id_queja();
$id_folio = last_id_folios();
$nivel = $user['user_level'];
$nivel_user = $user['user_level'];

$cat_medios_pres = find_all_medio_pres();
$cat_autoridades = find_all_aut_res();
$cat_quejosos = find_all_quejosos();
$cat_agraviados = find_all('cat_agraviados');
$users = find_all('users');
$asigna_a = find_all_area_userQ();
$area = find_all_areas_quejas();
$cat_estatus_queja = find_all_estatus_queja();
$cat_municipios = find_all_cat_municipios();

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 5) {
    page_require_level_exacto(5);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user == 19) {
    page_require_level_exacto(19);
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
if ($nivel_user > 19) :
    redirect('home.php');
endif;
?>

<?php header('Content-type: text/html; charset=utf-8');
if (isset($_POST['add_queja'])) {

    $req_fields = array(
        'fecha_presentacion', 'id_cat_med_pres', 'id_cat_aut', 'id_cat_quejoso', 'id_cat_agrav', 'id_user_asignado', 'id_area_asignada', 'id_estatus_queja', 'dom_calle',
        'dom_numero', 'dom_colonia', 'descripcion_hechos'
    );
    validate_fields($req_fields);

    if (empty($errors)) {
        $fecha_presentacion = remove_junk($db->escape($_POST['fecha_presentacion']));
        $id_cat_med_pres = remove_junk($db->escape($_POST['id_cat_med_pres']));
        $id_cat_aut = remove_junk($db->escape($_POST['id_cat_aut']));
        $id_cat_quejoso = remove_junk($db->escape($_POST['id_cat_quejoso']));
        $id_cat_agraviado = remove_junk($db->escape($_POST['id_cat_agrav']));
        $id_user_asignado = remove_junk($db->escape($_POST['id_user_asignado']));
        $id_area_asignada = remove_junk($db->escape($_POST['id_area_asignada']));
        $id_estatus_quja = remove_junk($db->escape($_POST['id_estatus_quja']));
        $dom_calle = remove_junk($db->escape($_POST['dom_calle']));
        $dom_numero = remove_junk($db->escape($_POST['dom_numero']));
        $dom_colonia = remove_junk($db->escape($_POST['dom_colonia']));
        $descripcion_hechos = remove_junk($db->escape($_POST['descripcion_hechos']));
        $observaciones = remove_junk($db->escape($_POST['observaciones']));
        $fecha_vencimiento = remove_junk($db->escape($_POST['fecha_vencimiento']));
        $id_estatus_queja = remove_junk($db->escape($_POST['id_estatus_queja']));
        $ent_fed = remove_junk($db->escape($_POST['ent_fed']));
        $id_cat_mun = remove_junk($db->escape($_POST['id_cat_mun']));
        $localidad = remove_junk($db->escape($_POST['localidad']));
        date_default_timezone_set('America/Mexico_City');
        $creacion = date('Y-m-d H:i:s');

        if (count($id_queja) == 0) {
            $nuevo_id_queja = 1;
            $no_folio = sprintf('%04d', 1);
        } else {
            foreach ($id_queja as $nuevo) {
                $nuevo_id_queja = (int) $nuevo['id'] + 1;
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

        $year = date("Y");
        $folio = 'CEDH/' . $no_folio1 . '/' . $year . '-Q';

        $folio_carpeta = 'CEDH-' . $no_folio1 . '-' . $year . '-Q';
        $carpeta = 'uploads/quejas/' . $folio_carpeta;

        if (!is_dir($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        $name = $_FILES['adjunto']['name'];
        $size = $_FILES['adjunto']['size'];
        $type = $_FILES['adjunto']['type'];
        $temp = $_FILES['adjunto']['tmp_name'];

        $move = move_uploaded_file($temp, $carpeta . "/" . $name);
        $dbh = new PDO('mysql:host=localhost;dbname=libroquejas2', 'root', '');

        $query = "INSERT INTO quejas_dates (folio_queja,fecha_presentacion,id_cat_med_pres,id_cat_aut,observaciones,id_cat_quejoso,id_cat_agraviado,id_user_creador,
                    fecha_creacion,id_user_asignado,id_area_asignada,fecha_vencimiento,id_estatus_queja,archivo,dom_calle,dom_numero,dom_colonia,ent_fed,id_cat_mun,localidad,
                    descripcion_hechos,estado_procesal) 
                    VALUES ('{$folio}','{$fecha_presentacion}','{$id_cat_med_pres}','{$id_cat_aut}','{$observaciones}','{$id_cat_quejoso}','{$id_cat_agraviado}','{$detalle}','{$creacion}',
                    '{$id_user_asignado}','{$id_area_asignada}','{$fecha_vencimiento}','{$id_estatus_queja}','{$name}','{$dom_calle}','{$dom_numero}','{$dom_colonia}','{$ent_fed}',
                    '{$id_cat_mun}','{$localidad}', '{$descripcion_hechos}',NULL)";

        $query3 = "INSERT INTO folios (";
        $query3 .= "folio, contador";
        $query3 .= ") VALUES (";
        $query3 .= " '{$folio}','{$no_folio1}'";
        $query3 .= ")";

        //------------------BUSCA EL ID INSERTADO------------------
        $dbh->exec($query3);
        $dbh->exec($query);
        $id_insertado = $dbh->lastInsertId();

        $query2 = "INSERT INTO rel_queja_aut(id_cat_aut, id_queja_date) VALUES ({$id_cat_aut}, {$id_insertado})";

        if ($db->query($query2)) {
            //sucess
            $session->msg('s', " La queja ha sido agregada con éxito.");
            redirect('quejas.php', false);
        } else {
            //failed
            $session->msg('d', ' No se pudo agregar la queja.');
            redirect('add_queja.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('add_queja.php', false);
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
                <span>Agregar Queja</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="add_queja.php" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_presentacion">Fecha de presentación</label>
                            <input type="datetime-local" class="form-control" name="fecha_presentacion" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_cat_med_pres">Medio Presetación</label>
                            <select class="form-control" name="id_cat_med_pres">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_medios_pres as $medio_pres) : ?>
                                    <option value="<?php echo $medio_pres['id_cat_med_pres']; ?>"><?php echo ucwords($medio_pres['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="id_cat_aut">Autoridad Responsable</label>
                            <select class="form-control" name="id_cat_aut">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_autoridades as $autoridades) : ?>
                                    <option value="<?php echo $autoridades['id_cat_aut']; ?>"><?php echo ucwords($autoridades['nombre_autoridad']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_quejoso">Quejoso</label>
                            <select class="form-control" name="id_cat_quejoso">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_quejosos as $quejoso) : ?>
                                    <option value="<?php echo $quejoso['id_cat_quejoso']; ?>"><?php echo ucwords($quejoso['nombre'] . " " . $quejoso['paterno'] . " " . $quejoso['materno']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_cat_agrav">Agraviado</label>
                            <select class="form-control" name="id_cat_agrav">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_agraviados as $agraviado) : ?>
                                    <option value="<?php echo $agraviado['id_cat_agrav']; ?>"><?php echo ucwords($agraviado['nombre'] . " " . $agraviado['paterno'] . " " . $agraviado['materno']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_user_asignado">Se asigna a</label>
                            <select class="form-control" name="id_user_asignado">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($asigna_a as $asigna) : ?>
                                    <option value="<?php echo $asigna['id_det_usuario']; ?>"><?php echo ucwords($asigna['nombre'] . " " . $asigna['apellidos']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_area_asignada">Área a la que se asigna</label>
                            <select class="form-control" name="id_area_asignada">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($area as $a) : ?>
                                    <option value="<?php echo $a['id_area']; ?>"><?php echo ucwords($a['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="id_estatus_queja">Estatus de Queja</label>
                            <select class="form-control" name="id_estatus_queja">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_estatus_queja as $estatus) : ?>
                                    <option value="<?php echo $estatus['id_cat_est_queja']; ?>"><?php echo ucwords($estatus['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="dom_calle">Calle</label>
                            <input type="text" class="form-control" name="dom_calle" placeholder="Calle" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="dom_numero">Núm. ext/int</label>
                            <input type="text" class="form-control" name="dom_numero" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="dom_colonia">Colonia</label>
                            <input type="text" class="form-control" name="dom_colonia" placeholder="Colonia" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ent_fed">Entidad Federativa</label>
                            <select class="form-control" name="ent_fed" required>
                                <option value="">Escoge una opción</option>
                                <option value="Michoacán">Michoacán</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="id_cat_mun">Municipio</label>
                            <select class="form-control" name="id_cat_mun">
                                <option value="">Escoge una opción</option>
                                <?php foreach ($cat_municipios as $id_cat_municipio) : ?>
                                    <option value="<?php echo $id_cat_municipio['id_cat_mun']; ?>"><?php echo ucwords($id_cat_municipio['descripcion']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="localidad">Localidad</label>
                            <input type="text" class="form-control" name="localidad" placeholder="Localidad" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="adjunto">Archivo adjunto (si es necesario)</label>
                            <input type="file" accept="application/pdf" class="form-control" name="adjunto" id="adjunto">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="descripcion_hechos">Descripción de los hechos</label>
                            <textarea class="form-control" name="descripcion_hechos" id="descripcion_hechos" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="observaciones">Notas Internas</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button style="background: #300285; border-color:#300285;" type="submit" name="add_queja" class="btn btn-primary" onclick="return confirm('La queja será guardada. Verifica el folio generado por el sistema para que lo asignes de manera correcta a su expediente. Da clic en Aceptar para continuar.');">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
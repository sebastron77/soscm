<?php
$page_title = 'Editar Recomendación General';
require_once('includes/load.php');

// page_require_level(4);
?>
<?php
$e_recomendacion = find_by_id('recomendaciones_generales', (int)$_GET['id']);
if (!$e_recomendacion) {
    $session->msg("d", "id de recomendación general no encontrado.");
    redirect('recomendaciones_generales.php');
}
$user = current_user();
$nivel = $user['user_level'];

$id_user = $user['id'];

page_require_level(2);

?>

<?php
if (isset($_POST['edit_recomendacion_general'])) {
    $req_fields = array('autoridad_responsable', 'servidor_publico', 'fecha_acuerdo', 'observaciones');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_recomendacion['id'];
        $autoridad_responsable   = remove_junk($db->escape($_POST['autoridad_responsable']));
        $servidor_publico   = remove_junk($db->escape($_POST['servidor_publico']));
        $fecha_acuerdo   = remove_junk($db->escape($_POST['fecha_acuerdo']));
        $observaciones   = remove_junk($db->escape($_POST['observaciones']));
        $recomendacion_adjunto   = remove_junk(($db->escape($_POST['recomendacion_adjunto'])));

        $folio_editar = $e_recomendacion['folio_queja'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/recomendacionesGenerales/' . $resultado;

        $name = $_FILES['recomendacion_adjunto']['name'];
        $size = $_FILES['recomendacion_adjunto']['size'];
        $type = $_FILES['recomendacion_adjunto']['type'];
        $temp = $_FILES['recomendacion_adjunto']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        $name2 = $_FILES['recomendacion_adjunto_publico']['name'];
        $size = $_FILES['recomendacion_adjunto_publico']['size'];
        $type = $_FILES['recomendacion_adjunto_publico']['type'];
        $temp = $_FILES['recomendacion_adjunto_publico']['tmp_name'];

        //Verificamos que exista la carpeta y si sí, guardamos el pdf
        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name2);
        }

        if ($name != '' && $name2 != '') {
            $sql = "UPDATE recomendaciones_generales SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto='{$name}', recomendacion_adjunto_publico='{$name2}' WHERE id='{$db->escape($id)}'";
        }

        if ($name != '' && $name2 == '') {
            $sql = "UPDATE recomendaciones_generales SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto='{$name}' WHERE id='{$db->escape($id)}'";
        }

        if ($name == '' && $name2 != '') {
            $sql = "UPDATE recomendaciones_generales SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}', recomendacion_adjunto_publico='{$name2}' WHERE id='{$db->escape($id)}'";
        }

        if ($name == '' && $name2 == '') {
            $sql = "UPDATE recomendaciones_generales SET autoridad_responsable='{$autoridad_responsable}', servidor_publico='{$servidor_publico}', fecha_recomendacion='{$fecha_acuerdo}', observaciones='{$observaciones}' WHERE id='{$db->escape($id)}'";
        }

        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada");
            redirect('recomendaciones_generales.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('edit_recomendacion_general.php?id=' . (int)$e_recomendacion['id'], false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_recomendacion_general.php?id=' . (int)$e_recomendacion['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar recomendación general <?php echo $e_recomendacion['folio_recomendacion_general']; ?></span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_recomendacion_general.php?id=<?php echo (int)$e_recomendacion['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="folio_queja">Folio de Queja</label>
                            <input type="text" style="background: #1E1F23;" class="form-control" name="folio_queja" value="<?php echo remove_junk($e_recomendacion['folio_queja']); ?>" readonly>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad_responsable">Autoridad señalada</label>
                            <select class="form-control" name="autoridad_responsable">
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Otra') echo 'selected="selected"'; ?> value="Otra">Otra</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaría de Seguridad Pública') echo 'selected="selected"'; ?> value="Secretaría de Seguridad Pública">Secretaría de Seguridad Pública</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Fiscalía General en el Estado') echo 'selected="selected"'; ?> value="Fiscalía General en el Estado">Fiscalía General en el Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Aeropuerto de Morelia') echo 'selected="selected"'; ?> value="Aeropuerto de Morelia">Aeropuerto de Morelia</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Colegio de Bachilleres del Estado de Michoacán COBAEM') echo 'selected="selected"'; ?> value="Colegio de Bachilleres del Estado de Michoacán COBAEM">Colegio de Bachilleres del Estado de Michoacán COBAEM</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM') echo 'selected="selected"'; ?> value="Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM">Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Colegio Nacional de Educación Profesional Técnica CONALEP') echo 'selected="selected"'; ?> value="Colegio Nacional de Educación Profesional Técnica CONALEP">Colegio Nacional de Educación Profesional Técnica CONALEP</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Coordinadora del Transporte Publico en Michoacán') echo 'selected="selected"'; ?> value="Comisión Coordinadora del Transporte Publico en Michoacán">Comisión Coordinadora del Transporte Publico en Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Ejecutiva Estatal de Atención a Victimas') echo 'selected="selected"'; ?> value="Comisión Ejecutiva Estatal de Atención a Victimas">Comisión Ejecutiva Estatal de Atención a Victimas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Estatal de Cultura Física y Deporte') echo 'selected="selected"'; ?> value="Comisión Estatal de Cultura Física y Deporte">Comisión Estatal de Cultura Física y Deporte</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Estatal del Agua y Gestión de Cuencas') echo 'selected="selected"'; ?> value="Comisión Estatal del Agua y Gestión de Cuencas">Comisión Estatal del Agua y Gestión de Cuencas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Nacional de los Derechos Humanos CNDH') echo 'selected="selected"'; ?> value="Comisión Nacional de los Derechos Humanos CNDH">Comisión Nacional de los Derechos Humanos CNDH</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Nacional del Agua CONAGUA') echo 'selected="selected"'; ?> value="Comisión Nacional del Agua CONAGUA">Comisión Nacional del Agua CONAGUA</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF') echo 'selected="selected"'; ?> value="Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF">Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Comisión Para la Regularización de la Tenencia de la Tierra CORETT') echo 'selected="selected"'; ?> value="Comisión Para la Regularización de la Tenencia de la Tierra CORETT">Comisión Para la Regularización de la Tenencia de la Tierra CORETT</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Consejería Jurídica del Ejecutivo del Estado') echo 'selected="selected"'; ?> value="Consejería Jurídica del Ejecutivo del Estado">Consejería Jurídica del Ejecutivo del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Consejo Nacional Para Prevenir la Discriminación') echo 'selected="selected"'; ?> value="Consejo Nacional Para Prevenir la Discriminación">Consejo Nacional Para Prevenir la Discriminación</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Coordinación de Comunicación Social') echo 'selected="selected"'; ?> value="Coordinación de Comunicación Social">Coordinación de Comunicación Social</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Coordinación del Sistema Penitenciario del Estado de Michoacán') echo 'selected="selected"'; ?> value="Coordinación del Sistema Penitenciario del Estado de Michoacán">Coordinación del Sistema Penitenciario del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Defensoría Publica Federal') echo 'selected="selected"'; ?> value="Defensoría Publica Federal">Defensoría Publica Federal</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Despacho del C. Gobernador') echo 'selected="selected"'; ?> value="Despacho del C. Gobernador">Despacho del C. Gobernador</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Dirección de Registro Civil') echo 'selected="selected"'; ?> value="Dirección de Registro Civil">Dirección de Registro Civil</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Dirección de Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Dirección de Trabajo y Previsión Social">Dirección de Trabajo y Previsión Social</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Dirección General de Educación Tecnológica Industrial DGTI') echo 'selected="selected"'; ?> value="Dirección General de Educación Tecnológica Industrial DGTI">Dirección General de Educación Tecnológica Industrial DGTI</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Dirección General de Institutos Tecnológicos') echo 'selected="selected"'; ?> value="Dirección General de Institutos Tecnológicos">Dirección General de Institutos Tecnológicos</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Fiscalía General de la República') echo 'selected="selected"'; ?> value="Fiscalía General de la República">Fiscalía General de la República</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'FOVISSSTE Michoacán') echo 'selected="selected"'; ?> value="FOVISSSTE Michoacán">FOVISSSTE Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Honorable Congreso del Estado de Michoacán') echo 'selected="selected"'; ?> value="Honorable Congreso del Estado de Michoacán">Honorable Congreso del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto de la Defensoría Publica del Estado') echo 'selected="selected"'; ?> value="Instituto de la Defensoría Publica del Estado">Instituto de la Defensoría Publica del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto de la Juventud Michoacana') echo 'selected="selected"'; ?> value="Instituto de la Juventud Michoacana">Instituto de la Juventud Michoacana</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado') echo 'selected="selected"'; ?> value="Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado">Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto de Vivienda de Michoacán IVEM') echo 'selected="selected"'; ?> value="Instituto de Vivienda de Michoacán IVEM">Instituto de Vivienda de Michoacán IVEM</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT') echo 'selected="selected"'; ?> value="Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT">Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto Electoral de Michoacán') echo 'selected="selected"'; ?> value="Instituto Electoral de Michoacán">Instituto Electoral de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto Mexicano del Seguro Social IMSS') echo 'selected="selected"'; ?> value="Instituto Mexicano del Seguro Social IMSS">Instituto Mexicano del Seguro Social IMSS</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto Michoacano de Ciencias de la Educación José María Morelos') echo 'selected="selected"'; ?> value="Instituto Michoacano de Ciencias de la Educación José María Morelos">Instituto Michoacano de Ciencias de la Educación José María Morelos</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto Nacional de Educación Para los Adultos INEA') echo 'selected="selected"'; ?> value="Instituto Nacional de Educación Para los Adultos INEA">Instituto Nacional de Educación Para los Adultos INEA</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Instituto Nacional de Migración') echo 'selected="selected"'; ?> value="Instituto Nacional de Migración">Instituto Nacional de Migración</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Junta de Asistencia Privada del Gobierno del Estado') echo 'selected="selected"'; ?> value="Junta de Asistencia Privada del Gobierno del Estado">Junta de Asistencia Privada del Gobierno del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Junta de Caminos del Estado de Michoacán') echo 'selected="selected"'; ?> value="Junta de Caminos del Estado de Michoacán">Junta de Caminos del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Junta Local de Conciliación y Arbitraje') echo 'selected="selected"'; ?> value="Junta Local de Conciliación y Arbitraje">Junta Local de Conciliación y Arbitraje</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Parque Zoológico Benito Juárez') echo 'selected="selected"'; ?> value="Parque Zoológico Benito Juárez">Parque Zoológico Benito Juárez</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Pensiones Civiles del Estado') echo 'selected="selected"'; ?> value="Pensiones Civiles del Estado">Pensiones Civiles del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Acuitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Acuitzio">Presidencia Municipal de Acuitzio</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Aguililla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aguililla">Presidencia Municipal de Aguililla</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Álvaro Obregón') echo 'selected="selected"'; ?> value="Presidencia Municipal de Álvaro Obregón">Presidencia Municipal de Álvaro Obregón</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Angamacutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angamacutiro">Presidencia Municipal de Angamacutiro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Angangueo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angangueo">Presidencia Municipal de Angangueo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Apatzingán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Apatzingán">Presidencia Municipal de Apatzingán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Aquila') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aquila">Presidencia Municipal de Aquila</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Ario') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ario">Presidencia Municipal de Ario</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Arteaga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Arteaga">Presidencia Municipal de Arteaga</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Briseñas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Briseñas">Presidencia Municipal de Briseñas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Buenavista') echo 'selected="selected"'; ?> value="Presidencia Municipal de Buenavista">Presidencia Municipal de Buenavista</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Carácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Carácuaro">Presidencia Municipal de Carácuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Charapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charapan">Presidencia Municipal de Charapan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Charo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charo">Presidencia Municipal de Charo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Chavinda') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chavinda">Presidencia Municipal de Chavinda</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Cheran') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cheran">Presidencia Municipal de Cheran</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Chilchota') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chilchota">Presidencia Municipal de Chilchota</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Chucándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chucándiro">Presidencia Municipal de Chucándiro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Churintzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Churintzio">Presidencia Municipal de Churintzio</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Coeneo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Coeneo">Presidencia Municipal de Coeneo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Cotija') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cotija">Presidencia Municipal de Cotija</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Cuitzeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cuitzeo">Presidencia Municipal de Cuitzeo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Ecuandureo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ecuandureo">Presidencia Municipal de Ecuandureo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Epitacio Huerta') echo 'selected="selected"'; ?> value="Presidencia Municipal de Epitacio Huerta">Presidencia Municipal de Epitacio Huerta</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Erongarícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Erongarícuaro">Presidencia Municipal de Erongarícuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Gabriel Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Gabriel Zamora">Presidencia Municipal de Gabriel Zamora</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Hidalgo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Hidalgo">Presidencia Municipal de Hidalgo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Huandacareo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huandacareo">Presidencia Municipal de Huandacareo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Huaniqueo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huaniqueo">Presidencia Municipal de Huaniqueo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Huetamo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huetamo">Presidencia Municipal de Huetamo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Huiramba') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huiramba">Presidencia Municipal de Huiramba</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Indaparapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Indaparapeo">Presidencia Municipal de Indaparapeo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Irimbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Irimbo">Presidencia Municipal de Irimbo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Ixtlán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ixtlán">Presidencia Municipal de Ixtlán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Jacona') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jacona">Presidencia Municipal de Jacona</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Jiménez') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiménez">Presidencia Municipal de Jiménez</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Jiquilpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiquilpan">Presidencia Municipal de Jiquilpan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de José Sixto Verduzco') echo 'selected="selected"'; ?> value="Presidencia Municipal de José Sixto Verduzco">Presidencia Municipal de José Sixto Verduzco</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Jungapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jungapeo">Presidencia Municipal de Jungapeo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de La Huacana') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Huacana">Presidencia Municipal de La Huacana</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de La Piedad') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Piedad">Presidencia Municipal de La Piedad</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Lagunillas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lagunillas">Presidencia Municipal de Lagunillas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lázaro Cárdenas">Presidencia Municipal de Lázaro Cárdenas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Los Reyes') echo 'selected="selected"'; ?> value="Presidencia Municipal de Los Reyes">Presidencia Municipal de los Reyes</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Madero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Madero">Presidencia Municipal de Madero</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Maravatío') echo 'selected="selected"'; ?> value="Presidencia Municipal de Maravatío">Presidencia Municipal de Maravatío</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Marcos Castellanos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Marcos Castellanos">Presidencia Municipal de Marcos Castellanos</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Morelia') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelia">Presidencia Municipal de Morelia</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Morelos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelos">Presidencia Municipal de Morelos</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Múgica') echo 'selected="selected"'; ?> value="Presidencia Municipal de Múgica">Presidencia Municipal de Múgica</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Nahuatzen') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nahuatzen">Presidencia Municipal de Nahuatzen</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Nocupétaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nocupétaro">Presidencia Municipal de Nocupétaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Nuevo Parangaricutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Parangaricutiro">Presidencia Municipal de Nuevo Parangaricutiro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Nuevo Urecho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Urecho">Presidencia Municipal de Nuevo Urecho</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Numarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Numarán">Presidencia Municipal de Numarán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Ocampo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ocampo">Presidencia Municipal de Ocampo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Pajacuarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pajacuarán">Presidencia Municipal de Pajacuarán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Panindícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Panindícuaro">Presidencia Municipal de Panindícuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Paracho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Paracho">Presidencia Municipal de Paracho</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Pátzcuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pátzcuaro">Presidencia Municipal de Pátzcuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Penjamillo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Penjamillo">Presidencia Municipal de Penjamillo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Peribán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Peribán">Presidencia Municipal de Peribán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Purépero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Purépero">Presidencia Municipal de Purépero</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Puruándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Puruándiro">Presidencia Municipal de Puruándiro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Queréndaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Queréndaro">Presidencia Municipal de Queréndaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Quiroga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Quiroga">Presidencia Municipal de Quiroga</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Sahuayo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Sahuayo">Presidencia Municipal de Sahuayo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Salvador Escalante') echo 'selected="selected"'; ?> value="Presidencia Municipal de Salvador Escalante">Presidencia Municipal de Salvador Escalante</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Santa Ana Maya') echo 'selected="selected"'; ?> value="Presidencia Municipal de Santa Ana Maya">Presidencia Municipal de Santa Ana Maya</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Senguio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Senguio">Presidencia Municipal de Senguio</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tacámbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tacámbaro">Presidencia Municipal de Tacámbaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tancítaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tancítaro">Presidencia Municipal de Tancítaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tangamandapio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangamandapio">Presidencia Municipal de Tangamandapio</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tangancicuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangancicuaro">Presidencia Municipal de Tangancicuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tanhuato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tanhuato">Presidencia Municipal de Tanhuato</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Taretan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Taretan">Presidencia Municipal de Taretan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tarímbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tarímbaro">Presidencia Municipal de Tarímbaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tepalcatepec') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tepalcatepec">Presidencia Municipal de Tepalcatepec</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tingambato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingambato">Presidencia Municipal de Tingambato</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tingüindín') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingüindín">Presidencia Municipal de Tingüindín</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tiquicheo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tiquicheo">Presidencia Municipal de Tiquicheo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tlalpujahua') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlalpujahua">Presidencia Municipal de Tlalpujahua</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tlazazalca') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlazazalca">Presidencia Municipal de Tlazazalca</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tocumbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tocumbo">Presidencia Municipal de Tocumbo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tuxpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuxpan">Presidencia Municipal de Tuxpan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tuzantla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuzantla">Presidencia Municipal de Tuzantla</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tzintzuntzan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzintzuntzan">Presidencia Municipal de Tzintzuntzan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Uruapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Uruapan">Presidencia Municipal de Uruapan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Venustiano Carranza') echo 'selected="selected"'; ?> value="Presidencia Municipal de Venustiano Carranza">Presidencia Municipal de Venustiano Carranza</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Villamar') echo 'selected="selected"'; ?> value="Presidencia Municipal de Villamar">Presidencia Municipal de Villamar</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Vista Hermosa') echo 'selected="selected"'; ?> value="Presidencia Municipal de Vista Hermosa">Presidencia Municipal de Vista Hermosa</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Yurécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Yurécuaro">Presidencia Municipal de Yurécuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Zacapu') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zacapu">Presidencia Municipal de Zacapu</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zamora">Presidencia Municipal de Zamora</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Zináparo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zináparo">Presidencia Municipal de Zináparo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Zinapécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zinapécuaro">Presidencia Municipal de Zinapécuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Ziracuaretiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ziracuaretiro">Presidencia Municipal de Ziracuaretiro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Zitácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zitácuaro">Presidencia Municipal de Zitácuaro</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Procuraduría Agraria En Michoacán') echo 'selected="selected"'; ?> value="Procuraduría Agraria En Michoacán">Procuraduría Agraria En Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Procuraduría Auxiliar de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Auxiliar de la Defensa del Trabajo">Procuraduría Auxiliar de la Defensa del Trabajo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Procuraduría Federal de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Federal de la Defensa del Trabajo">Procuraduría Federal de la Defensa del Trabajo</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Procuraduría Federal del Consumidor PROFECO') echo 'selected="selected"'; ?> value="Procuraduría Federal del Consumidor PROFECO">Procuraduría Federal del Consumidor PROFECO</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Quejas Sin Autoridad Señalada Como Responsable') echo 'selected="selected"'; ?> value="Quejas Sin Autoridad Señalada Como Responsable">Quejas Sin Autoridad Señalada Como Responsable</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Contraloría del Estado') echo 'selected="selected"'; ?> value="Secretaria de Contraloría del Estado">Secretaria de Contraloría del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaría de Bienestar') echo 'selected="selected"'; ?> value="Secretaría de Bienestar">Secretaría de Bienestar</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Comunicaciones y Obras Publicas') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Obras Publicas">Secretaria de Comunicaciones y Obras Publicas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Comunicaciones y Transportes SCT') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Transportes SCT">Secretaria de Comunicaciones y Transportes SCT</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Cultura en el Estado') echo 'selected="selected"'; ?> value="Secretaria de Cultura en el Estado">Secretaria de Cultura en el Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Desarrollo Económico') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Económico">Secretaria de Desarrollo Económico</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Desarrollo Rural y Agroalimentario') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Rural y Agroalimentario">Secretaria de Desarrollo Rural y Agroalimentario</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaría de Desarrollo Social y Humano') echo 'selected="selected"'; ?> value="Secretaría de Desarrollo Social y Humano">Secretaría de Desarrollo Social y Humano</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Desarrollo Territorial Urbano y Movilidad') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Territorial Urbano y Movilidad">Secretaria de Desarrollo Territorial Urbano y Movilidad</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Educación del Estado') echo 'selected="selected"'; ?> value="Secretaria de Educación del Estado">Secretaria de Educación del Estado</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Educación Pública Federal') echo 'selected="selected"'; ?> value="Secretaria de Educación Pública Federal">Secretaria de Educación Pública Federal</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Finanzas y Administración') echo 'selected="selected"'; ?> value="Secretaria de Finanzas y Administración">Secretaria de Finanzas y Administración</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaría de Gobernación') echo 'selected="selected"'; ?> value="Secretaría de Gobernación">Secretaría de Gobernación</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Gobierno') echo 'selected="selected"'; ?> value="Secretaria de Gobierno">Secretaria de Gobierno</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas') echo 'selected="selected"'; ?> value="Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas">Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de la Defensa Nacional Ejercito Mexicano') echo 'selected="selected"'; ?> value="Secretaria de la Defensa Nacional Ejercito Mexicano">Secretaria de la Defensa Nacional Ejercito Mexicano</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de los Migrantes En El Extranjero') echo 'selected="selected"'; ?> value="Secretaria de los Migrantes En El Extranjero">Secretaria de los Migrantes En El Extranjero</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Marina y Armada de México') echo 'selected="selected"'; ?> value="Secretaria de Marina y Armada de México">Secretaria de Marina y Armada de México</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Relaciones Exteriores SRE') echo 'selected="selected"'; ?> value="Secretaria de Relaciones Exteriores SRE">Secretaria de Relaciones Exteriores SRE</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Salud') echo 'selected="selected"'; ?> value="Secretaria de Salud">Secretaria de Salud</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Seguridad Publica Estatal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Estatal">Secretaria de Seguridad Publica Estatal</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Seguridad Publica Federal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Federal">Secretaria de Seguridad Publica Federal</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria de Seguridad y Protección Ciudadana') echo 'selected="selected"'; ?> value="Secretaria de Seguridad y Protección Ciudadana">Secretaria de Seguridad y Protección Ciudadana</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Secretaria del Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Secretaria del Trabajo y Previsión Social">Secretaria del Trabajo y Previsión Social</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia') echo 'selected="selected"'; ?> value="Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia">Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Sistema Michoacano de Radio y Televisión') echo 'selected="selected"'; ?> value="Sistema Michoacano de Radio y Televisión">Sistema Michoacano de Radio y Televisión</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Sistema Para el Desarrollo Integral de la Familia DIF') echo 'selected="selected"'; ?> value="Sistema Para el Desarrollo Integral de la Familia DIF">Sistema Para el Desarrollo Integral de la Familia DIF</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Supremo Tribunal de Justicia') echo 'selected="selected"'; ?> value="Supremo Tribunal de Justicia">Supremo Tribunal de Justicia</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Telebachillerato de Michoacán') echo 'selected="selected"'; ?> value="Telebachillerato de Michoacán">Telebachillerato de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Tribunal de Conciliación y Arbitraje del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Conciliación y Arbitraje del Estado de Michoacán">Tribunal de Conciliación y Arbitraje del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Tribunal de Justicia Administrativa del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Justicia Administrativa del Estado de Michoacán">Tribunal de Justicia Administrativa del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Universidad Intercultural Indígena de Michoacán') echo 'selected="selected"'; ?> value="Universidad Intercultural Indígena de Michoacán">Universidad Intercultural Indígena de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Universidad Michoacana de San Nicolas de Hidalgo UMSNH') echo 'selected="selected"'; ?> value="Universidad Michoacana de San Nicolas de Hidalgo UMSNH">Universidad Michoacana de San Nicolas de Hidalgo UMSNH</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Universidad Virtual del Estado de Michoacán') echo 'selected="selected"'; ?> value="Universidad Virtual del Estado de Michoacán">Universidad Virtual del Estado de Michoacán</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Visitaduría Morelia') echo 'selected="selected"'; ?> value="Visitaduría Morelia">Visitaduría Morelia</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Visitaduría Uruapan') echo 'selected="selected"'; ?> value="Visitaduría Uruapan">Visitaduría Uruapan</option>
                                <option <?php if ($e_recomendacion['autoridad_responsable'] === 'Presidencia Municipal de Tzitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzitzio">Presidencia Municipal de Tzitzio</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="servidor_publico">Servidor público</label>
                            <input type="text" class="form-control" name="servidor_publico" value="<?php echo remove_junk($e_recomendacion['servidor_publico']); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="fecha_acuerdo">Fecha de Recomendación</label><br>
                            <input type="date" class="form-control" name="fecha_acuerdo" value="<?php echo remove_junk($e_recomendacion['fecha_recomendacion']); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="observaciones">Observaciones</label>
                            <textarea class="form-control" name="observaciones" id="observaciones" cols="10" rows="1" value="<?php echo remove_junk($e_recomendacion['observaciones']); ?>"><?php echo remove_junk($e_recomendacion['observaciones']); ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto">Recomendación Adjunto</label>
                                <input id="recomendacion_adjunto" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_recomendacion['recomendacion_adjunto']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <span>
                                <label for="recomendacion_adjunto_publico">Recomendación Pública Adjunto</label>
                                <input id="recomendacion_adjunto_publico" type="file" accept="application/pdf" class="form-control" name="recomendacion_adjunto_publico">
                                <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_recomendacion['recomendacion_adjunto_publico']); ?><?php ?></label>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <a href="recomendaciones_generales.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                        Regresar
                    </a>
                    <button type="submit" name="edit_recomendacion_general" class="btn btn-primary" value="subir">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
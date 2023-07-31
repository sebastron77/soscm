<?php
$page_title = 'Ficha Técnica - Área Psicológica';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$nivel = $user['user_level'];
$areas = find_all_area_orden('area');
$tipo_ficha = find_tipo_ficha((int)$_GET['id']);



if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    page_require_level(4);
}
if ($nivel == 5) {
    redirect('home.php');
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}
?>
<?php
$e_ficha = find_by_id_ficha((int)$_GET['id'],2);
if (!$e_ficha) {
    $session->msg("d", "id de ficha no encontrado.");
    redirect('fichas_psic.php');
}
?>
<?php
if (isset($_POST['edit_ficha_psic'])) {
    $req_fields = array('funcion', 'num_queja', 'area_solicitante', 'visitaduria', 'ocupacion', 'escolaridad', 'hechos', 'autoridad', 'nombre_usuario', 'edad', 'sexo', 'grupo_vulnerable', 'fecha_intervencion', 'resultado', 'documento_emitido');
    validate_fields($req_fields);
    if (empty($errors)) {
        $id = (int)$e_ficha['id'];
        $funcion   = remove_junk($db->escape($_POST['funcion']));
        $num_queja   = remove_junk($db->escape($_POST['num_queja']));
        $visitaduria   = remove_junk($db->escape($_POST['visitaduria']));
        $area_solicitante   = remove_junk($db->escape($_POST['area_solicitante']));
        $ocupacion   = remove_junk(($db->escape($_POST['ocupacion'])));
        $escolaridad   = remove_junk(($db->escape($_POST['escolaridad'])));
        $hechos   = remove_junk(($db->escape($_POST['hechos'])));
        $autoridad   = remove_junk(($db->escape($_POST['autoridad'])));
        $nombre_usuario   = remove_junk($db->escape($_POST['nombre_usuario']));
        $edad   = remove_junk($db->escape($_POST['edad']));
        $sexo   = remove_junk($db->escape($_POST['sexo']));
        $grupo_vulnerable   = remove_junk($db->escape($_POST['grupo_vulnerable']));
        $fecha_intervencion   = remove_junk($db->escape($_POST['fecha_intervencion']));
        $resultado2   = remove_junk($db->escape($_POST['resultado']));
        $documento_emitido   = remove_junk($db->escape($_POST['documento_emitido']));
        $adjunto   = remove_junk($db->escape($_POST['ficha_adjunto']));
        $protocolo_estambul   = remove_junk($db->escape($_POST['protocolo_estambul']));
        $nombre_especialista   = remove_junk($db->escape($_POST['nombre_especialista']));
        $clave_documento   = remove_junk($db->escape($_POST['clave_documento']));

        $folio_editar = $e_ficha['folio'];
        $resultado = str_replace("/", "-", $folio_editar);
        $carpeta = 'uploads/fichastecnicas/' . $resultado;

        $name = $_FILES['ficha_adjunto']['name'];
        $size = $_FILES['ficha_adjunto']['size'];
        $type = $_FILES['ficha_adjunto']['type'];
        $temp = $_FILES['ficha_adjunto']['tmp_name'];

        if (is_dir($carpeta)) {
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        } else {
            mkdir($carpeta, 0777, true);
            $move =  move_uploaded_file($temp, $carpeta . "/" . $name);
        }

        if ($name != '') {
            $sql = "UPDATE fichas SET funcion='{$funcion}', num_queja='{$num_queja}', visitaduria='{$visitaduria}', area_solicitante='{$area_solicitante}', ocupacion='{$ocupacion}', escolaridad='{$escolaridad}', hechos='{$hechos}', autoridad='{$autoridad}', nombre_usuario='{$nombre_usuario}',edad='{$edad}', sexo='{$sexo}', grupo_vulnerable='{$grupo_vulnerable}', fecha_intervencion='{$fecha_intervencion}', resultado='{$resultado2}', documento_emitido='{$documento_emitido}', ficha_adjunto='{$name}', protocolo_estambul='{$protocolo_estambul}',nombre_especialista='{$nombre_especialista}', clave_documento='{$clave_documento}' WHERE id='{$db->escape($id)}'";
        }
        if ($name == '') {
            $sql = "UPDATE fichas SET funcion='{$funcion}', num_queja='{$num_queja}', visitaduria='{$visitaduria}', area_solicitante='{$area_solicitante}', ocupacion='{$ocupacion}', escolaridad='{$escolaridad}', hechos='{$hechos}', autoridad='{$autoridad}', nombre_usuario='{$nombre_usuario}',edad='{$edad}', sexo='{$sexo}', grupo_vulnerable='{$grupo_vulnerable}', fecha_intervencion='{$fecha_intervencion}', resultado='{$resultado2}', documento_emitido='{$documento_emitido}', protocolo_estambul='{$protocolo_estambul}',nombre_especialista='{$nombre_especialista}', clave_documento='{$clave_documento}' WHERE id='{$db->escape($id)}'";
        }
        $result = $db->query($sql);
        if ($result && $db->affected_rows() === 1) {
            $session->msg('s', "Información Actualizada ");
            redirect('fichas_psic.php', false);
        } else {
            $session->msg('d', ' Lo siento no se actualizaron los datos.');
            redirect('fichas_psic.php', false);
        }
    } else {
        $session->msg("d", $errors);
        redirect('edit_ficha_psic.php?id=' . (int)$e_ficha['id'], false);
    }
}
?>
<?php include_once('layouts/header.php'); ?>
<div class="row">
    <div class="panel panel-default">
        <div class="panel-heading">
            <strong>
                <span class="glyphicon glyphicon-th"></span>
                <span>Editar ficha - Área Psicológica</span>
            </strong>
        </div>
        <div class="panel-body">
            <form method="post" action="edit_ficha_psic.php?id=<?php echo (int)$e_ficha['id']; ?>" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="funcion">Función</label>
                            <select class="form-control" name="funcion">
                                <option <?php if ($e_ficha['funcion'] === 'Valoración Psicológica') echo 'selected="selected"'; ?> value="Valoración Psicológica">Valoración Psicológica</option>
                                <option <?php if ($e_ficha['funcion'] === 'Contención Psicológica') echo 'selected="selected"'; ?> value="Contención Psicológica">Contención Psicológica</option>
                                <option <?php if ($e_ficha['funcion'] === 'Orientación y Canalización Psicológica') echo 'selected="selected"'; ?> value="Orientación y Canalización Psicológica">Orientación y Canalización Psicológica</option>
                                <option <?php if ($e_ficha['funcion'] === 'Supervisión y Diagnóstico Institucional') echo 'selected="selected"'; ?> value="Supervisión y Diagnóstico Institucional">Supervisión y Diagnóstico Institucional</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="num_queja">No. de Queja</label>
                            <input type="text" class="form-control" value="<?php echo remove_junk($e_ficha['num_queja']); ?>" name="num_queja" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="area_solicitante">Área Solicitante</label>
                            <select class="form-control" name="area_solicitante">
                                <?php foreach ($areas as $area) : ?>
                                    <option <?php if ($area['nombre_area'] === $e_ficha['area_solicitante']) echo 'selected="selected"'; ?> value="<?php echo $area['nombre_area']; ?>"><?php echo ucwords($area['nombre_area']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="ocupacion">Ocupacion</label>
                            <select class="form-control" name="ocupacion">
                                <option <?php if ($e_ficha['ocupacion'] === 'Otro') echo 'selected="selected"'; ?> value="Otro">Otro</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Agricultor(a)') echo 'selected="selected"'; ?> value="Agricultor(a)">Agricultor(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Albañil') echo 'selected="selected"'; ?> value="Albañil">Albañil</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Ama de Casa') echo 'selected="selected"'; ?> value="Ama de Casa">Ama de Casa</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Artista') echo 'selected="selected"'; ?> value="Artista">Artista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Artesano(a)') echo 'selected="selected"'; ?> value="Artesano(a)">Artesano(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Pescador(a)') echo 'selected="selected"'; ?> value="Pescador(a)">Pescador(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Camionero(a)') echo 'selected="selected"'; ?> value="Camionero(a)">Camionero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Carpintero(a)') echo 'selected="selected"'; ?> value="Carpintero(a)">Carpintero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Cocinero(a)') echo 'selected="selected"'; ?> value="Cocinero(a)">Cocinero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Comerciante') echo 'selected="selected"'; ?> value="Comerciante">Comerciante</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Chofer') echo 'selected="selected"'; ?> value="Chofer">Chofer</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Deportista') echo 'selected="selected"'; ?> value="Deportista">Deportista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Empleada doméstica') echo 'selected="selected"'; ?> value="Empleada doméstica">Empleada doméstica</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Servidor(a) público(a)') echo 'selected="selected"'; ?> value="Servidor(a) público(a)">Servidor(a) público(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Empleado(a) de negocio') echo 'selected="selected"'; ?> value="Empleado(a) de negocio">Empleado(a) de negocio</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Empresario(a)') echo 'selected="selected"'; ?> value="Empresario(a)">Empresario(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Estilista') echo 'selected="selected"'; ?> value="Estilista">Estilista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Estudiante') echo 'selected="selected"'; ?> value="Estudiante">Estudiante</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Ganadero(a)') echo 'selected="selected"'; ?> value="Ganadero(a)">Ganadero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Intendente') echo 'selected="selected"'; ?> value="Intendente">Intendente</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Jornalero(a)') echo 'selected="selected"'; ?> value="Jornalero(a)">Jornalero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Jubilado(a)') echo 'selected="selected"'; ?> value="Jubilado(a)">Jubilado(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Locutor(a)') echo 'selected="selected"'; ?> value="Locutor(a)">Locutor(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Profesor(a)') echo 'selected="selected"'; ?> value="Profesor(a)">Profesor(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Mecánico(a)') echo 'selected="selected"'; ?> value="Mecánico(a)">Mecánico(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Migrante') echo 'selected="selected"'; ?> value="Migrante">Migrante</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Parroco') echo 'selected="selected"'; ?> value="Parroco">Parroco</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Peluquero(a)') echo 'selected="selected"'; ?> value="Peluquero(a)">Peluquero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Pensionado(a)') echo 'selected="selected"'; ?> value="Pensionado(a)">Pensionado(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Periodista') echo 'selected="selected"'; ?> value="Periodista">Periodista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Plomero(a)') echo 'selected="selected"'; ?> value="Plomero(a)">Plomero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Reportero(a)') echo 'selected="selected"'; ?> value="Reportero(a)">Reportero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Servidor(a) sexual') echo 'selected="selected"'; ?> value="Servidor(a) sexual">Servidor(a) sexual</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Taxista') echo 'selected="selected"'; ?> value="Taxista">Taxista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Transportista') echo 'selected="selected"'; ?> value="Transportista">Transportista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Interno(a)') echo 'selected="selected"'; ?> value="Interno(a)">Interno(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Franelero') echo 'selected="selected"'; ?> value="Franelero">Franelero</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Desempleado') echo 'selected="selected"'; ?> value="Desempleado">Desempleado</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Contratista') echo 'selected="selected"'; ?> value="Contratista">Contratista</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Policia') echo 'selected="selected"'; ?> value="Policia">Policia</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Ninguno') echo 'selected="selected"'; ?> value="Ninguno">Ninguno</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Litigante') echo 'selected="selected"'; ?> value="Litigante">Litigante</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Defensor(a) civil de los derechos humanos') echo 'selected="selected"'; ?> value="Defensor(a) civil de los derechos humanos">Defensor(a) civil de los derechos humanos</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Profesionista práctica privada') echo 'selected="selected"'; ?> value="Profesionista práctica privada">Profesionista práctica privada</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Investigador(a)') echo 'selected="selected"'; ?> value="Investigador(a)">Investigador(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Obrero(a)') echo 'selected="selected"'; ?> value="Obrero(a)">Obrero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Enfermera(o) especialista en salud') echo 'selected="selected"'; ?> value="Enfermera(o) especialista en salud">Enfermera(o) especialista en salud</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Auxiliar en actividades administrativas') echo 'selected="selected"'; ?> value="Auxiliar en actividades administrativas">Auxiliar en actividades administrativas</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Secretaria(o)') echo 'selected="selected"'; ?> value="Secretaria(o)">Secretaria(o)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Cajero(a)') echo 'selected="selected"'; ?> value="Cajero(a)">Cajero(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Comerciante en establecimiento') echo 'selected="selected"'; ?> value="Comerciante en establecimiento">Comerciante en establecimiento</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Comerciante Ambulante') echo 'selected="selected"'; ?> value="Comerciante Ambulante">Comerciante Ambulante</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Atención al público') echo 'selected="selected"'; ?> value="Atención al público">Atención al público</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Empleado(a) del sector público') echo 'selected="selected"'; ?> value="Empleado(a) del sector público">Empleado(a) del sector público</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Empleado(a) del sector privado') echo 'selected="selected"'; ?> value="Empleado(a) del sector privado">Empleado(a) del sector privado</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Preparación y servicio de alimentos') echo 'selected="selected"'; ?> value="Preparación y servicio de alimentos">Preparación y servicio de alimentos</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Cuidados personales y del hogar') echo 'selected="selected"'; ?> value="Cuidados personales y del hogar">Cuidados personales y del hogar</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Servicios de protección y vigilancia') echo 'selected="selected"'; ?> value="Servicios de protección y vigilancia">Servicios de protección y vigilancia</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Armada, ejercito y fuerza aérea') echo 'selected="selected"'; ?> value="Armada, ejercito y fuerza aérea">Armada, ejercito y fuerza aérea</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Actividades agrícolas y ganaderas') echo 'selected="selected"'; ?> value="Actividades agrícolas y ganaderas">Actividades agrícolas y ganaderas</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Actividades pesqueras, forestales, caza y similares') echo 'selected="selected"'; ?> value="Actividades pesqueras, forestales, caza y similares">Actividades pesqueras, forestales, caza y similares</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Operador(a) de maquinaria pesada') echo 'selected="selected"'; ?> value="Operador(a) de maquinaria pesada">Operador(a) de maquinaria pesada</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Extracción y edificador de construcciones') echo 'selected="selected"'; ?> value="Extracción y edificador de construcciones">Extracción y edificador de construcciones</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Ensamblador(a)') echo 'selected="selected"'; ?> value="Ensamblador(a)">Ensamblador(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Agente de ventas') echo 'selected="selected"'; ?> value="Agente de ventas">Agente de ventas</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Pintor(a)') echo 'selected="selected"'; ?> value="Pintor(a)">Pintor(a)</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Trabajador(a) de apoyo para espectaculos') echo 'selected="selected"'; ?> value="Trabajador(a) de apoyo para espectaculos">Trabajador(a) de apoyo para espectaculos</option>
                                <option <?php if ($e_ficha['ocupacion'] === 'Repartidor(a) de mercancias') echo 'selected="selected"'; ?> value="Repartidor(a) de mercancias">Repartidor(a) de mercancias</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="escolaridad">Escolaridad</label>
                            <select class="form-control" name="escolaridad">
                                <option <?php if ($e_ficha['escolaridad'] === 'Sin estudios') echo 'selected="selected"'; ?> value="Sin estudios">Sin estudios</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Primaria') echo 'selected="selected"'; ?> value="Primaria">Primaria</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Secundaria') echo 'selected="selected"'; ?> value="Secundaria">Secundaria</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Preparatoria') echo 'selected="selected"'; ?> value="Preparatoria">Preparatoria</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Licenciatura') echo 'selected="selected"'; ?> value="Licenciatura">Licenciatura</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Especialidad') echo 'selected="selected"'; ?> value="Especialidad">Especialidad</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Maestría') echo 'selected="selected"'; ?> value="Maestría">Maestría</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Doctorado') echo 'selected="selected"'; ?> value="Doctorado">Doctorado</option>
                                <option <?php if ($e_ficha['escolaridad'] === 'Pos Doctorado') echo 'selected="selected"'; ?> value="Pos Doctorado">Pos Doctorado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="visitaduria">Visitaduria</label>
                            <select class="form-control" name="visitaduria">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Apatzingán') echo 'selected="selected"'; ?> value="Regional de Apatzingán">Regional de Apatzingán</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Regional de Lázaro Cárdenas">Regional de Lázaro Cárdenas</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Morelia') echo 'selected="selected"'; ?> value="Regional de Morelia">Regional de Morelia</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Uruapan') echo 'selected="selected"'; ?> value="Regional de Uruapan">Regional de Uruapan</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de Paracho') echo 'selected="selected"'; ?> value="Auxiliar de Paracho">Auxiliar de Paracho</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Zamora') echo 'selected="selected"'; ?> value="Regional de Zamora">Regional de Zamora</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de La Piedad') echo 'selected="selected"'; ?> value="Auxiliar de La Piedad">Auxiliar de La Piedad</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Regional de Zitácuaro') echo 'selected="selected"'; ?> value="Regional de Zitácuaro">Regional de Zitácuaro</option>
                                <option <?php if ($e_ficha['visitaduria'] === 'Auxiliar de Huetamo') echo 'selected="selected"'; ?> value="Auxiliar de Huetamo">Auxiliar de Huetamo</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="hechos">Presuntos hechos violatorios</label>
                            <select class="form-control" name="hechos">
                                <option <?php if ($e_ficha['hechos'] === 'Preservar la vida humana') echo 'selected="selected"'; ?> value="Preservar la vida humana">Preservar la vida humana</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser privado de la vida arbitraria extrajudicial o sumaramente') echo 'selected="selected"'; ?> value="No ser privado de la vida arbitraria extrajudicial o sumaramente">No ser privado de la vida arbitraria extrajudicial o sumaramente</option>
                                <option <?php if ($e_ficha['hechos'] === 'Preservar la vida del producto de la concepción') echo 'selected="selected"'; ?> value="Preservar la vida del producto de la concepción">Preservar la vida del producto de la concepción</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser victima de genocidio') echo 'selected="selected"'; ?> value="No ser victima de genocidio">No ser victima de genocidio</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de creencia religiosa') echo 'selected="selected"'; ?> value="La libertad de creencia religiosa">La libertad de creencia religiosa</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de objeción de conciencia') echo 'selected="selected"'; ?> value="La libertad de objeción de conciencia">La libertad de objeción de conciencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de expresión') echo 'selected="selected"'; ?> value="La libertad de expresión">La libertad de expresión</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de asociación') echo 'selected="selected"'; ?> value="La libertad de asociación">La libertad de asociación</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de reunión') echo 'selected="selected"'; ?> value="La libertad de reunión">La libertad de reunión</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de defender a los derechos humanos') echo 'selected="selected"'; ?> value="La libertad de defender a los derechos humanos">La libertad de defender a los derechos humanos</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de procreación') echo 'selected="selected"'; ?> value="La libertad de procreación">La libertad de procreación</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad sexual') echo 'selected="selected"'; ?> value="La libertad sexual">La libertad sexual</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de transito') echo 'selected="selected"'; ?> value="La libertad de transito">La libertad de transito</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de privación ilegal de la libertad') echo 'selected="selected"'; ?> value="No ser sujeto de privación ilegal de la libertad">No ser sujeto de privación ilegal de la libertad</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de retención ilegal') echo 'selected="selected"'; ?> value="No ser sujeto de retención ilegal">No ser sujeto de retención ilegal</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de detención ilegal') echo 'selected="selected"'; ?> value="No ser sujeto de detención ilegal">No ser sujeto de detención ilegal</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto a trata de personas') echo 'selected="selected"'; ?> value="No ser sujeto a trata de personas">No ser sujeto a trata de personas</option>
                                <option <?php if ($e_ficha['hechos'] === 'A la dignidad') echo 'selected="selected"'; ?> value="A la dignidad">A la dignidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido a violencia institucional') echo 'selected="selected"'; ?> value="No ser sometido a violencia institucional">No ser sometido a violencia institucional</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser discriminado') echo 'selected="selected"'; ?> value="No ser discriminado">No ser discriminado</option>
                                <option <?php if ($e_ficha['hechos'] === 'La honra') echo 'selected="selected"'; ?> value="La honra">La honra</option>
                                <option <?php if ($e_ficha['hechos'] === 'La intimidad') echo 'selected="selected"'; ?> value="La intimidad">La intimidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'La identidad') echo 'selected="selected"'; ?> value="La identidad">La identidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Igualdad de oportunidades') echo 'selected="selected"'; ?> value="Igualdad de oportunidades">Igualdad de oportunidades</option>
                                <option <?php if ($e_ficha['hechos'] === 'Proyecto de vida') echo 'selected="selected"'; ?> value="Proyecto de vida">Proyecto de vida</option>
                                <option <?php if ($e_ficha['hechos'] === 'La protección de la familia') echo 'selected="selected"'; ?> value="La protección de la familia">La protección de la familia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Equidad de género') echo 'selected="selected"'; ?> value="Equidad de género">Equidad de género</option>
                                <option <?php if ($e_ficha['hechos'] === 'Libre desarrollo de la personalidad') echo 'selected="selected"'; ?> value="Libre desarrollo de la personalidad">Libre desarrollo de la personalidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una imagen propia') echo 'selected="selected"'; ?> value="Una imagen propia">Una imagen propia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Trato diferenciado y preferente') echo 'selected="selected"'; ?> value="Trato diferenciado y preferente">Trato diferenciado y preferente</option>
                                <option <?php if ($e_ficha['hechos'] === 'Personas con algún tipo de discapacidad') echo 'selected="selected"'; ?> value="Personas con algún tipo de discapacidad">Personas con algún tipo de discapacidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido a tortura') echo 'selected="selected"'; ?> value="No ser sometido a tortura">No ser sometido a tortura</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido a penas o tratos crueles inhumanos y degradantes') echo 'selected="selected"'; ?> value="No ser sometido a penas o tratos crueles inhumanos y degradantes">No ser sometido a penas o tratos crueles inhumanos y degradantes</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido al uso desproporcionado o indebido de la fuerza pública') echo 'selected="selected"'; ?> value="No ser sometido al uso desproporcionado o indebido de la fuerza pública">No ser sometido al uso desproporcionado o indebido de la fuerza pública</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de desaparición forzada') echo 'selected="selected"'; ?> value="No ser sujeto de desaparición forzada">No ser sujeto de desaparición forzada</option>
                                <option <?php if ($e_ficha['hechos'] === 'Protección contra toda forma de violencia') echo 'selected="selected"'; ?> value="Protección contra toda forma de violencia">Protección contra toda forma de violencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La posesión y portación de armas') echo 'selected="selected"'; ?> value="La posesión y portación de armas">La posesión y portación de armas</option>
                                <option <?php if ($e_ficha['hechos'] === 'Acceso a la justicia') echo 'selected="selected"'; ?> value="Acceso a la justicia">Acceso a la justicia</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de incomunicación') echo 'selected="selected"'; ?> value="No ser sujeto de incomunicación">No ser sujeto de incomunicación</option>
                                <option <?php if ($e_ficha['hechos'] === 'Debida diligencia') echo 'selected="selected"'; ?> value="Debida diligencia">Debida diligencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Garantía de audiencia') echo 'selected="selected"'; ?> value="Garantía de audiencia">Garantía de audiencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La fundamentación y motivación') echo 'selected="selected"'; ?> value="La fundamentación y motivación">La fundamentación y motivación</option>
                                <option <?php if ($e_ficha['hechos'] === 'La presunción de inocencia') echo 'selected="selected"'; ?> value="La presunción de inocencia">La presunción de inocencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La irretroactividad de la ley') echo 'selected="selected"'; ?> value="La irretroactividad de la ley">La irretroactividad de la ley</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una fianza asequible') echo 'selected="selected"'; ?> value="Una fianza asequible">Una fianza asequible</option>
                                <option <?php if ($e_ficha['hechos'] === 'La oportuna y adecuada adopción de medidas cautelares') echo 'selected="selected"'; ?> value="La oportuna y adecuada adopción de medidas cautelares">La oportuna y adecuada adopción de medidas cautelares</option>
                                <option <?php if ($e_ficha['hechos'] === 'Del imputado a recibir información') echo 'selected="selected"'; ?> value="Del imputado a recibir información">Del imputado a recibir información</option>
                                <option <?php if ($e_ficha['hechos'] === 'Preservar custodiar y  conservar las actuaciones ministeriales') echo 'selected="selected"'; ?> value="Preservar custodiar y  conservar las actuaciones ministeriales">Preservar custodiar y  conservar las actuaciones ministeriales</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una valoración y certificación médica') echo 'selected="selected"'; ?> value="Una valoración y certificación médica">Una valoración y certificación médica</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una adecuada administración y procuración de justicia') echo 'selected="selected"'; ?> value="Una adecuada administración y procuración de justicia">Una adecuada administración y procuración de justicia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una defensa adecuada') echo 'selected="selected"'; ?> value="Una defensa adecuada">Una defensa adecuada</option>
                                <option <?php if ($e_ficha['hechos'] === 'Que se proporcione traductor o interprete') echo 'selected="selected"'; ?> value="Que se proporcione traductor o interprete">Que se proporcione traductor o interprete</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una oportuna y adecuada ejecución de los mandamientos judiciales') echo 'selected="selected"'; ?> value="Una oportuna y adecuada ejecución de los mandamientos judiciales">Una oportuna y adecuada ejecución de los mandamientos judiciales</option>
                                <option <?php if ($e_ficha['hechos'] === 'Los medios alternativos de ejecución de controversias') echo 'selected="selected"'; ?> value="Los medios alternativos de ejecución de controversias">Los medios alternativos de ejecución de controversias</option>
                                <option <?php if ($e_ficha['hechos'] === 'La inviolabilidad del domicilio') echo 'selected="selected"'; ?> value="La inviolabilidad del domicilio">La inviolabilidad del domicilio</option>
                                <option <?php if ($e_ficha['hechos'] === 'La propiedad y a la posesión') echo 'selected="selected"'; ?> value="La propiedad y a la posesión">La propiedad y a la posesión</option>
                                <option <?php if ($e_ficha['hechos'] === 'La inviolabilidad de la correspondencia') echo 'selected="selected"'; ?> value="La inviolabilidad de la correspondencia">La inviolabilidad de la correspondencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La confidencialidad de las comunicaciones') echo 'selected="selected"'; ?> value="La confidencialidad de las comunicaciones">La confidencialidad de las comunicaciones</option>
                                <option <?php if ($e_ficha['hechos'] === 'La inviolabilidad del secreto profesional') echo 'selected="selected"'; ?> value="La inviolabilidad del secreto profesional">La inviolabilidad del secreto profesional</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir asesoría para la defensa de sus intereses') echo 'selected="selected"'; ?> value="Recibir asesoría para la defensa de sus intereses">Recibir asesoría para la defensa de sus intereses</option>
                                <option <?php if ($e_ficha['hechos'] === 'Ser informado de los intereses en que tenga interés legitimo') echo 'selected="selected"'; ?> value="Ser informado de los intereses en que tenga interés legitimo">Ser informado de los intereses en que tenga interés legitimo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Coadyubar con el ministerio público en la investigación de los delitos') echo 'selected="selected"'; ?> value="Coadyubar con el ministerio público en la investigación de los delitos">Coadyubar con el ministerio público en la investigación de los delitos</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir atención médica psicológica y tratamiento especializado') echo 'selected="selected"'; ?> value="Recibir atención médica psicológica y tratamiento especializado">Recibir atención médica psicológica y tratamiento especializado</option>
                                <option <?php if ($e_ficha['hechos'] === 'Reparación integral') echo 'selected="selected"'; ?> value="Reparación integral">Reparación integral</option>
                                <option <?php if ($e_ficha['hechos'] === 'La adopción de medidas cautelares') echo 'selected="selected"'; ?> value="La adopción de medidas cautelares">La adopción de medidas cautelares</option>
                                <option <?php if ($e_ficha['hechos'] === 'Impugnar las resoluciones en su agravio') echo 'selected="selected"'; ?> value="Impugnar las resoluciones en su agravio">Impugnar las resoluciones en su agravio</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sujeto de victimización secundaria') echo 'selected="selected"'; ?> value="No ser sujeto de victimización secundaria">No ser sujeto de victimización secundaria</option>
                                <option <?php if ($e_ficha['hechos'] === 'Las personas en situación de desplazamiento forzado') echo 'selected="selected"'; ?> value="Las personas en situación de desplazamiento forzado">Las personas en situación de desplazamiento forzado</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir educación de calidad') echo 'selected="selected"'; ?> value="Recibir educación de calidad">Recibir educación de calidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Acceso a la educación') echo 'selected="selected"'; ?> value="Acceso a la educación">Acceso a la educación</option>
                                <option <?php if ($e_ficha['hechos'] === 'La gratuidad de la educación') echo 'selected="selected"'; ?> value="La gratuidad de la educación">La gratuidad de la educación</option>
                                <option <?php if ($e_ficha['hechos'] === 'Educación laica') echo 'selected="selected"'; ?> value="Educación laica">Educación laica</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir educación en igualdad de trato y condiciones') echo 'selected="selected"'; ?> value="Recibir educación en igualdad de trato y condiciones">Recibir educación en igualdad de trato y condiciones</option>
                                <option <?php if ($e_ficha['hechos'] === 'La adecuada supervisión de la educación impartida por particulares') echo 'selected="selected"'; ?> value="La adecuada supervisión de la educación impartida por particulares">La adecuada supervisión de la educación impartida por particulares</option>
                                <option <?php if ($e_ficha['hechos'] === 'La educación especial') echo 'selected="selected"'; ?> value="La educación especial">La educación especial</option>
                                <option <?php if ($e_ficha['hechos'] === 'La elección de la educación de los hijos') echo 'selected="selected"'; ?> value="La elección de la educación de los hijos">La elección de la educación de los hijos</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una educación libre de violencia') echo 'selected="selected"'; ?> value="Una educación libre de violencia">Una educación libre de violencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Respeto a la situación jurídica') echo 'selected="selected"'; ?> value="Respeto a la situación jurídica">Respeto a la situación jurídica</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una estancia digna y segura') echo 'selected="selected"'; ?> value="Una estancia digna y segura">Una estancia digna y segura</option>
                                <option <?php if ($e_ficha['hechos'] === 'Protección de la integridad') echo 'selected="selected"'; ?> value="Protección de la integridad">Protección de la integridad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Desarrollo de actividades productivas y educativas') echo 'selected="selected"'; ?> value="Desarrollo de actividades productivas y educativas">Desarrollo de actividades productivas y educativas</option>
                                <option <?php if ($e_ficha['hechos'] === 'La vinculación social del interno') echo 'selected="selected"'; ?> value="La vinculación social del interno">La vinculación social del interno</option>
                                <option <?php if ($e_ficha['hechos'] === 'Mantenimiento del orden y aplicación de sanciones') echo 'selected="selected"'; ?> value="Mantenimiento del orden y aplicación de sanciones">Mantenimiento del orden y aplicación de sanciones</option>
                                <option <?php if ($e_ficha['hechos'] === 'Atención de grupos especiales dentro de instituciones penitenciarias') echo 'selected="selected"'; ?> value="Atención de grupos especiales dentro de instituciones penitenciarias">Atención de grupos especiales dentro de instituciones penitenciarias</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir atención médica integral') echo 'selected="selected"'; ?> value="Recibir atención médica integral">Recibir atención médica integral</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una atención médica libre de negligencia') echo 'selected="selected"'; ?> value="Una atención médica libre de negligencia">Una atención médica libre de negligencia</option>
                                <option <?php if ($e_ficha['hechos'] === 'La accesibilidad de los servicios de salud') echo 'selected="selected"'; ?> value="La accesibilidad de los servicios de salud">La accesibilidad de los servicios de salud</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir un trato digno y respetuoso') echo 'selected="selected"'; ?> value="Recibir un trato digno y respetuoso">Recibir un trato digno y respetuoso</option>
                                <option <?php if ($e_ficha['hechos'] === 'Decidir libremente sobre su atención médica') echo 'selected="selected"'; ?> value="Decidir libremente sobre su atención médica">Decidir libremente sobre su atención médica</option>
                                <option <?php if ($e_ficha['hechos'] === 'Otorgar el consentimiento válidamente informado') echo 'selected="selected"'; ?> value="Otorgar el consentimiento válidamente informado">Otorgar el consentimiento válidamente informado</option>
                                <option <?php if ($e_ficha['hechos'] === 'Confidencialidad respecto a sus enfermedades o padecimientos') echo 'selected="selected"'; ?> value="Confidencialidad respecto a sus enfermedades o padecimientos">Confidencialidad respecto a sus enfermedades o padecimientos</option>
                                <option <?php if ($e_ficha['hechos'] === 'Tener una segunda opinión médica') echo 'selected="selected"'; ?> value="Tener una segunda opinión médica">Tener una segunda opinión médica</option>
                                <option <?php if ($e_ficha['hechos'] === 'La debida integración del expediente clínico') echo 'selected="selected"'; ?> value="La debida integración del expediente clínico">La debida integración del expediente clínico</option>
                                <option <?php if ($e_ficha['hechos'] === 'Ser atendido cuando se inconforme con la atención médica recibida') echo 'selected="selected"'; ?> value="Ser atendido cuando se inconforme con la atención médica recibida">Ser atendido cuando se inconforme con la atención médica recibida</option>
                                <option <?php if ($e_ficha['hechos'] === 'Recibir los medicamentos y tratamiento correspondiente a su padecimiento') echo 'selected="selected"'; ?> value="Recibir los medicamentos y tratamiento correspondiente a su padecimiento">Recibir los medicamentos y tratamiento correspondiente a su padecimiento</option>
                                <option <?php if ($e_ficha['hechos'] === 'La inmunización universal') echo 'selected="selected"'; ?> value="La inmunización universal">La inmunización universal</option>
                                <option <?php if ($e_ficha['hechos'] === 'La educación para la salud alimentación e higiene') echo 'selected="selected"'; ?> value="La educación para la salud alimentación e higiene">La educación para la salud alimentación e higiene</option>
                                <option <?php if ($e_ficha['hechos'] === 'La satisfacción de las necesidades de salud de los grupos de más alto riesgo') echo 'selected="selected"'; ?> value="La satisfacción de las necesidades de salud de los grupos de más alto riesgo">La satisfacción de las necesidades de salud de los grupos de más alto riesgo</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido a esterilización forzada') echo 'selected="selected"'; ?> value="No ser sometido a esterilización forzada">No ser sometido a esterilización forzada</option>
                                <option <?php if ($e_ficha['hechos'] === 'Las mujeres a recibir información para decidir sobre la interrupción del embarazo') echo 'selected="selected"'; ?> value="Las mujeres a recibir información para decidir sobre la interrupción del embarazo">Las mujeres a recibir información para decidir sobre la interrupción del embarazo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Las mujeres a no ser sujetas de violencia obstétrica') echo 'selected="selected"'; ?> value="Las mujeres a no ser sujetas de violencia obstétrica">Las mujeres a no ser sujetas de violencia obstétrica</option>
                                <option <?php if ($e_ficha['hechos'] === 'La lactancia') echo 'selected="selected"'; ?> value="La lactancia">La lactancia</option>
                                <option <?php if ($e_ficha['hechos'] === 'Acceso a la información pública') echo 'selected="selected"'; ?> value="Acceso a la información pública">Acceso a la información pública</option>
                                <option <?php if ($e_ficha['hechos'] === 'Acceso rectificación y corrección de la información pública') echo 'selected="selected"'; ?> value="Acceso rectificación y corrección de la información pública">Acceso rectificación y corrección de la información pública</option>
                                <option <?php if ($e_ficha['hechos'] === 'Buscar recibir o difundir cualquier información pública') echo 'selected="selected"'; ?> value="Buscar recibir o difundir cualquier información pública">Buscar recibir o difundir cualquier información pública</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad de trabajo') echo 'selected="selected"'; ?> value="La libertad de trabajo">La libertad de trabajo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Goce de condiciones de trabajo justas equitativas y satisfactorias') echo 'selected="selected"'; ?> value="Goce de condiciones de trabajo justas equitativas y satisfactorias">Goce de condiciones de trabajo justas equitativas y satisfactorias</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido a trabajo forzado u obligatorio') echo 'selected="selected"'; ?> value="No ser sometido a trabajo forzado u obligatorio">No ser sometido a trabajo forzado u obligatorio</option>
                                <option <?php if ($e_ficha['hechos'] === 'Las prestaciones de seguridad social') echo 'selected="selected"'; ?> value="Las prestaciones de seguridad social">Las prestaciones de seguridad social</option>
                                <option <?php if ($e_ficha['hechos'] === 'La libertad sindical') echo 'selected="selected"'; ?> value="La libertad sindical">La libertad sindical</option>
                                <option <?php if ($e_ficha['hechos'] === 'La seguridad e higiene en el trabajo') echo 'selected="selected"'; ?> value="La seguridad e higiene en el trabajo">La seguridad e higiene en el trabajo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Al descanso al disfrute del tiempo libre y a la limitación razonable de la jornada de trabajo') echo 'selected="selected"'; ?> value="Al descanso al disfrute del tiempo libre y a la limitación razonable de la jornada de trabajo">Al descanso al disfrute del tiempo libre y a la limitación razonable de la jornada de trabajo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Al escalafón') echo 'selected="selected"'; ?> value="Al escalafón">Al escalafón</option>
                                <option <?php if ($e_ficha['hechos'] === 'No ser sometido al hostigamiento laboral') echo 'selected="selected"'; ?> value="No ser sometido al hostigamiento laboral">No ser sometido al hostigamiento laboral</option>
                                <option <?php if ($e_ficha['hechos'] === 'Instrumentos y apoyos para el acceso a una vivienda digna') echo 'selected="selected"'; ?> value="Instrumentos y apoyos para el acceso a una vivienda digna">Instrumentos y apoyos para el acceso a una vivienda digna</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una vivienda digna segura decorosa y con acceso a servicios e infraestructura vitales') echo 'selected="selected"'; ?> value="Una vivienda digna segura decorosa y con acceso a servicios e infraestructura vitales">Una vivienda digna segura decorosa y con acceso a servicios e infraestructura vitales</option>
                                <option <?php if ($e_ficha['hechos'] === 'Protección preservación y cuidado del medio ambiente') echo 'selected="selected"'; ?> value="Protección preservación y cuidado del medio ambiente">Protección preservación y cuidado del medio ambiente</option>
                                <option <?php if ($e_ficha['hechos'] === 'Disfrute de un medio ambiente sano y ecológicamente equilibrado') echo 'selected="selected"'; ?> value="Disfrute de un medio ambiente sano y ecológicamente equilibrado">Disfrute de un medio ambiente sano y ecológicamente equilibrado</option>
                                <option <?php if ($e_ficha['hechos'] === 'La indemnización por DA') echo 'selected="selected"'; ?> value="La indemnización por DA">La indemnización por DA</option>
                                <option <?php if ($e_ficha['hechos'] === 'Al agua y al saneamiento') echo 'selected="selected"'; ?> value="Al agua y al saneamiento">Al agua y al saneamiento</option>
                                <option <?php if ($e_ficha['hechos'] === 'Debido cobro de contribuciones e impuestos') echo 'selected="selected"'; ?> value="Debido cobro de contribuciones e impuestos">Debido cobro de contribuciones e impuestos</option>
                                <option <?php if ($e_ficha['hechos'] === 'Petición') echo 'selected="selected"'; ?> value="Petición">Petición</option>
                                <option <?php if ($e_ficha['hechos'] === 'Obtener servicios públicos de calidad') echo 'selected="selected"'; ?> value="Obtener servicios públicos de calidad">Obtener servicios públicos de calidad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Seguridad pública') echo 'selected="selected"'; ?> value="Seguridad pública">Seguridad pública</option>
                                <option <?php if ($e_ficha['hechos'] === 'Protección civil') echo 'selected="selected"'; ?> value="Protección civil">Protección civil</option>
                                <option <?php if ($e_ficha['hechos'] === 'Políticas públicas que propicien un mejor nivel de vida') echo 'selected="selected"'; ?> value="Políticas públicas que propicien un mejor nivel de vida">Políticas públicas que propicien un mejor nivel de vida</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una vida en paz') echo 'selected="selected"'; ?> value="Una vida en paz">Una vida en paz</option>
                                <option <?php if ($e_ficha['hechos'] === 'Desarrollo') echo 'selected="selected"'; ?> value="Desarrollo">Desarrollo</option>
                                <option <?php if ($e_ficha['hechos'] === 'Cultura física y deporte') echo 'selected="selected"'; ?> value="Cultura física y deporte">Cultura física y deporte</option>
                                <option <?php if ($e_ficha['hechos'] === 'Acceso del internet') echo 'selected="selected"'; ?> value="Acceso del internet">Acceso del internet</option>
                                <option <?php if ($e_ficha['hechos'] === 'Formar partidos políticos a agrupaciones políticas a nivel local') echo 'selected="selected"'; ?> value="Formar partidos políticos a agrupaciones políticas a nivel local">Formar partidos políticos a agrupaciones políticas a nivel local</option>
                                <option <?php if ($e_ficha['hechos'] === 'Ejercer el voto libre y sin coacción') echo 'selected="selected"'; ?> value="Ejercer el voto libre y sin coacción">Ejercer el voto libre y sin coacción</option>
                                <option <?php if ($e_ficha['hechos'] === 'Ser elegido') echo 'selected="selected"'; ?> value="Ser elegido">Ser elegido</option>
                                <option <?php if ($e_ficha['hechos'] === 'Una valoración y certificación médica o psicológica') echo 'selected="selected"'; ?> value="Una valoración y certificación médica o psicológica">Una valoración y certificación médica o psicológica</option>
                                <option <?php if ($e_ficha['hechos'] === 'La percepción puntual de la remuneración pactada o legalmente establecida') echo 'selected="selected"'; ?> value="La percepción puntual de la remuneración pactada o legalmente establecida">La percepción puntual de la remuneración pactada o legalmente establecida</option>
                                <option <?php if ($e_ficha['hechos'] === 'Desarrollo de la colectividad') echo 'selected="selected"'; ?> value="Desarrollo de la colectividad">Desarrollo de la colectividad</option>
                                <option <?php if ($e_ficha['hechos'] === 'Seguridad en los centros educativos') echo 'selected="selected"'; ?> value="Seguridad en los centros educativos">Seguridad en los centros educativos</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="autoridad">Autoridad señalada</label>
                            <select class="form-control" name="autoridad">
                                <option <?php if ($e_ficha['autoridad'] === 'Otra') echo 'selected="selected"'; ?> value="Otra">Otra</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Seguridad Pública') echo 'selected="selected"'; ?> value="Secretaría de Seguridad Pública">Secretaría de Seguridad Pública</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Fiscalía General en el Estado') echo 'selected="selected"'; ?> value="Fiscalía General en el Estado">Fiscalía General en el Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Aeropuerto de Morelia') echo 'selected="selected"'; ?> value="Aeropuerto de Morelia">Aeropuerto de Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio de Bachilleres del Estado de Michoacán COBAEM') echo 'selected="selected"'; ?> value="Colegio de Bachilleres del Estado de Michoacán COBAEM">Colegio de Bachilleres del Estado de Michoacán COBAEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM') echo 'selected="selected"'; ?> value="Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM">Colegio de Estudios Científicos y Tecnológicos del Estado de Michoacán CECYTEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Colegio Nacional de Educación Profesional Técnica CONALEP') echo 'selected="selected"'; ?> value="Colegio Nacional de Educación Profesional Técnica CONALEP">Colegio Nacional de Educación Profesional Técnica CONALEP</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Coordinadora del Transporte Publico en Michoacán') echo 'selected="selected"'; ?> value="Comisión Coordinadora del Transporte Publico en Michoacán">Comisión Coordinadora del Transporte Publico en Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Ejecutiva Estatal de Atención a Victimas') echo 'selected="selected"'; ?> value="Comisión Ejecutiva Estatal de Atención a Victimas">Comisión Ejecutiva Estatal de Atención a Victimas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Estatal de Cultura Física y Deporte') echo 'selected="selected"'; ?> value="Comisión Estatal de Cultura Física y Deporte">Comisión Estatal de Cultura Física y Deporte</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Estatal del Agua y Gestión de Cuencas') echo 'selected="selected"'; ?> value="Comisión Estatal del Agua y Gestión de Cuencas">Comisión Estatal del Agua y Gestión de Cuencas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional de los Derechos Humanos CNDH') echo 'selected="selected"'; ?> value="Comisión Nacional de los Derechos Humanos CNDH">Comisión Nacional de los Derechos Humanos CNDH</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional del Agua CONAGUA') echo 'selected="selected"'; ?> value="Comisión Nacional del Agua CONAGUA">Comisión Nacional del Agua CONAGUA</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF') echo 'selected="selected"'; ?> value="Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF">Comisión Nacional Para la Protección y Defensa de los Usuarios de Servicios Financieros CONDUSEF</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Comisión Para la Regularización de la Tenencia de la Tierra CORETT') echo 'selected="selected"'; ?> value="Comisión Para la Regularización de la Tenencia de la Tierra CORETT">Comisión Para la Regularización de la Tenencia de la Tierra CORETT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Consejería Jurídica del Ejecutivo del Estado') echo 'selected="selected"'; ?> value="Consejería Jurídica del Ejecutivo del Estado">Consejería Jurídica del Ejecutivo del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Consejo Nacional Para Prevenir la Discriminación') echo 'selected="selected"'; ?> value="Consejo Nacional Para Prevenir la Discriminación">Consejo Nacional Para Prevenir la Discriminación</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Coordinación de Comunicación Social') echo 'selected="selected"'; ?> value="Coordinación de Comunicación Social">Coordinación de Comunicación Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Coordinación del Sistema Penitenciario del Estado de Michoacán') echo 'selected="selected"'; ?> value="Coordinación del Sistema Penitenciario del Estado de Michoacán">Coordinación del Sistema Penitenciario del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Defensoría Publica Federal') echo 'selected="selected"'; ?> value="Defensoría Publica Federal">Defensoría Publica Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Despacho del C. Gobernador') echo 'selected="selected"'; ?> value="Despacho del C. Gobernador">Despacho del C. Gobernador</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección de Registro Civil') echo 'selected="selected"'; ?> value="Dirección de Registro Civil">Dirección de Registro Civil</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección de Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Dirección de Trabajo y Previsión Social">Dirección de Trabajo y Previsión Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección General de Educación Tecnológica Industrial DGTI') echo 'selected="selected"'; ?> value="Dirección General de Educación Tecnológica Industrial DGTI">Dirección General de Educación Tecnológica Industrial DGTI</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Dirección General de Institutos Tecnológicos') echo 'selected="selected"'; ?> value="Dirección General de Institutos Tecnológicos">Dirección General de Institutos Tecnológicos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Fiscalía General de la República') echo 'selected="selected"'; ?> value="Fiscalía General de la República">Fiscalía General de la República</option>
                                <option <?php if ($e_ficha['autoridad'] === 'FOVISSSTE Michoacán') echo 'selected="selected"'; ?> value="FOVISSSTE Michoacán">FOVISSSTE Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Honorable Congreso del Estado de Michoacán') echo 'selected="selected"'; ?> value="Honorable Congreso del Estado de Michoacán">Honorable Congreso del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de la Defensoría Publica del Estado') echo 'selected="selected"'; ?> value="Instituto de la Defensoría Publica del Estado">Instituto de la Defensoría Publica del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de la Juventud Michoacana') echo 'selected="selected"'; ?> value="Instituto de la Juventud Michoacana">Instituto de la Juventud Michoacana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado') echo 'selected="selected"'; ?> value="Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado">Instituto de Seguridad y Servicios Sociales de los Trabajadores al Servicio del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto de Vivienda de Michoacán IVEM') echo 'selected="selected"'; ?> value="Instituto de Vivienda de Michoacán IVEM">Instituto de Vivienda de Michoacán IVEM</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT') echo 'selected="selected"'; ?> value="Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT">Instituto del Fondo Nacional de la Vivienda Para los Trabajadores INFONAVIT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Electoral de Michoacán') echo 'selected="selected"'; ?> value="Instituto Electoral de Michoacán">Instituto Electoral de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Mexicano del Seguro Social IMSS') echo 'selected="selected"'; ?> value="Instituto Mexicano del Seguro Social IMSS">Instituto Mexicano del Seguro Social IMSS</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Michoacano de Ciencias de la Educación José María Morelos') echo 'selected="selected"'; ?> value="Instituto Michoacano de Ciencias de la Educación José María Morelos">Instituto Michoacano de Ciencias de la Educación José María Morelos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Nacional de Educación Para los Adultos INEA') echo 'selected="selected"'; ?> value="Instituto Nacional de Educación Para los Adultos INEA">Instituto Nacional de Educación Para los Adultos INEA</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Instituto Nacional de Migración') echo 'selected="selected"'; ?> value="Instituto Nacional de Migración">Instituto Nacional de Migración</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta de Asistencia Privada del Gobierno del Estado') echo 'selected="selected"'; ?> value="Junta de Asistencia Privada del Gobierno del Estado">Junta de Asistencia Privada del Gobierno del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta de Caminos del Estado de Michoacán') echo 'selected="selected"'; ?> value="Junta de Caminos del Estado de Michoacán">Junta de Caminos del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Junta Local de Conciliación y Arbitraje') echo 'selected="selected"'; ?> value="Junta Local de Conciliación y Arbitraje">Junta Local de Conciliación y Arbitraje</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Parque Zoológico Benito Juárez') echo 'selected="selected"'; ?> value="Parque Zoológico Benito Juárez">Parque Zoológico Benito Juárez</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Pensiones Civiles del Estado') echo 'selected="selected"'; ?> value="Pensiones Civiles del Estado">Pensiones Civiles del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Acuitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Acuitzio">Presidencia Municipal de Acuitzio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Aguililla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aguililla">Presidencia Municipal de Aguililla</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Álvaro Obregón') echo 'selected="selected"'; ?> value="Presidencia Municipal de Álvaro Obregón">Presidencia Municipal de Álvaro Obregón</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Angamacutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angamacutiro">Presidencia Municipal de Angamacutiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Angangueo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Angangueo">Presidencia Municipal de Angangueo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Apatzingán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Apatzingán">Presidencia Municipal de Apatzingán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Aquila') echo 'selected="selected"'; ?> value="Presidencia Municipal de Aquila">Presidencia Municipal de Aquila</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ario') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ario">Presidencia Municipal de Ario</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Arteaga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Arteaga">Presidencia Municipal de Arteaga</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Briseñas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Briseñas">Presidencia Municipal de Briseñas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Buenavista') echo 'selected="selected"'; ?> value="Presidencia Municipal de Buenavista">Presidencia Municipal de Buenavista</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Carácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Carácuaro">Presidencia Municipal de Carácuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Charapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charapan">Presidencia Municipal de Charapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Charo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Charo">Presidencia Municipal de Charo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chavinda') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chavinda">Presidencia Municipal de Chavinda</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cheran') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cheran">Presidencia Municipal de Cheran</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chilchota') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chilchota">Presidencia Municipal de Chilchota</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Chucándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Chucándiro">Presidencia Municipal de Chucándiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Churintzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Churintzio">Presidencia Municipal de Churintzio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Coeneo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Coeneo">Presidencia Municipal de Coeneo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cotija') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cotija">Presidencia Municipal de Cotija</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Cuitzeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Cuitzeo">Presidencia Municipal de Cuitzeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ecuandureo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ecuandureo">Presidencia Municipal de Ecuandureo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Epitacio Huerta') echo 'selected="selected"'; ?> value="Presidencia Municipal de Epitacio Huerta">Presidencia Municipal de Epitacio Huerta</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Erongarícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Erongarícuaro">Presidencia Municipal de Erongarícuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Gabriel Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Gabriel Zamora">Presidencia Municipal de Gabriel Zamora</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Hidalgo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Hidalgo">Presidencia Municipal de Hidalgo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huandacareo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huandacareo">Presidencia Municipal de Huandacareo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huaniqueo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huaniqueo">Presidencia Municipal de Huaniqueo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huetamo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huetamo">Presidencia Municipal de Huetamo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Huiramba') echo 'selected="selected"'; ?> value="Presidencia Municipal de Huiramba">Presidencia Municipal de Huiramba</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Indaparapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Indaparapeo">Presidencia Municipal de Indaparapeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Irimbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Irimbo">Presidencia Municipal de Irimbo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ixtlán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ixtlán">Presidencia Municipal de Ixtlán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jacona') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jacona">Presidencia Municipal de Jacona</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jiménez') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiménez">Presidencia Municipal de Jiménez</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jiquilpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jiquilpan">Presidencia Municipal de Jiquilpan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de José Sixto Verduzco') echo 'selected="selected"'; ?> value="Presidencia Municipal de José Sixto Verduzco">Presidencia Municipal de José Sixto Verduzco</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Jungapeo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Jungapeo">Presidencia Municipal de Jungapeo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de La Huacana') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Huacana">Presidencia Municipal de La Huacana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de La Piedad') echo 'selected="selected"'; ?> value="Presidencia Municipal de La Piedad">Presidencia Municipal de La Piedad</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Lagunillas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lagunillas">Presidencia Municipal de Lagunillas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Lázaro Cárdenas') echo 'selected="selected"'; ?> value="Presidencia Municipal de Lázaro Cárdenas">Presidencia Municipal de Lázaro Cárdenas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Los Reyes') echo 'selected="selected"'; ?> value="Presidencia Municipal de Los Reyes">Presidencia Municipal de los Reyes</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Madero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Madero">Presidencia Municipal de Madero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Maravatío') echo 'selected="selected"'; ?> value="Presidencia Municipal de Maravatío">Presidencia Municipal de Maravatío</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Marcos Castellanos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Marcos Castellanos">Presidencia Municipal de Marcos Castellanos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Morelia') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelia">Presidencia Municipal de Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Morelos') echo 'selected="selected"'; ?> value="Presidencia Municipal de Morelos">Presidencia Municipal de Morelos</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Múgica') echo 'selected="selected"'; ?> value="Presidencia Municipal de Múgica">Presidencia Municipal de Múgica</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nahuatzen') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nahuatzen">Presidencia Municipal de Nahuatzen</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nocupétaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nocupétaro">Presidencia Municipal de Nocupétaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nuevo Parangaricutiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Parangaricutiro">Presidencia Municipal de Nuevo Parangaricutiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Nuevo Urecho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Nuevo Urecho">Presidencia Municipal de Nuevo Urecho</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Numarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Numarán">Presidencia Municipal de Numarán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ocampo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ocampo">Presidencia Municipal de Ocampo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Pajacuarán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pajacuarán">Presidencia Municipal de Pajacuarán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Panindícuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Panindícuaro">Presidencia Municipal de Panindícuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Paracho') echo 'selected="selected"'; ?> value="Presidencia Municipal de Paracho">Presidencia Municipal de Paracho</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Pátzcuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Pátzcuaro">Presidencia Municipal de Pátzcuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Penjamillo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Penjamillo">Presidencia Municipal de Penjamillo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Peribán') echo 'selected="selected"'; ?> value="Presidencia Municipal de Peribán">Presidencia Municipal de Peribán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Purépero') echo 'selected="selected"'; ?> value="Presidencia Municipal de Purépero">Presidencia Municipal de Purépero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Puruándiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Puruándiro">Presidencia Municipal de Puruándiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Queréndaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Queréndaro">Presidencia Municipal de Queréndaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Quiroga') echo 'selected="selected"'; ?> value="Presidencia Municipal de Quiroga">Presidencia Municipal de Quiroga</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Sahuayo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Sahuayo">Presidencia Municipal de Sahuayo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Salvador Escalante') echo 'selected="selected"'; ?> value="Presidencia Municipal de Salvador Escalante">Presidencia Municipal de Salvador Escalante</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Santa Ana Maya') echo 'selected="selected"'; ?> value="Presidencia Municipal de Santa Ana Maya">Presidencia Municipal de Santa Ana Maya</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Senguio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Senguio">Presidencia Municipal de Senguio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tacámbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tacámbaro">Presidencia Municipal de Tacámbaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tancítaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tancítaro">Presidencia Municipal de Tancítaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tangamandapio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangamandapio">Presidencia Municipal de Tangamandapio</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tangancicuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tangancicuaro">Presidencia Municipal de Tangancicuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tanhuato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tanhuato">Presidencia Municipal de Tanhuato</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Taretan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Taretan">Presidencia Municipal de Taretan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tarímbaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tarímbaro">Presidencia Municipal de Tarímbaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tepalcatepec') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tepalcatepec">Presidencia Municipal de Tepalcatepec</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tingambato') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingambato">Presidencia Municipal de Tingambato</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tingüindín') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tingüindín">Presidencia Municipal de Tingüindín</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tiquicheo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tiquicheo">Presidencia Municipal de Tiquicheo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tlalpujahua') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlalpujahua">Presidencia Municipal de Tlalpujahua</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tlazazalca') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tlazazalca">Presidencia Municipal de Tlazazalca</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tocumbo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tocumbo">Presidencia Municipal de Tocumbo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tuxpan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuxpan">Presidencia Municipal de Tuxpan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tuzantla') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tuzantla">Presidencia Municipal de Tuzantla</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tzintzuntzan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzintzuntzan">Presidencia Municipal de Tzintzuntzan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Uruapan') echo 'selected="selected"'; ?> value="Presidencia Municipal de Uruapan">Presidencia Municipal de Uruapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Venustiano Carranza') echo 'selected="selected"'; ?> value="Presidencia Municipal de Venustiano Carranza">Presidencia Municipal de Venustiano Carranza</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Villamar') echo 'selected="selected"'; ?> value="Presidencia Municipal de Villamar">Presidencia Municipal de Villamar</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Vista Hermosa') echo 'selected="selected"'; ?> value="Presidencia Municipal de Vista Hermosa">Presidencia Municipal de Vista Hermosa</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Yurécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Yurécuaro">Presidencia Municipal de Yurécuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zacapu') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zacapu">Presidencia Municipal de Zacapu</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zamora') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zamora">Presidencia Municipal de Zamora</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zináparo') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zináparo">Presidencia Municipal de Zináparo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zinapécuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zinapécuaro">Presidencia Municipal de Zinapécuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Ziracuaretiro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Ziracuaretiro">Presidencia Municipal de Ziracuaretiro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Zitácuaro') echo 'selected="selected"'; ?> value="Presidencia Municipal de Zitácuaro">Presidencia Municipal de Zitácuaro</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Agraria En Michoacán') echo 'selected="selected"'; ?> value="Procuraduría Agraria En Michoacán">Procuraduría Agraria En Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Auxiliar de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Auxiliar de la Defensa del Trabajo">Procuraduría Auxiliar de la Defensa del Trabajo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Federal de la Defensa del Trabajo') echo 'selected="selected"'; ?> value="Procuraduría Federal de la Defensa del Trabajo">Procuraduría Federal de la Defensa del Trabajo</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Procuraduría Federal del Consumidor PROFECO') echo 'selected="selected"'; ?> value="Procuraduría Federal del Consumidor PROFECO">Procuraduría Federal del Consumidor PROFECO</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Quejas Sin Autoridad Señalada Como Responsable') echo 'selected="selected"'; ?> value="Quejas Sin Autoridad Señalada Como Responsable">Quejas Sin Autoridad Señalada Como Responsable</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Contraloría del Estado') echo 'selected="selected"'; ?> value="Secretaria de Contraloría del Estado">Secretaria de Contraloría del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Bienestar') echo 'selected="selected"'; ?> value="Secretaría de Bienestar">Secretaría de Bienestar</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Comunicaciones y Obras Publicas') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Obras Publicas">Secretaria de Comunicaciones y Obras Publicas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Comunicaciones y Transportes SCT') echo 'selected="selected"'; ?> value="Secretaria de Comunicaciones y Transportes SCT">Secretaria de Comunicaciones y Transportes SCT</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Cultura en el Estado') echo 'selected="selected"'; ?> value="Secretaria de Cultura en el Estado">Secretaria de Cultura en el Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Desarrollo Económico') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Económico">Secretaria de Desarrollo Económico</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Desarrollo Rural y Agroalimentario') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Rural y Agroalimentario">Secretaria de Desarrollo Rural y Agroalimentario</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Desarrollo Social y Humano') echo 'selected="selected"'; ?> value="Secretaría de Desarrollo Social y Humano">Secretaría de Desarrollo Social y Humano</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Desarrollo Territorial Urbano y Movilidad') echo 'selected="selected"'; ?> value="Secretaria de Desarrollo Territorial Urbano y Movilidad">Secretaria de Desarrollo Territorial Urbano y Movilidad</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Educación del Estado') echo 'selected="selected"'; ?> value="Secretaria de Educación del Estado">Secretaria de Educación del Estado</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Educación Pública Federal') echo 'selected="selected"'; ?> value="Secretaria de Educación Pública Federal">Secretaria de Educación Pública Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Finanzas y Administración') echo 'selected="selected"'; ?> value="Secretaria de Finanzas y Administración">Secretaria de Finanzas y Administración</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaría de Gobernación') echo 'selected="selected"'; ?> value="Secretaría de Gobernación">Secretaría de Gobernación</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Gobierno') echo 'selected="selected"'; ?> value="Secretaria de Gobierno">Secretaria de Gobierno</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas') echo 'selected="selected"'; ?> value="Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas">Secretaria de Igualdad Sustantiva y Desarrollo de Las Mujeres Michoacanas</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de la Defensa Nacional Ejercito Mexicano') echo 'selected="selected"'; ?> value="Secretaria de la Defensa Nacional Ejercito Mexicano">Secretaria de la Defensa Nacional Ejercito Mexicano</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de los Migrantes En El Extranjero') echo 'selected="selected"'; ?> value="Secretaria de los Migrantes En El Extranjero">Secretaria de los Migrantes En El Extranjero</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Marina y Armada de México') echo 'selected="selected"'; ?> value="Secretaria de Marina y Armada de México">Secretaria de Marina y Armada de México</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Relaciones Exteriores SRE') echo 'selected="selected"'; ?> value="Secretaria de Relaciones Exteriores SRE">Secretaria de Relaciones Exteriores SRE</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Salud') echo 'selected="selected"'; ?> value="Secretaria de Salud">Secretaria de Salud</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad Publica Estatal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Estatal">Secretaria de Seguridad Publica Estatal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad Publica Federal') echo 'selected="selected"'; ?> value="Secretaria de Seguridad Publica Federal">Secretaria de Seguridad Publica Federal</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria de Seguridad y Protección Ciudadana') echo 'selected="selected"'; ?> value="Secretaria de Seguridad y Protección Ciudadana">Secretaria de Seguridad y Protección Ciudadana</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Secretaria del Trabajo y Previsión Social') echo 'selected="selected"'; ?> value="Secretaria del Trabajo y Previsión Social">Secretaria del Trabajo y Previsión Social</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia') echo 'selected="selected"'; ?> value="Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia">Sistema Integral de Financiamiento para el Desarrollo de Michoacán Si Financia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Michoacano de Radio y Televisión') echo 'selected="selected"'; ?> value="Sistema Michoacano de Radio y Televisión">Sistema Michoacano de Radio y Televisión</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Sistema Para el Desarrollo Integral de la Familia DIF') echo 'selected="selected"'; ?> value="Sistema Para el Desarrollo Integral de la Familia DIF">Sistema Para el Desarrollo Integral de la Familia DIF</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Supremo Tribunal de Justicia') echo 'selected="selected"'; ?> value="Supremo Tribunal de Justicia">Supremo Tribunal de Justicia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Telebachillerato de Michoacán') echo 'selected="selected"'; ?> value="Telebachillerato de Michoacán">Telebachillerato de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Tribunal de Conciliación y Arbitraje del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Conciliación y Arbitraje del Estado de Michoacán">Tribunal de Conciliación y Arbitraje del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Tribunal de Justicia Administrativa del Estado de Michoacán') echo 'selected="selected"'; ?> value="Tribunal de Justicia Administrativa del Estado de Michoacán">Tribunal de Justicia Administrativa del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Intercultural Indígena de Michoacán') echo 'selected="selected"'; ?> value="Universidad Intercultural Indígena de Michoacán">Universidad Intercultural Indígena de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Michoacana de San Nicolas de Hidalgo UMSNH') echo 'selected="selected"'; ?> value="Universidad Michoacana de San Nicolas de Hidalgo UMSNH">Universidad Michoacana de San Nicolas de Hidalgo UMSNH</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Universidad Virtual del Estado de Michoacán') echo 'selected="selected"'; ?> value="Universidad Virtual del Estado de Michoacán">Universidad Virtual del Estado de Michoacán</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Visitaduría Morelia') echo 'selected="selected"'; ?> value="Visitaduría Morelia">Visitaduría Morelia</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Visitaduría Uruapan') echo 'selected="selected"'; ?> value="Visitaduría Uruapan">Visitaduría Uruapan</option>
                                <option <?php if ($e_ficha['autoridad'] === 'Presidencia Municipal de Tzitzio') echo 'selected="selected"'; ?> value="Presidencia Municipal de Tzitzio">Presidencia Municipal de Tzitzio</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_usuario">Nombre del usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" placeholder="Nombre Completo" value="<?php echo remove_junk($e_ficha['nombre_usuario']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-1">
                        <div class="form-group">
                            <label for="edad">Edad</label>
                            <input type="number" class="form-control" min="1" max="120" name="edad" value="<?php echo remove_junk($e_ficha['edad']); ?>" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="sexo">Género</label>
                            <select class="form-control" name="sexo">
                                <option <?php if ($e_ficha['sexo'] === 'Mujer') ?> value="Mujer">Mujer</option>
                                <option <?php if ($e_ficha['sexo'] === 'Hombre') ?> value="Hombre">Hombre</option>
                                <option <?php if ($e_ficha['sexo'] === 'LGBTIQ+') ?> value="LGBTIQ+">LGBTIQ+</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="grupo_vulnerable">Grupo Vulnerable</label>
                            <select class="form-control" name="grupo_vulnerable">
                                <option value="">Elige una opción</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Comunidad LGBTIQ+') echo 'selected="selected"'; ?> value="Comunidad LGBTIQ+">Comunidad LGBTIQ+</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Derecho de las mujeres') echo 'selected="selected"'; ?> value="Derecho de las mujeres">Derecho de las mujeres</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Niñas, niños y adolescentes') echo 'selected="selected"'; ?> value="Niñas, niños y adolescentes">Niñas, niños y adolescentes</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas con discapacidad') echo 'selected="selected"'; ?> value="Personas con discapacidad">Personas con discapacidad</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas migrantes') echo 'selected="selected"'; ?> value="Personas migrantes">Personas migrantes</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Personas que viven con VIH SIDA') echo 'selected="selected"'; ?> value="Personas que viven con VIH SIDA">Personas que viven con VIH SIDA</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Grupos indígenas') echo 'selected="selected"'; ?> value="Grupos indígenas">Grupos indígenas</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Periodistas') echo 'selected="selected"'; ?> value="Periodistas">Periodistas</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Defensores de los derechos humanos') echo 'selected="selected"'; ?> value="Defensores de los derechos humanos">Defensores de los derechos humanos</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Adultos mayores') echo 'selected="selected"'; ?> value="Adultos mayores">Adultos mayores</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Internos') echo 'selected="selected"'; ?> value="Internos">Internos</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'Otros') echo 'selected="selected"'; ?> value="Otros">Otros</option>
                                <option <?php if ($e_ficha['grupo_vulnerable'] === 'No Aplica') echo 'selected="selected"'; ?> value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fecha_intervencion">Fecha de Intervención</label>
                            <input type="date" class="form-control" value="<?php echo remove_junk($e_ficha['fecha_intervencion']); ?>" name="fecha_intervencion" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="protocolo_estambul">Protocolo de Estambul</label>
                            <select class="form-control" name="protocolo_estambul">
                                <option <?php if ($e_ficha['protocolo_estambul'] === 'Aplicado') echo 'selected="selected"'; ?> value="Aplicado">Aplicado</option>
                                <option <?php if ($e_ficha['protocolo_estambul'] === 'No Aplicado') echo 'selected="selected"'; ?> value="No Aplicado">No Aplicado</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="resultado">Resultado</label>
                            <select class="form-control" name="resultado">
                                <option <?php if ($e_ficha['resultado'] === 'Positivo') echo 'selected="selected"'; ?> value="Positivo">Positivo</option>
                                <option <?php if ($e_ficha['resultado'] === 'Negativo') echo 'selected="selected"'; ?> value="Negativo">Negativo</option>
                                <option <?php if ($e_ficha['resultado'] === 'No aplica') echo 'selected="selected"'; ?> value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="documento_emitido">Documento Emititdo</label>
                            <select class="form-control" name="documento_emitido">
                                <option <?php if ($e_ficha['documento_emitido'] === 'Dictamen psicológico')  echo 'selected="selected"'; ?> value="Dictamen psicológico">Dictamen psicológico</option>
                                <option <?php if ($e_ficha['documento_emitido'] === 'Informe psicológico')  echo 'selected="selected"'; ?> value="Informe psicológico">Informe psicológico</option>
                                <option <?php if ($e_ficha['documento_emitido'] === 'No Aplica')  echo 'selected="selected"'; ?> value="No Aplica">No Aplica</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="nombre_especialista">Especialista que emite</label>
                            <input type="text" class="form-control" name="nombre_especialista" value="<?php echo remove_junk($e_ficha['nombre_especialista']); ?>" placeholder="Nombre Completo del especialista" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="clave_documento">Clave del documento</label>
                            <input type="text" class="form-control" name="clave_documento" value="<?php echo remove_junk($e_ficha['clave_documento']); ?>" placeholder="Insertar la clave del documento" required>
                        </div>
                    </div>     
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="ficha_adjunto">Ficha Adjunta</label>
                            <input type="file" accept="application/pdf" class="form-control" name="ficha_adjunto" id="ficha_adjunto" value="uploads/fichastecnicas/<?php echo $e_ficha['ficha_adjunto']; ?>">
                            <label style="font-size:12px; color:#E3054F;">Archivo Actual: <?php echo remove_junk($e_ficha['ficha_adjunto']); ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group clearfix">
                    <?php if ($tipo_ficha['tipo_ficha'] == 1) : ?>
                        <a href="fichas_psic.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                    <?php else : ?>
                        <a href="fichas_psic.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                            Regresar
                        </a>
                    <?php endif; ?>
                    <button type="submit" name="edit_ficha_psic" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
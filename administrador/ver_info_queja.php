<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Queja';
require_once('includes/load.php');
?>
<?php
$id = (int) $_GET['id'];
$e_detalle = find_by_id_queja($id);
$e_detalle2 = find_by_id_acuerdo($id);
$user = current_user();
$nivel = $user['user_level'];
$cat_est_procesal = find_all('cat_est_procesal');
$cat_municipios = find_all_cat_municipios();

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 5) {
    page_require_level_exacto(5);
}
if ($nivel == 7) {
    page_require_level_exacto(7);
}
if ($nivel == 19) {
    page_require_level_exacto(19);
}
if ($nivel > 21) {
    page_require_level_exacto(21);
}

if ($nivel > 2 && $nivel < 5) :
    redirect('home.php');
endif;
if ($nivel > 5 && $nivel < 7) :
    redirect('home.php');
endif;
if ($nivel > 7 && $nivel < 19) :
    redirect('home.php');
endif;
if ($nivel > 19 && $nivel < 21) :
    redirect('home.php');
endif;
?>

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #FFFFFF;
        color: black;
        width: 48%;
        margin-left: 1.2%;
        margin-bottom: -15px;
        border-radius: 10px 10px 10px 10px;
        height: 9%;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
        width: 33%;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    /* .tabcontent {
        display: none;
        padding: -1px -1px;
        border: 1px solid #ccc;
        border-top: none;
    } */

    .rectangulo {
        width: 100%;
        height: 100%;
        border: 3px solid #D6D6D6;
        border-radius: 5px;
        background: #F9F9F9;
        margin: 0 auto;
        display: grid;
        margin-top: 2%;
    }

    .boton1 {
        text-decoration: none;
        width: 200px;
        height: 50px;
        border: 2px solid #075E9A;
        border-radius: 5px;
        background: #075E9A;
        color: black;
        text-align: center;
        line-height: 45px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .boton1:hover {
        text-decoration: none;
        color: black;
        box-shadow: 0 1px 5px rgb(7, 94, 154);
        transition: all 0.1s ease;
    }

    .boton2 {
        text-decoration: none;
        width: 200px;
        height: 50px;
        border: 2px solid #075E9A;
        border-radius: 5px;
        background: #075E9A;
        color: black;
        text-align: center;
        line-height: 45px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .boton2:hover {
        text-decoration: none;
        color: white;
        box-shadow: 0 1px 5px rgb(7, 94, 154);
        transition: all 0.1s ease;
    }

    .contenedor {
        width: 1080px;
        margin: auto;
        background: #BFBFBF;
        color: black;
        padding: 20px 15px 50px 50px;
        border-radius: 10px;
        box-shadow: 0 5px 5px 0px rgba(0, 0, 0, 0.8);
    }

    .contenedor .titulo {
        font-size: 3.5ex;
        font-weight: bold;
        margin-left: 10px;
        margin-bottom: 10px;
    }

    #pestanas {
        float: top;
        font-size: 3ex;
        font-weight: bold;
    }

    #pestanas ul {
        margin-left: -40px;
    }

    #pestanas li {
        list-style-type: none;
        float: left;
        text-align: center;
        margin: 0px 2px -2px -0px;
        background: #949494;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        border: 2px solid #949494;
        border-bottom: #0340A1;
        padding: 0px 20px 0px 20px;
    }

    #pestanas a:link {
        text-decoration: none;
        color: white;        
    }

    #contenidopestanas {
        clear: both;
        background: #FFFFFF;
        padding: 20px 0px 20px 20px;
        border-radius: 5px;
        border-top-left-radius: 0px;
        border: 2px solid #949494;
        width: 1025px;
    }
</style>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>
<div>

</div>
<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Generales')">Generales</button>
    <button class="tablinks1" onclick="openCity(event, 'Seguimiento')">Seguimiento</button>
    <button class="tablinks2" onclick="openCity(event, 'Expedientes')">Expedientes</button>
</div>
<div class="row">
    <div id="Generales" class="tabcontent">

        <body onload="return openCity(event, 'Generales');"></body>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Información general de la Queja <?php echo remove_junk(ucwords($e_detalle['folio_queja'])) ?></span>
                    </strong>
                </div>

                <div class="panel-body">
                    <table style="color:#3a3d44; margin-top: -10px">
                        <tr>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Folio: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['folio_queja'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 4%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Fecha de presentación: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['fecha_presentacion'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Medio de presentación: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['medio_pres'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 3%;">
                                <span class="text-center" style="height:5%;">
                                    <span style="font-weight: bold;">Autoridad responsable: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['nombre_autoridad'])) ?><br><br>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Estado procesal: </span>
                                    <?php if ($e_detalle['estado_procesal'] == "") {
                                        echo "N/A";
                                    } else {
                                        foreach ($cat_est_procesal as $est_pros) {
                                            if ($e_detalle['estado_procesal'] == $est_pros['id_cat_est_procesal']) {
                                                echo remove_junk(ucwords($est_pros['descripcion']));
                                            }
                                        }
                                    } ?><br><br>
                                </span>
                            </td>
                            <td style="width: 4%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Tipo de ámbito: </span>
                                    <?php if ($e_detalle['tipo_ambito'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['tipo_ambito'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 2%;">
                                <span>
                                    <span style="font-weight: bold;">Estatus de la queja: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['estatus_queja'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 3%;">
                                <?php
                                $folio_editar = $e_detalle['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <span class="text-center">
                                    <span style="font-weight: bold;">Documento: </span>
                                    <a target="_blank" style="color:#0094FF" href="uploads/quejas/<?php echo $resultado . '/' . $e_detalle['archivo']; ?>"><?php echo $e_detalle['archivo']; ?></a><br><br>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Usuario asignado: </span>
                                    <?php echo remove_junk(ucwords(($e_detalle['username']))) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 4%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Área del usuario: </span>
                                    <?php echo remove_junk(ucwords(($e_detalle['nombre_area']))) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Colonia: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['dom_colonia'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 3%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Municipio: </span>
                                    <!-- <?php echo remove_junk(ucwords($e_detalle['id_cat_mun'])) ?> -->
                                    <?php
                                    foreach ($cat_municipios as $municipios) {
                                        if ($e_detalle['id_cat_mun'] == $municipios['id_cat_mun']) {
                                            echo remove_junk(ucwords($municipios['descripcion']));
                                        }
                                    }
                                    ?><br><br>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Calle y núm: </span>
                                    <?php echo remove_junk(ucwords($e_detalle['dom_calle'] . " #" . $e_detalle['dom_numero'])) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 4%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Observaciones: </span>
                                    <?php echo remove_junk($e_detalle['observaciones']) ?><br><br>
                                </span>
                            </td>
                        </tr>
                        <table>
                            <tr>
                                <span class="text-center">
                                    <span style="font-weight: bold;">Descripción de los hechos: </span>
                                    <?php echo remove_junk($e_detalle['descripcion_hechos']) ?>
                                </span>
                            </tr>
                        </table>
                    </table>

                    <h3 style="margin-top: 5%; margin-bottom:1%; font-weight: bold;">Información del Quejoso y Agraviado</h3>
                    <table style="color: #3a3d44">
                        <tr>
                            <td style="width: 1%">
                                <span style="font-weight: bold;">Nombre completo del quejoso: </span>
                                <span onclick="javascript:window.open('./ver_info_qa.php?id=<?php echo $e_detalle['id_cat_quejoso'] ?>&t=q','popup','width=750,height=400');" class="text-center">
                                    <a href="">
                                        <?php echo remove_junk(ucwords(($e_detalle['nombre_quejoso'] . " " . $e_detalle['paterno_quejoso'] . " " . $e_detalle['materno_quejoso']))) ?>
                                    </a>
                                </span>
                            </td>
                            <td style="width: 1%">
                                <span style="font-weight: bold;">Nombre completo del agraviado: </span>
                                <span onclick="javascript:window.open('./ver_info_qa.php?id=<?php echo $e_detalle['id_cat_agraviado'] ?>&t=a','popup','width=700,height=400');" class="text-center">
                                    <a href="">
                                        <?php echo remove_junk(ucwords(($e_detalle['nombre_agraviado'] . " " . $e_detalle['paterno_agraviado'] . " " . $e_detalle['materno_agraviado']))) ?>
                                    </a>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="Seguimiento" class="tabcontent">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Seguimiento de la Queja <?php echo remove_junk(ucwords($e_detalle['folio_queja'])) ?></span>
                    </strong>
                </div>

                <div class="panel-body">
                    <table style="color:#3a3d44; margin-top: -10px">
                        <tr>
                            <td>
                                <span style="font-weight: bold;">Tipo de resolución: </span>
                                <?php if ($e_detalle['tipo_resolucion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['tipo_resolucion'])) ?>
                                <br><br>
                            </td>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Incompetencia: </span>
                                    <?php if ($e_detalle['incompetencia'] == "" || $e_detalle['incompetencia'] == 0) {
                                        echo "N/A";
                                    } else
                                        echo 'Sí' ?><br><br>
                                </span>
                            </td>
                            <td style="width: 3%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Causa de incompetencia: </span>
                                    <?php if ($e_detalle['causa_incomp'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['causa_incomp']))) ?><br><br>
                                </span>
                            </td>
                            <td style="width: 2%;">
                                <span>
                                    <span style="font-weight: bold;">Fecha de acuerdo de incompetencia: </span>
                                    <?php if ($e_detalle['fecha_acuerdo_incomp'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['fecha_acuerdo_incomp']))) ?>
                                    <br><br>
                                </span>
                            </td>

                        </tr>
                        <tr>
                            <td style="width: 3%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">¿A quién se traslada?: </span>
                                    <?php if ($e_detalle['a_quien_se_traslada'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['a_quien_se_traslada']))) ?>
                                    <br><br>
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Desechamiento: </span>
                                <?php if ($e_detalle['desechamiento'] == "" || $e_detalle['desechamiento'] == "0") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['desechamiento'])) ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Razón de Desechamiento: </span>
                                <?php if ($e_detalle['razon_desecha'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['razon_desecha'])) ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Forma de conclusión: </span>
                                <?php if ($e_detalle['forma_conclusion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk($e_detalle['forma_conclusion']) ?>
                                <br><br>
                            </td>

                        </tr>
                        <tr>
                            <td>
                                <span style="font-weight: bold;">Fecha de conclusión: </span>
                                <?php if ($e_detalle['fecha_conclusion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['fecha_conclusion'])) ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Núm. de recomendación: </span>
                                <?php if ($e_detalle['num_recomendacion'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['num_recomendacion'])) ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Fecha de termino: </span>
                                <?php if ($e_detalle['fecha_termino'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords($e_detalle['fecha_termino'])) ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Fecha de avocamiento: </span>
                                <?php if ($e_detalle['fecha_avocamiento'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['fecha_avocamiento']))) ?>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 3%;">
                                <span style="font-weight: bold;">Descripción (Sin materia): </span>
                                <?php if ($e_detalle['descripcion_sin_materia'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['descripcion_sin_materia']))) ?>
                                <br><br>
                            </td>
                            <td style="width: 3%;">
                                <span style="font-weight: bold;">Archivo (Sin materia): </span>
                                <?php
                                $folio_editar = $e_detalle['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <a target="_blank" style="color:#0094FF" href="uploads/quejas/<?php echo $resultado . '/Sin_Materia/' . $e_detalle['archivo_sin_materia']; ?>"><?php echo $e_detalle['archivo_sin_materia']; ?></a>
                                <br><br>
                            </td>
                            <td style="width: 3%;">
                                <span style="font-weight: bold;">Archivo (ANV): </span>
                                <?php
                                $folio_editar = $e_detalle['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <a target="_blank" style="color:#0094FF" href="uploads/quejas/<?php echo $resultado . '/ANV/' . $e_detalle['archivo_anv']; ?>"><?php echo $e_detalle['archivo_anv']; ?></a>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Fecha de desistimiento: </span>
                                <?php if ($e_detalle['fecha_desistimiento'] == "") {
                                    echo "N/A";
                                } else
                                    echo remove_junk(ucwords(($e_detalle['fecha_desistimiento']))) ?>
                                <br><br>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 3%;">
                                <span style="font-weight: bold;">Archivo (Desistimiento): </span>
                                <?php
                                $folio_editar = $e_detalle['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <a target="_blank" style="color:#0094FF" href="uploads/quejas/<?php echo $resultado . '/Desistimiento/' . $e_detalle['archivo_desistimiento']; ?>"><?php echo $e_detalle['archivo_desistimiento']; ?></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="Expedientes" class="tabcontent">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Expedientes de la Queja</span>
                    </strong>
                </div>
                <?php foreach ($e_detalle2 as $detalle) : ?>
                <div class="panel-body">
                    <table style="color:#3a3d44; margin-top: -10px">
                        <tr>
                            <td>
                                <span style="font-weight: bold;">Folio: </span>
                                <?php echo remove_junk(ucwords($detalle['folio_queja'])) ?>
                                <br><br>
                            </td>
                            <td style="width: 2%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Tipo de acuerdo: </span>
                                    <?php echo $detalle['tipo_acuerdo']?><br><br>
                                </span>
                            </td>
                            <td style="width: 3%;">
                                <span class="text-center">
                                    <span style="font-weight: bold;">Fecha de acuerdo: </span>
                                    <?php echo $detalle['fecha_acuerdo']?><br><br>
                                </span>
                            </td>
                            <td style="width: 2%;">
                                <span>
                                    <span style="font-weight: bold;">Acuerdo adjunto: </span>
                                    <?php echo $detalle['acuerdo_adjunto'] ?>
                                    <br><br>
                                </span>
                            </td>
                        </tr>
                        <tr>
                        <td style="width: 2%;">
                                <span>
                                    <span style="font-weight: bold;">Acuerdo público adjunto: </span>
                                    <?php echo $detalle['acuerdo_adjunto_publico'] ?>
                                    <br><br>
                                </span>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Versión pública: </span>
                                <?php if ($detalle['publico'] == 1) {
                                    echo "Sí";
                                } else
                                    echo "No"; ?>
                                <br><br>
                            </td>
                            <td>
                                <span style="font-weight: bold;">Razón de Desechamiento: </span>
                                <?php echo $detalle['sintesis_documento'] ?>
                                <br><br>
                            </td>
                        </tr>
                    </table>
                    <hr style="height: 1.5px; background-color: #5306e0; opacity: 1;">
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    function prueba(pestana) {
        if (pestana == 1) {
            return openCity(event, 'Generales');
        }
    }
</script>
<script>
    function cambiarPestanna(pestannas, pestanna) {

        // Obtiene los elementos con los identificadores pasados.
        pestanna = document.getElementById(pestanna.id);
        console.log(pestanna.id);
        listaPestannas = document.getElementById(pestannas.id);

        // Obtiene las divisiones que tienen el contenido de las pestañas.
        cpestanna = document.getElementById('c' + pestanna.id);
        listacPestannas = document.getElementById('contenido' + pestannas.id);

        i = 0;
        // Recorre la lista ocultando todas las pestañas y restaurando el fondo y el padding de las pestañas.

        while (typeof listacPestannas.getElementsByTagName('div')[i] != 'undefined') {
            $(document).ready(function() {
                // ----------->>>>>>>>>>> ES LO QUE BLOQUEA EL QUE FUNCIONEN LOS DIVS <<<<<<<<<<<<<----------------
                $(listacPestannas.getElementsByTagName('div')[i]).css('display', 'none');
                // ------------------------------------------------------------------------------------------------
                $(listaPestannas.getElementsByTagName('li')[i]).css('background', '');
                $(listaPestannas.getElementsByTagName('li')[i]).css('padding-bottom', '');
            });
            i += 1;
        }

        $(document).ready(function() {
            // Muestra el contenido de la pestaña pasada como parametro a la funcion, cambia el color de la pestaña y aumenta el padding para que tape el  
            // borde superior del contenido que esta puesto debajo y se vea de este modo que esta seleccionada.
            $(cpestanna).css('display', '');
            $(pestanna).css('background', '#056DCD');
            $(pestanna).css('padding-bottom', '2px');
        });
    }
</script>

<?php include_once('layouts/footer.php'); ?>
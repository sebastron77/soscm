<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Queja';
require_once('includes/load.php');
?>
<?php
$e_detalle = find_by_id_queja((int) $_GET['id']);
$user = current_user();
$nivel = $user['user_level'];
$cat_est_procesal = find_all('cat_est_procesal');
$cat_municipios = find_all_cat_municipios();

if ($nivel <= 2) {
    page_require_level(2);
}
if ($nivel == 3) {
    redirect('home.php');
}
if ($nivel == 4) {
    redirect('home.php');
}
if ($nivel == 5) {
    page_require_level(5);
}
if ($nivel == 6) {
    redirect('home.php');
}
if ($nivel == 7) {
    redirect('home.php');
}
?>

<style>
    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
        color: black;
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
    .tabcontent {
        display: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }

    .rectangulo {
        width: 90%;
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
<div class="tab">
    <button class="tablinks" onclick="openCity(event, 'Generales')">Generales</button>
    <button class="tablinks1" onclick="openCity(event, 'Seguimiento')">Seguimiento</button>
    <button class="tablinks2" onclick="openCity(event, 'Expedientes')">Expedientes</button>
</div>
<div class="row">
    <div id="Generales" class="tabcontent">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading clearfix">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <span>Información de Queja</span>
                    </strong>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead class="thead-purple">
                            <tr style="height: 10px;">
                                <th style="width: 2%;" class="text-center">Folio</th>
                                <th style="width: 1%;" class="text-center">Fecha Presentación</th>
                                <th style="width: 2%;" class="text-center">Medio de Presentación</th>
                                <th style="width: 7%;" class="text-center">Autoridad Responsable</th>
                                <th style="width: 0.1%;" class="text-center">Incompetencia</th>
                                <th style="width: 5%;" class="text-center">Causa Incompetencia</th>
                                <th style="width: 1%;" class="text-center">Fecha Acuerdo Incompetencia</th>
                                <th style="width: 7%;" class="text-center">¿A quién se traslada?</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['folio_queja'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['fecha_presentacion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['medio_pres'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['nombre_autoridad'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['incompetencia'] == "" || $e_detalle['incompetencia'] == 0) {
                                        echo "N/A";
                                    } else
                                        echo 'Sí' ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['causa_incomp'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['causa_incomp']))) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['fecha_acuerdo_incomp'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['fecha_acuerdo_incomp']))) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['a_quien_se_traslada'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['a_quien_se_traslada']))) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-purple">
                            <tr>
                                <th style="width: 0.1%;" class="text-center">Desechamiento</th>
                                <th style="width: 7%;" class="text-center">Razón Desechamiento</th>
                                <th style="width: 7%;" class="text-center">Forma Conclusión</th>
                                <th style="width: 1%;" class="text-center">Fecha Conclusión</th>
                                <th style="width: 3%;" class="text-center">Estado Procesal</th>
                                <th style="width: 2%;" class="text-center">Tipo Resolución</th>
                                <th style="width: 1%;" class="text-center">Num. Recomendación</th>
                                <th style="width: 1%;" class="text-center">Tipo de Ámbito</th>
                                <th style="width: 3%;" class="text-center">Fecha termino</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <?php if ($e_detalle['desechamiento'] == "" || $e_detalle['desechamiento'] == "0") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['desechamiento'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['razon_desecha'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['razon_desecha'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['forma_conclusion'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk($e_detalle['forma_conclusion']) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['fecha_conclusion'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['fecha_conclusion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['estado_procesal'] == "") {
                                        echo "N/A";
                                    } else {
                                        foreach ($cat_est_procesal as $est_pros) {
                                            if ($e_detalle['estado_procesal'] == $est_pros['id_cat_est_procesal']) {
                                                echo remove_junk(ucwords($est_pros['descripcion']));
                                            }
                                        }
                                    } ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['tipo_resolucion'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['tipo_resolucion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['num_recomendacion'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['num_recomendacion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['tipo_ambito'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['tipo_ambito'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['fecha_termino'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords($e_detalle['fecha_termino'])) ?>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-purple">
                            <tr>
                                <th style="width: 10%;" class="text-center">Quejoso</th>
                                <th style="width: 10%;" class="text-center">Agraviado</th>
                                <th style="width: 3%;" class="text-center">Fecha Creación</th>
                                <th style="width: 1%;" class="text-center">Asignado a</th>
                                <th style="width: 5%;" class="text-center">Área asignada</th>
                                <th style="width: 3%;" class="text-center">Fecha Vencimiento</th>
                                <th style="width: 3%;" class="text-center">Fecha avocamiento</th>
                                <th style="width: 5%;" class="text-center">Estatus Queja</th>
                                <th style="width: 5%;" class="text-center">Archivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords(($e_detalle['nombre_quejoso'] . " " . $e_detalle['paterno_quejoso'] . " " . $e_detalle['materno_quejoso']))) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['nombre_agraviado'] . " " . $e_detalle['paterno_agraviado'] . " " . $e_detalle['materno_agraviado'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['fecha_creacion'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords(($e_detalle['username']))) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords(($e_detalle['nombre_area']))) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($e_detalle['fecha_vencimiento'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($e_detalle['fecha_avocamiento'] == "") {
                                        echo "N/A";
                                    } else
                                        echo remove_junk(ucwords(($e_detalle['fecha_avocamiento']))) ?>
                                </td>
                                <td>
                                    <?php echo remove_junk(ucwords($e_detalle['estatus_queja'])) ?>
                                </td>
                                <?php
                                $folio_editar = $e_detalle['folio_queja'];
                                $resultado = str_replace("/", "-", $folio_editar);
                                ?>
                                <td class="text-center"><a target="_blank" style="color:#0094FF" href="uploads/quejas/<?php echo $resultado . '/' . $e_detalle['archivo']; ?>"><?php echo $e_detalle['archivo']; ?></a></td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table table-bordered table-striped">
                        <thead class="thead-purple">
                            <tr>
                                <th style="width: 5%;" class="text-center">Calle</th>
                                <th style="width: 0.5%;" class="text-center">Núm.</th>
                                <th style="width: 5%;" class="text-center">Colonia</th>
                                <th style="width: 5%;" class="text-center">Municipio</th>
                                <th style="width: 10%;" class="text-center">Descripción Hechos</th>
                                <th style="width: 10%;" class="text-center">Notas internas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['dom_calle'])) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($e_detalle['dom_numero']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk(ucwords($e_detalle['dom_colonia'])) ?>
                                </td>
                                <td class="text-center">
                                    <!-- <?php echo remove_junk(ucwords($e_detalle['id_cat_mun'])) ?> -->
                                    <?php
                                    foreach ($cat_municipios as $municipios) {
                                        if ($e_detalle['id_cat_mun'] == $municipios['id_cat_mun']) {
                                            echo remove_junk(ucwords($municipios['descripcion']));
                                        }
                                    }
                                    ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($e_detalle['descripcion_hechos']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo remove_junk($e_detalle['observaciones']) ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <!-- <a href="quejas.php" class="btn btn-md btn-success" data-toggle="tooltip" title="Regresar">
                    Regresar
                </a> -->
                </div>
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

            function prueba(pestana){
                if(pestana == 1){
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
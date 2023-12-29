<!DOCTYPE html>
<html lang="es">
<?php
require_once('includes/load.php');

$osc = find_all_osc();
$all_noticias = find_all_noticias2();
$all_eventos = find_all_eventos();
$all_eventos2 = find_all_eventos2();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Principal</title>
    <!-- Agrega este enlace a Bootstrap en la sección head de tu HTML -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">
    <link href="MyFont1.otf" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="libs/css/main.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,600,0,-25" />
</head>
<style>
    .body {
        font-family: "Montserrat", sans-serif;
        font-size: 13px;
        background: #e3e3e3;
    }

    .header {
        font-size: 15px;
    }

    .titulo {
        font-size: 72px;
        width: 115%;
        background: -webkit-linear-gradient(left, #081859, #1a95cb);
        background: linear-gradient(to right, #081859, #1a95cb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-family: "Montserrat", sans-serif;
    }

    .container {
        max-width: 800px;
        margin: auto;
    }

    .carousel-inner img {
        max-height: 450px;
        object-fit: cover;
        vertical-align: middle;
    }

    .popup-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
    }

    .popup-content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: #333;
        cursor: pointer;
    }

    .img-round {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        border: 2px solid #00164d;
        cursor: pointer;
        object-fit: cover;
        vertical-align: middle;
        background-color: white;
    }

    .image-container {
        /* display: flex; */
        justify-content: space-around;
        width: 100%;
        flex-wrap: wrap;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .footer {
        background-color: #091d5d;
    }

    a {
        color: white;
        font-size: 16px;
        text-decoration: none;
    }

    a:hover {
        color: #43DBE0;
    }


    .calendario {
        border: 1px solid #ddd;
        width: 90%;
        padding: 10px;
        box-sizing: border-box;
        margin-bottom: 25%;
        margin-left: 5%;
    }

    .headerC {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-radius: 3px;
    }

    .dias-semana {
        border-radius: 3px;
        display: flex;
        justify-content: space-around;
        background-color: #1573ac;
        color: white;
        font-weight: bold;
        margin-bottom: 0px;
        height: 30px;
        /* border: 2px solid #506883; */
    }

    .dias-mes {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        height: 35px;
        font-size: 13px;
    }

    .dias-mes span {
        text-align: center;
        padding: 5px;
        cursor: pointer;
        height: 70px;
        text-align: right;

        border-right-color: rgba(82, 104, 131, 0.15);
        border-left-color: rgba(82, 104, 131, 0.15);
        border-top-color: rgba(82, 104, 131, 0.15);
        border-bottom-color: rgba(82, 104, 131, 0.15);

        border-right-width: 0.1px;
        border-left-width: 0.5px;
        border-top-width: 0.1px;
        border-bottom-width: 0.5px;
        background-color: rgba(21, 115, 172, 0.05);
    }

    .mes {
        font-size: 18px;
        font-weight: bold;
    }

    .prev,
    .next {
        cursor: pointer;
        border-radius: 5px;
        background-color: #091d5d;
        line-height: inherit;
        -webkit-appearance: none;
        -moz-appearance: none;
        border: none;
    }

    .evento {
        background-color: #4CAF50;
        /* Color de fondo para los eventos */
        color: #fff;
        /* Color de texto para los eventos */
        padding: 2px;
        border-radius: 4px;
        text-align: center;
    }

    .btn-cerrar {
        font-size: 25px;
        /* Tamaño del texto */
        padding: 0px 8px;
        /* Espacio interno (arriba y abajo, izquierda y derecha) */
        background-color: #091d5d;
        /* Color de fondo */
        color: white;
        /* Color del texto */
        border: none;
        /* Elimina el borde */
        border-radius: 2px;
        /* Bordes redondeados */
        cursor: pointer;
        /* Cambia el cursor al pasar el ratón */
        margin-top: -2%;
    }
</style>

<body class="body">
    <nav class="navbar navbar-expand-lg bg-body-tertiary header">
        <div class="container-fluid">
            <div class="logo pull-left" style="width: 15%;"><img border="0" src="medios/Imagen4.png" width="34px" title="CEDH" alt="" style="margin-left: 12%;" />
                <div>
                    <p class="titulo" style="margin-top: -18.5%; margin-left: 28%; font-size:35px; font-weight:bold;">SOSCDH</p>
                    <p style="font-family: My Font1; font-size: 49px; color:#1573ac; margin-top:-34.5%; margin-bottom:-9.8px; margin-left: 97%;">M</p>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 3%; margin-top: -0.5%;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="principal.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="noticias.php" style="margin-left: 50%;">Noticias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="eventos.php" style="margin-left: 100%;">Eventos</a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="admin.php" style="color: black;">Iniciar Sesión</a>
            </div>
        </div>
    </nav>
    <!-- Carousel -->
    <div id="demo" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators/dots -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
        </div>

        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
            <?php foreach ($all_noticias as $a_noticia) : ?>
                <div class="carousel-item active">
                    <img src="uploads/noticias/<?php echo str_replace(' ', '', $a_noticia['titulo_noticia']); ?>/<?php echo $a_noticia['imagen']; ?>" alt="<?php echo $a_noticia['id_noticia'] ?>" class="d-block" style="width:100%">
                    <div class="carousel-caption" style="background: rgba(0, 0, 0, 0.3); border-radius: 5px; height:30%;">
                        <h3 style="margin-top: -1%;"><?php echo $a_noticia['titulo_noticia']; ?></h3>
                        <p style="margin-top: 0%;"><?php echo $a_noticia['noticia_all'] . '...'; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>
    <div class="d-flex align-items-center justify-content-center">
        <div class="row justify-content-center" style="margin-top: 1%;">

            <?php foreach ($all_noticias as $a_noticia) : ?>
                <div class="justify-content-center col-md-4" style="margin-left: 0px;">
                    <div class="card" style="width: 28rem; height: 33rem;">
                        <img src="uploads/noticias/<?php echo str_replace(' ', '', $a_noticia['titulo_noticia']); ?>/<?php echo $a_noticia['imagen']; ?>" class="card-img-top" height="315px;" alt="...">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $a_noticia['titulo_noticia']; ?></h5>
                            <p id="parrafoRecortado" class="card-text"><?php echo $a_noticia['noticia_all'] . '...'; ?></p>
                            <a href="ver_noticia.php?id=<?php echo (int)$a_noticia['id_noticia']; ?>" class="btn btn-primary btn-sm" style="margin-top: -3.5%; margin-left: 39%">Ir a noticia</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    </div><br><br>
    <div style="background-color: white; margin-top: -5px;">
        <!-- <div style="background-color: white; border-radius: 10px; width:97%; margin-left: 1.5%; margin-top: -5px;"> -->
        <div class="image-container">
            <?php $i = 0;
            $i2 = 0;
            foreach ($osc as $o) :

                $i = $i + 1;
                $i2 = $i2 + 1;
                //echo $i; 
            ?>

                <img class="img-round" src="uploads/logos_osc/<?php echo $o['siglas'] . '/' . $o['logo'] ?>" style="margin-top: 20px; margin-left: 9.5%;" alt="Imagen Miniatura" data-toggle="modal" data-target="#imagenModal<?php echo $i2; ?>">
                <?php if ($i == 5) {
                    $i = 0;
                    echo '<br><br>';
                }
                ?>
                <!-- Modal -->
                <div class="modal fade" id="imagenModal<?php echo $i2; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 800px;" role="document">
                        <div class="modal-content">
                            <div class="modal-header" style="color: white; height: 40px; background: #091d5d;">
                                <p class="modal-title" id="exampleModalLongTitle" style="color: white; font-size: 20px; font-weight: bold;"><?php echo $o['nombre'] ?></p>
                                <button type="button" class="close btn-cerrar" style="margin-top: -10px;" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p style="text-align: justify; font-size: 15px;"><strong>Siglas:</strong> <?php echo $o['siglas'] ?></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Ámbito:</strong> <?php echo $o['ambito_dv'] ?></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Objetivo:</strong> <?php echo $o['objetivo'] ?></p>
                                <?php if ($o['info_publica'] == 1) : ?>
                                    <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Domicilio:</strong> <?php echo $o['calle_num'] . ', Col. ' . $o['colonia'] . ', C.P. ' . $o['cp'] ?></p>
                                    <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Teléfono:</strong> <?php echo $o['telefono'] ?></p>
                                <?php endif; ?>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Web Oficial:</strong> <a href="<?php echo $o['web_oficial'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['web_oficial'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>X:</strong><a href="<?php echo $o['x'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['x'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Facebook:</strong><a href="<?php echo $o['facebook'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['facebook'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Instagram:</strong><a href="<?php echo $o['instagram'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['instagram'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Youtube:</strong><a href="<?php echo $o['youtube'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['youtube'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Tiktok:</strong><a href="<?php echo $o['tiktok'] ?>" style=" font-size: 15px; color:#091d5d;"> <?php echo $o['tiktok'] ?></a></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Correo Oficial:</strong> <?php echo $o['correo_oficial'] ?></p>
                                <p style="text-align: justify; margin-top: -10px; font-size: 15px;"><strong>Región:</strong> <?php echo $o['region_a'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div><br><br>
    </div>

    <div class="calendario" id="calendario">
        <div class="headerC" style="background-color: #1573ac; color: white;">
            <button class="prev" onclick="cambiarMes(-1)">
                <span class="material-symbols-outlined" style="color: white; font-size: 20px; margin-top: 6px;">
                    chevron_left
                </span>
            </button>
            <span class="mes" id="nombreMes"></span>
            <button class="next" onclick="cambiarMes(1)">
                <span class="material-symbols-outlined" style="color: white; font-size: 20px; margin-top: 6px;">
                    chevron_right
                </span>
            </button>
        </div>
        <div class="dias-semana">
            <span style="margin-top: 5px;">Domingo</span>
            <span style="margin-top: 5px;">Lunes</span>
            <span style="margin-top: 5px;">Martes</span>
            <span style="margin-top: 5px;">Miércoles</span>
            <span style="margin-top: 5px;">Jueves</span>
            <span style="margin-top: 5px;">Viernes</span>
            <span style="margin-top: 5px;">Sábado</span>
        </div>
        <div class="dias-mes" id="diasMes">
            <!-- Los días del mes se generarán dinámicamente con JavaScript -->
            <!-- Modal -->
            <div class="modal fade" id="eventoModal" tabindex="-1" aria-labelledby="eventoModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="height: 40px; background: #091d5d;">
                            <p style="color: white; font-size: 20px; font-weight: bold;" class="modal-title" id="eventoModalLabel">Detalles del Evento</p>
                            <button type="button" class="close btn-cerrar" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <div class="modal-body" id="eventoModalBody">
                            <!-- Contenido del modal generado dinámicamente por JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
    <div class="footer">
        <br>
        <h3 style="color: white; text-align: center;">SITIOS DE INTERÉS</h3>
        <div class="row" style="margin-top: 1%; margin-left: 3%;">
            <div class="col-md-6" style="text-align: center; margin-bottom: 1%">
                <a href="https://www.cndh.org.mx/" style="height: 10px; margin-bottom: 5%;" target="_blank">Comisión Nacional de Derechos Humanos</a>
            </div>
            <div class="col-md-6" style="text-align: center; margin-bottom: 1%">
                <a href="https://www.iidh.ed.cr/es/" style="height: 10px; margin-bottom: 5%;" target="_blank">Instituto Interamericano de Derechos Humanos</a>
            </div>
            <div class="col-md-6" style="text-align: center; margin-bottom: 1%">
                <a href="https://www.corteidh.or.cr/" style="height: 10px; margin-bottom: 5%;" target="_blank">Corte Interamericana de Derechos Humanos</a>
            </div>
            <div class="col-md-6" style="text-align: center; margin-bottom: 1%">
                <a href="https://federacionombudsperson.org.mx/" style="height: 10px; margin-bottom: 5%;" target="_blank">Federación Mexicana de Organismos Públicos de Derechos Humanos</a>
            </div>
            <div class="col-md-6" style="text-align: center; margin-bottom: 1%">
                <a href="http://congresomich.gob.mx/" style="height: 10px; margin-bottom: 5%;" target="_blank">Congreso del Estado de Michoacán</a>
            </div>
        </div>
    </div>

</body>
<script>
    // Número deseado de caracteres
    const maxCaracteres = 50;
    // Obtener el contenido original del párrafo
    const parrafoOriginal = document.getElementById('parrafoRecortado').innerText;
    const parrafoOriginal1 = document.getElementById('parrafoRecortado1').innerText;
    const parrafoOriginal2 = document.getElementById('parrafoRecortado2').innerText;
    // Recortar el contenido al número deseado de caracteres
    const parrafoRecortado = parrafoOriginal.slice(0, 210);
    const parrafoRecortado1 = parrafoOriginal1.slice(0, 210);
    const parrafoRecortado2 = parrafoOriginal2.slice(0, 210);
    // Mostrar el párrafo recortado
    document.getElementById('parrafoRecortado').innerText = parrafoRecortado + '...';
    document.getElementById('parrafoRecortado1').innerText = parrafoRecortado1 + '...';
    document.getElementById('parrafoRecortado2').innerText = parrafoRecortado2 + '...';

    function abrirPopup() {
        document.getElementById("popup").style.display = "block";
    }

    function cerrarPopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>



<script>
    let fechaActual = new Date();

    function mostrarCalendario() {
        const headerMes = document.getElementById('nombreMes');
        const diasMes = document.getElementById('diasMes');
        const primerDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
        const primerDiaSemana = primerDiaMes.getDay();
        const ultimoDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth() + 1, 0);
        const ultimoDia = ultimoDiaMes.getDate();
        const eventos = <?php echo json_encode(find_all_eventos()); ?>;
        // Antes de tu bucle para generar días del mes
        const modalBody = document.getElementById('eventoModalBody');
        const eventoModal = new bootstrap.Modal(document.getElementById('eventoModal'));


        // Configurar el texto del encabezado con el mes y año actual
        headerMes.textContent = obtenerNombreMes(fechaActual.getMonth()) + ' ' + fechaActual.getFullYear();

        // Limpiar días del mes anterior
        diasMes.innerHTML = '';

        // Agregar días vacíos del mes anterior
        for (let i = primerDiaSemana; i > 0; i--) {
            const diaAnterior = ultimoDiaMes.getDate() - i + 1;
            const diaElemento = document.createElement('span');

            const htmlCode = '<span><?php echo "Este es un texto PHP "; ?></span>';
            diaElemento.textContent = diaAnterior;
            diaElemento.title = obtenerNombreDia(new Date(fechaActual.getFullYear(), fechaActual.getMonth(), diaAnterior).getDay()) + ', ' + diaAnterior + ' ' + obtenerNombreMes(fechaActual.getMonth() - 1) + ' ' + fechaActual.getFullYear();
            diasMes.appendChild(diaElemento);

        }

        // Generar días del mes actual
        for (let dia = 1; dia <= ultimoDia; dia++) {
            const diaElemento = document.createElement('span');
            diaElemento.textContent = dia;
            const fechaDia = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), dia);
            <?php
            $eventosPorFecha = array();

            foreach ($all_eventos2 as $evento2) :
                $fechaEvento = $evento2['fecha'];
                $eventosPorFecha[$fechaEvento][] = $evento2;

            ?>
                // Obtener eventos para el día actual desde el array PHP           
                diaElemento.title = obtenerNombreDia(new Date(fechaActual.getFullYear(), fechaActual.getMonth(), dia).getDay()) + ', ' + dia + ' ' + obtenerNombreMes(fechaActual.getMonth()) + ' ' + fechaActual.getFullYear();


                //Sumamos un día porque es un arreglo que empieza en 0, y para que coincidan los meses se suma el 1
                var sumaMes = fechaActual.getMonth() + 1;

                if (dia <= 9) {
                    nDia = '0' + dia;
                } else {
                    nDia = dia;
                };
                fechaCompara = fechaActual.getFullYear() + '-' + sumaMes + '-' + nDia
                diasMes.appendChild(diaElemento);

                //Recorremos todos los eventos

                fechaEvento = '<?php echo $evento2['fecha']; ?>';
                var tema = document.createTextNode("<?php echo $evento2['temaCorto'] ?>");


                //Comparamos las fechas de los eventos para ver si coinciden con los del calendario
                if (fechaCompara == fechaEvento) {

                    diaElemento.appendChild(document.createElement("br"));
                    diaElemento.appendChild(tema);

                    // var todo = "INFORMACIÓN DEL EVENTO\n\nTema: <?php echo $evento2['temaCorto']; ?>\nHora: <?php echo $evento2['hora']; ?>\nLugar: <?php echo $evento2['lugar']; ?>";
                    diaElemento.addEventListener('click', function() {
                        // alert(todo);
                        modalBody.innerHTML = `
                            <p style="font-size: 20px; font-weight: bold; text-align: center; color: #1573ac;"><?php echo $evento2['tema'] ?></p>
                            <p><strong>Fecha:</strong> <?php echo $evento2['fecha'] ?></p>
                            <p style="margin-top: -3%;"><strong>Hora:</strong> <?php echo $evento2['hora'] ?></p>
                            <p style="margin-top: -3%;"><strong>Lugar:</strong> <?php echo $evento2['lugar'] ?></p>
                        `;
                        // Abre el modal
                        eventoModal.show();
                    });
                    // console.log(todo);
                }
            <?php endforeach; ?>
        }
    }

    function cambiarMes(cambio) {
        fechaActual.setMonth(fechaActual.getMonth() + cambio);
        mostrarCalendario();
    }

    function obtenerNombreMes(mes) {
        const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        return meses[mes];
    }

    function obtenerNombreDia(dia) {
        const dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        return dias[dia];
    }

    // Mostrar calendario al cargar la página
    mostrarCalendario();
</script>

</html>
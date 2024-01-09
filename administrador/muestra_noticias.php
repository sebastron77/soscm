<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="medios/favicon-16x16.png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticias</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css" />
    <link rel="stylesheet" href="libs/css/main.css" />
    <link rel="stylesheet" href="libs/css/organigrama.css" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>
    <script src="html2pdf.bundle.min.js"></script>
    <script src="script.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap" rel="stylesheet">

    <link href="https://harvesthq.github.io/chosen/chosen.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="https://harvesthq.github.io/chosen/chosen.jquery.js"></script>
    <link href="MyFont1.otf" rel="stylesheet">
</head>
<?php
require_once('includes/load.php');
$all_noticias = find_all_noticias();
?>

<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary header">
        <div class="container-fluid" style="margin-top: 5px;">
            <div class="logo pull-left" style="width: 15%;"><img border="0" src="medios/Imagen4.png" width="34px" title="CEDH" style="margin-left: 12%;" />
                <div>
                    <p class="titulo" style="margin-top: -18.5%; margin-left: 28%; font-size:35px; font-weight:bold;">SOSCDH</p>
                    <p style="font-family: My Font1; font-size: 49px; color:#1573ac; margin-top:-31.5%; margin-bottom:-9.8px; margin-left: 97%;">M</p>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 3%; margin-top: -0.5%;">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="principal.php">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="muestra_noticias.php" style="margin-left: 50px;">Noticias</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="muestra_eventos.php" style="margin-left: 50px;">Eventos</a>
                    </li>
                </ul>
            </div>
            <div>
                <a href="admin.php" style="color: black;">Iniciar Sesión</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <strong>
                            <span class="glyphicon glyphicon-th"></span>
                            <span>Lista de Noticias</span>
                        </strong>
                    </div>

                    <div class="panel-body">
                        <table class="datatable table table-bordered table-striped">
                            <thead class="thead-purple">
                                <tr style="height: 10px;"">
                                <th class="text-center" style=" width: 10%;">Fecha Pub.</th>
                                    <th class="text-center" style="width: 25%;">Nombre de OSC</th>
                                    <th class="text-center" style="width: 25%;">Titulo de Noticia</th>
                                    <th class="text-center" style="width: 25%;">Previa de Noticia</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_noticias as $a_noticia) : ?>
                                    <tr>
                                        <td class="text-center"><?php echo remove_junk($a_noticia['fecha']) ?></td>
                                        <td><?php echo remove_junk(ucwords($a_noticia['nombre'])) ?></td>
                                        <td><a href="ver_noticia.php?id=<?php echo (int)$a_noticia['id_noticia']; ?>" style="color: #0d3d7b;"><?php echo remove_junk(ucwords($a_noticia['titulo_noticia'])) ?></a></td>
                                        <!-- <td><?php echo remove_junk(ucwords($a_noticia['titulo_noticia'])) ?></td> -->
                                        <td><?php $txt = substr($a_noticia['noticia'], 0, 200);
                                            echo $txt . '...'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('footer.php'); ?>
</body>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="libs/js/pagination.js"></script>

</html>
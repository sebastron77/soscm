<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticia</title>
    <link rel="icon" type="image/png" sizes="16x16" href="medios/favicon-16x16.png">
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

    .container2 {
        max-width: 800px;
        margin: auto;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 20px;
        color: #333;
        cursor: pointer;
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
    
    h1 {
        font-weight: bold;
        text-align: center;
    }
</style>

<nav class="navbar navbar-expand-lg bg-body-tertiary header">
        <div class="container-fluid">
            <div class="logo pull-left" style="width: 15%;"><img border="0" src="medios/Imagen4.png" width="34px" title="CEDH" style="margin-left: 12%;" />
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
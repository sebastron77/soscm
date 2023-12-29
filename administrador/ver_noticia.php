<!DOCTYPE html>
<html lang="en">
<?php
$page_title = 'Datos trabajadores';
require_once('includes/load.php');
?>
<?php
header('Content-Type: text/html; charset=UTF-8');
$v_noticia = noticia_by_id((int) $_GET['id']);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Noticia</title>
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

    .container {
        max-width: 700px;
        margin: 20px auto;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        border-radius: 10px;
    }

    .imgNoticia {
        max-width: 50%;
        height: auto;
        margin-bottom: 5%;
        display: block;
        margin: 0 auto;
    }
</style>

<body>
    <?php include_once('header_nav.php'); ?>
    <div class="container">
        <h1 style="margin-top: -0.5%; color: #091d5d;"><?php echo upper_case($v_noticia['titulo_noticia']); ?></h1>
        <hr style="color: #636363">
        <img class="imgNoticia" style=" margin-top: 2%;" src="uploads/noticias/<?php echo str_replace(' ', '', $v_noticia['titulo_noticia']); ?>/<?php echo $v_noticia['imagen']; ?>">
        <p style="margin-top: 2%; margin-left: 30px; margin-right: 30px; text-align: justify;"><?php echo $v_noticia['noticia'] ?></p>
    </div>
    <?php include_once('footer.php'); ?>
</body>

</html>
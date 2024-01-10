<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'SOSCM';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$year = date("Y");
$c_noticias = count_by_id('noticias', 'id_noticia');
$c_osc = count_by_id('osc', 'id_osc');
$c_eventos = count_by_id('eventos', 'id_evento');
page_require_level(1);

?>

<?php include_once('layouts/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<style>
    @font-face {
        font-family: 'My Font';
        src: url('MyFont-Regular.otf') format('opentype');
        font-style: normal;
        font-weight: normal;
    }
</style>

<div class="container-fluid">
    <div class="full-box tile-container">

        <a style="text-decoration:none;" href="osc.php" class="tile">
            <div class="tile-tittle">OSC</div>
            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    diversity_3
                </span>
                <p> <?php echo $c_osc['total']; ?> Organizaciones Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" href="noticias.php" class="tile">
            <div class="tile-tittle">Noticias</div>

            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    newspaper
                </span>
                <p><?php echo $c_noticias['total']; ?> Noticias Publicadas</p>
            </div>
        </a>

        <a style="text-decoration:none;" href="eventos.php" class="tile">
            <div class="tile-tittle">Eventos</div>
            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    event_note
                </span>
                <p><?php echo $c_eventos['total']; ?> Eventos Registrados</p>
            </div>
        </a>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
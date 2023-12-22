<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'SOSCM';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
$year = date("Y");
$c_user = count_by_id('users', 'id_user');
$c_areas = count_by_id('area', 'id_area');

if ($nivel_user <= 2) {
    page_require_level(2);
}
if ($nivel_user == 7) {
    page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
    redirect('home.php');
endif;
if ($nivel_user > 7 && $nivel_user < 21) :
    redirect('home.php');
endif;
if ($nivel_user == 21) :
    page_require_level_exacto(21);
endif;
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

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="osc.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">OSC</div>
            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    diversity_3
                </span>
                <p> <?php echo $c_areas['total']; ?> Organizaciones Registradas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="noticias.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Noticias</div>
            
            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    newspaper
                </span>
                <p><?php echo $c_user['total']; ?> Noticias Publicadas</p>
            </div>
        </a>

        <a style="text-decoration:none;" <?php if ($nivel_user <= 2 || $nivel_user == 7) : ?> href="eventos.php" <?php endif; ?> class="tile">
            <div class="tile-tittle">Eventos</div>
            <div class="tile-icon">
                <span class="material-symbols-outlined" style="font-size:95px;">
                    event_note
                </span>
                <p><?php echo $c_user['total']; ?> Eventos Registrados</p>
            </div>
        </a>
    </div>
</div>

<?php include_once('layouts/footer.php'); ?>
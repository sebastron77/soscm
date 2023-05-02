<?php
$page_title = 'Presidencia';
require_once('includes/load.php');
?>
<?php
$user = current_user();
$id_user = $user['id_user'];
$nivel = $user['user_level'];

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

<?php
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<a href="solicitudes.php" class="btn btn-info">Regresar a Áreas</a><br><br>
<h1 style="color: #3a3d44;">Solicitudes de Presidencia</h1>


<div class="row">
    <div class="col-md-12">
        <?php echo display_msg($msg); ?>
    </div>
</div>

<div class="container-fluid">
    <div class="full-box tileO-container">
        <a href="#" class="tileO">
            <div class="tileO-tittle">Acciones Incost.</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    gavel
                </span>
            </div>
        </a>
        <a href="consejo.php" class="tileO">
            <div class="tileO-tittle">Actas sesión de consejo</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    receipt_long
                </span>

            </div>
        </a>
        <a href="eventos_pres.php" class="tileO">
            <div class="tileO-tittle">Actividades</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    arrow_circle_right
                </span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Amicus Curiae</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    groups
                </span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Ámparo</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    balance
                </span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Controversia Const.</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    account_balance
                </span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Convenios</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    description
                </span>
            </div>
        </a>
        <a href="gestiones.php" class="tileO">
            <div class="tileO-tittle">Gestión Jurisdiccional</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">send_time_extension</span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Opinión Consultiva</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    psychology_alt
                </span>
            </div>
        </a>
        <a href="#" class="tileO">
            <div class="tileO-tittle">Oficios</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    history_edu
                </span>
            </div>
        </a>
        <a href="recomendaciones_generales.php" class="tileO">
            <div class="tileO-tittle">Recomendaciones</div>
            <div class="tileO-icon">
                <span class="material-symbols-rounded" style="font-size:95px;">
                    breaking_news_alt_1
                </span>
            </div>
        </a>
    </div>
</div>
<?php include_once('layouts/footer.php'); ?>
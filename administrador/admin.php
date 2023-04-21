<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'SUIGCEDH';
require_once('includes/load.php');

$user = current_user();
$nivel_user = $user['user_level'];
// page_require_area(7);

if ($nivel_user <= 2) {
	page_require_level(2);
}
if ($nivel_user == 7) {
	page_require_level_exacto(7);
}
if ($nivel_user > 2 && $nivel_user < 7) :
	redirect('home.php');
endif;
if ($nivel_user > 7) :
	redirect('home.php');
endif;
?>
<?php
$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
$c_orientacion = count_by_id_orientacion('orientacion_canalizacion', 'id_or_can');
$c_canalizacion = count_by_id_canalizacion('orientacion_canalizacion', 'id_or_can');
$c_quejas = count_by_id('quejas_dates', 'id_queja_date');
?>
<?php include_once('layouts/header.php'); ?>

<div class="row">
	<div class="col-md-12">
		<?php echo display_msg($msg); ?>
	</div>
</div>

<div class="container-fluid">
	<div class="full-box tile-container">
		<a href="areas.php" class="tile">
			<div class="tile-tittle">Áreas</div>
			<div class="tile-icon">
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>domain</title>
					<path d="M18,15H16V17H18M18,11H16V13H18M20,19H12V17H14V15H12V13H14V11H12V9H20M10,7H8V5H10M10,11H8V9H10M10,15H8V13H10M10,19H8V17H10M6,7H4V5H6M6,11H4V9H6M6,15H4V13H6M6,19H4V17H6M12,7V3H2V21H22V7H12Z" />
				</svg> -->
				<span class="material-symbols-outlined" style="font-size:95px;">domain</span>
				<!-- <svg xmlns=" http://www.w3.org/2000/svg" width="100px" height="100px" fill="#455a64" class="bi bi-building" viewBox="0 0 16 16">
					<path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1ZM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1ZM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1Zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5h-1Z" />
					<path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V1Zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3V1Z" />
					</svg> -->
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>office-building-outline</title>
					<path d="M19 3V21H13V17.5H11V21H5V3H19M15 7H17V5H15V7M11 7H13V5H11V7M7 7H9V5H7V7M15 11H17V9H15V11M11 11H13V9H11V11M7 11H9V9H7V11M15 15H17V13H15V15M11 15H13V13H11V15M7 15H9V13H7V15M15 19H17V17H15V19M7 19H9V17H7V19M21 1H3V23H21V1Z" />
				</svg> -->
				<p> <?php echo $c_areas['total']; ?> Registradas</p>
			</div>
		</a>


		<a href="users.php" class="tile">
			<div class="tile-tittle">Trabajadores</div>
			<div class="tile-icon">
				<svg xmlns="http://www.w3.org/2000/svg" width="100px" height="100px" fill="#455a64" class="bi bi-person-video3" viewBox="0 0 16 16">
					<path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2Z" />
					<path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783.059-.187.09-.386.09-.593V4a2 2 0 0 0-2-2H2Z" />
				</svg>
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>account-tie</title>
					<path d="M12 3C14.21 3 16 4.79 16 7S14.21 11 12 11 8 9.21 8 7 9.79 3 12 3M16 13.54C16 14.6 15.72 17.07 13.81 19.83L13 15L13.94 13.12C13.32 13.05 12.67 13 12 13S10.68 13.05 10.06 13.12L11 15L10.19 19.83C8.28 17.07 8 14.6 8 13.54C5.61 14.24 4 15.5 4 17V21H20V17C20 15.5 18.4 14.24 16 13.54Z" />
				</svg> -->
				<i class="fas fa-user-tie"></i>
				<p><?php echo $c_user['total']; ?> Registrados</p>
			</div>
		</a>

		<a href="quejas.php" class="tile">
			<div class="tile-tittle">Quejas</div>
			<div class="tile-icon">
				<svg width="100px" height="100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>book-alert-outline</title>
					<path d="M16 2H4C2.9 2 2 2.9 2 4V20C2 21.11 2.9 22 4 22H16C17.11 22 18 21.11 18 20V4C18 2.9 17.11 2 16 2M16 20H4V4H6V12L8.5 9.75L11 12V4H16V20M20 15H22V17H20V15M22 7V13H20V7H22Z" />
				</svg>
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>account-child</title>
					<path d="M12,2A3,3 0 0,1 15,5A3,3 0 0,1 12,8A3,3 0 0,1 9,5A3,3 0 0,1 12,2M12,9C13.63,9 15.12,9.35 16.5,10.05C17.84,10.76 18.5,11.61 18.5,12.61V18.38C18.5,19.5 17.64,20.44 15.89,21.19V19C15.89,18.05 15.03,17.38 13.31,16.97C12.75,16.84 12.31,16.78 12,16.78C11.13,16.78 10.3,16.95 9.54,17.3C8.77,17.64 8.31,18.08 8.16,18.61C9.5,19.14 10.78,19.41 12,19.41L13,19.31V21.94L12,22C10.63,22 9.33,21.72 8.11,21.19C6.36,20.44 5.5,19.5 5.5,18.38V12.61C5.5,11.61 6.16,10.76 7.5,10.05C8.88,9.35 10.38,9 12,9M12,11A2,2 0 0,0 10,13A2,2 0 0,0 12,15A2,2 0 0,0 14,13A2,2 0 0,0 12,11Z" />
				</svg> -->
				<i class="fas fa-user-tie"></i>
				<p><?php echo $c_quejas['total']; ?> Registradas</p>
			</div>
		</a>

		<a href="orientaciones.php" class="tile">
			<div class="tile-tittle">Orientaciones</div>
			<div class="tile-icon">
				<span class="material-symbols-rounded" style="font-size:95px;">psychology_alt</span>
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>account-question</title>
					<path d="M13,8A4,4 0 0,1 9,12A4,4 0 0,1 5,8A4,4 0 0,1 9,4A4,4 0 0,1 13,8M17,18V20H1V18C1,15.79 4.58,14 9,14C13.42,14 17,15.79 17,18M20.5,14.5V16H19V14.5H20.5M18.5,9.5H17V9A3,3 0 0,1 20,6A3,3 0 0,1 23,9C23,9.97 22.5,10.88 21.71,11.41L21.41,11.6C20.84,12 20.5,12.61 20.5,13.3V13.5H19V13.3C19,12.11 19.6,11 20.59,10.35L20.88,10.16C21.27,9.9 21.5,9.47 21.5,9A1.5,1.5 0 0,0 20,7.5A1.5,1.5 0 0,0 18.5,9V9.5Z" />
				</svg> -->
				<i class="fas fa-user-tie"></i>
				<p><?php echo $c_orientacion['total']; ?> Registradas</p>
			</div>
		</a>

		<a href="canalizaciones.php" class="tile">
			<div class="tile-tittle">Canalizaciones</div>
			<div class="tile-icon">
				<span class="material-symbols-rounded" style="font-size:95px;">
					transfer_within_a_station
				</span>
				<!-- <svg style="width:100px;height:100px" fill="#455a64" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
					<title>account-switch-outline</title>
					<path d="M16 9C22 9 22 13 22 13V15H16V13C16 13 16 11.31 14.85 9.8C14.68 9.57 14.47 9.35 14.25 9.14C14.77 9.06 15.34 9 16 9M8 11C11.5 11 11.94 12.56 12 13H4C4.06 12.56 4.5 11 8 11M8 9C2 9 2 13 2 13V15H14V13C14 13 14 9 8 9M9 17V19H15V17L18 20L15 23V21H9V23L6 20L9 17M8 3C8.55 3 9 3.45 9 4S8.55 5 8 5 7 4.55 7 4 7.45 3 8 3M8 1C6.34 1 5 2.34 5 4S6.34 7 8 7 11 5.66 11 4 9.66 1 8 1M16 1C14.34 1 13 2.34 13 4S14.34 7 16 7 19 5.66 19 4 17.66 1 16 1Z" />
				</svg> -->
				<i class="fas fa-user-tie"></i>
				<p><?php echo $c_canalizacion['total']; ?> Registradas</p>
			</div>
		</a>

	</div>
</div>

<?php include_once('layouts/footer.php'); ?>
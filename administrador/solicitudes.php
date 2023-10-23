<?php
error_reporting(E_ALL ^ E_NOTICE);
$page_title = 'Áreas';
require_once('includes/load.php');
$user = current_user();
$id_usuario = $user['id_user'];

$busca_area = area_usuario($id_usuario);
$otro = $busca_area['nivel_grupo'];
$nivel = $user['user_level'];


$c_user = count_by_id('users', 'id_user');
$c_trabajadores = count_by_id('detalles_usuario', 'id_det_usuario');
$c_areas = count_by_id('area', 'id_area');
$c_cargos = count_by_id('cargos', 'id_cargos');
?>

<?php include_once('layouts/header.php'); ?>

<h1 style="color:#3A3D44; margin-left: 10px;">Áreas</h1>

<div class="row">
	<div class="col-md-12">
		<?php echo display_msg($msg); ?>
	</div>
</div>

<div class="container-fluid">
	<div class="full-box tile-container">
		<div class="organigrama">
			<ul>
				<li>
					<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 21)) : echo "solicitudes_presidencia.php";
								endif ?>" class="tileA">
						<div class="tileA-tittle">Presidencia</div>
						<div class="tileA-icon">
							<span class="material-symbols-rounded" style="font-size: 65px;">
								person
							</span>
						</div>
					</a>
					<ul>
						<li>
							<a href="<?php if (($otro <= 3) || ($otro == 7) || ($otro == 21)) : echo "solicitudes_consejo.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Consejo</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										groups_2
									</span>
								</div>
							</a>
						</li>

						<li>
							<a href="<?php if (($otro == 7) || ($otro <= 2) || ($otro == 3)) : echo "solicitudes_ejecutiva.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Secretaría Ejecutiva</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										next_week
									</span>
								</div>
							</a>
						</li>

						<li>
							<a href="<?php if (($otro == 7) || ($otro <= 2) || ($otro == 21) || ($otro == 51)) : echo "solicitudes_tecnica.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Secretaría Técnica</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										account_box
									</span>
								</div>
							</a>
							<ul>
								<li>
									<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 12)) : echo "solicitudes_desaparecidos.php";
												endif ?>" class="tileA">
										<div class="tileA-tittle">Desaparecidos</div>
										<div class="tileA-icon">
											<span class="material-symbols-rounded" style="font-size: 65px;">
												person_search
											</span>
										</div>
									</a>
								</li>

								<li>
									<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 10)) : echo "solicitudes_transparencia.php";
												endif ?>" class="tileA">
										<div class="tileA-tittle">Transparencia</div>
										<div class="tileA-icon">
											<span class="material-symbols-rounded" style="font-size: 65px;">
												travel_explore
											</span>
										</div>
									</a>
								</li>

								<li>
									<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 11)) : echo "solicitudes_archivo.php";
												endif ?>" class="tileA">
										<div class="tileA-tittle">Archivo</div>
										<div class="tileA-icon">
											<span class="material-symbols-rounded" style="font-size: 65px;">
												inventory_2
											</span>
										</div>
									</a>
								</li>

								<li>
									<a href="<?php if (($otro <= 2) || ($otro == 4) || ($otro == 7) || ($otro == 9)) : echo "solicitudes_servicios_tecnicos.php";
												endif ?>" class="tileA">
										<div class="tileA-icon">
											<div class="tileA-tittle">Servicios Técnicos</div>
											<span class="material-symbols-rounded" style="font-size: 65px;">
												procedure
											</span>
										</div>
									</a>
								</li>
							</ul>
						</li>

						<li>
							<a href="<?php if (($otro <= 2) || ($otro == 6) || ($otro == 7)) : echo "solicitudes_centro_estudios.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Centro Estudios</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										local_library
									</span>
								</div>
							</a>
						</li>

						<li>

							<a href="<?php if (($otro == 5) || ($otro <= 2) || ($otro == 7) || ($otro == 19) || ($otro == 20) || ($otro == 21) || ($otro == 50)) :							echo "solicitudes_quejas.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Quejas y Seguimiento</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										book
									</span>
								</div>
							</a>
						</li>

						<li>

							<a href="<?php if (($otro <= 2) || ($otro == 17)) : echo "solicitudes_agendas.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle" style="font-size: 11px;">Mecanismos y Agendas</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										calendar_view_month
									</span>
								</div>
							</a>
						</li>

						<!--
						<li>
							<a href="<?php if (($otro <= 2)) : echo "solicitudes_gestion.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Unidad de Gestión</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										rebase_edit
									</span>
								</div>
							</a>
						</li>
						-->
						<li>
							<a href="<?php if (($otro <= 2) || ($otro == 7) || ($otro == 15)) : echo "solicitudes_comunicacion_social.php";
										endif ?>" class="tileA">
								<div class="tileA-tittle">Comunicación Social</div>
								<div class="tileA-icon">
									<span class="material-symbols-rounded" style="font-size: 65px;">
										contact_mail
									</span>
								</div>
							</a>
						</li>

						<li>
							<a href="<?php if (($otro <= 2) || ($otro == 4) || ($otro == 7) || ($otro == 9)) : echo "solicitudes_sistemas.php";
										endif ?>" class="tileA">
								<div class="tileA-icon">
									<div class="tileA-tittle">Sistemas</div>
									<span class="material-symbols-rounded" style="font-size: 65px;">
										computer
									</span>
								</div>
							</a>
						</li>

					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>
<br>
<?php include_once('layouts/footer.php'); ?>
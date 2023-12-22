<link rel="icon" type="image/png" sizes="16x16" href="medios/favicon-16x16.png">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">
<?php
ob_start();
require_once('includes/load.php');
if ($session->isUserLoggedIn(true)) {
	redirect('home.php', false);
}
?>
<link href="MyFont1.otf" rel="stylesheet">
<style>
	.titulo {
		font-size: 72px;
		background: -webkit-linear-gradient(left, #081859, #1a95cb);
		background: linear-gradient(to right, #081859, #1a95cb);
		-webkit-background-clip: text;
		-webkit-text-fill-color: transparent;
	}
</style>
<div class="body2">
	<div class="login-page" style="margin-top: 14%;">
		<div style="height:50px; width:300px; margin:0px auto; ">
			<br />
			<div class="row">
				<div class="col-md-3">
					<div class="logo pull-left"><img border="0" src="medios/Imagen4.png" width="41px" title="CEDH" alt="" style="margin-top: -1.3%; margin-left: -2%;" />
						<div>
							<h1 class="titulo" style="margin-top: -16.3%; margin-left: 13%; font-size:50px; font-weight:bold;">SOSCDH
								<h2 style="font-family: My Font; font-size: 69px; color:#1573ac; margin-top:-73.6px; margin-left: 265px;">M</h2>
							</h1>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
				<h5 class="text-center" style="color:black; width: 100%; margin-top:-25px; color: #505248; font-size:14px;">Sistema de Organizaciones de la Sociedad Civil de Derechos Humanos de Michoacán</h5>
				</div>
			</div>
		</div>
		<div class=" text-center">
			<h1 style="margin-top:30px; font-weight: bold; color:black; padding-top: 20px;">Iniciar Sesión</h1>
		</div>
		<?php echo display_msg($msg); ?>
		<form method="post" action="auth.php" class="clearfix" style="margin-top: 15px;">

			<div class="form-group">
				<label for="username" class="control-label">Usuario</label>
				<input type="name" style="background:#E3E3E3;" class="form-control" name="username" placeholder="Usuario">
			</div>
			<div class="form-group">
				<label for="Password" class="control-label">Contraseña</label>
				<input type="password" style="background:#E3E3E3; " name="password" class="form-control" placeholder="Contraseña">
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-info  pull-right" style="background: #091d5d; border-color: #091d5d;">Entrar</button>
			</div>
		</form>
	</div>
</div>
<?php include_once('layouts/header.php'); ?>
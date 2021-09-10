<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="utf-8">
	<title>Cambiar mi Contraseña</title>
	<?php include "includes/scripts.php"; ?>
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
	<script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/jquery.min.js" type="text/javascript"></script>
	<script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/bootstrap.min.js" type="text/javascript"></script>

</head>

<body>
	<section id="container_login">
		<?PHP
		if (isset($_GET["idus"])) {
			$idus = $_GET['idus'];
		}
		if (isset($_GET["info"])) {
			$estado = $_GET["info"];
			$success = "display:none";
			$error = "display:none";
			$claseE = "";
			$claseS = "";
			if ($estado == "success") {
				$success = "display: block; width: auto;";
				$mensaje = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Se ha Enviado el Correo!</strong>";
				$claseS = "alert alert-success alert-dismissable";
			}
			if ($estado == "error") {
				$error = "display: block; width: auto;";
				$mensaje = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡El Correo No Existe!</strong>";
				$claseE = "alert alert-danger alert-dismissable";
			}
			if ($estado == "warning") {
				$warning = "display: block; width: auto;";
				$mensaje = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡El Correo No Existe!</strong>";
				$claseW = "alert alert-warning alert-dismissable";
			}
		} else {
			$success = "display: none";
			$error = "display: none";
			$warning = "display: none;";
			$claseE = "";
			$claseS = "";
			$claseW = "";
		}
		?>
		<div style="width: -webkit-fill-available; width:inherit;">
			<div style="text-align: center; margin-top:3%;">
				<img src="https://scontent.fgye1-1.fna.fbcdn.net/v/t1.0-9/118653579_3076909155753931_3802492417072025602_n.jpg?_nc_cat=104&ccb=3&_nc_sid=09cbfe&_nc_eui2=AeGSlwiT3Adm3sz3RxlRPMhSZE3B9kq67p9kTcH2SrrunyEqlM9zpH-Bh85CLzhvLR65dx97rmTkJw9MDSt8NxMU&_nc_ohc=VwvzDPiAD08AX8R-vb9&_nc_ht=scontent.fgye1-1.fna&oh=62248bfd84fff62e8fd27dfbc6113751&oe=606332CD" width="15%" alt="index">
				<h1 class="sombra" style="color: #013C80" style="font-weight: bold;">  </h1>

			</div>

			<div class="container" style="height: 40%; ">
				<div id="loginbox" style="margin-top:10px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
					<div class="panel panel-info" style="background: transparent; border:transparent">
						<div class="panel-heading" style="color:white; background:#44A0D3; ">
							<div class="panel-title sombra" style="font-weight: bold;">EMBUTIDOS 'JOSSY'</div>
						</div>

						<form style="align-items: center; width: auto; grid-gap: 10px;" id="loginform" role="form" action="guarda_pass.php" method="POST" autocomplete="off">

							<input type="hidden" id="idus" name="idus" value="<?php echo $idus; ?>" />

							<p>
								<label for="password" style="margin-left: 10%;">Nueva Contraseña</label>
							</p>
							<p>
								<input type="password" name="password" placeholder="Contraseña" required>
							</p>
							<p>
								<label for="con_password" style="margin-left: 10%;">Confirmar Contraseña</label>
							</p>
							<p>
								<input type="password" name="con_password" placeholder="Confirmar Contraseña" required>
							</p>
							<p class="full-width" style="text-align: center;">
								<button class="btn btntam" style="background-color: #479ED4; color: white;" type="submit">Modificar</a>
							</p>
						</form>
					</div>
				</div>
			</div>
		</div>

	</section>
</body>

</html>
<?php
session_start();
if ($_SESSION['rol'] != 1) {
	header("location: login.php");
}

include "conexion.php";
if (!empty($_POST)) {

	$alert = '';
	if (empty($_POST['tipo_corte'])) {
		$alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
	} else {



		$tip_cortes      =  ucfirst($_POST['tipo_corte']);
		$codi_tipo_mat = $_POST['rol'];



		$verificar = mysqli_query($conexion, "SELECT * FROM tipo_cortes WHERE cortes = '$tip_cortes' AND  tipo_mat_despo = '$codi_tipo_mat'");

		$result = mysqli_fetch_array($verificar);

		if ($result > 0) {
			$alert = '<p class="msg_error">El Tipo de Corte ya Existe</p>';
		} else {
			$insert = mysqli_query($conexion, "INSERT INTO tipo_cortes(tipo_mat_despo,cortes) 
		VALUES('$codi_tipo_mat','$tip_cortes')");

			if ($insert) {
				$alert = '<p class="msg_guardar">El Tipo de Corte Registrado Correctamente.</p>';
			} else {
				$alert = '<p class="msg_error">Error Al Registrar Tipo de Corte.</p>';
			}
		}
	}
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">

	<?php include "includes/scripts.php"; ?>
	<title>Sistema de Producción</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">

		<div class="form_register">
			<h1>Registrar Nuevo Tipo de Cortes</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form class="form_register5" action="" method="post">
				<h1>Datos</h1>
				<label for="rol">Tipo de Cortes:</label>

				<?php
				$query_rol = mysqli_query($conexion, "SELECT * FROM tipo_mat");

				$result_rol = mysqli_num_rows($query_rol);

				?>
				<select name="rol" id="rol">
					<?php
					?>
					<option value="">Seleccionar Tipo Materia Prima</option>
					<?php
					if ($result_rol > 0) {
						while ($rol = mysqli_fetch_array($query_rol)) {
					?>
							<option value="<?php echo $rol["id_tip_mat"]; ?>"><?php echo $rol["nom_tip_mat"] ?></option>
					<?php
						}
					}

					?>

				</select>
				<br>
				<input type="text" name="tipo_corte" id="tipo_corte" placeholder="Ingrese Tipo" maxlength="30" required="" class="letras">
				<br>


				<input type="submit" value="Crear Tipo de Corte" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
			</form>
		</div>
	</section>

</body>

</html>
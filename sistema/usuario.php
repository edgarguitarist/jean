<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
	header("location: login.php");
}

include "conexion.php";
if (!empty($_POST)) {

	$alert = '';
	if (empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['celular']) || empty($_POST['direccion']) || empty($_POST['correo']) || empty($_POST['rol']) || empty($_POST['usuario']) || empty($_POST['clave'])) {
		$alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
	} else {

		$cedula_usu      = ucwords($_POST['cedula']);
		$nombre_usu      = ucwords($_POST['nombre']);
		$apellido_usu    = ucwords($_POST['apellido']);
		$celular_usu     = $_POST['celular'];
		$telefono_usu    = $_POST['telefono'];
		$direccion_usu   = ucwords($_POST['direccion']);
		$correo_usu      = $_POST['correo'];
		$codigo_tipo_usu = $_POST['rol'];
		$usuario_usu     = $_POST['usuario'];
		$clave_usu       = $_POST['clave'];

		$verificar = mysqli_query($conexion, "SELECT * FROM usuario WHERE ced_usu = '$cedula_usu' OR  usu_usu = '$usuario_usu'");

		$result = mysqli_fetch_array($verificar);

		if ($result > 0) {
			$alert = '<p class="msg_error">El Usuario O Cedula ya Existe</p>';
		} else {
			$insert = mysqli_query($conexion, "INSERT INTO usuario(ced_usu,nom_usu,ape_usu,cel_usu,tel_usu,dir_usu,cor_usu,cod_tip_usu,usu_usu,cla_usu) 
			VALUES('$cedula_usu','$nombre_usu','$apellido_usu','$celular_usu','$telefono_usu','$direccion_usu','$correo_usu','$codigo_tipo_usu','$usuario_usu','$clave_usu')");
			$error = mysqli_errno($conexion);

			if ($insert) {
				$alert = '<p class="msg_guardar">Usuario Registrado Correctamente.</p>';
			} else {
				$alert = '<p class="msg_error">Error Al Registrar Usuario.'.$error.'</p>';
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
			<h1>Registro Usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form action="" name="formu" method="post" autocomplete="nope">
				<h1 class="full-width">Datos Personales</h1>
				<p>
					<label for="">Cedula de Usuario:</label>
					<input autocomplete="off" type="text" name="cedula" id="cedula" placeholder="Ingrese Cedula" maxlength="10" class="solo-numero intext" onkeyup="validar1()" onblur="validar1()" autofocus required>
					<label id="salida" style="font-size:1em; font-weight: bold;"></label>
				</p>

				<p>
					<label for="">Nombre de Usuario:</label>
					<input autocomplete="off" type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre Completo" maxlength="20" class="letras intext" required>
				</p>
				<p>
					<label for="">Apellido de Usuario:</label>
					<input autocomplete="off" type="text" name="apellido" id="apellido" placeholder=" Ingrese Apellido Completo" maxlength="20" class="letras" required>
				</p>
				<p>
					<label for="">Celular de Usuario:</label>
					<input autocomplete="off" type="text" name="celular" id="celular" placeholder=" Ingrese celular" maxlength="10" class="solo-numero" required>
				</p>

				<p class="full-width">
					<label for="">Dirección de Usuario:</label>
					<input autocomplete="off" type="text" name="direccion" id="direccion" placeholder=" Ingrese direccion Del Usuario" maxlength="60" required>
				</p>
				<p>
					<label for="">Telefono de Usuario:</label>
					<input autocomplete="off" type="text" name="telefono" id="telefono" placeholder=" Ingrese Telefono" maxlength="10" class="solo-numero" required>
				<p>
					<label for="">Correo de Usuario:</label>
					<input autocomplete="off" type="email" name="correo" id="correo" placeholder="Ingrese Correo electronico" maxlength="60" required>
				</p>

				<h1 class="full-width">Datos de Usuario</h1>
				<p>
					<label for="">Ingrese ID de Usuario:</label>
					<input autocomplete="off" type="text" name="usuario" id="usuario" placeholder="Ingrese ID de Usuario" maxlength="15" required>
				</p>
				<p>
					<label for="rol">Tipo Usuario</label>
					<?php
					$query_rol = mysqli_query($conexion, "SELECT * FROM tipo_usuario");

					$result_rol = mysqli_num_rows($query_rol);

					?>
					<select name="rol" id="rol" required>
						<?php
						?>
						<option value="">Seleccionar Rol</option>
						<?php
						if ($result_rol > 0) {
							while ($rol = mysqli_fetch_array($query_rol)) {
						?>
								<option value="<?php echo $rol["cod_tip_usu"]; ?>"><?php echo $rol["rol_tip_usu"] ?></option>
						<?php
							}
						}

						?>

					</select>
				</p>
				<p>
					<label for="">Ingrese Clave:</label>
					<input autocomplete="off" style="width: 93%; display:inline-flex;" type="password" name="clave" id="clave" placeholder="Ingrese Clave" maxlength="15" required>
					<span onclick="mostrarPassword()" class="fa fa-eye-slash icon gg1"></span>
				</p>
				<p>
					<label for="">Repita la Clave:</label>
					<input autocomplete="off" style="width: 93%; display:inline-flex;" type="password" name="reclave" id="reclave" onkeyup="contras()" onblur="contras()" placeholder="Repita la Clave" maxlength="15" required>
					<span onclick="mostrarPassword2()" class="fa fa-eye-slash icon gg2"></span>
					<label id="msg" style="font-size:1em; font-weight: bold;"></label>
				</p>
				<p class="full-width">
					<input autocomplete="off" type="submit" id="submito" name="submito" value="Crear Usuario" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
				</p>

			</form>
		</div>
	</section>

</body>

</html>
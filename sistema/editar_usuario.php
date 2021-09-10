<?php
session_start();
if ($_SESSION['rol'] != 1) {
	header("location: login.php");
}
include "conexion.php";
if (!empty($_POST)) {

	$alert = '';
	if (empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['celular']) || empty($_POST['direccion']) || empty($_POST['correo']) || empty($_POST['rol']) || empty($_POST['usuario'])) {
		$alert = '<p class="msg_error">Los Campos Asingados Son Obligatorio</p>';
	} else {


		$id_usuar        = $_POST['id_usuar'];
		$cedula_usu      = $_POST['cedula'];
		$nombre_usu      = ucwords($_POST['nombre']);
		$apellido_usu    = ucwords($_POST['apellido']);
		$celular_usu     = $_POST['celular'];
		$telefono_usu    = $_POST['telefono'];
		$direccion_usu   = ucwords($_POST['direccion']);
		$correo_usu      = $_POST['correo'];
		$codigo_tipo_usu = $_POST['rol'];
		$usuario_usu     = $_POST['usuario'];
		$clave_usu       = $_POST['clave'];

		$verificar = mysqli_query($conexion, "SELECT * FROM usuario WHERE (ced_usu = '$cedula_usu' AND  id_usu != '$id_usuar'
												                  OR usu_usu = '$usuario_usu'  AND id_usu != '$id_usuar')");
		$result = mysqli_fetch_array($verificar);

		if ($result > 0) {
			$alert = '<p class="msg_error">El Usuario O Cedula ya Existe</p>';
		} else {

			if (empty($_POST['clave'])) {
				$sql_update = mysqli_query($conexion, "UPDATE usuario
             		                                   SET nom_usu ='$nombre_usu', ape_usu ='$apellido_usu', cel_usu ='$celular_usu', tel_usu ='$telefono_usu', dir_usu ='$direccion_usu', cor_usu ='$correo_usu', cod_tip_usu ='$codigo_tipo_usu', usu_usu ='$usuario_usu' 
             		                                   where ced_usu = $cedula_usu");
			} else {
				$sql_update = mysqli_query($conexion, "UPDATE usuario
             		                                   SET nom_usu ='$nombre_usu', ape_usu ='$apellido_usu', cel_usu ='$celular_usu', tel_usu ='$telefono_usu', dir_usu ='$direccion_usu', cor_usu ='$correo_usu', cod_tip_usu ='$codigo_tipo_usu', usu_usu ='$usuario_usu', cla_usu ='$clave_usu' 
             		                                   where ced_usu = $cedula_usu");
			}


			if ($sql_update) {
				$alert = '<p class="msg_guardar">Usuario Actualizado Correctamente.</p>';
			} else {
				$alert = '<p class="msg_error">Error Al Actualizado Usuario.</p>';
			}
		}
	}
}



//mostrar datos
if (empty($_GET['id'])) {
	header('Location: lista-usuario.php');
}
$iduser = $_GET['id'];
$sql = mysqli_query($conexion, "SELECT u.id_usu, u.ced_usu,u.nom_usu,u.ape_usu,u.cel_usu,u.tel_usu,u.dir_usu,u.cor_usu,u.usu_usu, (u.cod_tip_usu) AS cod_tip_usu, (r.rol_tip_usu) AS rol_tip_usu
		FROM usuario u
		INNER JOIN tipo_usuario r 
		ON u.cod_tip_usu = r.cod_tip_usu
		WHERE id_usu= $iduser ");


$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
	header(('Location: lista-usuario.php'));
} else {
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		$id_usu        = $data['id_usu'];
		$cedu_usu      = $data['ced_usu'];
		$nomb_usu      = $data['nom_usu'];
		$apel_usu      = $data['ape_usu'];
		$celu_usu      = $data['cel_usu'];
		$tele_usu      = $data['tel_usu'];
		$dire_usu      = $data['dir_usu'];
		$corr_usu      = $data['cor_usu'];
		$codi_tipo_usu = $data['cod_tip_usu'];
		$rol_usua      = $data['rol_tip_usu'];
		$usua_usu      = $data['usu_usu'];

		if ($rol_usua == 1) {
			$option = '<option value="' . $codi_tipo_usu . '" select>' . $rol_usua . '</option>';
		} else if ($codi_tipo_usu == 2) {
			$option = '<option value="' . $codi_tipo_usu . '" select>' . $rol_usua . '</option>';
		} else if ($codi_tipo_usu == 3) {
			$option = '<option value="' . $codi_tipo_usu . '" select>' . $rol_usua . '</option>';
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">

	<?php include "includes/scripts.php"; ?>
	<title>Sistema de Producción</title>
</head>

<script>
$(document).ready(function () {
  $(".validar").change(function () {
    col = this.style.color;
	
	if(col=='red'){
		$('input[type="submit"]').attr('disabled','disabled');
	}else{
		$('input[type="submit"]').attr('disabled',false);
	}

  });
});
</script>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">

		<div class="form_register">
			<h1>Actualizar Usuario</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form class="form_register5" action="" method="post">
				<h1 class="full-width">Datos De Usuario</h1>
				<input type="hidden" name="id_usuar" value="<?php echo $id_usu; ?>">
				<p class="full-width">
					<label for="">Cedula De Usuario:</label>
					<input type="text" name="cedula" id="cedula" placeholder="Ingrese Cedula" maxlength="10" class="solo-numero" onblur="validar2()" onkeyup="validar2()" value="<?php echo $cedu_usu; ?>" required>
					<label id="salida"></label>
				</p>				
				<p class="full-width">
					<label for="">Nombre De Usuario:</label>
					<input type="text" name="nombre" id="nombre" placeholder="Ingres	e Nombre Completo" maxlength="50" class="letras" value="<?php echo $nomb_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Apellido De Usuario:</label>
					<input type="text" name="apellido" id="apellido" placeholder=" Ingrese Apellido Completo" maxlength="50" class="letras" value="<?php echo $apel_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Celular De Usuario:</label>
					<input type="text" name="celular" id="celular" placeholder=" Ingrese Acelular" maxlength="10" class="solo-numero" value="<?php echo $celu_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Telefono De Usuario:</label>
					<input type="text" name="telefono" id="telefono" placeholder=" Ingrese Telefono" maxlength="10"  class="solo-numero" value="<?php echo $tele_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Direcion De Usuario:</label>
					<input type="text" name="direccion" id="direccion" placeholder=" Ingrese direccion De Usuario" maxlength="60" value="<?php echo $dire_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Correo De Usuario:</label>
					<input type="email" name="correo" id="correo" placeholder="Ingrese Correo electronico" maxlength="60" value="<?php echo $corr_usu; ?>" required>
				</p>

				<p class="full-width">
					<label for="rol">Tipo Usuario</label>
					<?php
					include "conexion.php";
					$query_rol = mysqli_query($conexion, "SELECT * FROM tipo_usuario");

					$result_rol = mysqli_num_rows($query_rol);

					?>
					<select name="rol" id="rol" class="notItemOne"  required>
						<?php
						echo $option;
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
				<p class="full-width">
					<label for="">Ingrese ID De Usuario:</label>
					<input type="text" name="usuario" id="usuario" placeholder="Ingrese ID de Usuario" maxlength="15" class="letras" value="<?php echo $usua_usu; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Ingrese Clave:</label>
					<input type="password" name="clave" id="clave" placeholder="Ingrese Clave" maxlength="15" required>
				</p>
				<p class="full-width">
					<input type="submit" value="Actualizar Usuario" class="btn_guardar_usuario" style="width: auto; padding: 10px;" required>
				</p>
			</form>
		</div>
	</section>

</body>

</html>
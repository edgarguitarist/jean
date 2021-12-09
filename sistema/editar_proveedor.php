<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
	header("location: login.php");
}
include "conexion.php";
if (!empty($_POST)) {

	$alert = '';
	if (empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['celular']) || empty($_POST['direccion']) || empty($_POST['correo']) || empty($_POST['nombre_empresa']) || empty($_POST['ruc_empresa'])) {
		$alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
	} else {


		$id_prove           = $_POST['id_prove'];
		$cedula_provee      = $_POST['cedula'];
		$nombre_provee      = ucwords($_POST['nombre']);
		$apellido_provee    = ucwords($_POST['apellido']);
		$celular_provee     = $_POST['celular'];
		$correo_provee      = ucwords($_POST['correo']);
		$direccion_provee   = ucwords($_POST['direccion']);
		$ruc_empr           = $_POST['ruc_empresa'];
		$razon_empr         = ucwords($_POST['razon_empresa']);
		$nombre_empr        = ucwords($_POST['nombre_empresa']);
		$direccion_empr     = ucwords($_POST['direccion_empresa']);
		$correo_empr        = $_POST['correo_empresa'];
		$telefono_empr      = $_POST['telefono_empresa'];
		$tipo_provee        = $_POST['tipo_proveedor'];

		$verificar = mysqli_query($conexion, "SELECT * FROM proveedor WHERE (ced_pro = '$cedula_provee' AND  id_prov != '$id_prove' )
																OR (ruc_emp = '$ruc_empr'  AND id_prov != '$id_prove')");
		$result = mysqli_fetch_array($verificar);

		if ($result > 0) {
			$alert = '<p class="msg_error">La Cédula O Ruc ya Existe</p>';
		} else {


			$sql_update = mysqli_query($conexion, "UPDATE proveedor
             		                                   SET 
             		                                    nom_pro ='$nombre_provee', 
             		                                    ape_pro ='$apellido_provee',
             		                                    cel_pro ='$celular_provee', 
             		                                    cor_pro ='$correo_provee', 
             		                                    dir_pro ='$direccion_provee',
             		                                    ruc_emp ='$ruc_empr', 
             		                                    raz_emp ='$razon_empr',
             		                                    nom_emp ='$nombre_empr' ,
             		                                    dir_emp ='$direccion_empr',
             		                                    cor_emp ='$correo_empr' ,
             		                                    tel_emp ='$telefono_empr' ,
             		                                id_tip_emp ='$tipo_provee' 
             		                               where ced_pro = $cedula_provee");




			if ($sql_update) {
				$alert = '<p class="msg_guardar">Proveedor Actualizado Correctamente.</p>';
			} else {
				$alert = '<p class="msg_error">Error Al Actualizar el Proveedor.</p>';
			}
		}
	}
}



//mostrar datos
if (empty($_GET['id'])) {
	header('Location: lista-proveedor.php');
}
$idprove = $_GET['id'];
$sql = mysqli_query($conexion, "SELECT u.id_prov, u.ced_pro, u.nom_pro, u.ape_pro,  u.cel_pro, u.cor_pro, u.dir_pro, u.ruc_emp, u.raz_emp, u.nom_emp, u.dir_emp, u.cor_emp, u.tel_emp, (u.id_tip_emp) AS id_tip_emp, (r.nom_tip_emp) AS nom_tip_emp
		FROM proveedor u
		INNER JOIN tipo_empresa r 
		ON u.id_tip_emp = r.id_tip_emp
		WHERE id_prov = $idprove ");


$result_sql = mysqli_num_rows($sql);
if ($result_sql == 0) {
	header(('Location: lista-proveedor.php'));
} else {
	$option = '';
	while ($data = mysqli_fetch_array($sql)) {
		$id_prov           = $data['id_prov'];
		$cedula_prove      = $data['ced_pro'];
		$nombre_prove      = $data['nom_pro'];
		$apellido_prove    = $data['ape_pro'];
		$celular_prove     = $data['cel_pro'];
		$correo_prove      = $data['cor_pro'];
		$direccion_prove   = $data['dir_pro'];
		$ruc_empe          = $data['ruc_emp'];
		$razon_emp         = $data['raz_emp'];
		$nombre_emp        = $data['nom_emp'];
		$direccion_emp     = $data['dir_emp'];
		$correo_emp        = $data['cor_emp'];
		$telefono_emp      = $data['tel_emp'];
		$tipo_prove        = $data['nom_tip_emp'];
		$codi_tipo_prove   = $data['id_tip_emp'];


		if ($tipo_prove == 1) {
			$option = '<option value="' . $codi_tipo_prove . '" select>' . $tipo_prove . '</option>';
		} else if ($codi_tipo_prove == 2) {
			$option = '<option value="' . $codi_tipo_prove . '" select>' . $tipo_prove . '</option>';
		} else if ($codi_tipo_prove == 3) {
			$option = '<option value="' . $codi_tipo_prove . '" select>' . $tipo_prove . '</option>';
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
			<h1>Actualizar Proveedor</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>


			<form class="form_register5" action="" method="post">
				<h1 class="full-width">Datos de Contacto</h1>
				<input type="hidden" name="id_prove" value="<?php echo $id_prov ?>">
				<p class="full-width">
					<label for="">Cédula de Contacto:</label>
					<input type="text" name="cedula" id="cedula" placeholder="Ingrese la Cédula" maxlength="10" class="solo-numero" onblur="validar2()" onkeyup="validar2()" value="<?php echo $cedula_prove; ?>" required>
					<label id="salida"></label>
				</p>
				<p class="full-width">
					<label for="">Nombre de Contacto:</label>
					<input type="text" name="nombre" id="nombre" placeholder="Ingrese el Nombre de Contacto" maxlength="30" class="letras" value="<?php echo $nombre_prove; ?>" required>
				<p class="full-width">
					<label for="">Apellido de Contacto:</label>
					<input type="text" name="apellido" id="apellido" placeholder=" Ingrese el Apellido" maxlength="30" class="letras" value="<?php echo $apellido_prove; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Celular de Contacto:</label>
					<input type="text" name="celular" id="celular" placeholder=" Ingrese el Celular" maxlength="10" class="solo-numero" value="<?php echo $celular_prove; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Correo de Contacto:</label>
					<input type="email" name="correo" id="correo" placeholder="Ingrese el Correo Electronico" maxlength="60" value="<?php echo $correo_prove; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Dirección de Contacto:</label>
					<input type="text" name="direccion" id="direccion" placeholder=" Ingrese la Dirección de Contacto" maxlength="120" value="<?php echo $direccion_prove; ?>" required>
				</p>

				<h1 class="full-width">Datos de La Empresa</h1>
				<p class="full-width">
					<label for="">Ruc Empresa:</label>
					<input type="text" name="ruc_empresa" id="ruc_empresa" placeholder=" Ingrese Ruc Empresa" maxlength="13" onblur="validar()" class="solo-numero" value="<?php echo $ruc_empe; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Razon Social:</label>
					<input type="text" name="razon_empresa" id="razon_empresa" placeholder=" Ingrese Razon Social" maxlength="60" value="<?php echo $razon_emp; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Nombre de Empresa:</label>
					<input type="text" name="nombre_empresa" id="nombre_empresa" placeholder=" Ingrese Nombre de la Empresa" maxlength="60" value="<?php echo $nombre_emp; ?>" required>
				</p>
				<p class="full-width">
					<label for="Direccion de Empresa">Direccion de Empresa:</label>
					<input type="text" name="direccion_empresa" id="direccion_empresa" placeholder=" Ingrese Direccion de Empresa" maxlength="120" value="<?php echo $direccion_emp; ?>" required>
				<p class="full-width">
					<label for="">Correo de Empresa:</label>
					<input type="email" name="correo_empresa" id="correo_empresa" placeholder=" Ingrese Correo de Empresa" maxlength="60" value="<?php echo $correo_emp; ?>" required>
				</p>
				<p class="full-width">
					<label for="">Telefono de Empresa:</label>
					<input type="text" name="telefono_empresa" id="telefono_empresa" placeholder=" Ingrese Telefono de Empresa" maxlength="10" class="solo-numero" value="<?php echo $telefono_emp; ?>" required>
				</p>
				<p class="full-width">
					<label for="Tipo de Proveedor">Tipo de Proveedor:</label>
					<?php
					include "conexion.php";
					$query_rol = mysqli_query($conexion, "SELECT * FROM tipo_empresa");

					$result_tipo = mysqli_num_rows($query_rol);

					?>
					<select name="tipo_proveedor" id="tipo_proveedor" class="notItemOne">
						<?php
						echo $option;
						if ($result_tipo > 0) {
							while ($tipo_proveedor = mysqli_fetch_array($query_rol)) {
						?>
								<option value="<?php echo $tipo_proveedor["id_tip_emp"]; ?>"><?php echo $tipo_proveedor["nom_tip_emp"] ?></option>
						<?php
							}
						}

						?>

					</select>
				</p>
				<p class="full-width">
					<input type="submit" value="Actualizar Proveedor" class="btn_guardar" style="width: auto; padding: 10px;">
				</p>
			</form>
		</div>
	</section>

</body>

</html>
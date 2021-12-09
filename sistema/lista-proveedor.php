<?php

session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
	header("location: login.php");
}

include "conexion.php";

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

	<section id="container">

		<h1>Lista de Proveedor</h1>
		<a href="proveedor.php" class="btn_nusuario">Crear Proveedor</a>

		<table border="0" class="table" id="example" aria-describedby="tabla">
			<thead>

				<tr>
					<!-- <th>ID</th> -->
					<th>Cedula</th>
					<th>Apellido</th>
					<th>Nombre</th>
					<th>Celular</th>
					<th>Correo</th>
					<th>Direccion</th>
					<th>Ruc</th>
					<th>Razon Social</th>
					<th>Nombre Empresa</th>
					<th>Direccion Empresa</th>
					<th>Correo Empresa</th>
					<th>Telefono Empresa</th>
					<th>Tipo Proveedor</th>
					<th>Fecha de Registro</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>

				<?php

				/////////////////////////////

				$query = mysqli_query($conexion, "SELECT  u.id_prov, u.ced_pro, u.ape_pro, u.nom_pro, u.cel_pro, u.cor_pro, u.dir_pro, u.ruc_emp, u.raz_emp, u.nom_emp, u.dir_emp, u.cor_emp, u.tel_emp, t.nom_tip_emp, u.fech_reg_pro FROM proveedor u INNER JOIN tipo_empresa t ON u.id_tip_emp = t.id_tip_emp  
	    		WHERE estado = 1 ORDER BY u.id_prov ASC");
				mysqli_close($conexion);

				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
						$formato_fe = 'Y-m-d H:i:s';
						$fecha = DateTime::createFromFormat($formato_fe, $data["fech_reg_pro"]);
				?>
						<tr>
							<!-- <td><?php //echo $data["id_prov"]; 
										?></td> -->
							<td><?php echo $data["ced_pro"]; ?></td>
							<td><?php echo $data["ape_pro"]; ?></td>
							<td><?php echo $data["nom_pro"]; ?></td>
							<td><?php echo $data["cel_pro"]; ?></td>
							<td><?php echo $data["cor_pro"]; ?></td>
							<td><?php echo $data["dir_pro"]; ?></td>
							<td><?php echo $data["ruc_emp"]; ?></td>
							<td><?php echo $data["raz_emp"]; ?></td>
							<td><?php echo $data["nom_emp"]; ?></td>
							<td><?php echo $data["dir_emp"]; ?></td>
							<td><?php echo $data["cor_emp"]; ?></td>
							<td><?php echo $data["tel_emp"]; ?></td>
							<td><?php echo $data["nom_tip_emp"]; ?></td>
							<td><?php echo $fecha->format('d-m-Y'); ?></td>
							<td>
								<a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["id_prov"]; ?>">Editar</a>
								|

								<?php if ($_SESSION['rol'] == 1) {
								?>
									<a class="link_delete" href="eliminar_proveedor.php?id=<?php echo $data["id_prov"]; ?>">Eliminar</a>
								<?php  } ?>
							</td>

						</tr>

				<?php
					}
				}
				?>
			</tbody>
		</table>

	</section>
	<?php include "includes/script.php"; ?>
	<!-- Necesario para la tabla -->

</body>

</html>
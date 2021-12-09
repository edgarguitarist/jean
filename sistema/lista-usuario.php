<?php

session_start();
if ($_SESSION['rol'] != 1) {
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


		<h1>Lista de Usuario</h1>
		<a href="usuario.php" class="btn_nusuario">Crear Usuario</a>

		<table border="0" class="table" id="example" aria-describedby="tabla">
			<!-- <a data-toggle="modal" href="#anio_delete" id="delete" class="btn btn-danger"><em class="icon-trash icon-large"></em></a> -->
			<?php //include('modal_delete.php');
			?>
			<thead>
				<tr>
					<!-- <th>ID</th> -->
					<th>Cedula</th>
					<th>Apellido</th>
					<th>Nombre</th>
					<th>Celular</th>
					<th>Telefono</th>
					<th>Direccion</th>
					<th>Correo</th>
					<th>Usuario</th>
					<th>Rol</th>
					<th>Fecha de Registro</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>

				<?php
				$query = mysqli_query($conexion, "SELECT u.id_usu, u.ced_usu, u.ape_usu, u.nom_usu, u.cel_usu, u.tel_usu, u.dir_usu, u.cor_usu, u.usu_usu, t.rol_tip_usu, u.fech_reg_usu FROM usuario u INNER JOIN tipo_usuario t ON u.cod_tip_usu = t.cod_tip_usu 
	    		WHERE estado = 1 ORDER BY u.ape_usu ASC");
				mysqli_close($conexion);

				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

				?>
						<tr>
							<!-- <td><?php //echo $data["id_usu"]; ?></td> -->
							<td><?php echo $data["ced_usu"]; ?></td>
							<td><?php echo $data["ape_usu"]; ?></td>
							<td><?php echo $data["nom_usu"]; ?></td>
							<td><?php echo $data["cel_usu"]; ?></td>
							<td><?php echo $data["tel_usu"]; ?></td>
							<td><?php echo $data["dir_usu"]; ?></td>
							<td><?php echo $data["cor_usu"]; ?></td>
							<td><?php echo $data["usu_usu"]; ?></td>
							<td><?php echo $data["rol_tip_usu"]; ?></td>
							<td><?php echo $data["fech_reg_usu"]; ?></td>
							<td>
								<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id_usu"]; ?>">Editar</a>
								|

								<?php if ($data["id_usu"] != 1) {
								?>
									<a class="link_delete" href="eliminar_usuario.php?id=<?php echo $data["id_usu"]; ?>">Eliminar</a>
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
	
	<?php include "includes/script.php"; ?> <!-- Necesario para la tabla -->
</body>

</html>
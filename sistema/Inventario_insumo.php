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

		<h1>Lista de Insumo</h1>
		<a href="insumo.php" class="btn_nusuario">Crear Insumo</a>
		<form action="buscar_proveedor.php" method="get" class="form_buscar">
			<input type="text" name="busqueda" id="busqueda" placeholder="Buscar">
			<input type="submit" value="Buscar" class="btn_buscar" style="width: auto; padding: 10px;">

		</form>
		<table>
			<tr>
				<th>ID</th>
				<th>Cedula</th>
				<th>Apellido</th>
				<th>Nombre</th>
				<th>Celular</th>
				<th>Telefono</th>
				<th>Direccion</th>
				<th>Acciones</th>
			</tr>
			<?php

			//////////pagina
			$sql_registe = mysqli_query($conexion, "SELECT COUNT(*) as total_registro FROM usuario WHERE estado = 1");
			$result_register = mysqli_fetch_array($sql_registe);
			$total_registro = $result_register['total_registro'];

			$por_pagina = 10;
			if (empty($_GET['pagina'])) {
				$pagina = 1;
			} else {
				$pagina = $_GET['pagina'];
			}
			$desde = ($pagina - 1) * $por_pagina;
			$total_paginas = ceil($total_registro / $por_pagina);

			/////////////////////////////


			$query = mysqli_query($conexion, "SELECT u.id_usu, u.ced_usu, u.ape_usu, u.nom_usu, u.cel_usu, u.tel_usu, u.dir_usu, u.cor_usu, u.usu_usu, t.rol_tip_usu, u.fech_reg_usu FROM usuario u INNER JOIN tipo_usuario t ON u.cod_tip_usu = t.cod_tip_usu 
	    		WHERE estado = 1 ORDER BY ape_usu DESC LIMIT $desde,$por_pagina");
			mysqli_close($conexion);
			$result = mysqli_num_rows($query);
			if ($result > 0) {
				while ($data = mysqli_fetch_array($query)) {

			?>
					<tr>
						<td><?php echo $data["id_usu"]; ?></td>
						<td><?php echo $data["ced_usu"]; ?></td>
						<td><?php echo $data["ape_usu"]; ?></td>
						<td><?php echo $data["nom_usu"]; ?></td>
						<td><?php echo $data["cel_usu"]; ?></td>
						<td><?php echo $data["tel_usu"]; ?></td>
						<td><?php echo $data["dir_usu"]; ?></td>

						<td>
							<a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id_usu"]; ?>">Actualizar</a>
							|

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
		</table>
		<div class="pagina">
			<ul>
				<?php
				if ($pagina != 1) {

				?>
					<li><a href="?pagina=<?php echo 1; ?>">|<< /a>
					</li>
					<li><a href="?pagina=<?php echo $pagina - 1;  ?>">
							<<< /a>
					</li>

				<?php
				}
				for ($i = 1; $i <= $total_paginas; $i++) {
					if ($i == $pagina) {
						echo '<li class="pageSelected">' . $i . '</li>';
					} else {
						echo '<li><a href="?pagina=' . $i . '">' . $i . '</a></li>';
					}
				}
				if ($pagina != $total_paginas) {


				?>
					<li><a href="?pagina=<?php echo $pagina + 1; ?>">>></a></li>
					<li><a href="?pagina=<?php echo $total_paginas; ?>">>|</a></li>
				<?php } ?>
			</ul>

		</div>
	</section>
</body>

</html>
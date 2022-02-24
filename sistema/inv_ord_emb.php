<?php
session_start();
if (!isset($_SESSION['rol'])) {
	header("location: login.php");
}
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>INVENTARIO DE ORDEN DE EMBUTIDO</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1>Inventario de Orden de Embutido</h1>
		</div>
		<div class="buscador">
			<a href="orden_produc_embu.php" class="btn_nusuario" style="width: auto; padding: 10px;">Orden de Embutido</a>
			<form action="inv_ord_emb.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php"; ?>
			</form>
		</div>
		<div id="inv_ord_des">
			<table class="table" id="example" aria-describedby="tabla">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Cantidad</th>
						<th>Fecha de Orden</th>
						<th>Hora de Orden</th>
					</tr>
				</thead>
				<tbody>
				<?php


				$query = mysqli_query($conexion, "SELECT * 
				FROM orden_embut 
				WHERE (nom_ord LIKE '%$busqueda%'
				OR cant_ord LIKE '%$busqueda%') 
				AND estado = 1 
				AND fecha_ord_emb BETWEEN '$fecha1' AND '$fecha2'
				ORDER BY fecha_ord_emb DESC");

				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
						$fecha = explode( ' ', $data["fecha_ord_emb"]);
				?>
						<tr>
							<td><?php echo $data["nom_ord"]; ?></td>
							<td style="text-align: end;"><?php echo $data["cant_ord"]; ?></td>
							<td><?php echo $fecha[0]; ?></td>
							<td><?php echo $fecha[1]; ?></td>

						</tr>

					<?php
					}
					?>
				</tbody>
			</table>
			<?php
				} else {
					if ($search) {
			?>
				</tbody>
				</table>
				<br>
				<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>
			<?php
					} else {
			?>
				</tbody>
				</table>
				<br>
				<h1>AUN NO HAY DATOS PARA MOSTRAR</h1>
		<?php
					}
				}
		?>
		</div>
	</section>
	<?php include "includes/script_ns.php"; ?>
</body>

</html>
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
	<title>INVENTARIO DE PRODUCTO A PROCESAR</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1>Inventario de Producto A Procesar</h1>
		</div>
		<div class="buscador">
			<a href="#" class="btn_nusuario" style="width: auto; padding: 10px;">Producto a Procesar</a>
			<form action="inv_pro_pro.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php"; ?>
			</form>
		</div>


		<div id="inv_ord_des">
		<table border="0" class="table" id="example" aria-describedby="tabla">

				<thead>
					<tr>
						<th>Codigo</th>
						<th>Peso</th>
						<th>Fecha de Salida</th>
					</tr>
				</thead>
				<tbody>
					<?php

					$query = mysqli_query($conexion, "SELECT * 
				FROM prod_procesar 
				WHERE (cod_pro LIKE '%$busqueda%' 
					OR pes_pro LIKE '%$busqueda%') 
					AND estado_prod_pro = 1 
					AND fecha_sali_proce BETWEEN '$fecha1' AND '$fecha2' 
					ORDER BY fecha_sali_proce DESC ");

					mysqli_close($conexion);
					$result = mysqli_num_rows($query);
					if ($result > 0) {
						while ($data = mysqli_fetch_array($query)) {

					?>
							<tr>
								<td ><?php echo $data["cod_pro"]; ?></td>
								<td style="text-align: end;"><?php echo $data["pes_pro"]; ?></td>
								<td style="text-align: center;"><?php echo $data["fecha_sali_proce"]; ?></td>
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
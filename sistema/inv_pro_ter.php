<?php
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
	header("location: login.php");
}
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>INVENTARIO DE PRODUCTO TERMINADO</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
	<div class="title_page">
		<h1>Inventario De Producto Terminado</h1></div>
		<div class="buscador">
			<a href="#" class="btn_nusuario" style="width: auto; padding: 10px;">Producto Terminado</a>
			<form action="inv_pro_ter.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php";?>
			</form>
		</div>
		
		<div id="inv_ord_des">
			<table class="threetable">
				<!--
				<tr>
					<th>Codigo</th>
					<th>Peso</th>
					<th>Estado</th>
					<th>Fecha De Salida</th>
				</tr> -->
				<tr>
					<th>Corte</th>
					<th>Peso</th>
					<th>Estado</th>
					<th>Fecha De Ingreso</th>
				</tr>

				<?php

				//////////pagina
				/*
				$sql_registe = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro 
				FROM prod_procesar 
				WHERE (cod_pro LIKE '%$busqueda%'
					OR pes_pro LIKE '%$busqueda%') 
					AND estado_prod_pro = 1
					AND fecha_sali_proce BETWEEN '$fecha1' AND '$fecha2'"); // Activo 1*/

					$sql_registe = mysqli_query($conexion, "SELECT COUNT(DISTINCT(cortes)) AS total_registro 
					FROM prod_terminado 
					WHERE (peso LIKE '%$busqueda%'
						OR cortes LIKE '%$busqueda%') 
						AND fecha_ingre BETWEEN '$fecha1' AND '$fecha2'
					GROUP BY cortes
					ORDER BY fecha_ingre DESC "); // Activo 1


				$result_register = mysqli_fetch_array($sql_registe);
				$total_registro = $result_register['total_registro'];

				$por_pagina = 20;
				if (empty($_GET['pagina'])) {
					$pagina = 1;
				} else {
					$pagina = $_GET['pagina'];
				}
				$desde = ($pagina - 1) * $por_pagina;
				$total_paginas = ceil($total_registro / $por_pagina);


				/////////////////////////////


				$query = mysqli_query($conexion, "SELECT cortes, SUM(peso) AS peso, fecha_ingre 
				FROM prod_terminado 
				WHERE (peso LIKE '%$busqueda%'
						OR cortes LIKE '%$busqueda%') 
						AND fecha_ingre BETWEEN '$fecha1' AND '$fecha2'
				GROUP BY cortes
				ORDER BY fecha_ingre DESC 
				LIMIT $desde,$por_pagina");

				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

				?>
						<tr>
							<td><?php echo $data["cortes"]; ?></td>
							<td><?php echo $data["peso"]; ?></td>
							<td> <?php if($data["peso"]>20){
								echo "<span class='campoverde'> Suficiente Stock </span>";
							}else{
								echo "<span class='camporojo'> Poco Stock </span>";
							} ?> </td>
							
							<td><?php 
							$fecha = explode(' ', $data["fecha_ingre"]); 
							echo $fecha[0]; ?></td>
						</tr>

				<?php
					}
					?>
					</table>
					<?php
				}else{
					if($search){
						?>
						</table>
						<br>
						<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>
						<?php
					}else{
						?>
						</table>
						<br>
						<h1>AUN NO HAY DATOS PARA MOSTRAR</h1>
						<?php
					}
				}
				?>
			<?php include "includes/paginador.php"; ?>
		</div>
	</section>
</body>

</html>
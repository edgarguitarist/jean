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
	<title>INVENTARIO DE PRODUCTO TERMINADO</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
	<div class="title_page">
		<h1>Inventario de Producto Terminado</h1></div>
		<div class="buscador">
			<a href="#" class="btn_nusuario" style="width: auto; padding: 10px;">Producto Terminado</a>
			<form action="inv_pro_ter.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php";?>
			</form>
		</div>
<!-- TODO: Agregar el codigo de la materia prima -->
		<div id="inv_ord_des">
		<table border="0" class="table" id="example" aria-describedby="tabla">
				<thead>
				<!--<tr>
					<th>Codigo</th>
					<th>Peso</th>
					<th>Estado</th>
					<th>Fecha de Salida</th>
				</tr> -->
				
				<tr>
					<!-- <th>Codigo</th> --> <!-- Aqui se hace un agrupamiento y se muestra solo 1 -->
					<th>Corte</th>
					<th>Peso</th>
					<th>Estado</th>
					<th>Fecha de Ingreso</th>
				</tr>
				</thead>
				<tbody>
				<?php

				$query = mysqli_query($conexion, "SELECT cortes, SUM(peso) AS peso, fecha_ingre, cod_pro 
				FROM prod_terminado 
				WHERE (peso LIKE '%$busqueda%'
						OR cortes LIKE '%$busqueda%'
						OR cod_pro LIKE '%$busqueda%') 
						AND fecha_ingre BETWEEN '$fecha1' AND '$fecha2'
				GROUP BY cortes
				ORDER BY fecha_ingre DESC");

				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

				?>
						<tr>
							<!-- <td><?php //echo $data['cod_pro']; ?></td> -->
							<td><?php echo $data["cortes"]; ?></td>
							<td style="text-align: end;"><?php echo $data["peso"]; ?></td>
							<td style="text-align: center;"> <?php if($data["peso"]>20){
								echo "<span class='textoverde'> Suficiente Stock </span>";
							}else{
								echo "<span class='textorojo'> Poco Stock </span>";
							} ?> </td>
							
							<td style="text-align: center;"><?php 
							$fecha = explode(' ', $data["fecha_ingre"]); 
							echo $fecha[0]; ?></td>
						</tr>

				<?php
					}
					?>
						</tbody>
					</table>
					<?php
				}
				?>
			
		</div>
	</section>
	<?php include "includes/script_ns.php"; ?>

</body>

</html>
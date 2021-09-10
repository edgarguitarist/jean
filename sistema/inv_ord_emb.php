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
	<title>INVENTARIO DE ORDEN DE EMBUTIDO</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
	<div class="title_page">
		<h1>Inventario De Orden De Embutido</h1></div>
		<div class="buscador">
			<a href="orden_produc_embu.php" class="btn_nusuario" style="width: auto; padding: 10px;">Orden de Embutido</a>
			<form action="inv_ord_emb.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php";?>
			</form>
		</div>
		
		<div id="inv_ord_des">
			<table class="threetable">
				<tr>
					<th>Nombre</th>
					<th>Cantidad</th>
					<th>Fecha De Orden</th>

				</tr>
				<?php

				//////////pagina
				$sql_registe = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro 
				FROM orden_embut 
				WHERE (nom_ord LIKE '%$busqueda%'
					OR cant_ord LIKE '%$busqueda%') 
					AND estado = 1
					AND fecha_ord_emb BETWEEN '$fecha1' AND '$fecha2' 
					ORDER BY fecha_ord_emb DESC"); // Activo 1
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


				$query = mysqli_query($conexion, "SELECT * 
				FROM orden_embut 
				WHERE (nom_ord LIKE '%$busqueda%'
				OR cant_ord LIKE '%$busqueda%') 
				AND estado = 1 
				AND fecha_ord_emb BETWEEN '$fecha1' AND '$fecha2'
				ORDER BY fecha_ord_emb DESC LIMIT $desde,$por_pagina");

				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

				?>
						<tr>
							<td><?php echo $data["nom_ord"]; ?></td>
							<td><?php echo $data["cant_ord"]; ?></td>
							<td><?php echo $data["fecha_ord_emb"]; ?></td>
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
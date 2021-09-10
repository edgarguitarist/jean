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
	<title>INVENTARIO DE ORDEN DE DESPOSTE</title>
</head>

<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
	<div class="title_page">
		<h1>Inventario De Orden De Desposte</h1></div>
		<div class="buscador">
			<a href="orden_desposte.php" class="btn_nusuario" style="width: auto; padding: 10px;">Orden de Desposte</a>
			<form action="inv_ord_des.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php";?>
			</form>
		</div>
		
		<div id="inv_ord_des">
			<table class="fourtable">
				<tr>
					<th>Nombre</th>
					<th>Lote</th>
					<th>Cortes</th>
					<th>Fecha De Desposte</th>

				</tr>
				<?php

				//////////pagina
				$sql_registe = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro 
				FROM orden_despost o 
					INNER JOIN tipo_mat t ON o.tip_mat_pri = t.id_tip_mat 
				WHERE (t.nom_tip_mat LIKE '%$busqueda%'
					OR o.lot_mat_pri LIKE '%$busqueda%'
			   		OR o.cor_pro LIKE '%$busqueda%') 
					AND estado = 1 
					AND o.fec_despo BETWEEN '$fecha1' AND '$fecha2'
					ORDER BY o.fec_despo DESC"); // Activo 1
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

				$query = mysqli_query($conexion, "SELECT t.nom_tip_mat, o.lot_mat_pri, o.cor_pro, o.fec_despo 
				FROM orden_despost o 
					INNER JOIN tipo_mat t ON o.tip_mat_pri = t.id_tip_mat 
				WHERE (t.nom_tip_mat LIKE '%$busqueda%'
					OR o.lot_mat_pri LIKE '%$busqueda%'
			   		OR o.cor_pro LIKE '%$busqueda%') 
					AND estado = 1 
					AND o.fec_despo BETWEEN '$fecha1' AND '$fecha2' 
					ORDER BY o.fec_despo DESC 
					LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);
				//debug_to_console($desde);
				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {
				?>
						<tr>
							<td><?php echo $data["nom_tip_mat"]; ?></td>
							<td><?php echo $data["lot_mat_pri"]; ?></td>
							<td><?php echo $data["cor_pro"]; ?></td>
							<td><?php echo $data["fec_despo"]; ?></td>
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
			<div class="pagina">
				<ul>
					<?php
					

					if ($pagina != 1) {

					?>
						<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">|<< </a>
						</li>
						<li><a href="?pagina=<?php echo $pagina - 1;  ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">
								<< </a>
						</li>

					<?php
					}
					for ($i = 1; $i <= $total_paginas; $i++) {
						if ($i == $pagina) {
							echo '<li class="pageSelected">' . $i . '</li>';
						} else {
							echo '<li><a href="?pagina=' . $i . '&busqueda=' . $busqueda . '&start_date='. $fecha1 . '&end_date='. $fecha2 .' ">' . $i . '</a></li>';
						}
					}
					if ($pagina != $total_paginas && $total_paginas > 1) {

					?>
						<li><a href="?pagina=<?php echo $pagina + 1; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">>></a></li>
						<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>&start_date=<?php echo $fecha1; ?>&end_date=<?php echo $fecha2; ?>">>|</a></li>
					<?php } ?>
				</ul>

			</div>
		</div>
	</section>
</body>

</html>
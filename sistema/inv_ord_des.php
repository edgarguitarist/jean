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
	<title>INVENTARIO DE ORDEN DE DESPOSTE</title>
</head>

<body>
	<?php include "includes/header.php"; ?>

	<section id="container">
		<div class="title_page">
			<h1>Inventario de Orden de Desposte</h1>
		</div>
		<div class="buscador">
			<a href="orden_desposte.php" class="btn_nusuario" style="width: auto; padding: 10px;">Orden de Desposte</a>
			<form action="inv_ord_des.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php"; ?>
			</form>
		</div>

		<div id="inv_ord_des">
			<table border="0" class="table" id="example" aria-describedby="tabla">


				<thead>
					<tr>
						<th>Nombre</th>
						<th>Materia Prima</th>
						<th>Cortes</th>
						<th>Fecha de Desposte</th>
					</tr>
				</thead>
				<tbody>
					<?php



					$query = mysqli_query($conexion, "SELECT t.nom_tip_mat, o.lot_mat_pri, o.cor_pro, o.fec_despo 
				FROM orden_despost o 
					INNER JOIN tipo_mat t ON o.tip_mat_pri = t.id_tip_mat 
				WHERE (t.nom_tip_mat LIKE '%$busqueda%'
					OR o.lot_mat_pri LIKE '%$busqueda%'
			   		OR o.cor_pro LIKE '%$busqueda%') 
					AND estado = 1 
					AND o.fec_despo BETWEEN '$fecha1' AND '$fecha2' 
					ORDER BY o.fec_despo DESC ");
					mysqli_close($conexion);
					$result = mysqli_num_rows($query);
					//debug_to_console($desde);
					if ($result > 0) {
						while ($data = mysqli_fetch_array($query)) {
					?>
							<tr>
								<td><?php echo $data["nom_tip_mat"]; ?></td>
								<td style="text-align: center;"><?php echo $data["lot_mat_pri"]; ?></td>
								<td style="text-align: center;"><?php echo $data["cor_pro"] . "."; ?></td>
								<td style="text-align: center;"><?php echo $data["fec_despo"]; ?></td>
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
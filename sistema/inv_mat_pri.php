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
	<title>INVENTARIO DE MATERIA PRIMA</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1>Inventario de Materia Prima</h1>
		</div>
		<div class="buscador">
			<a href="materia_prima.php" class="btn_nusuario" style="width: auto; padding: 10px;">Materia Prima</a>
			<form action="inv_mat_pri.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php"; ?>
			</form>
		</div>

		<div id="inv_mat_pri">
			<table border="0" class="table" id="example" aria-describedby="tabla">
				<thead>
					<tr>
						<th>Codigo</th>
						<th>Tipo</th>
						<th>Peso</th>
						<th>Fecha de Llegada</th>
						<th>Hora de Llegada</th>
						<?php if ($_SESSION['rol'] == 1) {
						?>
							<th>Proveedor</th>
							<th>Usuario</th>
						<?php  } ?>
					</tr>
				</thead>
				<tbody>
					<?php

					$query = mysqli_query($conexion, "SELECT u.id_mat, pr.nom_pro, t.nom_tip_mat, u.peso_lle,u.cod_mat_pri, us.nom_usu, u.fech_reg_mat 
			FROM mat_prima u
	    	 	INNER JOIN tipo_mat t ON u.id_tip_mat = t.id_tip_mat 
	    	 	INNER JOIN proveedor pr  ON u.id_prov = pr.id_prov 
	    	 	INNER JOIN usuario us  ON u.id_usu = us.id_usu 
	    	WHERE (u.id_mat LIKE '%$busqueda%'
			 	OR pr.nom_pro LIKE '%$busqueda%'
				OR t.nom_tip_mat LIKE '%$busqueda%'  
				OR u.cod_mat_pri LIKE '%$busqueda%' 
	    		OR us.nom_usu LIKE '%$busqueda%' 
	    		OR u.peso_lle LIKE '%$busqueda%') 
				AND estado_mate = 1 
				AND u.fech_reg_mat BETWEEN '$fecha1' AND '$fecha2' 
				ORDER BY fech_reg_mat DESC ");
					mysqli_close($conexion);
					$result = mysqli_num_rows($query);


					if ($result > 0) {
						while ($data = mysqli_fetch_array($query)) {
							$fecha = explode(' ', $data["fech_reg_mat"]);
					?>
							<tr>
								<td><?php echo $data["cod_mat_pri"]; ?></td>
								<td style="text-align: center;"><?php echo $data["nom_tip_mat"]; ?></td>
								<td style="text-align: end;"><?php echo $data["peso_lle"]; ?></td>
								<td style="text-align: center;"><?php echo $fecha[0]; ?></td>
								<td style="text-align: center;"><?php echo $fecha[1]; ?></td>
								<?php if ($_SESSION['rol'] == 1) {
								?>
									<td><?php echo $data["nom_pro"]; ?></td>
									<td><?php echo $data["nom_usu"]; ?></td>
								<?php  } ?>
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
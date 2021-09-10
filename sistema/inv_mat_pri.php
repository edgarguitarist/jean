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
	<title>INVENTARIO DE MATERIA PRIMA</title>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1>Inventario De Materia Prima</h1>
		</div>
		<div class="buscador">
			<a href="materia_prima.php" class="btn_nusuario" style="width: auto; padding: 10px;">Materia Prima</a>
			<form action="inv_mat_pri.php" method="GET" class="form_buscar">
				<?php include "includes/buscador.php"; ?>
			</form>
		</div>

		<div id="inv_mat_pri">
			<table>
				<tr>
					<th>Codigo</th>
					<th>Tipo</th>
					<th>Peso</th>
					<th>Fecha De Llegada</th>
					<?php if ($_SESSION['rol'] == 1) {
					?>
						<th>Proveedor</th>
						<th>Usuario</th>
					<?php  } ?>
				</tr>
				<?php

				//////////pagina
				$sql_registe = mysqli_query($conexion, "SELECT COUNT(*) AS total_registro 
														FROM mat_prima u
															INNER JOIN tipo_mat t ON u.id_tip_mat = t.id_tip_mat 
															INNER JOIN proveedor pr  ON u.id_prov = pr.id_prov 
															INNER JOIN usuario us  ON u.id_usu = us.id_usu 
														WHERE (u.id_mat LIKE '%$busqueda%'
															OR pr.nom_pro LIKE '%$busqueda%'
															OR t.nom_tip_mat LIKE '%$busqueda%'  
															OR u.cod_mat_pri LIKE '%$busqueda%' 
															OR us.nom_usu LIKE '%$busqueda%' 
															OR u.peso_lle LIKE '%$busqueda%') AND estado_mate = 1 AND u.fech_reg_mat BETWEEN '$fecha1' AND '$fecha2' 
														ORDER BY fech_reg_mat DESC"); // Activo 1
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
				ORDER BY fech_reg_mat DESC 
				LIMIT $desde,$por_pagina");
				mysqli_close($conexion);
				$result = mysqli_num_rows($query);


				if ($result > 0) {
					while ($data = mysqli_fetch_array($query)) {

				?>
						<tr>
							<td><?php echo $data["cod_mat_pri"]; ?></td>
							<td><?php echo $data["nom_tip_mat"]; ?></td>
							<td><?php echo $data["peso_lle"]; ?></td>
							<td><?php echo $data["fech_reg_mat"]; ?></td>
							<?php if ($_SESSION['rol'] == 1) {
							?>
								<td><?php echo $data["nom_pro"]; ?></td>
								<td><?php echo $data["nom_usu"]; ?></td>
							<?php  } ?>


						</tr>

					<?php
					}
					?>
			</table>
			<?php
				} else {
					if ($search) {
			?>
				</table>
				<br>
				<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>
			<?php
					} else {
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
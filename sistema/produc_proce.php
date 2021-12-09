<?php
session_start();
include "conexion.php";

if (!empty($_POST)) {

	$alert = '';
	if (empty($_POST['prod_proce']) || empty($_POST['peso_sali'])) {
		$alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
	} else {

		$prod_procesa   =  $_POST['prod_proce'];
		$peso_sal      =  $_POST['peso_sali'];

		$insert = mysqli_query($conexion, "INSERT INTO prod_procesar(cod_pro,pes_pro ) 
		VALUES('$prod_procesa','$peso_sal')"); // agregar estado

		if ($insert) {
			$alert = '<p class="msg_guardar">Registrado Correctamente.</p>';
			$query_delete = mysqli_query($conexion, "UPDATE orden_despost SET estado = 0 WHERE lot_mat_pri = '$prod_procesa' ");
		} else {
			$alert = '<p class="msg_error">Error Al Registrar.</p>';
		}
	}
}

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
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">

		<div class="title_page">
			<h1>Producto A Procesar</h1>

			<div class="datos_desposte">
				<div class="action_orden">
					<h4>Datos</h4>
				</div>
				<form name="registra_desposte" id="registra_desposte" class="datos" action="" method="post">

					<div class="wd30">
						<label for="Tipo de Materia Prima">Orden A Procesar :</label>
						<?php
						$query_tipo = mysqli_query($conexion, "SELECT * FROM orden_despost WHERE estado=1");
						$result_tipo = mysqli_num_rows($query_tipo);
						?>
						<select name="prod_proce" id="prod_proce" required="">
							<option selected disabled>Seleccionar Orden</option>
							<?php
							if ($result_tipo > 0) {
								while ($tipo = mysqli_fetch_array($query_tipo)) {
							?>
									<option value='<?php echo $tipo["lot_mat_pri"]; ?>'><?php echo $tipo["lot_mat_pri"] ?></option>
							<?php
								}
							} ?>

						</select>
					</div>

					<div class="wd30">
						<label>Peso </label>
						<input name="peso_sali" id="peso_sali">
					</div>

					<div class="wd30">
						<input type="submit" value="Agregar Producto" class="btn_guardar" style="width: auto; padding: 10px;">
					</div>
				</form>
				<h1>Lista de Cortes</h1>

				<table>
					<thead>
						<tr style="background: #325459 !important;">
							<th class="textcenter" width="100px">Cortes</th>
						</tr>
					</thead>
					<tbody id="mostrar_data2">
						<!--contenido desde lista_receta-->
					</tbody>
				</table>

			</div>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
		</div>
	</section>
</body>

</html>
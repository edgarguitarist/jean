<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
	header("location: login.php");
}
include "conexion.php";
date_default_timezone_set('America/Guayaquil');
$reporte = "Reporte de Merma";
$namepdf = "Reporte_Merma - " . $hoy;
?>

<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title><?= $reporte; ?></title>
</head>

<script>
	//desabilitar el select obt_cod

	function verify() {

		var select = document.getElementById("tipo_reporte").value;
		if (select != "1") {
			document.getElementById("obt_cod").disabled = true;
			document.getElementById("obt_cod").required = false;
		} else {
			document.getElementById("obt_cod").disabled = false;
			//quitar el required del input obt_cod
			document.getElementById("obt_cod").required = true;
		}
	}
</script>

<body onload="blockday()">
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1><?= $reporte; ?></h1>
			<br>
			<div class="datos_desposte">
				<form id="form_reporte" name="form_reporte" method="post" style="padding: 0px; border: 0px; background: #00000000;">
					<div class="tipo_reporte col2 full-width">
						<p>
							<label>Tipo de Reporte</label>
							<select name="tipo_reporte" id="tipo_reporte" onchange="verify()" required>
								<option value="">Seleccionar un Tipo</option>

								<?php
								$query = mysqli_query($conexion, "SELECT * FROM tipo_reporte");
								$result = mysqli_num_rows($query);
								if ($result > 0) {
									while ($tip = mysqli_fetch_array($query)) {
								?>
										<option value='<?= $tip["id_tipo"]; ?>'><?= $tip["nom_tipo"] ?></option>
								<?php
									}
								} ?>

							</select>
						</p>
						<p>
							<label for="Tipo de Materia Prima">Tipo de Materia Prima :</label>
							<select name="tip_ma_m" id="tip_ma_m" required>
								<option value="">Seleccionar Tipo M.Primas</option>

								<?php
								$query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
								$result_tipo = mysqli_num_rows($query_tipo);
								if ($result_tipo > 0) {
									while ($tipo = mysqli_fetch_array($query_tipo)) {
								?>
										<option value='<?= $tipo["id_tip_mat"]; ?>'><?= $tipo["nom_tip_mat"] ?></option>
								<?php
									}
								} ?>
							</select>
						</p>


						<p class="">
							<label for="start_date" class="form" style="margin: 0px;">Fecha inicial:</label>
							<input id="start_date" type="date" class="f16" name="start_date" step="1" min="2020-01-01" max="<?= $hoy; ?>" value="2022-01-27">
						</p>
						<p class="">
							<label for="end_date" class="form" style="margin: 0px;">Fecha final:</label>
							<input id="end_date" type="date" class="f16" name="end_date" step="1" min="2020-01-01" max="<?= $hoy; ?>" value="2022-01-28">
						</p>
						<p class="full-width">
							<label for="obt_cod">Materia Prima :</label>
							<select name="obt_cod" id="obt_cod" required></select>
						</p>
						<p class="full-width" style="text-align: center;">
							<input type="submit" name="submit" id="generar" value="Generar" class="btn_guardar_usuario " style="width: auto; padding: 10px;" />
						</p>

					</div>
				</form>
			</div>
			<br>
			<!--<button onclick="genPDF();"> Generar Pdf</button>
			<div id="testDiv"></div>-->
			<br>
			<center><button id='btn-export' class='btn btn_guardar_usuario' onclick="genPDF('<?= $namepdf; ?>');" style='display:none;'>IMPRIMIR</button></center>
			<div id="pdf_container">
				<span>.</span>
				<div id="cabecera" style="display: none;">
					<table id="factura_head">
						<tr>
							<td class="logo_factura">
								<div>
									<img src="img/embj.jpg">
								</div>
							</td>
							<td class="info_empresa wd50">

								<div>
									<H1 class="textcenter"><?= $reporte; ?></H1>
								</div>

							</td>
							<td class="info_factura wd25">
								<div class="round">
									<h3 class="textcenter">Información</h3>
									<p>Fecha: <?= $fecha; ?></p>
									<p>Hora: <?= $hora; ?></p>
								</div>
							</td>
						</tr>
					</table>
				</div>
				<br><br>
				<div class="datosp full-width" id="mostrar_data" style="display: none;"></div>
			</div>
		</div>
	</section>

</body>

</html>
<?php
session_start();
include "conexion.php"; // Mostrar de la tabla    prod_procesar
$reporte = 'Reporte de Materia Prima';
$namepdf = "Reporte_Mat_Pri - " . $hoy;
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title><?= $reporte; ?></title>
</head>

<body onload="blockday()">
	<?php include "includes/header.php"; ?>
	<section id="container">
		<div class="title_page">
			<h1><?= $reporte; ?></h1>
			<br>
			<div class="datos_desposte">
				<form id="form_rep_mat" name="form_reporte" method="post" style="padding: 0px; border: 0px; background: #00000000;">
					<div class="tipo_reporte col2 full-width">
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

						<p>
							<label for="obt_cod">Materia Prima :</label>
							<select name="obt_cod" id="obt_cod" ></select>
						</p>
						<p></p> <!-- Extrañamente necesario -->
						<p style="text-align: center;">
							<label for="fecha1">Fecha Inicial:</label>
							<input onchange="ocultardata()" id="start_date" type="date" class="f16" name="start_date" step="1" min="2021-12-15" max="<?= $hoy; ?>" value="2020-01-01">

						</p>
						<p style="text-align: center;">
							<label for="fecha1">Fecha Final:</label>
							<input onchange="ocultardata()" id="end_date" type="date" class="f16" name="end_date" step="1" min="2021-12-15" max="<?= $hoy; ?>" value="<?= $hoy; ?>">

						</p>
						<p class="full-width2" style="text-align: center;">
							<input type="submit" name="submit" id="generar" value="Generar" class="btn_guardar_usuario full-width" style="width: auto; padding: 10px;" />
						</p>
					</div>
				</form>
			</div>
			<br>
			<br>
			<center><button id='btn-export' class='btn btn_guardar_usuario' onclick="genPDF('<?= $namepdf; ?>');" style='display:none;'>IMPRIMIR</button></center>
			<div id="pdf_container">
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
<?php
session_start();
include "conexion.php"; // Mostrar de la tabla    prod_procesar
$reporte = 'Reporte de Orden de Embutido';
$namepdf = "Reporte_Ord_Emb - " . $hoy;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>REPORTE DE ORDEN DE EMBUTIDOS</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <script type="text/javascript" src="funciones.js"></script>
    <section id="container">
		<div class="title_page">
			<h1><?php echo $reporte;?></h1>
			<br>
			<div class="datos_desposte">
				<form id="form_rep_ord_emb"  name="form_rep_ord_emb" method="post" style="padding: 0px; border: 0px; background: #00000000;">
					<div class="tipo_reporte col2 full-width">
						<!--<p>
							<label for="Tipo de Materia Prima">Tipo de Materia Prima :</label>
							<select name="tip_ma_m" id="tip_ma_m" required>
								<option value="">Seleccionar Tipo M.Primas</option>
								<?php
								$query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
								$result_tipo = mysqli_num_rows($query_tipo);
								if ($result_tipo > 0) {
									while ($tipo = mysqli_fetch_array($query_tipo)) {
								?>
										<option value='<?php echo $tipo["id_tip_mat"]; ?>'><?php echo $tipo["nom_tip_mat"] ?></option>
								<?php
									}
								} ?>
							</select>
						</p>-->
                        
						<p style="text-align: center;">
							<label for="fecha1">Fecha Inicial:</label>
							<input onchange="ocultardata()" id="start_date" type="date" class="f16" name="start_date" step="1" min="2021-12-15" max="<?php echo $hoy; ?>" value="<?php echo "2020-02-25";//Dia de prueba  //echo date("Y-m-d"); ?>">
							
						</p>
                        <p style="text-align: center;">
							<label for="fecha2">Fecha Final:</label>
							<input onchange="ocultardata();" id="end_date" type="date" class="f16" name="end_date" step="1" min="2021-12-15" max="<?php echo $hoy; ?>" value="<?php echo $hoy; ?>">
							
						</p>
						<p class="full-width" style="text-align: center;">
							<input type="submit" name="submit" id="generar" value="Generar" class="btn_guardar_usuario full-width" style="width: auto; padding: 10px;" />
						</p>
					</div>
				</form>
			</div>
			<br>
			<br>
			<center><button id='btn-export' class='btn btn_guardar_usuario' onclick="genPDF('<?php echo $namepdf; ?>');" style='display:none;'>IMPRIMIR</button></center>
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
									<H1 class="textcenter"><?php echo $reporte;?></H1>
								</div>
								
							</td>
							<td class="info_factura wd25">
								<div class="round">
									<h3 class="textcenter">Información</h3>
									<p>Fecha: <?php echo $fecha;?></p>
									<p>Hora: <?php echo $hora;?></p>
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
<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
	header("location: login.php");
}
include "conexion.php";


if (!empty($_POST)) {
	$alert = '';
	if (empty($_POST['rol_lis_re']) || empty($_POST['cant_lis'])) {
		$alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
	} else {
		$nombre_orde     = $_POST['rol_lis_re'];
		$canti_orde    = $_POST['cant_lis'];
		$insert = mysqli_query($conexion, "INSERT INTO orden_embut(nom_ord,cant_ord) 
		VALUES('$nombre_orde','$canti_orde')");
		if ($insert) {
			$alert = '<p class="msg_guardar">Orden Realizada Correctamente.</p>';
		} else {
			$alert = '<p class="msg_error">Error Al Realizar la Orden.</p>';
		}
	}
}
$nametitle = "Orden de Embutido";
$namepdf = "Orden de Embutido - " . $hoy;
?>


<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">

	<?php include "includes/scripts.php"; ?>
	<title>Sistema de Producción</title>

	<script>
		function limp() {
			$("#alerta").hide
		}
	</script>

</head>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">
		<div class="title_page">
			<h1>Orden de Producción de Embutido</h1>
			<div class="datos_cliente">
				<div class="action_cliente">
					<h4>Datos</h4>
				</div>
				<form name="orde_prdc_emb" id="orde_prdc_emb" class="datos" action="" method="post">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" id="idproveedor" name="idproveedor" value="" required>
					<div class="wd30">
						<label for="rol">Ingrediente:</label>
						<?php
						$query_rol = mysqli_query($conexion, "	SELECT*,IF(A.nom_rece IN(	SELECT
																								B.nom_ord
																							FROM
																								orden_embut B
																							WHERE
																								B.estado = 1
																							GROUP BY
																								B.nom_ord
																						),
																						'SI',
																						'NO'
																						) AS EXISTE
																FROM
																	lista_receta A
																GROUP BY
																	A.nom_rece");
						$result_rol = mysqli_num_rows($query_rol);
						?>
						<select name="rol_lis_re" id="rol_lis_re" onchange="reset_sub()">
							<option value="">Seleccionar Ingrediente</option>
							<?php
							if ($result_rol > 0) {
								while ($rol = mysqli_fetch_array($query_rol)) {
									if ($rol["EXISTE"] == "NO") {
							?>
										<option value="<?php echo $rol["nom_rece"]; ?>"><?php echo $rol["nom_rece"] ?></option>
							<?php  	}
								}
							}
							?>
						</select>
					</div>

					<div class="wd30">
						<label>Cantidad</label>
						<select name="cant_lis" id="cant_lis">
							<option value="0">Selecionar Cantidad</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
						</select>
					</div>

					<input id="submito" type="submit" value="Generar Orden de Embutido" class="btn_guardar" style="width: auto; padding: 10px;" disabled>
				</form>
				<center>

					<div class="wd30">
						<button id="imprimir" name="imprimir" onclick="genPDF('<?php echo $namepdf; ?>'); active_sub();" class="btn_guardar" style="width: auto; padding: 10px;" disabled>Imprimir Orden de Embutido</button>
					</div>
				</center>
				<div id="pdf_container">
					<span>.</span>
					<div id="cabecera" style="display: none;">
						<table id="factura_head">
							<tr>
								<td class="logo_factura">
									<div>
										<img class="" alt="logo" src="img/embj.jpg">
									</div>
								</td>
								<td class="info_empresa wd50">

									<div>
										<H1 class="textcenter"><?php echo $nametitle; ?></H1>
									</div>

								</td>
								<td class="info_factura wd25">
									<div class="round">
										<h3 class="textcenter">Información</h3>
										<p>Fecha: <?php echo $fecha; ?></p>
										<p>Hora: <?php echo $hora; ?></p>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<br><br>
					<h1 class="v-margin">Lista de Ingredientes</h1>
					<table border="0" class="table" id="example" aria-describedby="tabla">
						<thead>
							<tr style="background: #325459 !important;">
								<th class="textcenter" width="100px">Codigo</th>
								<th class="textcenter">Ingrediente</th>
								<th class="textcenter" width="100px">Cantidad</th>
							</tr>
						</thead>
						<tbody id="mostrar_data1">
							<!--contenido desde lista_receta-->
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<script type="text/javascript">
		//const submito = document.getElementById('submito');
		const imprimir = document.getElementById('imprimir');

		function reset_sub() {
			//submito.disabled = true;
			imprimir.disabled = true;
		}

		function active_sub() {
			submito.disabled = false;
			imprimir.disabled = true;
		}

		function viewRevisar() {
			gg = document.getElementById('est_info').value;
			if (gg == 1 || gg == '1') {
				//submito.disabled = false;
				imprimir.disabled = false;
			} else {
				//submito.disabled = true;
				imprimir.disabled = true;
			}
		}
	</script>
</body>

</html>
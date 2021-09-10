<?php
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2) {
	header("location: login.php");
}
include "conexion.php";


if (!empty($_POST)) {
	$alert = '';
	if (empty($_POST['rol_lis_re']) || empty($_POST['cant_lis'])) {
		$alert = '<p class="msg_error">Los Campos Asingados Son Obligatorio</p>';
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
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">

	<?php include "includes/scripts.php"; ?>
	<title>Sistema de Producción</title>

	<script>
	
	function limp (){
		$("#alerta").hide
	}
	
	</script>

</head>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">
		<div class="title_page">
			<h1>Orden De Produccion de Embutido</h1>
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
									if ($rol["EXISTE"] == "NO"){
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
					<div class="wd30"></div>
					<input id="submito" type="submit" value="Generar Orden de Embutido" class="btn_guardar" style="width: auto; padding: 10px;" disabled>
				</form>
				<h1 class="v-margin">Lista De Ingredientes</h1>
				<table>
					<thead>
						<tr>
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
			<div id="alerta" class="alert"><?php //echo isset($alert) ? $alert : ''; ?></div>
		</div>
	</section>
	
	<script type="text/javascript">

		function reset_sub(){
			submito = document.getElementById('submito');
			submito.disabled = true;
		}


		function viewRevisar() {
			gg = document.getElementById('est_info').value;
			submito = document.getElementById('submito');
			if (gg==1 || gg=='1') {
				submito.disabled = false;
				//console.log(gg,"yes")
			} else {
				submito.disabled = true;
				//console.log(gg,"no")
			}
		}


	</script>
</body>
</html>
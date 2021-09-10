<?php
session_start();
include "conexion.php"; // Mostrar de la tabla    prod_procesar																																}
if (isset($_GET['ord_desp'])) {
	$cod = $_GET['ord_desp'];
}
?>

<!DOCTYPE html>
<html lang="en">

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
			<h1>Producto Carnico Terminado</h1>

			<div class="datos_desposte">
				<div class="action_orden">
					<h4>Datos</h4>
				</div>
				<form name="prod_termina" id="prod_termina" class="datos">
					<div class="wd30">
						<label for="rol">Orden A Procesar :</label>
						<?php
						$query_rol1 = mysqli_query($conexion, "SELECT pp.id_pro_pro AS id, pp.cod_pro AS codigo, pp.pes_pro AS peso, (SELECT IFNULL(SUM(pt.peso), 0) FROM prod_terminado pt WHERE pt.cod_pro=pp.cod_pro  GROUP BY pt.cod_pro) AS suma FROM prod_procesar pp WHERE pp.estado_prod_pro = 1");
						$result_rol1 = mysqli_num_rows($query_rol1);
						?>

						<select name="ord_desp" id="ord_desp" onchange="revisar()" required>
							<option selected disabled value="">Seleccionar Producto</option>

							<?php
							$data = array("prueba" => 1);
							if ($result_rol1 > 0) {
								while ($rol = mysqli_fetch_array($query_rol1)) {
									$peso=$rol["peso"]-$rol["suma"];
									$data[$rol["codigo"]] = $peso;
							?>
									<option value="<?php echo $rol["codigo"]; ?>"><?php echo $rol["codigo"] ?></option>
							<?php

								}
							}
							//json_encode($data, JSON_UNESCAPED_UNICODE);
							?>
						</select>
					</div>
					<div class="wd30">
						<h4 id="msg_error_pro" class="msg_error v-margin" hidden>Primero debe Seleccionar un Producto</h4>
						<h4 id="msg_error_pro2" class="msg_error v-margin" hidden>El peso ingresado supera el peso de llegada del producto</h4>

						<?php
							//echo $data['Cha-35'];
						?>

					</div>
					<div class="wd30"></div>
					<div class="wd30">
						<label for="rol">Cortes :</label>
						<select name="id_cortes" id="id_cortes" onchange="revisar()" required>
							<option selected disabled value="">Seleccionar Corte</option>
						</select>
					</div>

					<div class="wd30">
						<label>Peso </label>
						<input name="peso_lle" id="peso_lle" class="solo-numero" value="0" onfocus="checkSelect()" onkeyup="revisar(); checkPeso();" required>
					</div>
					<div class="wd30"></div>

					<input id="add_prod_ter" type="submit" value="Guardar Producto" class="btn_guardar" style="width: auto; padding: 10px;" disabled>
				</form>
			</div>

			<h1 class="v-margin">Productos Terminados</h1>
			<table>
				<thead>
					<tr>
						<th class="textcenter">Codigo</th>
						<th class="textcenter">Cortes</th>
						<th class="textcenter">Peso</th>
						<th class="textcenter">Fecha Ingreso</th>
					</tr>
				</thead>
				<tbody id="mostrar_data_proter">
					<!--contenido desde lista_receta-->
					<?php
					$queryL = mysqli_query($conexion, "SELECT * FROM prod_terminado WHERE cod_pro NOT LIKE '%EMB%' ORDER BY cod_pro");
					while ($list = mysqli_fetch_array($queryL)) { ?>
						<tr>
							<td><?php echo $list["cod_pro"]; ?></td>
							<td><?php echo $list["cortes"]; ?></td>
							<td><?php echo $list["peso"]; ?></td>
							<td><?php echo $list["fecha_ingre"]; ?></td>
						</tr>
					<?php	} ?>
				</tbody>
			</table>
		</div>
	</section>

	<script>

		function checkPeso() {
			var selpro = $("#ord_desp").val();
  			var selcor = $("#id_cortes").val();	
			submito = document.getElementById('add_prod_ter');
			var arreglo = <?php echo json_encode($data); ?>

			if (selpro != null) {
				var valor = Number(arreglo[selpro]);
				var gg = Number(document.getElementById('peso_lle').value);
				if (valor >= gg) {
					$("#msg_error_pro2").hide();
					//console.log(valor, gg, "si");
					if(selcor!=null){
						submito.disabled = false;
						return true;
					}
				} else {
					$("#msg_error_pro2").show();
					submito.disabled = true;
					//console.log(valor, gg, "no");
					return false;
				}
			} else {
				$("#ord_desp").focus();
				return false;
			}
		}
	</script>

</body>

</html>
<?php
session_start();
include "conexion.php"; // Mostrar de la tabla    prod_procesar
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
			<h1>Producto Embutido Terminado</h1>

			<div class="datos_desposte">
				<div class="action_orden">
					<h4>Datos</h4>
				</div>
				<form name="prod_termina_emb" id="prod_termina_emb" class="datos" onclick="fetchPeso('peso_lle')">
					<div class="wd30">
						<label for="ord_desp">Orden A Procesar :</label>
						<?php
						$query_rol1 = mysqli_query($conexion, "SELECT *, (SELECT SUM(lr.cant_rece) * oe.cant_ord FROM lista_receta lr WHERE lr.nom_rece = oe.nom_ord GROUP BY lr.nom_rece) AS total FROM orden_embut oe WHERE oe.estado = '1' GROUP BY oe.nom_ord");
						$result_rol1 = mysqli_num_rows($query_rol1);
						?>
						<select name="ord_desp" id="ord_desp" onchange="revisar2(); checkPeso2();" required>
							<option selected disabled value="">Seleccionar Producto</option>
							<?php
							$data = array("prueba" => 1);
							if ($result_rol1 > 0) {
								while ($rol = mysqli_fetch_array($query_rol1)) {
									$data[$rol["nom_ord"]] = $rol["total"];
							?>
									<option value="<?php echo $rol["nom_ord"]; ?>"><?php echo $rol["nom_ord"] ?></option>
							<?php
								}
							}
							?>
						</select>
					</div>
					<div class="wd30">
						<label for="peso_lle">Peso</label>
						<input type="hidden" name="peso_lle" id="peso_lle">
						<input type="text" name="peso_lle2" id="peso_lle2"  value="0" disabled required>
					</div>
					<!-- TODO: Agregar Cantidad -->
					<div class="wd30">
						<label for="">Cantidad</label>
						<input type="number" name="cantidad" id="cantidad" class="solo-numero" minlength="2" min="30" value="" onfocus="checkSelect();" onchange="revisar2(); checkPeso2();" onkeyup="revisar2(); checkPeso2();" required>
					</div>
					<div class="wd100">
						<h4 id="msg_error_pro" class="msg_error v-margin" hidden>Primero debe Seleccionar un Producto</h4>
						<h4 id="msg_error_pro2" class="msg_error v-margin" hidden>El peso ingresado supera el peso de llegada del producto</h4>
					</div>
					<input id="submitemb" type="submit" value="Guardar Producto" class="btn_guardar" style="width: auto; padding: 10px;" disabled>
				</form>
			</div>

			<h1 class="v-margin">Productos Terminados</h1>
			<table border="0" class="table" id="example" aria-describedby="tabla">

				<thead>
					<tr>
						<th class="textcenter">Código</th>
						<th class="textcenter">Nombre</th>
						<th class="textcenter">Peso</th>
						<th class="textcenter">Cantidad</th>
						<!-- TODO: Agregar Cantidad -->
						<th class="textcenter">Fecha Ingreso</th>
					</tr>
				</thead>
				<tbody id="mostrar_data_proter">
					<!--contenido desde lista_receta-->
					<?php
					$queryL = mysqli_query($conexion, "SELECT * FROM prod_terminado WHERE cod_pro LIKE '%EMB%' ORDER BY fecha_ingre DESC");
					while ($list = mysqli_fetch_array($queryL)) { ?>
						<tr>
							<td><?php echo $list["cod_pro"]; ?></td>
							<td><?php echo $list["cortes"]; ?></td>
							<td><?php echo $list["peso"]; ?></td>
							<td><?php echo $list["cantidad"]; ?></td>
							<td><?php echo $list["fecha_ingre"]; ?></td>
						</tr>
					<?php	} ?>
				</tbody>
			</table>

		</div>

	</section>


	<script>
		function checkPeso2() {
			var mensaje = document.getElementById("msg_error_pro2")
			var selpro = $("#ord_desp").val();
			submito = document.getElementById('submitemb');
			var arreglo = <?php echo json_encode($data); ?>

			if (selpro != null) {
				var valor = parseFloat(arreglo[selpro]).toFixed(3);
				var gg = parseFloat(document.getElementById('peso_lle').value).toFixed(3);
				if (valor >= gg) {
					resultado = valor - gg;
					mensaje.innerHTML = "Quedan " + resultado + " libras";
					mensaje.className = "msg_success v-margin";
					$("#msg_error_pro2").show();
					submito.disabled = false;
					//console.log(valor, gg, "si");
					return true;
				} else {
					mensaje.innerHTML = "El peso ingresado supera el peso de llegada del producto";
					mensaje.className = "msg_error v-margin";
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
		position_sort_table = 4
		order_sort_table = "desc"
	</script>
	<?php include "includes/script_sort.php"; ?>
</body>

</html>
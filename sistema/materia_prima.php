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
	<title>Sistema de Producción</title>
	<script>
		function getProveedor() {
			var pro = $("#ced_proveedor").val();
			var action = "searchProveedor";
			var salida2 = document.getElementById("salida2");
			$.ajax({
				url: "ajax.php",
				type: "POST",
				async: true,
				data: {
					action: action,
					cliente: pro
				},
				success: function(response) {
					if (response == 0) {
						//limpiar campos
						$("#idproveedor").val("");
						$("#nom_proveedor").val("");
						$("#ruc_empresa").val("");
						$("#nom_empresa").val("");
						$("#tipo_empresa").val("");
						$('input[type="submit"]').attr('disabled', 'disabled');
					} else {
						//mostras datos
						var data = $.parseJSON(response);
						$("#idproveedor").val(data.id_prov);
						$("#nom_proveedor").val(data.raz_emp);
						$("#ruc_empresa").val(data.ruc_emp);
						$("#nom_empresa").val(data.nom_emp);
						$("#tipo_empresa").val(data.tipo);

						//bloquear campos
						$("#nom_proveedor").attr("disabled", "disabled");
						$("#ruc_empresa").attr("disabled", "disabled");
						$("#nom_empresa").attr("disabled", "disabled");
						salida2.innerHTML = '';

						//$('input[type="submit"]').attr('disabled',false);
					}
				},
				error: function(error) {},
			});
		}

		function revisar() {
			var prov = $("#ruc_empresa").val();
			var mat = $("#tipo_mate").val();
			var pes = $("#peso_lle").val();
			var salida2 = document.getElementById("salida2");

			//console.log(prov, mat, pes);
			if (prov != '' && mat != '' && pes != '') {
				$('input[type="submit"]').attr('disabled', false);
				salida2.innerHTML = '';
			} else {
				$('input[type="submit"]').attr('disabled', 'disabled');
				salida2.innerHTML = 'Por Favor llene todos los campos!';
				salida2.style.color = 'red';
			}

		}
	</script>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<?php include "includes/modal.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">
		<div class="title_page" class="alert">
			<h1>Registrar Materia Prima</h1>
			<div class="datos_cliente">
				<div class="action_cliente">
					<h4>Datos Del Proveedor</h4>
					<?php
					if ($_SESSION['rol'] == 1) {
					?>
						<a href="Proveedor.php" class="btn_nusuario">Nuevo Proveedor</a>
						<a href="#" class="btn_nusuario add_materia_prima">Nueva Materia Prima</a>
					<?PHP
					}
					?>
				</div>
				<form name="registra_materia_prima" id="registra_materia_prima" class="datos" onchange="revisar(); fetchPeso('peso_lle');">
					<input type="hidden" name="action" value="addCliente">
					<input type="hidden" id="idproveedor" name="idproveedor" value="">
					<div class="wd30">
						<!-- <input type="text" name="ced_proveedor" id="ced_proveedor" placeholder="Ingrese Cedula Proveedor" maxlength="10" class="solo-numero" onkeyup="getProveedor(); validar3();" onblur="validar3();" autofocus required> -->

						<?php
						$query_pro = mysqli_query($conexion, "SELECT * FROM proveedor");
						$result_pro = mysqli_num_rows($query_pro);
						?>
						<select name="ced_proveedor" id="ced_proveedor" onchange="getProveedor()" required>
							<option value="">Seleccionar Proveedor</option>
							<?php
							if ($result_pro > 0) {
								while ($pro = mysqli_fetch_array($query_pro)) {
							?>
									<option value="<?php echo $pro["ced_pro"]; ?>"><?php echo $pro["nom_pro"] . " " . $pro["ape_pro"] ?></option>
							<?php
								}
							}
							?>
						</select>
						<label id="salida" style="font-size:1em; font-weight: bold;"></label>
					</div>
					<div class="wd30">
						<label>Nombre Empresa</label>
						<input type="text" name="nom_empresa" id="nom_empresa" disabled>
					</div>
					<div class="wd30"></div>
					<div class="wd30">
						<label>Tipo Empresa</label>
						<input type="text" name="tipo_empresa" id="tipo_empresa" disabled>
					</div>
					<div class="wd30">
						<label>Razon</label>
						<input type="text" name="nom_proveedor" id="nom_proveedor" disabled>
					</div>
					<div class="wd30">
						<label>Ruc Empresa</label>
						<input type="text" name="ruc_empresa" id="ruc_empresa" disabled>
					</div>
					<div class="wd30">
						<label for="Materia Prima">Materia Prima:</label>
						<?php
						$query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
						$result_tipo = mysqli_num_rows($query_tipo);
						?>
						<select name="tipo_mate" id="tipo_mate" required>
							<?php
							?>
							<option value="">Seleccionar Materia Prima</option>
							<?php
							if ($result_tipo > 0) {
								while ($tipo = mysqli_fetch_array($query_tipo)) {
							?>
									<option value="<?php echo $tipo["id_tip_mat"]; ?>"><?php echo $tipo["nom_tip_mat"] ?></option>
							<?php
								}
							}
							?>
						</select>
					</div>
					<div class="wd30">
						<label>Peso de Llegada</label>
						<input type="hidden" name="peso_lle" id="peso_lle">
						<input type="text" name="peso_lle2" id="peso_lle2" value="0" disabled required>
					</div>
					<div class="wd30">
						<label id="salida2" style="font-size:1em; font-weight: bold;"></label>
					</div>
					<input id="btn_guar" type="submit" value="Registrar Materia Prima" class="btn_guardar" style="width: auto; padding: 10px;">
					<div class="alert" id="panel_respuesta"></div>
					<div class="wd30"></div>
				</form>
			</div>
			<hr>
		</div>
	</section>
</body>

</html>
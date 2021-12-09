<?php
session_start();

if ($_SESSION['rol'] != 1) {
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
</head>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>

	<section id="container">


		<div class="title_page" class="alert">
			<h1>Crear Receta Nueva</h1>
			<div class="datos_cliente">
				<div class="action_cliente">
					<h4>Ingredientes</h4>
					<a href="orden_produc_embu.php" class="btn_nusuario">Orden de Embutido</a>
					<a href="#" class="btn_busuario" id="btn_limpiar">Limpiar Lista</a>
				</div>
				<form name="crear_receta" id="crear_receta" class="datos">
					<input type="hidden" name="action" value="addProductoDetalle">



					<div class="wd30">
						<label>Nombre de la Receta</label>
						<input type="tex" name="nombr_rece" id="nombr_rece" placeholder="Nombre Recetas" maxlength="30" class="letras" required>
					</div>
					<div class="wd60" style="align-self: center;">
						<h4 id="msg_error" class="msg_error" hidden>La cantidad mínima permitida es de 15 lbs.</h4>
					</div>

					<div class="wd30">
						<label for="rol">Ingrediente:</label>
						<?php
						$query_rol = mysqli_query($conexion, "SELECT * FROM tipo_cortes");

						$result_rol = mysqli_num_rows($query_rol);

						?>
						<select name="rol" id="rol" required>
							<?php
							?>
							<option value="">Seleccionar Ingrediente</option>
							<?php
							if ($result_rol > 0) {
								while ($rol = mysqli_fetch_array($query_rol)) {
							?>
									<option value="<?php echo $rol["id_cortes"]; ?>"><?php echo $rol["cortes"] ?></option>
							<?php
								}
							}

							?>

						</select>
					</div>
					<div class="wd30">
						<label>Cantidad</label>
						<input type="text" name="cantidad_rece" id="cantidad_rece" placeholder="Cantidad en libra" min="15" onkeyup="cr_check()" maxlength="10" class="solo-numero" required>
					</div>
					<div class="wd30">
						<input id="add_btn_lista" type="submit" value="Agregar A La Lista" class="btn_guardar" style="width: auto; padding: 10px;" disabled>
					</div>




				</form>
				<h1 class="v-margin">Lista de Ingredientes</h1>

				<table>
					<thead>
						<tr style="background: #325459 !important;">
							<th class="textcenter" width="100px">Items</th>
							<th class="textcenter">Ingrediente</th>
							<th class="textcenter" width="100px">Cantidad</th>
							<th class="textcenter">Acciones</th>
						</tr>
					</thead>
					<tbody id="detalle_venta" onchange="viewProcesar()">
						<!--contenido desde lista_receta-->
					</tbody>
				</table>
				<div>
					<h4 id="msg_error_ing" class="msg_error v-margin" hidden>Cantidad mínima de ingredientes es 2.</h4>
					<input type="submit" value="Crear Receta" class="btn_guardar" id="crear_receta22" style="display: none; width: auto; padding: 10px;">
				</div>

			</div>
	</section>

	<script type="text/javascript">
		$(document).ready(function() {
			var usuarioid = '<?php echo $_SESSION['idUser']; ?>';
			searchForDetalle(usuarioid);
		});


		function cr_check() {
			cant = document.getElementById('cantidad_rece').value;
			submit_form = document.getElementById('add_btn_lista');
			mensaje = document.getElementById('msg_error');
			if (cant >= 15) {
				submit_form.disabled = false;
				mensaje.hidden = true;
			} else {
				submit_form.disabled = true;
				mensaje.hidden = false;
			}
		}

		function viewProcesar() {
			if ($("#detalle_venta tr").length >= 2) {
				$("#crear_receta22").show();
				$("#msg_error_ing").hide();
				
			} else {
				$("#crear_receta22").hide();
				$("#msg_error_ing").show();
			}
		}
	</script>
</body>

</html>
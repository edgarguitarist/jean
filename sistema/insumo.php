<?php
session_start();
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

	<section id="container">
		<div class="form_register">
			<h1>Registrar Insumo</h1>
			<hr>
			<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

			<form class="form_register5" action="" method="post">
				<h1 class="full-width">Datos</h1>
				<label for="">Nombre de Insumo:</label>
				<input type="text" name="tip_mat_prim" id="tip_mat_prim" placeholder="Ingrese Insumo" maxlength="20" required="" class="letras">
				<input type="submit" value="Crear Materia Prima" class="btn_guardar_usuario full-width" style="width: auto; padding: 10px;">
			</form>
		</div>
	</section>
	</section>
</body>

</html>
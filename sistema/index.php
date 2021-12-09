<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2 && $_SESSION['rol'] != 3) {
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sistema de Producción</title>
	<script>
		function closeModal() {
			$('.modal').fadeOut();
		}
	</script>
</head>

<body>
	<?php include "includes/header.php"; ?>
	<script type="text/javascript" src="funciones.js"></script>
	<section id="container">
		<div class="container_index">
			<h1>Bienvenido al Sistema de Embutidos Jossy</h1>
			<img src="img/embj.jpg" width="35%" alt="LOGO">
		</div>
	</section>
</body>

</html>
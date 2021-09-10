<?php
session_start();
if ($_SESSION['rol'] != 1 and $_SESSION['rol'] != 2 and $_SESSION['rol'] != 3) {
	header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<?php include "includes/scripts.php"; ?>
	<title>Sisteme Produccion</title>
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
			<h1>Bienvenido Al Sistema De Embutidos Jossy</h1>
			<img src="img/embj.jpg" width="35%" alt="LOGO">
		</div>
	</section>
</body>

</html>
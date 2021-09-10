<?php 
session_start();

if ($_SESSION['rol'] !=1 AND $_SESSION['rol'] !=2 AND $_SESSION['rol'] !=3 )  {
	header("location: login.php");
}
include "conexion.php";
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php";?>
  <title>Sistema de Producción</title>
</head>
<body>
  <?php include "includes/header.php";?>
 
	<section id="container">
		<h1>Bienvenido al sistema</h1>;
		<img src="img/construccion.JPG" alt="index">
	</section>
</body>
</html>
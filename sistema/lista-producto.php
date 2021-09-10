<?php 
 session_start(); 

if ($_SESSION['rol'] !=1) {
	header("location: login.php");
}

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

		<h1>Bienvenido al sistema</h1>
		<div class="datos_cliente">
			<div class="action_cliente">
			</div>
			<div class="datos1">
				<div class="wd30">
 					<label>Nombre de la Receta</label>
 					<input type="tex" name="ced_proveedor" id="ced_proveedor" placeholder="Ingrese Nombre de la Nueva Receta" maxlength="10" class="letras" required>
 				</div>
 				<div class="wd30">
 					<label>Nombre de la Receta</label>
 					<input type="tex" name="ced_proveedor" id="ced_proveedor" placeholder="Ingrese Nombre de la Nueva Receta" maxlength="10" class="letras" required>
 				</div>
 				<div class="wd30">
 					<label>Nombre de la Receta</label>
 					<input type="tex" name="ced_proveedor" id="ced_proveedor" placeholder="Ingrese Nombre de la Nueva Receta" maxlength="10" class="letras" required>
 				</div>

                    
                   	
                   		
			</div>
		</div>
		
	</section>
</body>
</html>
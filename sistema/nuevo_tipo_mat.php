<?php 
session_start();
if ($_SESSION['rol'] !=1) {
	header("location: login.php");
}

include "conexion.php";
if (!empty($_POST))
{

	$alert='';
     if(empty($_POST['tip_mat_prim']))
     {
     	$alert='<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
     }else{



$tip_mat_pri      =  $_POST['tip_mat_prim'];



$verificar = mysqli_query($conexion,"SELECT * FROM tipo_mat WHERE nom_tip_mat = '$tip_mat_pri'");

$result = mysqli_fetch_array($verificar);

if($result > 0){
	$alert='<p class="msg_error">La Materia Prima ya Existe</p>';	
}else{
	$insert = mysqli_query($conexion,"INSERT INTO tipo_mat(nom_tip_mat) 
		VALUES('$tip_mat_pri')");

if($insert){
	$alert='<p class="msg_guardar">Materia Prima Registrado Correctamente.</p>';
}else{
	$alert='<p class="msg_error">Error Al Registrar Materia Prima.</p>';
     }

   }
  }
}


 ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  
  <?php include "includes/scripts.php";?>
  <title>Sistema de Producción</title>
</head>
<body>
  <?php include "includes/header.php";?>
 <script type="text/javascript" src="funciones.js"></script>
		<section id="container">

 	   <div class="form_register">
 		<h1>Registrar Tipo de Materia Prima</h1>
 		<hr>
 		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

 		<form class="form_register5" action="" method="post">
 			<h1>Datos</h1>
 			    <label for="">Tipo de Materia Prima:</label>
				<input type="text" name="tip_mat_prim" id="tip_mat_prim" placeholder="Ingrese Tipo" maxlength="20" required="" class="letras">
				<br>
                
				
				<input type="submit" value="Crear Materia Prima" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
		</form>
	</div>
	</section>
	
</body>
</html>
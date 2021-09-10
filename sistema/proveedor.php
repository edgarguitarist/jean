<?php 
session_start();

if ($_SESSION['rol'] !=1 AND $_SESSION['rol'] !=2)  {
	header("location: login.php");
}
include "conexion.php";
if (!empty($_POST))
{

	$alert='';
     if(empty($_POST['cedula']) || empty($_POST['nombre']) || empty($_POST['apellido']) || empty($_POST['celular']) || empty($_POST['direccion']) || empty($_POST['correo']) || empty($_POST['ruc_empresa']))
     {
     	$alert='<p class="msg_error">Los Campos Asingados Son Obligatorio</p>';
     }else{



$cedula_prove      = $_POST['cedula'];
$nombre_prove      = ucwords($_POST['nombre']);
$apellido_prove    = ucwords($_POST['apellido']);
$celular_prove     = $_POST['celular'];
$correo_prove      = $_POST['correo'];
$direccion_prove   = ucwords($_POST['direccion']);
$ruc_empe          = $_POST['ruc_empresa'];
$razon_emp         = ucwords($_POST['razon_empresa']);
$nombre_emp        = ucwords($_POST['nombre_empresa']);
$direccion_emp     = ucwords($_POST['direccion_empresa']);
$correo_emp        = $_POST['correo_empresa'];
$telefono_emp      = $_POST['telefono_empresa'];
$tipo_prove    	   = $_POST['tipo_proveedor'];
$usua_id           = $_SESSION['idUser'];

$verificar = mysqli_query($conexion,"SELECT * FROM proveedor WHERE ced_pro = '$cedula_prove' OR  ruc_emp = '$ruc_empe'");

$result = mysqli_fetch_array($verificar);

if($result > 0){
	$alert='<p class="msg_error">El Usuario O Cedula ya Existe</p>';	
}else{
	$insert = mysqli_query($conexion,"INSERT INTO proveedor(ced_pro,nom_pro,ape_pro,cel_pro,cor_pro,dir_pro,ruc_emp,raz_emp,nom_emp,dir_emp,cor_emp,tel_emp,id_tip_emp,id_usu) 
		VALUES('$cedula_prove','$nombre_prove','$apellido_prove','$celular_prove','$correo_prove','$direccion_prove','$ruc_empe','$razon_emp','$nombre_emp','$direccion_emp','$correo_emp','$telefono_emp','$tipo_prove','$usua_id')");
	
if($insert){
	$alert='<p class="msg_guardar">Proveedor Registrado Correctamente.</p>';
}else{
	$alert='<p class="msg_error">Error Al Registrar Proveedor.</p>';
     }

   }
  }
 
}


 ?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
 
  <?php include "includes/scripts.php";?>
  
  <title>Registro De Proveedor</title>
</head>
<body>
      <?php include "includes/header.php";?>
 <script type="text/javascript" src="funciones.js"></script>
     <section id="container">

 	   <div class="form_register">
 		<h1>Registro Proveedor</h1>
 		<hr>
 		<div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>

 		<form action="" method="post"  autocomplete="nope">
			<h1 class="full-width">Datos De Contacto</h1>
			<p>
 			    <label for="">Cedula De Contacto:</label>
				<input type="text" name="cedula" id="cedula" placeholder="Ingrese Cedula" maxlength="10" class="solo-numero" onblur="validar1()" autofocus required>
				<label id="salida"style="color:red; font-size:1em; font-weight: bold;" ></label>
			</p>
                
			<p>
				<label for="">Nombre De Contacto:</label>
				<input type="text" name="nombre" id="nombre" placeholder="Ingrese Nombre De Contacto" maxlength="30" class="letras" required>
			</p>
			<p>
				<label for="">Apellido De Contacto:</label>
				<input type="text" name="apellido" id="apellido" placeholder=" Ingrese Apellido" maxlength="30" class="letras" required>
			</p>
			<p>
				<label for="">Celular De Contacto:</label>
				<input type="text" name="celular" id="celular" placeholder=" Ingrese Acelular" maxlength="10" class="solo-numero" required>
			</p>
			<p>
				<label for="">Correo De Contacto:</label>
				<input type="email" name="correo" id="correo" placeholder="Ingrese Correo electronico" maxlength="60" required>
			</p>
			<p>
				<label for="">Direcion De Contacto:</label>
				<input type="text" name="direccion" id="direccion" placeholder=" Ingrese direccion De Contacto" maxlength="120" required>
			</p>
			<h1 class="full-width">Datos De La Empresa</h1>
			<p>
				<label for="">Ruc Empresa:</label>
				<input type="text" name="ruc_empresa" id="ruc_empresa" placeholder=" Ingrese Ruc Empresa" maxlength="13" class="solo-numero" onblur="validar()" required> 
			</p>
			<p>
				<label for="">Razon Social:</label>
				<input type="text" name="razon_empresa" id="razon_empresa" placeholder=" Ingrese Razon Social" maxlength="60" required>
			</p>
			<p>
				<label for="">Nombre De Empresa:</label>
				<input type="text" name="nombre_empresa" id="nombre_empresa" placeholder=" Ingrese Nombre De Empresal" maxlength="60" required>
			</p>
			<p>
				<label for="">Telefono De Empresa:</label>
				<input type="text" name="telefono_empresa" id="telefono_empresa" placeholder=" Ingrese Telefono De Empresa" maxlength="10" class="solo-numero" required>
			</p>
			<p class="full-width">
				<label for="Direccion De Empresa">Direccion De Empresa:</label>
				<input type="text" name="direccion_empresa" id="direccion_empresa" placeholder=" Ingrese Direccion De Empresa" maxlength="120" required>
			</p>
			<p>
				<label for="">Correo De Empresa:</label>
				<input type="email" name="correo_empresa" id="correo_empresa" placeholder=" Ingrese Correo De Empresa" maxlength="60" required>
			</p>
			
			<p>

				<label for="Tipo De Proveedor">Tipo De Proveedor:</label>
				 <?php 
                $query_tipo = mysqli_query($conexion,"SELECT * FROM tipo_empresa");
                
                $result_tipo = mysqli_num_rows($query_tipo);

                ?>
				<select name="tipo_proveedor" id="tipo_proveedor" required>
					<?php
						 ?>
						 <option value="">Seleccionar Tipo</option>
					<?php
					if($result_tipo > 0)
					{
						while($tipo = mysqli_fetch_array($query_tipo)){
							?>
							<option value="<?php echo $tipo["id_tip_emp"]; ?>"><?php echo $tipo["nom_tip_emp"] ?></option>
					<?php
						}
                             
					}	
					
					?>
					
				</select>
				</p>
			<p class="full-width">
				<input type="submit" value="Crear Proveedor" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
			</p>
			
 		</form>



 	</div> 


 </section>


</body>
</html>
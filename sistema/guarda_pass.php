<?php
	
	include 'conexion.php';
	function validaPassword($var1, $var2)
	{
		return strcmp($var1, $var2) !== 0 ? false : true;
	}
	
	$idus = base64_decode($_POST['idus']);
	$password = $_POST['password'];
	$con_password = $_POST['con_password'];
	
	if(validaPassword($password, $con_password))
	{
		$consulta="UPDATE usuario SET cla_usu = '{$password}' WHERE cor_usu = '{$idus}'";
		$resultado=mysqli_query($conexion,$consulta);
			if($consulta){
				header('Location: login.php?info=success');
			}else{
				header('Location: change_pass.php?idus='.$_POST['idus'].'&info=error');
				echo "No se Pudieron Actualizar los Datos";	
				mysqli_close($conexion);
			}
		} else {
		header('Location: change_pass.php?idus='.$_POST['idus'].'&info=warning');
		echo 'Las contraseñas no coinciden';
		
	}

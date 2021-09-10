<?php
	$conexion=mysqli_connect("localhost","root","","jossyem1_tesis_embutido");
	
	//if(!$conexion){echo "ERROR AL CONCECTAR CON LA BASE DE DATOS";}
	//else{echo "CONECTADO A LA BASE DE DATOS";}
	date_default_timezone_set('America/Guayaquil'); 
	$fecha= date("d-m-Y");
	$hoy = date("Y-m-d");
	$hora= date("h:i") . " " . date("A");
?>

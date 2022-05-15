<?php
	// $conexion=mysqli_connect("localhost","u103247758_jossyemb",">6tZhb#:4","u103247758_jossyemb");
	$conexion=mysqli_connect("localhost","root","","u103247758_jossyemb");
	
	//if(!$conexion){echo "ERROR AL CONECTAR CON LA BASE DE DATOS";}
	//else{echo "CONECTADO A LA BASE DE DATOS";}
	date_default_timezone_set('America/Guayaquil'); 
	$fecha_base = date("Y-m-d H:i:s");
	$fecha= date("d-m-Y");
	$hoy = date("Y-m-d");
	$hora= date("h:i") . " " . date("A");

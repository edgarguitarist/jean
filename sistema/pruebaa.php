<?php
include "conexion.php";


	
	
	$orde_des = "cha-1";
	
	$queryM = "SELECT  cor_pro FROM orden_despost WHERE lot_mat_pri = '$orde_des'";
	$resultadoM = $conexion->query($queryM);
	$row1 = $resultadoM->fetch_assoc();
	$row2= implode(',',$row1);
	$row3= explode(',', $row2);
	
	$html= "<option value=''>Seleccionar Cortes</option>";
	
	/*
	foreach ($row3);
	{
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html.= "<option value='".$rowM['cor_pro']."'>".$rowM['cor_pro']."</option>";
	}
	*/
	
	
	echo $html;
?>	

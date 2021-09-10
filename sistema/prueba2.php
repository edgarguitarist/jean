<?php
include "conexion.php";

if(isset($_POST['id_estado'])){
	$id_estado = $_POST['id_estado'];
	$queryM = "SELECT id_mat, cod_mat_pri FROM mat_prima WHERE id_tip_mat = '$id_estado' AND estado_mate = 1";
	$resultadoM = $conexion->query($queryM);
	
	$html= "<option value=''>Seleccionar Serie o Lote</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html.= "<option value='".$rowM['id_mat']."'>".$rowM['cod_mat_pri']."</option>";
	}	
	echo $html;
}

if(isset($_POST['id_mat'])){

	$id_mat = $_POST['id_mat'];

    switch ($id_mat) {
        case 1:
            $cod='cha';
            break;
        case 2:
            $cod='chi';
            break;
		case 3:
			$cod='pol';
			break;
		case 4:
			$cod='pav';
			break;
		case 6:
			$cod='pes';
			break;
		default:
			$cod='emb';
			break;
    }


	$queryM = "	SELECT *, SUM(peso) AS SUMA 
				FROM prod_terminado 
				WHERE cod_pro LIKE '%$cod%' 
				GROUP BY cortes
				ORDER BY cortes";
	$resultadoM = $conexion->query($queryM);
	if($cod=='emb'){
		$html= "<option value=''>Seleccionar Embutido</option>";
	}else{
		$html= "<option value=''>Seleccionar Corte</option>";
	}	
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html.= "<option value='".$rowM['SUMA']."'>".$rowM['cortes']."</option>";
	}	
	echo $html;
}

if(isset($_POST['frm'])){
	$temp=0;
	$dif=0;
	$materia=$_POST['materia'];
	$peso=$_POST['peso'];
	$corte=$_POST['corte'];
	$temp=$peso;
	
	$consulta="SELECT * FROM prod_terminado WHERE cortes='$corte'";
	
	foreach ($conexion->query($consulta) as $tot) {
		$cod_act = $tot['cod_pro'];
		if($temp>0){
			if($tot['peso']>=$temp){
				$dif=$tot['peso']-$temp;
				$sql = mysqli_query($conexion,"UPDATE prod_terminado SET peso = '$dif' WHERE cod_pro='{$cod_act}'");
				$temp=0;
				echo '<h1>Datos Actualizados</h1>';
			}else{
				$temp=$temp-$tot['peso'];
				$sql = mysqli_query($conexion,"UPDATE prod_terminado SET peso = 0 WHERE cod_pro='{$cod_act}'");		
			}
		}		
	}

	if($temp==0){
		$insert = mysqli_query($conexion, "INSERT INTO prod_final(cortes, peso) VALUES('$corte','$peso')");
	}

}

if(isset($_POST['action'])){
	$queryM = "	SELECT *, SUM(peso) AS SUMA 
				FROM prod_terminado 
				WHERE cod_pro LIKE '%emb%' 
				GROUP BY cortes
				ORDER BY cortes";
	$resultadoM = $conexion->query($queryM);
	
	$html= "<option value=''>Seleccionar Embutido</option>";
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html.= "<option value='".$rowM['SUMA']."'>".$rowM['cortes']."</option>";
	}	
	echo $html;
}

?>	

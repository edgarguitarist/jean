<?php
session_start();
include "conexion.php";
///////////////////////////////////////ELIMINAR datos RECETAS///////////////////////////
$id_canta = $_POST['id_cant'];
$id_lista = $_POST['id_list'];



// $queryL = mysqli_query($conexion, "SELECT tmp.nom_rece, tmp.ingr_rece, tmp.cant_rece, t.cortes 
// 	    		FROM lista_receta tmp
// 	    	 INNER JOIN tipo_cortes t ON tmp.ingr_rece = t.id_cortes 
// 	    	 	WHERE tmp.nom_rece = '$id_lista' ;");

$queryL = mysqli_query($conexion, "SELECT tmp.nom_rece, tmp.ingr_rece, tmp.cant_rece, t.cortes, (SELECT IF (SUM(pt.peso) >= pt.cortes , 'Disponible', 'No Disponible') FROM prod_terminado pt WHERE pt.cortes = t.cortes GROUP BY pt.cortes) AS estado, (SELECT SUM(prt.peso) FROM prod_terminado prt WHERE prt.cortes = t.cortes GROUP BY prt.cortes) AS peso_dis FROM lista_receta tmp INNER JOIN tipo_cortes t on tmp.ingr_rece = t.id_cortes WHERE tmp.nom_rece = '$id_lista' ;");
?>

</thead>

<?php
$contador = 0;
$filas = mysqli_num_rows($queryL);
while ($lis = mysqli_fetch_array($queryL)) { 
	$total = ($lis["cant_rece"] * $id_canta)-$lis["peso_dis"];
	if($lis["estado"] == 'Disponible'){
		$contador+=1;
		if ( $total <= $lis["peso_dis"]){
	?>
	<tr>
		<td><?php echo $lis["ingr_rece"]; ?></td>
		<td><?php echo $lis["cortes"]; ?></td>
		<td><?php echo $lis["cant_rece"] * $id_canta; ?></td>
	</tr>
<?php	}else{ $contador-=1;?>
	<tr>
		<td><?php echo $lis["ingr_rece"]; ?></td>
		<td><?php echo $lis["cortes"]; ?></td>
		<td style="width: 20%;" class="error"><?php echo "Faltan " . $total . " lbs.";  ?></td>
	</tr>
<?php		}		
	}else{$contador-=1;?>
		<tr>
			<td><?php echo $lis["ingr_rece"]; ?></td>
			<td><?php echo $lis["cortes"]; ?></td>
			<td style="width: 20%;" class="error"><?php echo "Faltan " . $total . " lbs."; ?></td>
		</tr>
<?php }
}
if($contador==$filas){
	echo "<input id='est_info' type='hidden' value='1'> "; 
	echo "<script>viewRevisar()</script>";
}else{
	echo "<input id='est_info' type='hidden' value='0'>"; 
	echo "<script>viewRevisar()</script>";
}
?>
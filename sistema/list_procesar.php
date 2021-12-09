<?php
session_start();
include "conexion.php";
/////////////////////LISTA DE CORTE A PROCESAR //////////////////
$pro_proc = $_POST['pro_proc'];

$queryL = mysqli_query($conexion, "SELECT cor_pro FROM orden_despost  WHERE  lot_mat_pri = '$pro_proc' ;");
?>



<?php
while ($lis = mysqli_fetch_array($queryL)) {

	$array = explode(',', $lis["cor_pro"]);
	foreach ($array as $values) {

?>
		<tr>
			<td><?php echo $values; ?></td>
		</tr>

<?php	}
} ?>
<?php
include "conexion.php";

$query = mysqli_query($conexion,"SELECT DATA FROM tabla_balanza ");
$result = mysqli_fetch_array($query);

if($result['DATA'] != 0){
    echo $result['DATA'];
}

?>	

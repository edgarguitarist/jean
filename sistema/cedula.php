<?php

require 'conexion.php';
$contador=0;
if (isset($_POST['ced_usu'])){
    $ced_usu = $_POST['ced_usu'];
    $consulta="SELECT * FROM usuario WHERE ced_usu= '{$ced_usu}'";
    $resultado=mysqli_query($conexion,$consulta);
    $contador = mysqli_num_rows($resultado);
}else if(isset($_POST['ced_pro'])){
    $ced_pro = $_POST['ced_pro'];
    $consulta2="SELECT * FROM proveedor WHERE ced_pro= '{$ced_pro}'";
    $resultado2=mysqli_query($conexion,$consulta2);
    $contador = mysqli_num_rows($resultado2);
}
    if($contador>0){
       echo '1';
    }
?>
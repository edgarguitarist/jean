<?php

require 'conexion.php';
$contador=0;
if (isset($_POST['correo_usu'])){
    $correo_usu = $_POST['correo_usu'];
    $consulta="SELECT * FROM usuario WHERE cor_usu= '{$correo_usu}'";
    $resultado=mysqli_query($conexion,$consulta);
    $contador = mysqli_num_rows($resultado);
}else if(isset($_POST['correo_pro'])){
    $correo_pro = $_POST['correo_pro'];
    $consulta2="SELECT * FROM proveedor WHERE cor_pro= '{$correo_pro}'";
    $resultado2=mysqli_query($conexion,$consulta2);
    $contador = mysqli_num_rows($resultado2);
}
    if($contador>0){
       echo '1';
    }
?>
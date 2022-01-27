<?php
session_start();
if ($_SESSION['rol'] != 1) {
    header("location: login.php");
}
include "conexion.php";

if (isset($_GET['id']) && isset($_GET['who'])) {
    $id = $_GET['id'];
    $who = $_GET['who'];
    
    if($who == 'usuario'){
        $query_res = mysqli_query($conexion, "UPDATE usuario SET estado = 1 WHERE id_usu = $id");
        mysqli_close($conexion);
        if ($query_res) {
            header("location: lista-usuario.php?success=true");
        } else {
            echo "Error Al Eliminar al Usuario";
        }
    }elseif($who == 'proveedor'){
        $query_res = mysqli_query($conexion, "UPDATE proveedor SET estado = 1 WHERE id_prov = $id");
        mysqli_close($conexion);
        if ($query_res) {
            header("location: lista-proveedor.php?success=true");
        } else {
            echo "Error Al Eliminar al proveedor";
        }
    }else{
        header("location: index.php");
    }
}else{
    header("location: index.php");
}

?>

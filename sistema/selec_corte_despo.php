<?php
include "conexion.php";

$conter=0;
$orde_des = $_POST['orde_des'];
// $orde_des = 'Cha-22'; //entrada de prueba

$queryM = "SELECT lot_mat_pri, cor_pro FROM orden_despost WHERE lot_mat_pri = '$orde_des'";
$resultadoM = $conexion->query($queryM);

$html= "<option selected disabled value=''>Seleccionar Producto</option>";

while($rowM = $resultadoM->fetch_assoc())
{
    $array = explode(',', $rowM["cor_pro"]);
    
    foreach ($array as $values)
    { 
        $queryN = "SELECT * FROM prod_terminado WHERE cod_pro = '$orde_des' AND cortes= '$values'";
        $resultadoN = $conexion->query($queryN);
        $contador = mysqli_num_rows($resultadoN);
        //Si existe "si devuelve un resultado entonces no lo muestra"
        if($contador > 0){
            $html.= "";
        }else{
            $html.= "<option value='".$values."'>".$values."</option>";
            $conter+=1;
        }
        //preguntar en prod_terminado 
    }
}

/* 
if ($conter==0){

    //Si ya no hay cortes que mostrar entonces deja de mostrarse ese producto
    $consulta="UPDATE prod_procesar Set estado_prod_pro=0 Where cod_pro='{$orde_des}'";
    $resultadot=mysqli_query($conexion,$consulta);
}

*/
echo $html;
?>  



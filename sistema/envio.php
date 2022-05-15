<?php
include 'conexion.php';
$val = '';
session_start();
date_default_timezone_set('America/Guayaquil'); 
$fecha_base = date("Y-m-d H:i:s");

if (isset($_POST['s1des'])) {
    $s1des = $_POST['s1des'];
    $s2des = $_POST['s2des'];
    $regs1 = $s1des;

    $consultas2 = "SELECT cod_mat_pri FROM mat_prima WHERE id_mat= '{$s2des}'";
    $resultados2 = mysqli_query($conexion, $consultas2);
    $regs2 = mysqli_fetch_array($resultados2);

    if (isset($_POST['checkbox'])) {
        if (is_array($_POST['checkbox'])) {
            $checkbox = $_POST['checkbox'];
            $checkbox = implode(",", $checkbox);
            $regs3 = $checkbox;
        }
        //$check = substr($val, 0, -1); //quitamos la ultima coma
        $insert = "INSERT INTO orden_despost(tip_mat_pri,lot_mat_pri,cor_pro,fec_despo) VALUES ('{$regs1[0]}','{$regs2[0]}','{$regs3}', '$fecha_base')";
        $resultado_insert = mysqli_query($conexion, $insert);
        if ($resultado_insert) {
            //success    
            //echo '<br><br><h1>Datos Agregados</>'; 
            $array = explode(',', $regs3);
            foreach ($array as $values) {
                echo $values . ' ';
            }
            echo '<br> El numero de cortes seleccionados es ' . count($array);
            $consulta = "UPDATE mat_prima Set estado_mate=0 Where id_mat='{$s2des}'";
            $resultadot = mysqli_query($conexion, $consulta);
        } else {
            //error
            mysqli_close($conexion);
        }
    } else {
        $insert = "INSERT INTO orden_despost(tip_mat_pri,lot_mat_pri,fec_despo) VALUES ('{$regs1[0]}','{$regs2[0]}','$fecha_base')";
        $resultado_insert = mysqli_query($conexion, $insert);
        if ($resultado_insert) {
            //success  
            //echo '<br><br><h1>Datos Agregados</>';  
            $array = explode(',', $check);
            foreach ($array as $values) {
                echo $values . ' ';
            }
            echo '<br> El numero de cortes seleccionados es ' . count($array);
            $consulta = "UPDATE mat_prima Set estado_mate=0 Where id_mat='{$s2des}'";
            $resultadot = mysqli_query($conexion, $consulta);
        } else {
            //error
            mysqli_close($conexion);
        }
    }
} elseif (isset($_POST['selpro'])) {
    $conter = 0;
    $selordpro = $_POST['selordpro'];
    $selpro = $_POST['selpro'];
    $peso_lle = $_POST['peso_lle'];

    $insert = "INSERT INTO prod_terminado(cod_pro, cortes, peso, peso_restante, id_usu,fecha_ingre) VALUES ('{$selordpro}','{$selpro}','{$peso_lle}','{$peso_lle}','{$_SESSION['idUser']}', '$fecha_base')";
    $resultado_insert = mysqli_query($conexion, $insert);

    //Actualizacion de productos
    $queryM = "SELECT lot_mat_pri, cor_pro FROM orden_despost WHERE lot_mat_pri = '$selordpro'";
    $resultadoM = $conexion->query($queryM);

    //$html= "<option selected disabled>Seleccionar Serie o Lote</option>";

    while ($rowM = $resultadoM->fetch_assoc()) {
        $array = explode(',', $rowM["cor_pro"]);

        foreach ($array as $values) {
            $queryN = "SELECT * FROM prod_terminado WHERE cod_pro = '$selordpro' AND cortes= '$values'";
            $resultadoN = $conexion->query($queryN);
            $contador = mysqli_num_rows($resultadoN);
            //Si existe "si devuelve un resultado entonces no lo muestra"
            if ($contador > 0) {
                //$html.= "";
            } else {
                //$html.= "<option value='".$values."'>".$values."</option>";
                $conter += 1;
            }
            //preguntar en prod_terminado 
        }
    }

    if ($conter == 0) {

        //Si ya no hay cortes que mostrar entonces deja de mostrarse ese producto
        $consulta = "UPDATE prod_procesar Set estado_prod_pro=0 Where cod_pro='{$selordpro}'";
        $resultadot = mysqli_query($conexion, $consulta);
    }
} elseif (isset($_POST['proemb'])) {
    $conter = 0;
    $selordpro = $_POST['selordpro'];
    $peso_lle = $_POST['peso_lle'];
    $cantidad = $_POST['cantidad'];

    $flag = 0;
    $sep = '-';
    $val = 1;
    $Let = 'emb';

    foreach ($conexion->query("SELECT * FROM prod_terminado WHERE cod_pro LIKE '%emb%'") as $nom) {
        $Let = substr($nom['cod_pro'], 0, 3);
    }



    while ($flag == 0) {
        $aux = $val;
        $Codigo = $Let . $sep . $aux;
        $consulta = "SELECT * FROM prod_terminado WHERE cod_pro= '{$Codigo}'";
        $resultado = mysqli_query($conexion, $consulta);
        $contador = mysqli_num_rows($resultado);

        if ($contador == 1) {
            //mysqli_close($conexion); // SE CIERRA LA CONEXION
            $val = $val + 1;
            $salida = 'NADA';
        } else { // SI NO EXISTE SE HACE EL REGISTRO
            $salida = $Let . $sep . $aux;
            $flag = 1;
        }
    }

    $insert = "INSERT INTO prod_terminado(cod_pro, cortes, peso, peso_restante, cantidad, id_usu,fecha_ingre) VALUES ('{$salida}','{$selordpro}','{$peso_lle}','{$peso_lle}','{$cantidad}','{$_SESSION['idUser']}', '$fecha_base')";
    $resultado_insert = mysqli_query($conexion, $insert);

    //REVISAR DONDE DEBE ESTAR LA ACTUALIZACION

    $consulta = "UPDATE orden_embut Set estado=0 Where nom_ord='{$selordpro}'";
    $resultadot = mysqli_query($conexion, $consulta);
}

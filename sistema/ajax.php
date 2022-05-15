<?php
session_start();
include "conexion.php";
date_default_timezone_set('America/Guayaquil'); 
$fecha_base = date("Y-m-d H:i:s");

if (!empty($_POST)) {
  //buscar proveedor//
  if ($_POST['action'] == 'searchProveedor') {

    if (!empty($_POST['cliente'])) {
      $cedu_prove = $_POST['cliente'];

      ////////////////////////

      $query = mysqli_query($conexion, "SELECT *, ( SELECT nom_tip_emp FROM tipo_empresa WHERE id_tip_emp = pro.id_tip_emp ) AS tipo FROM proveedor pro WHERE pro.ced_pro = '$cedu_prove' AND pro.estado = 1");
      $result = mysqli_num_rows($query);
      $data = '';
      if ($result > 0) {
        $data = mysqli_fetch_assoc($query);
      } else {
        $data = 0;
      }
      echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    exit;
  }

  ///////////////////////////////////
  //REGISTRAR MATERIA PRIMA//// 
  if ($_POST['action'] == 'addCliente') {
    $id_proveed = $_POST['idproveedor'];
    if($id_proveed==''){
      $id_proveed =1;
    }
    $tipo_mate  = $_POST['tipo_mate'];
    $peso_llega = $_POST['peso_lle'];
    $id_usuar   = $_SESSION['idUser'];

    $flag = 0;
    $sep = '-';
    $val = 1;
    $Let='Null';

    foreach ($conexion->query("SELECT * FROM tipo_mat WHERE id_tip_mat= '{$tipo_mate}'") as $nom) {
      $Let = substr($nom['nom_tip_mat'], 0, 3);
    };

    //echo $Let;
    
    while ($flag == 0) {
      $aux = $val;
      $Codigo = $Let . $sep . $aux;
      $consulta = "SELECT * FROM mat_prima WHERE cod_mat_pri= '{$Codigo}'";
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

    //debug_to_console('sal '.$salida.'pro '.$id_proveed.'tip '.$tipo_mate.'pes '.$peso_llega.'us '.$id_usuar);

    $insert = mysqli_query($conexion,"INSERT INTO mat_prima (cod_mat_pri,id_prov,id_tip_mat,peso_lle,id_usu, fech_reg_mat) 
            VALUES('$salida','$id_proveed','$tipo_mate','$peso_llega','$id_usuar', '$fecha_base')");
    echo "Registro de Materia Prima Correcto!";
    exit;   
  }
  exit;
}

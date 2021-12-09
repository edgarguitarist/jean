<?php
session_start();
include "conexion.php";

function console_log($data)
{
  echo '<script>';
  echo 'console.log(' . json_encode($data) . ')';
  echo '</script>';
}

if (!empty($_POST)) {



  //Agregar a Receta//// 
  if ($_POST['action'] == 'addProductoDetalle') {
    if (empty($_POST['producto']) || empty($_POST['cantidad']) || empty($_POST['nom_re'])) {
      echo 'error falta un dato';
    } else {

      $codproducto = $_POST['producto'];
      $cantidad = $_POST['cantidad'];
      $nom_rece = $_POST['nom_re'];
      $token = $_SESSION['idUser'];

      $query_detalle_temp = mysqli_query($conexion, "CALL add_tempo_lista_receta($codproducto,$cantidad,'$nom_rece','$token')");
      $result = mysqli_num_rows($query_detalle_temp);

      $detalleTabla = '';
      $arrayData = array();
      console_log($query_detalle_temp);
      
      if ($result > 0) {

        while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
          $detalleTabla .= '<tr>                
            <td colspan="1" >' . $data['id_cortes'] . '</td>
            <td class="textcenter">' . $data['cortes'] . '</td>
            <td class="textcenter">' . $data['cant'] . '</td>
            <td>
                <a class="link_delete" href="#" onclick="event.preventDefault();
                    del_tempo_lista_receta(' . $data['correlativo'] . ');">Eliminar</a>
            </td>
            </tr>';
        }
        $arrayData['detalle'] = $detalleTabla;


        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
        //echo $detalleTabla;
      } else {
        echo 'error3 no se obtuvo resultado de llamada';
      }
    }
    exit;
  }





  ///////////////////////////////////////extrar datos///////////////////////////
  if ($_POST['action'] == 'searchForDetalle') {
    if (empty($_POST['user'])) {
      echo 'error1serch';
    } else {

      $token = $_SESSION['idUser'];

      $query = mysqli_query($conexion, "SELECT tmp.correlativo, tmp.id_cortes, tmp.cant, p.cortes, tmp.no_rece FROM tempo_lista_receta tmp
                                                 INNER JOIN tipo_cortes p
                                                 ON tmp.id_cortes = p.id_cortes
                                                 WHERE tmp.token_user = token_user;  ");
      /////////////extraer nombre////////////////////////////





      //////////////mostrar datos//////
      $result = mysqli_num_rows($query);


      $detalleTabla = '';
      $arrayData = array();

      if ($result > 0) {

        while ($data = mysqli_fetch_assoc($query)) {
          $nom_re = $data['no_rece'];
          $detalleTabla .= '<tr>        
              <td colspan="1" >' . $data['id_cortes'] . '</td>
              <td class="textcenter">' . $data['cortes'] . '</td>
              <td class="textcenter">' . $data['cant'] . '</td>
              <td>
                  <a class="link_delete" href="#" onclick="event.preventDefault();
                      del_tempo_lista_receta(' . $data['correlativo'] . ');">Eliminar</a>
              </td>
          </tr>';
        }

        $detalleNom = $nom_re;

        $arrayData['detalle'] = $detalleTabla;
        $arrayData['totales'] = $detalleNom;

        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
      } else {
        echo 'error';
      }
    }
    exit;
  }




  ///////////////////////////////////////ELIMINAR datos RECETAS///////////////////////////
  if ($_POST['action'] == 'delProductoDetalle') {
    if (empty($_POST['id_detalle'])) {
      echo 'error';
    } else {
      $id_detalle = $_POST['id_detalle'];
      $token = $_SESSION['idUser'];


      $query_detalle_temp = mysqli_query($conexion, "CALL del_tempo_lista_receta($id_detalle,'$token')");
      $result = mysqli_num_rows($query_detalle_temp);


      $detalleTabla = '';
      $arrayData = array();

      if ($result > 0) {

        while ($data = mysqli_fetch_assoc($query_detalle_temp)) {
          $detalleTabla .= '
          <tr>                 
            <td colspan="1" >' . $data['id_cortes'] . '</td>
            <td class="textcenter">' . $data['cortes'] . '</td>
            <td class="textcenter">' . $data['cant'] . '</td>    
            
            <td>
                <a class="link_delete" href="#" onclick="event.preventDefault();
                    del_tempo_lista_receta(' . $data['correlativo'] . ');">Eliminar</a>
                
            </td>

        </tr>';
        }
        $arrayData['detalle'] = $detalleTabla;

        echo json_encode($arrayData, JSON_UNESCAPED_UNICODE);
      } else {
        echo 'error';
      }
    }
    exit;
  }

  ////////////////////////LIMPIAR LISTA////////////////////////////////

  if ($_POST['action'] == 'anularventa') {

    $token = $_SESSION['idUser'];

    $query_del = mysqli_query($conexion, "DELETE FROM tempo_lista_receta WHERE token_user='$token' ");
    if ($query_del) {
      echo 'ok';
    } else {
      echo 'error';
    }
    exit;
  }
  ////////////////////////PROCESAR LISTA////////////////////////////////


  if ($_POST['action'] == 'procesarLista') {

    $token = $_SESSION['idUser'];

    $query = mysqli_query($conexion, "SELECT * FROM tempo_lista_receta WHERE token_user = '$token' ");
    $result = mysqli_num_rows($query);

    //////////////
    //console_log($query);
    //echo $result; //Si da respuesta
    if ($result > 0) {
      $query_procesar = mysqli_query($conexion, "CALL procesar_lista('$token')");
      $result_detalle = mysqli_num_rows($query_procesar);
      //console_log($query_procesar);
      echo $query_procesar;
      //console_log($result_detalle);
      echo $result_detalle;
      if ($result_detalle > 0) {
        $data = mysqli_fetch_assoc($query_procesar);
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
      } else {
        echo "error1pro";
      }
    } else {
      echo "error2 pro";
    }
    exit;
  }
  ///////////// agregar materia prima con modal ////////////////
  if ($_POST['action'] == 'addMateriaPrima') {

    if (empty($_POST['tip_mat_prim'])) {
      $html = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
    } else {

      $tip_mat_pri = $_POST['tip_mat_prim'];

      $verificar = mysqli_query($conexion, "SELECT * FROM tipo_mat WHERE nom_tip_mat = '$tip_mat_pri'");

      $result = mysqli_fetch_array($verificar);
      if ($result > 0) {
        $html = '<p class="msg_error">La Materia Prima ya Existe</p>';
      } else {
        $insert = mysqli_query($conexion, "INSERT INTO tipo_mat(nom_tip_mat) 
      VALUES('$tip_mat_pri')");
        if ($insert) {
          $html = '<p class="msg_guardar">Materia Prima fue Registrada Correctamente.</p>';
        } else {
          $html = '<p class="msg_error">Error Al Registrar Materia Prima.</p>';
        }
      }
    }
    echo $html;
  }
  ///////////////// agregar corte con modal //////////////////////
  if ($_POST['action'] == 'addCorte') {
    if (empty($_POST['tipo_corte'])) {
      $html = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
    } else {
      $sufijo = $_POST['sufijo'];
      $tipo = ucfirst($_POST['tipo_corte']);
      $tip_cortes = $tipo . ' de ' . $sufijo;
      $codi_tipo_mat = $_POST['rol'];
 
      $verificar = mysqli_query($conexion, "SELECT * FROM tipo_cortes WHERE cortes = '$tip_cortes' AND  tipo_mat_despo = '$codi_tipo_mat'");

      $result = mysqli_fetch_array($verificar);

      if ($result > 0) {
        $html = '<p class="msg_error">El Tipo de Corte ya Existe</p>';
      } else {
        $insert = mysqli_query($conexion, "INSERT INTO tipo_cortes(tipo_mat_despo,cortes) 
      VALUES('$codi_tipo_mat','$tip_cortes')");

        if ($insert) {
          $html = '<p class="msg_guardar">El Tipo de Corte fue Registrado Correctamente.</p>';
        } else {
          $html = '<p class="msg_error">Error Al Registrar Tipo de Corte.</p>';
        }
      }
    }
    echo $html;
  }
}

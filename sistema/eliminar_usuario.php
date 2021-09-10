<?php
session_start();
if ($_SESSION['rol'] !=1) {
  header("location: login.php");
}
     include "conexion.php";

     if (!empty($_POST)) 
     {
      if ($_POST['id_usua'] ==1) {
        header("location: lista-usuario.php");
        mysqli_close($conexion);
        exit;
        }      
       $id_usua =$_POST['id_usua'];
       $query_delete = mysqli_query($conexion,"UPDATE usuario SET estado = 0 WHERE id_usu = $id_usua ");
       mysqli_close($conexion);

       if ($query_delete) {
          header("location: lista-usuario.php");
       }else{
        echo "Error Al Eliminar al Usuario";
       }
     }

     if (empty($_REQUEST['id']) || $_REQUEST['id'] ==1) 
     {
      header("location: lista-usuario.php");
      mysqli_close($conexion);
     }else{
          
          $id_usua = $_REQUEST['id'];
                $query = mysqli_query($conexion,"SELECT u.ced_usu, u.nom_usu, u.usu_usu, r.rol_tip_usu
                FROM usuario u 
                INNER JOIN
                tipo_usuario r 
                on u.cod_tip_usu = r.cod_tip_usu
                WHERE u.id_usu = $id_usua");
                mysqli_close($conexion);

       $result = mysqli_num_rows($query);
       if ($result > 0) {
                  while ($data = mysqli_fetch_array($query)) {
                    $cedu_usu = $data['ced_usu'];
                    $nomb_usu = $data['nom_usu'];
                    $usua_usu = $data['usu_usu'];
                    $rol_usu = $data['rol_tip_usu'];
                  }
                } else{
                  header("location: lista-usuario.php");
                }        
     }






?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php";?>
  <title>Sistema de Producción</title>
</head>
<body>
  <?php include "includes/header.php";?>
 
	<section id="container">
	<div class="data_delete">
    <h2>¿Seguro que desea Eliminar el siguiente Usuario</h2>
    <p>Cedula: <spam><?php echo $cedu_usu; ?></p>
      <p>Nombre: <spam><?php echo $nomb_usu; ?></p>
        <p>Usuario: <spam><?php echo $usua_usu; ?></p>
          <p>Rol: <spam><?php echo $rol_usu; ?></p>
          
          <form method="post" action="">
            <input type="hidden" name="id_usua" value="<?php echo $id_usua; ?>">
            <a href="lista-usuario.php" class="btn_cancel">Cancelar</a>
            <input type="submit" value="Aceptar" class="btn_ok" style="width: auto; padding: 10px;">
          </form>

  </div>
	</section>
</body>
</html>
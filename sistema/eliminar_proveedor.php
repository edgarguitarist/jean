<?php
session_start();
if ($_SESSION['rol'] !=1 && $_SESSION['rol'] !=2) {
  header("location: login.php");
}
     include "conexion.php";

     if (!empty($_POST)) 
     {
          
       $id_prov =$_POST['id_prov'];
       $query_delete = mysqli_query($conexion,"UPDATE proveedor SET estado = 0 WHERE id_prov = $id_prov ");
       mysqli_close($conexion);

       if ($query_delete) {
          header("location: lista-proveedor.php");
       }else{
        echo "Error Al Eliminar al Usuario";
       }
     }

     if (empty($_REQUEST['id']) ) 
     {
      header("location: lista-proveedor.php");
      mysqli_close($conexion);
     }else{
          
          $id_prov = $_REQUEST['id'];
                $query = mysqli_query($conexion,"SELECT u.ced_pro, u.nom_pro, u.ruc_emp, u.nom_emp, r.nom_tip_emp
                FROM proveedor u 
                INNER JOIN
                tipo_empresa r 
                on u.id_tip_emp = r.id_tip_emp
                WHERE u.id_prov = $id_prov");
                mysqli_close($conexion);

       $result = mysqli_num_rows($query);
       if ($result > 0) {
                  while ($data = mysqli_fetch_array($query)) {
                    $cedu_pro = $data['ced_pro'];
                    $nomb_pro = $data['nom_pro'];
                    $ruc_empe = $data['ruc_emp'];
                    $nom_empe = $data['nom_emp'];
                    $tip_empe = $data['nom_tip_emp'];
                  }
                } else{
                  header("location: lista-proveedor.php");
                }        
     }






?>


<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php";?>
  <title>Sistema de Producción</title>
</head>
<body>
  <?php include "includes/header.php";?>
 
	<section id="container">
	<div class="data_delete">
    <h2>¿Seguro que desea Eliminar el siguiente Proveedor?</h2>
    <h2>Contacto</h2>
    <p>Cedula: <span><?php echo $cedu_pro; ?></p>
      <p>Nombre: <span><?php echo $nomb_pro; ?></p>
        <h2>Empresa</h2>
        <p>Ruc Empresa: <span><?php echo $ruc_empe; ?></p>
          <p>Nombre Empresa: <span><?php echo $nom_empe; ?></p>
             <p>Tipo Empresa: <span><?php echo $tip_empe; ?></p>
          
          <form method="post" action="">
            <input type="hidden" name="id_prov" value="<?php echo $id_prov; ?>">
            <a href="lista-proveedor.php" class="btn_cancel">Cancelar</a>
            <input type="submit" value="Aceptar" class="btn_ok" style="width: auto; padding: 10px;">
          </form>

  </div>
	</section>
</body>
</html>
<?php

session_start();
if ($_SESSION['rol'] !=1 AND $_SESSION['rol'] !=2) {
	header("location: login.php");
}

include "conexion.php";

?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <?php include "includes/scripts.php";?>
  <title>Sisteme Produccion</title>
</head>
<body>
  <?php include "includes/header.php";?>
 
	<section id="container">
   <?php 
   $busqueda = ucwords($_REQUEST['busqueda']);
   if (empty($busqueda)) {
   	header("location: lista-proveedor.php");
   	mysqli_close($conexion);
   	# code...
   }


    ?>
		

		<h1>Lista De Proveedor</h1>		
	    <a href="proveedor.php" class="btn_nusuario">Crear Proveedor</a>
	    <form action="buscar_proveedor.php" method="GET" class="form_buscar">
	    	<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
	    	<input type="submit" value="Buscar" class="btn_buscar" style="width: auto; padding: 10px;">

	    </form>
	    <table>
	    	<tr>
	    		<th>ID</th>
	    		<th>Cedula</th>
	    		<th>Apellido</th>
	    		<th>Nombre</th>
	    		<th>Celular</th>
	    		<th>Correo</th>
	    		<th>Direccion</th>
	    		<th>Ruc</th>
	    		<th>Razon Social</th>
	    		<th>Nombre Empresa</th>
	    		<th>Direccion Empresa</th>
	    		<th>Correo Empresa</th>
	    		<th>Telefono Empresa</th>
	    		<th>Tipo Proveedor</th>
	    		<th>Fecha De Registro</th>
	    		<th>Acciones</th>
	    	</tr>
	    	<?php

	   //////////pagina//////
	    	$rol = '';
	    	if ($busqueda == 'carne') {
	    		$rol = "OR id_tip_emp LIKE '%1%' ";
	    	}else if ($busqueda == 'pollo') {
	    		$rol = "OR id_tip_emp LIKE '%2%' ";
	    	}else if ($busqueda == 'chivo') {
	    		$rol = "OR id_tip_emp LIKE '%3%' ";
	    	}
	    		

	    	$sql_registe = mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM proveedor 
	    		WHERE (id_prov LIKE '%$busqueda%'
	    		OR ced_pro LIKE '%$busqueda%' 
	    		OR ape_pro LIKE '%$busqueda%' 
	    		OR nom_pro LIKE '%$busqueda%'
	    		OR cel_pro LIKE '%$busqueda%'
	    		OR cor_pro LIKE '%$busqueda%'
	    		OR dir_pro LIKE '%$busqueda%' 
	    		OR ruc_emp LIKE '%$busqueda%'
	    		OR raz_emp LIKE '%$busqueda%'
	    		OR nom_emp LIKE '%$busqueda%'
	    		OR dir_emp LIKE '%$busqueda%'
	    		OR cor_emp LIKE '%$busqueda%'
	    		OR tel_emp LIKE '%$busqueda%' 
	    		$rol) AND estado = 1");


	    	$result_register = mysqli_fetch_array($sql_registe);
	    	$total_registro = $result_register['total_registro'];

	    	$por_pagina = 10;
	    	if(empty($_GET['pagina']))
	    	 {
	    		$pagina = 1;
	    		}
	    		else{
	    		$pagina = $_GET['pagina'];
	    		}
	    			$desde = ($pagina-1) * $por_pagina;
	    			$total_paginas = ceil($total_registro / $por_pagina); 
	    		
/////////////////////////////


	    	$query = mysqli_query($conexion,"SELECT  u.id_prov, u.ced_pro, u.ape_pro, u.nom_pro, u.cel_pro, u.cor_pro, u.dir_pro, u.ruc_emp, u.raz_emp, u.nom_emp, u.dir_emp, u.cor_emp, u.tel_emp, t.nom_tip_emp, u.fech_reg_pro FROM proveedor u INNER JOIN tipo_empresa t ON u.id_tip_emp = t.id_tip_emp  
	    		WHERE (
	    		    u.id_prov LIKE '%$busqueda%'
		    	 OR u.ced_pro LIKE '%$busqueda%' 
		    	 OR u.ape_pro LIKE '%$busqueda%' 
		    	 OR u.nom_pro LIKE '%$busqueda%'
		    	 OR u.cel_pro LIKE '%$busqueda%' 
		    	 OR u.cor_pro LIKE '%$busqueda%' 
		    	 OR u.dir_pro LIKE '%$busqueda%' 
		    	 OR u.ruc_emp LIKE '%$busqueda%' 
		    	 OR u.raz_emp LIKE '%$busqueda%'
		    	 OR u.nom_emp LIKE '%$busqueda%'
		    	 OR u.dir_emp LIKE '%$busqueda%'
		    	 OR u.cor_emp LIKE '%$busqueda%'
		    	 OR u.tel_emp LIKE '%$busqueda%' 
		    	 OR	u.fech_reg_pro LIKE '%$busqueda%'
		    	 OR	t.nom_tip_emp LIKE '%$busqueda%')
	    		  AND estado = 1 ORDER BY u.id_prov ASC LIMIT $desde,$por_pagina");  
	    	mysqli_close($conexion);

	    	$result = mysqli_num_rows($query);
	    	if($result > 0) {
	    		while ($data = mysqli_fetch_array($query)) {
	    			$formato_fe = 'Y-m-d H:i:s';
	    		$fecha = DateTime::createFromFormat($formato_fe,$data["fech_reg_pro"]);	
	    	?>
	    	 <tr>
	    	 	<td><?php echo $data["id_prov"]; ?></td>
	    		<td><?php echo $data["ced_pro"]; ?></td>
	    		<td><?php echo $data["ape_pro"]; ?></td>
	    		<td><?php echo $data["nom_pro"]; ?></td>
	    		<td><?php echo $data["cel_pro"]; ?></td>
	    		<td><?php echo $data["cor_pro"]; ?></td>
	    		<td><?php echo $data["dir_pro"]; ?></td>	    
	    		<td><?php echo $data["ruc_emp"]; ?></td>
	    		<td><?php echo $data["raz_emp"]; ?></td>
	    		<td><?php echo $data["nom_emp"]; ?></td>
	    		<td><?php echo $data["dir_emp"]; ?></td>
	    		<td><?php echo $data["cor_emp"]; ?></td>
	    		<td><?php echo $data["tel_emp"]; ?></td>
	    		<td><?php echo $data["nom_tip_emp"]; ?></td>
	    		<td><?php echo $fecha ->format('d-m-Y'); ?></td>
	    		<td>
	    			<a class="link_edit" href="editar_proveedor.php?id=<?php echo $data["id_prov"]; ?>">Editar</a>
	    			|
	    			
	    			<?php if($_SESSION['rol'] ==1) {
	    			 ?>
	    			<a class="link_delete" href="eliminar_proveedor.php?id=<?php echo $data["id_prov"]; ?>">Eliminar</a>
	    			<?php  }?>
	    		</td>

	    	</tr>
	    		
	    		<?php
	    	         	}
	    		}
	    	?>
	    </table>

	    <?php 
         if ($total_registro != 0) {
         	# code...
         
	     ?>
	    <div class="pagina">
	    	<ul>
	    		<?php 
	    		if($pagina != 1)
	    		 {

	    		 ?>
	    		<li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
	    		<li><a href="?pagina=<?php echo $pagina-1;  ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>

	    		<?php 
	    		}
	    		for ($i=1; $i <= $total_paginas ; $i++) { 
	    			if($i == $pagina) 
	    			{
	    		  echo '<li class="pageSelected">'.$i.'</li>';
	    			}else{
	    		 	echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
	    		 } 
	    		 }
	    		 if ($pagina !=$total_paginas) {
	    		 
	    		 
	    		 ?>
	    		<li><a href="?pagina=<?php echo $pagina +1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
	    		<li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
				<?php } ?>
	    	</ul>
	    	
	    </div>
	<?php } ?>
	</section>
</body>
</html>
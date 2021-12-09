<?php
include "../conexion.php";


$codigo = $regs2['cod_mat_pri'];
$queryL = mysqli_query($conexion,"SELECT cor_pro FROM orden_despost WHERE lot_mat_pri = '$codigo'");

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Factura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div id="page_pdf">
	<table id="factura_head">
		<tr>
			<td class="logo_factura">
				<div>
					<img src="img/logo.png">
				</div>
			</td>
			<td class="info_empresa">
				
				<div>
					<span class="h2">ORDEN DE DESPOSTE</span>
				</div>
				
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Orden</span>
					<p>No.: <strong><?php echo $regs2['cod_mat_pri']; ?></strong></p>
					<p>Fecha: <?php echo $fecha;?></p>
					<p>Hora: <?php echo $hora;?></p>
				</div>
			</td>
		</tr>
	</table>


	<table id="factura_detalle">
			<thead>
				<tr>			
				
					<th class="textcenter" width="150px">Cortes A Procesar.</th>
		
				</tr>
			</thead>
			<tbody id="detalle_productos" class="textcenter">
           
	    			<?php
	    			while ($lis= mysqli_fetch_array($queryL)) {
                          
                      $array = explode(',', $lis["cor_pro"]);
                      foreach ($array as $values)
                            {

	    				?>
	    				<tr>
	    				<td><?php echo $values; ?></td>
	    			    </tr>

	    		<?php	}}?>	
			</tbody>			
	</table>
</div>
</body>
</html>
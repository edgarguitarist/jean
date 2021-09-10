<?php

	//print_r($_REQUEST);
	//exit;
	//echo base64_encode('2');
	//exit;
	session_start();
	if(empty($_SESSION['active']))
	{
		header('location: ../');
	}

	include "../conexion.php";
	require_once '../pdf/vendor/autoload.php';
	use Dompdf\Dompdf;

	if( empty($_REQUEST['f']) )
	{
		echo "No es posible generar la factura.";
	}else{
	
		
		$noFactura     = $_REQUEST['f'];

///////MOSTRAR EL CÓDIGO DE M.P.////////////////////
    $consultas2="SELECT cod_mat_pri FROM mat_prima WHERE id_mat= $noFactura";
    $resultados2=mysqli_query($conexion,$consultas2);
    $regs2=mysqli_fetch_assoc($resultados2);

     
			ob_start();
		    include(dirname('__FILE__').'/factura.php');
		    $html = ob_get_clean();

			// instantiate and use the dompdf class
			$dompdf = new Dompdf();

			$dompdf->loadHtml($html);
			// (Optional) Setup the paper size and orientation
			$dompdf->setPaper('letter', 'portrait');
			// Render the HTML as PDF
			$dompdf->render();
			// Output the generated PDF to Browser
			$dompdf->stream('Orden Desposte '.$regs2['cod_mat_pri'].'.pdf',array('Attachment'=>0));
			exit;
		}
	

?>
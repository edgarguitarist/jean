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

	if( empty($_REQUEST['tipo']) )
	{
		echo "<center><h1>Mi bro me dio ansiedad y no puedo generar el PDF! :'C</h1><img class='old' style='height: 160px;' src='../img/cheems.jpg'>";
	}else{
		$tipo=$_REQUEST['tipo'];
		$materia=$_REQUEST['materia'];
		$fecha=$_REQUEST['fecha'];
		$dias =$_REQUEST['dias'];
		ob_start();
		include(dirname('__FILE__').'/factura_r.php');
		$html = ob_get_clean();
		// instantiate and use the dompdf class
		$dompdf = new Dompdf();
		$dompdf->loadHtml($html);
		// (Optional) Setup the paper size and orientation
		$dompdf->setPaper('letter', 'portrait');
		// Render the HTML as PDF
		$dompdf->render();
		// Output the generated PDF to Browser
		$dompdf->stream('REPORTE'.$tipo.$materia.$fecha.$dias.'.pdf',array('Attachment'=>0));
		exit;
	}
	

$extra = "prueba";


?>
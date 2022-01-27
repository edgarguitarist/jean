<?php
	require 'conexion.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'PHPMailer/Exception.php';
	require 'PHPMailer/PHPMailer.php';
	require 'PHPMailer/SMTP.php';

	if (!empty($_POST)){$email = $_POST['email'];}else{$email = $_GET['email'];}
		
		
		$consulta="SELECT nom_usu, ape_usu FROM usuario WHERE cor_usu= '{$email}'";
        //Buscar si existe el correo y devolver datos
		$resultado=mysqli_query($conexion,$consulta);
		$contador = mysqli_num_rows($resultado);
     	
			if ($consulta && $reg=mysqli_fetch_array($resultado)){
					//echo "chevere";
			}

    	 if($contador == 1) {

			$token = base64_encode ($email); //generar codigo md5 apartir del correo
			$nombre = $reg['0'].' '.$reg['1']; // concatenacion del nombre y el apellido
			//echo $token;
			//echo $nombre;
			$url = 'http://'.$_SERVER["SERVER_NAME"].'/sistema/change_pass.php?idus='.$token;
    	 	$mail = new PHPMailer(true);

			try {
			    //Server settings
			    $mail->SMTPDebug = 0;                      // Enable verbose debug output
			    $mail->isSMTP();                                            // Send using SMTP
			    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
			    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
			    $mail->Username   = 'xxx@xxx.com';                     // SMTP username
			    $mail->Password   = 'xxxxxxxxxxx';                               // SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			    $mail->Port       = 587;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom("info.jossyemb.produ@gmail.com", "EMBUTIDOS 'JOSSY'");
			    $mail->addAddress($email, $nombre);     // Add a recipient


			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = "Reset Password - EMBUTIDOS 'JOSSY'";
			    $mail->Body    = "<center>
				<div style='margin-bottom:50px; align-content: center;'><img style='' src='https://scontent.fgye1-1.fna.fbcdn.net/v/t1.0-9/118653579_3076909155753931_3802492417072025602_n.jpg?_nc_cat=104&ccb=3&_nc_sid=09cbfe&_nc_eui2=AeGSlwiT3Adm3sz3RxlRPMhSZE3B9kq67p9kTcH2SrrunyEqlM9zpH-Bh85CLzhvLR65dx97rmTkJw9MDSt8NxMU&_nc_ohc=VwvzDPiAD08AX8R-vb9&_nc_ht=scontent.fgye1-1.fna&oh=62248bfd84fff62e8fd27dfbc6113751&oe=606332CD' width='150px' height='150px'>
				<h2 style='color: #013C80; font-weight: bold;'> EMBUTIDOS 'JOSSY' </h2></center>
				<p style='font-size: 16px; font-weight: bold; color:black;'>Hola $nombre, </p>
				<p style='font-size: 16px; font-weight: bold; color:black;'>Se ha solicitado un cambio de contrase&ntilde;a de tu cuenta del sitio del SISTEMA WEB DE EMBUTIDOS 'JOSSY'.</p> 
				<p style='font-size: 16px; font-weight: bold; color:black;'>Para restaurar la contrase&ntilde;a, visita la siguiente direcci&oacute;n: <a href='$url'>$url</a> </p>
				<p style='font-size: 16px; font-weight: bold; color:black;'>Si no solicitaste cambiar la contrase&ntilde;a ignora este correo electr&oacute;nico.</p>
				<br/>
				<p style='font-size: 16px; font-weight: bold; color:black;'>El equipo de EMBUTIDOS 'JOSSY'.</p> ";
			 
			    $mail->send();
				echo 'El mensaje ha sido enviado';
				header("Location: forgot_password.php?info=success");
			} catch (Exception $e) {
			    echo "No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}";
			}
       		mysqli_close($conexion); 
     	} else { 
			 echo "El Correo no existe";
			 header("Location: forgot_password.php?info=error");
     }		
	
?>

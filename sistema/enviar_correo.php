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
			    $mail->Username   = 'info.jossyemb@gmail.com';                     // SMTP username
			    $mail->Password   = '>6tZhb#:4';                               // SMTP password
			    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
			    $mail->Port       = 587;                                    // TCP port to connect to

			    //Recipients
			    $mail->setFrom("info.jossyemb.produ@gmail.com", "EMBUTIDOS 'JOSSY'");
			    $mail->addAddress($email, $nombre);     // Add a recipient


			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = "Reset Password - EMBUTIDOS 'JOSSY'";
			    $mail->Body    = "<center>
				<meta charset='UTF-8'>
				<div style='margin-bottom:50px; align-content: center;'><img src='https://www.jossyemb-produc.com/sistema/img/embj.jpg' width='150px' height='150px'>
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

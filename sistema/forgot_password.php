<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Olvide mi Contraseña</title>
    <?php include "includes/scripts.php";?>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/bootstrap.min.js" type="text/javascript"></script>
    
</head>

<body>

<?PHP
    if (isset($_GET["info"])) {
        $estado = $_GET["info"];
        $success = "display:none";
        $error = "display:none";
        $claseE ="";
        $claseS ="";
        if ($estado == "success") {
            $success = "display: block; width: auto;";
            $mensaje = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Se ha Enviado el Correo!</strong>";
            $claseS ="alert alert-success alert-dismissable";
        }
        if ($estado == "error") {
            $error = "display: block; width: auto;";
            $mensaje = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡El Correo No Existe!</strong>";
            $claseE ="alert alert-danger alert-dismissable";
        }
    } else {
        $success = "display: none";
        $error = "display: none";
        $claseE ="";
        $claseS ="";
    }
    ?>

    <section id="container_login">
        <form method="POST" action="enviar_correo.php" style="display: block;">
            <h3>Olvide mi Contraseña</h3>
            <img src="img/correo.png" alt="correo" width="40%">
            <input type="text" name="email" placeholder="Ingrese su Correo">
            
            <div class="<?php echo $claseS; ?>" style="<?php echo $success; ?>">
                <?php echo isset($mensaje) ? $mensaje : ''; ?> 
            </div>
            <div class="<?php echo $claseE; ?>" style="<?php echo $error; ?>">
                <?php echo isset($mensaje) ? $mensaje : ''; ?> 
            </div>
        
            <input type="submit" value="Enviar" style="width: auto; padding: 10px;">

            <div class="csess" style=" font-size: 18px; color: #013C80; text-align: end;"><a class="csess" style="color: #013C80" href="login.php">Iniciar Sesión</a></div>

        </form>
    </section>
</body>

</html>
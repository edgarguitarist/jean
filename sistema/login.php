<?php
$alert = '';
$display = 'display:none;';
$gg = false;
session_start();
if (!empty($_SESSION['active'])) {
    header('location: index.php');
} else {
    if (!empty($_POST)) {
        $alert = '';
        if (empty($_POST['usuario']) || empty($_POST['clave'])) {
            $alert = '<p class="msg_error">Los Campos Asignados son Obligatorios</p>';
        } else {
            require_once "conexion.php";
            $user = mysqli_real_escape_string($conexion, $_POST['usuario']);
            $pass = mysqli_real_escape_string($conexion, $_POST['clave']);

            $query = mysqli_query($conexion, "SELECT * FROM usuario WHERE BINARY usu_usu = '$user' and BINARY cla_usu = '$pass' AND estado =1");

            $result = mysqli_num_rows($query);
            if ($result > 0) {
                $data = mysqli_fetch_array($query);
                $_SESSION['active']   = true;
                $_SESSION['idUser']   = $data['id_usu'];
                $_SESSION['cedula']   = $data['ced_usu'];
                $_SESSION['nombre']   = $data['nom_usu'];
                $_SESSION['apellido'] = $data['ape_usu'];
                $_SESSION['user']     = $data['usu_usu'];
                $_SESSION['rol']      = $data['cod_tip_usu'];
                header('location: index.php ');
                $gg = false;
            } else {
                $gg = true;
                $clase = 'alert alert-danger';
                $display = 'display:block;';
                $alert = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Datos Erroneos, Vuelva a intentar!</strong>";
                session_destroy();
            }
        }
    }
}
?>



<!DOCTYPE html>

<html lang="es">

<head>
    <meta charset="utf-8">
    <title>Login - Sistema de Producción</title>
    <link rel="stylesheet" type="text/css" href="Css/style.css">
    <?php include "includes/scripts.php"; ?>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css">
    <script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/jquery.min.js" type="text/javascript"></script>
    <script src="https://uniwebsidad.com/static/libros/ejemplos/bootstrap-3/js/bootstrap.min.js" type="text/javascript"></script>
</head>

<body>

    <?PHP
    if (isset($_GET["info"])) {
        $estado2 = $_GET["info"];
        $display2 = "display:none";
        $clase2 = "";
        if ($estado2 == "success" && $gg != true) {
            $display2 = "display: block; width: auto;";
            $alert2 = "<button type='button' class='close' data-dismiss='alert'>&times;</button><strong>¡Se ha Actualizado su contraseña!</strong>";
            $clase2 = "alert alert-success alert-dismissable";
        }
    } else {
        $display2 = "display: none";
        $clase2 = "";
    }
    ?>


    <section id="container_login">
        <form action="" method="post" style="display: block;">
            <h3>Iniciar Sesion</h3>
            <img src="img/login.png" alt="login" width="40%">
            <input type="text" name="usuario" placeholder="Usuario">
            <input type="password" name="clave" placeholder="Contraseña">
            <div class="<?php echo $clase; ?>" style="<?php echo $display; ?>"><?php echo isset($alert) ? $alert : ''; ?> </div>
            <div class="<?php echo $clase2; ?>" style="<?php echo $display2; ?>"><?php echo isset($alert2) ? $alert2 : ''; ?> </div>
            <input type="submit" value="INGRESAR" style="width: auto; padding: 10px;">
            <div class="csess" style=" font-size: 18px; color: #013C80; text-align: end;"><a class="csess" style="color: #013C80" href="forgot_password.php">Olvidé mi Contraseña</a></div>
        </form>
    </section>
</body>

</html>
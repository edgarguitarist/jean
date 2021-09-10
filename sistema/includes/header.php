<?php

if (empty($_SESSION['active'])) {
    header('location: login.php');
}

switch ($_SESSION['rol']){
    case 1: 
        $rol = 'Administrador';
        break;
    case 2: 
        $rol = 'Supervisor';
        break;
    case 3: 
        $rol = 'Empleado';
        break;
    default:
        $rol= 'Usuario no Registrado';
        break;
}
   

?>
<header>
    <div class="header">

        <h1>Sistema Produccion</h1>
        <div class="optionsBar">
            <p>Ecuador, <?php echo fechaC(); ?></p>
            <span>|</span>
            <span class="user"> <?php echo $_SESSION['user'] . ' - ' . $rol; ?></span>
            <img class="photouser" src="img/user.png" alt="Usuario">
            <a href="salir.php"><img class="close" src="img/salir.png" alt="Salir del sistema" title="Salir"></a>
        </div>
    </div>
    <?php include "nav.php"; ?>
</header>
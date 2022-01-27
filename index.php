<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Embutidos Jossy</title>
    <script type="text/javascript" src="sistema/js/jquery.min.js"></script>
    <script type="text/javascript" src="sistema/js/icons.js"></script>

    <link rel="icon" type="image/png" href="sistema/img/embj.jpg" />
    <link rel='stylesheet' href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>
    <link rel="stylesheet" href="./style.css">
    <script type="text/javascript" src="sistema/js/icons.js"></script>
</head>



<body id="page-top" class="index">

    <?php include 'root/nav.php' ?>
    <?php include 'root/header.php' ?>



    <!-- PRODUCTOS Section -->
    <section id="product" class="bg-light-gray">
        <?php include 'root/sections/products.php' ?>
    </section>
    
    
    
    <!-- CONTACTO Section -->
    <section id="info">        
        <?php include 'root/sections/contacts.php' ?>
    </section>
    
    
    <!-- Quienes somos Section -->
    <section id="about" class="bg-light-gray">
        
        <?php include 'root/sections/about.php' ?>
    </section>
    
    <!-- MISION Y VISION Section -->
    <section id="myv">
        <?php include 'root/sections/myv.php' ?>
        
    </section>

    <?php include 'root/footer.php' ?>
    <?php include 'root/modals.php' ?>
</body>

<?php include 'root/scripts.php' ?>

</html>
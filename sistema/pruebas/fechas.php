<!DOCTYPE html>
<html lang="es">
<?php 


if(isset($_GET['enviar'])) {
    $datein = $_GET['datein'];
    $sqldate = $_GET['sqldate'];

    $formato1 = date("Y-m-d",strtotime($datein."+ 1 days"));
    $formato2 = $datein;
}

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="fechas.php" method="GET">
        <input id ="datein" type="date" name="datein" step="1" min="2021-12-15" max="<?php date_default_timezone_set('America/Guayaquil'); echo date("Y-m-d");?>" value="<?php date_default_timezone_set('America/Guayaquil'); echo date("Y-m-d");?>">
        <input type="text" name="sqldate" id="sqldate">
        <input type="submit" name="enviar" value="Enviar">
    </form>
        
        <input type="text" name="datefor1" id="datefor1" value="<?php echo $formato1 ?>">
        <input type="text" name="datefor2" id="datefor2" value="<?php echo $formato2 ?>">
</body>

</html>

<?php
include "../conexion.php";
include "../includes/scripts.php";

date_default_timezone_set('America/Guayaquil'); 

$fechaA= date("d-m-Y");
$hora= date("h:i") . " " . date("A");

$dias=$dias/997;
$materia=$materia/991;
$tipo=$tipo/983;

//$codigo = $regs2['cod_mat_pri'];
//$queryL = mysqli_query($conexion,"SELECT cor_pro FROM orden_despost WHERE lot_mat_pri = '$codigo'");
$PorcentajeDeMerma = 0.441;
$merma =0;
$nombre = '' ;
/*
	
if (isset($_GET['materia'])) {
    $materia = $_GET['materia']/991;
}
if (isset($_GET['tipo'])) {
    $tipo = $_GET['tipo']/983;
}
if (isset($_GET['fecha'])) {
    $fecha = $_GET['fecha'];
}
if (isset($_GET['dias'])) {
    $dias = $_GET['dias']/997;
}
*/

$data = '';

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>REPORTE</title>

    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="../css/style.css">

    <!-- RENDER DE GRAFICOS-->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.css">
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
					<h1>MERMA</h1>
				</div>
				
			</td>
			<td class="info_factura">
				<div class="round">
					<span class="h3">Orden</span>
					<!--<p>No.: <strong><?php //echo $regs2['cod_mat_pri']; ?></strong></p>!-->
					<p>Fecha: <?php echo $fechaA;?></p>
					<p>Hora: <?php echo $hora;?></p>
				</div>
			</td>
		</tr>
	</table>
    
    <div class="datosp" id="mostrar_data" style="width: 100%; display: block;">
        <?php 
        
        if ($tipo == "1") { // completo

            $total = 0;
            $ini = 0;
            $fecha2 = date("Y-m-d", strtotime($fecha . "+ 1 days"));
            $consulta = "SELECT A.nom_tip_mat AS Nombre, B.cod_mat_pri AS Codigo, B.peso_lle AS Peso 
                        FROM tipo_mat A ,mat_prima B 
                        WHERE A.id_tip_mat = B.id_tip_mat AND B.id_tip_mat = $materia AND B.fech_reg_mat BETWEEN '$fecha' AND '$fecha2'";
            foreach ($conexion->query($consulta) as $tot) {
                $total += $tot['Peso'];
                $nombre = $tot['Nombre'];
                $ini += 1;
            }
        
            $merma = $total - ($total*$PorcentajeDeMerma);
            $des=$total - $merma;
            $labels = "'Producto', 'Merma'";
            $datos= $merma . ", " . $des;
            /*
                $data = "<div style='width: 100%;'>
                <h1 style='text-align:center;'>".$nombre."</h1>
                <canvas id='chart1' width='100' height='25'></canvas>
                <script>
                var ctx = document.getElementById('chart1');
                var data = {
                    labels: [".$labels; $data .= "],
                    datasets: [{
                        label: 'Resultados',
                        data: [".$datos; $data .= "],
                        backgroundColor: [
                            '#325459','#C5BCC2'],
                        fontColor: '#FFFFFFFF', 
                        borderColor: '#ededed',
                        minBarLength: 5,
                        borderWidth: 2
                    }]
                };
                var options = {
                        responsive : true  
                    };
                var chart1 = new Chart(ctx, {
                    type: 'pie',
                    fill: false,
                    data: data,
                    options: options
                });
        
                </script>
                </div><BR>";*/
            
            if ($ini > 0) {        
                
                $data .= "
            <table id = 'tabla' style='margin: auto; width: 100%; border-spacing: 10px 5px;'>
            <thead>
            <th><center>Materia Prima</th>
            <th><center>Peso por Producto</th>
            <th><center>Peso Total</th>
            <th><center>Producto Total</th>
            </thead>";
        
        
            $data .= "<tr>" .
            "<td><center></td>" .
            "<td><center></td>" .
            "<td><center><b class='camporesalta'></td>" .
            "<td><center><b class='camporesalta'></td>" .
            "</tr>";
                $data .= "<tr>" .
                    "<td><center><b>" . $nombre . "</td>" .
                    "<td><center>" . "---" . "</td>" .
                    "<td><center><b class='camporesalta'>" . $total . "</td>" .
                    "<td><center><b class='camporesalta'>" . $merma . "</td>" .
                    "</tr>";
            } else {
                $data = '';
            }
            foreach ($conexion->query($consulta) as $fila) {
                $merma = $fila['Peso'] - ($fila['Peso']*$PorcentajeDeMerma);
                $data .= "<tr>" .
                    "<td><center>" . $fila['Codigo'] . "</td>" .
                    "<td><center>" . $fila['Peso'] . "</td>" .
                    "<td><center>" . "---" . "</td>" .
                    "<td><center>" . $merma . "</td>" .
                    "</tr>";
            }        
            if ($data == '') {
                echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
            } else {
                echo $data;
            }
        } elseif ($tipo == "2") { // SOLO PRODUCTO ---> PRODUCTO ESPECIFICO
            $fecha2 = date("Y-m-d", strtotime($fecha . "+ " . $dias . " days")); // SE SUMAN LOS DIAS SELECCIONADOS PARA CREAR UN RANGO DESDE LA FECHA INICIAL HASTA LOS DIAS AUMENTADOS
            if ($materia != 0) {
                
                $total = 0;
                $ini = 0;
                $consulta = "SELECT A.nom_tip_mat AS Nombre, B.cod_mat_pri AS Codigo, B.peso_lle AS Peso 
                            FROM tipo_mat A ,mat_prima B 
                            WHERE A.id_tip_mat = B.id_tip_mat AND B.id_tip_mat = $materia AND B.fech_reg_mat BETWEEN '$fecha' AND '$fecha2'";
                foreach ($conexion->query($consulta) as $tot) {
                    $total += $tot['Peso'];
                    $nombre = $tot['Nombre'];
                    $ini += 1;
                }
        
        
                $merma=$total - ($total*$PorcentajeDeMerma);
                $des=$total - $merma;
                $labels = "'Producto', 'Merma'";
                $datos= $merma . ", " . $des;
        /*
                    $data = "<div style='width: 100%;'>
                    <h1 style='text-align:center;'>".$nombre."</h1>
                    <canvas id='chart1' width='100' height='25'></canvas>
                    <script>
                    var ctx = document.getElementById('chart1');
                    var data = {
                        labels: [".$labels; $data .= "],
                        datasets: [{
                            label: 'Resultados',
                            data: [".$datos; $data .= "],
                            backgroundColor: [
                                '#325459','#C5BCC2'],
                            fontColor: '#FFFFFFFF', 
                            borderColor: '#ededed',
                            minBarLength: 5,
                            borderWidth: 2
                        }]
                    };
                    var options = {
                            responsive : true  
                        };
                    var chart1 = new Chart(ctx, {
                        type: 'pie',
                        fill: false,
                        data: data,
                        options: options
                    });
        
                    </script>
                    </div><BR>";*/
        
                if ($ini > 0) {
                    $data .= "<table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <th><center>Materia Prima</th>
                    <th><center>Peso por Producto</th>
                    <th><center>Peso Total</th>
                    <th><center>Producto Total</th>
                    </thead>";
                    $data .= "<tr>" .
                        "<td><center><b>" . $tot['Nombre'] . "</td>" .
                        "<td><center>" . "---" . "</td>" .
                        "<td><center><b class='camporesalta'>" . $total . "</td>" .
                        "<td><center><b class='camporesalta'>" . $merma . "</td>" .
                        "</tr>";
                    $data .= "</table><br>";
                } else {
                    $data = '';
                }
        
                if ($data == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $data;
                }
            } else { //////// SOLO PRODUCTOS ---> TODOS
                $data .= "
                <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                <thead>
                <th><center>Materia Prima</th>
                <th><center>Peso por Producto</th>
                <th><center>Peso Total</th>
                <th><center>Producto Total</th>
                </thead>";
                $total = 0;
                $ini = 0;
                $consulta = "SELECT A.nom_tip_mat AS Nombre, B.cod_mat_pri AS Codigo, SUM(B.peso_lle) AS Peso 
                            FROM tipo_mat A ,mat_prima B 
                            WHERE A.id_tip_mat = B.id_tip_mat AND B.fech_reg_mat BETWEEN '$fecha' AND '$fecha2'
                            GROUP BY B.id_tip_mat";
                foreach ($conexion->query($consulta) as $tot) { 
                    $merma = $tot['Peso'] - ($tot['Peso']*$PorcentajeDeMerma);
                    $data .= "<tr>" .
                    "<td><center><b>" . $tot['Nombre'] . "</td>" .
                    "<td><center>" . "---" . "</td>" .
                    "<td><center><b class='camporesalta'>" . $tot['Peso'] . "</td>" .
                    "<td><center><b class='camporesalta'>" . $merma . "</td>" .
                    "</tr>";
        
                    $ini += 1;
        
                }
                if ($ini > 0) {
                    $data .= "</table><br>";
                } else {
                    $data = '';
                }
        
                if ($data == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $data;
                }
            }
        } else {
            echo "<center><h1>Mi bro me dio ansiedad y no puedo generar el PDF! :'C</h1><img class='old' style='height: 160px;' src='../img/cheems.jpg'>";
            //echo $data;  // no muestra nada
        }
        
        ?>
    </div>
</div>
</body>
</html>
<?php

include "includes/scripts.php";
include "conexion.php";

$materia = isset($_POST['materia']) ? $_POST['materia'] : null;
$cod_materia = isset($_POST['cod_materia']) ? $_POST['cod_materia'] : null;

if (isset($_POST['materia2'])) {
    $materia2 = $_POST['materia2'];
}
if (isset($_POST['tipo'])) {
    $tipo = $_POST['tipo'];
}
if (isset($_POST['fecha'])) {
    $fecha = $_POST['fecha'];
}
if (isset($_POST['fecha2'])) {
    $fecha2 =  date("Y-m-d", strtotime($_POST['fecha2'] . "+ 1 days"));
}
if (isset($_POST['fecha_final'])) {
    $fecha_final = $_POST['fecha_final'];
}


$PorcentajeDeMerma = 0.1;
$merma = 0;
$nombre = '';
$html = '';
//$boton_reporte="";
$boton_reporte = "";

if (isset($_POST['frm'])) {
    $frm = $_POST['frm'];

    if ($frm == "MERMA") {
        if (isset($tipo)) {
            $html = '';
            if ($tipo == "1") { // completo 
                $total = 0;
                $ini = 0;
                $total_producto = 0;
                $fecha2 = date("Y-m-d", strtotime($_POST['fecha_final'] . "+ 1 days"));

                $consulta2 = "SELECT
                tm.nom_tip_mat AS Nombre,
                mp.cod_mat_pri AS Codigo,
                mp.peso_lle AS Peso,
                mp.fech_reg_mat,
                COUNT(pt.cortes) AS numero_cortes,
                round(SUM(pt.peso),2) AS total_producto
                FROM
                    mat_prima mp
                INNER JOIN tipo_mat tm ON
                    tm.id_tip_mat = mp.id_tip_mat AND mp.id_tip_mat = $materia
                INNER JOIN prod_terminado pt ON pt.cod_pro = mp.cod_mat_pri
                WHERE
                    pt.fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                GROUP BY mp.cod_mat_pri
                ORDER BY mp.id_mat";

                foreach ($conexion->query($consulta2) as $tot) {

                    $total += $tot['Peso'];
                    $total_producto += $tot['total_producto'];
                    $nombre = $tot['Nombre'];
                    $ini += 1;
                }
                if ($cod_materia == 'todos') {
                    if ($total <= 0 || $total_producto <= 0) {
                        echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                        return;
                    }
                    $pes_des = $total - $total_producto;
                    $merma = ($pes_des / $total) * 100;

                    $des = $pes_des;
                    $labels = "'Producto', 'Merma'";
                    $datos = $total . ", " . $des;

                    $html = "<div style='width: 100%;'>
                    <h1 style='text-align:center;'>" . $nombre . "</h1>
                    <canvas id='chart1' width='100' height='25'></canvas>
                    <script>
                    var ctx = document.getElementById('chart1');
                    var data = {
                        labels: [" . $labels;
                    $html .= "],
                        datasets: [{
                            label: 'Resultados',
                            data: [" . $datos;
                    $html .= "],
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
                    </div><BR>";

                    if ($ini > 0) {
                        $html .= $boton_reporte . "
                <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                <thead>
                <tr style='background: #325459 !important;'>
                <tr style='background: #325459 !important;'>
                <th><center>Materia Prima</th>
                <th><center>Peso Materias Prima</th>
                <th><center>Peso Total Cortes</th>
                <th><center>Merma x Libra</th>
                <th><center>Merma x Porcentaje</th>
                </tr></thead>";



                        $html .= "<tr>" .
                            "<td><center><b>" . $nombre . "</td>" .
                            "<td><center>" . round($total, 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($total_producto, 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($pes_des, 3) . " lbs.</td>" .
                            "<td><center><b class='camporesalta'>" . round($merma, 3) . "%</td>" .
                            "</tr>";
                    } else {
                        $html = '';
                    }


                    foreach ($conexion->query($consulta2) as $fila) {
                        $pes_des = $fila['Peso'] - $fila['total_producto'];
                        $merma = ($pes_des / $fila['Peso']) * 100;
                        $html .= "<tr>" .
                            "<td><center>" . $fila['Codigo'] . "</td>" .
                            "<td><center>" . round($fila['Peso'], 3) . "</td>" .
                            "<td><center>" . round($fila['total_producto'], 3) . "</td>" .
                            "<td><center>" . round($pes_des, 3) . " lbs.</td>" .
                            "<td><center>" . round($merma, 3) . "%</td>" .
                            "</tr>";
                    }


                    if ($html == '') {
                        echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                    } else {
                        echo $html;
                    }
                } else { // por codigo de materia prima
                    $html = "<div style='width: 100%;'>
                <h1 style='display:; text-align:center;'>" . $nombre . "</h1> <br>";
                    $html .= "
                <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                <thead>
                <tr style='background: #325459 !important;'>
                <tr style='background: #325459 !important;'>
                <th><center>Materia Prima</th>
                <th><center>Peso Materia Prima</th>
                <th><center>Peso Total Cortes</th>
                <th><center>Merma x Libra</th>
                <th><center>Merma x Porcentaje</th>
                </tr></thead>";
                    $total = 0;
                    $ini = 0;
                    $consulta = "SELECT
                    tm.nom_tip_mat AS Nombre,
                    mp.cod_mat_pri AS Codigo,
                    mp.peso_lle AS Peso,
                    mp.fech_reg_mat,
                    COUNT(pt.cortes) AS numero_cortes,
                    round(SUM(pt.peso),2) AS total_producto
                    FROM
                        mat_prima mp
                    INNER JOIN tipo_mat tm ON
                        tm.id_tip_mat = mp.id_tip_mat 
                    INNER JOIN prod_terminado pt ON pt.cod_pro = mp.cod_mat_pri AND  pt.cod_pro = '$cod_materia'
                    WHERE
                        pt.fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                    GROUP BY mp.cod_mat_pri";

                    foreach ($conexion->query($consulta) as $fila) {
                        $pes_des = $fila['Peso'] - $fila['total_producto'];
                        $merma = ($pes_des / $fila['Peso']) * 100;
                        $html .= "<tr>" .
                            "<td><center>" . $fila['Codigo'] . "</td>" .
                            "<td><center>" . round($fila['Peso'], 3) . "</td>" .
                            "<td><center>" . round($fila['total_producto'], 3) . "</td>" .
                            "<td><center>" . round($pes_des, 3) . " lbs.</td>" .
                            "<td><center>" . round($merma, 3) . "%</td>" .
                            "</tr>";
                        $ini++;
                    }
                    if ($ini > 0) {
                        $html .= "</table><br>";
                    } else {
                        $html = '';
                    }

                    if ($html == '') {
                        echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1> <script>$cod_materia</script>";
                    } else {
                        echo $html;
                    }
                }
            } elseif ($tipo == "2") { // SOLO PRODUCTO ---> PRODUCTO ESPECIFICO
                $fecha2 = $fecha_final;
                if ($materia != 0) {
                    $total = 0;
                    $ini = 0;
                    $total_producto = 0;
                    $consulta = "SELECT
                    tm.nom_tip_mat AS Nombre,
                    mp.cod_mat_pri AS Codigo,
                    mp.peso_lle AS Peso,
                    mp.fech_reg_mat,
                    COUNT(pt.cortes) AS numero_cortes,
                    round(SUM(pt.peso),2) AS total_producto
                    FROM
                        mat_prima mp
                    INNER JOIN tipo_mat tm ON
                        tm.id_tip_mat = mp.id_tip_mat AND mp.id_tip_mat = $materia
                    INNER JOIN prod_terminado pt ON pt.cod_pro = mp.cod_mat_pri
                    WHERE
                        pt.fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                    GROUP BY mp.cod_mat_pri
                    ORDER BY mp.id_mat";
                    foreach ($conexion->query($consulta) as $tot) {
                        $total += $tot['Peso'];
                        $nombre = $tot['Nombre'];
                        $total_producto += $tot['total_producto'];
                        $ini += 1;
                    }


                    $pes_des = $total - $total_producto;
                    $merma = ($pes_des / $total) * 100;

                    $des = $pes_des;
                    $labels = "'Producto', 'Merma'";
                    $datos = $total . ", " . $des;

                    $html = "<div style='width: 100%;'>
                        <h1 style='text-align:center;'>" . $nombre . "</h1>
                        <canvas id='chart1' width='100' height='25'></canvas>
                        <script>
                        var ctx = document.getElementById('chart1');
                        var data = {
                            labels: [" . $labels;
                    $html .= "],
                            datasets: [{
                                label: 'Resultados',
                                data: [" . $datos;
                    $html .= "],
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
                        </div><BR>";

                    if ($ini > 0) {
                        $html .= $boton_reporte . "<table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                        <thead>
                        <tr style='background: #325459 !important;'>
                        <tr style='background: #325459 !important;'>
                        <th><center>Materia Prima</th>
                        <th><center>Peso Materias Prima</th>
                        <th><center>Peso Total Cortes</th>
                        <th><center>Merma x Libra</th>
                        <th><center>Merma x Porcentaje</th>
                        </tr></thead>";
                        $html .= "<tr>" .
                            "<td><center><b>" . $nombre . "</td>" .
                            "<td><center>" . round($total, 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($total_producto, 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($pes_des, 3) . " lbs.</td>" .
                            "<td><center><b class='camporesalta'>" . round($merma, 3) . "%</td>" .
                            "</tr>";
                        $html .= "</table><br>";
                    } else {
                        $html = '';
                    }

                    if ($html == '') {
                        echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                    } else {
                        echo $html;
                    }
                } else { //////// SOLO PRODUCTOS ---> TODOS
                    $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <tr style='background: #325459 !important;'>
                    <th><center>Materia Prima</th>
                    <th><center>Peso Materias Prima</th>
                    <th><center>Peso Total Cortes</th>
                    <th><center>Merma x Libra</th>
                    <th><center>Merma x Porcentaje</th>
                    </tr></thead>";
                    $total = 0;
                    $ini = 0;
                    $total_producto = 0;
                    $nombres_array = array();
                    $total_array = array();
                    $total_producto_array = array();
                    $tempnombre = '';
                    $consulta = "SELECT tm.nom_tip_mat AS Nombre, mp.peso_lle AS Peso, round(SUM(pt.peso),2) AS total_producto 
                    FROM mat_prima mp 
                    INNER JOIN tipo_mat tm ON tm.id_tip_mat = mp.id_tip_mat 
                    INNER JOIN prod_terminado pt ON pt.cod_pro = mp.cod_mat_pri 
                    WHERE pt.fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                    GROUP BY mp.cod_mat_pri 
                    ORDER BY tm.nom_tip_mat";
                    $rows = $conexion->query($consulta);
                    $num_rows = $rows->num_rows;
                    $conter_name = 0;

                    foreach ($rows as $tot) {

                        $nombre = $tot['Nombre'];
                        if ($nombre != $tempnombre && $ini > 0) {
                            array_push($nombres_array, $tempnombre);
                            array_push($total_array, $total);
                            array_push($total_producto_array, $total_producto);
                            $total = 0;
                            $total_producto = 0;
                            $conter_name += 1;
                        }
                        $total += $tot['Peso'];
                        $total_producto += $tot['total_producto'];
                        $ini += 1;
                        if ($num_rows == $ini) {
                            array_push($nombres_array, $tempnombre);
                            array_push($total_array, $total);
                            array_push($total_producto_array, $total_producto);
                        }
                        $tempnombre = $tot['Nombre'];
                    }

                    for ($i = 0; $i < count($total_array); $i++) {
                        $pes_des = $total_array[$i] - $total_producto_array[$i];
                        $merma = ($pes_des / $total_array[$i]) * 100;
                        $html .= "<tr>" .
                            "<td><center><b>" . $nombres_array[$i] . "</td>" .
                            "<td><center>" . round($total_array[$i], 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($total_producto_array[$i], 3) . "</td>" .
                            "<td><center><b class='camporesalta'>" . round($pes_des, 3) . " lbs.</td>" .
                            "<td><center><b class='camporesalta'>" . round($merma, 3) . "%</td>" .
                            "</tr>";
                        $ini += 1;
                    }
                    if ($ini > 0) {
                        $html .= "</table><br>";
                    } else {
                        $html = '';
                    }

                    if ($html == '') {
                        echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                    } else {
                        echo $html;
                    }
                }
            } else {
                echo $html;  // no muestra nada
            }
        }
    } // fin de la funcion MERMA

    if ($frm == "MATPRIMA") {
        $total = 0;
        $ini = 0;
        $pro = 0;
        $npro = 0;



        $query = mysqli_query($conexion, "SELECT * 
        FROM tipo_mat
        WHERE id_tip_mat = $materia");
        $data = mysqli_fetch_array($query);
        if ($cod_materia == 'todos') {

            $consulta = "   SELECT * 
                        FROM mat_prima
                        WHERE id_tip_mat = $materia AND fech_reg_mat BETWEEN '$fecha' AND '$fecha2'";
            foreach ($conexion->query($consulta) as $tot) {
                //$total += $tot['Peso'];
                //$nombre = $tot['Nombre'];
                $ini += 1;
                if ($tot['estado_mate'] == 0) {
                    $pro += 1;
                } else {
                    $npro += 1;
                }
            }

            //$merma = $total - ($total*$PorcentajeDeMerma);
            //$des=$total - $merma;
            $labels = "'Procesado', 'No Procesado'";
            $datos = $pro . ", " . $npro;

            $html = "<div style='width: 100%;'>
            <h1 style='display:; text-align:center;'>" . $data['nom_tip_mat'] . "</h1>
            <canvas id='chart1' width='100' height='25'></canvas>
            <script>
            var ctx = document.getElementById('chart1');
            var data = {
                labels: [" . $labels;
            $html .= "],
                datasets: [{
                    label: 'Resultados',
                    data: [" . $datos;
            $html .= "],
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
            </div><br>
            <h4>Total de Registros: " . $ini . "</h3><br>";

            //$html.= "<br><h1 style='text-align:center;'>".$data['nom_tip_mat']."</h1>";

            $html .= $boton_reporte . "
            <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
            <thead>
            <tr style='background: #325459 !important;'>
            <th><center>Materia Prima</th>
            <th><center>Peso</th>
            <th><center>Fecha</th>
            <th><center>Hora</th>
            <th><center>Estado</th>
            </tr></thead>";
            $total = 0;
            $ini = 0;
            $consulta = "SELECT * 
                    FROM mat_prima
                    WHERE id_tip_mat = $materia AND fech_reg_mat BETWEEN '$fecha' AND '$fecha2'";

            foreach ($conexion->query($consulta) as $tot) {
                //$merma = $tot['Peso'] - ($tot['Peso']*$PorcentajeDeMerma);
                $tiempo = explode(" ", $tot['fech_reg_mat']);

                $estado = $tot['estado_mate'] == 0 ? "<span class='textoverde'>Procesado</span>" : "<span class='textorojo'>Sin Procesar</span>";
                $html .= "<tr>" .
                    "<td><center><b>" . $tot['cod_mat_pri'] . "</td>" .
                    "<td><center>" . $tot['peso_lle'] . "</td>" .
                    "<td><center>" . $tiempo[0] . "</td>" .
                    "<td><center>" . $tiempo[1] . "</td>" .
                    "<td style='text-align-last: center;'>" . $estado . "</td>" .
                    "</tr>";

                $ini += 1;
            }
            if ($ini > 0) {
                $html .= "</table><br>";
            } else {
                $html = '';
            }

            if ($html == '') {
                echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
            } else {
                echo $html;
            }
        } else {
            $html = "<div style='width: 100%;'>
            <h1 style='display:; text-align:center;'>" . $data['nom_tip_mat'] . "</h1>";
            $html .= "
            <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
            <thead>
            <tr style='background: #325459 !important;'>
            <th><center>Materia Prima</th>
            <th><center>Peso</th>
            <th><center>Fecha</th>
            <th><center>Hora</th>
            <th><center>Estado</th>
            </tr></thead>";
            $total = 0;
            $ini = 0;
            $consulta = "SELECT * 
                    FROM mat_prima
                    WHERE cod_mat_pri = '$cod_materia' AND fech_reg_mat BETWEEN '$fecha' AND '$fecha2'";

            foreach ($conexion->query($consulta) as $tot) {
                //$merma = $tot['Peso'] - ($tot['Peso']*$PorcentajeDeMerma);
                $tiempo = explode(" ", $tot['fech_reg_mat']);

                $estado = $tot['estado_mate'] == 0 ? "<span class='textoverde'>Procesado</span>" : "<span class='textorojo'>Sin Procesar</span>";
                $html .= "<tr>" .
                    "<td><center><b>" . $tot['cod_mat_pri'] . "</td>" .
                    "<td><center>" . $tot['peso_lle'] . "</td>" .
                    "<td><center>" . $tiempo[0] . "</td>" .
                    "<td><center>" . $tiempo[1] . "</td>" .
                    "<td style='text-align-last: center;'>" . $estado . "</td>" .
                    "</tr>";

                $ini += 1;
            }
            if ($ini > 0) {
                $html .= "</table><br>";
            } else {
                $html = '';
            }

            if ($html == '') {
                echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1> <script>$cod_materia</script>";
            } else {
                echo $html;
            }
        }
    }

    if ($frm == "PROTERM") {
        if ($tipo == "1") { //Carne
            switch ($materia) {
                case 1: //Chancho ---> cha
                    $codigo = 'cha';
                    break;
                case 2:
                    $codigo = 'chi';
                    break;
                case 3:
                    $codigo = 'pol';
                    break;
                case 4:
                    $codigo = 'pav';
                    break;
                case 6:
                    $codigo = 'pes';
                    break;
                case 99:
                    $codigo = '';
                    break;
                default:
                    echo $html; // no muestra nada
                    break;
            }

            if ($codigo != '') {
                $query = mysqli_query($conexion, "SELECT * 
                FROM tipo_mat
                WHERE id_tip_mat = $materia");
                $data = mysqli_fetch_array($query);
                $html .= "<br><h1 style='text-align:center;'>" . $data['nom_tip_mat'] . "</h1><br>";

                $total = 0;
                $ini = 0;
                if ($cod_materia == 'todos') {
                    $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <th style='display:none;'><center>Materia Prima</th>
                    <th><center>Corte</th>
                    <th><center>Peso</th>
                    <th><center>Fecha</th>
                    <th><center>Hora</th>
                    </tr></thead>";
                    $consulta = "   SELECT *, SUM(peso) AS SUMA 
                                FROM prod_terminado
                                WHERE cod_pro Like '%$codigo%' AND fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                                GROUP BY cortes";
                    foreach ($conexion->query($consulta) as $tot) {
                        $tiempo = explode(" ", $tot['fecha_ingre']);
                        $html .= "<tr>" .
                            "<td style='display:none;'><center><b>" . $tot['cod_pro'] . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                        $ini++;
                    }
                } else {
                    $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <th><center>Materia Prima</th>
                    <th><center>Corte</th>
                    <th><center>Peso</th>
                    <th><center>Fecha</th>
                    <th><center>Hora</th>
                    </tr></thead>";
                    $consulta = "SELECT *, SUM(peso) AS SUMA 
                                FROM prod_terminado
                                WHERE cod_pro ='$cod_materia' AND fecha_ingre BETWEEN '$fecha' AND '$fecha2'";
                    foreach ($conexion->query($consulta) as $tot) {
                        $tiempo = $tot['fecha_ingre'] != null ? explode(" ", $tot['fecha_ingre']) : ['', ''];

                        $html .= "<tr>" .
                            "<td><center><b>" . $tot['cod_pro'] . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                        $ini = $tiempo[0] != '' ? $ini + 1 : $ini;
                    }
                }
                if ($ini > 0) {
                    $html .= "</table><br>";
                } else {
                    $html = '';
                }
                if ($html == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $html;
                }
            } else {
                $query = mysqli_query($conexion, "SELECT * 
                FROM tipo_mat
                WHERE id_tip_mat = $materia");
                $data = mysqli_fetch_array($query);
                $html .= "<br><h1 style='text-align:center;'>Todos</h1><br>";
                $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <th><center>Materia Prima</th>
                    <th><center>Corte</th>
                    <th><center>Peso</th>
                    <th><center>Fecha</th>
                    <th><center>Hora</th>
                    </tr></thead>";
                $total = 0;
                $ini = 0;
                $consulta = "   SELECT *, SUM(peso) AS SUMA, CASE
                                                                WHEN cod_pro LIKE '%cha%'
                                                                THEN 'Chancho'
                                                                WHEN cod_pro LIKE '%chi%'
                                                                THEN 'Chivo'
                                                                WHEN cod_pro LIKE '%pes%'
                                                                THEN 'Pescado'
                                                                WHEN cod_pro LIKE '%pav%'
                                                                THEN 'Pavo'
                                                                WHEN cod_pro LIKE '%pol%'
                                                                THEN 'Pollo'
                                                                ELSE 'Embutido'
                                                            END AS t_mat 
                                FROM prod_terminado
                                WHERE cod_pro NOT LIKE '%emb%' AND fecha_ingre BETWEEN '$fecha' AND '$fecha2'
                                GROUP BY cortes
                                ORDER BY cod_pro";
                $ctrl = '';
                $last = '';
                foreach ($conexion->query($consulta) as $tot) {
                    $tiempo = explode(" ", $tot['fecha_ingre']);
                    $ctrl = $tot['t_mat'];
                    if ($ctrl == $last) {
                        $html .= "<tr>" .
                            "<td ><center><b>" . "" . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                    } else {
                        $html .= "<tr>" .
                            "<td ><center><b>" . $tot['t_mat'] . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                    }
                    $last = $tot['t_mat'];
                    $ini += 1;
                }
                if ($ini > 0) {
                    $html .= "</table><br>";
                } else {
                    $html = '';
                }
                if ($html == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $html;
                }
            }
        } else if ($tipo == "2") { // Embutido

            $html .= "<br><h1 style='text-align:center;'>Embutido</h1>";
            $html .= $boton_reporte . "
                <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                <thead>
                <tr style='background: #325459 !important;'>
                <th style='display:none;'><center>Materia Prima</th>
                <th><center>Embutido</th>
                <th><center>Peso</th>
                <th><center>Fecha</th>
                <th><center>Hora</th>
                </tr></thead>";
            $total = 0;
            $ini = 0;
            $consulta2 = "SELECT *, SUM(A.peso) AS SUMA, (SELECT MAX(B.fecha_ingre) 
                                                            FROM prod_terminado B 
                                                            WHERE B.cortes=A.cortes) AS FECHAF 
                            FROM prod_terminado A 
                            WHERE A.cod_pro LIKE '%emb%' AND fecha_ingre BETWEEN '$fecha' AND '$fecha2' 
                            GROUP BY A.cortes
            ";

            foreach ($conexion->query($consulta2) as $tot2) {
                $tiempo = explode(" ", $tot2['FECHAF']);
                $html .= "<tr>" .
                    "<td style='display:none;'><center><b>" . $tot2['cod_pro'] . "</td>" .
                    "<td><center><b>" . $tot2['cortes'] . "</td>" .
                    "<td><center>" . round($tot2['SUMA'], 3) . "</td>" .
                    "<td><center>" . $tiempo[0] . "</td>" .
                    "<td><center>" . $tiempo[1] . "</td>" .
                    "</tr>";
                $ini += 1;
            }
            if ($ini > 0) {
                $html .= "</table><br>";
            } else {
                $html = '';
            }
            if ($html == '') {
                echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
            } else {
                echo $html;
            }


            //echo "<h1>NO HAY DATOS DE EMBUTIDOS</h1>";  // no muestra nada porque no hay informacion
        } else {
            echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";  // no muestra nada
        }
    }

    //////////////////////////////////////////PRODUCTO FINAL

    if ($frm == "PROFINAL") {
        if ($tipo == "1") { //Carne
            switch ($materia) {
                case 1: //Chancho ---> cha
                    $cod = 'cha';
                    $codigo = 'chancho';
                    break;
                case 2:
                    $cod = 'chi';
                    $codigo = 'chivo';
                    break;
                case 3:
                    $cod = 'pol';
                    $codigo = 'pollo';
                    break;
                case 4:
                    $cod = 'pav';
                    $codigo = 'pavo';
                    break;
                case 7:
                    $cod = 'res';
                    $codigo = 'res';
                    break;
                case 99:
                    $cod = '';
                    $codigo = '';
                    break;
                default:
                    echo $html; // no muestra nada
                    break;
            }

            if ($codigo != '') {
                $query = mysqli_query($conexion, "SELECT * 
                FROM tipo_mat
                WHERE id_tip_mat = $materia");
                $data = mysqli_fetch_array($query);
                $html .= "<br><h1 style='text-align:center;'>" . $data['nom_tip_mat'] . "</h1>";
                $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <th style='display:none;'><center>Materia Prima</th>
                    <th><center>Corte</th>
                    <th><center>Peso</th>
                    <th><center>Fecha</th>
                    <th><center>Hora</th>
                    </tr></thead>";
                $total = 0;
                $ini = 0;
                $consulta = "   SELECT *, SUM(peso) AS SUMA 
                                FROM prod_final
                                WHERE cortes Like '%$codigo%' AND fecha_ingreso BETWEEN '$fecha' AND '$fecha2'
                                GROUP BY cortes";
                foreach ($conexion->query($consulta) as $tot) {
                    $tiempo = explode(" ", $tot['fecha_ingreso']);
                    $html .= "<tr>" .
                        "<td style='display:none;'><center><b>" . $tot['id_prod_final'] . "</td>" .
                        "<td><center><b>" . $tot['cortes'] . "</td>" .
                        "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                        "<td><center>" . $tiempo[0] . "</td>" .
                        "<td><center>" . $tiempo[1] . "</td>" .
                        "</tr>";
                    $ini += 1;
                }
                if ($ini > 0) {
                    $html .= "</table><br>";
                } else {
                    $html = '';
                }
                if ($html == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $html;
                }
            } else {
                $query = mysqli_query($conexion, "SELECT * 
                FROM tipo_mat
                WHERE id_tip_mat = $materia");
                $data = mysqli_fetch_array($query);
                $html .= "<br><h1 style='text-align:center;'>Todos</h1><br>";
                $html .= $boton_reporte . "
                    <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                    <thead>
                    <tr style='background: #325459 !important;'>
                    <th><center>Materia Prima</th>
                    <th><center>Corte</th>
                    <th><center>Peso</th>
                    <th><center>Fecha</th>
                    <th><center>Hora</th>
                    </tr></thead>";
                $total = 0;
                $ini = 0;
                $consulta = "   SELECT *, SUM(peso) AS SUMA, CASE
                                                                WHEN cortes LIKE '%cha%'
                                                                THEN 'Chancho'
                                                                WHEN cortes LIKE '%chi%'
                                                                THEN 'Chivo'
                                                                WHEN cortes LIKE '%res%'
                                                                THEN 'Res'
                                                                WHEN cortes LIKE '%pav%'
                                                                THEN 'Pavo'
                                                                WHEN cortes LIKE '%pol%'
                                                                THEN 'Pollo'
                                                                ELSE 'Embutido'
                                                            END AS t_mat 
                                FROM prod_final
                                WHERE cortes LIKE '% de %' AND fecha_ingreso BETWEEN '$fecha' AND '$fecha2'
                                GROUP BY cortes
                                ORDER BY cortes";
                $ctrl = '';
                $last = '';
                foreach ($conexion->query($consulta) as $tot) {
                    $tiempo = explode(" ", $tot['fecha_ingreso']);
                    $ctrl = $tot['t_mat'];
                    if ($ctrl == $last) {
                        $html .= "<tr>" .
                            "<td ><center><b>" . "" . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                    } else {
                        $html .= "<tr>" .
                            "<td ><center><b>" . $tot['t_mat'] . "</td>" .
                            "<td><center><b>" . $tot['cortes'] . "</td>" .
                            "<td><center>" . round($tot['SUMA'], 3) . "</td>" .
                            "<td><center>" . $tiempo[0] . "</td>" .
                            "<td><center>" . $tiempo[1] . "</td>" .
                            "</tr>";
                    }
                    $last = $tot['t_mat'];
                    $ini += 1;
                }
                if ($ini > 0) {
                    $html .= "</table><br>";
                } else {
                    $html = '';
                }
                if ($html == '') {
                    echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
                } else {
                    echo $html;
                }
            }
        } else if ($tipo == "2") { // Embutido

            $html .= "<br><h1 style='text-align:center;'>Embutido</h1>";
            $html .= $boton_reporte . "
                <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
                <thead>
                <tr style='background: #325459 !important;'>
                <th style='display:none;'><center>Materia Prima</th>
                <th><center>Corte</th>
                <th><center>Peso</th>
                <th><center>Fecha</th>
                <th><center>Hora</th>
                </tr></thead>";
            $total = 0;
            $ini = 0;
            $consulta2 = "  SELECT *, SUM(peso) AS SUMA, MAX(fecha_ingreso) AS FECHAF 
                            FROM prod_final 
                            WHERE cortes NOT LIKE '% de %' AND fecha_ingreso BETWEEN '$fecha' AND '$fecha2' 
                            GROUP BY cortes";

            foreach ($conexion->query($consulta2) as $tot2) {
                $tiempo = explode(" ", $tot2['FECHAF']);
                $html .= "<tr>" .
                    "<td style='display:none;'><center><b>" . $tot2['id_prod_final'] . "</td>" .
                    "<td><center><b>" . $tot2['cortes'] . "</td>" .
                    "<td><center>" . round($tot2['SUMA'], 3) . "</td>" .
                    "<td><center>" . $tiempo[0] . "</td>" .
                    "<td><center>" . $tiempo[1] . "</td>" .
                    "</tr>";
                $ini += 1;
            }
            if ($ini > 0) {
                $html .= "</table><br>";
            } else {
                $html = '';
            }
            if ($html == '') {
                echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
            } else {
                echo $html;
            }


            //echo "<h1>NO HAY DATOS DE EMBUTIDOS</h1>";  // no muestra nada porque no hay informacion
        } else {
            echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";  // no muestra nada
        }
    }

    if ($frm == "ORDEMB") {

        $html .= "<br><h1 style='text-align:center;'>Orden de Embutidos</h1><br>";

        $html .= $boton_reporte . "
            <table id = 'tabla' style='margin: auto; width: 90%; border-spacing: 10px 5px;'>
            <thead>
            <tr style='background: #325459 !important;'>
            <th><center>Nombre</th>
            <th><center>Cantidad</th>
            <th><center>Fecha</th>
            <th><center>Hora</th>
            <th><center>Estado</th>
            </tr></thead>";
        $ini = 0;
        $consulta = "SELECT * 
                    FROM orden_embut
                    WHERE fecha_ord_emb BETWEEN '$fecha' AND '$fecha2'";

        foreach ($conexion->query($consulta) as $tot) {
            //$merma = $tot['Peso'] - ($tot['Peso']*$PorcentajeDeMerma);
            $tiempo = explode(" ", $tot['fecha_ord_emb']);
            if ($tot['estado'] == 0) {
                $estado = "<span class='textoverde'>Procesado</span>";
            } else {
                $estado = "<span class='textorojo'>No Procesado</span>";
            }
            $html .= "<tr>" .
                "<td><center><b>" . $tot['nom_ord'] . "</td>" .
                "<td><center>" . $tot['cant_ord'] . "</td>" .
                "<td><center>" . $tiempo[0] . "</td>" .
                "<td><center>" . $tiempo[1] . "</td>" .
                "<td style='text-align-last: center;'>" . $estado . "</td>" .
                "</tr>";

            $ini += 1;
        }
        if ($ini > 0) {
            $html .= "</table><br>";
        } else {
            $html = '';
        }

        if ($html == '') {
            echo "<h1>NO SE ENCONTRARON COINCIDENCIAS CON SU BUSQUEDA</h1>";
        } else {
            echo $html;
        }
    }
} else {
    echo $html;  // no muestra nada
}

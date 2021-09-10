<?php
session_start();
include "conexion.php"; // Mostrar de la tabla    prod_procesar
$reporte = 'Producto Final';
$namepdf = "Producto Final - " . $hoy;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>PRODUCTO FINAL</title>
</head>

<script>
    function ver_peso() {        
        var mostrar = document.getElementById("mostrar_data");
        var salida = document.getElementById("salida");
        //var sumito = document.getElementById("generar");
        peso = parseInt($("#cortes").val(), 10);
        peso2 = parseInt($("#peso-fin").val(), 10);
        console.log(peso, peso2);
        salida.innerHTML = "";
        mostrar.style.display = "none";
        
        if (peso2 > 0) {   

            if (peso2 > peso) {
                dif = peso2 - peso;
                $respuesta = "Peso exedido en " + Math.abs(dif) + " libras";
                //console.log(dif);                
                salida.innerHTML = $respuesta;
                salida.style.color = "red";
                $('#generar').prop('disabled', 'disabled');
            } else {
                if (peso > 0) {
                    dif = peso2 - peso;
                    $respuesta = "Quedan " + Math.abs(dif) + " libras";
                    //console.log(dif);
                    salida.innerHTML = $respuesta;
                    salida.style.color = "green";
                    $('#generar').prop('disabled', false);
                }
            }
        }
    }

    function limpia() {
        var salida = document.getElementById("salida");
        var peso = document.getElementById("peso-fin");        
        var mostrar = document.getElementById("mostrar_data");
        //var cortes = document.getElementById("cortes");
        salida.innerHTML = "";
        //$("#cortes").val('');
        peso.value = "";
        mostrar.style.display = "none";
    }
</script>

<body>
    <?php include "includes/header.php"; ?>
    <script type="text/javascript" src="funciones.js"></script>
    <section id="container">

        <div class="title_page">
            <h1><?php echo $reporte; ?></h1>

            <div class="datos_desposte">
				<form id="form_pro_fin"  name="form_pro_fin" method="post" style="padding: 0px; border: 0px; background: #00000000;">
					<div class="tipo_reporte col2 full-width">						
                        <p>
                            <label for="Tipo De Materia Prima">Tipo De Producto :</label>
							<select name="tip_prod" id="tip_prod" required>
								<option value="">Seleccionar Tipo de Producto</option>
								<option value="1">Carnes</option>
                                <option value="2">Embutidos</option>
							</select>
                        </p>       
                        <p>
                            <label for="Materia Prima">Materia Prima :</label>
                            <?php
                            $query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
                            $result_tipo = mysqli_num_rows($query_tipo);
                            ?>

                            <select onchange="limpia()" name="prod_terminado" id="prod_terminado" required>
                                <option value="">Seleccionar Materia Prima</option>
                                <?php
                                if ($result_tipo > 0) {
                                    while ($tipo = mysqli_fetch_array($query_tipo)) {
                                ?>
                                        <option value='<?php echo $tipo["id_tip_mat"]; ?>'><?php echo $tipo["nom_tip_mat"] ?></option>
                                <?php
                                    }
                                } ?>
                            </select>
                        </p>
                        <p>
                            <label id="nom_cortes" for="Cortes">Cortes : </label>
                            <select onchange="limpia()" name="cortes" id="cortes" required></select>
                        </p>
                        <p>
                            <label for="Peso">Peso : </label>
                            <input type="text" name="peso-fin" id="peso-fin" maxlength="10" onkeyup="ver_peso()" class="solo-numero" required>
                            <label id="salida" style="font-size:1em; font-weight: bold;"></label>
                        </p>
                        <p class="full-width" style="text-align: center;">
							<input type="submit" name="submit" id="generar" value="Generar" class="btn_guardar_usuario full-width" style="width: auto; padding: 10px;" />
						</p> 
					</div>
				</form>
			</div>
            <br>
            <br>
			<div class="datosp full-width" id="mostrar_data" style="display: none;"></div>
        </div>
    </section>
</body>

</html>
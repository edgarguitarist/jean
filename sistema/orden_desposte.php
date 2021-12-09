<?php
session_start();
if ($_SESSION['rol'] != 1 && $_SESSION['rol'] != 2) {
    header("location: login.php");
}
include "conexion.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <?php include "includes/scripts.php"; ?>
    <title>Orden de Desposte</title>
</head>

<body>
    <?php include "includes/header.php"; ?>
    <?php include "includes/modal.php"; ?>
    <script type="text/javascript" src="funciones.js"></script>
    <section id="container">
        <div class="title_pages">
            <h1>Orden de Desposte</h1>
            <div class="alert"><?php echo isset($alert) ? $alert : ''; ?></div>
            <div class="datos_desposte">
                <div class="action_orden">
                    <h2>Datos</h2>
                    <a href="#" class="btn_nusuario add_corte">Nuevo Corte</a>
                </div>
                <form id="form1" name="form1" method="post" action="envio.php" style="padding: 0px; border: 0px; background: #00000000;">
                    <div class="datosdes full-width">
                        <p>
                            <label for="Tipo de Materia Prima">Tipo de Materia Prima :</label>
                            <?php
                            $query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
                            $result_tipo = mysqli_num_rows($query_tipo);
                            ?>
                            <select name="tip_ma" id="tip_ma" required="">
                                <option value="">Seleccionar Tipo M.Primas</option>
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
                            <label>Serie - Lote de Materia</label>
                            <select name="seri_despost" id="seri_despost" required="">
                            </select>
                        </p>
                    </div>
                    <h3 class="full-width" style="display: none; text-align:center;" id="cortesa">Cortes a Procesar</h3>
                    <div style="display: contents;">
                        <div class="datosp full-width" id="mostrar_data" style="display: none;"></div>
                    </div>
                    <p class="full-width" style="text-align:center;">
                        <input type="submit" name="submit" id="submit" value="Generar Orden" class="btn_guardar_usuario" style="width: auto; margin:auto; padding: 10px; text-align:center;" />
                    </p>
                </form>
            </div>
        </div>
    </section>
</body>

</html>
<?php
include "conexion.php";

if (isset($_POST['obt_cod'])) {

	$id_mat = $_POST['obt_cod'];

	$t_materia = "SELECT * FROM tipo_mat";

	$resultado_t_materia = $conexion->query($t_materia);

	$materias = array();
	while ($row = mysqli_fetch_assoc($resultado_t_materia)) {
		//tomar las primeras 3 letras del nombre de la materia prima
		$materias[$row['id_tip_mat']] = substr($row['nom_tip_mat'], 0, 3);
	}

	$cod = $materias[$id_mat] != null ? $materias[$id_mat] : "emb";


	$queryM = "SELECT id_mat, cod_mat_pri FROM mat_prima WHERE cod_mat_pri LIKE '%$cod%'";
	$resultadoM = $conexion->query($queryM);

	$html = "<option value=''>Seleccionar Materia Prima</option>";

	$html .= "<option value='todos'>Todos</option>";
	while ($rowM = $resultadoM->fetch_assoc()) {
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html .= "<option value='" . $rowM['cod_mat_pri'] . "'>" . $rowM['cod_mat_pri'] . "</option>";
	}
	echo $html;
}

if (isset($_POST['id_estado'])) {
	$id_estado = $_POST['id_estado'];
	$queryM = "SELECT id_mat, cod_mat_pri FROM mat_prima WHERE id_tip_mat = '$id_estado' AND estado_mate = 1";
	$resultadoM = $conexion->query($queryM);

	$html = "<option value=''>Seleccionar Serie o Lote</option>";

	while ($rowM = $resultadoM->fetch_assoc()) {
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html .= "<option value='" . $rowM['id_mat'] . "'>" . $rowM['cod_mat_pri'] . "</option>";
	}
	echo $html;
}

if (isset($_POST['id_mat'])) {

	$id_mat = $_POST['id_mat'];

	$t_materia = "SELECT * FROM tipo_mat";

	$resultado_t_materia = $conexion->query($t_materia);

	$materias = array();
	while ($row = mysqli_fetch_assoc($resultado_t_materia)) {
		//tomar las primeras 3 letras del nombre de la materia prima
		$materias[$row['id_tip_mat']] = substr($row['nom_tip_mat'], 0, 3);
	}

	$cod = $materias[$id_mat] != null ? $materias[$id_mat] : "emb";


	$queryM = "	SELECT *, SUM(peso) AS SUMA 
				FROM prod_terminado 
				WHERE cod_pro LIKE '%$cod%' 
				GROUP BY cortes
				ORDER BY cortes";
	$resultadoM = $conexion->query($queryM);
	if ($cod == 'emb') {
		$html = "<option value=''>Seleccionar Embutido</option>";
	} else {
		$html = "<option value=''>Seleccionar Corte</option>";
	}

	while ($rowM = $resultadoM->fetch_assoc()) {
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html .= "<option value='" . $rowM['SUMA'] . "'>" . $rowM['cortes'] . "</option>";
	}
	echo $html;
}




if (isset($_POST['frm'])) {
	$temp = 0;
	$dif = 0;
	$materia = $_POST['materia'];
	$peso = $_POST['peso'];
	$corte = $_POST['corte'];
	$temp = $peso;

	$consulta = "SELECT * FROM prod_terminado WHERE cortes='$corte'";

	foreach ($conexion->query($consulta) as $tot) {
		$cod_act = $tot['cod_pro'];
		if ($temp > 0) {
			if ($tot['peso'] >= $temp) {
				$dif = $tot['peso'] - $temp;
				$sql = mysqli_query($conexion, "UPDATE prod_terminado SET peso = '$dif' WHERE cod_pro='{$cod_act}'");
				$temp = 0;
				echo '<h1>Datos Actualizados</h1>';
			} else {
				$temp = $temp - $tot['peso'];
				$sql = mysqli_query($conexion, "UPDATE prod_terminado SET peso = 0 WHERE cod_pro='{$cod_act}'");
			}
		}
	}

	if ($temp == 0) {
		$insert = mysqli_query($conexion, "INSERT INTO prod_final(cortes, peso) VALUES('$corte','$peso')");
	}
}

if (isset($_POST['action'])) {
	$queryM = "	SELECT *, SUM(peso) AS SUMA 
				FROM prod_terminado 
				WHERE cod_pro LIKE '%emb%' 
				GROUP BY cortes
				ORDER BY cortes";
	$resultadoM = $conexion->query($queryM);

	$html = "<option value=''>Seleccionar Embutido</option>";

	while ($rowM = $resultadoM->fetch_assoc()) {
		// cambio de id_tip_mat x id_mat para poder identificarlo
		$html .= "<option value='" . $rowM['SUMA'] . "'>" . $rowM['cortes'] . "</option>";
	}
	echo $html;
}

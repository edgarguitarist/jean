<?php
date_default_timezone_set('America/Guayaquil');
if (isset($_GET['busqueda'])) {
	$busqueda = ucwords($_REQUEST['busqueda']) . ucwords($_REQUEST['add_mat']);
	$fecha1 = $_GET['start_date'];
	$fecha2 = date("Y-m-d", strtotime($_GET['end_date'] . "+ 1 days"));
	$search = true;
} else {
	$busqueda = "";
	$fecha1 = "2020-01-01";
	$hoy = date("Y-m-d");
	$fecha2 = date("Y-m-d", strtotime($hoy . "+ 1 days"));
	$search = false;
}
?>

<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">

<script>
	function adding() {
		//limpiar el input
		document.getElementById("busqueda").value = "";
	}
</script>

<?php
$query_pro = mysqli_query($conexion, "SELECT * FROM mat_prima where estado_mate = 0 Order by cod_mat_pri ASC");
$result_pro = mysqli_num_rows($query_pro);
?>
<select name="add_mat" id="add_mat" onchange="adding()">

	<option value="">Buscar Materia Prima</option>
	<?php
	if ($result_pro > 0) {
		while ($pro = mysqli_fetch_array($query_pro)) {
	?>
			<option value="<?php echo $pro["cod_mat_pri"]; ?>"><?php echo $pro["cod_mat_pri"] ?></option>
	<?php
		}
	}
	?>
</select>

</select>

<label for="fecha1" class="form" style="margin: 0px;">Fecha Inicial:</label>
<input id="start_date" type="date" class="f16" name="start_date" step="1" min="2020-01-01" max="<?php echo $hoy; ?>" value="<?php if (isset($_GET['start_date'])) {
																																echo $_GET['start_date'];
																															} else {
																																echo '2020-01-01';
																															} ?>">
<label for="fecha2" class="form" style="margin: 0px;">Fecha Final:</label>
<input id="end_date" type="date" class="f16" name="end_date" step="1" min="2020-01-01" max="<?php echo $hoy; ?>" value="<?php if (isset($_GET['end_date'])) {
																															echo $_GET['end_date'];
																														} else {
																															echo $hoy;
																														} ?>">
<input type="submit" value="Buscar" class="btn_buscar" style="width: auto; padding: 10px;">
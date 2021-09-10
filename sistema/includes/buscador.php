
<?php
		date_default_timezone_set('America/Guayaquil');
		if (isset($_GET['busqueda'])) {
			$busqueda = ucwords($_REQUEST['busqueda']);
			$fecha1 = $_GET['start_date'];
			$fecha2 = date("Y-m-d",strtotime($_GET['end_date']."+ 1 days"));
			$search = true;
		} else {
			$busqueda = "";
			$fecha1 = "2020-01-01";
			$hoy = date("Y-m-d");
			$fecha2 = date("Y-m-d",strtotime($hoy."+ 1 days"));
			$search = false;
		}
?>

<input type="text" name="busqueda" id="busqueda" placeholder="Buscar" value="<?php echo $busqueda; ?>">
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
<?php 
include "conexion.php";

if($id_estado = $_POST['id_est']){


		$consulta="SELECT * from tipo_cortes Where tipo_mat_despo = $id_estado";
		$resultado=mysqli_query($conexion,$consulta);
		$contador = mysqli_num_rows($resultado);	
		if($contador == 0) {
			echo "";
		}elseif($contador == 1){
			echo '<p><input onClick="setAllComplete(\'mostrar_data\', this);" type="checkbox" id="checkbox" name="checkbox[]" value="Completo"><label> Completo</label></p>';
			foreach ($conexion->query("SELECT * from tipo_cortes Where tipo_mat_despo = $id_estado") as $filas)
			{echo '<p><input onClick="NosetAllCheckboxes(\'mostrar_data\', this);" type="checkbox" id="checkbox" name="checkbox[]" value="'; echo $filas['cortes']; echo '"><label> '.$filas['cortes'].'</label></p>';}
		}else{
			echo '<p><input onClick="setAllCheckboxes(\'mostrar_data\', this);" type="checkbox" id="checkbox" name="all" value="Todos"><label> Seleccionar Todos</label></p>';
			echo '<p><input onClick="setAllComplete(\'mostrar_data\', this);" type="checkbox" id="checkbox" name="checkbox[]" value="Completo"><label> Completo</label></p>';
			foreach ($conexion->query("SELECT * from tipo_cortes Where tipo_mat_despo = $id_estado") as $filas)
			{echo '<p><input onClick="NosetAllCheckboxes(\'mostrar_data\', this);" type="checkbox" id="checkbox" name="checkbox[]" value="'; echo $filas['cortes']; echo '"><label> '.$filas['cortes'].'</label></p>';}
		}
		mysqli_close($conexion);
	}else {
		echo "";
		mysqli_close($conexion);
	}












 ?>
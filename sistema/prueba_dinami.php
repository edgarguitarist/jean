<?php include "conexion.php";?>
<div class="lista-ingrediente ">
	<div class="datos">
		<div class="wd30" id="ingre">
			<label for="Tipo de Materia Prima">Tipo Materia Prima :</label>
			<?php
			$query_tipo = mysqli_query($conexion, "SELECT * FROM tipo_mat");
			$result_tipo = mysqli_num_rows($query_tipo);
			?>

			<select name="tip_mat" id="tip_mat" required="">
				<?php
				?>
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
		</div>
		<div class="wd30" id="ingre">
			<label>Ingrediente</label>
			<select name="tipo_cort" id="tipo_cort" required=""></select>
		</div>
		<div class="wd30" id="cant">
			<label>Cantidad Lb</label>
			<input type="tex" name="cantidad[]" id="cantidad" placeholder="" maxlength="10" class="solo-numero" required>
		</div>
		<div class="float-left"><input type="checkbox" name="item_index[]" /></div>

	</div>

</div>
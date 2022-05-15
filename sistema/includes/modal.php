<div id="modal_materia" class="modal">
  <div class="bodyModal form_register">
    <form class="form_modal" action="" id="formModal1" name="formModal1" method="post">

      <h1 class="full-width">Nueva Materia Prima</h1>
      <label style="margin-left:0px;">Tipo De Materia:</label>
      <?php
      $query_rol = mysqli_query($conexion, "SELECT * FROM tipo_empresa");
      $result_rol = mysqli_num_rows($query_rol);
      ?>
      <select onchange="getSufijo();" name="id_tip_emp" id="id_tip_emp">
        <option value="">Seleccionar Tipo Materia</option>
        <?php
        if ($result_rol > 0) {
          while ($rol = mysqli_fetch_array($query_rol)) {
        ?>
            <option value="<?php echo $rol["id_tip_emp"]; ?>"><?php echo $rol["nom_tip_emp"] ?></option>
        <?php
          }
        }
        ?>
      </select>
      <label style="margin-left:0px;">Nombre de Materia Prima:</label>
      <input type="text" name="tip_mat_prim" id="tip_mat_prim" placeholder="Ingrese el Nombre" maxlength="20" required="">
      <div id="alerta-materia" class="full-width"></div>
      <input type="submit" value="Registrar" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
      <a href="#" class="btn_cerrarModal closeModal" onclick="closeModal();">Salir</a>
    </form>
  </div>
</div>

<div id="modal_corte" class="modal">

  <script>
    function getSufijo() {
      //var materia = document.getElementById("rol");
      //var sufijo = document.getElementById("sufijo");

      var combo = document.getElementById("rol");
      var selected = combo.options[combo.selectedIndex].text;
      materia = selected.toLowerCase();
      $("#sufijo").val(materia);

    }
  </script>

  <div class="bodyModal form_register">
    <form class="form_modal" action="" id="formModal2" name="formModal2" method="post">
      <h1 class="full-width">Nuevo Corte</h1>
      <label style="margin-left:0px;">Nombre de la Materia Prima:</label>
      <?php
      $query_rol = mysqli_query($conexion, "SELECT * FROM tipo_mat");
      $result_rol = mysqli_num_rows($query_rol);
      ?>
      <select onchange="getSufijo();" name="rol" id="rol">
        <option value="">Seleccionar Materia Prima</option>
        <?php
        if ($result_rol > 0) {
          while ($rol = mysqli_fetch_array($query_rol)) {
        ?>
            <option value="<?php echo $rol["id_tip_mat"]; ?>"><?php echo $rol["nom_tip_mat"] ?></option>
        <?php
          }
        }
        ?>
      </select>
      <label style="margin-left:0px;">Nombre del Corte:</label>
      <input type="text" name="tipo_corte" id="tipo_corte" placeholder="Ingrese nombre del Corte" maxlength="30" required="" class="letras">
      <input type="hidden" name="sufijo" id="sufijo">
      <div id="alerta-corte" class="full-width"></div>

      <input type="submit" value="Registrar" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
      <a href="#" class="btn_cerrarModal closeModal" onclick="closeModal();">Salir</a>
    </form>
  </div>
</div>
<div id="modal_condimento" class="modal">
  <div class="bodyModal form_register">
    <form class="form_modal" action="" id="formModal3" name="formModal3" method="post">
      <h1 class="full-width">Nuevo Condimento</h1>
      <label style="margin-left:0px;">Nombre del Condimento:</label>
      <input type="text" name="nombre_condi" id="nombre_condi" placeholder="Ingrese el Nombre" maxlength="30" required="">
      <div id="alerta-condimento" class="full-width"></div>
      <input type="submit" value="Registrar" class="btn_guardar_usuario" style="width: auto; padding: 10px;">
      <a href="#" class="btn_cerrarModal closeModal" onclick="closeModal();">Salir</a>
    </form>
  </div>
</div>
<?php

session_start();
if ($_SESSION['rol'] !=1 && $_SESSION['rol'] !=2) {
	header("location: login.php");
}

include "conexion.php";


$html = "";
if (!empty($_POST)) {
    if ($_POST['action'] == 'buscar_list_pro') {
        if (empty($_POST['busqueda'])) {
            echo 'vacio';
        } else {
            $busqueda = $_POST['busqueda'];
            
            $html .= "<table>
	    	<tr>
	    		<th>ID</th>
	    		<th>Cedula</th>
	    		<th>Apellido</th>
	    		<th>Nombre</th>
	    		<th>Celular</th>
	    		<th>Correo</th>
	    		<th>Direccion</th>
	    		<th>Ruc</th>
	    		<th>Razon Social</th>
	    		<th>Nombre Empresa</th>
	    		<th>Direccion Empresa</th>
	    		<th>Correo Empresa</th>
	    		<th>Telefono Empresa</th>
	    		<th>Tipo Proveedor</th>
	    		<th>Fecha de Registro</th>
	    		<th>Acciones</th>
            </tr>";

            $rol = '';
            if ($busqueda == 'carne') {
                $rol = "OR id_tip_emp LIKE '%1%' ";
            } else if ($busqueda == 'pollo') {
                $rol = "OR id_tip_emp LIKE '%2%' ";
            } else if ($busqueda == 'chivo') {
                $rol = "OR id_tip_emp LIKE '%3%' ";
            }


            $sql_registe = mysqli_query($conexion, "SELECT COUNT(*) as total_registro FROM proveedor 
	    		WHERE (id_prov LIKE '%$busqueda%'
	    		OR ced_pro LIKE '%$busqueda%' 
	    		OR ape_pro LIKE '%$busqueda%' 
	    		OR nom_pro LIKE '%$busqueda%'
	    		OR cel_pro LIKE '%$busqueda%'
	    		OR cor_pro LIKE '%$busqueda%'
	    		OR dir_pro LIKE '%$busqueda%' 
	    		OR ruc_emp LIKE '%$busqueda%'
	    		OR raz_emp LIKE '%$busqueda%'
	    		OR nom_emp LIKE '%$busqueda%'
	    		OR dir_emp LIKE '%$busqueda%'
	    		OR cor_emp LIKE '%$busqueda%'
	    		OR tel_emp LIKE '%$busqueda%' 
	    		$rol) AND estado = 1");


            $result_register = mysqli_fetch_array($sql_registe);
            $total_registro = $result_register['total_registro'];

            $por_pagina = 10;
            if (empty($_GET['pagina'])) {
                $pagina = 1;
            } else {
                $pagina = $_GET['pagina'];
            }
            $desde = ($pagina - 1) * $por_pagina;
            $total_paginas = ceil($total_registro / $por_pagina);

            /////////////////////////////


            $query = mysqli_query($conexion, "SELECT  u.id_prov, u.ced_pro, u.ape_pro, u.nom_pro, u.cel_pro, u.cor_pro, u.dir_pro, u.ruc_emp, u.raz_emp, u.nom_emp, u.dir_emp, u.cor_emp, u.tel_emp, t.nom_tip_emp, u.fech_reg_pro FROM proveedor u INNER JOIN tipo_empresa t ON u.id_tip_emp = t.id_tip_emp  
	    		WHERE (
	    		    u.id_prov LIKE '%$busqueda%'
		    	 OR u.ced_pro LIKE '%$busqueda%' 
		    	 OR u.ape_pro LIKE '%$busqueda%' 
		    	 OR u.nom_pro LIKE '%$busqueda%'
		    	 OR u.cel_pro LIKE '%$busqueda%' 
		    	 OR u.cor_pro LIKE '%$busqueda%' 
		    	 OR u.dir_pro LIKE '%$busqueda%' 
		    	 OR u.ruc_emp LIKE '%$busqueda%' 
		    	 OR u.raz_emp LIKE '%$busqueda%'
		    	 OR u.nom_emp LIKE '%$busqueda%'
		    	 OR u.dir_emp LIKE '%$busqueda%'
		    	 OR u.cor_emp LIKE '%$busqueda%'
		    	 OR u.tel_emp LIKE '%$busqueda%' 
		    	 OR	u.fech_reg_pro LIKE '%$busqueda%'
		    	 OR	t.nom_tip_emp LIKE '%$busqueda%')
	    		  AND estado = 1 ORDER BY u.id_prov ASC LIMIT $desde,$por_pagina");
            mysqli_close($conexion);

            $result = mysqli_num_rows($query);
            if ($result > 0) {
                while ($data = mysqli_fetch_array($query)) {
                    $formato_fe = 'Y-m-d H:i:s';
                    $fecha = DateTime::createFromFormat($formato_fe, $data["fech_reg_pro"]);
                    $html .= "
                <tr>
	    	 	<td>" . $data['id_prov'] . "</td>
	    		<td>" . $data["ced_pro"] . "</td>
	    		<td>" . $data["ape_pro"] . "</td>
	    		<td>" . $data["nom_pro"] . "</td>
	    		<td>" . $data["cel_pro"] . "</td>
	    		<td>" . $data["cor_pro"] . "</td>
	    		<td>" . $data["dir_pro"] . "</td>	    
	    		<td>" . $data["ruc_emp"] . "</td>
	    		<td>" . $data["raz_emp"] . "</td>
	    		<td>" . $data["nom_emp"] . "</td>
	    		<td>" . $data["dir_emp"] . "</td>
	    		<td>" . $data["cor_emp"] . "</td>
	    		<td>" . $data["tel_emp"] . "</td>
	    		<td>" . $data["nom_tip_emp"] . "</td>
	    		<td>" . $fecha->format('d-m-Y') . "</td>
	    		<td>
                <a class='link_edit' href='editar_proveedor.php?id=" . $data['id_prov'] . ">Editar</a>";
                if ($_SESSION['rol'] == 1) {
                    $html .= "
                    <a class='link_delete' href='eliminar_proveedor.php?id=" . $data["id_prov"] . ">Eliminar</a>";
                }
                    $html .= "
	    		</td>
	    	    </tr>";
                }
            }
        }
        echo $html;
        exit;
    }
    exit;
}

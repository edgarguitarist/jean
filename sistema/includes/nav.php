 <nav>
   <ul>
     <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
     <?php
      if ($_SESSION['rol'] == 1) {
      ?>
       <li class="principal"><a href="usuario.php"><i class="fas fa-users"></i> Usuarios</a>
         <ul>
           <li><a href="usuario.php">Nuevo Usuario</a></li>
           
             <li><a href="lista-usuario.php">Lista de Usuarios</a></li>
           
         </ul>
       </li>
       <?php } ?>
       <?php if ($_SESSION['rol'] != 3) { ?>
       <li class="principal"><a href="proveedor.php"><i class="fas fa-truck"></i> Proveedores</a>
         <ul>
           <li><a href="proveedor.php">Nuevo Proveedor</a></li>
           <li><a href="lista-proveedor.php">Lista de Proveedores</a></li>
         </ul>
       </li>
     <?php }?>
     
     <li class="principal"><a href="materia_prima.php"><i class="fas fa-arrow-down"></i> Entrada</a>
       <ul>
       <?php if ($_SESSION['rol'] != 3) { ?>
         <li><a href="orden_produc_embu.php">Orden de Embutido <i class="fas fa-arrow-right"></i></a>
           <?php if ($_SESSION['rol'] == 1) { ?>
            
             <ul>
               <li><a href="crear_recetas.php">Crear Receta</a></li>
             </ul>
           <?php } ?>
         </li>
         <li><a href="orden_desposte.php">Orden de Desposte</a></li>
         <?php } ?>
         <li><a href="materia_prima.php">Materia Prima</a></li>
       </ul>
     </li>
     
     <li class="principal"><a href="produc_proce.php"><i class="fas fa-cog fa-spin fa-fw"></i> Producción</a>
       <ul>
         <li><a href="produc_proce.php">Producto Procesar</a></li>

         <li></li>
       </ul>
     </li>

     <li class="principal"><a href="produc_termi.php"><em class="fas fa-arrow-up"></em> Salida</a>
       <ul>
         <li><a href="produc_termi.php">Producto Terminado <i class="fas fa-arrow-right"></i></a>
           <ul>
             <li><a href="produc_termi.php">Prod. Carnicos</a></li>
             <li><a href="produc_termi_emb.php">Prod. Embutidos</a></li>
           </ul>
         </li>
         <li><a href="produc_final.php">Producto Final</a></li>
       </ul>
     </li>

     <li class="principal"><a href="inv_mat_pri.php"><i class="fas fa-table"></i> Inventario</a>
       <ul>
         <li><a href="inv_mat_pri.php">Materia Prima</a></li>
         <li><a href="inv_ord_des.php">Orden de Desposte</a></li>
         <li><a href="inv_pro_pro.php">Producto a Procesar</a></li>
         <li><a href="inv_pro_ter.php">Producto Terminado</a></li>
         <li><a href="inv_ord_emb.php">Orden de Embutido</a></li>
       </ul>
     </li>
     <?php
      if ($_SESSION['rol'] !=3) {
      ?>
       <li class="principal"><a href="merma.php"><i class="fas fa-chart-pie"></i> Reporte</a>
         <ul>
           <li><a href="merma.php">Merma</a></li>
           <li><a href="rep_mat_pri.php">Materia Prima</a></li>
           <li><a href="rep_pro_ter.php">Producto Terminado</a></li>
           <li><a href="rep_pro_fin.php">Producto Final</a></li>
           <li><a href="rep_ord_emb.php">Orden de Embutido</a></li>
         </ul>
       </li>
     <?php } ?>
   </ul>
 </nav>
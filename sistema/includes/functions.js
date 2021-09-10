/***************Modal***********


$(document).ready(function () {
  ****BUSCAR PROVEEDOR**
  $("#ced_proveedor").onkeyup(function (e) {
    e.preventDefault();
    var pro = $(this).val();
    var action = "searchProveedor";

    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: { action: action, cliente: pro },
      success: function (response) {
        if (response == 0) {
          //limpiar campos
          $("#idproveedor").val("");
          $("#nom_proveedor").val("");
          $("#ruc_empresa").val("");
          $("#nom_empresa").val("");
        } else {
          //mostras datos
          var data = $.parseJSON(response);
          $("#idproveedor").val(data.id_prov);
          $("#nom_proveedor").val(data.nom_pro);
          $("#ruc_empresa").val(data.ruc_emp);
          $("#nom_empresa").val(data.nom_emp);

          //bloquear campos
          $("#nom_proveedor").attr("disabled", "disabled");
          $("#ruc_empresa").attr("disabled", "disabled");
          $("#nom_empresa").attr("disabled", "disabled");
        }
      },
      error: function (error) { },
    });
  });
});*/

//REGISTRAR MATERIA PRIMA///
$(document).ready(function () {
  $("#btn_guar").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: $("#registra_materia_prima").serialize(),
      success: function (data) {
        $("#panel_respuesta").html(data);

        setTimeout(function () {
          $("#panel_respuesta").html("");
        }, 2000);
      },
    });
  });
});

//OCULTAR MOSTRAR DATA

function ocultardata(){		
  var mostrar = document.getElementById("mostrar_data");
  var imprimir = document.getElementById("btn-export");
  mostrar.style.display = "none";
  imprimir.style.display = "none";
}

//REGISTRAR PRODUCTO CARNICO TERMINADO/// modificar
$(document).ready(function () {
  $("#btn_guar").click(function (e) {
    e.preventDefault();
    $.ajax({
      url: "ajax.php",
      type: "POST",
      async: true,
      data: $("#registra_materia_prima").serialize(),
      success: function (data) {
        $("#panel_respuesta").html(data);

        setTimeout(function () {
          $("#panel_respuesta").html("");
        }, 4000);
      },
    });
    return false;
  });
  return false;
});


//////////////////////////////////
///////////////////BALANZA/////////////

$(document).ready(function () {
  //;

  function obtener_datos() {
    $.ajax({
      url: "conex_balanza.php",
      type: "POST",
      async: true,
      success: function (data) {
        $("#peso_lle").val(data);
        //$("#peso_lle").attr("disabled", "disabled"); REHABILITAR
      },
    });
  }
  obtener_datos();
  //setInterval(obtener_datos,10500);
});

///////////////////////////DESPOSTE///////////////////////////////////
// Variables globales
var s1des = 0;
var s2des = 0;
var vacio = "";

/////////////////////selecionar serie o lote//////////////////////////////
$(document).ready(function () {
  $("#tip_ma").change(function () {
    $("#tip_ma option:selected").each(function () {
      id_estado = $(this).val();
      $.post("prueba2.php", { id_estado: id_estado }, function (data) {
        $("#seri_despost").html(data);
      });
    });
  });
});

/////////////////////selecionar materia produc_final//////////////////////////////
$(document).ready(function () {
  $("#prod_terminado").change(function () {
    $("#prod_terminado option:selected").each(function () {
      id_mat = $(this).val();      
      $.post("prueba2.php", { id_mat: id_mat }, function (data) {
        $("#cortes").html(data);
      });
    });
  });
});


//////////////////Elegir cortes///////////////////////////////////
$(document).ready(function () {
  $("#tip_ma").change(function () {
    $("#tip_ma option:selected").each(function () {
      id_est = $(this).val();
      s1des = id_est;
      var letras = document.getElementById("cortesa");
      var mostrar = document.getElementById("mostrar_data");
      if (id_est != 0) {
        letras.style.display = "block";
        mostrar.style.display = "grid";
      } else {
        letras.style.display = "none";
        mostrar.style.display = "none";
      }

      $.post("ele_cortes.php", { id_est: id_est }, function (data) {
        $("#mostrar_data").html(data);
        $("#mostrar_respuesta").html(vacio);
      });
    });
  });
});

//////////////////Elegir serie///////////////////////////////////
$(document).ready(function () {
  $("#seri_despost").change(function () {
    $("#seri_despost option:selected").each(function () {
      id_ser = $(this).val();
      s2des = id_ser;
      $("#mostrar_respuesta").html(vacio);
    });
  });
});

////////////////////////////////////////////////////////////////
////////////////////////SELEC PRODUCTO TERMINADO/////////////////////

$(document).ready(function () {
  $("#ord_desp").change(function () {
    $("#ord_desp option:selected").each(function () {
      orde_des = $(this).val();
      $.post("selec_corte_despo.php", { orde_des: orde_des }, function (data) {
        $("#id_cortes").html(data);
      });
    });
  });
});


////////////////////////AGREGAR PRODUCTO TERMINADO/////////////////////

$(document).ready(function () {
  $("#prod_termina").submit(function (e) {
    var selordpro = $("#ord_desp").val();
    var selpro = $("#id_cortes").val();
    //e.preventDefault();
    //e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "envio.php",
      data: $(this).serialize() + "&selordpro=" + selordpro + "&selpro=" + selpro,
      success: function (response) { 
        setTimeout( function() { /*window.location.href = "http://jossyemb-produc.com/sistema/produc_termi.php";*/ location.reload(); }, 50 ); //recarga tras 50 milisegundos
         //cambiar para subir 12345
      },
    });

  });
});

$(document).ready(function () {
  $("#prod_termina_emb").submit(function (e) {
    var selordpro = $("#ord_desp").val();
    var proemb =1;
    //e.preventDefault();
    //e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "envio.php",
      data: $(this).serialize() + "&selordpro=" + selordpro + "&proemb=" + proemb,
      success: function (response) {        
        setTimeout( function() { window.location.href = "http://jossyemb-produc.com/sistema/produc_termi_emb.php"; }, 50 ); //recarga tras 50 milisegundos
        location.reload(); //cambiar para subir 12345
      },
    });

  });
});

///////DESHABILITAR EL COPIAR Y PEGAR
$(document).ready(function(){
  $('input[type="text"]').on('paste', function(e){
    e.preventDefault();
    //alert('Esta acción está prohibida');
  })
  
  $('input[type="text"]').on('copy', function(e){
    e.preventDefault();
    //alert('Esta acción está prohibida');
  })

  $('input[type="text"]').on('cut', function(e){
    e.preventDefault();
    //alert('Esta acción está prohibida');
  })
})

////////////////////////////////////////////////////////////////
function checkSelect() {
  var selpro = $("#ord_desp").val();
  if (selpro != null) {
    $("#msg_error_pro").hide();
  } else {
    $("#ord_desp").focus();
    $("#msg_error_pro").show();
  }
}

function revisar(){
  gg = Number(document.getElementById('peso_lle').value);
  var selpro = $("#ord_desp").val();
  var selcor = $("#id_cortes").val();
  submito = document.getElementById('add_prod_ter');

  if( selpro!= null){
    $("#msg_error_pro").hide();
  }

  if(selpro != null && selcor != null && gg > 0){
    if(checkPeso()){
      submito.disabled = false;
    }
    //console.log(selpro, selcor, gg)
  }else{
    submito.disabled = true;
  }
}
function revisar2(){
  var gg = Number(document.getElementById('peso_lle').value);
  var selpro = $("#ord_desp").val();
  submito = document.getElementById('submitemb');
  if(selpro != null && gg > 0){
    if(checkPeso2()){
      submito.disabled = false;
    }
    //console.log(selpro, gg)
  }else{
    submito.disabled = true;
    //console.log(selpro, limpio.length)
  }
}
////////////// MOSTRAR LISTA DE CORTE EN PRODUCTO A PROCESAR /////////////////

$(document).ready(function () {
  $("#prod_proce").change(function () {
    $("#prod_proce option:selected").each(function () {
      pro_proc = $(this).val();
      $.post("list_procesar.php", { pro_proc: pro_proc }, function (data) {
        $("#mostrar_data2").html(data);
      });
    });
  });
});
////////////////////////////////////////////////////////////
////////////////////////AGREGAR DESPOSTE/////////////////////

$(document).ready(function () {
  $("#form1").submit(function (e) {
    if ($("input[type=checkbox]:checked").length === 0 && s1des != 5) {
      e.preventDefault();
      e.stopImmediatePropagation();
      alert("Debe seleccionar al menos un Corte");
      return false;
    } else {
      e.preventDefault();
      e.stopImmediatePropagation();
      $.ajax({
        type: "POST",
        url: "envio.php",
        data: $(this).serialize() + "&s1des=" + s1des + "&s2des=" + s2des,
        success: function (response) {
          $("#mostrar_respuesta").html(response);

          $.post("prueba2.php", { id_estado: s1des }, function (data) {
            $("#seri_despost").html(data);
          });
          $("#seri_despost").val("");

          generarPDF(s1des, s2des);
          location.reload();
        },
      });
    }
  });
});


///////////////////////////RECETA///////////////////////////////////
////////////////////////AGREGAR A LISTA RECETAS/////////////////////
$(document).ready(function () {
  $("#add_btn_lista").click(function (e) {
    //e.preventDefault();

    var codproducto = $("#rol").val();
    var cantidad = $("#cantidad_rece").val();
    var action = "addProductoDetalle";
    var nom_rece = $("#nombr_rece").val();
    $.ajax({
      url: "list_receta.php",
      type: "POST",
      async: true,
      data: {
        action: action,
        producto: codproducto,
        cantidad: cantidad,
        nom_re: nom_rece,
      },

      success: function (response) {
        //console.log(response);
        if (response != "error") {
          var info = JSON.parse(response);          
          $("#detalle_venta").html(info.detalle);

          //$("#detalle_venta").html(response);
          $("#rol").val("");
          $("#cantidad_rece").val("0");

          //bloquear contidad
          //$('#cantidad_rece').attr('disabled','disabled');
        } else {
          //console.log(response);
          console.log("no data lista receta");
        }
        viewProcesar();
      },
      error: function (error) { },
    });
  });
});

///////////////Retorna Prod term/////////////////////////////


///////////LIMPIAR LISTA/////////////////
$(document).ready(function () {
  $("#btn_limpiar").click(function (e) {
    e.preventDefault();
    var rows = $("#detalle_venta tr").length;
    if (rows > 0) {
      var action = "anularventa";

      $.ajax({
        url: "list_receta.php",
        type: "POST",
        async: true,
        data: { action: action },

        success: function (response) {
          if (response != "error") {
            location.reload();
          }
        },
        error: function (error) { },
      });
    }
  });
});

///////////CREAR RECETA/////////////////
$(document).ready(function () {
  $("#crear_receta22").click(function (e) {
    e.preventDefault();

    var rows = $("#detalle_venta tr").length;
    if (rows > 0) {
      var action = "procesarLista";

      $.ajax({
        url: "list_receta.php",
        type: "POST",
        async: true,
        data: { action: action },

        success: function (response) {
          console.log("respuesta", response);
          if (response != "error") {
            location.reload();
          } else {
            console.log("no data receta");
          }
        },
        error: function (error) { },
      });
    }
  });
});

//////////////////Ver LISTA//////////////////////////////////
$(document).ready(function () {
  $("#rol_lis_re").change(function () {
    $("#rol_lis_re option:selected").each(function () {
      id_list = $(this).val();
      $("#cant_lis").val(0);
      $("#mostrar_data1").html("");
      $("#cant_lis").change(function () {
        $("#cant_lis option:selected").each(function () {
          id_cant = $(this).val();

          $.post(
            "ver_receta.php",
            { id_list: id_list, id_cant: id_cant },
            function (data) {
              $("#mostrar_data1").html(data);
            }
          );
        });
      });
    });
  });
});
//////////////////MULTIPLICAR CANT LISTA///////////////////////////////////

//////////////////GENeRAR PDF///////////////////////////////////
function generarPDF(cliente, factura) {
  var ancho = 1000;
  var alto = 800;
  //calcular posicion x,y para centrar la ventana
  var x = parseInt(window.screen.width / 2 - ancho / 2);
  var y = parseInt(window.screen.height / 2 - alto / 2);

  $url = "factura/generaFactura.php?cl=" + cliente + "&f=" + factura;
  window.open(
    $url,
    "factura",
    "left=" +
    x +
    ",top=" +
    y +
    ",height=" +
    alto +
    ",width" +
    ancho +
    ",scrollbar=si,location=no,resizable=si,menubar=no"
  );
}

////////////////////////REPORTES//////////////////////////////////
//////////////////////////FIXED
$(document).ready(function() {
  $("#tipo_reporte").change(function() {
    $("#tipo_reporte option:selected").each(function() {
      sel = $(this).val();
      ocultardata()
      $('#tip_ma_m').val('');	
      $("#tip_ma_m option[value='0']").remove();
      if (sel == 2) {
        var data = '';
        data = "<option value='0'>Todos</option>";
        $(data).appendTo("#tip_ma_m");
        $('#dias').prop('disabled', false);					
      } else if (sel == 1) {        
        $("#tip_ma_m option[value='0']").remove();
        $('#dias').prop('disabled', 'disabled');
        $('#dias').val('1');					
      }
    });
  });
});

$(document).ready(function() {
  $("#tip_ma_m").change(function() {
    $("#tip_ma_m option:selected").each(function() {
      ocultardata()
    });
  });
});

$(document).ready(function() {
  $("#tip_pro").change(function() {
    $("#tip_pro option:selected").each(function() {
      ocultardata()
      var pro = $("#tip_pro").val();
      var cars = document.getElementById("cars");
      var embs = document.getElementById("embs");
      if(pro == '1'){
        cars.style.display = "block";
        $("#tip_ma_m").prop("required", true);
        embs.style.display = "none";
        $("#tip_emb").removeAttr("required");
        document.getElementById("tip_ma_m").disabled=false; //Otra Forma
      }else if(pro == '2'){
        //cars.style.display = "none";
        $('#tip_ma_m').val('');
        document.getElementById("tip_ma_m").disabled=true; //Otra Forma
        $("#tip_emb").removeAttr("required");
        $("#tip_ma_m").removeAttr("required");
        //embs.style.display = "block";
        //$("#tip_emb").prop("required", true);
      }
    });
  });
});

$(document).ready(function() {
  $("#tip_prod").change(function() {
    $("#tip_prod option:selected").each(function() {
      var pro = $("#tip_prod").val();
      if(pro == '1'){
        $("#prod_terminado").prop("required", true);
        document.getElementById("prod_terminado").disabled=false; //Otra Forma
        $("#nom_cortes").html('Cortes :');
        $("#cortes").empty();
      }else if(pro == '2'){        
        $('#prod_terminado').val('');
        document.getElementById("prod_terminado").disabled=true; //Otra Forma
        $("#prod_terminado").removeAttr("required");
        $("#nom_cortes").html('Embutidos :');
        $.ajax({
          type: "POST",
          url: "prueba2.php",
          data: $(this).serialize() + '&action=' + 'embutidos',
          success: function(data) {
            $("#cortes").html(data);
          },
        });
      }
    });
  });
});


$(document).ready(function() {
  $("#form_reporte").submit(function(e) {
    var tipo = $("#tipo_reporte").val();
    var materia = $("#tip_ma_m").val();
    var fecha = $("#start_date").val();
    var dias = $("#dias").val();
    var frm = "MERMA"; 
    var mostrar = document.getElementById("mostrar_data");
    var btn_export = document.getElementById('btn-export');
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "t_reporte.php",
      data: $(this).serialize() + "&frm=" + frm + "&tipo=" + tipo + "&materia=" + materia + "&fecha=" + fecha + "&dias=" + dias,
      success: function(response) {
        $("#mostrar_data").html(response);
        //
        mostrar.style.display = "block";
        btn_export.style.display = "block";
      },
    });
  });
});

$(document).ready(function() {
  $("#form_rep_mat").submit(function(e) {    
    var materia = $("#tip_ma_m").val();
    var fecha = $("#start_date").val();
    var fecha2 = $("#end_date").val();
    var frm = "MATPRIMA"; 
    var mostrar = document.getElementById("mostrar_data");
    var btn_export = document.getElementById('btn-export');
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "t_reporte.php",
      data: $(this).serialize() + "&frm=" + frm + "&materia=" + materia + "&fecha=" + fecha + "&fecha2=" + fecha2,
      success: function(response) {
        $("#mostrar_data").html(response);
        mostrar.style.display = "block";
        btn_export.style.display = "block";
      },
    });
  });
});

$(document).ready(function() {
  $("#form_rep_prot").submit(function(e) {
    var tipo = $("#tip_pro").val();
    var materia = $("#tip_ma_m").val();
    var materia2 = $("#tip_emb").val();
    var fecha = $("#start_date").val();
    var fecha2 = $("#end_date").val();
    var frm = "PROTERM"; 
    var mostrar = document.getElementById("mostrar_data");
    var btn_export = document.getElementById('btn-export');
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "t_reporte.php",
      data: $(this).serialize() + "&frm=" + frm + "&tipo=" + tipo + "&materia="  + materia + "&materia2="  + materia2 + "&fecha=" + fecha + "&fecha2=" + fecha2,
      success: function(response) {
        $("#mostrar_data").html(response);
        mostrar.style.display = "block";
        btn_export.style.display = "block";
      },
    });
  });
});


$(document).ready(function() {
  $("#form_rep_prof").submit(function(e) {
    var tipo = $("#tip_pro").val();
    var materia = $("#tip_ma_m").val();
    var materia2 = $("#tip_emb").val();
    var fecha = $("#start_date").val();
    var fecha2 = $("#end_date").val();
    var frm = "PROFINAL"; 
    var mostrar = document.getElementById("mostrar_data");
    var btn_export = document.getElementById('btn-export');
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "t_reporte.php",
      data: $(this).serialize() + "&frm=" + frm + "&tipo=" + tipo + "&materia="  + materia + "&materia2="  + materia2 + "&fecha=" + fecha + "&fecha2=" + fecha2,
      success: function(response) {
        $("#mostrar_data").html(response);
        mostrar.style.display = "block";
        btn_export.style.display = "block";
      },
    });
  });
});




$(document).ready(function() {
  $("#form_rep_ord_emb").submit(function(e) {    
    //var materia = $("#tip_ma_m").val();
    var fecha = $("#start_date").val();
    var fecha2 = $("#end_date").val();
    var frm = "ORDEMB"; 
    var mostrar = document.getElementById("mostrar_data");
    var btn_export = document.getElementById('btn-export');
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "t_reporte.php",
      data: $(this).serialize() + "&frm=" + frm + "&fecha=" + fecha + "&fecha2=" + fecha2,
      success: function(response) {
        $("#mostrar_data").html(response);
        mostrar.style.display = "block";
        btn_export.style.display = "block";
      },
    });
  });
});


$(document).ready(function() {
  $("#form_pro_fin").submit(function(e) {    
    var materia = $("#prod_terminado").val();
    var combo = document.getElementById("cortes");
    var corte = combo.options[combo.selectedIndex].text;
    var court = $("#cortes").val();
    var peso = $("#peso-fin").val();
    var diff= court-peso;
    var frm = "PRODTERM";
    var mostrar = document.getElementById("mostrar_data");
    e.preventDefault();
    e.stopImmediatePropagation();
    $.ajax({
      type: "POST",
      url: "prueba2.php",
      data: $(this).serialize() + "&frm=" + frm + "&materia=" + materia + "&corte=" + corte + "&peso=" + peso,
      success: function(response) {
        $("#mostrar_data").html(response);
        mostrar.style.display = "block";    //hacer que se actualice el peso //jkll
        $("#prod_terminado option:selected").each(function () {
          id_mat = $(this).val();      
          $.post("prueba2.php", { id_mat: id_mat }, function (data) {
            $("#cortes").html(data);
            $("#cortes").val(diff);
            $("#peso-fin").val('');
            $("#peso-fin").focus();
          });
        });
      },
    });
  });
});


function blockday(){
  $('#dias').prop('disabled', 'disabled');
}

/*
document.addEventListener('DOMContentLoaded', function() {
  
  var pdf_container = document.getElementById('pdf_container');
  var btn_export = document.getElementById('btn-export');
  var cabecera = document.getElementById("cabecera");
  var a4_px_width = '100%';
  var a4_heigth = '100vh';
  //var a4_px_width = '842px';		
  //var doc = new jsPDF({orientation: 'landscape',unit: 'in'});
  var doc = new jsPDF("p", "mm", "a4");
  // Export
  btn_export.addEventListener('click', function(e) {
    cabecera.style.display = "block";
    e.preventDefault();			
    // A4 landascape: 11.69x8.27 inches / 842x595px 72dpi
    // NOTE: html2canvas generated canvas sizes change according to the actual screen size.
    // Generated image must be added in proper size, 
    // or #pdf-container must be resized in print sizes before converting it...			
    pdf_container.setAttribute('style', 'width:' + a4_px_width);
    //pdf_container.setAttribute('style', 'heigth:' + a4_heigth);

    html2canvas(pdf_container).then(function(canvas) {
    
      var imgData = canvas.toDataURL('image/png');

      //doc.addImage(imgData, 'PNG', 0, 0, 210.0, 297.0);
      doc.addImage(imgData, 'PNG', 4, 5, 200, height);
      //doc.addImage(imgData, 'PNG', 0, 0, width, height);
      doc.save('gg.pdf');				
      pdf_container.removeAttribute('style');
      
    });			
    cabecera.style.display = "none";
  });
  
});*/

function genPDF(name) {
  const { jsPDF } = window.jspdf;
  var scaleBy = 1;
  cabecera.style.display = "block";
  html2canvas(document.getElementById("pdf_container"), {
    useCORS: true,
    onrendered: (canvas) => {
	  cabecera.style.display = "none";
      let doc = new jsPDF("p", "mm", "a4");
	  
      //Obtengo la dimensión en pixeles en base a la documentación
      // https://github.com/MrRio/jsPDF/blob/ddbfc0f0250ca908f8061a72fa057116b7613e78/jspdf.js#L59
      let a4Size = {
        w: convertPointsToUnit(595.28, "px"),
        h: convertPointsToUnit(841.89, "px")
      };

      let canvastoPrint = document.createElement("canvas");
      let ctx = canvastoPrint.getContext("2d");
      canvastoPrint.width = a4Size.w;
      canvastoPrint.height = a4Size.h;
      ctx.scale(scaleBy, scaleBy);

      // Como mi ancho es mas grande y lo redimencionare, tomo cuanto corresponde esos 595 de el total de mi imagen
      let aspectRatioA4 = a4Size.w / a4Size.h;
      let rezised = canvas.width / aspectRatioA4;

      let printed = 0,
        page = 0;
		
      while (printed < canvas.height) {
        //Tomo la imagen en proporcion a el ancho y alto.
        ctx.drawImage(
          canvas,
          0,
          printed,
          canvas.width,
          rezised,
          0,
          0,
          a4Size.w,
          a4Size.h
        );
        var imgtoPdf = canvastoPrint.toDataURL("image/png");
        let width = doc.internal.pageSize.getWidth() - 10;
        let height = doc.internal.pageSize.getHeight();
        if (page == 0) {
          // si es la primera pagina, va directo a doc
          doc.addImage(imgtoPdf, "PNG", 4, 0, width, height);
        } else {
          // Si no ya tengo que agregar nueva hoja.
          let page = doc.addPage();
          page.addImage(imgtoPdf, "PNG", 4, 2, width, height);
        }
        ctx.clearRect(0, 0, canvastoPrint.width, canvastoPrint.height); // Borro el canvas
        printed += rezised; //actualizo lo que ya imprimi
        page++; // actualizo mi pagina
      }
	  
      doc.save( name + ".pdf");
    }
  });

  function convertPointsToUnit(points, unit) {
    // Unit table from https://github.com/MrRio/jsPDF/blob/ddbfc0f0250ca908f8061a72fa057116b7613e78/jspdf.js#L791
    var multiplier;
    switch (unit) {
      case "pt":
        multiplier = 1;
        break;
      case "mm":
        multiplier = 72 / 25.4;
        break;
      case "cm":
        multiplier = 72 / 2.54;
        break;
      case "in":
        multiplier = 72;
        break;
      case "px":
        multiplier = 96 / 72;
        break;
      case "pc":
        multiplier = 12;
        break;
      case "em":
        multiplier = 12;
        break;
      case "ex":
        multiplier = 6;
      default:
        throw "Invalid unit: " + unit;
    }
    return points * multiplier;
  }
}

///////////////////////ELIMINAR DATOS DE RECETA/////////////
function del_tempo_lista_receta(correlativo) {
  var action = "delProductoDetalle";
  var id_detalle = correlativo;
  $.ajax({
    url: "list_receta.php",
    type: "POST",
    async: true,
    data: { action: action, id_detalle: id_detalle },

    success: function (response) {
      if (response != "error") {
        var info = JSON.parse(response);

        $("#detalle_venta").html(info.detalle);
        //$("#contador").val(info.total);
        $("#rol").val("");
        $("#cantidad_rece").val("0");
      } else {
        $("#detalle_venta").html("");
      }
      viewProcesar();
    },
    error: function (error) { },
  });
}

/////// TRAER DATOS A LA PAGINA SI SALES RECETAS//////////////////
function serchForDetalle(id) {
  var action = "serchForDetalle";
  var user = id;
  $.ajax({
    url: "list_receta.php",
    type: "POST",
    async: true,
    data: { action: action, user: user },

    success: function (response) {
      if (response != "error") {
        var info = JSON.parse(response);
        $("#detalle_venta").html(info.detalle);
        $("#nombr_rece").val(info.totales);

        $("#rol").val("");
        $("#cantidad_rece").val("0");

        //bloquear contidad
        //$('#cantidad_rece').attr('disabled','disabled');
      } else {
        console.log("no data");
      }
      viewProcesar();
    },
    error: function (error) { },
  });
}

////////////////VER -OCULATAR BOTON CREAR RECETA/////////
function viewProcesar() {
  if ($("#detalle_venta tr").length > 0) {
    $("#crear_receta22").show();
  } else {
    $("#crear_receta22").hide();
    $("#nombr_rece").val("");
    $("#cantidad_rece").val("0");
  }
}

///////////////////////////////////////////////////////////////
///////////////////Agregar campos Crear Receta///////////////////////////
//function AgregarMas() {
//  $("<div>").load("prueba_dinami.php", function() {
//    $("#registra_materia_prima").append($(this).html());
//});
//}
//function BorrarRegistro() {
// $('div.lista-ingrediente').each(function(index, item){
// jQuery(':checkbox', this).each(function () {
//       if ($(this).is(':checked')) {
//   $(item).remove();
//     }
//   });
// });
//}
/////////////////////selecionar Crear Recetas//////////////////////////////
// $(document).ready(function(){
// $("#tip_mat").change(function () {

//  $("#tip_mat option:selected").each(function () {
//   id_estado1 = $(this).val();
//   $.post("prueba3.php", { id_estado1: id_estado1 },
//    function(data){
//     $("#tipo_cort").html(data);
//   });
//    });
//  })
//  });

//Modales de Menu - OTROS - Registros


$(document).ready(function () {
  $('.add_materia_prima').click(function (e) {
    e.preventDefault();
    $('#modal_materia').fadeIn();
  });
});

$(document).ready(function () {
  $('.add_corte').click(function (e) {
    e.preventDefault();
    $('#modal_corte').fadeIn();
  });
});

function closeModal() {
  $('.modal').fadeOut();
  $('#tip_mat_prim').val("");
  $('#tipo_corte').val("");
  $('#alerta-materia').html("");
  $('#alerta-corte').html("");
  location.reload()
}

$(document).ready(function () {
  $("#formModal1").submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var action = "addMateriaPrima";
    $.ajax({
      type: "POST",
      url: "list_receta.php",
      data: $(this).serialize() + "&action=" + action,
      success: function (response) {
        $("#alerta-materia").html(response);
      },
    });
  });
});

$(document).ready(function () {
  $("#formModal2").submit(function (e) {
    e.preventDefault();
    e.stopImmediatePropagation();
    var action = "addCorte";
    $.ajax({
      type: "POST",
      url: "list_receta.php",
      data: $(this).serialize() + "&action=" + action,
      success: function (response) {
        $("#alerta-corte").html(response);
      },
    });
  });
});



//**********fUNCIONES DE ORDEN DE DESPOSTE PARA CHECKBOXES**********//

function setAllCheckboxes(divId, sourceCheckbox) {
  divElement = document.getElementById(divId);
  inputElements = divElement.getElementsByTagName('input');

  for (i = 0; i < inputElements.length; i++) {
    if (inputElements[i].type != 'checkbox')
      continue;
    inputElements[i].checked = sourceCheckbox.checked;
    console.log("si");
    if (inputElements[1].checked = true) {
      inputElements[1].checked = false;
    }
  }

}

function setAllComplete(divId, sourceCheckbox) {
  divElement = document.getElementById(divId);
  inputElements = divElement.getElementsByTagName('input');

  for (i = 0; i < inputElements.length; i++) {
    if (sourceCheckbox.checked = true) {
      inputElements[i].checked = false;
    }
  }

}

function NosetAllCheckboxes(divId, sourceCheckbox) {
  divElement = document.getElementById(divId);
  inputElements = divElement.getElementsByTagName('input');
  var aux = 0;
  for (i = 2; i < inputElements.length; i++) {
    if (inputElements[i].checked == false) {
      inputElements[0].checked = false;
      aux = aux + 1;
    }
  }
  if (aux > 0) {
    inputElements[0].checked = false;
    inputElements[1].checked = false;
    console.log("false");
  } else {
    inputElements[0].checked = true;
    inputElements[1].checked = false;
    console.log("true");
  }

}

////MERMA/////
function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
   if ((new Date().getTime() - start) > milliseconds) {
    break;
   }
  }
 }
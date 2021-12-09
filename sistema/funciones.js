///////*VALIDAR RUC///////
function validar() {
  var number = document.getElementById("ruc_empresa").value;
  var dto = number.length;
  var valor;
  var acu = 0;
  if (number == "") {
    alert("No has ingresado ningún dato, por favor ingresar los datos correspondientes.");
    $('input[type="submit"]').attr('disabled','disabled');
  } else {
    for (var i = 0; i < dto; i++) {
      valor = number.substring(i, i + 1);
      if (
        valor == 0 ||
        valor == 1 ||
        valor == 2 ||
        valor == 3 ||
        valor == 4 ||
        valor == 5 ||
        valor == 6 ||
        valor == 7 ||
        valor == 8 ||
        valor == 9
      ) {
        acu = acu + 1;
      }
    }
    if (acu == dto) {
      while (number.substring(10, 13) != 001) {
        alert("Los tres últimos dígitos no tienen el código del RUC 001.");
        $('input[type="submit"]').attr('disabled','disabled');

        return;
      }
      while (number.substring(0, 2) > 24) {
        alert("Los dos primeros dígitos no pueden ser mayores a 24.");
        $('input[type="submit"]').attr('disabled','disabled');
        return;
      }
      alert("El RUC está escrito correctamente");
      alert("Se procederá a analizar el respectivo RUC.");
      var porcion1 = number.substring(2, 3);
      if (porcion1 < 6) {
        alert(
          "El tercer dígito es menor a 6, por lo \ntanto el usuario es una persona natural.\n"
        );
        $('input[type="submit"]').attr('disabled',false);
      } else {
        if (porcion1 == 6) {
          alert(
            "El tercer dígito es igual a 6, por lo \ntanto el usuario es una entidad pública.\n"
          );
          $('input[type="submit"]').attr('disabled',false);
        } else {
          if (porcion1 == 9) {
            alert(
              "El tercer dígito es igual a 9, por lo \ntanto el usuario es una sociedad privada.\n"
              
            );
            $('input[type="submit"]').attr('disabled',false);
          }
        }
      }
    } else {
      alert("ERROR: Por favor no ingrese texto");
    }
  }
}

//////Validar Contraseñas//////

function contras() {
  var clave = document.getElementById("clave").value.trim();
  var reclave = document.getElementById("reclave").value.trim();
  var msg = document.getElementById("msg");
  if(clave != reclave){
    msg.innerHTML = "Las Contraseñas no Coinciden";
    msg.style.color = "red";
    $('input[type="submit"]').attr('disabled','disabled');
  }else{
    msg.innerHTML = "Las Contraseñas Coinciden";
    msg.style.color = "green";
    $('input[type="submit"]').attr('disabled', false);
  }

}

///////////OCULTAR Y MOSTRAR PASSWORD///////////////
function mostrarPassword(){
  var clave = document.getElementById("clave");
  if(clave.type == "password"){
    clave.type = "text";
    $('.gg1').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
  }else{
    clave.type = "password";
    $('.gg1').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
  }
} 


function mostrarPassword2(){
  var reclave = document.getElementById("reclave");
  if(reclave.type == "password"){
    reclave.type = "text";
    $('.gg2').removeClass('fa fa-eye-slash').addClass('fa fa-eye');
  }else{
    reclave.type = "password";
    $('.gg2').removeClass('fa fa-eye').addClass('fa fa-eye-slash');
  }
} 


///////*VALIDAR CEDULA///////

function validar1() {
  var cad = document.getElementById("cedula").value.trim();
  var salida = document.getElementById("salida");
  var total = 0;
  var longitud = cad.length;
  var longcheck = longitud - 1;
  var existe = "0";

  if (
    cad !== "" &&
    longitud === 10 &&
    cad !== "0000000000" &&
    cad !== "1111111111" &&
    cad !== "2222222222" &&
    cad !== "3333333333" &&
    cad !== "4444444444" &&
    cad !== "5555555555" &&
    cad !== "6666666666" &&
    cad !== "7777777777" &&
    cad !== "8888888888" &&
    cad !== "9999999999"
  ) {
    for (i = 0; i < longcheck; i++) {
      if (i % 2 === 0) {
        var aux = cad.charAt(i) * 2;
        if (aux > 9) aux -= 9;
        total += aux;
      } else {
        total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
      }
    }

    total = total % 10 ? 10 - (total % 10) : 0;

    if (cad.charAt(longitud - 1) == total) {
      $.ajax({
        type: "POST",
        url: "cedula.php",
        data: { ced_usu: cad },

        success: function (resultado) {
          existe = resultado;
          if (existe == "1") {
            salida.innerHTML = "Cedula Ya Existe";
            salida.style.color = "red";
            $('input[type="submit"]').attr('disabled','disabled');
          } else {
            salida.innerHTML = "Cedula Valida";
            salida.style.color = "green";
            $('input[type="submit"]').attr('disabled',false);
          }
        },
        error: function (resultado) {
          console.log("Error buscarDatos: " + resultado);
          salida.val("");
        },
      });
    } else {
      salida.innerHTML = "Cedula Inválida";
      salida.style.color = "red";
      $('input[type="submit"]').attr('disabled','disabled');
    }
  } else {
    salida.innerHTML = "La cedula debe contener 10 digitos";
    salida.style.color = "red";
    $('input[type="submit"]').attr('disabled','disabled');
  }
}


function validar3() {
  var cad = document.getElementById("ced_proveedor").value.trim();
  var salida = document.getElementById("salida");
  var salida2 = document.getElementById("salida2");
  var total = 0;
  var longitud = cad.length;
  var longcheck = longitud - 1;
  var existe = "0";

  if (
    cad !== "" &&
    longitud === 10 &&
    cad !== "0000000000" &&
    cad !== "1111111111" &&
    cad !== "2222222222" &&
    cad !== "3333333333" &&
    cad !== "4444444444" &&
    cad !== "5555555555" &&
    cad !== "6666666666" &&
    cad !== "7777777777" &&
    cad !== "8888888888" &&
    cad !== "9999999999"
  ) {
    for (i = 0; i < longcheck; i++) {
      if (i % 2 === 0) {
        var aux = cad.charAt(i) * 2;
        if (aux > 9) aux -= 9;
        total += aux;
      } else {
        total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
      }
    }

    total = total % 10 ? 10 - (total % 10) : 0;

    if (cad.charAt(longitud - 1) == total) {
      $.ajax({
        type: "POST",
        url: "cedula.php",
        data: { ced_pro: cad },

        success: function (resultado) {
          existe = resultado;
          if (existe == "1") {
            salida.innerHTML = "Cedula valida";
            salida.style.color = "green";
            salida2.innerHTML = "";
            salida2.style.color = "";
          } else {
            salida.innerHTML = "Cedula valida";
            salida.style.color = "green";
            salida2.innerHTML = "Proveedor no Encontrado";
            salida2.style.color = "red";
          }
        },
        error: function (resultado) {
          console.log("Error buscarDatos: " + resultado);
          salida.val("");
        },
      });
    } else {
      salida.innerHTML = "Cedula Inválida";
      salida.style.color = "red";
      $('input[type="submit"]').attr('disabled','disabled');
    }
  } else {
    salida.innerHTML = "La cedula debe contener 10 digitos";
    salida.style.color = "red";
    $('input[type="submit"]').attr('disabled','disabled');
  }
}


function validar2() {
  var cad = document.getElementById("cedula").value.trim();
  var salida = document.getElementById("salida");
  var total = 0;
  var longitud = cad.length;
  var longcheck = longitud - 1;
  var existe = "0";

  if (
    cad !== "" &&
    longitud === 10 &&
    cad !== "0000000000" &&
    cad !== "1111111111" &&
    cad !== "2222222222" &&
    cad !== "3333333333" &&
    cad !== "4444444444" &&
    cad !== "5555555555" &&
    cad !== "6666666666" &&
    cad !== "7777777777" &&
    cad !== "8888888888" &&
    cad !== "9999999999"
  ) {
    for (i = 0; i < longcheck; i++) {
      if (i % 2 === 0) {
        var aux = cad.charAt(i) * 2;
        if (aux > 9) aux -= 9;
        total += aux;
      } else {
        total += parseInt(cad.charAt(i)); // parseInt o concatenará en lugar de sumar
      }
    }

    total = total % 10 ? 10 - (total % 10) : 0;

    if (cad.charAt(longitud - 1) == total) {
      $.ajax({
        type: "POST",
        url: "cedula.php",
        data: { ced_usu: cad },

        success: function (resultado) {
          existe = resultado;
          if (existe == "1") {
            salida.innerHTML = "";
            salida.style.color = "red";
          } else {
            salida.innerHTML = "Cedula Valida";
            salida.style.color = "green";
            $('input[type="submit"]').attr('disabled',false);
          }
        },
        error: function (resultado) {
          console.log("Error buscarDatos: " + resultado);
          salida.val("");
        },
      });
    } else {
      salida.innerHTML = "Cedula Inválida";
      salida.style.color = "red";
      $('input[type="submit"]').attr('disabled','disabled');
    }
  } else {
    salida.innerHTML = "La cedula debe contener 10 digitos";
    salida.style.color = "red";
    $('input[type="submit"]').attr('disabled','disabled');
  }
}

//////SOLO NUMERO///////
$(document).ready(function () {
  $(".solo-numero").keyup(function () {
    this.value = (this.value + "").replace(/[^0-9]/g, "");
  });
});

////////////SOLO LETRA////////
$(document).ready(function () {
  $(".letras").keypress(function (e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toLowerCase(),
      letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  });
});

///////DESHABILITAR EL COPIAR Y PEGAR
$(document).ready(function(){
  $('input').on('paste', function(e){
    e.preventDefault();    
  })
  
  $('input').on('copy', function(e){
    e.preventDefault();
  })




})

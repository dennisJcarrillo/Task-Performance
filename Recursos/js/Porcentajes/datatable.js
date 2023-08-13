import {estadoValidado as validado } from './ValidacionesModalNuevoPorcentaje.js';
import {estadoValidado as valido } from './ValidacionesModalEditarPorcentaje.js';

let tablaPorcentajes = '';
$(document).ready(function () {
  tablaPorcentajes = $('#table-Porcentajes').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Porcentajes/obtenerPorcentajes.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "idPorcentaje"},
      { "data": "valorPorcentaje" },
      { "data": "descripcionPorcentaje" },
      { "data": "estadoPorcentaje" },
      {"defaultContent":
          '<div><button class="btns btn" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button></div>'
      }
    ]
  });
});
$('#btn_nuevoRegistro').click(function () {
  // //Petición para obtener

  // obtenerContactoCliente('#estadoContacto');
  //Petición para obtener estado de usuario
  // obtenerEstadoUsuario('#estado');
  // $(".modal-header").css("background-color", "#007bff");
  // $(".modal-header").css("color", "white");	 
});
//Crear nuevo usuario
$('#form-Porcentajes').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let valorPorcentaje = $('#valorPorcentaje').val();
     let descripcionPorcentaje = $('#descripcionPorcentaje').val();
     let estadoPorcentaje= $('#estadoPorcentaje').val();
    //  let estado = document.getElementById('estado').value;
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/Porcentajes/nuevoPorcentaje.php",
        type: "POST",
        datatype: "JSON",
        data: {
          valorPorcentaje: valorPorcentaje,
          descripcionPorcentaje: descripcionPorcentaje,
          estadoPorcentaje: estadoPorcentaje          
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Porcentaje Registrado!',
           'success',
         )
         tablaPorcentajes.ajax.reload(null, false);
        }
      });
     $('#modalNuevoPorcentaje').modal('hide');
    } 
});

// let obtenerContactoCliente = function (idElemento) {
//   //Petición para obtener estados contacto clientes
//   $.ajax({
//     url: '../../../Vista/crud/carteraCliente/obtenerContactoCliente.php',
//     type: 'GET',
//     dataType: 'JSON',
//     success: function (data) {
//       let valores = '<option value="">Seleccionar...</option>';
//       for (let i = 0; i < data.length; i++) {
//         valores += '<option value="' + data[i].id_estadoContacto + '">' + data[i].contacto_Cliente +'</option>';
//       }
//       $(idElemento).html(valores);
//     }
//   });
// }

//Editar Porcentaje
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  idPorcentaje = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  valorPorcentaje = fila.find('td:eq(1)').text(),
  descripcionPorcentaje = fila.find('td:eq(2)').text(),
  estadoPorcentaje = fila.find('td:eq(3)').text();
  $("#E_idPorcentaje").val(idPorcentaje);
  $("#E_valorPorcentaje").val(valorPorcentaje);
  $("#E_descripcionPorcentaje").val(descripcionPorcentaje);
  $("#E_estadoPorcentaje").val(estadoPorcentaje);
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	
  $('#modalEditarPorcentaje').modal('show');		   
});

$('#form-Edit-Porcentaje').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Cliente
   let 
   idPorcentaje = $('#E_idPorcentaje').val(),
   valorPorcentaje = $('#E_valorPorcentaje').val(),
   descripcionPorcentaje =  $('#E_descripcionPorcentaje').val(),
   estadoPorcentaje = $('#E_estadoPorcentaje').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/Porcentajes/editarPorcentaje.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idPorcentaje: idPorcentaje,
       valorPorcentaje: valorPorcentaje,
       descripcionPorcentaje: descripcionPorcentaje,
       estadoPorcentaje: estadoPorcentaje
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El Porcentaje ha sido modificado!',
          'success',
        )
         tablaPorcentajes.ajax.reload(null, false);
      }
    });
    $('#modalEditarPorcentaje').modal('hide');
   }
});

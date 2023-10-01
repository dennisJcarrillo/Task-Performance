import {estadoValidado as validado } from './validacionesModalNuevoUsuario.js';
import {estadoValidado as valido } from './validacionesModalEditarUsuario.js';

let tablaUsuarios = '';
$(document).ready(function () {
  tablaUsuarios = $('#table-Usuarios').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/usuario/obtenerUsuarios.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "IdUsuario"},
      { "data": "usuario" },
      { "data": "nombreUsuario" },
      { "data": "correo" },
      { "data": "Estado" },
      { "data": "Rol" },

      {"defaultContent":
          '<div><button class="btns btn" id="btn_ver"><i class="fa-solid fa-eye"></i></button>' +
          '<button class="btn-editar btns btn hidden" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>'
      }
    ]
  });
});

// Cuando presionamos el boton aparece el modal con los siguientes campos

$('#btn_nuevoRegistro').click(async function () {
  // //Petición para obtener roles 
  obtenerRoles('#rol');
  //Petición para obtener estado de usuario
  obtenerEstadoUsuario('#estado');
  //se obtiene la fecha de hoy
  let fechaC = new Date().toISOString().slice(0, 10);
  $("#fecha_C").val(fechaC);
  //se obtiene la fecha de Vencimiento
  let vigencia = await obtenerVigencia()
  let fechaV = new Date()
  //se calcula la fecha de hoy + los dias de vigencia
  fechaV.setDate(fechaV.getDate() + parseInt(vigencia['Vigencia']))
  $("#fecha_V").val(fechaV.toISOString().slice(0, 10));
  $(".modal-header").css("background-color", "#007bff");
  $(".modal-header").css("color", "white");	 
});

//Crear nuevo usuario
$('#form-usuario').submit(async function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let nombre = $('#nombre').val();
     let usuario = $('#usuario').val();
     let password = $('#password').val();
     let correo = $('#correo').val();
     let rol = document.getElementById('rol').value;
    //  let estado = document.getElementById('estado').value;
    //cambio 1
    let fechaV = $('#fecha_V').val(); 
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/usuario/nuevoUsuario.php",
        type: "POST",
        datatype: "JSON",
        data: {
          nombre: nombre,
          usuario: usuario,
          contrasenia: password,
          correo: correo,
          idRol: rol,
          fechaV: fechaV
        },
        success: function (res) {
          //Mostrar mensaje de exito
          console.log(res);
          Swal.fire(
           'Registrado!',
           'Se le ha enviado un correo al usuario!',
           'success',
         )
         tablaUsuarios.ajax.reload(null, false);
        }
      });
     $('#modalNuevoUsuario').modal('hide');
    } 
});
// $(document).on( async function(){
// });


//Eliminar usuario
$(document).on("click", "#btn_eliminar", function() {
  let fila = $(this);        
    let usuario = $(this).closest('tr').find('td:eq(1)').text();		    
    Swal.fire({
      title: 'Estas seguro de eliminar a '+usuario+'?',
      text: "No podras revertir esto!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/usuario/eliminarUsuario.php",
          type: "POST",
          datatype:"json",    
          data:  { usuario: usuario},    
          success: function(data) {
            // let estadoEliminado = data[0].estadoEliminado;
            // console.log(data);
            // if(estadoEliminado == 'eliminado'){
              tablaUsuarios.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'El usuario ha sido eliminado.',
                'success'
              )  
            // } else {
            //   Swal.fire(
            //     'Lo sentimos!',
            //     'El usuario no puede ser eliminado.',
            //     'error'
            //   );
            // }           
          }
          }); //Fin del AJAX
      }
    });                
});

$(document).on("click", "#btn_editar", async function(){		                
  let idUsuario = $(this).closest('tr').find('td:eq(0)').text(); //capturo el ID		            
  let usuario = await obtenerUsuariosPorId(idUsuario)
  obtenerRoles('#E_rol', usuario.Id_Rol);
  obtenerEstadoUsuario('#E_estado', usuario.Id_Estado_Usuario);
  $("#E_IdUsuario").val(idUsuario);
  $("#E_nombre").val(usuario['Nombre_Usuario']);
  $("#E_usuario").val(usuario['Usuario']);
  // $("#E_password").val(contrasenia);
  $("#E_correo").val(usuario['Correo_Electronico']);
  if (!!usuario['Fecha_Creacion']) {
    let date = new Date(usuario['Fecha_Creacion'].date)
    $("#E_fecha_C").val(date.toISOString().slice(0, 10));
  }
  if (!!usuario['Fecha_Vencimiento']) {
    let dateV = new Date(usuario['Fecha_Vencimiento'].date)
    $("#E_fecha_V").val(dateV.toISOString().slice(0, 10));
  } else {
    // Limpiar el valor del campo #E_fecha_V
    $("#E_fecha_V").val('');
}
  $('#modalEditarUsuario').modal('show');		   
});

$('#form-Edit-Usuario').submit(function (e) { 
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let nombre = $('#E_nombre').val(),
   idUser =  $('#E_IdUsuario').val(),
   usuario = $('#E_usuario').val(),
   correo = $('#E_correo').val(),
   rol = document.getElementById('E_rol').value,
   estado = document.getElementById('E_estado').value;
   /////////////////////////////////////////////////////////////////////////////
   console.log(valido)
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/usuario/editarUsuario.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idUsuario: idUser,
       nombre: nombre,
       usuario: usuario,
       correo: correo,
       idRol: rol,
       idEstado: estado
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El usuario ha sido modificado!',
          'success',
        )
         tablaUsuarios.ajax.reload(null, false);
      }
    });
    $('#modalEditarUsuario').modal('hide');
   }
});

//obtener datos para el modal editar
let obtenerUsuariosPorId = async (idUsuario) => {
  try {
    let datos = await $.ajax({
      url: '../../../Vista/crud/usuario/obtenerUsuarioPorId.php',
      type: 'GET',
      dataType: 'JSON',
      data: {
        IdUsuario: idUsuario
      }
    });
    return datos
  } catch(err) {
    console.error(err)
  }
}

let obtenerVigencia = async () =>{
    try {
      let dato = await $.ajax({
        url: '../../../Vista/crud/usuario/obtenerVigencia.php',
        type: 'GET',
        dataType: 'JSON'
      });
      return dato
    } catch(err) {
      console.error(err)
  }
}

let obtenerRoles = function (idElemento, rol_id) {
  //Petición para obtener roles
  $.ajax({
    url: '../../../Vista/crud/usuario/obtenerRoles.php',
    type: 'GET',
    dataType: 'JSON',
    success: function (data) {
      let valores = '<option value="">Seleccionar...</option>';
      //Recorremos el arreglo de roles que nos devuelve la peticion

      for (let i = 0; i < data.length; i++) {
        valores += '<option value="' + data[i].id_Rol + '"'+ (data[i].id_Rol === rol_id ? 'selected': '') +'>' + data[i].rol + '</option>';
        $(idElemento).html(valores);
      }
    }
    });
}
let obtenerEstadoUsuario = function (idElemento, estado_id){
    //Petición para obtener estado de usuario
    $.ajax({
      url: '../../../Vista/crud/usuario/obtenerEstadosUsuario.php',
      type: 'GET',
      dataType: 'JSON',
      success: function (data) {
        let valores = '<option value="">Seleccionar...</option>';
        //Recorremos el arreglo de roles que nos devuelve la peticion
        for (let i = 0; i < data.length; i++) {
          valores += '<option value="' + data[i].id_Estado_Usuario + '"'+ (data[i].id_Estado_Usuario === estado_id ? 'selected': '') +'   >' + data[i].descripcion + '</option>';
          $(idElemento).html(valores);
        }
      }
    });
}
document.getElementById('btn-cerrar').addEventListener('click', ()=>{
  limpiarForm();
})
document.getElementById('btn-x').addEventListener('click', ()=>{
  limpiarForm();
})
let limpiarForm = () => {
  let $inputs = document.querySelectorAll('.mensaje_error');
  let $mensajes = document.querySelectorAll('.mensaje');
  $inputs.forEach($input => {
    $input.classList.remove('mensaje_error');
  });
  $mensajes.forEach($mensaje =>{
    $mensaje.innerText = '';
  });
  let nombre = document.getElementById('nombre'),
    usuario = document.getElementById('usuario'),
    password = document.getElementById('password'),
    password2 = document.getElementById('password2'),
    correo = document.getElementById('correo'),
    rol = document.getElementById('rol'),
    estado = document.getElementById('estado'),
    fecha_C = document.getElementById('fecha_C'),
    fecha_V = document.getElementById('fecha_V');
  //Vaciar campos cliente
    nombre.value = '';
    usuario.value = '';
    password.value = '';
    password2.value = '';
    correo.value = '';
    rol.value = '';
    estado.value = '';
    fecha_C.value = '';
    fecha_V.value = ''; 
}







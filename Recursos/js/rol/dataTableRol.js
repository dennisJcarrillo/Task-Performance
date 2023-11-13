import {estadoValidado as validado} from './validacionesModalNuevoRol.js';
import {estadoValidado as valido } from './validacionesModalEditarRol.js';
let tablaRol = '';
$(document).ready(function () {
  let $idObjetoSistema = document.querySelector('.title-dashboard-task').id;
  // console.log($idObjetoSistema);
  obtenerPermisos($idObjetoSistema, procesarPermisoActualizar);
});
let procesarPermisoActualizar = data => {
  let permisos = JSON.parse(data);
  // console.log(permisos);
  tablaRol = $('#table-Rol').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/rol/obtenerRoles.php",
      "dataSrc": ""
    },
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "id_Rol" },
      { "data": 'rol' },
      { "data": 'descripcion' },
      {
        "defaultContent":
        `<button class="btns btn ${(permisos.Actualizar == 'N')? 'hidden': ''}" id="btn_editar"><i class="fa-solid fa-pen-to-square"></i></button>`+
        '<button class="btns btn" id="btn_eliminar"><i class="fa-solid fa-trash"></i></button></div>'
      }
    ]
  });
}
//Peticion  AJAX que trae los permisos
let obtenerPermisos = function ($idObjeto, callback) { 
  $.ajax({
      url: "../../../Vista/crud/permiso/obtenerPermisos.php",
      type: "POST",
      datatype: "JSON",
      data: {idObjeto: $idObjeto},
      success: callback
  });
}

// Crear nuevo rol
$('#form-Rol').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
     //Obtener datos del nuevo Usuario
     let rol = $('#rol').val();
     let descripcion = $('#descripcion').val();
    if(validado){
      $.ajax({
        url: "../../../Vista/crud/rol/nuevoRol.php",
        type: "POST",
        datatype: "JSON",
        data: {
          rolUsuario: rol,
          descripcionRol: descripcion,
        },
        success: function () {
          //Mostrar mensaje de exito
          Swal.fire(
           'Registrado!',
           'Se ha registrado un nuevo Rol de Usuario!',
           'success',
         )
         tablaRol.ajax.reload(null, false);
        }
      });
     $('#modalNuevoRol').modal('hide');
    } 
});

//Editar un rol
$(document).on("click", "#btn_editar", function(){		        
  let fila = $(this).closest("tr"),	        
  id_Rol = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
  rol = fila.find('td:eq(1)').text(),
  descripcion = fila.find('td:eq(2)').text();
  if (rol == 'Super Administrador'){
    Swal.fire(
      'Sin acceso!',
      'Super Administrador no puede ser editado',
      'error'
    )
  }else{
    $("#E_idRol").val(id_Rol);
    $("#E_rol").val(rol);
    $("#E_descripcion").val(descripcion);
    $(".modal-header").css("background-color", "#007bff");
    $(".modal-header").css("color", "white");	
    $('#modalEditarRol').modal('show')
  }
 ;		   
});

$('#form-Edit-Rol').submit(function (e) {
  e.preventDefault(); //evita el comportambiento normal del submit, es decir, recarga total de la página
   //Obtener datos del nuevo Usuario
   let idRol = $('#E_idRol').val(),
   descripcion = $('#E_descripcion').val();
   if(valido){
    $.ajax({
      url: "../../../Vista/crud/rol/editarRol.php",
      type: "POST",
      datatype: "JSON",
      data: {
       idRol: idRol,
       descripcion: descripcion
      },
      success: function () {
        //Mostrar mensaje de exito
        Swal.fire(
          'Actualizado!',
          'El Rol ha sido modificado!',
          'success',
        )
        tablaRol.ajax.reload(null, false);
      }
    });
    $('#modalEditarRol').modal('hide');
   }
});

//Limpiar modal de crear
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
  let rol = document.getElementById('rol'),
    descripcion = document.getElementById('descripcion');
  //Vaciar campos cliente
    rol.value = '';
    descripcion.value = ''; 
}

//Limpiar modal de editar
document.getElementById('button-cerrar').addEventListener('click', ()=>{
  limpiarFormEdit();
})
document.getElementById('button-x').addEventListener('click', ()=>{
  limpiarFormEdit();
})
let limpiarFormEdit = () => {
  let $inputs = document.querySelectorAll('.mensaje_error');
  let $mensajes = document.querySelectorAll('.mensaje');
  $inputs.forEach($input => {
    $input.classList.remove('mensaje_error');
  });
  $mensajes.forEach($mensaje =>{
    $mensaje.innerText = '';
  });
}


//Eliminar Rol
$(document).on("click", "#btn_eliminar", function() {
     
  let fila = $(this).closest("tr"),	        
    id_Rol = $(this).closest('tr').find('td:eq(0)').text(), //capturo el ID		            
    ROL = $(this).closest('tr').find('td:eq(1)').text();
    if (ROL == 'Super Administrador'){
      Swal.fire(
        'Sin acceso!',
        'Super Administrador no puede ser eliminado',
        'error'
      )
      }else{
        Swal.fire({
          title: 'Estas seguro de eliminar el Rol '+ROL+'?',
          text: "No podras revertir esto!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Si, borralo!'
    }).then((result) => {
      if (result.isConfirmed) {      
        $.ajax({
          url: "../../../Vista/crud/rol/eliminarRol.php",
          type: "POST",
          datatype:"json",    
          data:  { id_Rol : id_Rol},    
          success: function(data) {
            let estadoEliminado = data[0].estadoEliminado;
             console.log(data);
             if(estadoEliminado == 'eliminado'){
              tablaRol.row(fila.parents('tr')).remove().draw();
              Swal.fire(
                'Eliminado!',
                'El Rol ha sido eliminada.',
                'success'
              ) 
              tablaRol.ajax.reload(null, false);
            } else {
               Swal.fire(
                 'Lo sentimos!',
                 'El Rol no puede ser eliminado.',
                 'error'
               );
               tablaRol.ajax.reload(null, false);
             }           
          }
          }); //Fin del AJAX
      }
    });  
  }              
});
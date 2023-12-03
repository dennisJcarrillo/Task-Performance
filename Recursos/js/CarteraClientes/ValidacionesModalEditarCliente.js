import * as funciones from '../funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
let estadoExisteRtn = false;

const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\/ .ÑñáéíóúÁÉÍÓÚs])+$/, //Solo letras
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/,
    soloNumeros: /^[0-9,-]*$/,
    MismoCaracter: /^(?=.*(..)\1)/, 
}
//VARIABLES GLOBALES

let estadoEspacioInput = {
    estadoEspacioName: true,
    estadoEspaciotelefono: true,
    estadoEspacioDireccion: true,
    estadoEspacioRtn: true,
    estadoEspacioCorreo: true,
}
  


let estadoSelect = {
    estadoSelectCorreo: true,
    estadoSelecttelefono: true,
    estadoSelectDireccion: true,
    estadoSelectName: true,
    estadoSelectRtn:true,
}
let estadoMasdeUnEspacio = {
        estadoMasEspacioCorreo:true,
        estadoMasEspacioDireccion:true,
        estadoMasEspaciotelefono:true,
        estadoMasEspacioRtn:true,
        estadoMasEspacioName:true,

}

let estadoSoloLetras = {
    estadoLetrasDireccion:true,
    estadoLetrasName:true,
  

}
let estadoSoloNumeros = {
    estadoNumerortn :false,
    estadoNumerotelefono :false,
}

let estadoCorreo = true;

const $form = document.getElementById('form-editar-carteraCliente');
const $name = document.getElementById('E_Nombre');
const $rtn = document.getElementById('E_Rtn');
const $telefono = document.getElementById('E_Telefono');
const $correo = document.getElementById('E_Correo');
const $direccion = document.getElementById('E_Direccion');
const $estadoContacto = document.getElementById('E_estadoContacto');

/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {
    //Validamos que algún campo no esté vacío.
    let estadoInputName = funciones.validarCampoVacio($name);
    let estadoInputtelefono = funciones.validarCampoVacio($telefono);
    let estadoInputDireccion = funciones.validarCampoVacio($direccion);
    let estadoInputRtn = funciones.validarCampoVacio($rtn);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputName == false || estadoInputtelefono  == false || estadoInputRtn == false || estadoInputCorreo == false  || estadoInputDireccion == false) {
        e.preventDefault();
    }else{
        if(estadoEspacioInput.estadoEspacioName == false || estadoEspacioInput.estadoEspaciotelefono  == false || estadoEspacioInput.estadoEspacioRtn== false || estadoEspacioInput.estadoEspacioCorreo == false || estadoEspacioInput.estadoEspacioDireccion == false){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioName = funciones.validarEspacios($name);  
            estadoEspacioInput.estadoEspaciotelefono= funciones.validarEspacios($telefono);  
            estadoEspacioInput.estadoEspacioDireccion = funciones.validarEspacios($direccion);  
            estadoEspacioInput.estadoEspacioCorreo = funciones.validarEspacios($correo); 
            estadoEspacioInput.estadoEspacioRtn = funciones.validarEspacios($rtn);   
        }
        estadoMasdeUnEspacio.estadoMasEspacioName= funciones.validarMasdeUnEspacio($name);
        estadoMasdeUnEspacio.estadoMasEspaciotelefono= funciones.validarMasdeUnEspacio($telefono);
        estadoMasdeUnEspacio.estadoMasEspacioDireccion= funciones.validarMasdeUnEspacio($direccion);
        estadoMasdeUnEspacio.estadoMasEspacioCorreo = funciones.validarMasdeUnEspacio($correo);
        estadoMasdeUnEspacio.estadoMasEspacioRtn = funciones.validarMasdeUnEspacio($rtn);
       
        if(estadoMasdeUnEspacio.estadoMasEspacioName == false || estadoMasdeUnEspacio.estadoMasEspaciotelefono == false || estadoMasdeUnEspacio.estadoMasEspacioDireccion== false || estadoMasdeUnEspacio.estadoMasEspacioRtn == false|| estadoMasdeUnEspacio.estadoMasEspacioCorreo == false){
            e.preventDefault();
            console.log(estadoMasdeUnEspacio.estadoMasEspacioDireccion);
           
               
        }else{
            if(estadoSoloLetras.estadoLetrasName == false ||  estadoSoloLetras.estadoLetrasDireccion == false ){
                e.preventDefault();
                estadoLetrasdescripcion = funciones.validarSoloLetras($descripcion, validaciones.soloLetras);
                estadoLetrasubicacion = funciones.validarSoloLetras($ubicacion, validaciones.soloLetras);
                estadoLetrasAvance = funciones.validarSoloLetras($Avance, validaciones.soloLetras);
               
            }
             if(estadoSoloNumeros.estadoNumerotelefono == false || estadoSoloNumeros.estadoNumerortn == false ){
                e.preventDefault();
                estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
                estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
            }else{
                if(estadoCorreo == false || estadoSelect == false ){
                    e.preventDefault();   
                    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);        
                    estadoSelect = funciones.validarCampoVacio($name);
                    estadoSelect = funciones.validarCampoVacio($direccion);
                    estadoSelect = funciones.validarCampoVacio($rtn);
                    estadoSelect = funciones.validarCampoVacio($correo);
                    estadoSelect = funciones.validarCampoVacio($telefono);
                } else {
                    estadoValidado = true; // 
                }  
            }
        
        } 
    }
});
$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_Nombre", 50);
});
$direccion.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasDireccion= funciones.validarSoloLetras($direccion, validaciones.soloLetras);
   funciones.limitarCantidadCaracteres("E_Direccion", 300);
});

$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioName){
        funciones.validarMasdeUnEspacio($name);
    } 
    let nameMayus = $name.value.toUpperCase();
    $name.value = nameMayus; 
});
$telefono.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspaciotelefono){
        funciones.validarMasdeUnEspacio($telefono);
    }  
});
$correo.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioCorreo){
        funciones.validarMasdeUnEspacio($correo);
    }  
});
$direccion.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioDireccion){
        funciones.validarMasdeUnEspacio($direccion);
    } 
    let direccionMayus = $direccion.value.toUpperCase();
    $direccion.value = direccionMayus;  

});
$rtn.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioRtn){
        funciones.validarMasdeUnEspacio($rtn);
    }  
});


$name.addEventListener('change', ()=>{
    estadoSelect.estadoSelectName = funciones.validarCampoVacio($name);
});
$telefono.addEventListener('change', ()=>{
    estadoSelect.estadoSelecttelefono = funciones.validarCampoVacio($telefono);
});
$direccion.addEventListener('change', ()=>{
    estadoSelect.estadoSelectDireccion = funciones.validarCampoVacio($direccion);
});
$correo.addEventListener('change', ()=>{
    estadoSelect.estadoSelectCorreo = funciones.validarCampoVacio($correo);
});
$rtn.addEventListener('change', ()=>{
    estadoSelect.estadoSelectRtn= funciones.validarCampoVacio($rtn);
});
$telefono.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerotelefono = funciones.validarSoloNumeros($telefono, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_Telefono", 20);
});

$rtn.addEventListener('keyup', ()=>{
    estadoSoloNumeros.estadoNumerortn = funciones.validarSoloNumeros($rtn, validaciones.soloNumeros);
   funciones.limitarCantidadCaracteres("E_Rtn", 20);
});
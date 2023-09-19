import * as funciones from './funcionesValidaciones.js';
export let estadoValidado = false;
//Objeto con expresiones regulares para los inptus
const validaciones = {
    soloLetras: /^(?=.*[^a-zA-Z\s])/, //Solo letras
    password: /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).{8,15}$/,
    correo: /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/
}
//VARIABLES GLOBALES
let estadoExisteUsuario = false;

let estadoEspacioInput = {
    estadoEspacioUser: true,
    estadoEspacioPassword: true, 
} 
let estadoSoloLetras = {
    estadoLetrasUser: true,
    estadoLetrasName: true,
}
let estadoPassword = {
    estadoPassword1: true,
    estadoPassword2: true
}
let estadoMasdeUnEspacio = {
    estadoMasEspacioNombre: true
}
let estadoSelect = true;
let estadoCorreo = true;

const $form = document.getElementById('form-usuario');
const $user = document.getElementById('usuario');
const $name = document.getElementById('nombre');
const $password = document.getElementById('password');
const $confirmarContrasenia = document.getElementById('password2');
const $correo = document.getElementById('correo');
const $rol = document.getElementById('rol');


//Funcion para mostrar contraseña
$(document).ready(function () {
    $('#checkbox').click(function () {
        if ($(this).is(':checked')) {
            $('#password').attr('type', 'text');
            $('#password2').attr('type', 'text');
        } else {
            $('#password').attr('type', 'password');
            $('#password2').attr('type', 'password');
        }
    });
});
/* ---------------- VALIDACIONES FORMULARIO GESTION NUEVO USUARIO ----------------------*/
/* 
    Antes de enviar datos del formulario, se comprobara que todas  
    las validaciones se hayan cumplido.
*/
$form.addEventListener('submit', e => {   
    //Validamos que algún campo no esté vacío.
    let estadoInputNombre = funciones.validarCampoVacio($name);
    let estadoInputUser =  funciones.validarCampoVacio($user);
    let estadoInputPassword = funciones.validarCampoVacio($password);
    let estadoInputConfirmarContrasenia = funciones.validarCampoVacio($confirmarContrasenia);
    let estadoInputCorreo = funciones.validarCampoVacio($correo);
    let estadoInputRol = funciones.validarCampoVacio($rol);
    // Comprobamos que todas las validaciones se hayan cumplido 
    if (estadoInputNombre == false || estadoInputUser  == false || estadoInputPassword == false || 
        estadoInputConfirmarContrasenia == false || estadoInputCorreo == false || estadoInputRol == false) {
        e.preventDefault();
    } else {
        if(estadoEspacioInput.estadoEspacioUser == false || estadoEspacioInput.estadoEspacioPassword == false || estadoMasdeUnEspacio.estadoMasEspacioNombre == true){ 
            e.preventDefault();
            estadoEspacioInput.estadoEspacioPassword = funciones.validarEspacios($password); 
            estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($user);
            estadoMasdeUnEspacio.estadoMasEspacioNombre = funciones.validarMasdeUnEspacio($name);
        } else {
            if(estadoSoloLetras.estadoLetrasUser == false || estadoSoloLetras.estadoLetrasName == false ||
                estadoPassword.estadoPassword1 == false || estadoPassword.estadoPassword2 == false){
                e.preventDefault();
                estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
                estadoSoloLetras.estadoLetrasUser = funciones.validarSoloLetras($user, validaciones.soloLetras);
                estadoPassword.estadoPassword1= funciones.validarPassword($password, validaciones.password);
                estadoPassword.estadoPassword2= funciones.validarCoincidirPassword($password, $confirmarContrasenia);
            } else {
                if(estadoCorreo == false || estadoSelect == false){
                    e.preventDefault();
                    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
                    estadoSelect = funciones.validarCampoVacio($rol);
                } else {
                    if (estadoExisteUsuario == false) {
                        e.preventDefault(); // Prevent form submission if username exists
                        estadoExisteUsuario = obtenerUsuarioExiste($('#usuario').val());
                    } else {
                    estadoValidado = true;
                    }
                }
            }
        }
    }
});


$name.addEventListener('keyup', ()=>{
    estadoSoloLetras.estadoLetrasName = funciones.validarSoloLetras($name, validaciones.soloLetras);
    funciones.limitarCantidadCaracteres("nombre", 20 );
});
$name.addEventListener('focusout', ()=>{
    if(estadoMasdeUnEspacio.estadoMasEspacioNombre){
        funciones.validarMasdeUnEspacio($name);
    }
    let usuarioMayus = $name.value.toUpperCase();
    $name.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$user.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioUser = funciones.validarEspacios($user);
    //Validación con jQuery inputlimiter
    funciones.limitarCantidadCaracteres("usuario", 15 );
});
// Convierte usuario en mayúsuculas antes de enviar.
$user.addEventListener('focusout', () => {
    if(estadoEspacioInput.estadoEspacioUser){
        let letras = funciones.validarSoloLetras($user, validaciones.soloLetras);
    if(letras) {
        let usuario = $('#usuario').val();
        estadoExisteUsuario = obtenerUsuarioExiste(usuario); 
       } 
    }
    let usuarioMayus = $user.value.toUpperCase();
    $user.value = usuarioMayus;
});
//Evento que llama a la función que valida espacios entre caracteres.
$password.addEventListener('keyup', () => {
    estadoEspacioInput.estadoEspacioPassword= funciones.validarEspacios($password);
    funciones.limitarCantidadCaracteres("password", 15 );
});
//Evento que llama a la función para validar que la contraseña sea robusta.
$password.addEventListener('focusout',() => {
    //Mientras no se haya cumplido la validación de espacios no se ejecutara la de validar Password
    if(estadoEspacioInput.estadoEspacioPassword){
        estadoPassword.estadoPassword1 = funciones.validarPassword($password, validaciones.password);
    }
});
$confirmarContrasenia.addEventListener('focusout', ()=>{
    estadoPassword.estadoPassword2 = funciones.validarCoincidirPassword($password, $confirmarContrasenia);
});
$correo.addEventListener('keyup', ()=>{
    estadoCorreo = funciones.validarCorreo($correo, validaciones.correo);
});
$rol.addEventListener('change', ()=>{
    estadoSelect = funciones.validarCampoVacio($rol);
});


let obtenerUsuarioExiste = ($usuario) => {
    let estadoUsuario = false;
    $.ajax({
        url: "../../../Vista/crud/usuario/usuarioExistente.php",
        type: "POST",
        datatype: "JSON",
        data: {
            usuario: $usuario
        },
        success: function (usuario) {
            let $objUsuario = JSON.parse(usuario);
            if ($objUsuario.estado == 'true') {
                document.getElementById('usuario').classList.add('mensaje_error');
                document.getElementById('usuario').parentElement.querySelector('p').innerText = '*Usuario ya existe';
                estadoExisteUsuario = false; // Username exists, set to false
            } else {
                document.getElementById('usuario').classList.remove('mensaje_error');
                document.getElementById('usuario').parentElement.querySelector('p').innerText = '';
                estadoExisteUsuario = true; // Username doesn't exist, set to true
            }
        }
        
    });
    return estadoUsuario;
}





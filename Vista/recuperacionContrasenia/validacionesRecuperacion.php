<?php
    require_once ("../../db/Conexion.php");
    require_once ("../../Modelo/Usuario.php");
    require_once("../../Controlador/ControladorUsuario.php");
    require_once "../../Modelo/Parametro.php";
    require_once "../../Controlador/ControladorParametro.php";
    require_once("enviarCorreo.php");

    $opcion = '';
    $existe = '';
    $mensaje = '';
    session_start(); //Iniciamos session
    if(isset($_POST['radioOption'])){
        $_SESSION['metodo'] = $_POST['radioOption'];
    }
    if(isset($_POST['submit'])){
        if(isset($_POST['usuario'])){
            $_SESSION['usuario'] = $_POST['usuario'];
        }
        if(isset($_SESSION['usuario']) && isset($_SESSION['metodo'])) {
            $usuario = $_SESSION['usuario'];
            $creadoPor = $_SESSION['usuario'];
            $metodoRec = $_SESSION['metodo'];
            $userExiste = ControladorUsuario::usuarioExiste($usuario);
            if($userExiste){
                //Si el método es recuperación por correo
                if($metodoRec == 'correo'){
                    $correo = ControladorUsuario::obCorreoUsuario($usuario);
                    if($correo != ''){
                        //Generar y Almacenar token en la base de datos correspondiente al usuario
                        $almacenado = ControladorUsuario::almacenarToken($usuario, $creadoPor);
                        if($almacenado){
                            enviarCorreo($correo, $token);
                            header("location:v_SolicitarToken.php");
                        }
                    } else {
                        $mensaje = "No tiene un correo configurado";
                        unset($_SESSION['usuario']);//Eliminamos la variable
                    }
                } else { //Si el método es recuperación por pregunta secreta
                    $cantPregContestadas = ControladorUsuario::cantPreguntasContestadas($usuario);
                    if($cantPregContestadas  > 0){
                        header("location: preguntasResponder.php");
                    } else {
                        $mensaje = "No tiene preguntas contestadas";
                        unset($_SESSION['usuario']); //Eliminamos la variable
                    }
                } 
            } else {
                $mensaje = "No existe el usuario";
                unset($_SESSION['usuario']);//Eliminamos la variable
            }
        } else {
            $mensaje = "No existe un metodo";
        }
    }



    




<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Comision.php");
   require_once("../../../Controlador/ControladorComision.php");
   
   $data = ControladorComision::getComision();

   print json_encode($data, JSON_UNESCAPED_UNICODE);

   // if(isset($_POST["submit"])){
   //    $nuevaComision = new Comision();
   //    $nuevaComision->usuario = $_POST["usuario"];
   //    $nuevaComision->nombre = $_POST["nombre"];
   //    $nuevaComision->idEstado= 1; 
   //    $nuevoUsuario->contrasenia = password_hash($_POST["contraseña"], PASSWORD_DEFAULT);
   //    $nuevoUsuario->correo = $_POST["correoElectronico"]; 
   //    $nuevoUsuario->idRol = 1;
      
   //    $nuevoUsuario->preguntasContestadas = 0;
   //    $nuevoUsuario->creadoPor = $_POST["usuario"]; 

   //    ControladorUsuario::registroUsuario($nuevoUsuario);
   //    header('location: login.php');
   //    // $mensaje = "Registro éxitoso";
   ?>

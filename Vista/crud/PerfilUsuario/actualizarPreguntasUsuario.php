<?php
   require_once ("../../../db/Conexion.php");
   require_once ("../../../Modelo/Usuario.php");
   require_once("../../../Controlador/ControladorUsuario.php");
   require_once ("../../../Modelo/Pregunta.php");
   require_once("../../../Controlador/ControladorPregunta.php");
 
   

   if(isset($_POST['guardarRespuestas'])){
      $respuestas=new Usuario();
      $respuestas->usuario=$_SESSION['usuario'];
      $respuestas->respuesta = $_POST['respuestas'];
    //  
      // Actualizar las respuestas
      ControladorPregunta::actualizarRespuesta($_SESSION['usuario'], $respuestas);
  
      // Redirigir después de la actualización
      //header("location: ./gestionPerfilUsuario.php");
  }
?>
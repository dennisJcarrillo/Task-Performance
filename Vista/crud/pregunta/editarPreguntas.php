<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Pregunta.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Controlador/ControladorPregunta.php");
    require_once ("../../../Controlador/ControladorBitacora.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $insertarPregunta = new Pregunta();
        $insertarPregunta->idPregunta = ($_POST['idPregunta']);
        $insertarPregunta->pregunta = ($_POST['pregunta']);
        $insertarPregunta->ModificadoPor = $user;
        $insertarPregunta->FechaModificacion = date("Y-m-d");
        ControladorPregunta::actualizarPregunta($insertarPregunta);
        
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Insert'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' creo usuario '.$_POST['usuario'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }

?>
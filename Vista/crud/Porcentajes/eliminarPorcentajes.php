<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Porcentajes.php");
    require_once("../../../Controlador/ControladorPorcentajes.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    
    $user = '';
    session_start();
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $eliminarPorcentaje = new Porcentajes();
        $eliminarPorcentaje->idPorcentaje = $_POST['idPorcentaje'];
        $eliminarPorcentaje->estadoPorcentaje = $_POST['estado'];
        $eliminarPorcentaje->ModificadoPor = $user;
        date_default_timezone_set('America/Tegucigalpa');
        $eliminarPorcentaje->fechaModificacion = date("Y-m-d");
        ControladorPorcentajes::eliminarPorcentaje($eliminarPorcentaje);
        // Porcentajes::editarPorcentaje($eliminarPorcentaje);
        /* ========================= Evento editar porcentaje. ======================*/
        $newBitacora = new Bitacora();
        $accion = ControladorBitacora::accion_Evento();
        date_default_timezone_set('America/Tegucigalpa');
        $newBitacora->fecha = date("Y-m-d h:i:s"); 
        $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionPorcentajes.php');
        $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        $newBitacora->accion = $accion['Update'];
        $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el porcentaje '.'"'.$_POST['descripcionPorcentaje'].'"'.' a '.$_POST['valorPorcentaje'];
        ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }

?>
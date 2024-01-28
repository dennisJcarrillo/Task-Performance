<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once ("../../../Modelo/Metricas.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once ("../../../Modelo/EstadoUsuario.php");
    require_once("../../../Controlador/ControladorEstadoUsuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once("../../../Controlador/ControladorMetricas.php");
    require_once("../../../Controlador/ControladorBitacora.php");
    

    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $editarEstado = new EstadoUsuario();
        $editarEstado->idEstado = $_POST['idEstadoU'];
        $editarEstado->descripcion = $_POST['descripcion'];
        $editarEstado->modificadoPor = $_SESSION['usuario'];
        ControladorEstadoUsuario::editarEstadoU($editarEstado);
        /* ========================= Evento Editar Usuario. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionMetricas.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Update'];
        // $metrica = ControladorMetricas::obtenerNombreMetrica($_POST['idMetrica']);
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó la métrica '.$metrica.' a '.$_POST['meta'];
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        /* =======================================================================================*/
    }
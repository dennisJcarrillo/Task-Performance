<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    // require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");
    // require_once("../../../Controlador/ControladorBitacora.php");
    

    // session_start(); //Reanudamos session
    // if(isset($_SESSION['usuario'])){
        $nuevoCliente = new CarteraClientes();
        $nuevoCliente->idcarteraCliente = $_POST['id'];
        $nuevoCliente->nombre = $_POST['nombre'];
        $nuevoCliente->rtn = $_POST['rtn'];
        $nuevoCliente->telefono = $_POST['telefono'];
        $nuevoCliente->correo= $_POST['correo'];
        $nuevoCliente->direccion = $_POST['direccion'];
        ControladorCarteraClientes::editarCliente($nuevoCliente);
        /* ========================= Evento Editar Usuario. ======================*/
        // $newBitacora = new Bitacora();
        // $accion = ControladorBitacora::accion_Evento();
        // date_default_timezone_set('America/Tegucigalpa');
        // $newBitacora->fecha = date("Y-m-d h:i:s"); 
        // $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
        // $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
        // $newBitacora->accion = $accion['Update'];
        // $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' modificó el usuario '.$_POST['usuario'];
        // ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
        // /* =======================================================================================*/
    // }
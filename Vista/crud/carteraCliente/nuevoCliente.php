<?php
    require_once ("../../../db/Conexion.php");
    require_once ("../../../Modelo/Usuario.php");
    require_once("../../../Controlador/ControladorUsuario.php");
    require_once ("../../../Modelo/CarteraClientes.php");
    require_once ("../../../Modelo/Bitacora.php");
    require_once("../../../Controlador/ControladorCarteraClientes.php");
    require_once("../../../Controlador/ControladorBitacora.php");

    $user = '';
    session_start(); //Reanudamos session
    if(isset($_SESSION['usuario'])){
        $user = $_SESSION['usuario'];
        $nuevoCliente = new CarteraClientes();
        $nuevoCliente->nombre = $_POST['nombre'];
        $nuevoCliente->rtn = $_POST['rtn'];
        $nuevoCliente->telefono = $_POST['telefono'];
        $nuevoCliente->correo = $_POST['correo'];
        $nuevoCliente->direccion = $_POST['direccion'];
        $nuevoCliente->estadoContacto = 'En Proceso';
        $nuevoCliente->CreadoPor = $user;
        ControladorCarteraClientes::registroCliente($nuevoCliente);
       /* ========================= Evento Creacion cartera cliente. =============================*/
       $newBitacora = new Bitacora();
       $accion = ControladorBitacora::accion_Evento();
       date_default_timezone_set('America/Tegucigalpa');
       $newBitacora->fecha = date("Y-m-d h:i:s"); 
       $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionCarteraClientes.php');
       $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($user);
       $newBitacora->accion = $accion['Insert'];
       $newBitacora->descripcion = 'El usuario '.$user.' creó al nuevo cliente '.$_POST['nombre'];
       ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
       /* =======================================================================================*/
    }
?>

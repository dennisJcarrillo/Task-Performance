<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario'])){ //Validamos si existe una session y el usuario
    $existe = array();
    $cliente = ControladorTarea::validarRtnCliente($_POST['rtnCliente']);
    if($cliente == false){
        $estadoClienteC = ControladorTarea::validarClienteExistenteCarteraCliente($_POST['rtnCliente']);
        print json_encode($estadoClienteC, JSON_UNESCAPED_UNICODE);
    } else {
        $existe = [
            'estado' => 'true'
        ];  
        print json_encode($existe, JSON_UNESCAPED_UNICODE);
    }
}


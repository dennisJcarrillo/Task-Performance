<?php
session_start(); //Reunamos sesion
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorUsuario.php');
require_once('../../Controlador/ControladorTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');

if(isset($_POST['tipoTarea'])){
    $user = $_SESSION['usuario'];
    $tarea = new Tarea(); //Creamos un objeto a partir de la clase TAREA
    //Llenamos algunas propiedades del objeto para nueva Tarea
    if($_POST['tipoTarea'] == 'llamada'){
        $tarea->idEstadoAvance = 1;
    } else if($_POST['tipoTarea'] == 'lead'){
        $tarea->idEstadoAvance = 2;
    } else if ($_POST['tipoTarea'] == 'cotizacion'){
        $tarea->idEstadoAvance = 3;
    } else{
        $tarea->idEstadoAvance = 4;
    }
    $tarea->titulo = $_POST['titulo'];
    $tarea->idUsuario =  ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $tarea->Creado_Por = $user;
    $idTarea = ControladorTarea::insertarNuevaTarea($tarea);
    /* ====================== Evento, el usuario ha creado una nueva tarea. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($idTarea);
    $newBitacora->descripcionEvento = 'Ha creado la tarea # '.$idTarea.' en el estado '.$_POST['tipoTarea'];
    $idBitacora = ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
    unset($_POST['tipoTarea']); //Vaciar variable
}
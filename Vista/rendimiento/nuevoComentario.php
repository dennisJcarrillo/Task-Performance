<?php
session_start();
require_once('../../db/Conexion.php');
require_once('../../Modelo/Usuario.php');
require_once('../../Modelo/BitacoraTarea.php');
require_once('../../Controlador/ControladorBitacoraTarea.php');
require_once('../../Controlador/ControladorUsuario.php');

if(isset($_SESSION['usuario']) && isset($_POST['id_Tarea'])){
    ControladorBitacoraTarea::agregarComentarioTarea(intval($_POST['id_Tarea']), $_POST['comentario'], $_SESSION['usuario']);
    /* ====================== Evento, el usuario creo un nuevo comentario. =====================*/
    $idUsuario = intval(ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']));
    $accion = ControladorBitacoraTarea::acciones_Evento_Tareas();
    $newBitacora = new BitacoraTarea();
    $newBitacora->idTarea = intval($_POST['id_Tarea']);
    $newBitacora->accionEvento = $accion['nuevoComentario'];
    $newBitacora->descripcionEvento = 'El usuario ' . $_SESSION['usuario'] . ' agregó un nuevo comentario';
    ControladorBitacoraTarea::SAVE_EVENT_TASKS_BITACORA($newBitacora, $idUsuario);
    /* =======================================================================================*/
}
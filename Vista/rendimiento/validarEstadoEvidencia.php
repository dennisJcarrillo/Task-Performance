<?php
require_once('../../db/Conexion.php');
require_once('../../Modelo/Tarea.php');
require_once('../../Controlador/ControladorTarea.php');

session_start(); //Reanudamos sesion
if(isset($_SESSION['usuario']) && isset($_POST['evidencia'])){ //Validamos si existe una session y el usuario
    $estadoE = ControladorTarea::validarSiExisteEvidencia($_POST['evidencia']);
    print json_encode($estadoE, JSON_UNESCAPED_UNICODE);
}




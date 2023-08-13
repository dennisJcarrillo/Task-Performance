<?php

class Parametro {
    public $idParametro;
    public $parametro;
    public $valor;
    public $nombre;
    public $idUsuario;
    public $creadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;

    //Método para obtener todos los usuarios que existen.
    public static function obtenerTodosLosParametros(){
        $parametros = null;
        try {
            $parametros = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $resultado = $abrirConexion->query("SELECT p.id_Parametro, p.parametro, p.valor, u.usuario FROM tbl_ms_parametro AS p
            INNER JOIN tbl_ms_usuario AS u ON p.id_Usuario = u.id_Usuario;");
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = $resultado->fetch_assoc()) {
                $parametros[] = [
                    'id' => $fila['id_Parametro'],
                    'parametro' => $fila['parametro'],
                    'valorParametro' => $fila['valor'],
                    'usuario' => $fila['usuario'],
                ];
            }
        } catch (Exception $e) {
            $parametros = 'Error SQL:' . $e;
        }
        mysqli_close($abrirConexion); //Cerrar conexion
        return $parametros;
    }
}
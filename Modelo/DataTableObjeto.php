<?php

class DataTableObjeto
{
    public $id_Objeto;
    public $objeto;
    public $descripcion;
    public $tipo_Objeto;
    
    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerObjetos()
    {
        $ObjetoUsuario = null;
        try {
            $objetoUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = " SELECT o.id_Objeto, o.objeto, o.descripcion,o.tipo_Objeto
            FROM tbl_MS_Objetos AS o";
           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $ObjetoUsuario[] = [
                    'id_Objeto' => $fila['id_Objeto'],
                    'objeto' => $fila['objeto'],
                    'descripcion' => $fila['descripcion'],
                    'tipo_Objeto' => $fila['tipo_Objeto']

                ];
            }
        } catch (Exception $e) {
            $ObjetoUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $ObjetoUsuario;
    } 
}
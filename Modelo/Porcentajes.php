<?php

class Porcentajes {
    public $idPorcentaje;
    public $valorPorcentaje;
    public $descripcionPorcentaje;
    public $estadoPorcentaje;
    public $CreadoPor;
    public $FechaCreacion;
    public $ModificadoPor;
    public $FechaModificacion;



    //Método para obtener todos los usuarios que existen.
    public static function obtenerPorcentajes(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT id_TipoServicio,servicio_Tecnico 
        FROM tbl_TipoServicio;";
        $listaPorcentajes = sqlsrv_query($consulta, $query);
        $Porcent = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaPorcentajes, SQLSRV_FETCH_ASSOC)){
            $Porcent [] = [
                'idPorcentaje' => $fila["id_Porcentaje"],
                'valorPorcentaje' => $fila["valor_Porcentaje"],
                'descripcionPorcentaje'=> $fila["descripcion"],
                'estadoPorcentaje' => $fila["estado_Porcentaje"]
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $Porcent;
    }

    //Método para crear nuevo registro
    public static function registroNuevoPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB
        $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        $descripcionPorcentaje = $nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $CreadoPor = $nuevoPorcentaje->CreadoPor;
        date_default_timezone_set('America/Tegucigalpa');
        $FechaCreacion = date("Y-m-d");
        $query = "INSERT INTO tbl_Porcentaje(valor_Porcentaje,descripcion,estado_Porcentaje, Creado_Por, Fecha_Creacion)
                       VALUES ('$valorPorcentaje', '$descripcionPorcentaje', '$estadoPorcentaje', '$CreadoPor', '$FechaCreacion');";        
        $nuevoPorcentaje = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $nuevoPorcentaje;
    }

    public static function editarPorcentaje($nuevoPorcentaje){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $idPorcentaje = $nuevoPorcentaje->idPorcentaje;
        $valorPorcentaje = $nuevoPorcentaje->valorPorcentaje;
        $descripcionPorcentaje =$nuevoPorcentaje->descripcionPorcentaje;
        $estadoPorcentaje = $nuevoPorcentaje->estadoPorcentaje;
        $ModificadoPor = $nuevoPorcentaje->ModificadoPor;
        date_default_timezone_set('America/Tegucigalpa'); 
        $FechaModificacion = date("Y-m-d");
        $query = "UPDATE tbl_porcentaje SET valor_Porcentaje='$valorPorcentaje', descripcion='$descripcionPorcentaje',
                                            estado_Porcentaje ='$estadoPorcentaje', Modificado_Por = '$ModificadoPor', 
                                            Fecha_Modificacion = '$FechaModificacion' WHERE id_Porcentaje='$idPorcentaje';";
        $nuevoPorcentaje = sqlsrv_query($conexion, $query);
        sqlsrv_close($conexion); #Cerramos la conexión.
    }


}
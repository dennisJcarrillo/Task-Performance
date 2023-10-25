<?php

class DataTableSolicitud
{
    public $idSolicitud;
    public $idTipoSolicitud;
    public $EstadoAvance;
    public $EstadoSolicitud;
    public $TelefonoCliente;
    public $FechaCreacion;
    public $MotivoCancelacion;

    // Obtener todas las tareas que le pertenecen a un usuario.
    public static function obtenerSolicitud()
    {
        $SolicitudesUsuario = null;
        try {
            $SolicitudesUsuario = array();
            $con = new Conexion();
            $abrirConexion = $con->abrirConexionDB();
            $query = "SELECT id_Solicitud,
            CASE
              WHEN cc.nombre_Cliente IS NOT NULL THEN cc.nombre_Cliente COLLATE Modern_Spanish_CI_AS
              ELSE c.NOMBRECLIENTE COLLATE Modern_Spanish_CI_AS
            END AS NombreCliente
            ,t.servicio_Tecnico,telefono_cliente,EstadoAvance
            ,s.Fecha_Creacion
            FROM [tbl_Solicitud] as s
            inner join tbl_TipoServicio as t on t.id_TipoServicio = s.id_TipoServicio
            LEFT join View_Clientes as c on c.CIF COLLATE Modern_Spanish_CI_AS = s.rtn_cliente COLLATE Modern_Spanish_CI_AS
            LEFT join tbl_CarteraCliente as cc on cc.rtn_Cliente = s.rtn_clienteCartera 
			where EstadoSolicitud = 'ACTIVO';";

           $resultado = sqlsrv_query($abrirConexion, $query);
            //Recorremos el resultado de tareas y almacenamos en el arreglo.
            while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
                $SolicitudesUsuario[] = [
                    'id_Solicitud' => $fila['id_Solicitud'],
                    'Nombre' => $fila['NombreCliente'],
                    'servicio_Tecnico' => $fila['servicio_Tecnico'],
                    'telefono' => $fila['telefono_cliente'],
                    'EstadoAvance' => $fila['EstadoAvance'],
                    'Fecha_Creacion' => $fila['Fecha_Creacion']
                   
                ];
            }
        } catch (Exception $e) {
            $SolicitudesUsuario = 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion
        return $SolicitudesUsuario;
    } 


    public static function actualizarEstadoSolicitud($nuevaSolicitud){
        try {
            $conn = new Conexion();
            $abrirConexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
            $idSolicitud=$nuevaSolicitud->idSolicitud;
            $EstadoSolicitud=$nuevaSolicitud->EstadoSolicitud;
            $MotivoCancelacion=$nuevaSolicitud->MotivoCancelacion;
            $modificadoPor=$nuevaSolicitud->modificadoPor;
            // date_default_timezone_set('America/Tegucigalpa'); 
            // $fechaModificado = date("Y-m-d h:i:s");
            $query ="UPDATE tbl_Solicitud SET EstadoSolicitud='$EstadoSolicitud', motivo_cancelacion = '$MotivoCancelacion', 
            Modificado_Por='$modificadoPor', Fecha_Modificacion = GETDATE()
            WHERE id_Solicitud='$idSolicitud';";
            $nuevaSolicitud = sqlsrv_query($abrirConexion, $query);
        } catch (Exception $e) {
            echo 'Error SQL:' . $e;
        }
        sqlsrv_close($abrirConexion); //Cerrar conexion

    }

    public static function editarSolicitud($EditarSolicitud){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB();
        $idSolicitud = $EditarSolicitud->idSolicitud;
        $descripcion = $EditarSolicitud->descripcion;
        $telefono = $EditarSolicitud->telefono;
        $ubicacion = $EditarSolicitud->ubicacion;
        $EstadoAvance = $EditarSolicitud->EstadoAvance;
        $ModificadoPor = $EditarSolicitud->ModificadoPor;
        $query = "UPDATE tbl_Solicitud SET descripcion = '$descripcion', telefono_cliente = '$telefono', 
		ubicacion_instalacion = '$ubicacion', EstadoAvance ='$EstadoAvance',
        Modificado_Por = '$ModificadoPor', Fecha_Modificacion = GETDATE()
        WHERE id_Solicitud = '$idSolicitud';";
        $EditarSolicitud = sqlsrv_query($consulta, $query);
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $EditarSolicitud;
    }

    public static function VerSolicitudesPorId ($idSolicitud){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB();
        $query="SELECT id_Solicitud
        ,idFactura,s.rtn_cliente,s.rtn_clienteCartera,
        CASE
          WHEN cc.nombre_Cliente IS NOT NULL THEN cc.nombre_Cliente COLLATE Modern_Spanish_CI_AS
          ELSE c.NOMBRECLIENTE COLLATE Modern_Spanish_CI_AS
        END AS NombreCliente
        ,descripcion,t.servicio_Tecnico,s.correo,telefono_cliente,ubicacion_instalacion,EstadoAvance
        ,EstadoSolicitud,motivo_cancelacion,s.Creado_Por,s.Fecha_Creacion,s.Modificado_Por,s.Fecha_Modificacion
        FROM [tbl_Solicitud] as s
        inner join tbl_TipoServicio as t on t.id_TipoServicio = s.id_TipoServicio
        LEFT join View_Clientes as c on c.CIF COLLATE Modern_Spanish_CI_AS = s.rtn_cliente COLLATE Modern_Spanish_CI_AS
        LEFT join tbl_CarteraCliente as cc on cc.rtn_Cliente = s.rtn_clienteCartera
        Where id_Solicitud = $idSolicitud;";
        $resultado = sqlsrv_query($conexion, $query);
        $fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC);
        $datosVerSolicitudes = [
            'idSolicitud' => $fila['id_Solicitud'],
            'idFactura' => $fila['idFactura'],
            'rtnCliente' => $fila['rtn_cliente'],
            'rtnClienteCartera' => $fila['rtn_clienteCartera'],
            'NombreCliente' => $fila['NombreCliente'],
            'Descripcion' => $fila['descripcion'],
            'TipoServicio' => $fila['servicio_Tecnico'],
            'Correo' => $fila['correo'],
            'telefono' => $fila['telefono_cliente'],
            'ubicacion' => $fila['ubicacion_instalacion'],
            'EstadoAvance' => $fila['EstadoAvance'],
            'EstadoSolicitud' => $fila['EstadoSolicitud'],
            'motivoCancelacion' => $fila['motivo_cancelacion'],
            'CreadoPor' => $fila['Creado_Por'],
            'FechaCreacion' => $fila['Fecha_Creacion'],  
            'ModificadoPor' => $fila['Modificado_Por'],
            'FechaModificacion' => $fila['Fecha_Modificacion']  
        ];
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $datosVerSolicitudes;
    }

}


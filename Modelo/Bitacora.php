<?php
    class Bitacora {
        public $idBitacora;
        public $fecha;
        public $idUsuario;
        public $accion;
        public $idObjeto;
        public $descripcion;
        //Método de captura los eventos y los almacena en la tabla bitacora.
        public static function EVENT_BITACORA($datosEvento){
            //Recibir objeto y obtener parametros
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $ejecutarSQL = "INSERT INTO tbl_ms_bitacora (`fecha`, `id_Usuario`, `id_Objeto`, `accion`, `descripcion`) 
            VALUES('$datosEvento->fecha','$datosEvento->idUsuario','$datosEvento->idObjeto','$datosEvento->accion','$datosEvento->descripcion')";
            $consulta->query($ejecutarSQL);
            mysqli_close($consulta); #Cerramos la conexión.
        }
        //Método que recibe un objeto y devuelve su id.
        public static function obtener_Id_Objeto($objeto){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $resultado = $consulta->query("SELECT id_Objeto FROM tbl_ms_objetos WHERE objeto = '$objeto'");
            $fila = $resultado->fetch_assoc();
            $idObjeto = $fila['id_Objeto'];
            mysqli_close($consulta); #Cerramos la conexión.
            return $idObjeto;
        }
        public static function acciones_Evento(){
            $acciones = [
                'Insert' => 'Creacion',
                'Update' => 'Actualizacion',
                'Delete' => 'Eliminacion',
                'Login'  => 'Iniciar Sesion',
                'Logout'  => 'Cerrar Session',
                'income'  => 'Ingreso',
                'Exit' => 'Salio'
            ];
            return $acciones;
        }

        public static function obtenerBitacorasUsuario(){
            $conn = new Conexion();
            $consulta = $conn->abrirConexionDB();
            $obtenerBitacoras = $consulta->query("SELECT id_Bitacora, fecha, id_Usuario, id_Objeto, accion, descripcion FROM tbl_ms_bitacora");
            $bitacoras = array();
            while($fila = $obtenerBitacoras->fetch_assoc()){
                $bitacoras [] = [
                    'id_Bitacora' => $fila["id_Bitacora"],
                    'fecha' => $fila["fecha"],
                    'id_Usuario' => $fila["id_Usuario"],
                    'id_Objeto' => $fila["id_Objeto"],
                    'accion' => $fila["accion"],
                    'descripcion' => $fila["descripcion"],
                    
                ];
            }
            mysqli_close($consulta); #Cerramos la conexión.
            return $bitacoras;
        } 
    }

<?php
 class Conexion {
    private $hostName = 'localhost';
    private $dbName = 'COCINAS_Y_EQUIPOS';
    private $userName = 'root';
    private $password = '';

    #Abrir conexión al servidor de MySQL
    public function abrirConexionDB(){
        $conn = mysqli_connect($this->hostName, $this->userName, $this->password, $this->dbName);
        return $conn;
    }
 }
?>
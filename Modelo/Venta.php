<?php
class Venta {
    public $numFactura;
    public $CodCliente;
    public $NombreCliente;
    public $Cif;
    public $Fecha;
    public $TotalBruto;
    public $TotalImpuesto;
    public $TotalNeto;
    
  //Método para obtener todas las ventas que existen.
    public static function obtenertodaslasventas(){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        
        $query = "SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO
        FROM View_Clientes AS c
        INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE;
            ";
        $listaVentas = sqlsrv_query($consulta, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente' => $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente' => $fila["CIF"],
                'fechaEmision'=> $fila["FECHA"],
                'totalBruto' => $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTOS"],     
                'totalNeto' => $fila["TOTALNETO"]    
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ventas;
    }
    public static function obtenerVentasPorFechas($fechaDesde, $fechaHasta){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $select = "SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO
                    FROM view_clientes AS c
                    INNER JOIN View_facturasventa AS v ON c.CODCLIENTE = v.CODCLIENTE
                    WHERE v.FECHA BETWEEN '$fechaDesde' AND '$fechaHasta' AND v.TOTALNETO > 0;";
        $query = $select;
        $listaVentas = sqlsrv_query($conexion, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente'=> $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'fechaEmision' => $fila["FECHA"],
                'totalBruto'=> $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTOS"],   
                'totalVenta' => $fila["TOTALNETO"]       
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $ventas;
    }

    //obtener el id de la venta
    public static function obtenerIdVenta($numFactura){
        $conn = new Conexion();
        $conexion = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.
        $query = "SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO
        FROM View_Clientes AS c
        INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE WHERE NUMFACTURA = '$numFactura';";
        $consulta = sqlsrv_query($conexion, $query);
        $idVenta = array();
        While($fila = sqlsrv_fetch_array($consulta, SQLSRV_FETCH_ASSOC)){
            $idVenta [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente'=> $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente'=> $fila["CIF"],
                'fechaEmision' => $fila["FECHA"],
                'totalBruto'=> $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTOS"],   
                'totalVenta' => $fila["TOTALNETO"]    
            ];
        }
        sqlsrv_close($conexion); #Cerramos la conexión.
        return $idVenta;
    }

    //Método para obtener todas las ventas que existen.
    public static function obtenerlasventasPDF($buscar){
        $conn = new Conexion();
        $consulta = $conn->abrirConexionDB(); #Abrimos la conexión a la DB.        
        $query = "		SELECT v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, v.FECHA, v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO
        FROM View_Clientes AS c
        INNER JOIN View_FACTURASVENTA AS v ON c.CODCLIENTE = v.CODCLIENTE
        WHERE CONCAT(v.NUMFACTURA, v.CODCLIENTE, c.NOMBRECLIENTE, c.CIF, CONVERT(NVARCHAR, v.FECHA, 23), v.TOTALBRUTO, v.TOTALIMPUESTOS, v.TOTALNETO) 
        LIKE '%' + '$buscar' + '%' ORDER BY v.NUMFACTURA;";
        $listaVentas = sqlsrv_query($consulta, $query);
        $ventas = array();
        //Recorremos la consulta y obtenemos los registros en un arreglo asociativo
        while($fila = sqlsrv_fetch_array($listaVentas, SQLSRV_FETCH_ASSOC)){
            $ventas [] = [
                'numFactura' => $fila["NUMFACTURA"],
                'codCliente' => $fila["CODCLIENTE"],
                'nombreCliente'=> $fila["NOMBRECLIENTE"],
                'rtnCliente' => $fila["CIF"],
                'fechaEmision'=> $fila["FECHA"],
                'totalBruto' => $fila["TOTALBRUTO"],
                'totalImpuesto' => $fila["TOTALIMPUESTOS"],     
                'totalNeto' => $fila["TOTALNETO"]    
            ];
        }
        sqlsrv_close($consulta); #Cerramos la conexión.
        return $ventas;
    }

}#Fin de la clase

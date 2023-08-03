<?php

require('./fpdf.php');
require_once("../../db/Conexion.php");
require_once("../../Modelo/Venta.php");
require_once("../../Controlador/ControladorVenta.php");

class PDF extends FPDF
{

   // Cabecera de página
   function Header()
   {
      //include '../../recursos/Recurso_conexion_bd.php';//llamamos a la conexion BD

      //$consulta_info = $conexion->query(" select *from hotel ");//traemos datos de la empresa desde BD
      //$dato_info = $consulta_info->fetch_object();
      $this->Image('LOGO-HD-transparente.jpg', 250, 5, 40); //logo de la empresa,moverDerecha,moverAbajo,tamañoIMG
      $this->SetFont('times', 'B', 19); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(45); // Movernos a la derecha
      $this->SetTextColor(0, 0, 0); //color
      //creamos una celda o fila
      $this->Cell(190, 15, mb_convert_encoding('EQUIPOS Y COCINAS', 'UTF-8'), 0, 2, 'C', 0); // AnchoCelda,AltoCelda,titulo,borde(1-0),saltoLinea(1-0),posicion(L-C-R),ColorFondo(1-0)
      $this->Ln(3); // Salto de línea
      $this->SetTextColor(103); //color

      /* UBICACION */
      /* $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(96, 10, utf8_decode("Ubicación : "), 0, 0, '', 0);
      $this->Ln(5);
 */
      /* TELEFONO */
      /* $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(59, 10, utf8_decode("Teléfono : "), 0, 0, '', 0);
      $this->Ln(5);
 */
      /* COREEO */
      /* $this->Cell(110);  // mover a la derecha
      $this->SetFont('Arial', 'B', 10);
      $this->Cell(85, 10, utf8_decode("Correo : "), 0, 0, '', 0);
      $this->Ln(5); */

      /* TITULO DE LA TABLA */
      //color
     /*  $this->SetMargins(10, 10, 10); */
     $this->SetMargins(40, 15, 10);
      $this->SetTextColor(205, 92, 92);
      $this->Cell(1); // mover a la derecha
      $this->SetFont('Arial', 'B', 15);
      $this->Cell(70, 10, mb_convert_encoding('REPORTE DE VENTAS ', 'windows-1252', 'UTF-8'), 0, 2, 'L', 0);
      $this->Ln(7);

      /* CAMPOS DE LA TABLA */
      //color
      $this->SetMargins(40, 15, 10);
      $this->SetFillColor(33, 47, 60 ); //colorFondo
      $this->SetTextColor(255, 255, 255); //colorTexto
      $this->SetDrawColor(163, 163, 163); //colorBorde
      $this->SetFont('Arial', 'B', 8);
      $this->Cell(10, 10, mb_convert_encoding('N°','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(25, 10, mb_convert_encoding('CODCLIENTE','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(40, 10, mb_convert_encoding('CLIENTE','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(30, 10, mb_convert_encoding('RTN','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(30, 10, mb_convert_encoding('FECHA','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(25, 10, mb_convert_encoding('TOTALBRUTO','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(25, 10, mb_convert_encoding('IMPUESTO','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Cell(25, 10, mb_convert_encoding('TOTAL','windows-1252', 'UTF-8'), 1, 0, 'C', 1);
      $this->Ln(10);
   }

   // Pie de página
   function Footer()
   {
      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, negrita(B-I-U-BIU), tamañoTexto
      $this->Cell(0, 10, mb_convert_encoding('Página','windows-1252', 'UTF-8') . $this->PageNo() . '/{nb}', 0, 0, 'C'); //pie de pagina(numero de pagina)

      $this->SetY(-15); // Posición: a 1,5 cm del final
      $this->SetFont('Arial', 'I', 8); //tipo fuente, cursiva, tamañoTexto
      date_default_timezone_set('America/Tegucigalpa');
      $hoy = date('d/m/Y');
      $this->Cell(450, 10, mb_convert_encoding($hoy, 'windows-1252', 'UTF-8'), 0, 0, 'C'); // pie de pagina(fecha de pagina)
   }
}

//include '../../recursos/Recurso_conexion_bd.php';
//require '../../funciones/CortarCadena.php';
/* CONSULTA INFORMACION DEL HOSPEDAJE */
//$consulta_info = $conexion->query(" select *from hotel ");
//$dato_info = $consulta_info->fetch_object();

$pdf = new PDF();
$pdf->AddPage('Landscape'); /* aqui entran dos para parametros (horientazion,tamaño)V->portrait H->landscape tamaño (A3.A4.A5.letter.legal) */
$pdf->AliasNbPages(); //muestra la pagina / y total de paginas
$pdf->SetAutoPageBreak(true, 25); //margen de pie de pagina

$i = 0;
$pdf->SetFont('Arial', '', 8);
$pdf->SetDrawColor(163, 163, 163); //colorBorde


/*$consulta_reporte_alquiler = $conexion->query("  ");*/
$ventas = ControladorVenta::getVentas();
foreach ($ventas as $venta) {
   $pdf->Cell(10, 10, mb_convert_encoding($venta['numFactura'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, mb_convert_encoding($venta['codCliente'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(40, 10, mb_convert_encoding($venta['nombreCliente'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, mb_convert_encoding($venta['rtnCliente'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(30, 10, mb_convert_encoding($venta['fechaEmision'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($venta['totalBruto'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Cell(25, 10, mb_convert_encoding($venta['totalImpuesto'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
    $pdf->Cell(25, 10, mb_convert_encoding($venta['totalNeto'],'windows-1252', 'UTF-8'), 1, 0, 'C', 0);
   $pdf->Ln(10);
   
}
/* TABLA */


$pdf->Output('Ventas.pdf', 'I');//nombreDescarga, Visor(I->visualizar - D->descargar)
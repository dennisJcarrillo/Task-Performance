<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/Parametro.php");
require_once("../../../Modelo/Usuario.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorParametro.php");
require_once("../../../Controlador/ControladorUsuario.php");
require_once("../../../Controlador/ControladorBitacora.php");

session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $permisoRol = ControladorUsuario::permisosRol($idRolUsuario);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionParametro.php');
  $objetoPermitido = ControladorUsuario::permisoSobreObjeto($_SESSION['usuario'], $idObjetoActual, $permisoRol);
  if(!$objetoPermitido){
    /* ==================== Evento intento de ingreso sin permiso a mantenimiento parametro. ==========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionParametro.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a mantenimiento parámetro';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = '';
    $_SESSION['descripcionObjeto'] = '';
    /* ===============================================================================================================*/
    header('location: ../../v_errorSinPermiso.php');
    die();
  }else{
    if(isset($_SESSION['objetoAnterior']) && !empty($_SESSION['objetoAnterior'])){
      /* ====================== Evento salir. ================================================*/
      $accion = ControladorBitacora::accion_Evento();
      date_default_timezone_set('America/Tegucigalpa');
      $newBitacora->fecha = date("Y-m-d h:i:s");
      $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto($_SESSION['objetoAnterior']);
      $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
      $newBitacora->accion = $accion['Exit'];
      $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' salió de '.$_SESSION['descripcionObjeto'];
      ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    /* =======================================================================================*/
    }
    /* ====================== Evento ingreso a mantenimiento parametro. ========================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionParametro.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a mantenimiento parámetro';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionParametro.php';
    $_SESSION['descripcionObjeto'] = 'mantenimiento parámetro';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/3135/3135715.png">
  <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
  <!-- Boostrap5 -->
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionComision.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Parametros </title>
</head>

<body style="overflow: hidden;">
 
    <!-- Sidebar 1RA PARTE -->
    <div class="conteiner-global">
      <div class="sidebar-conteiner">
      <?php
          $urlIndex = '../../index.php';
          // Rendimiento
          $urlMisTareas = '../../rendimiento/v_tarea.php';
          $urlConsultarTareas = './'; //PENDIENTE
          $urlBitacoraTarea = ''; //PENDIENTE
          $urlMetricas = '../Metricas/gestionMetricas.php';
          $urlEstadisticas = ''; //PENDIENTE
          //Solicitud
          $urlSolicitud = '../DataTableSolicitud/gestionDataTableSolicitud.php';
          //Comisión
          $urlComision = '../../comisiones/v_comision.php';
          //Consulta
          $urlClientes = '../cliente/gestionCliente.php';
          $urlVentas = '../Venta/gestionVenta.php';
          $urlArticulos = '../articulo/gestionArticulo.php';
          //Mantenimiento
          $urlUsuarios = '../usuario/gestionUsuario.php';
          $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
          $urlPreguntas = '../pregunta/gestionPregunta.php';
          $urlBitacoraSistema = './gestionBitacora.php';
          $urlParametros = '../parametro/gestionParametro.php';
          $urlPermisos = '../permiso/gestionPermiso.php';
          $urlRoles = '../rol/gestionRol.php';
          $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
          $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
          require_once '../../layout/sidebar.php';
        ?>
      </div>

      <div class="conteiner-main">
            <!-- Encabezado -->
          <div class= "encabezado">
              <div class="navbar-conteiner">
                  <!-- Aqui va la barra -->
                  <?php include_once '../../layout/navbar.php'?>                             
              </div>        
              <div class ="titulo">
                    <H2 class="title-dashboard-task">Gestión de Parámetros</H2>
              </div>  
          </div>
      
          <div class="table-conteiner">
              <div>
              <a href="../../fpdf/ReporteParametros.php" target="_blank" class="btn_Pdf btn btn-primary" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>
              </div>
          <table class="table" id="table-Parametro">
            <thead>
              <tr>
                <th scope="col"> ID </th>
                <th scope="col"> PARAMETRO </th>
                <th scope="col"> VALOR </th>
                <th scope="col"> USUARIO </th>
                <th scope="col"> ACCIONES </th>
              </tr>
            </thead>
            <!-- <div class ="text-left mb-2">
            <a href="../../fpdf/ReporteClientes.php" target="_blank" class="btn btn-success" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>
            </div> -->
            <tbody class="table-group-divider">
            </tbody>
          </table>
        </div>
            <!-- Footer -->
            <div class="footer-conteiner">
                    <?php
                    require_once '../../layout/footer.php';
                    ?>
            </div>
      </div>
      
    </div>
 
          <?php
          require_once('./modalEditarParametro.html');
          ?>
        
          <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
          <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
          <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
          <script src="../../../Recursos/js/Parametro/datatable.js" type="module"></script>
          <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
          <script src="../../../Recursos/js/Porcentajes/ValidacionesModalEditarPorcentaje.js" type="module"></script> -->
          <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
          <script src="../../../Recursos/js/index.js"></script>
</body>

</html>
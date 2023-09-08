<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/CarteraClientes.php");
require_once("../../../Controlador/ControladorCarteraClientes.php");
session_start(); //Reanudamos la sesion



// if(isset($_SESSION['usuario'])){
//   /* ====================== Evento ingreso a mantenimiento de usuario. =====================*/
//   $newBitacora = new Bitacora();
//   $accion = ControladorBitacora::accion_Evento();
//  date_default_timezone_set('America/Tegucigalpa');
//   $newBitacora->fecha = date("Y-m-d h:i:s"); 
//   $newBitacora->idObjeto = ControladorBitacora:: obtenerIdObjeto('gestionUsuario.php');
//   $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
//   $newBitacora->accion = $accion['income'];
//   $newBitacora->descripcion = 'El usuario '.$_SESSION['usuario'].' ingreso a mantenimiento usuario';
//   ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
//   /* =======================================================================================*/
// }

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
  <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href="../../../Recursos/css/gestionUsuario.css" rel="stylesheet" />
  <link href="../../../Recursos/css/modalNuevoUsuario.css" rel="stylesheet">
  <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  <!-- <link href="../../../Recursos/css/index.css" rel="stylesheet" /> -->
  <title> Cartera Cliente </title>
</head>

<body style="overflow: hidden;">
  <div class="conteiner">
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
          $urlSolicitud = '../solicitud/gestionSolicitud.php';
          //Comisión
          $urlComision = '../../comisiones/v_comision.php';
          //Consulta
          $urlClientes = '../cliente/gestionCliente.php';
          $urlVentas = '../Venta/gestionVenta.php';
          $urlArticulos = '../articulo/gestionArticulo.php';
          //Mantenimiento
          $urlUsuarios = '../usuario/gestionUsuario.php';
          $urlCarteraCliente = './gestionCarteraClientes.php';
          $urlPreguntas = '../pregunta/gestionPregunta.php';
          $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
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
                  <H1 class="title-dashboard-task">Gestión de Cartera de Clientes</H1>
            </div>  
          </div>
          
          <H1></H1>
        <div class="table-conteiner">
          <div>
            <a href="#" class="btn_nuevoRegistro btn btn-primary" id="btn_nuevoRegistro" data-bs-toggle="modal" data-bs-target="#modalNuevoCliente"><i class="fa-solid fa-circle-plus"></i> Nuevo registro</a>
          </div>
          <table class="table" id="table-CarteraClientes">
            <thead>
              <tr>
                <th scope="col"> ID </th>
                <th scope="col"> NOMBRE </th>
                <th scope="col"> RTN </th>
                <th scope="col"> TELEFONO </th>
                <th scope="col"> CORREO </th>
                <th scope="col"> DIRECCION </th>
                <th scope="col"> ESTADO CONTACTO </th>
                <th scope="col"> ACCIONES </th>                
              </tr>
            </thead>
            <div class ="text-left mb-2">
            <a href="../../fpdf/ReporteCarteraClientes.php" target="_blank" class="btn btn-success" id="btn_Pdf"> <i class="fas fa-file-pdf"> </i> Generar PDF</a>
            </div>
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
  </div>
  <?php
  require_once('modalNuevoCliente.html');
  require_once('modalEditarCliente.html');
  ?>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
  <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="../../../Recursos/js/CarteraClientes/datatable.js" type="module"></script>
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
  <script src="../../../Recursos/js/CarteraClientes/validacionesModalNuevoCliente.js"  type="module"></script>
  <script src="../../../Recursos/js/CarteraClientes/validacionesModalEditarCliente.js" type="module"></script>
</body>

</html>
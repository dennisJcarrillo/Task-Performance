<?php
require_once("../db/Conexion.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Bitacora.php");
require_once("../Controlador/ControladorUsuario.php");
require_once("../Controlador/ControladorBitacora.php");
session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  /* ========================= Capturar evento inicio sesión. =============================*/
  $newBitacora = new Bitacora();
  $accion = ControladorBitacora::accion_Evento();
  date_default_timezone_set('America/Tegucigalpa');
  $newBitacora->fecha = date("Y-m-d h:i:s");
  $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('index.php');
  $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
  $newBitacora->accion = $accion['income'];
  $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingreso al menú principal';
  ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
  /* =======================================================================================*/
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="https://cdn-icons-png.flaticon.com/512/1862/1862358.png">
  <!-- Boostrap5 -->
  <link href='../Recursos/boostrap5/bootstrap.min.css' rel='stylesheet'>
  <!-- Boxicons CSS -->
  <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link href='../Recursos/css/layout/sidebar.css' rel='stylesheet'>
  <!--   para el index.css
 -->
  <link href='../Recursos/css/index.css' rel='stylesheet'>
  <title>Dashboard</title>
</head>

<body style="overflow: hidden;">
  <!-- Sidebar -->
  <div class="conteiner-global">
    <div class="sidebar-conteiner">
      <?php
      $urlIndex = 'index.php';
      $urlGestion = './crud/usuario/gestionUsuario.php';
      $urlTarea = './rendimiento/v_tarea.php';
      $urlSolicitud = './crud/solicitud/gestionSolicitud.php';
      $urlComision = './comisiones/v_comision.php';
      $urlVenta = './crud/venta/gestionVenta.php';
      $urlCliente = './crud/cliente/gestionCliente.php';
      $urlCarteraCliente = './crud/carteraCliente/gestionCarteraClientes.php';
      $urlCrudComision = './crud/comision/gestionComision.php';
      $urlRoles = '../../../Vista/crud/rol/gestionRol.php';
      $urlPreguntas = '../../../Vista/crud/pregunta/gestionPregunta.php';
      $urlBitacoras = '../../../Vista/crud/bitacora/gestionBitacora.php';
      $urlPorcentaje = './crud/Porcentajes/gestionPorcentajes.php';
      $urlMetricas = './crud/Metricas/gestionMetricas.php';
      require_once 'layout/sidebar.php';
      ?>
    </div>
    <div class="conteiner-main">
      <div class="navbar-conteiner">
      </div>
      <!-- Cuerpo de la pagina -->
      <main class="main">
        <!-- Contenedor de los enlaces de los modulos -->
        <div class="conteiner-link">
          <a class="card-link" href="#"><i class="fa-solid fa-cash-register"></i> Ventas</a>
          <a class="card-link" href="#"><i class="fa-solid fa-square-poll-vertical"></i> Rendimiento</a>
          <a class="card-link" href="/Vista/comisiones/v_comision.php"><i class="fa-solid fa-money-bill"></i> Comisiones</a>
          <a class="card-link" href="/Vista/crud/cliente/gestionCliente.php"><i class="fa-solid fa-user-group"></i> Clientes</a>
          <a class="card-link" href="#"><i class="fa-solid fa-screwdriver-wrench"></i> Mantenimiento</a>
          <a class="card-link" href="#"><i class="fa-solid fa-screwdriver-wrench"></i> Consultas</a>
        </div>
      </main>
      <!-- Footer -->
      <div class="footer-conteiner">
        <P>FOOTER</P>
        <?php
        // require_once 'layout/navbar.php';
        ?>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="../Recursos/boostrap5/bootstrap.min.js"></script>
  <script src="../Recursos/js/index.js"></script>
</body>
</html>
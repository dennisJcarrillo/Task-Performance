<?php
require_once("../../../db/Conexion.php");
require_once("../../../Modelo/DataTableSolicitud.php");
require_once("../../../Modelo/Bitacora.php");
require_once("../../../Controlador/ControladorDataTableSolicitud.php");
require_once("../../../Controlador/ControladorBitacora.php");
require_once('../../../Modelo/Usuario.php');
require_once('../../../Controlador/ControladorUsuario.php');
require_once('../../../Modelo/Tarea.php');
require_once('../../../Controlador/ControladorTarea.php');



session_start(); //Reanudamos la sesion
if (isset($_SESSION['usuario'])) {
  $newBitacora = new Bitacora();
  $idRolUsuario = ControladorUsuario::obRolUsuario($_SESSION['usuario']);
  $permisoRol = ControladorUsuario::permisosRol($idRolUsuario);
  $idObjetoActual = ControladorBitacora::obtenerIdObjeto('gestionSolicitud.php');
  $objetoPermitido = ControladorUsuario::permisoSobreObjeto($_SESSION['usuario'], $idObjetoActual, $permisoRol);
  if(!$objetoPermitido){
    /* ====================== Evento intento de ingreso sin permiso a solicitud. ================================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionSolicitud.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['fallido'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' intentó ingresar sin permiso a solicitud';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
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
    /* ====================== Evento ingreso a vista solicitud. =====================*/
    $accion = ControladorBitacora::accion_Evento();
    date_default_timezone_set('America/Tegucigalpa');
    $newBitacora->fecha = date("Y-m-d h:i:s");
    $newBitacora->idObjeto = ControladorBitacora::obtenerIdObjeto('gestionSolicitud.php');
    $newBitacora->idUsuario = ControladorUsuario::obtenerIdUsuario($_SESSION['usuario']);
    $newBitacora->accion = $accion['income'];
    $newBitacora->descripcion = 'El usuario ' . $_SESSION['usuario'] . ' ingresó a vista a la vista de solicitud';
    ControladorBitacora::SAVE_EVENT_BITACORA($newBitacora);
    $_SESSION['objetoAnterior'] = 'gestionSolicitud.php';
    $_SESSION['descripcionObjeto'] = 'vista de solicitud';
    /* =======================================================================================*/
  }
} else {
  header('location: ../../login/login.php');
  die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- DataTables -->
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.min.css">
    <!-- Boostrap5 -->
    <link href='../../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
    <link href='../../../Recursos/css/v_nueva_solicitud.css' rel='stylesheet'>
    <!-- Estilos personalizados -->
    
    <link href="../../../Recursos/css/modalClienteFrecuente.css" rel="stylesheet">
    <link href="../../../Recursos/css/modalEditarTarea.css" rel="stylesheet">
    <link href='../../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../../Recursos/css/layout/footer.css' rel='stylesheet'>
  
  
    <title>Nueva solicitud</title>
</head>

<body>
    <div class="conteiner">
        <div class="conteiner-global">
            <div class="sidebar-conteiner">
                <?php
                $urlIndex = '../../index.php';
                // Rendimiento
                $urlMisTareas = '../../rendimiento/v_tarea.php';
                $urlConsultarTareas = './'; //PENDIENTE
                $urlBitacoraTarea = ''; //PENDIENTE
                $urlMetricas = '../Metricas/gestionMetricas.php';
                $urlEstadisticas = '../../grafica/estadistica.php'; //PENDIENTE
                //Solicitud
                $urlSolicitud = '../DataTableSolicitud/gestionDataTableSolicitud.php';
                //Comisión
                $urlComision = '../../comisiones/v_comision.php';
                $comisionVendedor = '../ComisionesVendedores/ComisionesVendedores.php';
                $urlPorcentajes = '../Porcentajes/gestionPorcentajes.php';
                //Consulta
                $urlClientes = '../cliente/gestionCliente.php';
                $urlVentas = '../Venta/gestionVenta.php';
                $urlArticulos = '../articulo/gestionArticulo.php';
                //Mantenimiento
                $urlUsuarios = '../usuario/gestionUsuario.php';
                $urlCarteraCliente = '../carteraCliente/gestionCarteraClientes.php';
                $urlPreguntas = '../pregunta/gestionPregunta.php';
                $urlBitacoraSistema = '../bitacora/gestionBitacora.php';
                $urlParametros = '../parametro/gestionParametro.php';
                $urlPermisos = '../permiso/gestionPermiso.php';
                $urlRoles = '../rol/gestionRol.php';
                $urlServiciosTecnicos = '../TipoServicio/gestionTipoServicio.php';
                $urlImg = '../../../Recursos/imagenes/Logo-E&C.png';
                require_once '../../layout/sidebar.php';
                ?>
            </div>
            <div class="conteiner-main">
    <div class="encabezado">
        <div class="navbar-conteiner">
            <!-- Aqui va la barra -->
            <?php include_once '../../layout/navbar.php' ?>
        </div>
        <div class="titulo">
            <h2 class="title-dashboard-task">Generar nueva solicitud</h2>
        </div>
    </div>
    <div class="form-conteiner">
        <div class="form-element">
            <label>Tipo solicitud: </label>
            <div class="radio-conteiner">
			<input type="radio" name="radioOption" id="cliente-existente"  class="radio" value="Existente" ><label for="cliente-existente" class="radio-label form-label">Existente</label>
			<input type="radio" name="radioOption" id="cliente-nuevo" class="radio" value="Nuevo" ><label for="cliente-nuevo" class="radio-label form-label">Nuevo</label>   
            </div>
        </div>
        <form action="<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method="post" id="form-solicitud">
          
        <div class="group-form">
                <div class="form-element input-conteiner"  id="container-Factura-cliente">
                    <label for="id-factura"  class="form-label">N° Factura</label>
                    <input type="text" id="id-factura" name="numeroFactura" class="form-control">
                </div>
                <div class="form-element input-conteiner" id="container-rtn-cliente" >
                    <label for="rnt-cliente" class="form-label">RTN:</label>
                    <p id="mensaje"></p>
                    <input type="text" id="rnt-cliente" name="rtnCliente" class="form-control">
                </div>
                <div class="form-element input-conteiner">
                    <label for="telefono" class="form-label">nombre</label>
                    <input type="text" id="nombre" name="telefono" class="form-control">
                </div>
                <div class="form-element input-conteiner">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" class="form-control">
                </div>
                <div class="form-element input-conteiner">
            <label for="correo"class="form-label">Correo electrónico</label>
            <input type="text" id="correo" name="correoElectronico" class="form-control" value="oaoproyecto@gmail.com" readonly>
        </div>
            </div>
                <div class="group-form">
                    <div class="form-element input-conteiner">
                        <label for="fecha-solicitud" class="form-label">Fecha solicitud</label>
                        <input type="date" id="fecha-solicitud" name="fechaSolicitud" class="form-control">
                    </div>
                    <div class= "form-element input-conteiner">
                        <label for="tipo-solicitud" class="form-label">Tipo solicitud</label>
                        <input type="text" id="tipo-solicitud" name="tipoSolicitud" class="form-control">
                    </div>
            
                    <div class="form-element input-conteiner">
                        <label for="id-descripcion" class="form-label">Ubicación instalación</label>
                        <input type="text" id="id-descripcion" name="ubicacionInstalacion" class="form-control">
                    </div>
                    <div class="form-element input-conteiner">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <input type="text" id="descripcion" name="descripcion" class="form-control">
                    </div>
                </div>
            </div>
                <div class="table-conteiner">
                    <div class="mb-3 conteiner-id-articulo">
                        <p class="titulo-articulo">Artículos Interés</p>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalArticulosSolicitud" id="btn-articulos">
                            Seleccionar... <i class="btn-fa-solid fa-solid fa-magnifying-glass-plus"></i>
                                </button>
                            </div>
                            <table id="table-articulos" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Id</th>
                                        <th scope="col">Artículo</th>
                                        <th scope="col">Marca</th>
                                        <th scope="col">Cantidad</th>
                                        </tr>
                                </thead>
                                    <tbody id="list-articulos" class="table-group-divider">
                                            <!-- Articulos de interes -->
                                        </tbody>
                                    </table>
                                </div>
					<!-- Botones -->
					<div class="btn-guardar">
						<a href="./v_tarea.php"><button type="button" id="btn-cerrar2" class="btn btn-secondary">Cancelar</button></a>
						<button type="submit" id="btn-guardar" class="btn btn-primary" name="actualizarTarea"><i class="fa-solid fa-floppy-disk"></i>Guardar</button>
					</div>
				</form>
			</div>
			</main>
		</div>
	</div>
<?php
  require_once('modalClienteFrecuente.html');
  require_once('modalArticulosSolicitud.html');
  require_once('modalFacturaSolicitud.html');
?>
 <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
  <script src="../../../Recursos/js/librerias/jQuery-3.7.0.min.js"></script>
  <script src="../../../Recursos/js/librerias/JQuery.dataTables.min.js"></script>
  <!-- Scripts propios -->
  <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
  <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
  <script src="../../../Recursos/js/index.js"></script>
  <script src="../../../Recursos/js/DataTableSolicitud/vistaClienteFrecuente.js" type="module"></script>

</body>

</html>
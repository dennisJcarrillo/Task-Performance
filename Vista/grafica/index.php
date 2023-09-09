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
    <link href='../../Recursos/bootstrap5/bootstrap.min.css' rel='stylesheet'>
    <!-- Boxicons CSS -->
    <link flex href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link href='./index.css' rel='stylesheet'>
    <title>Gráfica</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@latest/dist/Chart.min.js"></script>
    <link href='../../Recursos/css/layout/sidebar.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/estilosEstructura.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/navbar.css' rel='stylesheet'>
    <link href='../../Recursos/css/layout/footer.css' rel='stylesheet'>
</head>

<body style="overflow: hidden;">
    <!-- Sidebar 1RA PARTE -->
    <div class="conteiner-global">
        <div class="sidebar-conteiner sidebar locked">
            <?php
            $urlIndex = '../index.php';
            // Rendimiento
            $urlMisTareas = './v_tarea.php';
            $urlConsultarTareas = './'; //PENDIENTE
            $urlBitacoraTarea = ''; //PENDIENTE
            $urlMetricas = '../crud/Metricas/gestionMetricas.php';
            $urlEstadisticas = ''; //PENDIENTE
            //Solicitud
            $urlSolicitud = '../crud/DataTableSolicitud/gestionDataTableSolicitud.php';
            //Comisión
            $urlComision = '../comisiones/v_comision.php';
            //Consulta
            $urlClientes = '../crud/cliente/gestionCliente.php';
            $urlVentas = '../crud/Venta/gestionVenta.php';
            $urlArticulos = '../crud/articulo/gestionArticulo.php';
            //Mantenimiento
            $urlUsuarios = '../crud/usuario/gestionUsuario.php';
            $urlCarteraCliente = '../crud/carteraCliente/gestionCarteraClientes.php';
            $urlPreguntas = '../crud/pregunta/gestionPregunta.php';
            $urlBitacoraSistema = '../crud/bitacora/gestionBitacora.php';
            $urlParametros = '../crud/parametro/gestionParametro.php';
            $urlPermisos = '../crud/permiso/gestionPermiso.php';
            $urlRoles = '../crud/rol/gestionRol.php';
            $urlPorcentajes = '../crud/Porcentajes/gestionPorcentajes.php';
            $urlServiciosTecnicos = '../crud/TipoServicio/gestionTipoServicio.php';
            require_once '../layout/sidebar.php';
          ?>
        </div>    

        <div class="conteiner-main">

                <!-- Encabezado -->
            <div class= "encabezado">
                <div class="navbar-conteiner">
                    <!-- Aqui va la barra -->
                    <?php include_once '../layout/navbar.php'?>                             
                </div>        
                <div class ="titulo">
                    <H2 class="title-dashboard-task">Graficas</H2>
                </div>  
            </div>

            <div class="Graficoss" >
                <div class="filtros">
                    <div class="filtro-fecha">
                        <label for="fechaDesde">Fecha desde:</label>
                        <input type="date" id="fechaDesdef" name="fechaDesdef" class="form-control">
                        <label for="fechaHasta">Fecha hasta:</label>
                        <input type="date" id="fechaHastaf" name="fechaHastaf" class="form-control">
                    </div>
                    
                    <div class="filtro-Input">   
                        <input type="radio" id="general" name="fav_language" value="General">
                        <label for="html">General</label><br>
                        <input type="radio" id="porVendedor" name="fav_language" value="Por Vendedor">
                        <label for="css">PorVendedor</label><br>
                    </div>
                    
                    <div class="filtro-PorVendedor" id="PorVendedor">
                        <label for="PorTarea" class="form-label">Seleccione Vendedores:</label>
                        <select class="filtro-PorVendedor" data-placeholder="Lorem ipsum dolor sit amet">
                            <option value="" disabled selected>Seleccionar...</option>
                            <option value="L">LEAD</option>
                            <option value="C">LLAMADA</option>
                        </select>
                    </div> 

                    <div class="filtro-PorTarea" id="PorTarea">
                        <label for="PorTarea" class="form-label">Seleccione Tareas:</label>
                        <select class="filtro-PorTarea" disable="What's your favorite movie ?">
                        <option value="" disabled selected>Seleccionar...</option>
                            <option value="L">LEAD</option>
                            <option value="C">LLAMADA</option>
                            
                        </select>
                    </div> 
                    <button type="button" class="btn btn-primary" id="btnFiltrar">Filtrar</button>

                </div>  
                <div class="grafica">
                    <canvas id="grafica"  style="display: flow-root; width: 1333px; height: 366px;" class="chartjs-render-monitor"></canvas>
                </div>
            </div>
            
                <!-- Footer -->
            <div class="footer-conteiner">
                    <?php
                    require_once '../layout/footer.php';
                    ?>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="https://kit.fontawesome.com/2317ff25a4.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.12/dist/sweetalert2.all.min.js"></script>
    <script src="../../../Recursos/js/librerias//jQuery-3.7.0.min.js"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="../../../Recursos/js/librerias/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="../../../Recursos/bootstrap5/bootstrap.min.js"></script>
     <script src="../../../Recursos/js/index.js"></script>
</body>

</html>
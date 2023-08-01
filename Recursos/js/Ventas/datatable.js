let tablaVentas = '';
$(document).ready(function () {
  tablaVentas = $('#table-Ventas').DataTable({
    "ajax": {
      "url": "../../../Vista/crud/Venta/obtenerVenta.php",
      "dataSrc": ""
    },
    "language":{
      "url":"//cdn.datatables.net/plug-ins/1.13.5/i18n/es-ES.json"
    },
    "columns": [
      { "data": "numFactura"},
      { "data": 'fechaEmision' },
      { "data": 'codCliente' },
      { "data": 'nombreCliente' },
      { "data": 'rtnCliente' },
      { "data": 'totalBruto' },
      { "data": 'totalImpuesto'},
      { "data": 'totalVenta' },
    ]
  });

});


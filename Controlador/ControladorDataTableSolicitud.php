<?php

class ControladorDataTableSolicitud {

  
    public static function DataTableSolicitud(){
        return DataTableSolicitud::obtenerSolicitud();
    }

    public static function actualizarEstadoSolicitud($cancelarSolicitud){
        return DataTableSolicitud::actualizarEstadoSolicitud($cancelarSolicitud);
    }

    public static function LlenarModalSolicitudEditar($idSolicitud){
        return DataTableSolicitud::obtenerSolicitudPorId($idSolicitud);
    }

    public static function editarDataTableSolicitud($EditarSolicitud){
        return DataTableSolicitud::editarSolicitud($EditarSolicitud);
    }

    public static function VerSolicitudesPorId($idSolicitud){
        return DataTableSolicitud::VerSolicitudesPorId($idSolicitud);
    }

    public static function NuevaSolicitud($nuevaSolicitud, $productosSolicitud){
        return DataTableSolicitud::NuevaSolicitud($nuevaSolicitud, $productosSolicitud);
    }

    public static function obtenerProductosS($idSolicitud){
        return DataTableSolicitud::obtenerArticuloS($idSolicitud);
    }   

    public static function validarRtnExiste($rtn){
        return DataTableSolicitud::validarRtnExiste($rtn);
       }

    public static function obtenerSolicitudPDF($buscar){
       return DataTableSolicitud::obtenerSolicitudPDF($buscar);
    }
    
    public static function insertarEvidenciaPDF($solicitud, $directorio_destino){
        DataTableSolicitud::insertarEvidenciaPDF($solicitud, $directorio_destino);
    } 
}
<?php
Class ControladorRazonSocial{
    public static function getRazonSocial(){
        return razonSocial::obtenerTodasLasRazonSocial();
    }

    public static function crearRazonSocial($nuevaRazonSocial){
        razonSocial::nuevaRazonSocial($nuevaRazonSocial);
    }

    public static function editarRazonSocial($editarRazonSocial){
        razonSocial::editarRazonSocial($editarRazonSocial);
    }

    public static function eliminarRazonSocial($idRazonSocial){
        return razonSocial::eliminarRazonSocial($idRazonSocial);
    }
    public static function RazonSocialExiste($razonSocial){
        return razonSocial::RazonSocialExistente($razonSocial);
    }
    public static function obtenerRazonSocialPDF($buscar){
        return razonSocial::obtenerPdfRazonSocial($buscar);
    }
}
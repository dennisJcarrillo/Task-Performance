<?php

class ControladorArticulo {
    public static function obtenerTodosArticulos(){
        return Articulo::obtenerArticulo();
    }

    public static function obtenerArticuloxId($CodArt){
        return Articulo::obtenerArticuloxId($CodArt);
    }

    public static function obtenerArticuloPdf($buscar){
        return Articulo::obtenerArticuloPdf($buscar);
    }
}
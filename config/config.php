<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of config
 *
 * @author samuel
 */
class Config {
    
  
    
    //put your code here
    private static $nombreCompañia = "";
    private static $imagenCompañia = "";
    private static $nombreSistema = "";
    private static $tituloPagina = "";
    private static $notaAlPie="";
    private static $tituloModal="";
    private static $nombreCliente="";
    private static $rutaCss="";
    
    static function getRutaCss(){
        return self::$rutaCss;
    }
    static function setRutaCss($rutaCss){
        self::$rutaCss=$rutaCss;
    }
    
    static function getNotaAlPie(){
        return self::$notaAlPie;
    }
    
    static function setNotaAlPie($notaAlPie){
        self::$notaAlPie=$notaAlPie;
    }
    
    static function getTituloModal(){
        return self::$tituloModal;
    }
    
    static function setTituloModal($tituloModal){
        self::$tituloModal=$tituloModal;
    }
    
    static function getNombreCompañia() {
        return self::$nombreCompañia;
    }

    static function getImagenCompañia() {
        return self::$imagenCompañia;
    }

    static function getNombreSistema() {
        return self::$nombreSistema;
    }

    static function getNombreCliente() {
        return self::$nombreCliente;
    }
    
    static function getTituloPagina() {
        return self::$tituloPagina;
    }

    static function setNombreCompañia($nombreCompañia) {
        self::$nombreCompañia = $nombreCompañia;
    }

    static function setImagenCompañia($imagenCompañia) {
        self::$imagenCompañia = $imagenCompañia;
    }

    static function setNombreSistema($nombreSistema) {
        self::$nombreSistema = $nombreSistema;
    }

    static function setTituloPagina($tituloPagina) {
        self::$tituloPagina = $tituloPagina;
    }
    
    static function setNombreCliente($nombreCliente) {
        self::$nombreCliente = $nombreCliente;
    }

    
    static function init() {

        $c = Conexion::getConexionPorDefecto();
        $sql = 'SELECT  nombreSistema,'
                . ' nombreCompañia,'
                . ' urlImagenCompañia,'
                . ' tituloPagina,'
                . ' notaPie,'
                . ' tituloModal,'
                . ' nombreCliente, '
                . ' rutacss '
                . '  FROM configuracion where id_empresa= ';
        if(isset($_SESSION['id_empresa'])){
            $sql=$sql." {idEmp}";
        }else{
            //EMPRESA POR DEFECTO
            $sql=$sql."3";
        }
        $res = new ResultSet($sql);

        $res->next();

        Config::setNombreSistema($res->getString("nombreSistema"));
        Config::setNombreCompañia($res->getString("nombreCompañia"));
        Config::setImagenCompañia($res->getString("urlImagenCompañia"));
        Config::setTituloPagina($res->getString("tituloPagina"));
        Config::setNotaAlPie($res->getString("notaPie"));
        Config::setTituloModal($res->getString("tituloModal"));
        Config::setTituloModal($res->getString("tituloModal"));
        Config::setNombreCliente($res->getString("nombreCliente"));
        Config::setRutaCss($res->getString("rutacss"));
    }

}

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of user
 *
 * @author samuel
 */
class User {
    //put your code here
    private static $idUsuario="NO SESSION";
    private static $nombreUsuario="NO SESSION";
    private static $nombrePerfil="NO SESSION";
    private static $idPerfil="NO SESSION";
    
    static function getIdUsuario(){
        return self::$idUsuario;
    }
    
    static function getNombreUsuario(){
        return self::$nombreUsuario;
    }
    
    static function getPerfil(){
        return self::$nombrePerfil;
    }
    
    static function getIdPerfil(){
        return self::$idPerfil;
    }
    
    static function init(){
       //Almaceno el idDelUsuario
       self::$idUsuario=$_SESSION["idUsuario"];
       //Almaceno el nombre del usuario
       self::$nombreUsuario=$_SESSION["nombreUsuario"];
       //Almaceno el perfil del usuario  
       self::$idPerfil=$_SESSION["idPerfil"];
       //Almaceno el nombre perfil del usuario  
       self::$nombrePerfil=$_SESSION["nombrePerfil"];
       
    }
    
    
    

}

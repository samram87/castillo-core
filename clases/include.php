<?php


$add ='core/';
if(!isset($sinSesion)){
    include 'Sesion.php';
}
include  $add.'clases/ini_set.php';


include $add.'clases/conexion.php';
include $add.'clases/resultset.php';
include $add.'config/config.php';
if(isset($_SESSION['id_empresa'])){
    Config::init();    
}

include $add.'clases/campos.php';
include $add.'funciones/menu.php';
include $add.'funciones/utilidades.php';
include $add.'funciones/bitacora.php';
include $add.'clases/user.php';
include $add.'clases/Request.php';
if(!isset($sinSesion)){
    User::init();
}


if(isset($_SESSION["mayusDia"])){
    if($_SESSION["mayusDia"]==true){
        if(!isset($noMayusculas)){
            mayusculasVariables();
        }
    }
}





?>
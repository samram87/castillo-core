<?php
//Capturo lo que ha venido en el Usuario/Password.
error_reporting(E_ALL);
ini_set('display_errors', '1');
$noMayusculas=true;
$sinSesion=true;
include 'core/clases/include.php';


$usuario=$_REQUEST["user"];
$password=$_REQUEST["password"];

$password=str_replace("'", "\\'", $password);

//Primero reviso que el usuario exista.
$query="select idUsuario,
concat(
ifnull(primerNombre,''),' ',
ifnull(segundoNombre,''),' ',
ifnull(primerApellido,''),' ',
ifnull(segundoApellido,'')
) as nombre,
cambiarClave,
activo,
email,
escribeEnMayusculas(idUsuario) as mayus,
idPerfilPorDefecto,
usuario.id_empresa,
perfiles.nombrePerfil
from usuario inner join perfiles on usuario.idPerfilPorDefecto=perfiles.idPerfil
where upper(login)=upper('$usuario')
and password=MD5('$password')";


$rs=new ResultSet($query);
$entro=false;
if(!$rs->next()){
    header('Location: index.php?error') ;
    echo $conexion->mostrarErrores();
    die();
}
$rs->beforeFirst();
$mayus=false;
$idUnidad=0;
while($rs->next()){
    $idUsuario=$rs->getInt("idUsuario");
    $nombre=$rs->getString("nombre");
    $cambiarClave=$rs->getBoolean("cambiarClave");
    $activo=$rs->getBoolean("activo");
    $email=$rs->getString("email");
    $mayus=$rs->getBoolean("mayus");   
    $idPerfilPorDefecto=$rs->getString("idPerfilPorDefecto");
    $nombrePerfil=$rs->getString("nombrePerfil");
    $id_empresa=$rs->getString("id_empresa");
}
$rs->cerrar();
if($activo===false){
    header('Location: index.php?activo') ;
    $conexion->cerrar();
    die();
}

$rs->cerrar();
session_start();
$_SESSION["id_empresa"]=$id_empresa;
//Almaceno el idDelUsuario
$_SESSION["idUsuario"]=$idUsuario;
//Almaceno el nombre del usuario
$_SESSION["nombreUsuario"]=$nombre;
//Almaceno el mail del usuario
$_SESSION["emailUsuario"]=$email;
//Almaceno el id de la unidad del usuario

$_SESSION["loginUsuario"]=$usuario;

//Almaceno si el usuario escribe en mayusculas
$_SESSION["mayus"]=$mayus;

//Guardo el 
$_SESSION["idPerfil"]=$idPerfilPorDefecto;

//Guardo el 
$_SESSION["nombrePerfil"]=$nombrePerfil;

$queryMenu="SELECT
    Menu.URL, Menu.idMenu
FROM
    MenuPorPerfil
    INNER JOIN menu
        ON (MenuPorPerfil.idMenu = menu.idMenu)
WHERE MenuPorPerfil.menuPorDefecto =1
    AND MenuPorPerfil.idPerfil='$idPerfilPorDefecto'";

echo $queryMenu;

$rs=new ResultSet($queryMenu);

if($rs->next()){
    $url=$rs->getString(0);
    $idM=$rs->getString(1);
    if(strpos($url, "?")===false){
        $url.="?idMenuSeleccionado=$idM";
    }else{
        $url.="&idMenuSeleccionado=$idM";
    }
    header("Location: $url");
}else{
    header('Location: /core/bienvenida.php');
}

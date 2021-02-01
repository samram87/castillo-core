<?php
//Capturo lo que ha venido en el Usuario/Password.
error_reporting(E_ALL);
ini_set('display_errors', '1');
$noMayusculas=true;
$sinSesion=true;
include 'core/clases/include.php';

session_start();

$idPerfilPorDefecto=$_REQUEST["perfil"];

//Guardo el 
$_SESSION["idPerfil"]=$idPerfilPorDefecto;


$queryMenu="SELECT
    Menu.URL, Menu.idMenu,
    perfiles.nombrePerfil
FROM
    MenuPorPerfil
    INNER JOIN menu
        ON (MenuPorPerfil.idMenu = menu.idMenu)
    inner join perfiles on MenuPorPerfil.idPerfil =perfiles.idPerfil
WHERE MenuPorPerfil.menuPorDefecto =1
    AND MenuPorPerfil.idPerfil='$idPerfilPorDefecto'";

echo $queryMenu;

$rs=new ResultSet($queryMenu);

if($rs->next()){
    $url=$rs->getString(0);
    $nombrePerf=$rs->getString("nombrePerfil");
    $_SESSION["nombrePerfil"]=$nombrePerf;
    header("Location: $url");
}else{
    header('Location: /core/bienvenida.php');
}

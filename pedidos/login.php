<?php
$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';

if(!isset($_GET["version"])){
    echo "[]";
    die();
}

if($_GET["version"]!="1.5"){
    echo "[]";
    die();
}

$sql="select usuario.idUsuario,NombreDeUsuario(usuario.idUsuario) nombre, login,password, idPerfilPorDefecto as perfil,'1020' as minutodia
from usuario inner join 
usuariosporperfiles on usuario.idUsuario=usuariosporperfiles.idUsuario
where  usuariosporperfiles.idPerfil in ('APP_PEDIDOS','SUPERVISOR_APP')  and login=".R::getString("user")."and password=".R::getString("pass");
$rs=new ResultSet($sql);
echo $rs->toJsonArray();


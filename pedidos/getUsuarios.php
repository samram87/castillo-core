<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';


$sql="select usuario.idUsuario,NombreDeUsuario(usuario.idUsuario) nombre, login,password, idPerfilPorDefecto as perfil
from usuario inner join 
usuariosporperfiles on usuario.idUsuario=usuariosporperfiles.idUsuario;
where usuariosporperfiles.idPerfil='APP_PEDIDOS'";
$rs=new ResultSet($sql);
echo $rs->toJsonArray();

<?php
$trabajandoEnFrame=true;
include 'core/clases/include.php';

$rs=new ResultSet("select (usuarioPerteneceAPerfil($idUsuario,'CONFIG') or usuarioPerteneceAPerfil($idUsuario,'SIS_002')) as permiso");
if($rs->next()){
    if($rs->getInt(0)==0){
        echo "<center><H2>Usted no tiene permisos para cambiar la clave del usuario</H2></center>";
        die();
    }
}

if(isset($_GET["IDUsuario"])){
    if($_GET["IDUsuario"]!=''){
        $sql="update usuario set password=login where idUsuario=".$_GET["IDUsuario"];
        $conexion->ejecutar($sql);
        echo "<center><H2>La Clave ha sido cambiada exitosamente.</h2></center>";
    }
}


?>
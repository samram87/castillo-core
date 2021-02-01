<?php
include $_SERVER['DOCUMENT_ROOT']."/core/clases/include.php";

 if($_SESSION["tipoMenuDia"]==1){
    echo "<ul id='nav'>";
 }
 $sqlQuery="CALL GenerarMenu($idUsuario)";
 $conexion->ejecutar($sqlQuery);
 $sqlQuery="SELECT distinct MenuUsuario.* from MenuUsuario order by NivelMenu,Titulo";
 $rs=new ResultSet($sqlQuery);
 //$rs=$conexion->ejecutarQuery($sqlQuery);
 $menu=generarMenu($rs);
 echo $menu;
 $conexion->ejecutar("DROP TEMPORARY TABLE IF EXISTS MenuUsuario");
 if($_SESSION["tipoMenuDia"]==1){
    echo "</ul>";
 }



?>
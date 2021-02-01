<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';
;

$sql="
select CODI_RUTA as codigo,NOMB_RUTA as nombre, ESTA_RUTA as estado, 
(select count(1) from pedidos.maes_clie where maes_clie.CODI_RUTA=maes_ruta.CODI_RUTA) as cantidad  
FROM pedidos.maes_ruta where (select count(1) from pedidos.maes_clie where maes_clie.CODI_RUTA=maes_ruta.CODI_RUTA) >0";


$rs=new ResultSet($sql);
echo $rs->toJsonArray();
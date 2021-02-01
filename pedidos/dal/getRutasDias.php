<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';


$sql="select 
    CODI_CLIE as codigo, 
    NOMB_CLIE as nombre, 
    TIPO_CLIE as tipo, 
    DIRE_CLIE as direccion,
    TEOF_CLIE as telefono,
    CELU_CLIE as celular, 
    EMAI_CLIE as email, 
    (select NOMB_MUNI from pedidos.maes_muni where CODI_MUNI=maes_clie.CODI_MUNI) as municipio,
    (select NOMB_DEPA from pedidos.maes_muni inner join pedidos.maes_depa on maes_muni.CODI_DEPA=maes_depa.CODI_DEPA where CODI_MUNI=maes_clie.CODI_MUNI) as departamento,
    LATITUD as LATITUD, 
    LONGITUD as LONGITUD
    from pedidos.maes_clie  where CODI_CLIE in (select ";
$rs=new ResultSet($sql);
echo $rs->toJsonArray();

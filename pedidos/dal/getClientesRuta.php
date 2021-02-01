<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';
$sql="
select 
    CODI_CLIE as codigo, 
    CODI_CLIE as codigoCliente, 
    NOMB_CLIE as cliente, 
    NOMB_CLIE as nombre, 
    TIPO_CLIE as tipo, 
    DIRE_CLIE as direccion,
    TEOF_CLIE as telefono,
    CELU_CLIE as celular, 
    EMAI_CLIE as email, 
    CLAS_CLIE as clase,
    NOMB_COME as nombreComercial,
    CODI_MUNI,
    (select NOMB_MUNI from pedidos.maes_muni where CODI_MUNI=maes_clie.CODI_MUNI) as municipio,
    (select NOMB_DEPA from pedidos.maes_muni inner join pedidos.maes_depa on maes_muni.CODI_DEPA=maes_depa.CODI_DEPA where CODI_MUNI=maes_clie.CODI_MUNI) as departamento,
    LATITUD as latitud, 
    LONGITUD as longitud
    from pedidos.maes_clie where CODI_RUTA=".R::getString("codigo");

$rs=new ResultSet($sql);
echo $rs->toJsonArray();

<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';


$sql="
select 
    CODI_CLIE as codigo, 
    NOMB_CLIE as nombre, 
    TIPO_CLIE as tipo, 
    DIRE_CLIE as direccion,
    TEOF_CLIE as telefono,
    CELU_CLIE as celular, 
    EMAI_CLIE as email, 
    CLAS_CLIE as clase,
    NOMB_COME as nombreComercial,
    (select NOMB_MUNI from pedidos.maes_muni where CODI_MUNI=maes_clie.CODI_MUNI) as municipio,
    (select NOMB_DEPA from pedidos.maes_muni inner join pedidos.maes_depa on maes_muni.CODI_DEPA=maes_depa.CODI_DEPA where CODI_MUNI=maes_clie.CODI_MUNI) as departamento,
    LATITUD as LATITUD, 
    LONGITUD as LONGITUD
    from pedidos.maes_clie where CODI_CLIE='214919'

union

select 
    CODI_CLIE as codigo, 
    NOMB_CLIE as nombre, 
    TIPO_CLIE as tipo, 
    DIRE_CLIE as direccion,
    TEOF_CLIE as telefono,
    CELU_CLIE as celular, 
    EMAI_CLIE as email, 
    CLAS_CLIE as clase,
    NOMB_COME as nombreComercial,
    (select NOMB_MUNI from pedidos.maes_muni where CODI_MUNI=maes_clie.CODI_MUNI) as municipio,
    (select NOMB_DEPA from pedidos.maes_muni inner join pedidos.maes_depa on maes_muni.CODI_DEPA=maes_depa.CODI_DEPA where CODI_MUNI=maes_clie.CODI_MUNI) as departamento,
    LATITUD as LATITUD, 
    LONGITUD as LONGITUD
    from pedidos.maes_clie
    where maes_clie.esta_clie='A' and CODI_CLIE in (select 
    c.CODI_CLIE
    from pedidos.maes_vend as v inner join pedidos.maes_ruta as r on
    v.CODI_VEND=r.CODI_VEND inner join
    pedidos.maes_clie as c on 
    c.CODI_RUTA=r.CODI_RUTA
    inner join pedidos.usuario_vendedor on
    usuario_vendedor.codi_vend=v.codi_vend
    where usuario_vendedor.id_usuario='".$_GET["idUser"]."') ";

$rs=new ResultSet($sql);
echo $rs->toJsonArray();

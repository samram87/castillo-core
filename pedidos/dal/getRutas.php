<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';
;

$sql="
select * from
(select 
c.CODI_CLIE as codigoCliente,
c.NOMB_CLIE as cliente,
c.`LATITUD` as latitud,
c.`LONGITUD` as longitud,
c.`DIRE_CLIE` as direccion,
'' as ruta,
'".$_GET["idUser"]."' as idUser,
c.NOMB_COME as nombreComercial,
(select nomb_muni from pedidos.maes_muni where codi_muni=c.codi_muni) as municipio
from pedidos.maes_clie as c where c.CODI_CLIE='214919') as nuev
union
    select * from (select 
    c.CODI_CLIE as codigoCliente,
    c.NOMB_CLIE as cliente,
    c.`LATITUD` as latitud,
    c.`LONGITUD` as longitud,
    c.`DIRE_CLIE` as direccion,
    r.`NOMB_RUTA` as ruta,
    v.ID_USER as idUser,
    c.NOMB_COME as nombreComercial,
    (select nomb_muni from pedidos.maes_muni where codi_muni=c.codi_muni) as municipio
    from pedidos.maes_vend as v inner join pedidos.maes_ruta as r on
    v.CODI_VEND=r.CODI_VEND inner join
    pedidos.maes_clie as c on 
    c.CODI_RUTA=r.CODI_RUTA
    inner join pedidos.usuario_vendedor on
    usuario_vendedor.codi_vend=v.codi_vend
    where c.esta_clie='A' and  ( usuario_vendedor.id_usuario='".$_GET["idUser"]."' or c.CODI_CLIE='214919')
    order by r.NOMB_RUTA ) as tb   ";



/*

$sql="select 
    c.CODI_CLIE as codigoCliente,
    c.NOMB_CLIE as cliente,
    c.`LATITUD` as latitud,
    c.`LONGITUD` as longitud,
    c.`DIRE_CLIE` as direccion,
    r.`NOMB_RUTA` as ruta,
    ar.dia_visita as fecha,
    v.ID_USER as idUser
    from pedidos.maes_vend as v inner join pedidos.maes_ruta as r on
    v.CODI_VEND=r.CODI_VEND inner join
    pedidos.agenda_ruta as ar on
    ar.codi_ruta=r.CODI_RUTA inner join 
    pedidos.maes_clie as c on 
    c.CODI_RUTA=r.CODI_RUTA
     inner join pedidos.usuario_vendedor on
    usuario_vendedor.codi_vend=v.codi_vend
    where ar.dia_visita=DAYOFWEEK(CURDATE()) and usuario_vendedor.id_usuario='".$_GET["idUser"]."'
    order by ar.dia_visita, r.NOMB_RUTA    ";

 */

$rs=new ResultSet($sql);
echo $rs->toJsonArray();
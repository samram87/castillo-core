<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';

/*
$sql="SELECT 
a.CODI_ARTI AS Codigo,
a.NOMB_ARTI AS Producto,
e.NOMB_PROV AS Proveedor,
b.DESC_MARC AS Marca,
c.NOMB_MEDI AS UnidadMediMenor,
pedidos.NombreUnidadMedida_m(a.CODI_ARTI,'M') AS UnidadMediMayor, 
pedidos.factor_m(a.CODI_ARTI,'M') AS FactorMayoreo,  
IFNULL(pedidos.precio_m(a.CODI_ARTI,'D'),0) AS PrecioUnidad, 
IFNULL(pedidos.precio_m(a.CODI_ARTI,'M'),0) AS PrecioMayoreo,
d.VALO_EXIS AS Existencias
FROM pedidos.maes_arti a 
INNER JOIN pedidos.marc_arti b ON b.CODI_MARC=a.CODI_MARC
LEFT JOIN pedidos.tipo_medi c ON c.CODI_MEDI=a.CODI_MEDI 
LEFT JOIN pedidos.exis_tenc d ON d.CODI_ARTI=a.CODI_ARTI
LEFT OUTER JOIN pedidos.maes_prov e ON e.CODI_PROV=a.CODI_PROV 
ORDER BY a.NOMB_ARTI";
*/
$sql="SELECT 
`precios_y_existencias`.`Codigo`,
`precios_y_existencias`.`Producto`,
`precios_y_existencias`.`Proveedor`,
`precios_y_existencias`.`Marca`,
`precios_y_existencias`.`UnidadMediMenor`,
`precios_y_existencias`.`UnidadMediMayor`,
`precios_y_existencias`.`FactorMayoreo`,
`precios_y_existencias`.`PrecioUnidad`,
`precios_y_existencias`.`PrecioMayoreo`,
`precios_y_existencias`.`Existencias`
FROM `pedidos`.`precios_y_existencias`";
$rs=new ResultSet($sql);
echo $rs->toJsonArray();

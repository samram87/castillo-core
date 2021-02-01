<?php

$sinSesion=true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';
$jsonRet="[";
$sql="select CODI_ARTI as codigo,NOMB_ARTI as nombre, 
    CODI_CATE_ARTI as categoria, 
    SURT_INST as surtido,
    IFNULL(maout.abre_surt,'') as abrev,
    case SURT_PREE when 'S' then 0 else (select count(*) from pedidos.deta_comb where deta_comb.CODI_ARTI=maout.CODI_ARTI) end as hijos,
    CASE WHEN  (select count(*) from pedidos.deta_comb where deta_comb.CODI_ARTI_COMB=maout.CODI_ARTI)>0 then IF(ISNULL(maout.CODI_ARTI_PADR),0,1) else 0 end as esHijo,
    maout.CODI_ARTI_PADR as padre
    from pedidos.maes_arti maout
    where maout.CODI_ARTI in (Select CODI_ARTI from pedidos.prec_arti_unid)";

$rs=new ResultSet($sql);

while($rs->next()){
    if($rs->getPosicionActual()>1){
        $jsonRet.=",";
    }
    $first=false;
    
    
    
    //Ahora selecciono los prec_arti_unid del producto
    $sqlUOM="select uom.CODI_PREC_UNID as codigo, 
        tipo_medi.CODI_MEDI as uom, 
        tipo_medi.NOMB_MEDI as nombre, 
        ROUND(uom.FACT_CONV,2)  as cnt,
        IFNULL((select limite from pedidos.limite_venta where 
        limite_venta.CODI_ARTI='".$rs->getString("codigo")."'
        and limite_venta.CODI_MEDI=tipo_medi.CODI_MEDI ),-1) as limite
        from pedidos.prec_arti_unid as uom inner join 
        pedidos.tipo_medi on tipo_medi.CODI_MEDI=uom.CODI_MEDI   
        where uom.CODI_ARTI='".$rs->getString("codigo")."' 
        order by tipo_medi.codi_medi";
    $rsUom=new ResultSet($sqlUOM);
    $jsonUOM="[";
    while($rsUom->next()){
        if($rsUom->getPosicionActual()>1){
            $jsonUOM.=",";
        }
        
        
        
        $sqlPrecio="select CORR_ESCA_PREC as codigo, 
            ROUND(CANT_INIC,2) as desde,
            ROUND(CANT_FINA,2) as hasta, 
            ROUND(PRECIO,5) as precio, 
            ROUND(PREC_MINI,5) as precioMinimo, 
            TIPO_PREC as tipo
            from pedidos.esca_prec 
            where CODI_PREC_UNID ='".$rsUom->getString("codigo")."' order by CANT_INIC;";
        $rsPrecio=new ResultSet($sqlPrecio);
        $arrPrecio=$rsPrecio->toJsonArray();
        //Ahora con el precio tienda
        $sqlPrecioTienda="select CORR_ESCA_PREC_TIEN as codigo, 
            ROUND(CANT_INIC,2) as desde,
            ROUND(CANT_FINA,2) as hasta, 
            ROUND(PRECIO,5) as precio, 
            ROUND(PREC_MINI,5) as precioMinimo, 
            TIPO_PREC as tipo
            from pedidos.esca_prec_tien 
            where CODI_PREC_UNID ='".$rsUom->getString("codigo")."' order by CANT_INIC;";
        $rsPrecioTienda=new ResultSet($sqlPrecioTienda);
        $arrPrecioTienda=$rsPrecioTienda->toJsonArray();
        
        
        
        $jsonUOM.="{".$rsUom->toJsonObject(false);
        $jsonUOM.=",\"precios\":".$arrPrecio.",\"preciosTienda\":".$arrPrecioTienda."}";
    }
    $jsonUOM.="]";
    
    $arrPromo="[]";
    
    try {
    $sqlPromo="SELECT enca_prom.CORR_ENCA_PROM, ROUND(enca_prom.CANT_PROD,2) as cnt_requerida,
deta_prom.CODI_ARTI as ARTICULO, deta_prom.CODI_MEDI as CODI_MEDI, ROUND(deta_prom.CANT_PROD,2) as cnt_regalo,
enca_prom.CODI_MEDI as UOM_REQ
FROM pedidos.enca_prom inner join pedidos.deta_prom 
on enca_prom.CORR_ENCA_PROM=deta_prom.CORR_ENCA_PROM
where enca_prom.CODI_ARTI='".$rs->getString("codigo")."'";
    $rsPromo=new ResultSet($sqlPromo);

    $arrPromo=$rsPromo->toJsonArray();
    }catch(Exception $e){
        $arrPromo="[]";
    }
    
    $jsonSurtido="[]";
    if($rs->getInt("hijos")>0){
        $sqlDetaCom="select CODI_ARTI_COMB as codigoProducto, CODI_MEDI as uom, CANT_PROD_COMB as cantidad
            from pedidos.deta_comb where CODI_ARTI='".$rs->getString("codigo")."'";
        $rsSurt=new ResultSet($sqlDetaCom);
        $jsonSurtido=$rsSurt->toJsonArray();
    }
    
    
    $jsonRet.="{".$rs->toJsonObject(false).",\"uom\":".$jsonUOM.",\"surtido\":".$jsonSurtido.",\"promos\":".$arrPromo."}";
    
}
$jsonRet.="]";

echo $jsonRet;
  

/*
select * from pedidos.prec_arti_unid  where CODI_ARTI='1.1007' order by codi_arti, codi_medi;

select * from pedidos.esca_prec where CODI_PREC_UNID in ('0000002414','0000002413') order by CODI_PREC_UNID;

 */

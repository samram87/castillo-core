<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function obtenerConversion($codi_prod,$uni_medi){
    
    $sqlUOM="select uom.CODI_PREC_UNID as codigo, 
        tipo_medi.CODI_MEDI as uom, 
        tipo_medi.NOMB_MEDI as nombre, 
        ROUND(uom.FACT_CONV,2)  as cnt 
        from pedidos.prec_arti_unid as uom inner join 
        pedidos.tipo_medi on tipo_medi.CODI_MEDI=uom.CODI_MEDI   
        where uom.CODI_ARTI='".$codi_prod."' 
        order by tipo_medi.codi_medi";
}
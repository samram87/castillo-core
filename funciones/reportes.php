<?php
/* 
 * funciones utiles para los reportes...
 */

function imprimirListadoDeReportes(){
   
$rsRep=new ResultSet("SELECT
    reportes.idReporte
    , reportes.titulo
FROM
    reportes
    INNER JOIN reportesporperfiles
        ON (reportes.idReporte = reportesporperfiles.idReporte)
    INNER JOIN usuariosporperfiles
        ON (usuariosporperfiles.idPerfil = reportesporperfiles.idPerfil)
WHERE (usuariosporperfiles.idUsuario ={CodigoUsuario})");
    
    $listadoDeReportes=array();
    while ($rsRep->next()){
        $listadoDeReportes[$rsRep->getString("idReporte")]=$rsRep->getString("titulo");
    }

    Campos::selectAPartirDeArray("idReporte", $listadoDeReportes,'',"style='max-width:300px;min-width:300px;width:300px;'");
}

?>
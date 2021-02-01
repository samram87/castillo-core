<?php
include_once 'entidades/Detallesmantenimientosdetablas.class.php';
include_once 'entidades/Mantenimientosdetablas.class.php';
//include_once 'FuncionesFiltro.php';
/**
 * Clase que guarda los datos de un mantenimiento de tabla en un
 *
 * @author samuel
 */
$con=new Conexion();
$mantenimiento=new Mantenimientosdetablas();
$idMantenimiento=0;
if(isset($_REQUEST["idMantenimientoDeTabla"])) {
    $idMantenimiento=$_REQUEST["idMantenimientoDeTabla"];
    $mantenimiento=obtenerMantenimiento($_REQUEST["idMantenimientoDeTabla"]);
}else {
    die('No se ha enviado el parámetro idMantenimiento.
        <br>Necesario para generar el mantenimiento de tabla.');
}

function obtenerMantenimiento($idMantenimiento) {
    $idUsuario=$_SESSION["idUsuario"];
    $mantenimiento=new Mantenimientosdetablas();
    $queryMantenimientos="SELECT mantenimientosdetablas.idMantenimientoDeTabla,
       mantenimientosdetablas.NombreTabla,
       mantenimientosdetablas.TituloTabla,
       mantenimientosdetablas.idSuperiorMantenimientoDeTabla,
       mantenimientosdetablas.NumeroDeColumnasMostradas,
       mantenimientosdetablas.NivelTabla,
       mantenimientosdetablas.TipoDeDespliegue,
       mantenimientosdetablas.RutaDespliegue,
       mantenimientosdetablas.RutaCaptura,
       mantenimientosdetablas.RutaInsert,
       mantenimientosdetablas.RutaActualizacion,
       mantenimientosdetablas.RutaUpdate,
       mantenimientosdetablas.RutaRetorno,
       mantenimientosdetablas.TipoDeRetorno,
       mantenimientosdetablas.ConfirmaEliminacion,
       mantenimientosdetablas.RequerirAuditoria,
       mantenimientosdetablas.DescripcionDeTabla,
       mantenimientosdetablas.NumeroDeRegistrosPorPantalla,
       mantenimientosdetablas.TipoDespliegueDependecias,
       mantenimientosdetablas.JavascriptDeEjecucionGlobal,
       mantenimientosdetablas.FiltroGeneralDeLaTabla,
       mantenimientosdetablas.NombreClaseValidacion,
       mantenimientosdetablas.numeroDeColumnas,
       permisoInsertDeUsuario($idUsuario,mantenimientosdetablas.idMantenimientoDeTabla,{idPerfil}) as permisoInsert,
       permisoUpdateDeUsuario($idUsuario,mantenimientosdetablas.idMantenimientoDeTabla,{idPerfil}) as permisoUpdate,
       permisoDeleteDeUsuario($idUsuario,mantenimientosdetablas.idMantenimientoDeTabla,{idPerfil}) as permisoDelete
    FROM mantenimientosdetablas mantenimientosdetablas
    WHERE (mantenimientosdetablas.idMantenimientoDeTabla ='$idMantenimiento')";
    //error_log("Query MTO: ".$queryMantenimientos );
    $resultset=new ResultSet($queryMantenimientos);
    if($resultset->next()) {
        $mantenimiento->setIdMantenimientoDeTabla($resultset->getString("idMantenimientoDeTabla"));
        $mantenimiento->setNombreTabla($resultset->getString("NombreTabla"));
        $mantenimiento->setTituloTabla($resultset->getString("TituloTabla"));
        $mantenimiento->setIdSuperiorMantenimientoDeTabla($resultset->getString("idSuperiorMantenimientoDeTabla"));
        $mantenimiento->setNumeroDeColumnasMostradas($resultset->getInt("NumeroDeColumnasMostradas"));
        $mantenimiento->setNivelTabla($resultset->getInt("NivelTabla"));
        $mantenimiento->setTipoDeDespliegue($resultset->getString("TipoDeDespliegue"));
        $mantenimiento->setRutaDespliegue($resultset->getString("RutaDespliegue"));
        $mantenimiento->setRutaCaptura($resultset->getString("RutaCaptura"));
        $mantenimiento->setRutaInsert($resultset->getString("RutaInsert"));
        $mantenimiento->setRutaUpdate($resultset->getString("RutaUpdate"));
        $mantenimiento->setRutaActualizacion($resultset->getString("RutaActualizacion"));
        $mantenimiento->setRutaRetorno($resultset->getString("RutaRetorno"));
        $mantenimiento->setTipoDeRetorno($resultset->getString("TipoDeRetorno"));
        $mantenimiento->setConfirmaEliminacion($resultset->getBoolean("ConfirmaEliminacion"));
        $mantenimiento->setRequerirAuditoria($resultset->getString("RequerirAuditoria"));
        $mantenimiento->setDescripcionDeTabla($resultset->getString("DescripcionDeTabla"));
        $mantenimiento->setNumeroDeRegistrosPorPantalla($resultset->getString("NumeroDeRegistrosPorPantalla"));
        $mantenimiento->setTipoDespliegueDependecias($resultset->getString("TipoDespliegueDependecias"));
        $mantenimiento->setJavascriptDeEjecucionGlobal($resultset->getString("JavascriptDeEjecucionGlobal"));
        $mantenimiento->setFiltroGeneralDeLaTabla($resultset->getString("FiltroGeneralDeLaTabla"));
        $mantenimiento->setNombreClaseValidacion($resultset->getString("NombreClaseValidacion"));
        $mantenimiento->setNumeroDeColumnas($resultset->getString("numeroDeColumnas"));
        $mantenimiento->setPermisoInsert($resultset->getBoolean("permisoInsert"));
        $mantenimiento->setPermisoUpdate($resultset->getBoolean("permisoUpdate"));
        $mantenimiento->setPermisoDelete($resultset->getBoolean("permisoDelete"));
        

        //AHORA CARGO LOS DETALLES Normales...
        $queryDetalles="SELECT detallesmantenimientosdetablas.idDetallleMantenimientoTabla,
            detallesmantenimientosdetablas.idMantenimientoDeTabla,
            detallesmantenimientosdetablas.idCampo,
            detallesmantenimientosdetablas.nombreCampo,
            detallesmantenimientosdetablas.accionCampo,
            detallesmantenimientosdetablas.claseCampo,
            detallesmantenimientosdetablas.idTipoCampo,
            detallesmantenimientosdetablas.tamanoCampo,
            detallesmantenimientosdetablas.tamanoMaximoCampo,
            detallesmantenimientosdetablas.nulidadCampo,
            detallesmantenimientosdetablas.descripcionCampo,
            detallesmantenimientosdetablas.admiteDefault,
            detallesmantenimientosdetablas.valorDefault,
            detallesmantenimientosdetablas.desplegarCampo,
            detallesmantenimientosdetablas.ordenDespliegue,
            detallesmantenimientosdetablas.autoincremento,
            detallesmantenimientosdetablas.ordenFila,
            detallesmantenimientosdetablas.ordenColumna,
            detallesmantenimientosdetablas.javascriptDesdeCampo,
            detallesmantenimientosdetablas.formatoFecha,
            detallesmantenimientosdetablas.restriccionDeFechas,
            detallesmantenimientosdetablas.altoCampo,
            detallesmantenimientosdetablas.tipoCapturaExtranjera,
            detallesmantenimientosdetablas.idMantenimientoDeTablaExtranjera,
            detallesmantenimientosdetablas.queryFiltro,
            detallesmantenimientosdetablas.nombreDeTablaMuchosAMuchos,
            detallesmantenimientosdetablas.rutaDeArchivo,
            detallesmantenimientosdetablas.idCampoNombreArchivo,
            detallesmantenimientosdetablas.mostrarSoloEnModificacion,
            detallesmantenimientosdetablas.catalogo_id
        FROM detallesmantenimientosdetablas detallesmantenimientosdetablas
        WHERE (detallesmantenimientosdetablas.idMantenimientoDeTabla ='$idMantenimiento')";
        //error_log("Query Detalles: ".$queryDetalles );
        $detalles=array();
        $resultado=new ResultSet($queryDetalles);
        while($resultado->next()) {
            $detalle=new Detallesmantenimientosdetablas();
            $detalle->setIdDetallleMantenimientoTabla($resultado->getString("idDetallleMantenimientoTabla"));
            $detalle->setIdMantenimientoDeTabla($resultado->getString("idMantenimientoDeTabla"));
            $detalle->setIdCampo($resultado->getString("idCampo"));
            if($resultado->getString("idCampo")=='idMantenimientoDeTabla'){
                $detalle->setIdCampo("IDMANTENIMIENTODETABLA");
            }
            $detalle->setNombreCampo($resultado->getString("nombreCampo"));
            $detalle->setAccionCampo($resultado->getString("accionCampo"));
            $detalle->setClaseCampo($resultado->getString("claseCampo"));
            $detalle->setIdTipoCampo($resultado->getString("idTipoCampo"));
            $detalle->setTamanoCampo($resultado->getString("tamanoCampo"));
            $detalle->setTamanoMaximoCampo($resultado->getString("tamanoMaximoCampo"));
            $detalle->setNulidadCampo($resultado->getString("nulidadCampo"));
            $detalle->setDescripcionCampo($resultado->getString("descripcionCampo"));
            $detalle->setAdmiteDefault($resultado->getString("admiteDefault"));
            $detalle->setValorDefault($resultado->getString("valorDefault"));
            $detalle->setDesplegarCampo($resultado->getString("desplegarCampo"));
            $detalle->setOrdenDespliegue($resultado->getString("ordenDespliegue"));
            $detalle->setAutoincremento($resultado->getString("autoincremento"));
            $detalle->setOrdenFila($resultado->getString("ordenFila"));
            $detalle->setOrdenColumna($resultado->getString("ordenColumna"));
            $detalle->setJavascriptDesdeCampo($resultado->getString("javascriptDesdeCampo"));
            $detalle->setFormatoFecha($resultado->getString("formatoFecha"));
            $detalle->setRestriccionDeFechas($resultado->getString("restriccionDeFechas"));
            $detalle->setAltoCampo($resultado->getString("altoCampo"));
            $detalle->setTipoCapturaExtranjera($resultado->getString("tipoCapturaExtranjera"));
            $detalle->setIdMantenimientoDeTablaExtranjera($resultado->getString("idMantenimientoDeTablaExtranjera"));
            $detalle->setQueryFiltro($resultado->getString("queryFiltro"));
            $detalle->setNombreDeTablaMuchosAMuchos($resultado->getString("nombreDeTablaMuchosAMuchos"));
            $detalle->setRutaDeArchivo($resultado->getString("rutaDeArchivo"));
            $detalle->setIdCampoNombreArchivo($resultado->getString("idCampoNombreArchivo"));
            $detalle->setMostrarSoloEnActualizacion($resultado->getBoolean("mostrarSoloEnModificacion"));
            $detalle->setCatalogoId($resultado->getString("catalogo_id"));
            $detalles[]=$detalle;
        }
        $mantenimiento->setDetalles($detalles);



        //Ahora cargo los detalles ordenados por despliegue
        $detalles=array();
        $resultado=new ResultSet($queryDetalles."  ORDER BY desplegarCampo desc, ordenDespliegue ");
        while($resultado->next()) {
            $detalle=new Detallesmantenimientosdetablas();
            $detalle->setIdDetallleMantenimientoTabla($resultado->getString("idDetallleMantenimientoTabla"));
            $detalle->setIdMantenimientoDeTabla($resultado->getString("idMantenimientoDeTabla"));
            $detalle->setIdCampo($resultado->getString("idCampo"));
            if($resultado->getString("idCampo")=='idMantenimientoDeTabla'){
                $detalle->setIdCampo("IDMANTENIMIENTODETABLA");
            }
            $detalle->setNombreCampo($resultado->getString("nombreCampo"));
            $detalle->setAccionCampo($resultado->getString("accionCampo"));
            $detalle->setClaseCampo($resultado->getString("claseCampo"));
            $detalle->setIdTipoCampo($resultado->getString("idTipoCampo"));
            $detalle->setTamanoCampo($resultado->getString("tamanoCampo"));
            $detalle->setTamanoMaximoCampo($resultado->getString("tamanoMaximoCampo"));
            $detalle->setNulidadCampo($resultado->getString("nulidadCampo"));
            $detalle->setDescripcionCampo($resultado->getString("descripcionCampo"));
            $detalle->setAdmiteDefault($resultado->getString("admiteDefault"));
            $detalle->setValorDefault($resultado->getString("valorDefault"));
            $detalle->setDesplegarCampo($resultado->getString("desplegarCampo"));
            $detalle->setOrdenDespliegue($resultado->getString("ordenDespliegue"));
            $detalle->setAutoincremento($resultado->getString("autoincremento"));
            $detalle->setOrdenFila($resultado->getString("ordenFila"));
            $detalle->setOrdenColumna($resultado->getString("ordenColumna"));
            $detalle->setJavascriptDesdeCampo($resultado->getString("javascriptDesdeCampo"));
            $detalle->setFormatoFecha($resultado->getString("formatoFecha"));
            $detalle->setRestriccionDeFechas($resultado->getString("restriccionDeFechas"));
            $detalle->setAltoCampo($resultado->getString("altoCampo"));
            $detalle->setTipoCapturaExtranjera($resultado->getString("tipoCapturaExtranjera"));
            $detalle->setIdMantenimientoDeTablaExtranjera($resultado->getString("idMantenimientoDeTablaExtranjera"));
            $detalle->setQueryFiltro($resultado->getString("queryFiltro"));
            $detalle->setNombreDeTablaMuchosAMuchos($resultado->getString("nombreDeTablaMuchosAMuchos"));
            $detalle->setRutaDeArchivo($resultado->getString("rutaDeArchivo"));
            $detalle->setIdCampoNombreArchivo($resultado->getString("idCampoNombreArchivo"));
            $detalle->setMostrarSoloEnActualizacion($resultado->getBoolean("mostrarSoloEnModificacion"));
            $detalle->setCatalogoId($resultado->getString("catalogo_id"));
            $detalles[]=$detalle;
        }
        $mantenimiento->setDetallesOrdenadosPorDespliegue($detalles);



        //Ahora cargo los detalles ordenados por captura
        $detalles=array();
        $resultado=new ResultSet($queryDetalles." and idTipoCampo not in ( '30') ORDER BY ordenFila ");
        while($resultado->next()) {
            $detalle=new Detallesmantenimientosdetablas();
            $detalle->setIdDetallleMantenimientoTabla($resultado->getString("idDetallleMantenimientoTabla"));
            $detalle->setIdMantenimientoDeTabla($resultado->getString("idMantenimientoDeTabla"));
            $detalle->setIdCampo($resultado->getString("idCampo"));
            if($resultado->getString("idCampo")=='idMantenimientoDeTabla'){
                $detalle->setIdCampo("IDMANTENIMIENTODETABLA");
            }
            $detalle->setNombreCampo($resultado->getString("nombreCampo"));
            $detalle->setAccionCampo($resultado->getString("accionCampo"));
            $detalle->setClaseCampo($resultado->getString("claseCampo"));
            $detalle->setIdTipoCampo($resultado->getString("idTipoCampo"));
            $detalle->setTamanoCampo($resultado->getString("tamanoCampo"));
            $detalle->setTamanoMaximoCampo($resultado->getString("tamanoMaximoCampo"));
            $detalle->setNulidadCampo($resultado->getString("nulidadCampo"));
            $detalle->setDescripcionCampo($resultado->getString("descripcionCampo"));
            $detalle->setAdmiteDefault($resultado->getString("admiteDefault"));
            $detalle->setValorDefault($resultado->getString("valorDefault"));
            $detalle->setDesplegarCampo($resultado->getString("desplegarCampo"));
            $detalle->setOrdenDespliegue($resultado->getString("ordenDespliegue"));
            $detalle->setAutoincremento($resultado->getString("autoincremento"));
            $detalle->setOrdenFila($resultado->getString("ordenFila"));
            $detalle->setOrdenColumna($resultado->getString("ordenColumna"));
            $detalle->setJavascriptDesdeCampo($resultado->getString("javascriptDesdeCampo"));
            $detalle->setFormatoFecha($resultado->getString("formatoFecha"));
            $detalle->setRestriccionDeFechas($resultado->getString("restriccionDeFechas"));
            $detalle->setAltoCampo($resultado->getString("altoCampo"));
            $detalle->setTipoCapturaExtranjera($resultado->getString("tipoCapturaExtranjera"));
            $detalle->setIdMantenimientoDeTablaExtranjera($resultado->getString("idMantenimientoDeTablaExtranjera"));
            $detalle->setQueryFiltro($resultado->getString("queryFiltro"));
            $detalle->setNombreDeTablaMuchosAMuchos($resultado->getString("nombreDeTablaMuchosAMuchos"));
            $detalle->setRutaDeArchivo($resultado->getString("rutaDeArchivo"));
            $detalle->setIdCampoNombreArchivo($resultado->getString("idCampoNombreArchivo"));
            $detalle->setMostrarSoloEnActualizacion($resultado->getBoolean("mostrarSoloEnModificacion"));
            $detalle->setCatalogoId($resultado->getString("catalogo_id"));
            $detalles[]=$detalle;
        }
        $mantenimiento->setDetallesOrdenadosPorCaptura($detalles);

    }
    return $mantenimiento;
}

function obtenerCantidadMantenimientosHijos($idMantenimiento){
 $sel="SELECT COUNT(*) FROM MantenimientosDeTablas WHERE MantenimientosDeTablas.idSuperiorMantenimientoDeTabla='$idMantenimiento'";
 $rs=new ResultSet($sel);
 if($rs->next()){
     return $rs->getInt(0);
 }else{
    return 0;
 }
}

/*
 * Devuelve segun el mantenimiento enviado el valor
 * VERDADERO o FALSO segun sea hijo de algun mantenimiento.
 */
function esHijo($idMantenimientoReq){
    $sel ="select ifnull(MantenimientosDeTablas.idSuperiorMantenimientoDeTabla,0)
        from MantenimientosDeTablas
        where MantenimientosDeTablas.idMantenimientoDeTabla='$idMantenimientoReq'";
    $rs=new ResultSet($sel);
    if($rs->next()){
        if($rs->getString(0)=='0'){
            return false;
        }else if($rs->getString(0)==''){
            return false;
        }else{
            return true;
        }
    }else{
        return false;
    }
}

function obtenerIdMantenimientoPadre($idMantenimiento){
    $sel ="select ifnull(MantenimientosDeTablas.idSuperiorMantenimientoDeTabla,0)
        from MantenimientosDeTablas
        where MantenimientosDeTablas.idMantenimientoDeTabla='$idMantenimiento'";
    $rs=new ResultSet($sel);
    if($rs->next()){
        return $rs->getString(0);
    }else{
        return 0;
    }
}
/*
 * Devuelve el valor verdadero falso segun el mantenimiento posea hijos.
 */

function esPadre($idMantenimiento){
    $cantHijos=obtenerCantidadMantenimientosHijos($idMantenimiento);
    if($cantHijos>0){
        return true;
    }else{
        return false;
    }
}

function imprimirTabsHijosLista($idMantenimiento,$habilitar=true){
    if(esHijo($idMantenimiento)){
        //Es Hijo asi que tengo q obtener el titulo y la llave de su padre.
        $idMantenimientoPadre=obtenerIdMantenimientoPadre($idMantenimiento);
        $sel="SELECT TituloTabla, obtenerNombreLlaveMantenimiento(idmantenimientodeTabla)
        FROM MantenimientosDeTablas WHERE idMantenimiento='$idMantenimientoPadre'";
        $rs=new ResultSet($sel);
        if($rs->next()){
            //Si continuo es por que tengo datos.
            $TituloPadre=$rs->getString(0);
            $nombreLlave=$rs->getString(1);
            //Obtengo el valor del campo padre.
            $valorPadre=$_REQUEST[$nombreLlave];
            //Ahora obtengo todos los mantenimientos hijos.
            $select="SELECT
                    idMantenimientoDeTabla
                    , TituloTabla
                    , idSuperiorMantenimientoDeTabla
                    FROM
                    MantenimientosDeTablas
                    WHERE (idSuperiorMantenimientoDeTabla ='$idMantenimientoPadre')
                    ORDER BY OrdenDespliegueDetalle ASC";
           $res=new ResultSet($select);
        }
    }
}

function imprimirTabs($idMantenimientoSolicitado,$nivel=0){
    $idMantenimientoPadre=0;
    if(esPadre($idMantenimientoSolicitado)){
        $idMantenimientoPadre=$idMantenimientoSolicitado;
    }else if(esHijo($idMantenimientoSolicitado)){
        $idMantenimientoPadre=obtenerIdMantenimientoPadre($idMantenimientoSolicitado);
    }else{
        return false;
    }
    $mantenimientoPadre=obtenerMantenimiento($idMantenimientoPadre);
    $detalles=obtenerCamposLlave($mantenimientoPadre);
    $detalle=new Detallesmantenimientosdetablas();
    $detalle=$detalles[0];
    $nombreLlave=$detalle->getIdCampo();
    $valorLlave=$_REQUEST[$nombreLlave];
    $query="
SELECT     idMantenimientoDeTabla, TituloTabla ,RutaActualizacion as RutaDespliegue, 0 as OrdenDespliegueDetalle
FROM mantenimientosdetablas
WHERE (mantenimientosdetablas.idMantenimientoDeTabla = '$idMantenimientoPadre')
union
SELECT idMantenimientoDeTabla, TituloTabla, RutaDespliegue, if(ifnull(OrdenDespliegueDetalle,1)='',1,ifnull(OrdenDespliegueDetalle,1)) as OrdenDespliegueDetalle
FROM
mantenimientosdetablas  
WHERE (mantenimientosdetablas.idSuperiorMantenimientoDeTabla = '$idMantenimientoPadre') order by OrdenDespliegueDetalle,TituloTabla  ";
    $rs=new ResultSet($query);
    Campos::inicioTabs();
    $primeraVez=true;
    while($rs->next()){
        $idActual=$rs->getString("idMantenimientoDeTabla");
        $texto=$rs->getString("TituloTabla");
        $rutaDespliegue=$rs->getString("RutaDespliegue");
        $seleccionado=false;
        if($idMantenimientoSolicitado==$idActual){
            $seleccionado=true;
        }
        $url="";
        if($primeraVez==true){
            if($idActual=='EMP001'){
                $url="/core/planilla/modificarEmp.php?$nombreLlave=$valorLlave&id=$valorLlave";
            }else{
                if($rutaDespliegue==''){
                    $url="/core/mantenimiento/actualizacionDeTabla.php?idMantenimientoDeTabla=$idActual&$nombreLlave=$valorLlave";
                }else{
                    if(strpos($rutaDespliegue,'?')===false){
                        $url=$rutaDespliegue."?idMantenimientoDeTabla=$idActual&$nombreLlave=$valorLlave";
                    }else{
                        $url=$rutaDespliegue."&idMantenimientoDeTabla=$idActual&$nombreLlave=$valorLlave";
                    }
                }
            }
            $primeraVez=false;
        }else{
            if($rutaDespliegue==''){
                $url="/core/mantenimiento/listadoDeTabla.php?idMantenimientoDeTabla=$idActual&$nombreLlave=$valorLlave";
            }else{
                $url=$rutaDespliegue."?idMantenimientoDeTabla=$idActual&$nombreLlave=$valorLlave";
            }
        }
        Campos::tab($texto, "#",$seleccionado,"onclick=\"cargarContenido('$url')\"");
    }
    Campos::finTabs();
}





function obtenerCamposLlave(Mantenimientosdetablas $mantenimiento) {
    $detalleLlave=[];
    $detalles=$mantenimiento->getDetalles();
    for($i=0;$i<$mantenimiento->getCantidadDetalles();$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        if(trim(strtoupper($detalle->getClaseCampo()))=='P') {
            $detalleLlave[]=$detalle;
        }
    }
    return $detalleLlave;
}

function obtenerCamposMaestro(Mantenimientosdetablas $mantenimiento) {
    $detalleLlave=[];
    $detalles=$mantenimiento->getDetalles();
    for($i=0;$i<$mantenimiento->getCantidadDetalles();$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];

        if(trim(strtoupper($detalle->getClaseCampo()))=='M') {
            $detalleLlave[]=$detalle;
        }
    }
    return $detalleLlave;
}

function obtenerCamposDesplegados(Mantenimientosdetablas $mantenimiento,$incluirLlaves=true) {
    $detalleCampos;
    $detalles=$mantenimiento->getDetallesOrdenadosPorDespliegue();
    $columnasDesplegadas=$mantenimiento->getNumeroDeColumnasMostradas();
    $contador=0;
    for($i=0;$i<$mantenimiento->getCantidadDetalles();$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        if($detalle->getDesplegarCampo()=='1') {
            if(($incluirLlaves===true)||(($incluirLlaves==false)&&($detalle->getClaseCampo()!='P'))){
                $detalleCampos[]=$detalle;
                $contador++;
                if($contador==$columnasDesplegadas){
                    return $detalleCampos;
                }
            }
        }
    }
    return $detalleCampos;
}

function obtenerCantidadLlaves($mantenimiento) {
    return count(obtenerCamposLlave($mantenimiento));
}

function obtenerSelectCamposDespliegue(Mantenimientosdetablas $mantenimiento,$limit=true) {
    $sqlCampos="select ";
//Primero selecciono los campos llaves.
    $llaves=obtenerCamposLlave($mantenimiento);
    $cantidadLlaves=count($llaves);
    $primeraVez=true;
    $detalles=$mantenimiento->getDetallesOrdenadosPorDespliegue();

    for($i=0;$i<$cantidadLlaves;$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$llaves[$i];
        if($primeraVez) {
            $sqlCampos.=$detalle->getIdCampo().' as Llave'.$i.' ';
            $primeraVez=false;
        }else {
            $sqlCampos.=','.$detalle->getIdCampo().' as Llave'.$i.' ';
        }
    }
    $detalles=obtenerCamposDesplegados($mantenimiento,true);
//Ahora selecciono los demas campos que no son llave...
    for($i=0;$i<count($detalles);$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        if($detalle->getDesplegarCampo()=='1') {
            if($primeraVez) {
                if($detalle->getIdTipoCampo()=='9' || $detalle->getIdTipoCampo() =='25'){ // && $detalle->getQueryFiltro()==''
                     //Si el tipo de campo es extranjera pues obtengo hago un subselect.
                    $nombreCampo=$mantenimiento->getNombreTabla().".".$detalle->getIdCampo();
                    $sqlCampos.=obtenerSubSelectLlaveExtranjera($nombreCampo, $detalle);
                }else if($detalle->getIdTipoCampo()=='21'){
                    //Es persona
                    $sqlCampos.='nombrePersona('.$detalle->getIdCampo().") as ".$detalle->getIdCampo()." ";
                }else if($detalle->getIdTipoCampo()=='29'){
                    //Es Catalogo_Id
                    $sqlCampos.=" (SELECT descripcion FROM catalago_opciones  where codigo = ".$mantenimiento->getNombreTabla().".".$detalle->getIdCampo()." and catalogo_id = '".$detalle->getCatalogoId()."' ) as ".$detalle->getIdCampo()." ";
                }else if($detalle->getIdTipoCampo()=='30'){
                    //Es Columna Calculada
                    if($detalle->getQueryFiltro()==''){
                        $sqlCampos.=" '' as ".$detalle->getIdCampo()." ";
                    }else{
                        $sqlCalculado=$detalle->getQueryFiltro();

                        $sqlCampos.=" ( ".$sqlCalculado." ) as ".$detalle->getIdCampo()." ";
                    }
                    
                }else{
                    $sqlCampos.=$detalle->getIdCampo();
                }
                
                $primeraVez=false;
            }else {
                //Si el tipo de campo es extranjera pues obtengo hago un subselect.
                if($detalle->getIdTipoCampo()=='9' || $detalle->getIdTipoCampo() =='25' ){//&& $detalle->getQueryFiltro()==''
                    
                    $nombreCampo=$mantenimiento->getNombreTabla().".".$detalle->getIdCampo();
                    
                    $sqlCampos.=','.obtenerSubSelectLlaveExtranjera($nombreCampo, $detalle);
                    //echo $nombreCampo.'<br>';
                }else if($detalle->getIdTipoCampo()=='21'){
                    //Es persona
                    $sqlCampos.=', nombrePersona('.$detalle->getIdCampo().") as ".$detalle->getIdCampo()." ";
                }else if($detalle->getIdTipoCampo()=='29'){
                    //Es Catalogo_Id
                    $sqlCampos.=", (SELECT descripcion FROM catalago_opciones  where codigo = ".$mantenimiento->getNombreTabla().".".$detalle->getIdCampo()." and catalogo_id = '".$detalle->getCatalogoId()."' ) as ".$detalle->getIdCampo()." ";
                }else if($detalle->getIdTipoCampo()=='30'){
                    //Es Columna Calculada
                    if($detalle->getQueryFiltro()==''){
                        $sqlCampos.=", '' as ".$detalle->getIdCampo()." ";
                    }else{
                        $sqlCalculado=$detalle->getQueryFiltro();

                        $sqlCampos.=", ( ".$sqlCalculado." ) as ".$detalle->getIdCampo()." ";
                    }
                    
                }else{
                    $sqlCampos.=','.$detalle->getIdCampo();
                }
            }
        }
    }
    $sqlCampos.=" from ".$mantenimiento->getNombreTabla()." ";
    $conWhere=false;
    if($mantenimiento->getFiltroGeneralDeLaTabla()!='') {
        //El mantenimiento tiene filtro debo agregarselo.
        $filtro=reemplazarValores($mantenimiento->getFiltroGeneralDeLaTabla());
        $sqlCampos.=" where ".$filtro." ";
        $conWhere=true;
    }
    $idM=$mantenimiento->getIdMantenimientoDeTabla();
    if(isset($_SESSION["filtroMantenimiento_".$idM])){
        if($conWhere==true){
            $sqlCampos.=" AND ".$_SESSION["filtroMantenimiento_".$idM]." ";
        }else{
            $sqlCampos.=" where ".$_SESSION["filtroMantenimiento_".$idM]." ";
        }
        $conWhere=true;
    }

    if($mantenimiento->getNivelTabla()>1){
        $llaves=obtenerCamposMaestro($mantenimiento);
        $maestro=$llaves[0];
        $nombreM=$maestro->getIdCampo();
        $valor=$_REQUEST[$nombreM];
        if($conWhere==true){
            $sqlCampos.=" and $nombreM='$valor' ";
        }else{
            $sqlCampos.=" where $nombreM='$valor' ";
        }
    }
        //En este momento agrego el select como un subquery.
        //$sqlCampos=" select * from ($sqlCampos) as TablaExtra ";
//Empiezo a colocar los filtros.
        $idMantenimiento=$mantenimiento->getIdMantenimientoDeTabla();
        if(isset($_SESSION["filtro".$idMantenimiento])){
            
            $ar=$_SESSION["filtro".$idMantenimiento];
            //print_r($ar);
            if(count($ar)>0) {
                /*if($mantenimiento->getFiltroGeneralDeLaTabla()=='') {
                    $sqlCampos.=" where ";
                }else {
                    $sqlCampos.=" and ";
                }*/

                $sqlCampos="select * from (".$sqlCampos.") as tb where ";
                
                for($i=0;$i<count($ar);$i++) {
                    $arr=$ar[$i];
                    if($i>0){
                        $sqlCampos.=" and ";
                    }
                    $sqlCampos.=$arr[0];
                }

            }

        }

//Ahora pregunto si viene ordenado.
    if(isset($_REQUEST["orden"])) {
        $sqlCampos.=" ORDER BY ".$_REQUEST["orden"]." ";
        if(isset($_REQUEST["tipoOrden"])) {
            $sqlCampos.=$_REQUEST["tipoOrden"];
        }
    }
//Por ultimo obtengo el limit.
//    if($limit===true){
//        //No colocar el limit sirve en los casos en los que tenga q calcular el total de los registros.
//        $numeroPPantalla=$mantenimiento->getNumeroDeRegistrosPorPantalla();
//        $pagina=1;
//        $valorInicial=0;
//        if(isset($_REQUEST["p"])){
//            //si la pagina esta puesta hago el calculo.
//            $pagina=$_REQUEST["p"];
//            $valorInicial=($pagina*$numeroPPantalla)-($numeroPPantalla);
//        }
//        $sqlCampos.=" Limit $valorInicial,$numeroPPantalla ";
//    }
    return $sqlCampos;
}

function contiene($array,$id) {
    if(is_array($array)){
        for($i=0;$i<count($array);$i++) {
            if($id==$array[$i]) {
                return true;
            }
        }
    }
    return false;
}

function obtenerVariablesRequest($variablesNoIncluidas) {
    $variables="";

    $llaves=array_keys($_POST);
    for($i=0;$i<count($_POST);$i++) {

        $id=$llaves[$i];
        if(!contiene($variablesNoIncluidas,$id)) {
            $value=$_POST[$id];
            $variables.="&".$id."=".$value;
        }
    }

    //Reemplazo algun valor que venga por get.
    $llaves=array_keys($_GET);
    for($i=0;$i<count($_GET);$i++) {
        $id=$llaves[$i];
        if(!contiene($variablesNoIncluidas,$id)) {
            $value=$_GET[$id];
            $variables.="&".$id."=".$value;
        }
    }
    return $variables;
}

function imprimirEncabezadosDespliegue(Mantenimientosdetablas $mantenimiento) {
    $camposDesplegados=obtenerCamposDesplegados($mantenimiento);

    for($i=0;$i<count($camposDesplegados);$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$camposDesplegados[$i];
        $nombreCampo=$detalle->getIdCampo();
        $tituloCampo=$detalle->getNombreCampo();
        Campos::columna($tituloCampo);
    }
}


function imprimirCamposDespliegue(Mantenimientosdetablas $mantenimiento){
    $query= obtenerSelectCamposDespliegue($mantenimiento);
    $camposDespliegue=obtenerCamposDesplegados($mantenimiento);
    $urlBase=obtenerVariablesRequest("");
    $rutaCaptura='/core/mantenimiento/actualizacionDeTabla.php?'.$urlBase;
    $llaves=obtenerCamposLlave($mantenimiento);
    $nombre=$llaves[0]->getIdCampo();
    $rutaCaptura.="&".$nombre."=";
    $rs=new ResultSet($query);
    
    $cantidadLlaves=obtenerCantidadLlaves($mantenimiento);
    $cantidadCampos=count($camposDespliegue);
    $ancho=100/$cantidadCampos;
    while($rs->next()){
        
        //Primero Obtengo los campos llave para generar la tabla...
        $llave=obtenerValorLlave($mantenimiento, $rs);
        $auxRuta=$rutaCaptura.$llave;
        //"onclick=\"if(accionBoton==false){cargarContenido('$urlLlave')};accionBoton=false;\"
        Campos::inicioFila(" id='$llave' style='cursor:hand;' ondblclick='cargarContenido(\"$auxRuta\")'");
        for($i=0;$i<count($camposDespliegue);$i++){
            $detalle=$camposDespliegue[$i];
            $valor=obtenerValorCampoDespliegue($detalle, $rs, $i+$cantidadLlaves);
            if($valor==''){
                $valor='&nbsp;';
            }
            Campos::columna($valor);
        }
        Campos::finFila();
    }
}
//Obtiene la url de las llaves...
function obtenerUrlLlaves(Mantenimientosdetablas $mantenimiento,ResultSet $rs){
    $camposLlave=obtenerCamposLlave($mantenimiento);
    $cantidadLLaves=count($camposLlave);
    $url="";
    for($i=0;$i<$cantidadLLaves;$i++){
        $nombre=$camposLlave[$i]->getIdCampo();
        $valor=$rs->getString($i);
        $url="&".$nombre."=".$valor;
    }
    return $url;
}

function obtenerValorLlave(Mantenimientosdetablas $mantenimiento,ResultSet $rs){
    $camposLlave=obtenerCamposLlave($mantenimiento);
    $cantidadLLaves=count($camposLlave);
    $url="";
    for($i=0;$i<$cantidadLLaves;$i++){ 
        $valor=$rs->getString($i);
        $url=$valor;
    }
    return $url;
}

function obtenerValorCampoDespliegue(Detallesmantenimientosdetablas $detalle,ResultSet $rs,$campo,$incluirCentrado=true){
    $tipo=$detalle->getIdTipoCampo();
    if($tipo=='1'){
        //Es una fecha
        return $rs->getDate($campo);
    }else if ($tipo=='2'){
        //Es una fecha hora
        return $rs->getDateTime($campo);
    }else if ($tipo=='3'){
        //Es una hora
        return $rs->getDate($campo,"H:i");
    }else if ($tipo=='5'){
        //Es un numerico Los numericos los centro...
        if($incluirCentrado)
        return "<center>".$rs->getInt($campo)."</center>";
        else
        return $rs->getInt($campo);
    }else if ($tipo=='6'){
        //Es moneda
        if($incluirCentrado)
        return "<center>".$rs->getFloat($campo)."</center>";
        else
        return "$ ".$rs->getFloat($campo);
    }else if ($tipo=='7'){
        //Es una cadena
        return $rs->getString($campo);
    }else if ($tipo=='8'){
        //Es una cadena
        return $rs->getString($campo);
    }else if ($tipo=='9'){
        //Es un campo de llave extranjera
        return $rs->getString($campo);
        if($detalle->getQueryFiltro()==''){
            return $rs->getString($campo);
        }else{
        $mantExtranjero=$detalle->getIdMantenimientoDeTablaExtranjera();
        $mantenimientoExtranjero=obtenerMantenimiento($mantExtranjero);
        $llave=$rs->getString($campo);
        $valor=obtenerValorLlaveExtranjera($llave, $mantenimientoExtranjero);
        return $valor;
        }
    }else if ($tipo=='10' || $tipo=='27'){
        if($rs->getBoolean($campo)===true){
            return "Sí";
        }else{
            return "No";
        }
    }else if ($tipo=='13'){
        if($detalle->getQueryFiltro()==''){
            return $rs->getString($campo);
        }else{
            return $rs->getString($campo);
        
        $mantExtranjero=$detalle->getIdMantenimientoDeTablaExtranjera();
        $mantenimientoExtranjero=obtenerMantenimiento($mantExtranjero);
        $llave=$rs->getString($campo);
        $resLlave13=new ResultSet($detalle->getQueryFiltro()." LIMIT 0");
        $camposRes=$resLlave13->getMetadata();
        $nombreCampRes=$camposRes[0]->name;
        $query=$detalle->getQueryFiltro();
        if(strpos($detalle->getQueryFiltro(),'where')!=false){
            $query.= " and $nombreCampRes = '".$llave."' ";
        }else{
            $query.= " WHERE $nombreCampRes = '".$llave."' ";
        }
        $resLlave13=new ResultSet($query);
        $resLlave13->next();
        return $resLlave13->getString(1);
        //return $valor;
        }
    }else{
        return $rs->getString($campo);
    }
}

function obtenerSubSelectLlaveExtranjera($llave,Detallesmantenimientosdetablas $detalle){
    $mantExtranjero=$detalle->getIdMantenimientoDeTablaExtranjera();
    $mantenimiento=obtenerMantenimiento($mantExtranjero);
    $llaves=obtenerCamposLlave($mantenimiento);
    $detalleLlaveExtranjera=new Detallesmantenimientosdetablas();
    $detalleLlaveExtranjera=$llaves[0];
    //Le envio false para que no incluya las llaves.
    $camposDespliegue=obtenerCamposDesplegados($mantenimiento,false);

    //Comienzo a formar el select.
    $sel= "(select
        TABLA_EXT.".$camposDespliegue[0]->getIdCampo()."
            from
            ".$mantenimiento->getNombreTabla()." as TABLA_EXT
                where TABLA_EXT.".$detalleLlaveExtranjera->getIdCampo()."=".$llave.") as E".$detalle->getIdCampo();
    return $sel;
}

function obtenerSubSelectListaDesplegable($llave,Detallesmantenimientosdetablas $detalle){
    $query=$detalle->getQueryFiltro();
    $placeComa=strpos($query,',');
    $firstPart=substring($query,0,$placeComa-1);
    $secondPart= substring($query,$placeComa);
    $firstPart=
    //Comienzo a formar el select.
    $sel= "(select
        TABLA_EXT.".$camposDespliegue[0]->getIdCampo()."
            from
            ".$mantenimiento->getNombreTabla()." as TABLA_EXT
                where TABLA_EXT.".$detalleLlaveExtranjera->getIdCampo()."=".$llave.") as E".$detalle->getIdCampo();
    return $sel;
}
/**
 * @return una cadena de texto con el substring necesario para obtener el valor del campo cuando es extranjera.
 */
function obtenerValorLlaveExtranjera($CampoLlave,Mantenimientosdetablas $mantenimiento){
    $llaves=obtenerCamposLlave($mantenimiento);
    $detalleLlaveExtranjera=new Detallesmantenimientosdetablas();
    $detalleLlaveExtranjera=$llaves[0];
    //Le envio false para que no incluya las llaves.
    $camposDespliegue=obtenerCamposDesplegados($mantenimiento,false);

    //Comienzo a formar el select.
    $sel= "select
        ".$camposDespliegue[0]->getIdCampo()."
            from
            ".$mantenimiento->getNombreTabla()."
                where ".$detalleLlaveExtranjera->getIdCampo()."='".$llave."'";
    $rs=new ResultSet($sel);
    if($rs->next()){
        return $rs->getString(0);
    }
    return $llave;
}

function    agregarBotones(Mantenimientosdetablas $mantenimiento){
    //El boton del filtro.
    $idMantenimiento=$mantenimiento->getIdMantenimientoDeTabla();
    
    if(isset($_SESSION["retornar_$idMantenimiento"])){
        C::boton("Retornar", "Regresar", "onclick=\"window.location='".$_SESSION["retornar_$idMantenimiento"]."'\"");
        Campos::espaciosEnBlanco(5);
    }
    
    //Campos::boton("Exportar", "Exportar a Excel","onclick=\"window.location=window.location+'&exportarAExcel=1';\"");
    Campos::inicioGrupoBotones("grupoBotonesListado");
    //Campos::botonColor("checkMto", "<i class='fa fa-square-o' aria-hidden='true'></i> &nbsp;", C::$NEGRO);
    //Si existe el permiso para insertar agrego el boton
    if($mantenimiento->getPermisoInsert()===true){

        $url=obtenerVariablesRequest("");

        if($mantenimiento->getRutaCaptura()!=''){
            if(strpos($mantenimiento->getRutaCaptura(),'?')===false){
                $url="?".$url;
            }else{
                $url="&".$url;
            }
            $url=$mantenimiento->getRutaCaptura().$url;
        }else{
            $url="/core/mantenimiento/capturaDeTabla.php?".$url;
        }
        Campos::boton("Agregar", "<i class='fa fa-plus' aria-hidden='true'></i> Nuevo","onclick=\"cargarContenido('$url');\"");
    }else{
        Campos::botonColor("ADD_WRONG","Agregar", "<i class='fa fa-plus' aria-hidden='true'></i> Nuevo",C::$GRIS);
    }
    if($mantenimiento->getPermisoUpdate()===true){

        $url=obtenerVariablesRequest("");

        if($mantenimiento->getRutaCaptura()!=''){
            if(strpos($mantenimiento->getRutaCaptura(),'?')===false){
                $url="?".$url;
            }else{
                $url="&".$url;
            }
            $url=$mantenimiento->getRutaCaptura().$url;
        }else{
            $url="/core/mantenimiento/capturaDeTabla.php?".$url;
        }
        Campos::botonColor("Modificar", "<i class='fa fa-pencil' aria-hidden='true'></i> Modificar", C::$VERDE," disabled='disabled' ");
    }else{
        Campos::botonColor("MOD_WRONG", "<i class='fa fa-pencil' aria-hidden='true'></i> Modificar", C::$GRIS);
    }
    if($mantenimiento->getPermisoDelete()===true){

        $url=obtenerVariablesRequest("");

        if($mantenimiento->getRutaCaptura()!=''){
            if(strpos($mantenimiento->getRutaCaptura(),'?')===false){
                $url="?".$url;
            }else{
                $url="&".$url;
            }
            $url=$mantenimiento->getRutaCaptura().$url;
        }else{
            $url="/core/mantenimiento/capturaDeTabla.php?".$url;
        }
        Campos::botonColor("Eliminar", "<i class='fa fa-trash-o' aria-hidden='true'></i> Eliminar",C::$ROJO,"disabled='disabled' ");
        
    }else{
        Campos::botonColor("DEL_WRONG", "<i class='fa fa-trash-o' aria-hidden='true'></i> Eliminar",C::$GRIS);
        
    }
    //Campos::botonColor("Auditoria", "<i class='fa fa-database' aria-hidden='true'></i> Revisar Auditoria",C::$NARANJA," disabled='disabled' ");
    
    //Campos::botonColor("Exportar", "<i class='fa fa-file-excel-o' aria-hidden='true'></i> Exportar a Excel",C::$VERDE,"onclick=\"cargarContenido('$url');\"");
    
    Campos::finGrupoBotones();
}






/**
 * Comienzo con los procedimientos para filtrar
 */
function obtenerCamposFiltrables(Mantenimientosdetablas $mantenimiento,$incluirLlaves=false) {
    $detalleCampos;
    $detalles=$mantenimiento->getDetalles();
    for($i=0;$i<$mantenimiento->getCantidadDetalles();$i++) {
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        if($detalle->getPermiteFiltro()===true) {
            if(($incluirLlaves===true)||(($incluirLlaves==false)&&($detalle->getClaseCampo()!='P'))) {
                if($detalle->getPermiteFiltro()===true) {
                    $detalleCampos[]=$detalle;
                }
            }
        }
    }
    return $detalleCampos;
}


include_once "CapturaMantenimiento.php";

?>
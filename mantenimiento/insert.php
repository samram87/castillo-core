<?php
/**
 * Esta es una pagina para capturar un nuevo elemento de la tabla.
 */
//error_reporting(E_ALL);
//ini_set("display_errors", 0);
include 'core/clases/include.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/core/clases/Mantenimiento.php';
$mantenimientos=new Mantenimientosdetablas();
$mantenimientos=$mantenimiento;
$idMM=$_REQUEST["idMantenimientoDeTabla"];
limpiarVariablesRequest();

$ACTION="INSERT";
if($mantenimientos->getNombreClaseValidacion()!=''){
    include $mantenimientos->getNombreClaseValidacion();
}

//ucaseVariablesPost();
$valores=insertarMantenimiento($mantenimientos);
$sql=$valores[0];
//echo "<script type='text/javascript'>alert(\"$sql\");</script>";
//die();
if($conexion->ejecutar($sql)==false){
    $error=$conexion->mostrarErrores();
    $error=str_replace("\"", "'", $error);
    echo "<script type='text/javascript'>alert(\"$error\");</script>";
    die();
}

$llave=$valores[1];
if($llave=='0'){
    $llave=$conexion->obtenerGenerada();
}
 //Bitacora de Insert



$url=trim($mantenimientos->getRutaRetorno());
$cLlaves=obtenerCamposLlave($mantenimientos);
$campoLlave=new Detallesmantenimientosdetablas();
$campoLlave=$cLlaves[0];


if($url==''){
    $tipoRet=$mantenimientos->getTipoDeRetorno();
    if($tipoRet==1){
        //Vuelvo al listado
        $url="/core/mantenimiento/listadoDeTabla.php?idMantenimientoDeTabla=$idMM";
    }else{
        //Retorno a la actualizacion.
        $id=$campoLlave->getIdCampo();
        $url="/core/mantenimiento/actualizacionDeTabla.php?idMantenimientoDeTabla=$idMM&$id=$llave";
    }
}
if($mantenimientos->getNivelTabla()>1){
        $llaves=obtenerCamposMaestro($mantenimiento);
        $maestro=$llaves[0];
        $nombreM=$maestro->getIdCampo();
        $valor=$_REQUEST[$nombreM];
        $url.="&$nombreM=$valor";
}
//BITACORA INSERT
$nombreTabla=$mantenimiento->getNombreTabla();
$id=$campoLlave->getIdCampo();
$sqlBitacora= "select * from $nombreTabla where $id='$llave'";
$idSistema=0;
$val=explode(".", $nombreTabla);
if(strtoupper($val[0])=="DIA"){
    $idSistema=1;
}else if(strtoupper($val[0])=="EXTRANJERIA"){
    $idSistema=2;
}else if(strtoupper($val[0])=="SIRES_WEB"){
    $idSistema=3;
}
generarBitacoraInsert($nombreTabla, $llave, $sqlBitacora, $idSistema);

echo "<script type='text/javascript'>parent.cargarContenido('$url');</script>";

?>
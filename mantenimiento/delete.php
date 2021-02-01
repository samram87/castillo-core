<?php
/**
 * Esta es una pagina para capturar un nuevo elemento de la tabla.
 */
error_reporting(E_ALL);
ini_set('display_errors', 0);
$rANT=$_REQUEST;
include 'core/clases/include.php';
include 'core/clases/Mantenimiento.php';

//limpiarVariablesRequest();
$conEE=new Conexion(true);
$conEE=$conexion;
$mantenimientos=new Mantenimientosdetablas();
$mantenimientos=$mantenimiento;
$idMM=$_REQUEST["idMantenimientoDeTabla"];
$cLlaves=obtenerCamposLlave($mantenimientos);
$campoLlave=new Detallesmantenimientosdetablas();
$campoLlave=$cLlaves[0];

$nombre=$campoLlave->getIdCampo();
$valor="";

$llaves= explode(",", $_REQUEST["ids"]);
foreach ($llaves as &$val) {
    if($valor !=""){
        $valor.=",";
    }
    $valor .= "'$val'";
}

$sql="delete from ".$mantenimientos->getNombreTabla()." where  $nombre in ($valor)";
$mantenimientos->setTipoDeRetorno(1);


$error=$conexion->ejecutar($sql);



//generarBitacoraUpdate($nombreTabla, $llave, $sqlBitacora, $idSistema, $datosAnteriores);
$url="/core/mantenimiento/listadoDeTabla.php?idMantenimientoDeTabla=$idMM";

if($mantenimientos->getNivelTabla()>1){
        $llaves=obtenerCamposMaestro($mantenimiento);
        $maestro=$llaves[0];
        $nombreM=$maestro->getIdCampo();
        $valor=$_REQUEST[$nombreM];
        $url.="&$nombreM=$valor";
} 


if($error===false){
    $url.="&error=delete";
}

header("Location: $url");
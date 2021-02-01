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
//ucaseVariablesPost();

$ACTION="UPDATE";
if($mantenimientos->getNombreClaseValidacion()!=''){
    include $mantenimientos->getNombreClaseValidacion();
}

$sql=actualizarMantenimiento($mantenimientos);
//echo "<script>alert(\"$sql\");</script>";
//die();
$cLlaves=obtenerCamposLlave($mantenimientos);
$campoLlave=new Detallesmantenimientosdetablas();
$campoLlave=$cLlaves[0];

$nombre=$campoLlave->getIdCampo();
$valor=$_REQUEST[$nombre];

$sql.=" $nombre='$valor'";

if(isset($_REQUEST["deleteRecord"])){
    $sql="delete from ".$mantenimientos->getNombreTabla()." where  $nombre='$valor'";
    $mantenimientos->setTipoDeRetorno(1);
}

//BITACORA INSERT
$nombreTabla=$mantenimiento->getNombreTabla();
$id=$nombre;
$llave=$valor;
$sqlBitacora= "select * from $nombreTabla where $id='$valor'";
$idSistema=0;
$val=explode(".", $nombreTabla);
if(strtoupper($val[0])=="DIA"){
    $idSistema=1;
}else if(strtoupper($val[0])=="EXTRANJERIA"){
    $idSistema=2;
}
else if(strtoupper($val[0])=="SIRES_WEB"){
    $idSistema=3;
}
$datosAnteriores=datosAnterioresUpdate($nombreTabla, $llave, $sqlBitacora, $idSistema);

$error=$conexion->ejecutar($sql);

generarBitacoraUpdate($nombreTabla, $llave, $sqlBitacora, $idSistema, $datosAnteriores);

if($error===false){
    $descError=$conEE->obtenerErrores();
    $descError=str_replace("'", "\\'", $descError);
    $sqlANT=$sql;
    $sql=str_replace("'", "\\'", $sql);
    if(isset($_REQUEST["deleteRecord"])){
        echo "<br><script type='text/javascript'>parent.alerta('No se puede eliminar este registro, aun existen datos relacionados. Elimine primero los registros que dependan de este.');</script>";
    }else{
        echo "<br><script type='text/javascript'>parent.alerta('Ocurrio un Error, por favor ponganse en contacto con Informatica.<br><i>$sql</i><br>$descError');</script>";
    }
    die();
}else{
    $url=trim($mantenimientos->getRutaRetorno());
    if($url==''){
        $tipoRet=$mantenimientos->getTipoDeRetorno();
        if($tipoRet==1){
            //Vuelvo al listado
            $url="/core/mantenimiento/listadoDeTabla.php?idMantenimientoDeTabla=$idMM";
        }else{
            //Retorno a la actualizacion.
            $id=$campoLlave->getIdCampo();
            $url="/core/mantenimiento/actualizacionDeTabla.php?idMantenimientoDeTabla=$idMM&$nombre=$valor&actualizado=1";
        }
    }
    if($mantenimientos->getNivelTabla()>1){

            $llaves=obtenerCamposMaestro($mantenimiento);
            $maestro=$llaves[0];
            $nombreM=$maestro->getIdCampo();
            $valor=$_REQUEST[$nombreM];
            $url.="&$nombreM=$valor";
    }

    echo "<script type='text/javascript'>parent.cargarContenido('$url');</script>";
}
?>
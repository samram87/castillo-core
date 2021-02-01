<?php
/**
 * Esta es una pagina para capturar un nuevo elemento de la tabla.
 */

include 'core/estatico/encabezado.php';;
include_once $_SERVER['DOCUMENT_ROOT'].'/core/clases/Mantenimiento.php';

$mantenimientos=new Mantenimientosdetablas();
$mantenimientos=$mantenimiento;
$idMantenimiento;
//Lleno algunas variables auxiliares.
$nombreTabla=$mantenimientos->getNombreTabla();
$titulo=$mantenimientos->getTituloTabla();
//$idUsuario=$_SESSION["idUsuario"];
//if($mantenimientos->getNivelTabla()>1){
$niv=$mantenimientos->getNivelTabla();
    imprimirTabs($_REQUEST["idMantenimientoDeTabla"],$niv);
//}
if(isset($_GET["actualizado"])==1){
    c::mensaje("El registro ha sido actualizado");
}
echo '<h2>'.$mantenimientos->getTituloTabla().'</h2>';
echo "<br>";
//Comienzo a leer los campos que se mostraran.
$cLlaves=obtenerCamposLlave($mantenimientos);

$campoLlave=new Detallesmantenimientosdetablas();
$campoLlave=$cLlaves[0];

$nombre=$campoLlave->getIdCampo();
$valor=$_REQUEST[$nombre];

$campos="";
$detalles=$mantenimientos->getDetallesOrdenadosPorCaptura();
for ($i = 0; $i < count($detalles); $i++) {
    $detalle = new Detallesmantenimientosdetablas();
    $detalle = $detalles[$i];
    $tipo=$detalle->getIdTipoCampo();
    if ($i > 0) {
        $campos.=",";
    }
    $campos.=$detalle->getIdCampo();
}
$sqlSelect="select $campos from  $nombreTabla where $nombre='$valor'";
$resValores=new ResultSet($sqlSelect);

$resValores->next();
imprimirCamposActualizacion($mantenimientos,$resValores);

C::addJavascript($mantenimientos->getJavascriptDeEjecucionGlobal());
include 'core/estatico/pie.php';
?>
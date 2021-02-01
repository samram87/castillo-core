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
$idUsuario=$_SESSION["idUsuario"];
if($mantenimientos->getNivelTabla()>1){
    imprimirTabs($_REQUEST["idMantenimientoDeTabla"]);
}

echo '<h2>'.$mantenimientos->getTituloTabla().'</h2>';
echo "<br>";
//Comienzo a leer los campos que se mostraran.
imprimirCamposCaptura($mantenimientos);
echo "<!-- END -->";
C::addJavascript($mantenimientos->getJavascriptDeEjecucionGlobal());
include 'core/estatico/pie.php';
?>
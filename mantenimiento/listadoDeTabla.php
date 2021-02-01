<?php
if(isset($_GET["exportarAExcel"])){
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/clases/include.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/lib/writeExcel/Worksheet.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/lib/writeExcel/Workbook.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/clases/Mantenimiento.php';
    $mantenimientos=new Mantenimientosdetablas();
    $mantenimientos=$mantenimiento;

    //Estableciendo los Headers
    header("Content-type: application/vnd.ms-excel; charset=utf-8");
    header("Content-Disposition: attachment; filename=".$mantenimientos->getTituloTabla().".xls" );
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
    header("Pragma: public");
    
    exportarAExcel($mantenimientos);
}else{
    
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/estatico/encabezado.php';
    include_once $_SERVER['DOCUMENT_ROOT'].'/core/clases/Mantenimiento.php';

$mantenimientos=new Mantenimientosdetablas();
$mantenimientos=$mantenimiento;

$cLlaves=obtenerCamposLlave($mantenimientos);

$campoLlave=new Detallesmantenimientosdetablas();
$campoLlave=$cLlaves[0];

$nombreLlave=$campoLlave->getIdCampo();


if($mantenimientos->getNivelTabla()>1){
    imprimirTabs($_REQUEST["idMantenimientoDeTabla"]);
}

$idMantenimiento;
//Lleno algunas variables auxiliares.
$idMantenimiento=$mantenimientos->getIdMantenimientoDeTabla();
$nombreTabla=$mantenimientos->getNombreTabla();
$titulo=$mantenimientos->getTituloTabla();
$columnas=$mantenimientos->getNumeroDeColumnasMostradas();
$idUsuario=$_SESSION["idUsuario"];

$filtro=reemplazarValores($mantenimientos->getFiltroGeneralDeLaTabla());
/*
 * Despliego las tabs de los hijos si el mantenimiento es un hijo y 
 * se esta accediendo desde el padre
 */
//Busco si viene un mensaje

if(isset($_GET["mmt_tipoMensaje"])){
    if($_GET["mmt_tipoMensaje"]==1){
        C::mensaje($_GET["mmt_mensaje"]);
    }else{
        echo "<script type='text/javascript'>window.onload=function(){alerta('".$_GET["mmt_mensaje"]."')};</script>";
    }
}

//Empiezo a desplegar la tabla...


if(isset($_SESSION["titulo_$idMantenimiento"])){
    echo '<h2>'.$_SESSION["titulo_$idMantenimiento"].'</h2>';
}else{
    echo '<h2>'.$mantenimientos->getTituloTabla().'</h2>';
}

if(isset($_REQUEST["error"])){
    if($_REQUEST["error"]==="delete"){
        C::mensajeError("Ocurrio un error al intentar eliminar el registro");
    }
}
//Campos::editorHTML("prueba",'Este es el contenido... jaja');
//Despliego el boton agregar si es que el usuario tiene opcion para agregar.
echo "<div id='testingBotones'></div>";
agregarBotones($mantenimiento);
echo "<form id='accionMantenimiento' action='#' method='POST' >"
        ."<input type='hidden' name='idMantenimientoDeTabla' value='$_REQUEST[idMantenimientoDeTabla]'>"
        ."<input type='hidden' id='ids' name='ids'>"
        ."<input type='hidden' id='key' name='$nombreLlave'>";
    //Reemplazo algun valor que venga por get.
    $llaves=array_keys($_REQUEST);
    for($i=0;$i<count($_REQUEST);$i++) {
        $id=$llaves[$i];
        if($id!="idMantenimientoDeTabla") {
            $value=$_GET[$id];
            echo "<input type='hidden' id='$id' name='$id' value='$value'>";
        }
    }    
echo  "</form>";
echo "<br><br>";
Campos::inicioDataTable("ListadoDeTabla","testingBotones");
Campos::inicioEncabezadoTabla();
imprimirEncabezadosDespliegue($mantenimiento);
Campos::finEncabezadoTabla();
imprimirCamposDespliegue($mantenimiento);
Campos::finTabla();

Campos::importarJSAlFinal("/core/assets/js/listadoTabla.js");
include 'core/estatico/pie.php';
}
?>
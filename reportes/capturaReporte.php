<?php
include 'core/clases/include.php';
$idReporte=$_REQUEST["idReporte"];

$sql="SELECT
        parametrosdereportes.idParametro
        , parametrosdereportes.titulo
        , parametrosdereportes.nombre
        , parametrosdereportes.queryCampo
        , parametrosdereportes.idTipoCampo
        , parametrosdereportes.oculto
        , parametrosdereportes.valorPorDefecto
        , reportes.sqlReporteSencillo
    FROM
        parametrosdereportes
        INNER JOIN reportes
        ON (parametrosdereportes.idReporte = reportes.idReporte)
    WHERE (reportes.idReporte ='$idReporte')";
$rs=new ResultSet($sql);

C::saltoDeLinea(1);

$sqlReporteSencillo="";
//imprimo el campo oculto con el valor usuarioImprime
c::oculto("idUsuarioImprime",$idUsuario);
$resUsu=new ResultSet("select nombreDeUsuario($idUsuario) ");
$resUsu->next();
$nUsu=$resUsu->getString(0);
c::oculto("imprime",$nUsu);
while($rs->next()){
    $sqlReporteSencillo=$rs->getString("sqlReporteSencillo");
    //Asignacion Variables ResultSet
    $titulo=$rs->getString("titulo");
    $nombre=$rs->getString("nombre");
    $idParametro=$nombre;
    $queryCampo=$rs->getString("queryCampo");
    $tipo=$rs->getInt("idTipoCampo");
    $valorPorDefecto=$rs->getString("valorPorDefecto");
    $oculto=$rs->getBoolean("oculto");

    if($oculto==true){
        //Tipo 22 = usuario
        if($tipo==22){
            c::oculto($idParametro,$idUsuario);
        }else{
            c::oculto($idParametro,obtenerValorPorDefecto($valorPorDefecto));
        }
    }else{
        c::filaGrid();
        c::columnaGrid(3);
        echo $titulo;
        c::finColumnaGrid();
        c::columnaGrid(3);
        //Comienzo a preguntar el tipo de campo.
        $vpd=obtenerValorPorDefecto($valorPorDefecto);
        if($tipo==1){
            //Si es fecha
            c::fecha($idParametro,$vpd);
        }else if($tipo==2){
            //Si es fecha Hora
            c::fechaHora($idParametro,$vpd);
        }else if($tipo==3){
            //Si es hora
            c::hora($idParametro, $vpd);
        }else if($tipo==5){
            //Si es numero entero
            c::entero($idParametro,$vpd);
        }else if($tipo==6){
            //Si es numero flotante
            c::flotante($idParametro, $vpd);
        }else if($tipo==7){
            //Si son caracteres
            c::texto($idParametro, $vpd);
        }else if($tipo==8){
            //Si es un textarea
            c::textArea($idParametro, $vpd);
        }else if($tipo==10){
            //Si es un cheque.
            $chq=false;
            if($vpd==1){
                $chq=true;
            }
             c::chequeSiNo($idParametro,'',$chq);
        }else if($tipo==13){
            //Si es lista desplegable
             $queryCampo=reemplazarValores($queryCampo);
             $resSQL=new ResultSet($queryCampo);
             c::selectAPartirDeResultSet($idParametro, $resSQL, $vpd);
             
        }else if($tipo==26){
            //Si es lista desplegable
             $queryCampo=reemplazarValores($queryCampo);
             $resSQL=new ResultSet($queryCampo);
             c::selectAPartirDeResultSet($idParametro, $resSQL, $vpd);
             echo '<script>setTimeout(function(){$("#'.$idParametro.'").selectpicker();},500);</script>';
             
        }else if($tipo==20){
            //Si es un editor HTML
            c::editorHTMLPopUp($idParametro, $vpd);
        }else if($tipo==21){
            //Si es persona
            c::persona($idParametro);
        }    
        
        c::finColumnaGrid();
        C::saltoDeLinea();
        c::finFilaGrid();
    }
}

Campos::filaGrid();
Campos::columnaGrid(6);
c::inicioCentrado();

    C::saltoDeLinea();
    Campos::inicioGrupoBotones("btnIMp");
    Campos::botonColor("imp", " Exportar a PDF ",C::$NARANJA ,"onclick='return validar(\"pdf\");'");//validar
    Campos::botonColor("impDocx", " Exportar a Word ",C::$AZUL ,"onclick='return validar(\"docx\");'");
    Campos::botonColor("impExcel", " Exportar a Excel ",C::$VERDE ,"onclick='return validar(\"xlsx\");'");
    C::finGrupoBotones();

    if(trim($sqlReporteSencillo)!=''){
        Campos::espaciosEnBlanco(5);
        Campos::boton("exp", "Exportacion Sencilla", "onclick='exportarATexto();'");
        //echo "<textarea name='sqlReporteSencillo' style='display:none'>".$sqlReporteSencillo."</textarea>";
    }
c::finalCentrado();
Campos::finColumnaGrid();
c::finFilaGrid();



function obtenerValorPorDefecto($valorPorDefecto){
    if($valorPorDefecto==''){
        return '';
    }
    $return='';
    //echo strpos($valorPorDefecto,'{');
    
    if(strpos($valorPorDefecto,'{')===0){

        //si comienza con un { es por que se trata de un query asi que lo ejecuto.    
        //primero reemplazo los {idUsuario} por su valor.
        $valorPorDefecto=str_replace("{idUsuario}", $_SESSION["idUsuario"], $valorPorDefecto);
        $valorPorDefecto=str_replace("{", "", $valorPorDefecto);
        $valorPorDefecto=str_replace("}", "", $valorPorDefecto);
        $rsVPD=new ResultSet($valorPorDefecto);
        if($rsVPD->next()){
            $return=$rsVPD->getString(0);
        }
        
    }else{
        $return=$valorPorDefecto;
    }

    return $return;
}
?>
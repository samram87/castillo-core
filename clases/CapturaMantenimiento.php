<?php
/**
 *
 *Comienzo con las funciones para agregar uno nuevo.
 *
 */

function imprimirCamposCaptura(Mantenimientosdetablas $mantenimiento){
    $detalles=$mantenimiento->getDetallesOrdenadosPorCaptura();
    $nombreTabla=$mantenimiento->getNombreTabla();
    $mod=$mantenimiento->getNumeroDeColumnas();
    //Se divide 12 que es el numero del grid entre las columnas por dos
    // asi si se piden 2 columnas se asignan col-grids de 3 una para la etiqueta y otra para el campo
    $num=12/($mantenimiento->getNumeroDeColumnas()*2);
    $cadenaJavascript="";
    $url=$mantenimiento->getRutaInsert();
    $target="target='frameInsert'";
    if(trim($url)==''){    
        $url="/core/mantenimiento/insert.php";
    }
    echo '<iframe src="" name="frameInsert" style="display:none"  ></iframe>';//
    C::inicioFormulario($url, "POST", "FORM1", "onsubmit='return validarFormulario();' $target ");
    imprimirCamposEnOculto();
    C::filaGrid();
    $lastJ=0;
    $j=0;
    for($i=0;$i<count($detalles);$i++){
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        $accion=strtoupper($detalle->getAccionCampo());
        $nombre=$detalle->getNombreCampo();
        $ayuda=$detalle->getDescripcionCampo();
        $tipo=$detalle->getIdTipoCampo();
        $clase=trim(strtoupper($detalle->getClaseCampo()));
        $idC=$detalle->getIdCampo();
        $llaveMostrada=false;

        if($clase=='P'){
            $autonum=$detalle->getAutoincremento();
            if($idC=='idMantenimientoDeTabla'){
                $detalle->setIdCampo("IDMANTENIMIENTODETABLA");
                $idC="IDMANTENIMIENTODETABLA";
            }
            if($autonum=='N'){
                $j++;
                capturarCampo($detalle,$num);
                $j++;
                $llaveMostrada=true;
                //Ahora debo imprimir el javascript para validar el que la llave sea única
                $urlValid="/core/mantenimiento/validarLlave.php?nombreTabla=$nombreTabla&nombreCampo=$idC&valor=";
                C::addJavascript("
                    
                    var llaveValida=true;
                    $(function(){
                        $('#$idC').blur(function(){
                            if($('#$idC').val()!=''){
                                $('#$idC').removeClass('errores');
                                var url='$urlValid'+$('#$idC').val();
                                var cantidad=$.ajax({ type: 'GET', url: url, async: false }).responseText;
                                if(cantidad>0){
                                    $('#$idC').addClass('errores');
                                    llaveValida=false;
                                }else{
                                    llaveValida=true;
                                }
                            }
                        });
                     });");
                $cadenaJavascript.=" if($('#".$detalle->getIdCampo()."').val()==''){ret=false;$('#".$detalle->getIdCampo()."').addClass('vacios');} ";
                $cadenaJavascript.=" if(llaveValida==false){ret=false;} ";
            }
        }else if($clase!='M'){
            echo "<!-- ";
            echo  $detalle->mostrarSoloEnActualizacion();
            echo " -->";
            if($accion=="O"){
                //El campo estara oculto asi q no lo mostrare solo pondre un hidden con su valor por defecto.
                $valorPorDefecto=obtenerValorPorDefecto($detalle);
                C::oculto($idC,$valorPorDefecto);
            } else if( $detalle->mostrarSoloEnActualizacion()){
                //TODO
            } else if($accion=="C"){
                //Si es de captura pues lo muestro
                $j++;
                capturarCampo($detalle,$num);
            } else if($accion=="D"){
                //Si es de despliegue  pues lo muestro aunq  lo deshabilitare.
                $j++;
                desplegarCampo($detalle);
            }
            if($detalle->getNulidadCampo()=='N'){
                //El campo no puede estar vacio.
                $cadenaJavascript.=" if($('#".$detalle->getIdCampo()."').val()==''){ret=false;$('#".$detalle->getIdCampo()."').addClass('vacios');} ";
            }
        }
        if($detalle->getOrdenColumna()>0){
            $j++;
        }
        if($j % $mod ==0){
            if($j!=$lastJ){
                $lastJ=$j;
                C::finFilaGrid();
                echo "<br>";
                if($i+1<count($detalles)){
                    C::filaGrid();
                }
            }
        }else{
            if($i+1>=count($detalles)){
                C::finFilaGrid();
            }
        }
    }
    C::filaGrid();
    C::columnaGrid(12);
    C::inicioCentrado();
    C::boton("ret", "Retornar","onclick='volverAlAnterior();'");
    c::espaciosEnBlanco(10);
    C::submit("send", "Guardar Informacion");
    C::finCentrado();
    C::finColumnaGrid();
    C::finFilaGrid();
    C::finFomulario();
    echo "<script type='text/javascript'> function validarFormulario(){ var ret=true; $('.vacios').removeClass('vacios');$cadenaJavascript
    if(ret==false){alerta('Falta completar la información, por favor revise los campos resaltados.');} return  ret; }</script>";

}

function capturarCampo(Detallesmantenimientosdetablas $detalle,$numeroGrid,$ValorPorDefecto=false,$sinValorPorDefecto=''){
    //Ahora dependiendo del tipo de campo asi pongo la captura
    $size=$detalle->getTamanoCampo();
    $max=$detalle->getTamanoMaximoCampo();
    $javascript=$detalle->getJavascriptDesdeCampo();
    $valorPorDefecto=trim(obtenerValorPorDefecto($detalle));
    if($sinValorPorDefecto!=false){
        $valorPorDefecto=$ValorPorDefecto;
    }
    $id=$detalle->getIdCampo();
    $tipo=$detalle->getIdTipoCampo();
    $requerido=$detalle->getNulidadCampo();
    $accion=strtoupper($detalle->getAccionCampo());

    $ayuda=$detalle->getDescripcionCampo();
    
    if ($tipo == 14) { //Si es tipo Separador de Campos
        Campos::columnaGrid($numeroGrid);
        echo "<center><strong>" . $detalle->getNombreCampo() . "</strong></center>";
        Campos::finColumnaGrid();

        return;
    } else if($tipo!='30') {
       Campos::columnaGrid($numeroGrid);
        echo $detalle->getNombreCampo();
        Campos::finColumnaGrid();
    }


/*
    1	Fecha
    2	Fecha Hora
    3	Hora
    4	Archivo
    5	Numerico
    6	Moneda
    7	Caracteres
    8	Texto
    9	Tabla Extranjera
    10	Boton de Cheque
    11	Botones de Opcion Múltiple PENDIENTE
    12	FALSO
    13	Lista Desplegable
    14	Agrupador de Campos 
    15	Separador De Campos Oculto PENDIENTE
    16	Finalizacion del Separador PENDIENTE
    17	Tabla PENDIENTE
    18	Boton PENDIENTE
    19	Ruta de archivo PENDIENTE
    20  Editor HTML PopUp
 */

    Campos::columnaGrid($numeroGrid);
    //Aqui empieza la captura...
    if($tipo==1){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        if(trim($valorPorDefecto)==""){
            $valorPorDefecto=null;
        }
        C::fecha($id,$valorPorDefecto,$resFecha);
    }else if($tipo==2){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        C::fechaHora($id,$valorPorDefecto,$resFecha);
    }else if($tipo==3){
        C::hora($id, $valorPorDefecto);
    }else if($tipo==5){
        C::entero($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==6){
        C::flotante($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==7){
        C::texto($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==8){
        $filas=$detalle->getAltoCampo();
        C::textArea($id,$valorPorDefecto,$filas,$size,$javascript);
    }else if($tipo==9){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id, $rsT, $valorPorDefecto);
    }else if($tipo==10){
        $chequeado=false;
        if($valorPorDefecto==1){
            $chequeado=true;
        }
        C::chequeSiNo($id,'',$chequeado);
    } else if($tipo==12){
        C::texto($id, $valorPorDefecto, $size, $max, $javascript." READONLY");
    }else if($tipo==13){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id, $rsT, $valorPorDefecto);
    }else if($tipo==20){
        C::editorHTMLPopUp($id, "<p></p>", $detalle->getNombreCampo());
    }else if($tipo==21){
        C::persona($id, $valorPorDefecto);
    }else if($tipo==25){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==14){
        //Separador de campos
    }else if($tipo==26){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==27){
        $chequeado=false;
        if($valorPorDefecto=='A'){
            $chequeado=true;
        }
        C::chequeActivo($id,'',$chequeado);
    }else if($tipo==28){
        C::textoConMascara($id,$detalle->getQueryFiltro());
    }else if($tipo==29){
        C::selectCatalogoId($id,$detalle->getCatalogoId(), $valorPorDefecto);
    }
    
    C::finColumnaGrid();
}

function desplegarCampo(Detallesmantenimientosdetablas $detalle,$numeroGrid,$sinValorPorDefecto=false){


    //Ahora dependiendo del tipo de campo asi pongo la captura
    $size=$detalle->getTamanoCampo();
    $max=$detalle->getTamanoMaximoCampo();
    $javascript=$detalle->getJavascriptDesdeCampo();
    $valorPorDefecto=trim(obtenerValorPorDefecto($detalle));
    if($sinValorPorDefecto!=false){
        $valorPorDefecto=$ValorPorDefecto;
    }
    $id=$detalle->getIdCampo();
    $tipo=$detalle->getIdTipoCampo();
    $requerido=$detalle->getNulidadCampo();
    $accion=strtoupper($detalle->getAccionCampo());

    $ayuda=$detalle->getDescripcionCampo();

    if ($tipo == 14) { //Si es tipo Separador de Campos
         Campos::columnaGrid($numeroGrid);
        echo "<center><strong>" . $detalle->getNombreCampo() . "</strong></center>";
        Campos::finColumnaGrid();
        return;
    } else {
          Campos::columnaGrid($numeroGrid);
          echo $detalle->getNombreCampo();
          C::finColumnaGrid();
    }

     Campos::columnaGrid($numeroGrid);

/*
    1	Fecha
    2	Fecha Hora
    3	Hora
    4	Archivo
    5	Numerico
    6	Moneda
    7	Caracteres
    8	Texto
    9	Tabla Extranjera
    10	Boton de Cheque
    11	Botones de Opcion Múltiple PENDIENTE
    12	FALSO
    13	Lista Desplegable
    14	Agrupador de Campos
    15	Separador De Campos Oculto PENDIENTE
    16	Finalizacion del Separador PENDIENTE
    17	Tabla PENDIENTE
    18	Boton PENDIENTE
    19	Ruta de archivo PENDIENTE
    20  Editor HTML PopUp
 */


    //Aqui empieza la captura...
    if($tipo==1){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        if(trim($valorPorDefecto)==""){
            $valorPorDefecto=null;
        }
        C::texto($id,$valorPorDefecto,10,10," READONLY ");
    }else if($tipo==2){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        C::texto($id,$valorPorDefecto,15,15," READONLY ");
    }else if($tipo==3){
        C::texto($id,$valorPorDefecto,10,10," READONLY ");
    }else if($tipo==5){
        C::entero($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==6){
        C::flotante($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==7){
        C::texto($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==8){
        $filas=$detalle->getAltoCampo();
        C::textArea($id,$valorPorDefecto,$filas,$size,$javascript." READONLY ");
    }else if($tipo==9){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id."selectDisabled", $rsT, $valorPorDefecto," DISABLED ");
        C::oculto($id,$valorPorDefecto);
    }else if($tipo==10){
        $chequeado=false;
        if($valorPorDefecto==1){
            $chequeado=true;
        }
        C::chequeSiNo($id,'',$chequeado,1," DISABLED ");
    } else if($tipo==12){
        C::texto($id, $valorPorDefecto, $size, $max, $javascript." READONLY");
    }else if($tipo==13){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id."selectDisabled", $rsT, $valorPorDefecto," DISABLED ");
        C::oculto($id,$valorPorDefecto);
    }else if($tipo==20){
        C::editorHTMLPopUp($id, $valorPorDefecto, $detalle->getNombreCampo());
    }else if($tipo==26){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==27){
        $chequeado=false;
        if($valorPorDefecto=='A'){
            $chequeado=true;
        }
        C::chequeActivo($id,'',$chequeado);
    }else if($tipo==28){
        C::textoConMascara($id,$detalle->getQueryFiltro());
    }else if($tipo==29){
        C::selectCatalogoId($id,$detalle->getCatalogoId(), $valorPorDefecto);
    }

    C::finColumnaGrid();
}

function imprimirCamposEnOculto(){
    $arr = array_keys($_POST);
    for ($i = 0; $i < count($arr); $i++) {
        $key = $arr[$i];
        $val=$_POST[$key];
        C::oculto($key, $val);
    }
    $arr = array_keys($_GET);
    for ($i = 0; $i < count($arr); $i++) {
        $key = $arr[$i];
        $val=$_GET[$key];
        C::oculto($key, $val);
    }
}

function generarQueryCapturaExtranjera(Detallesmantenimientosdetablas $detalle){
    $filtro=$detalle->getQueryFiltro();
    if(trim($filtro)==""){
        //No existe el filtro asi que debo generar el query a partir del mantenimiento extranjero
        $idMantTablaExt=$detalle->getIdMantenimientoDeTablaExtranjera();
        $manteExt=new Mantenimientosdetablas();
        $manteExt=obtenerMantenimiento($idMantTablaExt);
        $llaves=obtenerCamposLlave($manteExt);
        $llaveOculta=new Detallesmantenimientosdetablas();
        $campoMostrado=new Detallesmantenimientosdetablas();
        $llaveOculta=$llaves[0];
        $nombreLlave=$llaveOculta->getIdCampo();
        $desp=obtenerCamposDesplegados($manteExt,true);
        $campoMostrado=$desp[0];
        if($campoMostrado->getIdCampo()==$llaveOculta->getIdCampo()){
            $campoMostrado=$desp[1];
        }
        $generarSelect="select ".$llaveOculta->getIdCampo().", ".$campoMostrado->getIdCampo()." from ".$manteExt->getNombreTabla()." ";
        if($manteExt->getFiltroGeneralDeLaTabla()!=''){
             $filtro=reemplazarValores($manteExt->getFiltroGeneralDeLaTabla());
            $generarSelect.=" where ".$filtro." ";
        }
        $generarSelect.=" order by ".$campoMostrado->getIdCampo();

        return $generarSelect;
    }else{
        $filtro=reemplazarValores($filtro);
        return $filtro;
    }
}

function obtenerValorPorDefecto(Detallesmantenimientosdetablas $detalle){
    $val=$detalle->getValorDefault();
    $val=trim($val);
    if($val!=""){
        $valorDefecto="";
        if(StartsWith($val, "::")){
            //si el valor comienza con :: es por que es un sql que debo ejecutar.
            $val=str_replace("::","",$val);
            $query=reemplazarValores($val);
            $rs=new ResultSet($query);
            $rs->next();
            $valorDefecto=$rs->getString(0);
        }else{
            $valorDefecto=$val;
        }
        return $valorDefecto;
    }else{
        return "";
    }
}

function insertarMantenimiento(Mantenimientosdetablas $mantenimiento){
    $detalles=$mantenimiento->getDetallesOrdenadosPorCaptura();
    $nombreTabla=$mantenimiento->getNombreTabla();
    $sql="insert into $nombreTabla(";
    $campos="";
    $valores="";
    $primeraVez=true;
    $valorLlaveInsertada='';
    for($i=0;$i<count($detalles);$i++){
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        $idTipo=$detalle->getIdTipoCampo();
        $clase=trim(strtoupper($detalle->getClaseCampo()));
        $idC=$detalle->getIdCampo();
        $autonum=$detalle->getAutoincremento();
        if($primeraVez==false){
            $campos.=",";
            $valores.=",";
        }
        if($clase=='P'){
            if($autonum=='N'){
                $primeraVez=false;
                $campos.="$idC";
                $valores="'".$_REQUEST[$idC]."'";
                $valorLlaveInsertada=$_REQUEST[$idC];
            }
        }else{
            if($idTipo!='30'){
                $primeraVez=false;
             
                $campos.="$idC";
                if($_REQUEST[$idC]==''){
                    $valores.="NULL";
                }else{
                    if ($idTipo == 1) {
                        $valores.="str_to_date('" . $_REQUEST[$idC] . "','%d/%m/%Y')";
                    } else if ($idTipo == 2) {
                        $valores.="str_to_date('" . $_REQUEST[$idC] . "','%d/%m/%Y %H:%i')";
                    } else if ($idTipo == 3) {
                        $valores.="str_to_date('" . $_REQUEST[$idC] . "','%H:%i')";
                    } else {
                        
                        $valores.="'" .Conexion::escaparString($_REQUEST[$idC]) . "'";
                    }
                }
            }
             
        }
    }
    $sql.=$campos.") values(".$valores.")";
    $ret=array ();
    $ret[0]=$sql;
    $ret[1]=0;
    if($valorLlaveInsertada!=''){
        $ret[1]= $valorLlaveInsertada;
    }
    return $ret;
}


function imprimirCamposActualizacion(Mantenimientosdetablas $mantenimiento,  ResultSet $resValores){
    $detalles=$mantenimiento->getDetallesOrdenadosPorCaptura();
    $idMMM=$mantenimiento->getIdMantenimientoDeTabla();
    $nombreTabla=$mantenimiento->getNombreTabla();
    $cadenaJavascript="";
    
    $mod=$mantenimiento->getNumeroDeColumnas();
    //Se divide 12 que es el numero del grid entre las columnas por dos
    // asi si se piden 2 columnas se asignan col-grids de 3 una para la etiqueta y otra para el campo
    $num=12/($mantenimiento->getNumeroDeColumnas()*2);
    $url=$mantenimiento->getRutaInsert();
    $target="";
    if(trim($url)==''){
        $target="target='frameUpdate'";
        $url="/core/mantenimiento/update.php";
    }
    echo '<iframe src="" name="frameUpdate" style="display:none"  /></iframe>';//style="display:none"
    C::inicioFormulario($url, "POST", "FORM1", "onsubmit='return validarFormulario();' $target ");
    imprimirCamposEnOculto();
    C::filaGrid();
    $j=0;
    $lastJ=0;
    for($i=0;$i<count($detalles);$i++){
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        $accion=strtoupper($detalle->getAccionCampo());
        $nombre=$detalle->getNombreCampo();
        $ayuda=$detalle->getDescripcionCampo();
        $tipo=$detalle->getIdTipoCampo();
        $clase=trim(strtoupper($detalle->getClaseCampo()));
        $idC=$detalle->getIdCampo();
        $valor=false;

        $id=$detalle->getIdCampo();
        if ($tipo == 1) {
            $valor = $resValores->getDate($id);
           
        } else if ($tipo == 2) {
            $valor = $resValores->getString($id);
        } else if ($tipo == 3) {
            $valor = $resValores->getDateTime($id);
        } else if ($tipo == 9) {
            $valor = $resValores->getString($id);
          
        } else if ($tipo == 13) {
            $valor = $resValores->getString($id);

        } else if ($tipo == 8) {
            $valor = $resValores->getString($id);
            $valor = str_replace("\n", "", $valor);
            $valor = str_replace(chr(13), " ", $valor);
           
        } else if ($tipo == 10) {
            $valor =$resValores->getString($id);
        } else if ($tipo == 20) {
            $valor = $resValores->getString($id);
            $valor = str_replace(chr(13), " ", $valor);
            $valor = str_replace("\r", " ", $valor);
            $valor = str_replace("\n", " ", $valor);
            if($valor==''){
            $valor = '<p>Inserte aqui el contenido...</p>';
            }
        } else {
            $valor = $resValores->getString($id);
            $valor = str_replace("\"", "\\\"", $valor);
        }

        //Aqui si capturo el campo
        if($clase=='P'){
            $autonum=$detalle->getAutoincremento();
            if($idC=='idMantenimientoDeTabla'){
                $detalle->setIdCampo("IDMANTENIMIENTODETABLA");
                $idC="IDMANTENIMIENTODETABLA";
            }
            if($autonum=='N'){
                $detalle->setValorDefault($_REQUEST[$idC]);
                desplegarCampoActualizar($detalle,$num,$valor); 
                $j++; $j++;
            }
        }else if($clase=='M'){
              //C::oculto($nombre,$valorPorDefecto);
        }else{
            if($accion=="O"){
                //El campo estara oculto asi q no lo mostrare solo pondre un hidden con su valor por defecto.
                C::oculto($idC,$valor);
            }else if($accion=="C"){
                $j++;
                //Si es de captura pues lo muestro
                capturarCampoActualizar($detalle,$num,$valor);
            }else if($accion=="D"){
                $j++;
                //Si es de despliegue  pues lo muestro aunq  lo deshabilitare.
                desplegarCampoActualizar($detalle,$num,$valor);
            }
            if($detalle->getNulidadCampo()=='N'){
                //El campo no puede estar vacio.
                $cadenaJavascript.=" if($('#".$detalle->getIdCampo()."').val()==''){ret=false;$('#".$detalle->getIdCampo()."').addClass('vacios');} ";
            }
        }
        if($detalle->getOrdenColumna()>0){
            $j++;
        }
        if($j % $mod ==0){
            if($j!=$lastJ){
                $lastJ=$j;
                C::finFilaGrid();
                echo "<br>";
                if($i+1<count($detalles)){
                    C::filaGrid();
                }
            }
        }else{
            if($i+1>=count($detalles)){
                C::finFilaGrid();
            }
        }
    }
    C::saltoDeLinea();
    C::filaGrid();
    C::columnaGrid(12);
    echo "<center>";
    $adRet="";
    if($mantenimiento->getNivelTabla()>1){
        $llaves=obtenerCamposMaestro($mantenimiento);
        $maestro=$llaves[0];
        $nombreM=$maestro->getIdCampo();
        $valor=$_REQUEST[$nombreM];
        $adRet.="&$nombreM=$valor";
    }
    C::boton("ret", "Regresar","onclick='cargarContenido(\"/core/mantenimiento/listadoDeTabla.php?idMantenimientoDeTabla=$idMMM&$adRet\");'");
    if($mantenimiento->getPermisoUpdate()==true){
        c::espaciosEnBlanco(5);
        C::submit("send", "Guardar Informacion");
    }
    if($mantenimiento->getPermisoDelete()==true){
        c::espaciosEnBlanco(5);
        C::submit("deleteRecord", "Eliminar Registro",'',"onclick=\"return confirm('Esta a punto de eliminar un registro. ¿Desea continuar?');\"");
    }
    C::saltoDeLinea();
    imprimirBotonesDelMantenimiento($mantenimiento);
    echo "</center>";
    C::finColumnaGrid();
    C::finFilaGrid();
    C::finFomulario();
    echo "<script type='text/javascript'> function validarFormulario(){ var ret=true; $('.vacios').removeClass('vacios');$cadenaJavascript
    if(ret==false){alerta('Falta completar la información, por favor revise los campos resaltados.');} return  ret; }
    ".$mantenimiento->getJavascriptDeEjecucionGlobal()."
    </script>";

}


function capturarCampoActualizar(Detallesmantenimientosdetablas $detalle,$numeroGrid,$ValorPorDefecto=''){
    //Ahora dependiendo del tipo de campo asi pongo la captura
    $size=$detalle->getTamanoCampo();
    $max=$detalle->getTamanoMaximoCampo();
    $javascript=$detalle->getJavascriptDesdeCampo();
    $valorPorDefecto=$ValorPorDefecto;
    $id=$detalle->getIdCampo();
    $tipo=$detalle->getIdTipoCampo();
    $requerido=$detalle->getNulidadCampo();
    $accion=strtoupper($detalle->getAccionCampo());

    $ayuda=$detalle->getDescripcionCampo();
    if ($tipo == 14) { //Si es tipo Separador de Campos
        Campos::columnaGrid($numeroGrid);
        echo "<center><strong>" . $detalle->getNombreCampo() . "</strong></center>";
        Campos::finColumnaGrid();
        return;
    } else {
        Campos::columnaGrid($numeroGrid);
        echo $detalle->getNombreCampo();
        Campos::finColumnaGrid();
    }
    Campos::columnaGrid($numeroGrid);
    //Aqui empieza la captura...
    if($tipo==1){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        if(trim($valorPorDefecto)==""){
            $valorPorDefecto=null;
        }
        C::fecha($id,$valorPorDefecto,$resFecha);
    }else if($tipo==2){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        C::fechaHora($id,$valorPorDefecto,$resFecha);
    }else if($tipo==3){
        C::hora($id, $valorPorDefecto);
    }else if($tipo==5){
        C::entero($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==6){
        C::flotante($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==7){
        C::texto($id,$valorPorDefecto,$size,$max,$javascript);
    }else if($tipo==8){
        $filas=$detalle->getAltoCampo();
        C::textArea($id,$valorPorDefecto,$filas,$size,$javascript);
    }else if($tipo==9){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id, $rsT, $valorPorDefecto);
    }else if($tipo==10){
        $chequeado=false;
        if($valorPorDefecto==1){
            $chequeado=true;
        }
        C::chequeSiNo($id,'',$chequeado);
    } else if($tipo==12){
        C::texto($id, $valorPorDefecto, $size, $max, $javascript." READONLY");
    }else if($tipo==13){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id, $rsT, $valorPorDefecto);
    }else if($tipo==20){
        C::editorHTMLPopUp($id, $valorPorDefecto, $detalle->getNombreCampo());
    }else if($tipo==21){
        C::persona($id, $valorPorDefecto);
    }else if($tipo==25){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==26){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==27){
        $chequeado=false;
        if($valorPorDefecto=='A'){
            $chequeado=true;
        }
        C::chequeActivo($id,'',$chequeado);
    }else if($tipo==28){
        C::textoConMascara($id,$detalle->getQueryFiltro(),$valorPorDefecto);
    }else if($tipo==29){
        C::selectCatalogoId($id,$detalle->getCatalogoId(), $valorPorDefecto);
    }

    
        C::finColumnaGrid();

}

function desplegarCampoActualizar(Detallesmantenimientosdetablas $detalle,$numeroGrid,$valor=''){
    //Ahora dependiendo del tipo de campo asi pongo la captura
    $size=$detalle->getTamanoCampo();
    $max=$detalle->getTamanoMaximoCampo();
    $javascript=$detalle->getJavascriptDesdeCampo();
    $valorPorDefecto=$valor;
    $id=$detalle->getIdCampo();
    $tipo=$detalle->getIdTipoCampo();
    $requerido=$detalle->getNulidadCampo();
    $accion=strtoupper($detalle->getAccionCampo());

    Campos::inicioFila();
    $ayuda=$detalle->getDescripcionCampo();

    if ($tipo == 14) { //Si es tipo Separador de Campos
        Campos::columnaGrid($numeroGrid);
        echo "<center><strong>" . $detalle->getNombreCampo() . "</strong></center>";
        Campos::finColumnaGrid();
        return;
    } else {
        Campos::columnaGrid($numeroGrid);
        echo $detalle->getNombreCampo();
        C::finColumnaGrid();
    }

    Campos::columnaGrid($numeroGrid);
    //Aqui empieza la captura...
    if($tipo==1){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        if(trim($valorPorDefecto)==""){
            $valorPorDefecto=null;
        }
        C::texto($id,$valorPorDefecto,10,10," READONLY ");
    }else if($tipo==2){
        $resFecha=$detalle->getRestriccionDeFechas();
        if(trim($resFecha)==""){
            $resFecha=null;
        }
        C::texto($id,$valorPorDefecto,15,15," READONLY ");
    }else if($tipo==3){
        C::texto($id,$valorPorDefecto,10,10," READONLY ");
    }else if($tipo==5){
        C::entero($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==6){
        C::flotante($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==7){
        C::texto($id,$valorPorDefecto,$size,$max,$javascript." READONLY ");
    }else if($tipo==8){
        $filas=$detalle->getAltoCampo();
        c::oculto($id,$valorPorDefecto);
        echo $valorPorDefecto;
    }else if($tipo==9){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id."selectDisabled", $rsT, $valorPorDefecto," DISABLED ");
        C::oculto($id,$valorPorDefecto);
    }else if($tipo==10){
        $chequeado=false;
        if($valorPorDefecto==1){
            $chequeado=true;
        }
        C::chequeSiNo($id,'',$chequeado,1," DISABLED ");
    } else if($tipo==12){
        C::texto($id, $valorPorDefecto, $size, $max, $javascript." READONLY");
    }else if($tipo==13){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSet($id."selectDisabled", $rsT, $valorPorDefecto," DISABLED ");
        C::oculto($id,$valorPorDefecto);
    }else if($tipo==20){
        C::editorHTMLPopUp($id, $valorPorDefecto, $detalle->getNombreCampo());
    }else if($tipo==25){
        $query=generarQueryCapturaExtranjera($detalle);
        $rsT=new ResultSet($query);
        C::selectAPartirDeResultSetConBusqueda($id, $rsT, $valorPorDefecto);
    }else if($tipo==27){
        $chequeado=false;
        if($valorPorDefecto=='A'){
            $chequeado=true;
        }
        C::chequeActivo($id,'',$chequeado);
    }else if($tipo==29){
        C::selectCatalogoId($id,$detalle->getCatalogoId(), $valorPorDefecto);
    }
    C::finColumnaGrid();
}

function imprimirBotonesDelMantenimiento(Mantenimientosdetablas $mantenimiento){
    $id=$mantenimiento->getIdMantenimientoDeTabla();
    $sel="SELECT idBoton, NombreBoton, Accion FROM botonespormantenimiento
	where idMantenimientoDeTabla='$id' ";
    $resBtn=new ResultSet($sel);
    $primeraVez=true;

    while($resBtn->next()){
        if($primeraVez){
            echo '<br>';
            $primeraVez=false;
        }else{
            c::espaciosEnBlanco(5);
        }
        $idbtn=$resBtn->getString(0);
        $nombre=$resBtn->getString(1);
        $accion=reemplazarValores($resBtn->getString(2));
        C::boton("btn$idbtn",$nombre,$accion);
        
    }
    if(isset($_SESSION["botones_$id"])){
        $arr=$_SESSION["botones_$id"];
        for($i=0;$i<count($arr);$i++){
            $rem=reemplazarValores($arr[$i][1]);
            
            c::espaciosEnBlanco(5);
            
            C::boton("btn_generado$i",$arr[$i][0],$rem);
        }
    }
}


function actualizarMantenimiento(Mantenimientosdetablas $mantenimiento){
    $detalles=$mantenimiento->getDetallesOrdenadosPorCaptura();
    $nombreTabla=$mantenimiento->getNombreTabla();
    $sql="update $nombreTabla  set ";
    $campos="";

    $primeraVez=true;
    $valorLlaveInsertada='';
    for($i=0;$i<count($detalles);$i++){
        $detalle=new Detallesmantenimientosdetablas();
        $detalle=$detalles[$i];
        $idTipo=$detalle->getIdTipoCampo();
        $clase=trim(strtoupper($detalle->getClaseCampo()));
        $idC=$detalle->getIdCampo();
        $autonum=$detalle->getAutoincremento();
        if($primeraVez==false){
            $campos.=",";
        }
        if($clase!='P'){
            if ($idTipo != '30') {
             $primeraVez=false;
             $campos.="$idC=";
             if($_REQUEST[$idC]==''){
                 $campos.="NULL";
             }else{
                 if ($idTipo == 1) {
                    $campos.="str_to_date('" . $_REQUEST[$idC] . "','%d/%m/%Y')";
                } else if ($idTipo == 2) {
                    $campos.="str_to_date('" . $_REQUEST[$idC] . "','%d/%m/%Y %H:%i')";
                } else if ($idTipo == 3) {
                    $campos.="str_to_date('" . $_REQUEST[$idC] . "','%H:%i')";
                } else {
                    $campos.="'" .Conexion::escaparString($_REQUEST[$idC]) . "'";
                }
             }
            }
        }
    }
    $sql.=$campos." where ";
    
    return $sql;
}
?>
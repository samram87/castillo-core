<?php
/**
 * 
 * Clase que genera los campos html.
 *
 * @author Informatica. Dirección General de Migración y Extranjeria.
 * @copyright Los Fuentes aqui incluidos son para uso exclusivo de la Direccion General de Migracion y Extranjeria. Cualquier uso indebido sera penado por las leyes de proteccion a la propiedad intelectual.
 */
class Campos {

    public static $Contador = 1;
    public static $resaltado = false;
    public static $incluidoFecha = false;
    public static $incluirEditor = false;
    public static $Derecha = 1;
    public static $Izquierda = 1;
    
    public static $VERDE="success";
    public static $ROJO="danger";
    public static $CELESTE="info";
    public static $NARANJA="warning";
    public static $GRIS="default";
    public static $NEGRO="metis-5";
    public static $AZUL="primary";
    
    public static $SELECT_MULTY="multi";
    public static $SELECT_SINGLE="single";
    
    
    public static $javascript="";
    
    public static $cssAImportar="";
    
    public static $javascriptAImportar="";
    public static $javascriptFinal="";
    
    public static function importarJS($url){
        Campos::$javascriptAImportar.="<script src='$url'></script>";
    }

    public static function importarCss($url){
        Campos::$cssAImportar.="<link rel='stylesheet' href='$url'>";
    }
    
    
    
    
    
    public static function importarJSAlFinal($url){
        Campos::$javascriptFinal.="<script src='$url'></script>";
    }
    /**
     * Procedimiento que imprime una caja de texto en la página HTML.<br>
     * <input type='text' />
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $tamano (opcional) el tamaño de la caja de texto (50 por defecto)
     * @param string $maximo (opcional) la cantidad maxima de caracteres que se podran ingresar en la caja de texto (50 por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function texto($nombre, $valor = '', $tamano = 50, $maximo = 50, $eventos = '',$placeholder='',$required=false) {
        $req=($required===true?"required":"");
        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'' . $maximo . '\'
            value=\'' . $valor . '\' ' . $eventos . '
            tabindex=\'' . Campos::$Contador . '\'
            placeholder=\'' . $placeholder . '\' 
                '.$req.'
            class="form-control" >';
        Campos::$Contador+=1;
    }
    
    
    
     public static function email($nombre, $valor = '',$maximo=50,$eventos = '') {
        echo '<input type=\'email\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'' . $maximo . '\'
            value=\'' . $valor . '\' ' . $eventos . '
            tabindex=\'' . Campos::$Contador . '\'
            placeholder=\'ejemplo@ejemplo.com\' 
            class="form-control" >';
        Campos::$Contador+=1;
    }

    public static function ayuda($ss){
        
    }
    /**
     * Procedimiento que imprime un <b>textarea</b> en la pagina.<br>
     * <textarea cols=15 rows=3>$valor</textarea>
     * @static
     * @param string $nombre el nombre y ID del textarea
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $filas (opcional) modifica la propiedad rows (3 por defecto)
     * @param string $columnas (opcional) modifica la propiedad cols (50 por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function textArea($nombre, $valor = '', $filas = 3, $columnas = 50, $eventos = '') {
        echo '<textarea
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            rows=\'' . $filas . '\'
                cols=\'' . $columnas . '\'
            ' . $eventos . '
            tabindex=\'' . Campos::$Contador . '\' class="form-control" >' . $valor . '</textarea>';
        Campos::$Contador+=1;
    }

    /**
     * Procedimiento que imprime una caja de texto para password en la página HTML.<br>
     * <input type='password' value='valor' />
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $tamano (opcional) el tamaño de la caja de texto (15 por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function password($nombre, $valor = '', $tamano = 15, $eventos = '') {
        echo '<input type=\'password\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            size=\'' . $tamano . '\'
            value=\'' . $valor . '\' ' . $eventos . ' tabindex=\'' . Campos::$Contador . '\'
            class="form-control" >';
        Campos::$Contador+=1;
    }

    /**
     * Procedimiento que imprime una caja de texto que solamente permite ingresar fechas.
     * Incluye un calendario buscador de fechas  (<a href='http://jqueryui.com/demos/datepicker/#min-max'>jquery UI datepicker</a>).<br>
     * <input type='text' maxlength='10' size='11' value='01/01/2011' />
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto) este debe estar en formato dd/mm/yyyy
     * @param string $restriccion (opcional) incluye una restriccion a las fechas. por ejemplo si la restriccion es: minDate: -20, maxDate: "+1M +10D" la menor fecha permitida sera hace 20 dias y la mayor dentro de un mes con 10 dias
     */
    public static function fecha($nombre, $valor = null, $required="") {

        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'10\'
            size=\'12\' $required
            tabindex=\'' . Campos::$Contador . '\'
            value=\'' . $valor . '\'  onblur="validarFecha(this)"  class="form-control, datepicker"  data-date-format="dd/mm/yyyy" >';
        Campos::$Contador+=1;
        //Ahora imprimo el javascript

        Campos::$javascript.='          
              $(function(){
                $("#' . $nombre . '").datepicker({format: "dd/mm/yyyy"}); 
              });
             ';
    }

    //.mask("99/99/9999");
    /**
     * Procedimiento que imprime una caja de texto que solamente permite ingresar numeros de telefono validos en EL Salvador.

     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto) este debe estar en formato dd/mm/yyyy
     */
    public static function telefono($nombre, $valor = null) {
        echo '
            <div class="input-group">
                <input type=\'text\'
                name=\'' . $nombre . '\'
                id=\'' . $nombre . '\'
                maxlength=\'9\'
                size=\'10\'
                tabindex=\'' . Campos::$Contador . '\'
                value=\'' . $valor . '\'  class="form-control" data-mask="9999-9999" >
                <span class="input-group-addon">9999-9999</span>
            </div>';
        Campos::$Contador+=1;
        //Ahora imprimo el javascript
        
    }

    /**
     * Procedimiento que imprime una caja de texto para el ingreso de numeros enteros en la página HTML.<br>
     * <input type='text' value=15 size=10 />
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $tamano (opcional) el tamaño de la caja de texto (10 por defecto)
     * @param string $maximo (opcional) la cantidad maxima de caracteres que se podran ingresar en la caja de texto (11 por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function entero($nombre, $valor = '', $tamano = 10, $maximo = 11, $eventos = '',$required=false) {
        Campos::texto($nombre, $valor, $tamano, $maximo, $eventos . ' onblur="validarEntero(this);" ',"",$required);
        Campos::$javascript.="
            $(function(){
                $('#$nombre').keypress(function(e){
                var unicode=e.charCode? e.charCode : e.keyCode;
                //alert(unicode);
                if (unicode!=8 && unicode!=9 && unicode!=37 && unicode!=13 && unicode!=39 && unicode!=46){ //if the key isn't the backspace key (which we should allow)
                if (unicode<48||unicode>57) //if not a number
                    return false //disable key press
                }
                    
        	});
                });
               ";
    }

    /**
     * Procedimiento que imprime una caja de texto para el ingreso de flotantes separados por . (punto) enteros en la página HTML.<br>
     * <input type='text' value=15 size=10 />
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $tamano (opcional) el tamaño de la caja de texto (10 por defecto)
     * @param string $maximo (opcional) la cantidad maxima de caracteres que se podran ingresar en la caja de texto (11 por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function flotante($nombre, $valor = '', $tamano = 10, $maximo = 11, $eventos = '') {
        Campos::texto($nombre, $valor, $tamano, $maximo, $eventos . ' onblur="validarNumero(this);" ');
        Campos::$javascript.="
            $(function(){
                $('#$nombre').keypress(function(e){
                var unicode=e.charCode? e.charCode : e.keyCode;
                if (unicode!=8 && unicode!=9 && unicode!=37 && unicode!=39 && unicode!=46){
                if (unicode<48||unicode>57)
                    return false
                }
        	});
                });
               ";
    }

    /*
      public static function subirImagen($nombre,$valor,$maximoTamano){

      }
     */

    public static function boton($nombre, $valor, $eventos = '',$icono='') {
        echo "<button $eventos tabindex='" . Campos::$Contador . "'  class=\"btn btn-primary\" type=\"button\" role='button' name='$nombre' id='$nombre' >";
        if($icono!=''){
            echo "<i class='fa fa-$icono' aria-hidden='true'></i>";
        }
        echo "$valor</button>";
        Campos::$Contador+=1;
    }
    
    
    public static function botonColor($nombre, $valor, $color="primary", $eventos = '',$icono='') {
        echo "<button $eventos tabindex='" . Campos::$Contador . "'  class=\"btn btn-$color\" type=\"button\" role='button' name='$nombre' id='$nombre' >";
        if($icono!=''){
            echo "<i class='fa fa-$icono' aria-hidden='true'></i>&nbsp;";
        }    
        echo  "$valor</button>";
        Campos::$Contador+=1;
    }
    

    /**
     * Procedimiento que imprime un boton submit de formulario en la pagina HTML
     * <button name='nombre' type='submit' onclick='alert("Aqui los eventos")'>Valor O Texto</button><br>
     * Si se incluye un valor por defecto
     * @static
     * @param string $nombre el nombre y ID de la caja de texto.
     * @param string $valor (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $texto (opcional) identifica el valor por defecto de la caja de texto (vacio por defecto)
     * @param string $eventos (opcional) html adicional dentro de la etiqueta input (puede ser onclick='' style='' etc)
     */
    public static function submitRed($nombre, $valor, $texto = '', $eventos = '', $ocultar = 0) {
        if ($texto == '') {
            $texto = $valor;
        }
        echo "<button $eventos tabindex='" . Campos::$Contador . "' class=\"btn btn-".C::$ROJO."\" type=\"submit\" name='$nombre' id='$nombre' value='$valor' >$texto</button>";
        if ($ocultar == 1) {
            echo "";
        }

        Campos::$Contador+=1;
    }
    public static function submitGreen($nombre, $valor, $texto = '', $eventos = '', $ocultar = 0) {
        if ($texto == '') {
            $texto = $valor;
        }
        echo "<button $eventos tabindex='" . Campos::$Contador . "' class=\"btn btn-".C::$VERDE."\" type=\"submit\" name='$nombre' id='$nombre' value='$valor' >$texto</button>";
        if ($ocultar == 1) {
            echo "";
        }

        Campos::$Contador+=1;
    }
    
    public static function submit($nombre, $valor, $texto = '', $eventos = '', $ocultar = 0) {
        if ($texto == '') {
            $texto = $valor;
        }
        echo "<button $eventos tabindex='" . Campos::$Contador . "' class=\"btn btn-".C::$AZUL."\" type=\"submit\" name='$nombre' id='$nombre' value='$valor' >$texto</button>";
        if ($ocultar == 1) {
            echo "";
        }

        Campos::$Contador+=1;
    }

    public static function textoConMascara($nombre, $mascara, $valor = '', $tamano = 50, $maximo = 50, $eventos = '') {
        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'' . $maximo . '\'
            size=\'' . $tamano . '\'
            value=\'' . $valor . '\'
            tabindex="' . Campos::$Contador . '"
            ' . $eventos . '
            class="form-control" data-mask="' . $mascara . '" >';
        Campos::$Contador+=1;
        
    }

    public static function oculto($nombre, $valor = '') {
        echo "<input type=hidden name='$nombre' id='$nombre' value='$valor' />";
    }

    /**
     * Imprime un select pasandole de referencia un objeto de la clase ResultSet.
     * Se puede especificar el nombre o id de los campos value y despliegue si estos
     * no son enviados se utilizara la primer columna como id y la segunda como despliegue.
     */
    public static function selectAPartirDeResultSet($nombre, ResultSet $rs, $valor = '', $eventos = '', $campoId = 0, $campoDespliegue = 1) {
        $rs->beforeFirst();
        echo "<select name='$nombre' id='$nombre' tabindex='" . Campos::$Contador . "' class='form-control'  $eventos  >";
        //Ahora comienzo a escribir los options
        echo "<option value='' >-- Seleccione --</option>";
        while ($rs->next()) {
            $id = $rs->getString($campoId);
            $show = $rs->getString($campoDespliegue);
            if ($id == $valor) {
                echo "<option value='$id' selected >$show</option>";
            } else {
                echo "<option value='$id' >$show</option>";
            }
        }
        echo "</select>";
        Campos::$Contador+=1;
    }
    

    public static function selectCatalogo($nombre, $codigoCatalogo, $valor = '', $eventos = '', $campoId = 0, $campoDespliegue = 1) {
        $rs=new ResultSet("SELECT catalago_opciones.codigo,catalago_opciones.descripcion FROM catalago_opciones 
        inner join catalogos on catalogos.catalogo_id = catalago_opciones.catalogo_id
        where catalogos.codigo='".$codigoCatalogo."' order by catalago_opciones.orden");
        C::selectAPartirDeResultSet($nombre,$rs,$valor,$eventos,$campoId,$campoDespliegue);
    }
    public static function selectCatalogoId($nombre, $catalogo_id, $valor = '', $eventos = '', $campoId = 0, $campoDespliegue = 1) {
        $rs=new ResultSet("SELECT catalago_opciones.codigo,catalago_opciones.descripcion FROM catalago_opciones 
        inner join catalogos on catalogos.catalogo_id = catalago_opciones.catalogo_id
        where catalogos.catalogo_id='".$catalogo_id."' order by catalago_opciones.orden");
        C::selectAPartirDeResultSet($nombre,$rs,$valor,$eventos,$campoId,$campoDespliegue);
    }
   
    
    public static function selectAPartirDeResultSetConBusqueda($nombre, ResultSet $rs, $valor = '', $eventos = '', $campoId = 0, $campoDespliegue = 1) {
        //$rs->beforeFirst();
        echo "<select name='$nombre' id='$nombre' tabindex='" . Campos::$Contador . "' class='form-control selectpicker' data-live-search='true'  $eventos  >";
        //Ahora comienzo a escribir los options
        echo "<option value='' >-- Seleccione el Registro Deseado --</option>";
        while ($rs->next()) {
            $id = $rs->getString($campoId);
            $show = $rs->getString($campoDespliegue);
            if ($id == $valor) {
                echo "<option value='$id' selected >$show</option>";
            } else {
                echo "<option value='$id' >$show</option>";
            }
        }
        echo "</select>";
        Campos::$Contador+=1;
    }

    /**
     * Imprime un select pasandole de referencia un array de doble de la clase ResultSet.
     * Se puede especificar el nombre o id de los campos value y despliegue si estos
     * no son enviados se utilizara la primer columna como id y la segunda como despliegue.
     * 
     */
    public static function selectAPartirDeArray($nombre, $rs, $valor = '', $eventos = '') {
        $llaves = array_keys($rs);
        echo "<select name='$nombre' id='$nombre' tabindex='" . Campos::$Contador . "' class='form-control'  $eventos  >";
        //Ahora comienzo a escribir los options
        echo "<option value='' >-- Seleccione --</option>";
        for ($i = 0; $i < count($rs); $i++) {
            $id = $llaves[$i];
            $show = $rs[$id];
            if ($id == $valor) {
                echo "<option value='$id' selected >$show</option>";
            } else {
                echo "<option value='$id' >$show</option>";
            }
        }
        echo "</select>";
        Campos::$Contador+=1;
    }
    
   public static function selectVacio($nombreSelect)
{
    echo "<select name=$nombreSelect id=$nombreSelect tabindex='".Campos::$Contador."' class='text ui-widget-content ui-corner-all'>
          <option value='' >-- Seleccione --</option>
          </select>";
}

    /**
     * AQUI TERMINAN LOS COMPONENTES INPUT/SELECT o de Captura
     *
     * COMIENZAN LOS DE  DESPLIEGUE
     */
    public static function inicioCentrado() {
        //echo '<span style="text-align: center; width:100%;">';
        echo '<center>';
    }

    public static function finCentrado() {
        C::finalCentrado();
    }

    public static function finalCentrado() {
        //echo '</span>';
        echo '</center>';
    }

    /**
     * 
     */
    public static function iniciofieldset() {
        echo '<fieldset class="ui-widget ui-widget-content">';
    }

    public static function finfieldset() {
        echo '</fieldset>';
    }

    public static function leyenda($texto) {
        echo '<legend class="ui-widget-header ui-corner-all"><div>' . $texto . '</div></legend>';
    }

    public static function inicioTabla($propiedades = '') {
        echo '<table class=\'table table-bordered table-condensed table-hover table-striped\' cellpadding=5 cellspacing=0 '  . $propiedades . ' >';
    }
    
    public static function inicioDataTable($id,$grupoBotones,$propiedades = '') {
        
        $js='$(function(){ var tableDT= $("#'.$id.'").dataTable(
            { 
            select:{ style:"multi"},
            buttons: [ 
            {text: "<i class=\\"fa fa-square-o\\"></i> ", className:"btn-metis-5 checkMto", action: function(){ seleccionarFilas(this);}},
            {extend: "excelHtml5", text: "<i class=\\"fa fa-file-excel-o\\"></i> Exportar a Excel",className: "btn-metis-5"},
            {extend: "csvHtml5", text: "<i class=\\"fa fa-file-text-o\\"></i> Descargar CSV",className: "btn-metis-5"},
            {extend: "copyHtml5", text: "<i class=\\"fa fa-files-o\\"></i> Copiar al Portapapeles",className: "btn-metis-5"}
            
            ],
            language: {
            buttons:    {
                copyTitle: "Copia Realizada con Exito",
                copySuccess:    {
                    _: "%d Filas Copiadas",
                    1: "1 fila copiada"
                                }
                        }
                      },
            dom: "Bftrip"
        ';
        if($propiedades!=''){
            $js.=",".$propiedades;
        }
        $js.='
        }
            ); 

}); ';
        Campos::$javascript.=$js;
        
        echo '<table class=\'table table-bordered table-condensed table-hover table-striped display responsive nowrap\' id="'.$id.'"  width="100%" cellpadding=5 cellspacing=0 '  . $propiedades . ' >';
        
    }

    
     public static function inicioDataTableNormal($id,$grupoBotones,$propiedades = '',$showButtons=true) {
        Campos::$javascript.='$(function(){ var tableDT= $("#'.$id.'").dataTable(
            { ';
        if($showButtons===true){
            Campos::$javascript.='            buttons: [ 
            {text: "<i class=\\"fa fa-square-o\\"></i> ", className:"btn-metis-5 checkMto", action: function(){ seleccionarFilas(this);}},
            {extend: "excelHtml5", text: "<i class=\\"fa fa-file-excel-o\\"></i> Exportar a Excel",className: "btn-metis-5"},
            {extend: "csvHtml5", text: "<i class=\\"fa fa-file-text-o\\"></i> Descargar CSV",className: "btn-metis-5"},
            {extend: "copyHtml5", text: "<i class=\\"fa fa-files-o\\"></i> Copiar al Portapapeles",className: "btn-metis-5"}
            ],
            language: {buttons:{copyTitle: "Copia Realizada con Exito",copySuccess:{_: "%d Filas Copiadas",1: "1 fila copiada"}}},
            dom: "Bftrip"';
        }
        Campos::$javascript.='
            
            }
            ); 
}); ';
        
        echo '<table class=\'table table-bordered table-condensed table-hover table-striped display responsive nowrap\' id="'.$id.'"  width="100%" cellpadding=5 cellspacing=0 '  . $propiedades . ' >';
        
    }


    public static function inicioTablaNormal($propiedades = '') {
        echo '<table class="tablaNormal" cellpadding=5 cellspacing=0 ' . $propiedades . ' >';
    }

    public static function inicioEncabezadoTabla($opciones="") {
        echo "<thead $opciones ><tr>";
    }

    public static function finEncabezadoTabla() {
        echo '</tr></thead>';
    }

    public static function columnaEncabezado($contenido, $opciones = '') {
        echo '<th ' . $opciones . ' >' . $contenido . '</th>';
    }

    public static function inicioColumna($opciones = '') {
        echo '<td ' . $opciones . ' >';
    }

    public static function finColumna() {
        echo '</td>';
    }

    

    public static function columna($contenido, $opciones = '') {
        echo '<td ' . $opciones . ' >' . $contenido . '</td>';
    }


    public static function inicioFila($opciones = '') {
        echo '<tr ' . $opciones . ' >';
    }

    public static function inicioFilaSeparado($opciones = '') {
        echo '<tr class="separado" ' . $opciones . ' >';
    }

    public static function finFila() {
        echo '</tr>';
    }

    public static function finTabla() {
        echo '</table>';
    }
    
    public static function filaGrid() {
        echo '<div class="row">';
    }
    
    public static function finFilaGrid() {
        echo '</div>';
    }
    
    public static function columnaGrid($espacio=3, $opciones="") {
        echo '<div class="col-lg-'.$espacio.'" '.$opciones.'>';
    }
    public static function columnaGridOffset($espacio=3,$offset=3, $opciones="") {
        echo '<div class="col-lg-'.$espacio.' offset-lg-'.$offset.'  " '.$opciones.'>';
    }
    
    public static function finColumnaGrid($espacio=3) {
        echo '</div>';
    }
    
    public static function inicioDiv($opciones="") {
        echo '<div '.$opciones.'>';
    }
    public static function finDiv() {
        echo '</div>';
    }
    
    public static function inicioGrupoBotones($id,$align='left') {
        echo '<div class="btn-group" id="'.$id.'" style="float:'.$align.'" >';
    }
    public static function finGrupoBotones() {
        echo '</div>';
    }
    

    public static function mensajeError($mensaje) {
        echo "<div class=\"alert alert-danger\"><p><i class='fa fa-exclamation-circle' aria-hidden='true'></i> $mensaje</font></p></div>";
    }

    public static function mensaje($mensaje) {
        echo "<div class=\"alert alert-info\" ><strong>Atencion </strong><font size=\"2\"> $mensaje</font></p></div>";
    }

    public static function mensajeDisabled($mensaje) {
        echo "<div class=\"alert alert-warning\" style=\"padding: 0 .2em;text-align: left;margin-bottom:5px;\"><p><span class=\"ui-icon ui-icon-info\" style=\"float: left; margin-right: .3em;\"></span><font size=\"2\">$mensaje</font></p></div>";
    }
    
    public static function mensajeAdvertencia($mensaje) {
        echo "<div class=\"alert alert-warning\" ><strong> ADVERTENCIA </strong><font size=\"2\">$mensaje</font></p></div>";
    }

    public static function mensajeAprobado($mensaje) {
        echo "<div class=\"alert alert-success\" ><strong> </strong><font size=\"2\">$mensaje</font></p></div>";
    }

    public static function inicioFilaResaltada($opciones = '') {
        if (Campos::$resaltado == true) {
            echo '<tr class=\'resaltado\'  ' . $opciones . ' >';
        } else {
            echo '<tr  class="noResaltado" ' . $opciones . ' >';
        }
        Campos::$resaltado = !Campos::$resaltado;
    }

    public static function inicioFormulario($action, $method = 'POST', $name = 'FORM1', $eventos = '', $ocultar = 0) {
        echo "<form name='$name' id='$name' action='$action' method='$method' $eventos >";
        if ($ocultar == 1) {
            Campos::$javascript.="
            var funcionSubmit$name=document.getElementById('$name').onsubmit;
                
            $(function(){
            funcionSubmit$name=$('#$name').attr('onsubmit');
                    $('#$name').attr('onsubmit','');
                $('#$name').submit(function(){
                    var res=eval(funcionSubmit$name.replace(';','').replace('return',''));
                    if(res){
                        $('#$name button').attr('disabled','disabled');
                    }else{
                        return false;
                    }
            });
})";
        }
    }
    
    public static function subirImagen($name){
        echo "<input type='file' name='$name'>";
        
    }
    
     public static function inicioFormularioIframe($action,$name = 'FORM1', $eventos = '') {
        $method = 'POST';
        $target=$name."_target";
        echo "<iframe src='javascript:void(0);'  name='$target' style='width:0;height:0;border:0; border:none;' ></iframe>";
        echo "<form name='$name' id='$name' action='$action' target='$target' method='$method' $eventos >";
    }
    
    
    public static function inicioGrupoCampos($titulo,$icono="",$incluirBotones=false,$collapsed=false){
        C::filaGrid();
        C::columnaGrid(12);
        echo "<div class='box' style='margin-bottom:10px;'>
                  <header>";
        if($icono){
            echo "<div class='icons'><i class='fa fa-$icono'></i></div>";
        }
        echo "<h5>$titulo</h5>";
        if($incluirBotones){
        
        echo '<div class="toolbar">
        <nav style="padding: 8px;">
        <a href="javascript:;" class="btn btn-default btn-xs collapse-box">
        <i class="fa fa-minus"></i>
        </a>
        <a href="javascript:;" class="btn btn-default btn-xs full-box">
        <i class="fa fa-expand"></i>
        </a>
        <a href="javascript:;" class="btn btn-danger btn-xs close-box">
        <i class="fa fa-times"></i>
        </a>
        </nav>
        </div>';
            
        }
        if($collapsed){
            echo "</header><div style='padding:10px;' class='body collapse ' aria-expanded='false' >";
        }else{
            echo "</header><div style='padding:10px;' class='body collapse in' >";
        }
        
        
        
    }
    public static function finGrupoCampos(){
       c::finColumnaGrid();
       c::finFilaGrid();
       echo "</div></div>";
        
    }

    public static function finFomulario() {
        echo '</form>';
    }
    
    public static function saltoDeLinea($numero=1) {
        for($i=0;$i<$numero;$i++){
            echo '<br/>';
        }
    }

    public static function focoPrimerElemento() {

        echo '<script>
            $(function(){
            $("input:visible:enabled:first").focus();
            });
            </script>';
    }



    public static function espaciosEnBlanco($cantidad = 1) {
        echo str_repeat("&nbsp;", $cantidad);
    }

    public static function editorHTML($nombre, $contenido = '', $opciones = '', $toolbar = '', $height = '350px') {
        //if(Campos::$incluirEditor===false){
        echo '';
        //  Campos::$incluirEditor=true;
        //}
        echo "<textarea class='ckeditor' id='$nombre'  name='$nombre'>$contenido</textarea>";
        Campos::$javascript.="$(function(){ $('#$nombre').wysihtml5();});";
        Campos::$Contador+=1;
    }

    
    public static function addJavascript($js){
        Campos::$javascript.=$js;
    }
    /**
     *
     *
     *
     *
     * @param $nombre
     * El nombre que tendran los campos. (no incluir las llaves [])
     */
    public static function chequesAPartirDeResultset($nombre, ResultSet $rs, $columnas = 1, $tipoAlineado = 1, $propiedades = '') {
        if ($columnas > 1) {
            Campos::inicioTablaNormal("border=0 $propiedades ");
            Campos::inicioFila();
        }

        $contador = 1;
        $cerrada = false;
        while ($rs->next()) {
            if ($columnas > 1) {
                Campos::inicioColumna();
            }
            $valor = $rs->getString(0);
            $desc = $rs->getString(1);
            $selected = $rs->getString(2);
            if ($selected) {
                $selected = 'checked';
            } else {
                $selected = '';
            }
            if ($tipoAlineado == Campos::$Derecha) {
                echo "<input type=checkbox class='uniform' tabindex='" . Campos::$Contador . "' name='" . $nombre . "[]'  value='$valor' $selected />&nbsp;$desc";
            } else {
                echo "$desc &nbsp;<input tabindex='" . Campos::$Contador . "' type=checkbox class='uniform' name='" . $nombre . "[]'  value='$valor' $selected />";
            }
            if ($columnas > 1) {
                /* echo " ".$contador;
                  echo " ".$columnas;
                  echo " ".($contador % $columnas); */
                Campos::finColumna();

                if (($contador % $columnas) == 0) {
                    //echo 'entro';
                    Campos::finFila();
                    Campos::inicioFila();
                    $cerrada = true;
                } else {
                    $cerrada = false;
                }
                $contador++;
            } else {
                echo "<br>";
            }
            Campos::$Contador;
        }
        if ($columnas > 1) {
            if ($cerrada == false) {
                Campos::finFila();
            }
            Campos::finTabla();
        }
    }



    public static function imprimirValidacionCamposVacios($nombreFormulario, $campos) {
        if (!is_array($campos)) {
            die('<br><br>La información para validar el formulario no corresponde a un array.');
        }

        Campos::$javascript.='$(function(){
            $("#' . $nombreFormulario . '").submit(function(){
                
            });
            });';
    }

    public static function cheque($nombre, $valor, $rotulo = '', $chequeado = false, $tipoAlineado = 1, $propiedades = '') {
        $selected = 'checked';
        if ($chequeado === false) {
            $selected = '';
        }
        if ($tipoAlineado == Campos::$Derecha) {
            echo "<input class='uniform' type=checkbox tabindex='" . Campos::$Contador . "' name='" . $nombre . "' id='" . $nombre . "' value='$valor' $selected $propiedades />&nbsp;$rotulo";
        } else {
            echo "$rotulo &nbsp;<input class='uniform' tabindex='" . Campos::$Contador . "' type=checkbox name='" . $nombre . "' id='" . $nombre . "' value='$valor' $selected $propiedades />";
        }
        Campos::$Contador+=1;
    }

    public static function chequeSiNo($nombre, $rotulo = '', $chequeado = false, $tipoAlineado = 1, $propiedades = '') {
        $selected = 'checked';
        if ($chequeado === false) {
            $selected = '';
        }
        if ($tipoAlineado == Campos::$Izquierda) {
            echo "&nbsp;$rotulo";
        }
        echo "<input tabindex='" . Campos::$Contador . "' type='checkbox' name='chk" . $nombre . "' id='chk" . $nombre . "' value='1' onchange=\"escribirValorCheque_$nombre()\" style='display:none'  $selected  $propiedades />";
        if ($tipoAlineado == Campos::$Derecha) {
            echo "&nbsp;$rotulo";
        }
        C::addJavascript("$(function(){"
                . "$('#chk$nombre').bootstrapSwitch({onText:'Si',offText:'No'});"
                . "});");
        if ($chequeado) {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='1' >";
        } else {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='0' >";
        }
        ?><script type="text/javascript">
                        function escribirValorCheque_<?php echo $nombre; ?>(){
                            var chq=$("#chk<?php echo $nombre; ?>").prop("checked");
                            if(chq==true){
                                $("#<?php echo $nombre; ?>").val(1);
                            }else{
                                $("#<?php echo $nombre; ?>").val(0);
                            }
                        }
                        </script>
        <?php
        Campos::$Contador+=1;
    }
    
    public static function chequeSiNoSN($nombre, $rotulo = '', $chequeado = false, $tipoAlineado = 1, $propiedades = '') {
        $selected = 'checked';
        if ($chequeado === false) {
            $selected = '';
        }
        if ($tipoAlineado == Campos::$Izquierda) {
            echo "&nbsp;$rotulo";
        }
        echo "<input tabindex='" . Campos::$Contador . "' type='checkbox' name='chk" . $nombre . "' id='chk" . $nombre . "' value='1' onchange=\"escribirValorCheque_$nombre()\" style='display:none'  $selected  $propiedades />";
        if ($tipoAlineado == Campos::$Derecha) {
            echo "&nbsp;$rotulo";
        }
        C::addJavascript("$(function(){"
                . "$('#chk$nombre').bootstrapSwitch({onText:'Si',offText:'No'});"
                . "});");
        if ($chequeado) {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='S' >";
        } else {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='N' >";
        }
        ?><script type="text/javascript">
                        function escribirValorCheque_<?php echo $nombre; ?>(){
                            var chq=$("#chk<?php echo $nombre; ?>").prop("checked");
                            if(chq==true){
                                $("#<?php echo $nombre; ?>").val('S');
                            }else{
                                $("#<?php echo $nombre; ?>").val('N');
                            }
                        }
                        </script>
        <?php
        Campos::$Contador+=1;
    }

    
    public static function chequeActivo($nombre, $rotulo = '', $chequeado = false, $tipoAlineado = 1, $propiedades = '') {
        $selected = 'checked';
        if ($chequeado === false) {
            $selected = '';
        }
        if ($tipoAlineado == Campos::$Izquierda) {
            echo "&nbsp;$rotulo";
        }
        echo "<input tabindex='" . Campos::$Contador . "' type='checkbox' name='chk" . $nombre . "' id='chk" . $nombre . "' value='1' onchange=\"escribirValorCheque_$nombre()\" style='display:none'  $selected  $propiedades />";
        if ($tipoAlineado == Campos::$Derecha) {
            echo "&nbsp;$rotulo";
        }
        C::addJavascript("$(function(){"
                . "$('#chk$nombre').bootstrapSwitch({onText:'Si',offText:'No'});"
                . "});");
        if ($chequeado) {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='A' >";
        } else {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='I' >";
        }
        ?><script type="text/javascript">
                        function escribirValorCheque_<?php echo $nombre; ?>(){
                            var chq=$("#chk<?php echo $nombre; ?>").prop("checked");
                            if(chq==true){
                                $("#<?php echo $nombre; ?>").val('A');
                            }else{
                                $("#<?php echo $nombre; ?>").val("I");
                            }
                        }
                        </script>
        <?php
        Campos::$Contador+=1;
    }

     
    public static function chequeMasculinoFemenino($nombre, $sexo = 'M', $propiedades = '') {
        $selected = 'checked';
        if ($sexo === 'F') {
            $selected = '';
        }
        echo "<input tabindex='" . Campos::$Contador . "' type='checkbox' name='chk" . $nombre . "' id='chk" . $nombre . "' value='1' onchange=\"escribirValorCheque_$nombre()\" style='display:none'  $selected  $propiedades />";

        C::addJavascript("$(function(){"
                . "$('#chk$nombre').bootstrapSwitch({onText:'Masculino',offText:'Femenino',offColor:'danger'});"
                . "});");
        if ($sexo === 'M') {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='M' >";
        } else {
            echo "<input type=hidden name='" . $nombre . "' id='" . $nombre . "' value='F' >";
        }
        ?><script type="text/javascript">
                        function escribirValorCheque_<?php echo $nombre; ?>(){
                            var chq=$("#chk<?php echo $nombre; ?>").prop("checked");
                            if(chq==true){
                                $("#<?php echo $nombre; ?>").val('M');
                            }else{
                                $("#<?php echo $nombre; ?>").val("F");
                            }
                        }
                        </script>
        <?php
        Campos::$Contador+=1;
    }

    
    
    
    
    
    public static function imagen($url, $propiedades = '', $alt = '') {
        echo "<img src='$url' border=0  title='$alt' $propiedades />";
    }

    public static function inicioTabs($otros = "") {
        echo '<ul class="nav nav-tabs" >';
    }

    public static function tab($texto, $url, $seleccionado = false, $opciones = '', $opcionesTab = "") {
        $estilos = "tab-normal";
        if ($seleccionado == true) {
            $estilos = "active";
        }
        echo "<li role='presentation' class='$estilos' $opcionesTab ><a href=\"$url\" $opciones >$texto</a></li>";
    }

    public static function finTabs() {
        echo '</ul>';
    }

    public static function hora($nombre, $valor = '', $eventos = '') {

        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'5\'
            size=\'7\'
            value=\'' . $valor . '\' ' . $eventos . '
            tabindex=\'' . Campos::$Contador . '\'
            class="text ui-widget-content ui-corner-all" >';
        Campos::$javascript.="
            $(function(){
                $('#$nombre').timepicker({
	timeFormat: 'hh:mm'});
            });
        ";
        Campos::$Contador+=1;
    }

    public static function fechaHora($nombre, $valor = '', $restriccion = null) {
        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id=\'' . $nombre . '\'
            maxlength=\'17\'
            size=\'20\'
            tabindex=\'' . Campos::$Contador . '\'
            value=\'' . $valor . '\'   class="text ui-widget-content ui-corner-all"  >';
        Campos::$Contador+=1;
        //Ahora imprimo el javascript

        Campos::$javascript.= '
              $(function(){
                $("#' . $nombre . '").datetimepicker({changeMonth: true,changeYear: true';
        if ($restriccion != null) {
            Campos::$javascript.= ',' . $restriccion;
        }
        Campos::$javascript.=',  showOn: \'button\', buttonImage: \'/core/imagenes/calendario.png\',buttonImageOnly: true,buttonText:\'Seleccione la fecha desde un calendario\'});
$("#' . $nombre . '").mask("99/99/9999 99:99");
            
});
             ';
    }

    public static function editorHTMLPopUpSoloTexto($nombre, $valor = '', $titulo = '') {
        echo "<input type='text'><button class='modalInput' type='button' rel='#div$nombre'>...</button>";
        echo "<div class='modal' id='div$nombre'>$valor<br><br><br><center><button class='close' type='button' >Aceptar</button><center></div>";
        echo "<style>
        #div$nombre {
		background-color:#fff;
		display:none;
		width:800px;
		padding:15px;
		text-align:left;
                z-index:5019;
		border:2px solid #609ecd;
		-moz-border-radius:6px;
                -moz-box-shadow: 0 0 25px  rgb(0,0,0);
	}
        </style>";
        echo "<script type=\"text/javascript\">
        var triggers;
        $(function(){
            
        //Overlay
        $('.modalInput').overlay({
            closeOnClick:false
            });
        });
	</script>";
        ?>
                    
        <?php
    }

    public static function editorHTMLPopUp($nombre, $valor = '', $titulo = '') {
        if ($valor == '') {
            $valor = 'Inserte el contenido aqui';
        }
        $valor = str_replace("\\", "\\\\", $valor);
        $valor = str_replace('"', '\\"', $valor);
        $valor = str_replace("'", "\"", $valor);
        $valor = str_replace("\n", "", $valor);

        echo '<input type=\'text\'
            name=\'' . $nombre . '\'
            id="' . $nombre . '"
            maxlength=\'80000\'
            size=\'25\'
            value=\'' . $valor . '\'
            class="text ui-widget-content ui-corner-all" >';
        echo "<button id='btn$nombre' class=\"ui-state-default ui-corner-all \" type=\"button\"  type='button' rel='#capaEditorHtmlGenerico'>...</button>&nbsp;&nbsp;&nbsp;";
        echo "
        <button id='btnVistaPrevia$nombre' class=\"ui-state-default ui-corner-all \" onclick=\"vistaPrevia$nombre()\" type=\"button\"  type='submit' >Vista Previa</button>";
        echo "";
        echo "";
        echo "<script type='text/javascript'>
            function vistaPrevia$nombre(){
                var valor=$(\"#$nombre\").val();
                $(\"body\").append(\"<div id='vistaPrevia$nombre'><form id='frmVistaPrevia$nombre' action='/core/utilidades/generarPDFCampo.php' method='post' target='_blank' >\"+
                \"<input type='hidden' name='valorImprimir' id='valorImprimir$nombre' />\"+
                \"</form></div>\");
                $(\"#valorImprimir$nombre\").val(valor);
                $(\"#frmVistaPrevia$nombre\").submit();
                $(\"#vistaPrevia$nombre\").remove();
            }
                
        $(function(){
        $('#ContenidoEditorHtmlGenerico').html('" . $valor . "');
        $('#$nombre').change(function(){
            $('#ContenidoEditorHtmlGenerico').html($('#$nombre').val());
        });
         $('#btn$nombre').overlay({
            closeOnClick:false,
            onClose: function(){ $('#$nombre').val($('#ContenidoEditorHtmlGenerico').html());$('#ContenidoEditorHtmlGenerico').tinymce().hide(); },
            onBeforeLoad: function(){ $('#ContenidoEditorHtmlGenerico').tinymce().show();$('#ContenidoEditorHtmlGenerico').html($('#$nombre').val()); }
            });
        });
	</script>";
    }

    public static function persona($nombre, $valor = '') {
        $nombrePersonaDesplegado = "";
        if ($valor != '') {
            $resObtenerValorPersona = new ResultSet("select nombrePersona($valor) ");
            $resObtenerValorPersona->next();
            $nombrePersonaDesplegado = $resObtenerValorPersona->getString(0);
        }
        C::texto("$nombre", $valor, 5, 5, 'READONLY');
        echo "<span id='" . $nombre . "_nombre' >$nombrePersonaDesplegado</span>";
        C::boton("bPersona", 'Buscar/Ver', " onclick=\"buscarPersona('$nombre');\" ");
    }

    public static function titulo($titulo) {
        echo "<center><h2>$titulo</h2></center>";
    }

    public static function subTitulo($titulo) {
        echo "<center><h3>$titulo</h3></center>";
    }

    public static function radioButton($nombre, $valor, $texto = '', $seleccionado = false, $eventos = '') {
        echo "<input type='radio' name='$nombre' id='$nombre' value='$valor' tabindex='" . Campos::$Contador . "' $eventos ";
        if ($seleccionado != false) {
            echo "checked";
        }
        echo " > $texto";
        Campos::$Contador+=1;
    }
    
    
    public static function inicioBotonDropDown($nombre,$texto,$icono=''){
        echo "<div class='dropdown'>
            <button class='btn btn-primary dropdown-toggle' type='button' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
            if($icono!=''){ echo "<span class='fa fa-$icono'></span>";}
            echo "&nbsp;$texto&nbsp;<span class='caret'></span></button>
            <div class='dropdown-menu' aria-labelledby='dropdownMenuButton'>";
    }
    
    public static function opcionBotonDropDown($texto,$url,$eventos=""){
        echo "<a class='dropdown-item' href='$url' $eventos >$texto</a><br>";
    }
    
    public static function finBotonDropDown(){
        echo "</div></div>";
    }

   

}

class c extends Campos {
    
}

$campos = new Campos();
        ?>
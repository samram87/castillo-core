/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var urlsVisitadas=new Array();
var posicionActual=0;
urlsVisitadas[0]=window.location.toString();
var ultimaUrl=window.location.toString();



function cargarContenido(url) {
    //alert(url);
    //$("#efectoCarga").hide(100);
    urlsVisitadas[urlsVisitadas.length] = url;
    ultimaUrl = url;
    window.location=url;
}
function recargarContenido() {

    var txt = Math.random();
    var url = ultimaUrl;
    if (url.indexOf("?") == -1) {
        url = url + '?rndcache=' + txt;
    } else {
        url = url + '&rndcache=' + txt;
    }
    cargarContenido(url);
}
function recargarContenidoSinCache() {
    cargarContenido(ultimaUrl);
}
function volverAlAnterior() {
    if (urlsVisitadas.length == 1) {
        history.go(-1);
    } else {
        cargarContenido(urlsVisitadas[urlsVisitadas.length - 2]);
    }
}

function imprimirReporte(contenido) {
    window.open("http://192.100.1.8:8080/reportes/Reporte.xls?" + contenido);
}
function abrirFrameGenerico(url){
    $('#iframeModal').prop("src",url);
    $('#divModalIframe').modal('show');
}

function alerta(mensaje){
    $("#contenidoAlerta").html(mensaje);
    $('#divModalAlerta').modal('show');
}




window.onload = function () {
    $("*[tabindex=1]").focus();
};
//Final Script

function validarFecha(elemento,maxima){
    if(elemento.value=='__/__/____'){
        elemento.value='';
    }
    
    
    if(elemento.value!=''){
        if(!isDate(elemento.value)){
            alertaFoco("La fecha digitada no es valida.",elemento);
        }
        if(maxima==undefined){
            maxima='';
        }
        
        if(maxima!=''){
            var fec=maxima.split('/');
            var fechaHoy=new Date(fec[2],fec[1],fec[0]);
            fec=elemento.value.split('/');
            var fechaValid=new Date(fec[2],fec[1],fec[0]);
            if(fechaValid>fechaHoy){
                alertaFoco("La fecha digitada sobrepasa el limite permitido.",elemento);
            }
        }
    }
}

function validarHora(elemento){
    if(elemento.value=='__:__'){
        elemento.value='';
    }
    if(elemento.value!=''){
        var valor=elemento.value;
        if(valor!=''){
            if(valor.charAt(':')!=-1){
                var ar=valor.split(":");
                var ret=true;
                if(ar[0]>23){
                    ret=false;
                }
                if(ar[1]>59){
                    ret=false;
                }
                if(!ret){
                    alertaFoco("El valor escrito no es un formato de hora correcto. Recuerde que debe estar en formato 24 horas.",elemento);
                }
            }
        }
    }
}

function validarNumero(elemento){
    var valor=elemento.value;
    if(isNaN(valor)){
        alertaFoco("Los caracteres ingresados no corresponden a un n&uacute;mero.<br><i>Recuerde utilizar el caracter '.' para separar decimales.</i>",elemento);
    }
}

function validarEntero(elemento){
    var valor=elemento.value;
    if(!isInteger(valor)){
        alertaFoco("Los caracteres ingresados no corresponden a un n&uacute;mero entero.<br>",elemento);
    }
}


var dtCh= "/";
var minYear=1900;
var maxYear=2100;
function isInteger(s){
    var i;
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (((c < "0") || (c > "9"))){
            return false;
        }
    }
    return true;
}

function stripCharsInBag(s, bag){
    var i;
    var returnString = "";
    for (i = 0; i < s.length; i++){   
        var c = s.charAt(i);
        if (bag.indexOf(c) == -1){returnString += c;}
    }
    return returnString;
}

function daysInFebruary (year){
    // February has 29 days in any year evenly divisible by four,
    // EXCEPT for centurial years which are not also divisible by 400.
    return (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 );
}
function DaysArray(n) {
    for (var i = 1; i <= n; i++) {
        this[i] = 31
        if (i==4 || i==6 || i==9 || i==11) {
            this[i] = 30
        }
        if (i==2) {
            this[i] = 29
        }
    }
    return this
}

function isDate(dtStr){
    var daysInMonth = DaysArray(12)
    var pos1=dtStr.indexOf(dtCh)
    var pos2=dtStr.indexOf(dtCh,pos1+1)
    var strDay=dtStr.substring(0,pos1)
    var strMonth=dtStr.substring(pos1+1,pos2)
    var strYear=dtStr.substring(pos2+1)
    strYr=strYear
    if (strDay.charAt(0)=="0" && strDay.length>1) strDay=strDay.substring(1)
    if (strMonth.charAt(0)=="0" && strMonth.length>1) strMonth=strMonth.substring(1)
    for (var i = 1; i <= 3; i++) {
        if (strYr.charAt(0)=="0" && strYr.length>1) strYr=strYr.substring(1)
    }
    month=parseInt(strMonth)
    day=parseInt(strDay)
    year=parseInt(strYr)
    if (pos1==-1 || pos2==-1){
        return false
    }
    if (strMonth.length<1 || month<1 || month>12){
        return false
    }
    if (strDay.length<1 || day<1 || day>31 || (month==2 && day>daysInFebruary(year)) || day > daysInMonth[month]){
        return false
    }
    if (strYear.length != 4 || year==0 || year<minYear || year>maxYear){
        return false
    }
    if (dtStr.indexOf(dtCh,pos2+1)!=-1 || isInteger(stripCharsInBag(dtStr, dtCh))==false){
        return false
    }
    return true
}

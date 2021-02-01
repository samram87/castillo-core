<?php include "core/estatico/encabezado.php";
include "core/inventario/odbcCnx.php";

function isMobile() {
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}

C::importarCss("/core/inventario/select2/css/select2.min.css");

C::importarJS("/core/inventario/select2/js/select2.min.js");
C::inicioFormularioIframe("/core/inventario/save.php?save=1","form1","onsubmit='validar();'");
C::oculto("save","1");
C::importarCss("/core/inventario/inventario.css");
C::filaGrid();
c::columnaGrid(12);
C::boton("<- Regresar", "<- Regresar","onclick='cargarContenido(\"/core/inventario/dashboard.php\")'");
C::finColumnaGrid();
c::finFilaGrid();
c::inicioGrupoCampos("Inventario Fisico","id-badge");

    c::filaGrid();
    Campos::columnaGrid(6);
    echo "<strong>Producto *</strong>";
    Campos::finColumnaGrid();
    Campos::columnaGrid(6);
    $rs=new ResultSetODBC("select CODI_ARTI, STRING(CODI_ARTI,' - ', NOMB_ARTI) as nombre from MAES_ARTI where CODI_ARTI in (select CODI_ARTI from PREC_ARTI_UNID ) order by CODI_ARTI");
    if(isMobile()){
        c::selectAPartirDeResultSet("CODI_ARTI",$rs,"","onchange='getUOM()'","CODI_ARTI","nombre");    
        c::addJavascript("$(document).ready(function() { $('#CODI_ARTI').select2(); });");
    }else{
        c::selectAPartirDeResultSetConBusqueda("CODI_ARTI",$rs,"","onchange='getUOM()'","CODI_ARTI","nombre");
    }
    
    Campos::finColumnaGrid();
    c::finFilaGrid();c::saltoDeLinea();

    c::filaGrid();
    Campos::columnaGrid(6);
    echo "<strong>Existencias</strong>";
    Campos::finColumnaGrid();
    Campos::columnaGrid(6,"id='exis'");
    echo "<span style='font-size:0.8em;color:gray'>Seleccione un producto para ver existencias</span>";
    Campos::finColumnaGrid();
    c::finFilaGrid();c::saltoDeLinea();
    
    c::filaGrid();
    Campos::columnaGrid(6);
    echo "<strong>Unidad de Medida *</strong>";
    Campos::finColumnaGrid();
    Campos::columnaGrid(6,"id='uom'");
    $res=new ResultSet("select * from configuracion where id_empresa=-10");
    C::selectAPartirDeResultset("CODI_MEDI",$res);
    Campos::finColumnaGrid();
    c::finFilaGrid();c::saltoDeLinea();

    c::filaGrid();
    Campos::columnaGrid(6);
    echo "<strong>Cantidad Encontrada *</strong>";
    Campos::finColumnaGrid();
    Campos::columnaGrid(6,"id='uom'");
    Campos::entero("CANT_DIGI");
    Campos::finColumnaGrid();

    c::finFilaGrid();c::saltoDeLinea();

    c::filaGrid();
    Campos::columnaGrid(12);
    Campos::inicioCentrado();
    C::submit("Guardar", "Guardar");
    Campos::finCentrado();
    Campos::finColumnaGrid();

    c::finFilaGrid();c::saltoDeLinea();

    if(isset($_REQUEST['save'])){
        c::filaGrid();
        C::mensajeAprobado("El Registro Fue Guardado Con Exito");
        c::finFilaGrid();c::saltoDeLinea();
    }
c::finGrupoCampos();
?>
<script type="text/javascript">
function getUOM(){
    var idProd=$("#CODI_ARTI").val();
    if(idProd==''){
        $("#uom").html("<span style='font-size:0.8em;color:gray'>Seleccione un producto para ver sus medidas</span>");
        $("#exis").html("<span style='font-size:0.8em;color:gray'>Seleccione un producto para ver existencias</span>");
    }else{
        $.get("getuom.php?CODI_ARTI="+idProd, function(data, status){
        $("#uom").html(data);
        
        });
        $.get("getexis.php?CODI_ARTI="+idProd, function(data, status){
            $("#exis").html(data);

        });
    }
    
}

function validar(){
    var idProd=$("#CODI_ARTI").val();
    var idMedi=$("#CODI_MEDI").val();
    var cnt=$("#CANT_DIGI").val();
    if(idProd=="" || idMedi=="" || cnt==""){
        alerta("Por favor ingrese todos los datos, los tres campos son requeridos");
        return false;
    }else{
        return true;
    }
}
</script>
<?php


include "core/estatico/pie.php";
<?php
/*
 * Esta pagina maneja los reportes segun el perfil del usuario
 */
include 'core/estatico/encabezado.php';
;
include 'core/funciones/reportes.php';
$URL_SERVER_REPORTES = $_SERVER['SERVER_NAME'] . ":8080";  //$_SERVER["SERVER_ADDR"].":8080";
//$URL_SERVER_REPORTES= $_SERVER['SERVER_NAME'].":8080";
//target='ventanaReporte'
Campos::inicioFormulario("http://" . $URL_SERVER_REPORTES . "/reportes/Reporte.pdf", "POST", "formaReportes", " target='frameReportes' "); //http://192.100.1.8:8080
//Campos::inicioFormulario("/core/sires-web/Entrevistas/Pruebas.php","POST","formaReportes"," target='frameReportes' ");

echo "<h2>Reportes del Sistema</h2>";


Campos::filaGrid();
Campos::columnaGrid();
echo "Reporte a consultar";
Campos::finColumnaGrid();
Campos::columnaGrid();

imprimirListadoDeReportes();

Campos::finColumnaGrid();
Campos::finFilaGrid();




//Div se carga por ajax
echo "<div id='capturaReporte' style='width:100%;display:none' ></div>";

//finaliza el formulario
c::finFomulario();
echo "<br>";


echo "";

include 'core/estatico/pie.php';
?>
<script type="text/javascript">

    $(function () {

        $('#idReporte').change(function () {
            if (this.value != '') {
                //alert("asdasdasd");
                var url = "/core/reportes/capturaReporte.php?idReporte=" + this.value;
                var html = $.ajax({type: "GET", url: url, async: false}).responseText;
                //alert(html);
                $("#capturaReporte").html(html);
                $("#capturaReporte").show();
                $(".datepicker").datepicker({format: "dd/mm/yyyy"}); 
            } else {
                //alert("NOOOOOOO");
                $("#capturaReporte").hide();
            }
        });

        //Evento Change del combo idReporte

    });


    function validar(formato) {
        if ($("#idReporte").val() == '') {
            alerta("Debe seleccionar el reporte deseado.");
            return false;
        } else {
            if(formato=="pdf"){
                exportarApdf();
            }else if(formato=="xlsx"){
                exportarAExcel();
            }else if(formato=="docx"){
                exportarWord();
            }
            return true;
        }
    }


    var reporte = '/core/sires-web/Entrevistas/Pruebas.php';
    function EnviarReporte() {
        parent.window.location = reporte;
    }


//se mandan a llamar desde capturarReporte.php
    function exportarAExcel() {
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte.xlsx");
        $("#formaReportes").removeAttr("target");
        $("#formaReportes").submit();


        //valores por defecto...
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte");
        $("#formaReportes").attr("target", '_blank');
    }

    function exportarApdf() {
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte.pdf");
        $("#formaReportes").attr("target", '_blank');
        $("#formaReportes").submit();


        //valores por defecto...
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte");
        $("#formaReportes").attr("target", '_blank');
    }

    function exportarATexto() {

        $("#formaReportes").attr("action", "/core/reportes/generarATexto.php");
        $("#formaReportes").attr("method", 'POST');
        $("#formaReportes").removeAttr("target");
        $("#formaReportes").submit();

        //valores por defecto
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte");
        $("#formaReportes").attr("method", 'GET');
        $("#formaReportes").attr("target", '_blank');

    }

    function exportarWord() {
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte.docx");
        $("#formaReportes").removeAttr("target");
        $("#formaReportes").submit();


        //valores por defecto
        $("#formaReportes").attr("action", "http://<?php echo $URL_SERVER_REPORTES; ?>/reportes/Reporte");
        $("#formaReportes").attr("method", 'GET');
        $("#formaReportes").attr("target", '_blank');
    }

</script>


<?php 


?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

require_once('core/lib/dompdf/dompdf_config.inc.php');
$html =$_REQUEST["valorImprimir"];
$html=utf8_decode($html);
$html=str_replace("ú", "&uacute;", $html);
$html=str_replace("á", "&aacute;", $html);
$html=str_replace("é", "&eacute;", $html);
$html=str_replace("í", "&iacute;", $html);
$html=str_replace("ó", "&oacute;", $html);
$html=str_replace("Á", "&Áacute;", $html);
$html=str_replace("É", "&Eacute;", $html);
$html=str_replace("Í", "&iacute;", $html);
$html=str_replace("Ó", "&Oacute;", $html);
$html=str_replace("Ú", "&Uacute;", $html);
$html=str_replace("ñ", "&ntilde;", $html);
$html=str_replace("Ñ", "&Ntilde;", $html);
$html='<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title>Prueba 2</title>
<style type="text/css">
body{
margin-top:20px;
margin-left:40px;
margin-right:40px;
margin-bottom:40px;
}
</style>
</head>
<body>'.$html.'</body></html>';
$dompdf = new DOMPDF();
$dompdf->load_html($html);
$dompdf->render();
$dompdf->stream("vistaPrevia.pdf",array('Attachment' => 0));
//echo $html;
?>
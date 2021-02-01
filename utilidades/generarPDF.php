<?php
error_reporting(E_ALL);
ini_set("display_errors", 0);

require_once('core/lib/dompdf/dompdf_config.inc.php');
      $html =$_REQUEST[$_REQUEST["nombreCampo"]];
      $dompdf = new DOMPDF();
      if(isset($_GET["imagen"])){
        $dompdf->load_html("<img src='../..".$_GET["imagen"]."' border=0 width='800' height='1030'  />");
      }else{
        $dompdf->load_html($html);
      }
      $dompdf->render();
      $dompdf->stream("vistaPrevia.pdf",array('Attachment' => 0));
?>
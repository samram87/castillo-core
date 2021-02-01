<?php
include 'core/clases/include.php';
$val=$_GET["valor"];
$nombreTabla=$_GET["nombreTabla"];
$nombreCampo=$_GET["nombreCampo"];

$sel="select count(1) from $nombreTabla where $nombreCampo='$val'";
$rs=new ResultSet($sel);
$rs->next();
echo $rs->getInt(0);

?>

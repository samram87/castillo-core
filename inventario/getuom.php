<?php include "core/clases/include.php";
include "core/inventario/odbcCnx.php";

$_REQUEST["CODI_ARTI"];

$sql="select CODI_MEDI, NOMB_MEDI from TIPO_MEDI where CODI_MEDI in (select CODI_MEDI from PREC_ARTI_UNID where CODI_ARTI='".$_REQUEST["CODI_ARTI"]."')";
$rs=new ResultSetODBC($sql);
c::selectAPartirDeResultSet("CODI_MEDI",$rs,"","","CODI_MEDI","NOMB_MEDI");
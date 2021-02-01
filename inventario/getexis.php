<?php include "core/clases/include.php";
include "core/inventario/odbcCnx.php";

$_REQUEST["CODI_ARTI"];

$sql="select a.VALO_EXIS,c.NOMB_MEDI from "
        . " EXIS_TENC a inner join MAES_ARTI b on b.CODI_ARTI=a.CODI_ARTI "
        . " inner join TIPO_MEDI c on c.CODI_MEDI=b.CODI_MEDI "
        . " WHERE a.CODI_BODE= '00002' "
        . " AND a.CODI_ARTI='".$_REQUEST["CODI_ARTI"]."'";
$rs=new ResultSetODBC($sql);
while($rs->next()){
     echo $rs->getString("NOMB_MEDI").": <strong>".$rs->getFloat("VALO_EXIS")."</strong><br>"; 
}
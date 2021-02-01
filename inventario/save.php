<?php include "core/clases/include.php";
include "core/inventario/odbcCnx.php";

$_REQUEST["CODI_ARTI"];
$_REQUEST["CODI_MEDI"];
$_REQUEST["CANT_DIGI"];


$sql=" insert into DETA_INVE_FISI (
    ID_ENCA_INVE,
    CODI_ARTI,
    CODI_MEDI,
    CANT_DIGI,
    CANT_INVE,
    ESTA_DETA_INVE,
    FECH_DETA_INVE,
    FECH_ACTU,USUA_ACTU)
    values (
        (select top 1 ID_ENCA_INVE from enca_inve_fisi where ESTA_INVE='A' ),
        '".$_REQUEST["CODI_ARTI"]."',
        '".$_REQUEST["CODI_MEDI"]."',
        '".$_REQUEST["CANT_DIGI"]."',
        0,'D',NOW(),NOW(),'".$_SESSION['idUsuario']."'
    )";

    $cnxOdbc->ejecutar($sql);
?>
<script type="text/javascript">parent.cargarContenido("inventariofisico.php?save=1");</script>

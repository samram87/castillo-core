<?php include "core/estatico/encabezado.php";
include "core/inventario/odbcCnx.php";




c::titulo("Inventario Fisico");
C::importarCss("/core/inventario/inventario.css");
C::filaGrid();
c::columnaGrid(12);
C::boton("<- Regresar", "<- Regresar","onclick='cargarContenido(\"/core/inventario/dashboard.php\")'");
C::finColumnaGrid();
c::finFilaGrid();
if(isset($_REQUEST["del"])){
    $sqlUpd="update DETA_INVE_FISI set ESTA_DETA_INVE='E' where ID_DETA_INVE=".$_REQUEST["del"]."";
    //$cnxOdbc=new ConexionODBC();
    $cnxOdbc->ejecutarActualizacion($sqlUpd);

    C::filaGrid();
    C::columnaGrid(12);
    C::mensajeAprobado("El registro fue elimnado con exito");
    C::finColumnaGrid();
    c::finFilaGrid();
}



$sql="SELECT IV.ID_DETA_INVE, 
A.CODI_ARTI, 
A.NOMB_ARTI, 
TIPO_MEDI.NOMB_MEDI,
CANT_DIGI, 
IV.FECH_ACTU, 
IV.USUA_ACTU
FROM DETA_INVE_FISI as IV inner join MAES_ARTI as A on IV.CODI_ARTI=A.CODI_ARTI
inner join TIPO_MEDI on TIPO_MEDI.CODI_MEDI=IV.CODI_MEDI 
where IV.ESTA_DETA_INVE='D' and IV.ID_ENCA_INVE=(select top 1 ID_ENCA_INVE from enca_inve_fisi where ESTA_INVE='A' )
order by  IV.FECH_ACTU DESC
";

$r=new ResultSetODBC($sql);


C::filaGrid();
Campos::columnaGrid(12);
c::inicioDataTableNormal("listadoEmpleados","divbotones");
c::inicioEncabezadoTabla();
c::columna("Nombre Articulo");
c::columna("Codigo Articulo");
c::columna("Unidad de Medida");
c::columna("Cantidad Encontrada");
c::columna("Usuario Ingresó");
c::columna("Fecha Lectura");
C::columna("Acciones");
c::finEncabezadoTabla();



while($r->next()){
    c::inicioFila(" style='cursor:hand;'");
    c::columna($r->getString("NOMB_ARTI"));
    c::columna($r->getString("CODI_ARTI"));
    c::columna($r->getString("NOMB_MEDI"));
    c::columna($r->getString("CANT_DIGI"));
    $res=new ResultSet("select NombreDeusuario(".$r->getString("USUA_ACTU").")");
    $res->next();
    c::columna($res->getString(0));
    c::columna($r->getDateTime("FECH_ACTU"));
    C::inicioColumna();
    C::botonColor("del", "Eliminar", C::$ROJO,"onclick='if(confirm(\"¿Esta seguro que desea eliminar este registro?\")){cargarContenido(\"listadoInventario.php?del=".$r->getString("ID_DETA_INVE")."\")}'");
    C::finColumna();
    c::finFila();
}
c::finTabla();

c::finColumnaGrid();
c::finFilaGrid();




include "core/estatico/pie.php";
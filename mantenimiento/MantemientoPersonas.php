<?php
include 'core/clases/include.php';
//Libero las variables de session utilizadas
//Por si acaso ocurre algun percance.
session_unregister("filtroMantenimiento_PER001");
session_unregister("noFiltrar_PER001");
session_unregister("retornar_PER001");
session_unregister("titulo_PER001");
session_unregister("botones_PER001");
session_unregister("busquedaP_PrimerNombre");
session_unregister("busquedaP_SegundoNombre");
session_unregister("busquedaP_PrimerApellido");
session_unregister("busquedaP_SegundoApellido");
session_unregister("busquedaP_idUbicacionGeograficaNacimiento");
session_unregister("busquedaP_idUbicacionGeograficaNacionalidad");
session_unregister("busquedaP_FechaNacimiento");
header("location:/core/mantenimientos/listadoDeTabla.php?idMantenimientoDeTabla=PER001");
?>

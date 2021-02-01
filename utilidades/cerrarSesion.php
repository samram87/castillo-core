<?php
//session_start();

include 'core/clases/include.php';

$query = "UPDATE accesos SET sesion = 'sesion destruida', sesioncerrada = '1', fechacierre = NOW() WHERE idAccesos = $_SESSION[idSessionDia]";
$conexion->ejecutar($query);

session_destroy();
header("location:/core/index.php");
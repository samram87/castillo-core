<?php

$sinSesion = true;
header("Access-Control-Allow-Origin: *");
//header('Content-Type: application/json');
include 'core/clases/include.php';




$idUser = $_REQUEST["idUsuario"];
$cntPedidos = $_REQUEST["pedidos"];
$cntNoVentas = $_REQUEST["noventas"];
$cntDetalle = $_REQUEST["totaldetalle"];
$cntMayoreo = $_REQUEST["totalmayoreo"];
$ventaInsuficiente = $_REQUEST["ventaInsuficiente"];
$primerPedido = $_REQUEST["primerPedido"];
$ultimoPedido = $_REQUEST["ultimoPedido"];
$totalA=$_REQUEST["totalA"];
$totalB=$_REQUEST["totalB"];
$totalC=$_REQUEST["totalC"];

$inexA=$_REQUEST["inexistenciaA"];
$inexB=$_REQUEST["inexistenciaB"];
$inexC=$_REQUEST["inexistenciaC"];

$del="delete from pedidos.cierre_dia where CODI_VEND=(select codi_vend from pedidos.usuario_vendedor where id_usuario='$idUser' AND codi_vend IS NOT NULL LIMIT 1)
and fecha=curdate()
";
$conexion->ejecutarActualizacion($del);

$ins="INSERT INTO pedidos.cierre_dia
(
CODI_VEND,
fecha,
pedidos_realizados,
no_ventas,
ventas_mayoreo,
ventas_detalle,
ventas_insuficientes,
primer_pedido,
ultimo_pedido,
total_a,total_b,total_c,
inexistencia_a,inexistencia_b,inexistencia_c
)
VALUES (
(select codi_vend from pedidos.usuario_vendedor where id_usuario='$idUser' AND codi_vend IS NOT NULL LIMIT 1),
curdate(),
$cntPedidos,
$cntNoVentas,
$cntMayoreo,
$cntDetalle,
$ventaInsuficiente,
'$primerPedido','$ultimoPedido','$totalA','$totalB','$totalC','$inexA','$inexB','$inexC'
)";
$conexion = new Conexion();
$conexion->ejecutarActualizacion($ins);
error_log(str_replace("\n"," ", $ins));

echo "SUCCESS";


<?php

$sinSesion = true;
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');
include 'core/clases/include.php';
$idUser = $_REQUEST["idUsuario"];
$conexion = new Conexion();
$sqlMensaje = "insert into pedidos.mensaje(id_usuario,json,type,sinc)
values(" . $_REQUEST["idUsuario"] . ",'" . substr(Conexion::escaparString($_REQUEST["clientes"]), 0, 19990) . "','ARRAY',0)";
$conexion->ejecutarActualizacion($sqlMensaje);
$idMsjArr = $conexion->obtenerGenerada();
$i = -1;
$errores = [];
$correctos = [];
$response = "";
if($_REQUEST["clientes"]=="[]"){
    echo '{"errores":'. json_encode($errores).',"correctos":'. json_encode($correctos).'}';
    die();
}
foreach (json_decode($_REQUEST["clientes"], true) as $cliente) {
    //Ingreso el encabezado del pedido.
    $i++;
    $cntPedidos++;

    $sqlMensaje = "insert into pedidos.mensaje(id_usuario,json,type,sinc)
    values(" . $_REQUEST["idUsuario"] . ",'" . substr(Conexion::escaparString(json_encode($cliente)), 0, 19990) . "','OBJ',0)";
    $conexion->ejecutarActualizacion($sqlMensaje);
    $idMensaje = $conexion->obtenerGenerada();


    if ($cliente["nuevo"] == true) {
        try {
            $insert = "INSERT INTO pedidos.maes_clie ("
                    . "CODI_CLIE, CODI_MUNI, NOMB_CLIE, NAJU_CLIE, TIPO_CLIE, "
                    . "DIRE_CLIE, ESTA_CLIE, ESTA_REGI, GEIM_CLIE, CLIE_GOB, TIPO_CONT, CLAS_CLIE, "
                    . "CODI_RUTA,LATITUD,LONGITUD) "
                    . "values ('" . $cliente["codigo"] . "','" . $cliente["CODI_MUNI"] . "','" . $cliente["nombre"] . "','','',"
                    . "'" . $cliente["direccion"] . "','','','','','','','" . $_REQUEST["ruta"] . "','" . $cliente["latitud"] . "','" . $cliente["longitud"] . "' )";
            $conexion->ejecutarActualizacion($insert);
            $updMensaje = "update pedidos.mensaje set sinc=1 where id_mensaje=$idMensaje";
            $conexion->ejecutarActualizacion($updMensaje);
            $correctos[] = $i;
        } catch (Exception $e) {
            error_log($e);
            $errores[] = $i;
        }
    } else {
        try {
            $update = "UPDATE pedidos.maes_clie set "
                    . "CODI_MUNI='" . $cliente["CODI_MUNI"] . "', "
                    . "NOMB_CLIE='" . $cliente["nombre"] . "', "
                    . "DIRE_CLIE='" . $cliente["direccion"] . "', "
                    . "LATITUD='" . $cliente["latitud"] . "', "
                    . "LONGITUD ='" . $cliente["longitud"] . "' "
                    . "where CODI_CLIE= '" . $cliente["codigo"] . "'";
            $conexion->ejecutarActualizacion($update);
            $updMensaje = "update pedidos.mensaje set sinc=1 where id_mensaje=$idMensaje";
            $conexion->ejecutarActualizacion($updMensaje);
            $correctos[] = $i;
        } catch (Exception $e) {
            error_log($e);
            $errores[] = $i;
        }
    }
}




if ($cntPedidos == $cnt) {
    $updMensaje = "update pedidos.mensaje set sinc=1 where id_mensaje=$idMsjArr";
    $conexion->ejecutarActualizacion($updMensaje);
}

echo '{"errores":'. json_encode($errores).',"correctos":'. json_encode($correctos).'}';

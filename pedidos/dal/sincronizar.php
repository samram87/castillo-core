<?php

$sinSesion = true;
header("Access-Control-Allow-Origin: *");
//header('Content-Type: application/json');
include 'core/clases/include.php';
$cnt=0;
$cntPedidos=0;
$idUser = $_REQUEST["idUsuario"];
$conexion = new Conexion();
$sqlMensaje="insert into pedidos.mensaje(id_usuario,json,type,sinc)
values(".$_REQUEST["idUsuario"].",'".substr(Conexion::escaparString($_REQUEST["pedidos"]),0,19990)."','ARRAY',0)";
$conexion->ejecutarActualizacion($sqlMensaje);
$idMsjArr=$conexion->obtenerGenerada();
foreach(json_decode($_REQUEST["pedidos"],true) as $pedido){
    //Ingreso el encabezado del pedido.
    $cntPedidos++;

    $sqlMensaje="insert into pedidos.mensaje(id_usuario,json,type,sinc)
    values(".$_REQUEST["idUsuario"].",'".substr(Conexion::escaparString(json_encode($pedido)),0,19990)."','OBJ',0)";
    $conexion->ejecutarActualizacion($sqlMensaje);
    $idMensaje = $conexion->obtenerGenerada();


   if($pedido["tipo"]=="NOVENTA"){
    $uid=$pedido['uuid'];
    $delete="delete from pedidos.no_venta where app_uuid='$uid'";
    $conexion->ejecutarActualizacion($delete);



     $sqlIns="
     INSERT INTO
     pedidos.no_venta(CODI_CLIE, observacion, id_usuario,
     app_uuid,latitud,longitud)
      VALUES ('".$pedido['cliente']['codigo']."',  '".Conexion::escaparString($pedido['observacion'])."', '" . $idUser . "',
      '".$pedido['uuid']."','".$pedido['latitud']."','".$pedido['longitud']."'
      )";
      $res=$conexion->ejecutarActualizacion($sqlIns);
      if($res!==false){
          $cnt++;
      }
      $idNo_venta = $conexion->obtenerGenerada();
      $updMensaje="update pedidos.mensaje set sinc=1,CORR_NO_VENTA=$idNo_venta where id_mensaje=$idMensaje";
      $conexion->ejecutarActualizacion($updMensaje);
   }else{
    $id=0;
    $uid=$pedido['uuid'];
    error_log("PROCESANDO UUID ".$uid);
    $rsPedido=new ResultSet("select CORR_ENCA_PEDI from pedidos.enca_pedi where app_uuid='$uid'");
    if($rsPedido->next()){
        $idPedido=$rsPedido->getString("CORR_ENCA_PEDI");
        
        $delSurt="delete from pedidos.deta_pedi_surt where CORR_DETA_PEDI in (select CORR_DETA_PEDI from pedidos.deta_pedi where CORR_ENCA_PEDI='$idPedido')";
        $conexion->ejecutarActualizacion($delSurt);

        $delDeta="delete from pedidos.deta_pedi where CORR_ENCA_PEDI='$idPedido'";
        $conexion->ejecutarActualizacion($delDeta);

        $sqlIns = "
        update pedidos.enca_pedi
        set
        CODI_CLIE='" . $pedido['cliente']['codigo'] . "',
        id_usuario='" . $idUser . "',
        fecha=curdate(),
        latitud='" . $pedido['latitud'] . "',
        longitud='" . $pedido['longitud'] . "',
        observacion='".Conexion::escaparString($pedido['observacion'])."',
        app_uuid='" . $uid . "',
        json='".substr(Conexion::escaparString(json_encode($pedido)),0,9990)."'
        where  CORR_ENCA_PEDI='$idPedido'
        ";
        $res=$conexion->ejecutarActualizacion($sqlIns);
        $id=$idPedido;
        $cnt++;
    }else{
        $sqlIns = "
        INSERT INTO pedidos.enca_pedi
        (
        CODI_CLIE,
        id_usuario,
        fecha,
        latitud,
        longitud,observacion,app_uuid,fuera_rango,distancia,json)
        VALUES
        (
        '" . $pedido['cliente']['codigo'] . "',
        '" . $idUser . "',
        curdate(),
        '" . $pedido['latitud'] . "',
        '" . $pedido['longitud'] . "',
        '".Conexion::escaparString($pedido['observacion'])."',
        '" . $pedido['uuid'] . "',
        '" . $pedido['fuera_rango'] . "',
        '" . $pedido['distance'] . "',
        '')";

        $res=$conexion->ejecutarActualizacion($sqlIns);
        if($res!==false){
            $cnt++;
        }
        $id = $conexion->obtenerGenerada();
        if($id==$idMensaje){
            $cnt--;
        }
    }


    

     

     if($id!=0){
         //Luego con cada linea ingreso en deta_pedi
         $i = 0;
         foreach ($pedido["lineas"] as $linea) {
             $i++;
             $sqlInsDeta = "
             INSERT INTO pedidos.deta_pedi
         (
         CORR_ENCA_PEDI,
         CODI_ARTI,
         CODI_MEDI,
         CANT_PROD,
         PREC_PROD,
         TOTA_PROD,
         tipo_prec,
         NUME_FILA,
         app_uuid)
         VALUES
         (
         $id,
         '" . $linea["producto"]["codigo"] . "',
         '" . $linea["uom"]["uom"] . "',
         '" . $linea["cantidad"] . "',
         '" . $linea["precio"] . "',
         '" . $linea["total"] . "',
         '" . $linea["tipoPrecio"] . "',
         $i,'" . $linea["uuid"] . "')";
             error_log(str_replace("\n", " ",$sqlInsDeta));
         $conexion->ejecutarActualizacion($sqlInsDeta);
         $idLinea = $conexion->obtenerGenerada();

             if(isset($linea["surtido"])){
                 //La linea posee surtido
                 foreach ($linea["surtido"] as $surtido) {
                     $sqlInsDetaComb="insert into
                         pedidos.deta_pedi_surt (
                         CODI_ARTI,
                         CORR_DETA_PEDI,
                         CODI_MEDI,
                         CANT_PROD,app_uuid)
                         VALUES (
                         '".$surtido["hijo"]["codigoProducto"]."',
                         '".$idLinea."',
                         '".$surtido["hijo"]["uom"]."',
                         '".$surtido["cnt"]."',
                         '".$surtido["uuid"]."'
                         )";
                     $conexion->ejecutarActualizacion($sqlInsDetaComb);
                 }
             }

         }
         //Verfico si el cliente tiene lat,long si no asigno las del pedido
         /*
         Usuario 16 (guillermo) y Usuario 14 (Orlando no guardan coordenadas)
         */
         if($idUser!="14"){
            $rs=new ResultSet("select codi_clie,
             LATITUD, LONGITUD
             from pedidos.maes_clie where codi_clie='". $pedido['cliente']['codigo']."'");
            if($rs->next()){
                if($rs->isNull("LATITUD")){
                    $upd="update pedidos.maes_clie
                        set LATITUD='".$pedido['latitud'] . "',
                        LONGITUD='".$pedido['longitud']."'
                        where CODI_CLIE='".$pedido['cliente']['codigo']."'";
                    $conexion->ejecutar($upd);
                }
            }
         }
         

         $updMensaje="update pedidos.mensaje set sinc=1,CORR_ENCA_PEDI=$id where id_mensaje=$idMensaje";
         $conexion->ejecutarActualizacion($updMensaje);
     }


   //Ahora las copias

   $sqlIns = "
        INSERT INTO pedidos.enca_pedi_copy
        (
        CODI_CLIE,
        id_usuario,
        fecha,
        latitud,
        longitud,observacion,app_uuid,json)
        VALUES
        (
        '" . $pedido['cliente']['codigo'] . "',
        '" . $idUser . "',
        curdate(),
        '" . $pedido['latitud'] . "',
        '" . $pedido['longitud'] . "',
        '".Conexion::escaparString($pedido['observacion'])."',
        '" . $pedido['uuid'] . "',
        '')";

        $res=$conexion->ejecutarActualizacion($sqlIns);
        $id = $conexion->obtenerGenerada();

        foreach ($pedido["lineas"] as $linea) {
            $i++;
            $sqlInsDeta = "
            INSERT INTO pedidos.deta_pedi_copy
        (
        CORR_ENCA_PEDI,
        CODI_ARTI,
        CODI_MEDI,
        CANT_PROD,
        PREC_PROD,
        TOTA_PROD,
        NUME_FILA,
        app_uuid)
        VALUES
        (
        $id,
        '" . $linea["producto"]["codigo"] . "',
        '" . $linea["uom"]["uom"] . "',
        '" . $linea["cantidad"] . "',
        '" . $linea["precio"] . "',
        '" . $linea["total"] . "',
        $i,'" . $linea["uuid"] . "')";
            error_log(str_replace("\n", " ",$sqlInsDeta));
        $conexion->ejecutarActualizacion($sqlInsDeta);
        $idLinea = $conexion->obtenerGenerada();

            if(isset($linea["surtido"])){
                //La linea posee surtido
                foreach ($linea["surtido"] as $surtido) {
                    $sqlInsDetaComb="insert into
                        pedidos.deta_pedi_surt_copy (
                        CODI_ARTI,
                        CORR_DETA_PEDI,
                        CODI_MEDI,
                        CANT_PROD)
                        VALUES (
                        '".$surtido["hijo"]["codigoProducto"]."',
                        '".$idLinea."',
                        '".$surtido["hijo"]["uom"]."',
                        '".$surtido["cnt"]."'
                        )";
                    $conexion->ejecutarActualizacion($sqlInsDetaComb);
                }
            }

        }
    }
}

if($cntPedidos==$cnt){
    $updMensaje="update pedidos.mensaje set sinc=1 where id_mensaje=$idMsjArr";
    $conexion->ejecutarActualizacion($updMensaje);
}

echo $cnt;

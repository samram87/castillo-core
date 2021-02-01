<?php
    /**
     * Ingresa en la tabla bitacora los datos insertados por una consulta.
     * @param $nombreTabla Nombre de la tabla que se ha modificado debe incluir el nombre del esquema, ej.: personas
     * @param $sql Sql del que se tomara la informacion de la tabla.
     * @param $valorLlave Valor de la llave de la tabla. Se puede obtener con mysql_last_insert_id
     */

    function generarBitacoraInsert($nombreTabla,$valorLlave,$sql,$idSistema){
        //$sql="select * from $nombreTabla where $nombreCampoLlave='$idAutoGenerado' limit 1";
        $rs=new ResultSet($sql);
        $rsMd=$rs->getMetadata();
        $campos=array();
        $textoNuevo="<table class=\"tablaBitacora\">";
        if($rs->next()){
            foreach($rsMd as $campo){
                $textoNuevo.="<tr><td><b>".$campo->name."</b></td><td>".$rs->getString($campo->name)."</td></tr>";
            }
        }
        $textoNuevo.="</table>";
        $textoNuevo=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$textoNuevo);

        $session="<table class=\"bitacoraSession\">";
        $llaves=array_keys($_SESSION);
        for($i=0;$i<count($llaves);$i++){
            $session.="<tr><td>".$llaves[$i]."</td><td>".$_SESSION[$llaves[$i]]."</td></tr>";
        }
        $session.="</table>";
        $session=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$session);
        $sqlInsert="INSERT INTO bitacora
        (
        `idUsuario`,
        `ipUsuario`,
        `fechaMovimiento`,
        `nombreTabla`,
        `valorLLave`,
        `tipoMovimiento`,
        `datosAnteriores`,
        `datosNuevos`,
        `IdSistema`,
        `Sesion`)
        VALUES (
        '".$_SESSION["idUsuario"]."',
        '".$_SERVER["REMOTE_ADDR"]."',
        now(),
        '$nombreTabla',
        '$valorLlave',
        'INSERT',
        NULL,
        '$textoNuevo'
        ,$idSistema,'$session'
        )";
        //echo $sqlInsert;
        $cnx=new Conexion();
        if(!$cnx->ejecutar($sqlInsert)){
            echo $cnx->obtenerErrores();
            die();
        }
        
        $cnx->finalizar();
        $cnx->cerrar();
    }

    function datosAnterioresUpdate($nombreTabla,$valorLlave,$sql,$idSistema){
        $rs=new ResultSet($sql);
        $rsMd=$rs->getMetadata();
        $campos=array();
        $textoNuevo="<table class=\"tablaBitacora\">";
        if($rs->next()){
            foreach($rsMd as $campo){
                $textoNuevo.="<tr><td><b>".$campo->name."</b></td><td>".$rs->getString($campo->name)."</td></tr>";
            }
        }
        $textoNuevo.="</table>";
        return $textoNuevo;
    }
    
    function generarBitacoraUpdate($nombreTabla,$valorLlave,$sql,$idSistema,$valoresAnteriores){
        //$sql="select * from $nombreTabla where $nombreCampoLlave='$idAutoGenerado' limit 1";
        $rs=new ResultSet($sql);
        $rsMd=$rs->getMetadata();
        $campos=array();
        $textoNuevo="<table class=\"tablaBitacora\">";
        if($rs->next()){
            foreach($rsMd as $campo){
//                if($textoNuevo!=""){
//                    $textoNuevo.=",";
//                }
                $textoNuevo.="<tr><td><b>".$campo->name."</b></td><td>".$rs->getString($campo->name)."</td></tr>";
            }
        }
        $textoNuevo.="</table>";
        $valoresAnteriores=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$valoresAnteriores);
        $textoNuevo=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$textoNuevo);

        $session="<table class=\"bitacoraSession\">";
        $llaves=array_keys($_SESSION);
        for($i=0;$i<count($llaves);$i++){
            $session.="<tr><td>".$llaves[$i]."</td><td>".$_SESSION[$llaves[$i]]."</td></tr>";
        }
        $session.="</table>";
        $session=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$session);
        $sqlInsert="INSERT INTO bitacora
        (
        `idUsuario`,
        `ipUsuario`,
        `fechaMovimiento`,
        `nombreTabla`,
        `valorLLave`,
        `tipoMovimiento`,
        `datosAnteriores`,
        `datosNuevos`,
        
        `Sesion`)
        VALUES (
        '".$_SESSION["idUsuario"]."',
        '".$_SERVER["REMOTE_ADDR"]."',
        now(),
        '$nombreTabla',
        '$valorLlave',
        'UPDATE',
        '$valoresAnteriores',
        '$textoNuevo'
        ,'$session'
        )";
        //echo $sqlInsert;
        $cnx=new Conexion();
        $cnx->ejecutarActualizacion($sqlInsert);
        $cnx->finalizar();
        $cnx->cerrar();
    }


    
    
    

?>
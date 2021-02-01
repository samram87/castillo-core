<?php


    function enviarCorreo($destinatario,$asunto,$mensaje,$from='sistemadgme@seguridad.gob.sv',$nombreFrom='Sistemas De Migracion y Extranjeria') {
        require_once("core/lib/phpmailer/class.phpmailer.php");
        
        $mail = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
//      $mail->SMTPAuth = true; // enable SMTP authentication
//      $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
        $mail->Host = "10.10.1.27"; // sets GMAIL as the SMTP server
//        $mail->Port = 25; // set the SMTP port for the GMAIL server
//        $mail->Username = 'sistemadgme'; // GMAIL username
//        $mail->Password = 'Dgme123456'; // GMAIL password        
//        $mail->SMTPDebug  = 1;
        $mail->CharSet = "UTF-8";
        $mail->From = $from;
        $mail->FromName = $nombreFrom;
        $mail->IsHTML(true);
        $mail->Subject =$asunto;
        $mail->AltBody = $mensaje;
        $mail->Body = $mensaje;
        $destinatario=$destinatario;
        $mail->AddAddress($destinatario,$destinatario);
        if(!$mail->Send()) {
            return false;
        } else {
            return true;
        }
    }

    function mayusculasVariables(){
        $arr=array_keys($_POST);
        for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            if(!is_array($_POST[$key])){
            if(strpos($_POST[$key],"<")===false){
                $_POST[$key]=strtoupper($_POST[$key]);
            }
            
            }
        }
        $arr=array_keys($_GET);
        for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            if(!is_array($_GET[$key])){
                if(strpos($_GET[$key],"<")===false){
                    $_GET[$key]=strtoupper($_GET[$key]);
                }
            }
            
        }
        $arr=array_keys($_REQUEST);
        for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            if(!is_array($_REQUEST[$key])){
                if(strpos($_REQUEST[$key],"<")===false){
                    $_REQUEST[$key]=strtoupper($_REQUEST[$key]);
                }
            }
        }
    }
    $variablesPostLimpias=false;
    function limpiarVariablesPost(){
        if($variablesPostLimpias==false){
            $variablesPostLimpias=true;
        $arr=array_keys($_POST);
        for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            $_POST[$key]=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$_POST[$key]);
            $_POST[$key]=trim($_POST[$key]);
        }
        }
    }
    
    $variablesRequestLimpias=false;
    function limpiarVariablesRequest(){
            $variablesRequestLimpias=true;
            $arr=array_keys($_REQUEST);
            for($i=0;$i<count($arr);$i++){
                $key=$arr[$i];
                $_REQUEST[$key]=str_replace("\\","\\\\", $_REQUEST[$key]);
                $_REQUEST[$key]=str_replace("'","\\'", $_REQUEST[$key]);
                //$_REQUEST[$key]=mysqli_real_escape_string(Conexion::getConexionPorDefecto(),$_REQUEST[$key]);
                //$_REQUEST[$key]=trim($_REQUEST[$key]);
            }
    }

     function ucaseVariablesPost(){
        $arr=array_keys($_POST);
        for($i=0;$i<count($arr);$i++){
            $key=$arr[$i];
            $_POST[$key]=strtoupper($_POST[$key]);
        }
    }


    function estaVacio($var){
        if(isset($var)){
            if($var!=''){
                return false;
            }
        }
        return true;
    }
    function reemplazarValores($query) {
        $idUsuario=$_SESSION["idUsuario"];
        $filtro=$query;
        $filtro=str_replace("{idUsuario}", $idUsuario, $filtro);

        //Reemplazo los valores que vengan por POST
        $llaves=array_keys($_POST);
        for($i=0;$i<count($_POST);$i++) {
            $id=$llaves[$i];
            $value=$_POST[$id];
            $filtro=str_replace("{".$id."}", $value, $filtro);
        }

        //Reemplazo algun valor que venga por get.
        $llaves=array_keys($_GET);
        for($i=0;$i<count($_GET);$i++) {
            $id=$llaves[$i];
            $value=$_GET[$id];
            $filtro=str_replace("{".$id."}", $value, $filtro);
        }

        return $filtro;
    }
    /**
     * StartsWith
     * Tests if a text starts with an given string.
     *
     * @param     string
     * @param     string
     * @return    bool
     */
    function StartsWith($Haystack, $Needle){
    // Recommended version, using strpos
    return strpos($Haystack, $Needle) === 0;
}

    function obtenerNombreUbiGeo($ubiGeo){
        $res=new ResultSet("SELECT 	nombre
	FROM 
	ubicacionesgeograficas WHERE idUbicacionGeografica=$ubiGeo");
        $res->next();
        return $res->getString(0);
    }

    function obtenerDescripcionUbiGeo($ubiGeo){
        $desc='';
        $query='SELECT
                    nivel
                FROM
                    ubicacionesgeograficas
                WHERE (idUbicacionGeografica='.$_REQUEST['idUbicacionGeografica'].')';
        $res=new ResultSet($query);
        $nivel=0;
        if($res->next()){
            $nivel=$res->getInt(0);
        }
        $res->cerrar();
        if($nivel!=0){
            //La ubicacion geografica existe.

            if($nivel==2){
                $desc=obtenerNombreUbiGeo($ubiGeo);
            }else if($nivel==3){
                $query='SELECT
                    idUbicacionGeograficaSuperior
                FROM
                    ubicacionesgeograficas
                WHERE (idUbicacionGeografica='.$_REQUEST['idUbicacionGeografica'].')';
                $res=new ResultSet($query);
                if($res->next()){
                    $desc=obtenerNombreUbiGeo($res->getInt(0));
                    $desc.=', '.obtenerNombreUbiGeo($ubiGeo);
                }
                $res->cerrar();

            }else if($nivel==4){
                $query='SELECT
                            municipios.idUbicacionGeograficaSuperior,
                            departamentos.idUbicacionGeograficaSuperior
                        FROM
                            ubicacionesgeograficas AS municipios
                        INNER JOIN ubicacionesgeograficas AS departamentos
                            ON (municipios.idUbicacionGeograficaSuperior = departamentos.idUbicacionGeografica)
                        WHERE (ubicacionesgeograficas.idUbicacionGeografica='.$_REQUEST['idUbicacionGeografica'].')';
                $res=new ResultSet($query);
                if($res->next()){
                    $desc=obtenerNombreUbiGeo($res->getInt(1));
                     $desc=', '.obtenerNombreUbiGeo($res->getInt(0));
                    $desc.=', '.obtenerNombreUbiGeo($ubiGeo);
                }
                $res->cerrar();
            }
        }
        return $desc;
    }
    
    function validar_interpol($numpass, $nacionalidad) {
    if ($numpass != '' && $nacionalidad != '') {
        require_once("core/lib/soap/nusoap.php");
        $msg_text_res_interpol = '';
        $proxyhost = "10.4.180.100:80";
        $proxyport = "80";
        $client = new nusoap_client('http://10.1.1.42:248/WSProxy0.4/SLTD.asmx?wsdl', true, $proxyhost, $proxyport, '', '', 0);
        $err = $client->getError();
        $client->timeout=10;
        $client->response_timeout=5;
        if ($err) {
            // $msg_text_res_interpol .= '1. PROBLEMAS DE CONEXION AL SERVICIO DE INTERPOL';
        }
        $headers = '<UsernameToken  xmlns="http://interpol.int/WSEASFProxy/SLTD">
      <Username>ncb.sansalvador.sv</Username>
      <Password>bue98vadoye36</Password>
    </UsernameToken>';
        $client->forceEndpoint = 'http://10.1.1.42:248/WSProxy0.4/SLTD.asmx';
        $param = array('DIN' => $numpass, 'CountryOfRegistration' => $nacionalidad, 'NbRecord' => 1);
        $result = $client->call('Search', array($param), '', '', $headers, true);
        if ($client->fault) {
            // $msg_text_res_interpol .= '2. PROBLEMAS DE CONEXION AL SERVICIO DE INTERPOL';
        } else {
            $err = $client->getError();
            if ($err) {
                // $msg_text_res_interpol .= '3. PROBLEMAS DE CONEXION AL SERVICIO DE INTERPOL';
            } else {
                // $msg_text_res_interpol .= '4. CONEXION OK';

            }
        }
        $resres = trim($result['SearchResult']['resultCode']);
        if ($resres == 'NO_ERROR') {
            // $msg_text_res_interpol .= '5. CONEXION OK';
            // $msg_text_res_interpol .= '6. RESTRICCION INTERPOL';
        }
        else {
            // $msg_text_res_interpol .= '7. PROBLEMAS DE CONEXION AL SERVICIO DE INTERPOL';
        }
        return trim($resres);
    }
    }


    function arrayContiene($array,$id) {
    if(is_array($array)){
        for($i=0;$i<count($array);$i++) {
            if($id==$array[$i]) {
                return true;
            }
        }
    }
    return false;
    }

    function obtenerElementosSeparados($array,$separador=',',$omitirVacios=true){
        $elementos="";
        foreach($array as $vl){
            if($omitirVacios){
                if($elementos!="" && $vl!=""){
                    $elementos.=",";
                }
                if($vl!=""){
                    $elementos.=$vl;
                }
            }else{
                if($elementos!=""){
                    $elementos.=",";
                }
                $elementos.=$vl;
            }
        }
    }
?>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RequestForSQL {
    private static $NULL_TEXT="NULL";
    private static $NUMBER_EMPTY="0";
    private static $INCLUDE_SINGLE_QUOTE=true;
    private static $DATE_FORMAT="%d/%m/%Y";
    private static $DATETIME_FORMAT="%d/%m/%Y %H:%i:%s";
    
    public static function getString($nombre){
        if(!isset($_REQUEST[$nombre])){
            return RequestForSQL::$NULL_TEXT;
        }
        $campo=$_REQUEST[$nombre];
        if(is_null_or_empty($campo)){
            return RequestForSQL::$NULL_TEXT;
        }else{
            //Reemplazo backslash por doble backslash
            $campo=str_replace("\\", "\\\\", $campo);
            //Reemplazo la comilla
            $campo=str_replace("'", "\\'", $campo);
            $campo="'".$campo."'";
            return $campo;
        }
    }
    
    public static function getDate($nombre){
        if(!isset($_REQUEST[$nombre])){
            return RequestForSQL::$NULL_TEXT;
        }
        $campo=$_REQUEST[$nombre];
        if(is_null_or_empty($campo)){
            return RequestForSQL::$NULL_TEXT;
        }else{
            //No debe venir nada de comillas ni backslash
            $campo=str_replace("\\", "", $campo);
            //Reemplazo la comilla
            $campo=str_replace("'", "", $campo);
            $campo="str_to_date('".$campo."','".RequestForSQL::$DATE_FORMAT."')";
            return $campo;
        }
    }
    
    public static function getDateTime($nombre){
        if(!isset($_REQUEST[$nombre])){
            return RequestForSQL::$NULL_TEXT;
        }
        $campo=$_REQUEST[$nombre];
        if(is_null_or_empty($campo)){
            return RequestForSQL::$NULL_TEXT;
        }else{
            //No debe venir nada de comillas ni backslash
            $campo=str_replace("\\", "", $campo);
            //Reemplazo la comilla
            $campo=str_replace("'", "", $campo);
            $campo="str_to_date('".$campo."','".RequestForSQL::$DATETIME_FORMAT."')";
            return $campo;
        }
    }
    
    public static function getInt($nombre,$null_value=""){
        if($null_value==""){
            $null_value=RequestForSQL::$NULL_TEXT;
        }
        if(!isset($_REQUEST[$nombre])){
            return $null_value;
        }
        $campo=$_REQUEST[$nombre];
        if(is_null_or_empty($campo)){
            return $null_value;
        }else{
            //No debe venir nada de comillas ni backslash
            $campo=str_replace("\\", "", $campo);
            //Reemplazo la comilla
            $campo=str_replace("'", "", $campo);
            $campo=str_replace(",", "", $campo);
            $campo=intval($campo);
            $campo="'".$campo."'";
            return $campo;
        }
    }
    
    public static function getFloat($nombre,$null_value=""){
        if($null_value==""){
            $null_value=RequestForSQL::$NULL_TEXT;
        }
        if(!isset($_REQUEST[$nombre])){
            return $null_value;
        }
        $campo=$_REQUEST[$nombre];
        if(is_null_or_empty($campo)){
            return $null_value;
        }else{
            //No debe venir nada de comillas ni backslash
            $campo=str_replace("\\", "", $campo);
            //Reemplazo la comilla
            $campo=str_replace("'", "", $campo);
            $campo=str_replace(",", "", $campo);
            $campo=floatval($campo);
            $campo="'".$campo."'";
            return $campo;
        }
    }
    
    public static function getCampo($nombre){
        return $_REQUEST[$nombre];
    }
}

class R extends RequestForSQL{}


function is_null_or_empty($value){
    if($value==null){
        return true;
    }else if($value==''){
        return true;
    }else{
        return false;
    }
}

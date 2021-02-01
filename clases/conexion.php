<?php 
class Conexion {

    private  $server='localhost';
    private  $username='root';
    //private  $password='';
    private  $password='castillo';
    private  $baseDeDatosPorDefecto='core';
    private  $conexion;

    private static $conexionPorDefecto=null;
    
    public static $logQuery=false;
    /**
     * @return ResultSet
     */
    public function __construct ($probando=false) {
        if($probando===false){
            $this->conexion=mysqli_connect($this->server, $this->username, $this->password);
            
            //die(mysqli_error($this->conexion));
            Conexion::setConexionPorDefecto($this->conexion);
            mysqli_select_db($this->conexion,$this->baseDeDatosPorDefecto);
            mysqli_multi_query($this->conexion,"SET NAMES 'UTF8'");
        }
    }

    public function setServer($server){
        $this->server=$server;
    }
    public function setUsername($username){
        $this->username=$username;
    }
    public function setPassword($password){
        $this->password=$password;
    }
    public function setBaseDeDatosPorDefecto($baseDeDatosPorDefecto){
        $this->baseDeDatosPorDefecto=$baseDeDatosPorDefecto;
    }

    public function reconectar(){
        $this->conexion=mysqli_connect($this->server, $this->username, $this->password);
        if($this->baseDeDatosPorDefecto!=''){
            mysqli_select_db($this->conexion,$this->baseDeDatosPorDefecto);
        }
        mysqli_multi_query($this->conexion,"SET NAMES 'UTF8mb4'");
    }
    public function ejecutarQuery($query,$parse=false){
        if(isset($_SESSION['idUsuario'])){
            str_replace('{CodigoUsuario}', $_SESSION['idUsuario'], $query);
        }
        return new ResultSet($query,$this);
    }
    public function ejecutarActualizacion($query){
        $res=mysqli_query($this->conexion,$query);
        if($res===false){
            error_log(mysqli_error($this->conexion));
            return false;
        }
        return mysqli_affected_rows($this->conexion);
    }

    public function ejecutar($query){
        return mysqli_query($this->conexion,$query);

    }

    public function obtenerGenerada(){
        return mysqli_insert_id($this->conexion);
    }

    public function getConexion(){
        return $this->conexion;
    }
    
    public function cerrar(){
        mysqli_close($this->conexion);
    }

    public function mostrarErrores(){
        return mysqli_error($this->conexion);
    }
    
    public function obtenerErrores(){
        return mysqli_error($this->conexion);
    }

    private static function setConexionPorDefecto($conexion){
        if(Conexion::$conexionPorDefecto==null){
            Conexion::$conexionPorDefecto=$conexion;
        }
    }
    
    public static function getConexionPorDefecto(){
        return Conexion::$conexionPorDefecto;
    }

    public function finalizar(){
        $this->ejecutar("COMMIT;");
        $this->cerrar();
    }
    
    public static function escaparString($str){
        return mysqli_real_escape_string(Conexion::$conexionPorDefecto,$str);
    }

}
$conexion=new Conexion(true);
if((!isset($sinConexion))||($sinConexion===false)){
    $conexion=new Conexion();
    $conexion->ejecutar("set names 'UTF8' ");
}



$_URL_SERVIDOR_REPORTES="http://".$_SERVER["SERVER_ADDR"].":8080";


<?php


class ConexionODBC {

    private $dsn = "castillo"; 
    private $usuario = "dba";
    private $clave="sql";
    private  $conexion;

    private static $conexionPorDefecto=null;
    
    /**
     * @return ResultSet
     */
    public function __construct ($probando=false) {
        if($probando===false){
            $this->conexion=odbc_connect($this->dsn, $this->usuario,$this->clave);
            //die(mysqli_error($this->conexion));
            ConexionODBC::setConexionPorDefecto($this->conexion);       
        }
    }

    public function ejecutarQuery($query,$parse=false){
        if(isset($_SESSION['idUsuario'])){
            str_replace('{CodigoUsuario}', $_SESSION['idUsuario'], $query);
        }
        return new ResultSetODBC($query,$this);
    }
    public function ejecutarActualizacion($query){
        return odbc_exec($this->conexion,$query);
    }
    public function ejecutar($query){
        return odbc_exec($this->conexion,$query);

    }
    public function getConexion(){
        return $this->conexion;
    }    
    public function cerrar(){
        odbc_close($this->conexion);
    }
    private static function setConexionPorDefecto($conexion){
        if(ConexionODBC::$conexionPorDefecto==null){
            ConexionODBC::$conexionPorDefecto=$conexion;
        }
    }
    public static function getConexionPorDefecto(){
        return ConexionODBC::$conexionPorDefecto;
    }
    public static function escaparString($str){
        return mysqli_real_escape_string(Conexion::$conexionPorDefecto,$str);
    }
}

$cnxOdbc=new ConexionODBC();

class ResultSetODBC extends ResultSet {
    private $asociativo;
    private $resultado;
    private $filas;
    private $filaActual=0;
    private $conexion=null;
    public function __construct($query,$conexionSql=null) {
        //error_log($query);
        if($conexionSql==null){
            $this->conexion= ConexionODBC::getConexionPorDefecto();
        }else{
            $this->conexion=$conexionSql->getConexion();
        }
        $this->resultado=odbc_exec($this->conexion,$query);
    }
    public function next(){
        $this->asociativo=odbc_fetch_array($this->resultado);
        $this->filaActual=$this->filaActual+1;
        if($this->asociativo==false){
            return false;
        }else{
            return true;
        }
    }

	public function getResult(){
		return $this->resultado;
	}
	
    
    
    
    private function get($campo){
        return $this->asociativo[$campo];
    }

    public function getString($campo){
        return $this->get($campo);
    }

    public function getDate($campo,$formato='d/m/Y'){
        $fechaMysql=$this->get($campo);
        if($fechaMysql==''){
            return '';
        }
        $fechaPhp = strtotime($fechaMysql);
        $fecha=date($formato,$fechaPhp);
        return $fecha;
    }

    public function getDateTime($campo){
        return $this->getDate($campo,'d/m/Y H:i');
    }
    public function getTime($campo){
        return $this->getDate($campo,'H:i');
    }
    public function getInt($campo){
        if(!is_integer($this->get($campo))){
            if(is_numeric($this->get($campo))){
                return $this->get($campo);
            }
            return 0;
        }else{
            return $this->get($campo);
        }
    }
    public function beforeFirst(){
        return 0;
    }
    public function getDouble($campo){
        if(!is_numeric($this->get($campo))){
            return 0;
        }else{
            return number_format($this->get($campo),4,'.',',');
        }
    }
    public function getFloat($campo){
        if(!is_numeric($this->get($campo))){
            return 0;
        }else{
            return number_format($this->get($campo),2,'.',',');
        }
    }
    public function getBoolean($campo){
        if(!is_numeric($this->get($campo))){
            //Esto para los campos S/N
            if($this->getString($campo)=="S"){
                return true;
            }else{
                return false;
            }
        }else { 
            if($this->getInt($campo)==0){
                return false;
            }else{
                return true;
            }
        }
    }

    public function isNull($campo){
        if($this->get($campo)==''){
            return true;
        }else{
            return false;
        }
    }
}
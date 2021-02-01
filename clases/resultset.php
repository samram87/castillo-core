<?php
class ResultSet {
    private $asociativo;
    private $resultado;
    private $filas;
    private $filaActual=0;
    private $conexion=null;
    public function __construct($query,$conexionSql=null) {
        if(isset($_SESSION['idUsuario'])){
            $query=str_replace('{CodigoUsuario}', $_SESSION['idUsuario'], $query);
            $query=str_replace('{idUsuario}', $_SESSION['idUsuario'], $query);
            $query=str_replace('{idPerfil}', "'".$_SESSION['idPerfil']."'", $query);
            if(isset($_SESSION['id_empresa'])){
                $query=str_replace('{idEmp}', "'".$_SESSION['id_empresa']."'", $query);
                if($_SESSION['id_empresa']>1){
                    //Solo si la empresa del usuario actual es >1
                    $query=str_replace('{filtroEmp}', "id_empresa='".$_SESSION['id_empresa']."'", $query);
                }else{
                    //Si la empresa del usuario actual es ==1 debe poder ver todas
                    $query=str_replace('{filtroEmp}', "id_empresa in (select id_empresa from configuracion)", $query);
                }
            }
            
        }
        
        if(Conexion::$logQuery){
            error_log(str_replace("\n", " ",$query));
        }
        if($conexionSql==null){
            $this->conexion=Conexion::getConexionPorDefecto();
        }else{
            $this->conexion=$conexionSql->getConexion();
        }
        if(mysqli_multi_query($this->conexion,$query)==false){
            
            echo mysqli_error($this->conexion)." <br> Error Ejecutando el query : $query ";
            error_log(mysqli_error($this->conexion));
        }
        //if(mysqli_more_results($this->conexion)){
            $this->resultado=mysqli_store_result($this->conexion);
            //$this->filas=mysqli_num_rows($this->resultado);
        //}
        
    }
    public function getNumeroDeFilas(){
        return mysqli_num_rows($this->resultado);
    }

    public function getCantidadDeColumnas(){
        return mysqli_field_count($this->conexion);
    }
    public function getMetadata(){
        return mysqli_fetch_fields($this->resultado);
    }
    public function next(){
        $this->asociativo=mysqli_fetch_array($this->resultado,MYSQLI_BOTH);
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
	
    public function nextResult(){
        if(mysqli_more_results($this->conexion)){
            mysqli_next_result($this->conexion);
            $this->resultado=mysqli_store_result($this->conexion);
            $this->filaActual=0;
            if ($this->resultado){ 
            $this->filas=mysqli_num_rows($this->resultado);
            return true;} else {return false;}
        }else{
            return false;
        }
    }
    
    public function back(){
        if($this->filaActual>=1){
            mysqli_data_seek($this->resultado,$this->filaActual-1);
            $this->filaActual=$this->filaActual-1;
            $this->next();
        }
    }
    public function beforeFirst(){
        if($this->getNumeroDeFilas()>0){
            mysqli_data_seek($this->resultado,0);
        }
    }
    public function getPosicionActual(){
        return $this->filaActual;
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
    public function cerrar(){
        mysqli_free_result($this->resultado);

    }

    /*
     * Procedimiento que genera todo el objeto resultset a un jsonArray
     */
    public function toJsonArray(){
        $json="[";
        $first=true;
        while($this->next()){
            if(!$first){
                $json.=",";
            }
            $json.=$this->toJsonObject();
            $first=false;
        }
        $json.="]";
        return $json;
    }
    
    /*
     * Procedimiento que genera la fila actual a un objeto JSON 
     * si se envia false como parametro no se incluira entre {}
     * esto puede servir en el caso de que se necesite agregar mas al objeto
     */
    function toJsonObject($useBrackets=true){
        $json="{";
        if(!$useBrackets){
            $json="";
        }
        $info_campo = $this->getMetadata();
        $primer=true;
        foreach ($info_campo as $valor) {
            if(!$primer){
                $json.=",";
            }
            $f=$valor->name;
            $json.='"'.$f.'":"'.str_replace("\n","",str_replace('"', '',$this->getString($f))).'"';
            $primer=false;
        }
        if($useBrackets){
            $json.="}";
        }
        return $json;
    }
}

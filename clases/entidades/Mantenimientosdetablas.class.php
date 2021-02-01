<?php

class Mantenimientosdetablas {
	
	private $idMantenimientoDeTabla;
	private $NombreTabla;
	private $TituloTabla;
	private $idSuperiorMantenimientoDeTabla;
	private $NumeroDeColumnasMostradas;
	private $NivelTabla;
	private $TipoDeDespliegue;
	private $RutaDespliegue;
	private $RutaCaptura;
        private $RutaInsert;
	private $RutaActualizacion;
        private $RutaUpdate;
	private $RutaRetorno;
	private $TipoDeRetorno;
	private $ConfirmaEliminacion;
	private $RequerirAuditoria;
	private $DescripcionDeTabla;
	private $NumeroDeRegistrosPorPantalla;
	private $TipoDespliegueDependecias;
	private $JavascriptDeEjecucionGlobal;
	private $FiltroGeneralDeLaTabla;
	private $NombreClaseValidacion;
        private $Detalles;
        private $DetallesOrdenadosPorDespliegue;
        private $DetallesOrdenadosPorCaptura;
        private $NumeroDeColumnas;
        private $permisoInsert;
        private $permisoDelete;
        private $permisoUpdate;

        public function &setRutaUpdate($RutaUpdate){
            $this->RutaUpdate=$RutaUpdate;
            return $this->RutaUpdate;
        }
        public function &getRutaUpdate(){
            return $this->RutaUpdate;
        }
	public function &setRutaInsert($RutaInsert){
            $this->RutaInsert=$RutaInsert;
            return $this->RutaInsert;
        }
        public function &getRutaInsert(){
            return $this->RutaInsert;
        }

        public function &setPermisoInsert($permisoInsert){
            $this->permisoInsert=$permisoInsert;
            return $this->permisoInsert;
        }
        public function &getPermisoInsert(){
            return $this->permisoInsert;
        }
        public function &setPermisoDelete($permisoDelete){
            $this->permisoDelete=$permisoDelete;
            return $this->permisoDelete;
        }
        public function &getPermisoDelete(){
            return $this->permisoDelete;
        }
        public function &setPermisoUpdate($permisoUpdate){
            $this->permisoUpdate=$permisoUpdate;
            return $this->permisoUpdate;
        }
        public function &getPermisoUpdate(){
            return $this->permisoUpdate;
        }

        public function &setDetalles($array){
            $this->Detalles=$array;
            return $this;
        }
        public function &getDetalles(){
            return $this->Detalles;
        }

        public function &setDetallesOrdenadosPorCaptura($array){
            $this->DetallesOrdenadosPorCaptura=$array;
            return $this;
        }
        public function &getDetallesOrdenadosPorCaptura(){
            return $this->DetallesOrdenadosPorCaptura;
        }
        //DetallesOrdenadosPorDespliegue
        public function &setDetallesOrdenadosPorDespliegue($array){
            $this->DetallesOrdenadosPorDespliegue=$array;
            return $this;
        }
        public function &getDetallesOrdenadosPorDespliegue(){
            return $this->DetallesOrdenadosPorDespliegue;
        }
        public function &getCantidadDetalles(){
            $count = count($this->Detalles);
            return $count;
        }        

	public function &setIdMantenimientoDeTabla($idMantenimientoDeTabla) {
		$this->idMantenimientoDeTabla=$idMantenimientoDeTabla;
		return $this;
	}

	public function getIdMantenimientoDeTabla() {
		return $this->idMantenimientoDeTabla;
	}
	public function &setNombreTabla($NombreTabla) {
		$this->NombreTabla=$NombreTabla;
		return $this;
	}
	public function getNombreTabla() {
		return $this->NombreTabla;
	}
	public function &setTituloTabla($TituloTabla) {
            $this->TituloTabla=$TituloTabla;
		return $this;
	}
	public function getTituloTabla() {
		return $this->TituloTabla;
        }
	public function &setIdSuperiorMantenimientoDeTabla($idSuperiorMantenimientoDeTabla) {
		$this->idSuperiorMantenimientoDeTabla=$idSuperiorMantenimientoDeTabla;
		return $this;
	}
	public function getIdSuperiorMantenimientoDeTabla() {
		return $this->idSuperiorMantenimientoDeTabla;
	}
	public function &setNumeroDeColumnasMostradas($NumeroDeColumnasMostradas) {
		$this->NumeroDeColumnasMostradas=$NumeroDeColumnasMostradas;
		return $this;
	}
	public function getNumeroDeColumnasMostradas() {
		return $this->NumeroDeColumnasMostradas;
	}
	public function &setNivelTabla($NivelTabla) {
		$this->NivelTabla=$NivelTabla;
		return $this;
	}
	public function getNivelTabla() {
		return $this->NivelTabla;
	}
	public function &setTipoDeDespliegue($TipoDeDespliegue) {
		$this->TipoDeDespliegue=$TipoDeDespliegue;
		return $this;
	}
	public function getTipoDeDespliegue() {
		return $this->TipoDeDespliegue;
	}
	public function &setRutaDespliegue($RutaDespliegue) {
		$this->RutaDespliegue=$RutaDespliegue;
		return $this;
	}
	public function getRutaDespliegue() {
		return $this->RutaDespliegue;
	}
	public function &setRutaCaptura($RutaCaptura) {
		$this->RutaCaptura=$RutaCaptura;
		return $this;
	}
	public function getRutaCaptura() {
		return $this->RutaCaptura;
	}
	public function &setRutaActualizacion($RutaActualizacion) {
		$this->RutaActualizacion=$RutaActualizacion;
		return $this;
	}
	public function getRutaActualizacion() {
		return $this->RutaActualizacion;
	}
	public function &setRutaRetorno($RutaRetorno) {
		$this->RutaRetorno=$RutaRetorno;
		return $this;
	}
	public function getRutaRetorno() {
		return $this->RutaRetorno;
	}
	public function &setTipoDeRetorno($TipoDeRetorno) {
		$this->TipoDeRetorno=$TipoDeRetorno;
		return $this;
	}
	public function getTipoDeRetorno() {
		return $this->TipoDeRetorno;
	}
	public function &setConfirmaEliminacion($ConfirmaEliminacion) {
		$this->ConfirmaEliminacion=$ConfirmaEliminacion;
		return $this;
	}
	public function getConfirmaEliminacion() {
		return $this->ConfirmaEliminacion;
	}
	public function &setRequerirAuditoria($RequerirAuditoria) {
		$this->RequerirAuditoria=$RequerirAuditoria;
		return $this;
	}
	public function getRequerirAuditoria() {
		return $this->RequerirAuditoria;
	}
	public function &setDescripcionDeTabla($DescripcionDeTabla) {
		$this->DescripcionDeTabla=$DescripcionDeTabla;
		return $this;
	}
	public function getDescripcionDeTabla() {
		return $this->DescripcionDeTabla;
	}
	public function &setNumeroDeRegistrosPorPantalla($NumeroDeRegistrosPorPantalla) {
		$this->NumeroDeRegistrosPorPantalla=$NumeroDeRegistrosPorPantalla;
		return $this;
	}
	public function getNumeroDeRegistrosPorPantalla() {
		return $this->NumeroDeRegistrosPorPantalla;
	}
	public function &setTipoDespliegueDependecias($TipoDespliegueDependecias) {
		$this->TipoDespliegueDependecias=$TipoDespliegueDependecias;
		return $this;
	}
	public function getTipoDespliegueDependecias() {
		return $this->TipoDespliegueDependecias;
	}
	public function &setJavascriptDeEjecucionGlobal($JavascriptDeEjecucionGlobal) {
		$this->JavascriptDeEjecucionGlobal=$JavascriptDeEjecucionGlobal;
		return $this;
	}
	public function getJavascriptDeEjecucionGlobal() {
		return $this->JavascriptDeEjecucionGlobal;
	}
	public function &setFiltroGeneralDeLaTabla($FiltroGeneralDeLaTabla) {
		$this->FiltroGeneralDeLaTabla=$FiltroGeneralDeLaTabla;
		return $this;
	}
	public function getFiltroGeneralDeLaTabla() {
		return $this->FiltroGeneralDeLaTabla;
	}
	public function &setNombreClaseValidacion($NombreClaseValidacion) {
		$this->NombreClaseValidacion=$NombreClaseValidacion;
		return $this;
	}
	public function getNombreClaseValidacion() {
		return $this->NombreClaseValidacion;
	}
        public function &setNumeroDeColumnas($NumeroDeColumnas) {
		$this->NumeroDeColumnas=$NumeroDeColumnas;
		return $this;
	}
	public function getNumeroDeColumnas() {
		return $this->NumeroDeColumnas;
	}
        
        

}
?>
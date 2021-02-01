<?php
class Detallesmantenimientosdetablas {
	
	private $idDetallleMantenimientoTabla;
	private $idMantenimientoDeTabla;
	private $idCampo;
	private $nombreCampo;
	private $accionCampo;
	private $claseCampo;
	private $idTipoCampo;
	private $tamanoCampo;
	private $tamanoMaximoCampo;
	private $nulidadCampo;
	private $descripcionCampo;
	private $admiteDefault;
	private $valorDefault;
	private $desplegarCampo;
	private $ordenDespliegue;
	private $autoincremento;
	private $ordenFila;
	private $ordenColumna;
	private $javascriptDesdeCampo;
	private $formatoFecha;
	private $restriccionDeFechas;
	private $altoCampo;
	private $tipoCapturaExtranjera;
	private $idMantenimientoDeTablaExtranjera;
	private $queryFiltro;
	private $nombreDeTablaMuchosAMuchos;
	private $rutaDeArchivo;
	private $idCampoNombreArchivo;
	private $permiteFiltro;
		private $mostrarSoloEnActualizacion;
		private $catalogoId;


	
	public function &setIdDetallleMantenimientoTabla($idDetallleMantenimientoTabla) {
		$this->idDetallleMantenimientoTabla=$idDetallleMantenimientoTabla;
		return $this;
	}

	public function getIdDetallleMantenimientoTabla() {
		return $this->idDetallleMantenimientoTabla;
	}

	public function &setIdMantenimientoDeTabla($idMantenimientoDeTabla) {
		$this->idMantenimientoDeTabla=$idMantenimientoDeTabla;
		return $this;
	}

	public function getIdMantenimientoDeTabla() {
		return $this->idMantenimientoDeTabla;
	}

	public function &setIdCampo($idCampo) {
		$this->idCampo=$idCampo;
		return $this;
	}

	public function getIdCampo() {
		return $this->idCampo;
	}

	public function &setNombreCampo($nombreCampo) {
		$this->nombreCampo=$nombreCampo;
		return $this;
	}

	public function getNombreCampo() {
		return $this->nombreCampo;
	}

	public function &setAccionCampo($accionCampo) {
		$this->accionCampo=$accionCampo;
		return $this;
	}
        /*
         * Devuelve la accion de un campo.
         * O = Oculto, D=Despliegue, C=Captura, L=Lectura
         */
	public function getAccionCampo() {
		return $this->accionCampo;
	}

	public function &setClaseCampo($claseCampo) {
		$this->claseCampo=$claseCampo;
		return $this;
	}

        /*
         * Obtiene la clase del campo. P=Primaria; N=Normal
         */
	public function getClaseCampo() {
		return $this->claseCampo;
	}

	public function &setIdTipoCampo($idTipoCampo) {
		$this->idTipoCampo=$idTipoCampo;
		return $this;
	}

	public function getIdTipoCampo() {
		return $this->idTipoCampo;
	}

	public function &setTamanoCampo($tamanoCampo) {
		$this->tamanoCampo=$tamanoCampo;
		return $this;
	}

	public function getTamanoCampo() {
		return $this->tamanoCampo;
	}

	public function &setTamanoMaximoCampo($tamanoMaximoCampo) {
		$this->tamanoMaximoCampo=$tamanoMaximoCampo;
		return $this;
	}

	public function getTamanoMaximoCampo() {
		return $this->tamanoMaximoCampo;
	}

	public function &setNulidadCampo($nulidadCampo) {
		$this->nulidadCampo=$nulidadCampo;
		return $this;
	}

	public function getNulidadCampo() {
		return $this->nulidadCampo;
	}

	public function &setDescripcionCampo($descripcionCampo) {
		$this->descripcionCampo=$descripcionCampo;
		return $this;
	}

	public function getDescripcionCampo() {
		return $this->descripcionCampo;
	}

	public function &setAdmiteDefault($admiteDefault) {
		$this->admiteDefault=$admiteDefault;
		return $this;
	}

	public function getAdmiteDefault() {
		return $this->admiteDefault;
	}

	public function &setValorDefault($valorDefault) {
		$this->valorDefault=$valorDefault;
		return $this;
	}

	public function getValorDefault() {
		return $this->valorDefault;
	}

	public function &setDesplegarCampo($desplegarCampo) {
		$this->desplegarCampo=$desplegarCampo;
		return $this;
	}

	public function getDesplegarCampo() {
		return $this->desplegarCampo;
	}

	public function &setOrdenDespliegue($ordenDespliegue) {
		$this->ordenDespliegue=$ordenDespliegue;
		return $this;
	}

	public function getOrdenDespliegue() {
		return $this->ordenDespliegue;
	}

	public function &setAutoincremento($autoincremento) {
		$this->autoincremento=$autoincremento;
		return $this;
	}

	public function getAutoincremento() {
		return $this->autoincremento;
	}

	public function &setOrdenFila($ordenFila) {
		$this->ordenFila=$ordenFila;
		return $this;
	}

	public function getOrdenFila() {
		return $this->ordenFila;
	}

	public function &setOrdenColumna($ordenColumna) {
		$this->ordenColumna=$ordenColumna;
		return $this;
	}

	public function getOrdenColumna() {
            return $this->ordenColumna;
	}

	/**
	 * set value for javascriptDesdeCampo permite agregar eventos ONBLUR, ONCLICK, ONCHANGE al elemento html
	 *
	 * type:VARCHAR,size:2000,default:null,nullable
	 *
	 * @param mixed $javascriptDesdeCampo
	 * @return Detallesmantenimientosdetablas
	 */
	public function &setJavascriptDesdeCampo($javascriptDesdeCampo) {
		$this->javascriptDesdeCampo=$javascriptDesdeCampo;
		return $this;
	}

	public function getJavascriptDesdeCampo() {
		return $this->javascriptDesdeCampo;
	}

	public function &setFormatoFecha($formatoFecha) {
		$this->formatoFecha=$formatoFecha;
		return $this;
	}

	public function getFormatoFecha() {
		return $this->formatoFecha;
	}

	public function &setRestriccionDeFechas($restriccionDeFechas) {
		$this->restriccionDeFechas=$restriccionDeFechas;
		return $this;
	}

	public function getRestriccionDeFechas() {
		return $this->restriccionDeFechas;
	}

	public function &setAltoCampo($altoCampo) {
		$this->altoCampo=$altoCampo;
		return $this;
	}

	public function getAltoCampo() {
		return $this->altoCampo;
	}

	public function &setTipoCapturaExtranjera($tipoCapturaExtranjera) {
		$this->tipoCapturaExtranjera=$tipoCapturaExtranjera;
		return $this;
	}

	public function getTipoCapturaExtranjera() {
		return $this->tipoCapturaExtranjera;
	}

	public function &setIdMantenimientoDeTablaExtranjera($idMantenimientoDeTablaExtranjera) {
		$this->idMantenimientoDeTablaExtranjera=$idMantenimientoDeTablaExtranjera;
		return $this;
	}

	public function getIdMantenimientoDeTablaExtranjera() {
		return $this->idMantenimientoDeTablaExtranjera;
	}

	public function &setQueryFiltro($queryFiltro) {
		$this->queryFiltro=$queryFiltro;
		return $this;
	}

	public function getQueryFiltro() {
		return $this->queryFiltro;
	}

	public function &setNombreDeTablaMuchosAMuchos($nombreDeTablaMuchosAMuchos) {
		$this->nombreDeTablaMuchosAMuchos=$nombreDeTablaMuchosAMuchos;
		return $this;
	}

	public function getNombreDeTablaMuchosAMuchos() {
		return $this->nombreDeTablaMuchosAMuchos;
	}

	public function &setRutaDeArchivo($rutaDeArchivo) {
		$this->rutaDeArchivo=$rutaDeArchivo;
		return $this;
	}

	public function getRutaDeArchivo() {
		return $this->rutaDeArchivo;
	}

	public function &setIdCampoNombreArchivo($idCampoNombreArchivo) {
		$this->idCampoNombreArchivo=$idCampoNombreArchivo;
		return $this;
	}

	public function getIdCampoNombreArchivo() {
		return $this->idCampoNombreArchivo;
	}

	public function &setPermiteFiltro($permiteFiltro) {
		$this->permiteFiltro=$permiteFiltro;
		return $this;
	}

	public function getPermiteFiltro() {
		return $this->permiteFiltro;
	}
        
    public function &setMostrarSoloEnActualizacion($val) {
		$this->mostrarSoloEnActualizacion=$val;
		return $this;
	}

	public function getMostrarSoloEnActualizacion() {
		return $this->mostrarSoloEnActualizacion;
	}
        public function mostrarSoloEnActualizacion(){
            return $this->mostrarSoloEnActualizacion;
		}
		
	
		public function &setCatalogoId($catalogoId) {
			$this->catalogoId=$catalogoId;
			return $this;
		}
	
		public function getCatalogoId() {
			return $this->catalogoId;
		}
	
}

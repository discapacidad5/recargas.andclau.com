<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pin extends CI_Model
{
private	$id,$descripcion,$valor,$credito,$pin,$tarifa,$estatus;

	function __construct()
	{
		parent::__construct();
	}
	
	public function getId() {
		return $this->id;
	}
	public function setId($id) {
		$this->id = $id;
	}
	public function getDescripcion() {
		return $this->descripcion;
	}
	public function setDescripcion($descripcion) {
		$this->descripcion = $descripcion;
	}
	
	public function getValor() {
		return $this->valor;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
	
	public function getCredito() {
		return $this->credito;
	}
	public function setCredito($credito) {
		$this->credito = $credito;
	}
	
	public function getEstatus() {
		return $this->estatus;
	}
	public function setEstatus($estatus) {
		$this->estatus = $estatus;
	}
	
	public function getPin() {
		return $this->pin;
	}
	public function setPin($pin) {
		$this->pin = $pin;
	}
	
	public function getTarifa() {
		return $this->tarifa;
	}
	public function setTarifa($tarifa) {
		$this->tarifa = $tarifa;
	}
}
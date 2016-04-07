<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pin extends CI_Model
{
private	$id,$descrip,$valor,$credito;

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
		return $this->descrip;
	}
	public function setDescripcion($descrip) {
		$this->descrip = $descrip;
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
}
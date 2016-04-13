<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class billetera_recargas extends CI_Model
{
private	$id,$usuario,$saldo,$disponible,$Saldos,$valor;

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
	public function getUsuario() {
		return $this->usuario;
	}
	public function setUsuario($usuario) {
		$this->usuario = $usuario;
	}
	
	public function getSaldos() {
		return $this->Saldos;
	}
	
	public function setSaldos($Saldos) {
		$this->Saldos = $Saldos;
	}	
	
	public function getSaldo() {
		return $this->Saldos['saldo'];
	}
	
	public function setSaldo($saldo) {
		$this->saldo = $saldo;
	}	
	
	public function getDisponible() {
		return $this->Saldos['disponible'];
	}
	
	public function setDisponible($disponible) {
		$this->disponible = $disponible;
	}
	public function getValor() {
		return $this->valor;
	}
	public function setUsuarioValor($usuario,$valor) {
		$this->usuario = $usuario;
		$this->valor = $valor;		
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
		
	
}
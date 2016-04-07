<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class billetera_recargas extends CI_Model
{
private	$id,$usuario,$saldo;

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
	
	public function getSaldo() {
		return $this->saldo;
	}
	public function setSaldo($saldo) {
		$this->saldo = $saldo;
	}
	
	
}
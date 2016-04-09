<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_billetera_recargas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		
	}
	
	function getSaldos(){
		$q=$this->db->query("SELECT 
								u.id,u.username,
								(select sum(valor) 
									from billetera_recargas_saldo 
									where id_billetera = b.id) saldo,
								(select sum(valor) 
									from billetera_recargas_canjeo 
									where id_billetera = b.id and estatus = 'ACT') disponible,
								(select sum(valor) 
									from billetera_recargas_retiro 
									where id_billetera = b.id) consumo
								FROM billetera_recargas b, users u
								WHERE b.id_user = u.id 
										and u.id = ".$this->billetera_recargas->getUsuario()."
								ORDER BY u.id");
		$q=$q->result();
		
		$disponible = $q[0]->disponible - $q[0]->consumo;
		$saldo = $q[0]->saldo - $q[0]->disponible;
		
		$Saldos = array(
				#'billetera' => $q[0]->saldo,
				'disponible' => ($disponible<0) ? 0 : $disponible,
				'saldo' => ($saldo<0) ? 0 : $saldo
		);
		
		$this->billetera_recargas->setSaldos($Saldos);
	}
	
	function agregarSaldoPadre(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => number_format(($this->billetera_recargas->getValor()*0.2),2),
				'tipo' => 'CATEGORIA'
		);
		
		$this->db->insert("billetera_recargas_saldo",$data);
		return $this->db->insert_id();
	}
	
	function agregarSaldo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => number_format(($this->billetera_recargas->getValor()*1.05),2),
				'tipo' => 'CARRITO'
		);
	
		$this->db->insert("billetera_recargas_saldo",$data);
		return $this->db->insert_id();
	}
	
	function agregarCanjeo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => number_format(($this->billetera_recargas->getValor()*1.05),2),
				'estatus' => 'ACT'
		);
	
		$this->db->insert("billetera_recargas_canjeo",$data);
		return $this->db->insert_id();
	}
	
	function getId(){
		$q=$this->db->query("SELECT id from billetera_recargas where id_user = ".$this->billetera_recargas->getUsuario());
		$q=$q->result();
		$this->billetera_recargas->setId($q[0]->id);
	}
	
}
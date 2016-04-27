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
								u.id,u.username,b.id bill,
								(select round(sum(valor),2) 
									from billetera_recargas_saldo 
									where id_billetera = b.id) saldo,
								(select round(sum(valor))
									from billetera_recargas_canjeo 
									where id_billetera = b.id and estatus = 'ACT') disponible,
								(select round(sum(valor),2) 
									from billetera_recargas_canjeo 
									where id_billetera = b.id) quitado,
								(select round(sum(valor),2) 
									from billetera_recargas_retiro 
									where id_billetera = b.id) consumo
								FROM billetera_recargas b, users u
								WHERE b.id_user = u.id 
										and u.id = ".$this->billetera_recargas->getUsuario()."
								ORDER BY u.id");
		$q=$q->result();
		
		$disponible = $q[0]->disponible - $q[0]->consumo;
		$saldo = $q[0]->saldo - $q[0]->quitado;

		$Saldos = array(
				#'billetera' => $q[0]->saldo,
				'disponible' => ($disponible<=0.011) ? 0 : $disponible,
				'saldo' => ($saldo<=0.011) ? 0 : $saldo
		);
		
		$this->billetera_recargas->setSaldos($Saldos);
	}
	
	function agregarSaldoPadre(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor()*0.2,
				'tipo' => 'CATEGORIA'
		);
		
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	function agregarSaldo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'tipo' => 'CARRITO'
		);
	
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	function agregarSaldo_BilleteraRec($id,$monto,$tipo){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'tipo' => $tipo
		);
	
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	
	function agregarCanjeo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'estatus' => 'ACT'
		);
	
		$this->db->insert("billetera_recargas_canjeo",$data);
		return true;
	}
	
	function agregarCanjeo_BilleteraRec($id,$monto,$estado){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'estatus' => $estado
				
		);
	
		$this->db->insert("billetera_recargas_canjeo",$data);
		return true;
	}
	
	function add_sub_billeteraRec($tipo,$id,$monto){
	  if ($tipo == "ADD") {
			$id_transac = $this->agregarSaldo_BilleteraRec ( $id, $monto,'EMPRESA');
		} else {
			$id_transac = $this->agregarCanjeo_BilleteraRec ( $id, $monto ,'EMPRESA' );
		}
	return $id_transac;
	}
	
	function agregarRetiro_BilleteraRec($id,$monto,$tipo,$transac){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'tipo' => $tipo,
				'id_transaccion' => $transac
		);
	
		$this->db->insert("billetera_recargas_retiro",$data);
		return true;
	}
	
	function agregarRetiro(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'tipo' => 'GSM',
				'id_transaccion' => $this->recarga->getId()
		);
	
		$this->db->insert("billetera_recargas_retiro",$data);
		return true;
	}
	
	function getId(){
		$q=$this->db->query("SELECT id from billetera_recargas where id_user = ".$this->billetera_recargas->getUsuario());
		$q=$q->result();
		$this->billetera_recargas->setId($q[0]->id);
	}
		
	function getId_($id){
		$q=$this->db->query("SELECT id from billetera_recargas where id_user = ".$id);
		$q=$q->result();
		return $q[0]->id;
	}
		
	function limpiar($tabla,$id){
		$this->db->query("DELETE FROM billetera_recargas_".$tabla."  where id_billetera = ".$id);
		return 0;
	}
}
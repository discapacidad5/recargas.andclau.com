<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_pin extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		
	}
	
	function ingresar_pin(){
		$dato=array(
				"id" =>				$this->pin->getId(),
				"descripcion" => 	$this->pin->getDescripcion(),
				"id_pin_tarifas" => 			$this->pin->getValor()
			//	"credito" => 		$this->pin->getCredito()
		);
		$this->db->insert("pin",$dato);
		
		return true;
	}
	
	function listar_pin()
	{
			$q=$this->db->query('select pin.id,descripcion,pin_tarifas.valor,pin_tarifas.credito  from pin,pin_tarifas where pin.id_pin_tarifas=pin_tarifas.id;
					');
			$result=$q->result();
			$this->pin->setPin($result);
	}
	function listar_tarifa()
	{
		$q=$this->db->query('select id,valor,credito from pin_tarifas;');
		$result=$q->result();
		$this->pin->setTarifa($result);
	}
	function editar_pin()
	{
		$q=$this->db->query('select id,descripcion,id_pin_tarifas from pin where id ='.$this->pin->getId());
		$result=$q->result();
		$this->pin->setPin($result);
	}
	
	function actualizar_pin(){
		$datos = array(
				'id' =>              $this->pin->getId(),
				'descripcion' =>     $this->pin->getDescripcion(),
				'id_pin_tarifas' =>           $this->pin->getValor()
			//	'credito' =>         $this->pin->getCredito()
				
		);
		$this->db->update("pin",$datos,"id = ".$_POST['id2']);
		return true;
	}
	
	function eliminar_pin(){
		
		$this->db->query('delete from pin where id = '.$this->pin->getId());
	}
	
}
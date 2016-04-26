<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_pin extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function ingresar_pin(){
				
		$dato=array(
				"id" =>				$this->pin->getId(),
				"descripcion" => 	$this->pin->getDescripcion(),
				"id_pin_tarifas" =>  $this->pin->getValor(),
				"costo" =>  $this->pin->getCosto()
			//	"credito" => 		$this->pin->getCredito()
		);
		
		#echo $dato['id']."|".$dato['descripcion']."|".$dato['id_pin_tarifas']."|".$dato['costo'];exit();
		
		$this->db->insert("pin",$dato);
		
		return true;
	}
	
	function listar_pin()
	{
			$q=$this->db->query('select pin.id,descripcion,pin_tarifas.valor,pin_tarifas.credito, pin.costo,pin.estatus from pin,pin_tarifas where pin.id_pin_tarifas=pin_tarifas.id;
					');
			$result=$q->result();
			$this->pin->setPin($result);
	}
	function listar_tarifa()
	{
		$q=$this->db->query('select * from pin_tarifas;');
		$result=$q->result();
		$this->pin->setTarifa($result);
	}
	function editar_pin()
	{
		$q=$this->db->query('select id,descripcion,id_pin_tarifas,costo from pin where id ='.$this->pin->getId());
		$result=$q->result();
		$this->pin->setPin($result);
	}
	
	function actualizar_pin(){
		$datos = array(
				'id' =>              $this->pin->getId(),
				'descripcion' =>     $this->pin->getDescripcion(),
				'id_pin_tarifas' =>  $this->pin->getValor(),
				"costo" =>  $this->pin->getCosto()
			//	'credito' =>         $this->pin->getCredito()
				
		);
		$this->db->update("pin",$datos,"id = ".$_POST['id2']);
		return true;
	}
	
	function eliminar_pin(){
		
		$this->db->query('delete from pin where id = '.$this->pin->getId());
	}
	
	function pin_comprar(){
		$datos = array(
					'estatus' => 'DES'	
		);
		$this->db->update("pin",$datos,"id = ".$this->pin->getId());
		return true;
	}
	
	function infoPin_comprado()
	{
		$q=$this->db->query("select pin.id,descripcion
				 from pin,pin_tarifas where pin.id_pin_tarifas=pin_tarifas.id
				and pin.id=".$this->pin->getId());
		$result=$q->result();
		$this->pin->setPin($result);
	}
	
	function listar_pines_deCompra()
	{
		$q=$this->db->query("select p.id,t.credito,t.valor,round(min(p.costo),2) costo
								from pin_tarifas t, pin p
								where t.id = p.id_pin_tarifas and estatus = 'ACT'
								group by p.id_pin_tarifas;");
		$result=$q->result();
		$this->factura_recargas->setCredito($result);
	}
	
	function insert_pinesComprados($pin,$id,$credito,$costo){
	
		$dato=array(
				"id_user" => 	$id,
				"id_pin" =>		$pin,
				"credito" =>	$credito,
				"costo" =>		$costo
		);
	
		#echo $dato['id']."|".$dato['descripcion']."|".$dato['id_pin_tarifas']."|".$dato['costo'];exit();
	
		$this->db->insert("histo_pinescompra",$dato);
	
		return true;
	}
	
	function listar_pinscomprados($id)
	{
		$q=$this->db->query("select id_pin,credito,costo,fecha from histo_pinescompra where id_user = ".$id." order by fecha desc");
		$result=$q->result();
		#echo var_dump($result);exit();
		$this->pin->setPinc($result);
	}
	
	
}
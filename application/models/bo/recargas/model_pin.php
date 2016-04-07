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
				"valor" => 			$this->pin->getValor(),
				"credito" => 		$this->pin->getCredito()
		);
		$this->db->insert("pin",$dato);
		
		return true;
	}
}
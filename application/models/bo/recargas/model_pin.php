<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
include APPPATH.'models/bo/recargas/pin.php';
class model_pin extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		$this->load->model('model_tipo_red');
	}
	
	function ingresar_pin($id,$descrip,$valor,$credito){
		$dato=array(
				"id" =>	$id,
				"descripcion" =>	$descrip,
				"valor" =>	$valor,
				"credito" =>	$credito
		);
		$this->db->insert("pin",$dato);
	}
}
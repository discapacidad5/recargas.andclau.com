<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_recargas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		
	}
	
	function setResponse($responses){
		$data = array();
		foreach ($responses as $response) {
			$key = split("=", $response)[0];
			$value = count(split("=", $response))>1 ? split("=", $response)[1] : "";
			if($key != "" && $value != "") {
				$data[$key] = $value;
			}
		}
		return $data;
	}
	
	function get_pais(){
		$q=$this->db->query("select * from country_recarga where code !='AAA'");
		return $q->result();
	}
	
	function get_pais_id($id){
		$q=$this->db->query("select * from country_recarga where code ='".$id."'");
		return $q->result();
	}
	
}
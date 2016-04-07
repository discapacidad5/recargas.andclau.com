<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_billetera_recargas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		
	}
	
	function getSaldo(){
		$q=$this->db->query("select * from billetera_recargas where id_user = ".$this->billetera_recargas->getUsuario());
		$q=$q->result();
		$this->billetera_recargas->setSaldo($q[0]->monto);
	}
}
<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_recargas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		
	}
	
	function setResponse($responses){
		$data = array();
		foreach ($responses as $response) {
			$key = explode("=", $response)[0];
			$value = count(explode("=", $response))>1 ? explode("=", $response)[1] : "";
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
	
	function insertar_gsm($values,$id){
		
		foreach ($values as $key => $item){
			$values[$key] = trim ($item," \t\n\r\0\x0B");
		}
		
		$data = array(
				
				  'transactionid' => $values['transactionid'],
				  'msisdn' => $values['msisdn'],
				  'destination_msisdn' => $values['destination_msisdn'],
				  'country' => $values['country'],
				  'countryid' => $values['countryid'],
				  'operator' => $values['operator'],
				  'operatorid' => $values['operatorid'],
				  'reference_operator' => $values['reference_operator'],
				  'originating_currency' => $values['originating_currency'],
				  'destination_currency' => $values['destination_currency'],
				  'wholesale_price' => $values['wholesale_price'],
				  'retail_price' => $values['retail_price'],
				  'local_info_amount' => $values['local_info_amount'],
				  'local_info_currency' => $values['local_info_currency'],
				  'skuid' => $values['skuid'],
				  'authentication_key' => $values['authentication_key'],
				  'error_code' => $values['error_code'],
				  'error_txt' => $values['error_txt'],
				  'id_user' => $id
				
		);		
		
		
		$this->db->insert("factura_recarga",$data);
		return $values['transactionid'];
	}
	
	
	function listar_facturaRecargas($id)
	{
		$q=$this->db->query('select 
							    transactionid,
							    msisdn,
							    destination_msisdn,
							    Country,
							    countryid,
							    operator,
							    operatorid,
							    originating_currency,
							    destination_currency,
							    concat(retail_price," ",originating_currency) retail_price,
								concat(local_info_amount," ",local_info_currency) local,
							    skuid,
							    fecha
							from
							    factura_recarga
							where id_user='.$id.' order by fecha desc');
		$result=$q->result();
		$this->factura_recargas->setFactura_rec($result);
	}
	
	function listar_facturaRecargasGeneral()
	{ 
		$q=$this->db->query('select 
							    p.nombre,
							    transactionid,
							    msisdn,
							    destination_msisdn,
							    Country,
							    countryid,
							    operator,
							    operatorid,
							    originating_currency,
							    destination_currency,
							    wholesale_price,
							    concat(retail_price," ",originating_currency) retail_price,
								concat(local_info_amount," ",local_info_currency) local,
							    skuid,
							    fecha
							from
							    factura_recarga,
							    user_profiles p								
							where
							    factura_recarga.id_user = p.user_id
							order by fecha desc');
		
		$result=$q->result();
		$this->factura_recargas->setFactura_recG($result);
	}
	
}
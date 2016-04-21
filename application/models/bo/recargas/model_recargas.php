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
	
	function insertar_gsm($values){
		
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
				  /*'balance' => $values['balance'],
				  'sms_sent' => $values['sms_sent'],
				  'info_txt' => $values['info_txt'],
				  'open_range' => $values['open_range'],
				  'open_range_local_amount_delivered' => $values['open_range_local_amount_delivered'],
				  'open_range_local_amount_requested' => $values['open_range_local_amount_requested'],
				  'open_range_local_currency' => $values['open_range_local_currency'],
				  'open_range_requested_amount' => $values['open_range_requested_amount'],
				  'open_range_requested_currency' => $values['open_range_requested_currency'],
				  'open_range_wholesale_cost' => $values['open_range_wholesale_cost'],
				  'open_range_wholesale_discount' => $values['open_range_wholesale_discount'],
				  'open_range_wholesale_currency' => $values['open_range_wholesale_currency'],
				  'open_range_wholesale_rate' => $values['open_range_wholesale_rate'],*/
				  'skuid' => $values['skuid'],
				  'authentication_key' => $values['authentication_key'],
				  'error_code' => $values['error_code'],
				  'error_txt' => $values['error_txt']
				
		);		
		
		
		$this->db->insert("factura_recarga",$data);
		return $values['transactionid'];
	}
	
	
	function listar_facturaRecargas($id)
	{
		$q=$this->db->query('select  transactionid,msisdn,destination_msisdn,Country,
                             countryid,operator,operatorid,
                             originating_currency,destination_currency,wholesale_price,
                            retail_price,skuid from erpMatamala.factura_recarga where id_user='.$id.';');
		$result=$q->result();
		$this->factura_recargas->setFactura_rec($result);
	}
	
	function listar_facturaRecargasGeneral()
	{
		$q=$this->db->query('select   user_profiles.nombre,transactionid,msisdn,destination_msisdn,Country,
countryid,operator,operatorid,
originating_currency,destination_currency,wholesale_price,
retail_price,skuid from erpMatamala.factura_recarga,erpMatamala.user_profiles where 
factura_recarga.id_user=user_profiles.user_id; ');
		$result=$q->result();
		$this->factura_recargas->setFactura_recG($result);
	}
	
}
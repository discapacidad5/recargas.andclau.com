<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class factura_recargas extends CI_Model
{
private	$factura_rec,$msisdn,$factura_recG,$credito;
	function __construct()
	{
		parent::__construct();
	}
	public function getFactura_rec() {
		return $this->factura_rec;
	}
	public function setFactura_rec($factura_rec) {
		$this->factura_rec= $factura_rec;
	}
	
	public function getFactura_recG() {
		return $this->factura_recG;
	}
	public function setFactura_recG($factura_recG) {
		$this->factura_recG= $factura_recG;
	
	}

	public function getMsisdn() {
		return $this->msisdn;
	}
	public function setMsisdn($msisdn) {
		$this->msisdn= $msisdn;
	}
	public function getDestination_msisdn() {
		return $this->destination_msisdn;
	}
	public function setDestination_msisdn($destination_msisdn) {
		$this->destination_msisdn= $destination_msisdn;
	}
	public function getCredito() {
		return $this->credito;
	}
	public function setCredito($credito) {
		$this->credito= $credito;
	}
	
}



<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class recarga extends CI_Model
{
private $url = 'https://fm.transfer-to.com/cgi-bin/shop/topup', 
		$login = 'andclau_soluciones', 
		$token = 'uqAmyTVCn7',
		$key, 
		$md5, 
		$action = 'simulation', 
		$account, 
		$destination_msisdn = '+573008423480',
		$msisdn,
		$valor;

	function __construct()
	{
		parent::__construct();
		//echo "hola";
	}
	
	public function getLogin() {
		return $this->login;
	}
	public function setLogin($login) {
		$this->login = $login;
	}
	public function getKey() {
		return $this->key;
	}
	public function setKey($key) {		
		$this->key = $key;
	}
	public function getMd5() {
		return $this->md5;
	}
	public function setMd5() {
		$md5=md5($this->login.$this->token.$this->key);
		$this->md5 = $md5;
	}
	public function getAction() {
		return $this->action;
	}
	public function setAction($action) {
		$this->action = $action;
	}
	public function getAccount() {
		return $this->account;
	}
	public function setAccount() {
		$this->setKey(time());
		$this->setMd5();
		$account = array(
				'login' => $this->login,
				'token' => $this->token,
				'key' => $this->key,
				'md5' => $this->md5,
				'url' => $this->url,
				'action' => $this->action,
		);			
		
		$this->account = $account;
	}
	public function getValor() {
		return $this->valor;
	}
	public function setValor($valor) {
		$this->valor = $valor;
	}
	public function getUrl() {
		return $this->url;
	}
	public function setUrl($url) {
		$this->url = $url;
	}
	public function getToken() {
		return $this->token;
	}
	public function setToken($token) {
		$this->token = $token;
	}
	public function getDestinationMsisdn() {
		return $this->destination_msisdn;
	}
	public function setDestinationMsisdn($destination_msisdn) {
		$this->destination_msisdn = $destination_msisdn;
	}
	public function getMsisdn() {
		return $this->msisdn;
	}
	public function setMsisdn($msisdn) {
		$this->msisdn = $msisdn;
	}
	
	
		
	
}
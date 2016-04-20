<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class billetera3 extends CI_Controller
{
	private $saldo, $disponible; 
	
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->load->library('cart');
		$this->lang->load('tank_auth');
		$this->load->model('ov/general');
		$this->load->model('ov/modelo_billetera');
		$this->load->model('ov/modelo_dashboard');
		$this->load->model('bo/model_bonos');
		$this->load->model('model_tipo_red');
		$this->load->model('bo/recargas/billetera_recargas');
		$this->load->model('bo/recargas/model_recargas');
		$this->load->model('bo/recargas/recarga');
		$this->load->model('bo/recargas/model_billetera_recargas');
		
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
	/*	if($this->general->isAValidUser($id,"OV") == false)
		{
			redirect('/ov/compras/carrito');
		}*/
	}

	function index()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}

		$id              = $this->tank_auth->get_user_id();
		
		if($this->general->isActived($id)!=0){
			redirect('/ov/compras/carrito');
		}


		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
		
		$this->billetera_recargas->setUsuario($id);	
		$this->model_billetera_recargas->getSaldos();	
		$this->saldo = $this->billetera_recargas->getSaldo();	
		$this->disponible = $this->billetera_recargas->getDisponible();	
		
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);

		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/billetera/dashboard');
		$this->template->build('website/ov/recargas/billetera');
	}
	
	function canjear()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
		
		if($this->general->isActived($id)!=0){
			redirect('/ov/compras/carrito');
		}	
	
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		$this->saldo = $this->billetera_recargas->getSaldo();
		$this->disponible = $this->billetera_recargas->getDisponible();
		
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
	
		$this->template->build('website/ov/recargas/canjear');
	}
	
	function historial_cuenta()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
		
		if($this->general->isActived($id)!=0){
			redirect('/ov/compras/carrito');
		}
	
	
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
	
		$historial=$this->modelo_billetera->get_historial_cuenta($id);
		$ganancias=$this->modelo_billetera->get_monto($id);
		$ganancias=$ganancias[0]->monto;
		$años = $this->modelo_billetera->anosCobro($id);

	/*	foreach ($historial as $comision){
				if($comision->fecha == $mes->fecha){
					$mes->valor+=$comision->valor;
				}
		}*/
		$this->template->set("historial",$historial);
		
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		//$this->template->set("historial",$historial);
		$this->template->set("ganancias",$ganancias);
		$this->template->set("años",$años);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/billetera/dashboard');
		$this->template->build('website/ov/billetera/historial_cuenta');
	}
	
	function historial()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
		
		if($this->general->isActived($id)!=0){
			redirect('/ov/compras/carrito');
		}
	
	
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
	
		$historial=$this->modelo_billetera->get_historial($id);
		$ganancias=$this->modelo_billetera->get_monto($id);
		$ganancias=$ganancias[0]->monto;
		$cobro=$this->modelo_billetera->get_cobro($id);
		$metodo_cobro=$this->modelo_billetera->get_metodo();
		$datatable=$this->modelo_billetera->datable($id);
		$años = $this->modelo_billetera->anosCobro($id);
		
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("historial",$historial);
		$this->template->set("ganancias",$ganancias);
		$this->template->set("datatable",$datatable);
		$this->template->set("metodo_cobro",$metodo_cobro);
		$this->template->set("años",$años);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/billetera/dashboard');
		$this->template->build('website/ov/billetera/historial');
	}

	function gsm()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
		
		if($this->general->isActived($id)!=0){
			redirect('/ov/compras/carrito');
		}	
	
		$pais  = $this->model_recargas->get_pais();
		$this->template->set("pais",$pais);
		
		$this->recarga->setAccount();
		$account=$this->recarga->getAccount();
		
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		$this->saldo = $this->billetera_recargas->getSaldo();
		$this->disponible = $this->billetera_recargas->getDisponible();
		
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
		$this->template->set("api",$account);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/gsm');
	}
	
	function agregar_saldo()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
		if(intval($_POST['cobro'])<=0){
			echo "ERROR <br>Valor del cobro invalido.";
			exit();
		}	
		
		$id=$this->tank_auth->get_user_id();
		
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		$this->saldo = number_format($this->billetera_recargas->getSaldo(),2);
		#$this->disponible = $this->billetera_recargas->getDisponible();
		
 
		if(($this->saldo-$_POST['cobro'])>=0){
			$this->billetera_recargas->setValor($_POST['cobro']);
			$this->model_billetera_recargas->agregarCanjeo();
			echo "Felicitaciones<br> Tu Canjeo se ha Realizado.";
		}else {
			echo "ERROR <br>No hay saldo para realizar el Canjeo.";
		}

	}
	
	function recargar_gsm() 
	{
		
		$id = $this->tank_auth->get_user_id();
		#$usuario=$this->general->get_username(2);
		
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
		
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();		
		
		if(!isset($_POST["destination_msisdn"])){return "No digitó numero!";}
		
		$sku = $_POST["sku"];
		$action = "simulation";//"topup";
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]		
		."&currency=USD"
		."&destination_currency=USD"
		."&skuid=".intval($sku[0])		
		."&product=".$sku[1]	
		."&delivered_amount_info=".$sku[1]	
		."&retail_price=".$sku[2]
		."&wholesale_price=".$sku[3]
		."&msisdn=AndClau_ST"
		."&action=".$action;
		
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		#$this->saldo = number_format($this->billetera_recargas->getSaldo(),2);
		$this->disponible = number_format($this->billetera_recargas->getDisponible(),2);
			
		if(($this->disponible-$sku[1])>=0){
			
			try {
				$response = file_get_contents($url);
			} catch (Exception $e) {
				return "";
			}
			
			$responses = explode("\n", $response );
			$values = $this->model_recargas->setResponse($responses);	
			
			//foreach ($values as $key => $item){
				//echo $key."=".$item."\n";
			//}exit();			
			
			$transaccion = ($values['error_code']==0) 
			? $this->model_recargas->insertar_gsm($values) : $values['transactionid'];
			$this->recarga->setId($transaccion);
			//echo $transaccion;//exit();
			
			$this->billetera_recargas->setValor($sku[1]);
			$this->model_billetera_recargas->agregarRetiro();
			
			
			echo ($values['error_code']==0 ) ? "Transaccion Exitosa" : "Transacción No pudo realizarse";
		}else {
			echo "ERROR <br>No hay saldo para realizar la Recarga.";
		}
		
		//echo $sku[0]."|".$sku[1]."|".$response;//"dentro de recargar_gsm";
		
		// $values['error_code'];//$responses;
		
		
	}
	
	function getmsisdn()
	{
		
		$zip  = $this->model_recargas->get_pais_id($_POST['id']);
		echo $zip ? "+".$zip[0]->zip : "";
	
	}
	
	function response_numero(){
	
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
	
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();
	
		if(!isset($_POST["destination_msisdn"])){return "";}
	
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]
		."&currency=USD
		&destination_currency=USD
		&action=".$_POST["action"];
	
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			return "";
		}
	
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
	
		//foreach ($values as $key => $item){
		//echo $key."=".$item."\n";
		//}
	
		if($values['error_code']!=0){return "";}
		
		$salida = $this->getOperators ($values);
	
		//$salida = isset($values['product_list']) ? $this->get_productlist ($values) : $this->get_products($values);
	
		echo ($values['error_code']==0) ? $salida : "";//  $values['operator']; //$response; $values['error_code'];//
	
	}
	

	private function getOperators($values) {
		
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
	
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&info_type=country"
		."&content=".$values['countryid']
		."&action=pricelist";
		
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			return "";
		}
		
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
		
		$operator_list =  explode(",", $values['operator']);
		$operator_id =  explode(",", $values['operatorid']);
		
		$salida='';
		$i=0;
		foreach ($operator_id as $operator)
		{
			$img = 'https://fm.transfer-to.com/logo_operator/logo-'.$operator.'-2.png';
$salida.=
'<div class="padding-2"><div class=" txt-color-black text-center col-xs-3 col-md-3  margin2">
		<img src="'.$img.'" height="70em" width="90%" alt="'.$operator_list[$i].'"/>'.			
			'<input type="radio" value="'.$operator
			.'|'.$operator_list[$i]
			.'" id="operator" name="operator" />
					</div><div>';
			$i++;
		}
		return $salida;
	}

	
	function response_operator(){	
		
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
		
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();		
		
		if(!isset($_POST["destination_msisdn"])){return "";}
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]		
		."&currency=USD
		&destination_currency=USD
		&action=".$_POST["action"];
		
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			return "";
		}
		
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
		
		//foreach ($values as $key => $item){
			//echo $key."=".$item."\n";
		//}
		
		if($values['error_code']!=0){return "";}
		
		//$salida = isset($values['product_list']) ? $this->get_productlist ($values) : $this->get_products($values);		 
		
		echo ($values['error_code']==0) ? $values['operator'] : "";// $values['error_code'];//$responses;
		
	}
	
	function validar_numero(){
	
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
	
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();
	
		if(!isset($_POST["destination_msisdn"])){return "";}
	
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]
		."&currency=USD
		&destination_currency=USD
		&action=".$_POST["action"];
	
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			return "";
		}
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
	
		echo ($values['error_code']==0) ? "OK" : "";// $values['error_code'];//$responses;
	
	}
	
	private function get_products($values) {
		$minimum_local =  $values['open_range_minimum_amount_local_currency'];
		#$maximum_local =  $values['open_range_maximum_amount_local_currency'];
		$minimum =  $values['open_range_minimum_amount_requested_currency'];
		$maximum =  $values['open_range_maximum_amount_requested_currency'];
		$increment_local =  $values['open_range_increment_local_currency'];
		$increment =  (($increment_local*$minimum)/$minimum_local);
		$skuid = $values['skuid'];
		#$open_range = $values['open_range'];
		#$requested_currency = $values['requested_currency'];
		#$operator= $values['operator'];
		#$operatorid= $values['operatorid'];
		#$countryid = $values['countryid'];
		#$country = $values['country'];
		
		$salida="";		
		$j=2;
		$salida.='<div style="overflow-y: scroll; height:200px;">';
		for ($i=($minimum ? $minimum : $increment);$i<$maximum;$i=$i+$increment)
		{
			if($i>$minimum){
			error_reporting(0);
			$salida.='<div class="well well-sm txt-color-white text-center col-xs-3 col-md-3 primary margin2">
						<h6>$ '.number_format($i,2).'</h6>
						'.//<h6>'.$retail_price_list[$i].'</h4>
						//<p>'.$wholesale_price_list[$i].'</p>
						'<input type="radio" value="'.intval($skuid).'|'.number_format($i,2).'|'.number_format($i,2).'|'.number_format($i,2).'|2'
						.'" id="monto" name="delivered_amount_info" />		
					</div>';
			
			//$j++;
			$i*=$j;
			}
		}
		$salida.='</div>';
		return $salida;
	}

	private function get_productlist($values) {
		$product_list =  explode(",", $values['product_list']);
		$retail_price_list = explode(",", $values['retail_price_list']);
		$wholesale_price_list = explode(",", $values['wholesale_price_list']);
		$skuid_list = explode(",", $values['skuid_list']);
		#$open_range = $values['open_range'];
		#$requested_currency = $values['requested_currency'];
		#$operator= $values['operator'];
		#$operatorid= $values['operatorid'];
		#$countryid = $values['countryid'];
		#$country = $values['country'];
	
		$salida="";
		$i=0;
		$salida.='<div style="overflow-y: scroll; height:200px;">';
		foreach ($product_list as $product)
		{
			if($i%5==0){
			$salida.='<div class="well well-sm txt-color-white text-center col-xs-3 col-md-3 primary margin2">
						<h6>$ '.$product.'</h6>
						'.//<h6>'.$retail_price_list[$i].'</h4>
							//<p>'.$wholesale_price_list[$i].'</p>
			'<input type="radio" value="'.$skuid_list[$i]
			.'|'.$product
			.'|'.$retail_price_list[$i]
			.'|'.$wholesale_price_list[$i]
			.'|1'
			.'" id="monto" name="delivered_amount_info" />
					</div>';
			}
			$i++;
		}
		$salida.='</div>';
		return $salida;
	}
	
	function ventas_comision(){
	
	
		$id=$_POST['id'];
		$fecha =isset($_POST['fecha']) ? $_POST['fecha'] : null;
	
		//echo "dentro de historial : ".$id;
	
		$ventas = ($fecha) 
		 	? $this->modelo_billetera->get_ventas_comision_fecha($id,$fecha) 
		 	: $this->modelo_billetera->get_ventas_comision_id($id);
		
		$total = 0 ;
	
		echo
		"<table id='datatable_fixed_column1' class='table table-striped table-bordered table-hover' width='80%'>
				<thead id='tablacabeza'>
					<th data-class='expand'>ID Venta</th>
					<th data-hide='phone,tablet'>Afiliado</th>
					<th data-hide='phone,tablet'>Red</th>
					<th data-hide='phone,tablet'>Items</th>
					<th data-hide='phone,tablet'>Total</th>
					<th data-hide='phone,tablet'>Comision</th>
				</thead>
				<tbody>";
	
	
		foreach($ventas as $venta)
		{
			
			echo "<tr>
			<td class='sorting_1'>".$venta->id_venta."</td>
			<td>".$venta->nombres."</td>
			<td>".$venta->red."</td>
			<td>".$venta->items."</td>
			<td>".number_format($venta->total, 2)."</td>
			<td> $	".number_format($venta->comision, 2)."</td>
			</tr>";
				
			$total += ($venta->comision);
	
		}
			
		echo "<tr>
			<td class='sorting_1'></td>			
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			</tr>";
		
		echo "<tr>			
			<td></td>			
			<td></td>
			<td></td>
			<td></td>
			<td class='sorting_1'><b>TOTAL:</b></td>
			<td><b> $	".number_format($total, 2)."</b></td>
			</tr>";
	
		echo "</tbody>
		</table><tr class='odd' role='row'>";
	
	}
	
}
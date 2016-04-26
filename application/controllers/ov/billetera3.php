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
		$this->load->model('ov/model_perfil_red');
		$this->load->model('ov/modelo_billetera');
		$this->load->model('ov/modelo_dashboard');
		$this->load->model('bo/model_bonos');
		$this->load->model('model_tipo_red');
		$this->load->model('bo/recargas/billetera_recargas');
		$this->load->model('bo/recargas/model_recargas');
		$this->load->model('bo/recargas/recarga');
		$this->load->model('bo/recargas/model_pin');
		$this->load->model('bo/recargas/pin');
		$this->load->model('bo/recargas/model_billetera_recargas');
		$this->load->model('bo/recargas/factura_recargas');
		$this->load->model('ov/modelo_recargas'); 
		$this->load->model('cemail');

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
		
		if($id == 2){ 
			$wallet = $this->check_wallet();
			$this->saldo = intval($wallet['balance']);
			$this->disponible = intval($wallet['wallet']);
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			$this->saldo = $this->billetera_recargas->getSaldo();	
			$this->disponible = $this->billetera_recargas->getDisponible();	
		}
		
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("id",$id);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);

		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/billetera/dashboard');
		$this->template->build('website/ov/recargas/billetera');
	}
	
	function check_wallet(){
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
		
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&action=check_wallet";		
		
		try {
			$response = file_get_contents ( $url );
		} catch ( Exception $e ) {
			return "";
		}
		
		$responses = explode ( "\n", $response );
		$values = $this->model_recargas->setResponse ( $responses );
		
		//foreach ($values as $key => $item){
			//echo $key."=".$item."<br/>";
		//}exit();
		
		return $values;
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

	function billeteraMenugsm()
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
		$this->template->build('website/ov/recargas/billeteraMenugsm');
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
		
		if($id == 2){ 
			$wallet = $this->check_wallet();
			$this->saldo = intval($wallet['balance']);
			$this->disponible = intval($wallet['wallet']);
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			$this->saldo = $this->billetera_recargas->getSaldo();	
			$this->disponible = $this->billetera_recargas->getDisponible();	
		}
		
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
	
   function listar_historialRecarga()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id              = $this->tank_auth->get_user_id();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->model_recargas->listar_facturaRecargas($id);
		$factura_rec = $this->factura_recargas->getFactura_rec();
	
		#echo var_dump($pin);exit();
	
		$this->template->set("facturas_rec",$factura_rec);
		
		
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/listar_historial_recargas');
	}

	function Menumultimedia()
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
		$this->template->set("id",$id);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
		$this->template->set("api",$account);
	
		$this->model_pin->listar_pines_deCompra();
		$credito = $this->factura_recargas->getCredito();
	
		if(count($credito)==0){redirect('/ov/billetera3');}
	
		#echo var_dump($pin);exit();
	
		$this->template->set("creditos",$credito);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/MenuMultimedia');
	}
	
	
	
	
function multimedia()
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
		$this->template->set("id",$id);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
		$this->template->set("api",$account);
	
		$this->model_pin->listar_pines_deCompra();
		$credito = $this->factura_recargas->getCredito();
		
		if(count($credito)==0){redirect('/ov/billetera3');}
		
		#echo var_dump($pin);exit();
		
		$this->template->set("creditos",$credito);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/comprar_pines');
	}
	
	function comprar_pin(){
	
		#echo "aqui!";
		
		$id = $_POST['id'];
		$credito  = $_POST['credito'];
		$pin  = $_POST['pin'];
		$monto  = intval($_POST['valor'])*0.1;
		$costo  = intval($_POST['valor']);	
		
		#echo $_POST['id']."|".$_POST['credito']."|".$_POST['valor'];
		$this->pin->setId ( $_POST ['id'] );
		
		
		if($id == 2){
			$wallet = $this->check_wallet();
			$this->saldo = intval($wallet['balance']);
			$this->disponible = intval($wallet['wallet']);
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			$this->saldo = $this->billetera_recargas->getSaldo();
			$this->disponible = $this->billetera_recargas->getDisponible();			
		}
		
		
		
		if(($this->disponible-$costo)<0){
			echo "ERROR <br>No hay saldo para realizar la Compra.";
			exit(); 
		}
		#echo "aqui!";exit();
		$this->pin->setId($pin);
		
	    $this->model_pin->insert_pinesComprados($pin,$id,$credito,$costo); 
		$this->model_billetera_recargas->agregarRetiro_BilleteraRec($id,$costo,'MEDIA',$pin);
		$this->model_billetera_recargas->agregarSaldo_BilleteraRec($id,$monto,'PIN');
	
		$data = array(
		 'email' => $this->model_perfil_red->get_email($id),
		 'username' => $this->model_perfil_red->get_username($id),
		 'pin' => $pin,
		 'credito' => $credito,
		 'costo' => $costo
		 );
		
		$email = $this->cemail->send_email(12, $data['email'], $data);
		
		echo $this->model_pin->pin_comprar() 
		? "Pin Comprado Exitosamente <br/> <ul><li>Numero de Pin 
		: ".$pin."</li></ul>" : "Pin no pudo ser Comprado ";
		
		//echo $email ? "Email Enviado" : "Falló envio de Email";
		//redirect('bo/recargas/listar_pines');
	
	}
	
	function listar_pinescomprados()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
		$id              = $this->tank_auth->get_user_id();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->model_pin->listar_pinscomprados($id);
		$pinc = $this->pin->getPinc();
	
		#echo var_dump($pinc);exit();
	
		$this->template->set("pinesc",$pinc);
		
		
		
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/list_compra_pines');
	}
	
	
	
	function agregar_saldo()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		
		$monto = $_POST['cobro']-0.01;
		
		if($monto<0){
			echo "ERROR <br>Valor del cobro invalido.";
			exit();
		}	
		
		$id=$this->tank_auth->get_user_id();
		
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		$this->saldo = $this->billetera_recargas->getSaldo();
		#$this->disponible = $this->billetera_recargas->getDisponible();
		
		if(($this->saldo-$monto)>0){
			$this->billetera_recargas->setValor($monto*1.05);
			$this->model_billetera_recargas->agregarCanjeo();
			$this->model_billetera_recargas->agregarSaldo_BilleteraRec($id,($monto*0.05),'ADICIONAL');
			echo "Felicitaciones<br> Tu Canjeo se ha Realizado.";
		}else {
			echo "ERROR <br>No hay saldo para realizar el Canjeo.";
		}

	}
	
	function testRecarga()
	{
	
		//$id = $this->tank_auth->get_user_id();
	
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
	
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();
	
		if(!isset($_POST["destination_msisdn"])){return "No digitó numero!";}
	
		$sku = $_POST["sku"];
		$operator = $_POST["operator"];
		$action = "simulation";
	
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]
		."&operatorid=".$operator[0]
		."&currency=USD"
		."&destination_currency=USD"
		."&skuid=".intval($sku[0])
		."&product=".$sku[1]
		."&delivered_amount_info=".$sku[1]
		."&retail_price=".$sku[2]
		."&wholesale_price=".$sku[3]
		."&msisdn=AndClau_ST"
		."&action=".$action;
	
						
		try {
			$response = file_get_contents ( $url );
		} catch ( Exception $e ) {
			redirect("/auth/login");
			exit();
		}
		
		$responses = explode ( "\n", $response );
		$values = $this->model_recargas->setResponse ( $responses );
		
		// foreach ($values as $key => $item){
		// echo $key."=".$item."<br/>";
		// }exit();
		
		echo  ($values['error_code']==0 ) ? $this->recargar_gsm() : ""; //$values ['error_code'];$response;
	
		//echo $sku[0]."|".$sku[1]."|".$response;//"dentro de recargar_gsm";
	
		// $values['error_code'];//$responses;	
	
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
		$operator = $_POST["operator"];
		$action = "simulation";//"topup";
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&destination_msisdn=".$_POST["destination_msisdn"]	
		."&operatorid=".$operator[0]
		//."&operator=".$operator[1]
		."&currency=USD"
		."&destination_currency=USD"
		."&skuid=".intval($sku[0])		
		."&product=".$sku[1]	
		."&delivered_amount_info=1"//.$sku[1]	
		."&retail_price=".$sku[2]
		."&wholesale_price=".$sku[3]
		."&msisdn=AndClau_ST"
		."&action=".$action;
		
		
		if($id == 2){
			$wallet = $this->check_wallet();
			#$this->saldo = intval($wallet['balance']);
			$this->disponible = intval($wallet['wallet']);
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			#$this->saldo = number_format($this->billetera_recargas->getSaldo(),2);
			$this->disponible = number_format($this->billetera_recargas->getDisponible(),2);
		}
		
		$this->billetera_recargas->setUsuario($id);
		$this->model_billetera_recargas->getSaldos();
		
			
		if(($this->disponible-$sku[1])>=0){
			
			try {
				$response = file_get_contents($url);
			} catch (Exception $e) {
				redirect("/auth/login");
				exit();
			}
			
			$responses = explode("\n", $response );
			$values = $this->model_recargas->setResponse($responses);	
			
			//foreach ($values as $key => $item){
				//echo $key."=".$item."<br/>";
			//}exit();			
			
			$transaccion = ($values['error_code']==0) 
			? $this->model_recargas->insertar_gsm($values,$id) : $values['transactionid'];
			$this->recarga->setId($transaccion);
			//echo $transaccion."|".$sku[1];exit();
			
			$this->billetera_recargas->setValor($sku[1]);
			$this->model_billetera_recargas->agregarRetiro();
			
			
			return ($values['error_code']==0 ) 
				? "<ul>"
					."<li>"
					."<h3>Valor: </b>$ ".$values['local_info_amount']
								." ".$values['local_info_currency']."</b><h3>"
					."</li>"
				."</ul><br/>
					Transaccion Exitosa" 
				: "Transacción No pudo realizarse";
		}else {
			return "ERROR <br>No hay saldo para realizar la Recarga.";
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
		."&currency=USD"
		."&destination_currency=USD"
		."&action=".$_POST["action"];
	
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			redirect("/auth/login");
			exit();
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
		
		$selected = intval($values['operatorid']);
		
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
			redirect("/auth/login");
			exit();
		}
		
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
		
		$operator_list =  explode(",", $values['operator']);
		$operator_id =  explode(",", $values['operatorid']);
		
		
		$salida='<div title="" class="padding-2"><div class=" txt-color-black text-center col-xs-3 col-md-3  margin2">
		<img id="ope_img" src="https://fm.transfer-to.com/logo_operator/logo-'.$selected.'-2.png" height="70em" width="90%" alt=""/>
					</div>';
		$salida.='<label class="col-md-9 select"><b>Operador</b> 
				<select style="width: 100%" onchange="operator_img()" id="operator" required	name="operator">';//'';
		$i=0;
		foreach ($operator_id as $operator)
		{
			$img = 'https://fm.transfer-to.com/logo_operator/logo-'.$operator.'-2.png';
			
$salida.= ($operator == $selected)
? '<option selected value="'.$operator.'|'.$operator_list[$i].'|'.$img.'">'.$operator_list[$i].'</option>'
: '<option value="'.$operator.'|'.$operator_list[$i].'|'.$img.'">'.$operator_list[$i].'</option>';
/*'<div title="'.$operator_list[$i].'" class="padding-2"><div class=" txt-color-black text-center col-xs-3 col-md-3  margin2">
		<img src="'.$img.'" height="70em" width="90%" alt="'.$operator_list[$i].'"/>'.			
			'<input type="radio" value="'.$operator
			.'|'.$operator_list[$i]
			.'" id="operator" name="operator" />
					</div><div>';*/
			$i++;
		}
		$salida.="</select></label><div>";
		return $salida;
	}

	
	function response_operator(){	
		//echo "aqui!";
		$this->recarga->setKey(time().rand());
		$this->recarga->setMd5();
		
		$login= $this->recarga->getLogin();
		$key = $this->recarga->getKey();
		$md5 = $this->recarga->getMd5();		
		
		if(!isset($_POST["destination_msisdn"])){return "";}
		
		$operator = $_POST["operator"];
		
		$url = $this->recarga->getUrl().
		"?login=".$login
		."&key=".$key
		."&md5=".$md5
		."&operatorid=".$operator[0]
		."&destination_msisdn=".$_POST["destination_msisdn"]
		."&delivered_amount_info=1"
		."&currency=USD"
		."&destination_currency=USD"
		."&action=".$_POST["action"];
		
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			redirect("/auth/login");
			exit();
		}
		
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
		
		//foreach ($values as $key => $item){
			//echo $key."=".$item."<br/>";
		//}exit();
		
		if($values['error_code']!=0){return "";}
		
		$salida = isset($values['product_list']) ? $this->get_productlist ($values) : $this->get_products($values);		 
		
		echo ($values['error_code']==0) ? $salida : "";//$values['operator'] $values['error_code'];//$responses;
		
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
		."&currency=USD"
		."&destination_currency=USD"
		."&action=".$_POST["action"];
	
		try {
			$response = file_get_contents($url);
		} catch (Exception $e) {
			redirect("/auth/login");
			exit();
		}
		
		$responses = explode("\n", $response );
		$values = $this->model_recargas->setResponse($responses);
	
		echo ($values['error_code']==0) ? "OK" : "";// $values['error_code'];//$responses;
	
	}
	
	private function get_products($values) {
		$minimum_local =  $values['open_range_minimum_amount_local_currency'];
		#$maximum_local =  $values['open_range_maximum_amount_local_currency'];
		$minimum =  $values['open_range_minimum_amount_requested_currency']+0.01;
		$maximum =  $values['open_range_maximum_amount_requested_currency'];
		$increment_local = $values['open_range_increment_local_currency'];
		$increment = (($increment_local*$minimum)/$minimum_local);
		$skuid = $values['skuid'];
		#$open_range = $values['open_range'];
		$origin_currency = $values['open_range_requested_currency'];
		$local_currency = $values['destination_currency'];
		#$operator= $values['operator'];
		#$operatorid= $values['operatorid'];
		#$countryid = $values['countryid'];
		#$country = $values['country'];
		
		$salida="";		
		$j=1;
		$local=$minimum_local;
		$salida.='<div style="overflow-y: scroll; height:200px;">';
		for ($i=($minimum ? $minimum : $increment);$i<$maximum;$i=$i+$increment)
		{	
			if(($local/$j)==$minimum_local){
			
			error_reporting(0);
			$salida.='<div class="well well-sm txt-color-white text-center col-xs-3 col-md-3 primary margin2">
						<h6>$ '.$local.' '.$local_currency.'</h6>
						<p>$ '.number_format($i,2).' '.$origin_currency.'</p>
						'.//<h6>'.$retail_price_list[$i].'</h4>
						//<p>'.$wholesale_price_list[$i].'</p>
						'<input type="radio" value="'.intval($skuid)
						.'|'.$i
						.'|'.$i
						.'|'.$i
						.'|2|'.$local
						.'|'.$local_currency
						.'" id="monto" name="delivered_amount_info" />		
					</div>';
			
			$j++;
			//$i*=$j;			
			}
			$local+=$increment_local;
		}
		$salida.='</div>';
		return $salida;
	}

	private function get_productlist($values) {
		$product_list =  explode(",", $values['product_list']);
		$retail_price_list = explode(",", $values['retail_price_list']);
		$wholesale_price_list = explode(",", $values['wholesale_price_list']);
		$local_list =  explode(",", $values['local_info_amount_list']);
		$skuid_list = explode(",", $values['skuid_list']);
		#$open_range = $values['open_range'];
		$origin_currency = $values['destination_currency'];
		$local_currency = $values['local_info_currency'];
		#$requested_currency = $values['requested_currency'];
		#$operator= $values['operator'];
		#$operatorid= $values['operatorid'];
		#$countryid = $values['countryid'];
		#$country = $values['country'];
	
		$salida="";
		$i=0;
		$j=0;
		$salida.='<div style="overflow-y: scroll; height:200px;">';
		foreach ($product_list as $product)
		{
			if($i==$j){
			$salida.='<div class="well well-sm txt-color-white text-center col-xs-3 col-md-3 primary margin2">
						<h6>$ '.$local_list[$i].' '.$local_currency.'</h6>
						<p>$ '.$product.' '.$origin_currency.'</p>
						'.//<h6>'.$retail_price_list[$i].'</h4>
							//<p>'.$wholesale_price_list[$i].'</p>
			'<input type="radio" value="'.$skuid_list[$i]
			.'|'.$product
			.'|'.$retail_price_list[$i]
			.'|'.$wholesale_price_list[$i]
			.'|1|'.$local_list[$i]
			.'|'.$local_currency
			.'" id="monto" name="delivered_amount_info" />
					</div>';
			($i==0) ? $j+=4 : $j+=5;
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
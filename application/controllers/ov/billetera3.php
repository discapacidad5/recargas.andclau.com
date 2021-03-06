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
			$this->saldo = $wallet['balance'];
			$this->disponible = $wallet['wallet'];
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
		
		$billetera= $this->model_billetera_recargas->Empresa($values);
				
		
		return $billetera;
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
	
	function vender()
	{
		
		//echo "Aqui!"; exit();
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
	
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
		
		
		$virtual = $this->getbilleteraVirtual();
		
		$this->template->set("virtual",$virtual);
		
		$this->template->build('website/ov/recargas/vender');
	}
	
	function venderSaldo(){
		
		$id = $this->tank_auth->get_user_id();
		$monto = $_POST['cobro'];
		$descripcion = 'Venta de Saldo de billetera recargas, retencion de $ 3 USD.';
		$tipo = 'ADD';
		
		$monto2 = ($monto-3.0);
		
		if($monto<200.0){echo "<p>Transacción No puede realizarse</p></br>
				<p>Debes obtener en tu billetera al menos <strong> $ 200 USD</strong></p>";}
		
		$transact = $this->modelo_billetera->add_sub_billetera($tipo,$id,$monto2,$descripcion);
		$this->model_billetera_recargas->agregarCanjeo_BilleteraRec($id,$monto,'DES');
		$this->model_billetera_recargas->agregarSaldo_BilleteraRec(2,$monto,'VENTA');
		$this->model_billetera_recargas->alta_venta_saldo($id,$monto2,$monto);
		
		$data = array(
				'email' => $this->model_perfil_red->get_email($id),
				'username' => $this->model_perfil_red->get_username($id),
				'id_transaccion' => $transact,
				'tipo_t' => "Agregado",
				'descripcion_t' => $descripcion,
				'monto_t' => $monto2
		);
		
		$email = $this->cemail->send_email(10, $data['email'], $data);
		
		echo $transact ? "<ul>"
					."<li>"
					."<h3>Valor: </b>$ ".$monto2." USD</b><h3>"
					."<h3>Retención : $ 3 USD <h3>"
					."</li>"
				."</ul><br/>
					Transaccion Exitosa"  : "Falló la Transacción";
		//echo $email ? "Email Enviado" : "Falló envio de Email";
		
	}
	
	
	function getbilleteraVirtual(){
		
		$id = $this->tank_auth->get_user_id ();
		
		$redes = $this->model_tipo_red->listarTodos ();
		$redesUsuario = $this->model_tipo_red->RedesUsuario ( $id );
		
		$ganancias = array ();
		$comision_directos = array ();
		$bonos = array ();
		
		foreach ( $redesUsuario as $red ) {
			array_push ( $bonos, $this->model_bonos->ver_total_bonos_id_red ( $id, $red->id ) );
			array_push ( $ganancias, $this->modelo_billetera->get_comisiones ( $id, $red->id ) );
			array_push ( $comision_directos, $this->modelo_billetera->getComisionDirectos ( $id, $red->id ) );
		}
		
		$comision_todo = array (
				'directos' => $comision_directos,
				'ganancias' => $ganancias,
				'bonos' => $bonos,
				'redes' => $redesUsuario 
		);
		
		$total_bonos = $this->model_bonos->ver_total_bonos_id ( $id );
		
		$comisiones = $this->modelo_billetera->get_total_comisiones_afiliado ( $id );
		$cobro = $this->modelo_billetera->get_cobros_total ( $id );
		$cobroPendientes = $this->modelo_billetera->get_cobros_pendientes_total_afiliado ( $id );
		$retenciones = $this->modelo_billetera->ValorRetencionesTotales ( $id );
		
		$transaction = $this->modelo_billetera->get_total_transacciones_id ( $id );
		
		$total = 0;
		$i = 0;
		$total_transact = 0;
		// var_dump($comision_todo);
		for($i = 0; $i < sizeof ( $comision_todo ["redes"] ); $i ++) {
			
			$totales = (intval ( $comision_todo ["ganancias"] [$i] [0]->valor ) != 0 || sizeof ( $comision_todo ["bonos"] [$i] ) != 0) ? 0 : 'FAIL';
			
			// echo $totales."|";
			
			if ($totales !== 'FAIL') {
				
				if ($comision_todo ["ganancias"] [$i] [0]->valor != 0) {
					
					if ($comision_todo ["ganancias"] [$i] [0]->valor) {
						$totales += ($comision_todo ["ganancias"] [$i] [0]->valor);
					}
				}
				
				if ($comision_todo ["bonos"] [$i]) {
					
					for($k = 0; $k < sizeof ( $comision_todo ["bonos"] [$i] ); $k ++) {
						if ($comision_todo ["bonos"] [$i] [$k]->valor != 0) {
							$totales += ($comision_todo ["bonos"] [$i] [$k]->valor);
						}
					}
				}
				
				if ($totales != 0) {
					$total += ($totales);
				}
			}
		}
		
		if ($transaction) {
			if ($transaction ['add']) {
				$total_transact += $transaction ['add'];
			}
			if ($transaction ['sub']) {
				$total_transact -= $transaction ['sub'];
			}
		}
		
		$retenciones_total = 0;
		foreach ( $retenciones as $retencion ) {
			$retenciones_total += $retencion ['valor'];
			$total;
		}
		
		foreach ( $cobro as $cobros ) {
			
			if ($cobros->monto == null) {
				$cobro = 0;
			} else {
				$cobro = $cobros->monto;
			}
		}
		$saldo_neto = ($total - ($cobro + $retenciones_total + $cobroPendientes) + ($total_transact));
		
		return $saldo_neto;
	
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
	
		if($id == 2){ 
			$wallet = $this->check_wallet();
			$this->disponible = $wallet['balance'];
			#$this->disponible = $wallet['wallet'];
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
			$this->disponible = $wallet['balance'];
			#$this->disponible = $wallet['wallet'];
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
	
		if($id == 2){ 
			$wallet = $this->check_wallet();
			$this->disponible = $wallet['balance'];
			#$this->disponible = $wallet['wallet'];
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
		$this->template->set("id",$id);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
		$this->template->set("api",$account);
	
		$this->model_pin->listar_pines_deCompra();
		$credito = $this->factura_recargas->getCredito();
	
		#if(count($credito)==0){redirect('/ov/billetera3');}
	
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
			$this->saldo = $wallet['balance'];
			$this->disponible = $wallet['wallet'];
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
		
		//foreach ($values as $key => $item){
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
			$this->disponible = $wallet['balance'];
			#$this->disponible = $wallet['wallet'];
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
			
			if($values['error_code']!=0){return "Transacción No pudo realizarse";}
			
			//foreach ($values as $key => $item){
				//echo $key."=".$item."<br/>";
			//}exit();			
			
			$transaccion = ($values['error_code']==0) 
			? $this->model_recargas->insertar_gsm($values,$id) : $values['transactionid'];
			$this->recarga->setId($transaccion);
			//echo $transaccion."|".$sku[1];exit();
			 
			$this->billetera_recargas->setValor($sku[1]);
			($values['error_code']==0) ? $this->model_billetera_recargas->agregarRetiro() : '' ;
			
			
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
	
	function transferir_otro()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
	
	
		$id = $this->tank_auth->get_user_id();
		$style = $this->general->get_style($id);
		$this->template->set("id",$id);
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
	
	
		if($id<=2)
			$cantidadRedes = $this->model_tipo_red->cantidadRedes();
		else
			$cantidadRedes = $this->model_tipo_red->cantidadRedesUsuario($id);
	
		if(sizeof($cantidadRedes)==0)
			redirect('/');
		if(sizeof($cantidadRedes)==1)
			redirect('/ov/billetera3/transferir_red?id='.$cantidadRedes[0]->id);
	
		$redes = $this->model_tipo_red->RedesUsuario($id);
		$this->template->set("redes",$redes);
	
		$this->template->build('website/ov/recargas/transferencia/redes');
	}
	
	function transferir_red()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
	
	
	
		$id_red          = $_GET['id'];
	
		$usuario         = $this->model_perfil_red->datos_perfil($id);
		$telefonos       = $this->model_perfil_red->telefonos($id);
		$sexo            = $this->model_perfil_red->sexo();
		$pais            = $this->model_perfil_red->get_pais();
		$style           = $this->general->get_style($id);
		$dir             = $this->model_perfil_red->dir($id);
		$civil           = $this->model_perfil_red->edo_civil();
		$tipo_fiscal     = $this->model_perfil_red->tipo_fiscal();
		$estudios        = $this->model_perfil_red->get_estudios();
		$ocupacion       = $this->model_perfil_red->get_ocupacion();
		$tiempo_dedicado = $this->model_perfil_red->get_tiempo_dedicado();
	
		$red 			 = $this->model_afiliado->RedAfiliado($id, $id_red);
	
		if($id>2){
			$estaEnRed 	 = $this->model_tipo_red->validarUsuarioRed($id,$id_red);
	
			if(!$estaEnRed)
				redirect('/');
	
		}
	
		//$premium         = $red[0]->premium;
		$afiliados       = $this->model_perfil_red->get_afiliados($id_red, $id);
		//$planes 		 = $this->model_planes->Planes();
	
		$image 			 = $this->model_perfil_red->get_images($id);
		$red_forntales 	 = $this->model_tipo_red->ObtenerFrontalesRed($id_red );
	
		$img_perfil="/template/img/empresario.jpg";
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
		$this->template->set("id",$id);
		$this->template->set("style",$style);
		$this->template->set("afiliados",$afiliados);
		$this->template->set("sexo",$sexo);
		$this->template->set("civil",$civil);
		$this->template->set("pais",$pais);
		$this->template->set("tipo_fiscal",$tipo_fiscal);
		$this->template->set("estudios",$estudios);
		$this->template->set("ocupacion",$ocupacion);
		$this->template->set("tiempo_dedicado",$tiempo_dedicado);
		$this->template->set("img_perfil",$img_perfil);
		$this->template->set("red_frontales",$red_forntales);
		//$this->template->set("premium",$premium);
		//$this->template->set("planes",$planes);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/transferencia/transferir_red');
	}
	
	function nueva_tranferencia(){
		//echo "dentro de botbox ";
	
		//$datos_banner=$this->model_admin->datos_banner();
		$img = $this->model_admin->img_banner();
	
		$empresa  = $this->model_admin->val_empresa_multinivel();
		$this->template->set("empresa",$empresa);
		$this->template->set("img",$img);
		$this->template->set("debajo_de",$_POST['id_debajo']);
		$this->template->set("lado",$_POST['lado']);
		$this->template->set("red",$_POST['red']);
	
		$this->template->build('website/ov/recargas/invitar/ver');
	
	}
	
	
	function validarPass() {
		
		$contraseña = $_POST['pass'];
		$id              = $this->tank_auth->get_user_id();
		$username = $this->model_perfil_red->get_username($id);
		
		
	$validacion = $this->tank_auth->login($username,$contraseña,"",1,0);
	
	echo $validacion;
	
	}
	
	
	function SMenu_transfer()
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
		$this->template->build('website/ov/recargas/transferencia/SubMTransfer');
	}
	
	function listar_HTransferencia()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id              = $this->tank_auth->get_user_id();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->model_billetera_recargas->listar_transferencia_recargas($id);
		$factura_rec = $this->factura_recargas->getFactura_rec();
	
		#echo var_dump($pin);exit();
	
		$this->template->set("facturas_rec",$factura_rec);
	
	
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/ov/header');
		$this->template->set_partial('footer', 'website/ov/footer');
		$this->template->build('website/ov/recargas/transferencia/listar_HTransfer');
	}
	
	
	function enviar_transferencia(){
	
		//echo "dentro de enviar";
	
		$afiliado = $_POST['id'];
		$cobro = $_POST['cobro'];
		$id = $this->tank_auth->get_user_id();
		
		if($id == 2){
			$wallet = $this->check_wallet();
			$this->saldo = $wallet['balance'];
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			$this->saldo = $this->billetera_recargas->getSaldo();
		}		
		
		if(($this->saldo-$cobro)<0){
			echo "ERROR <br>No hay saldo suficiente para realizar la Transferencia.";
			exit();
		}
	
		$cobro2 = ($cobro-3.0);
		
		$validar = $this->model_billetera_recargas->agregarSaldo_BilleteraRec($afiliado,$cobro2,'TRANSFER');
		$this->model_billetera_recargas->agregarCanjeo_BilleteraRec($id,$cobro,'DES');
		$this->model_billetera_recargas->tranferencia_recargas($id,$afiliado,$cobro2);
		
		$data = array(
				'email' => $this->model_perfil_red->get_email($afiliado),
				'username' => $this->model_perfil_red->get_username($afiliado),
				'id_transaccion' => "Transferido de Usuario: ".$this->model_perfil_red->get_username($id),
				'tipo_t' => "Agregado",
				'monto_t' => $cobro2
		);
		
		$this->CEmail ( $data,11 );
	
		$data2 = array(
				'email' => $this->model_perfil_red->get_email($id),
				'username' => $this->model_perfil_red->get_username($id),
				'id_transaccion' => "Transferido a: ".$this->model_perfil_red->get_username($afiliado),
				'tipo_t' => "Descontado, retencion de $ 3 USD",
				'monto_t' => $cobro
		);		
		
		$this->CEmail ( $data2,11 );
		
		echo $validar
		? 		"<ul>"
					."<li>"
					."<h3>Valor: </b>$ ".$cobro2." USD</b><h3>"
					."<h3>Retención : $ 3 USD <h3>"
					."</li>"
				."</ul><br/>
					Transaccion Exitosa" : "Transacción no pudo ser Realizada ";
		
		//echo $email ? "Email Enviado" : "Falló envio de Email";
		//redirect('bo/recargas/listar_pines');
	
	}
	
	private function CEmail($data,$type) {		
		
		$email = $this->cemail->send_email($type, $data['email'], $data);
		
	}

	
	function transferencia_usu()
	{
		$id = $this->tank_auth->get_user_id();
	
		$afiliado = $_POST['afiliado'];
		
		$usuario2=$this->general->get_username($afiliado);
	
		if(!$usuario2||$afiliado<=1){echo "Este ID no existe, intente con otro";exit();}
		
		$pais  = $this->model_recargas->get_pais();
		$this->template->set("pais",$pais);
	
		$this->recarga->setAccount();
		$account=$this->recarga->getAccount();
	
		if($id == 2){ 
			$wallet = $this->check_wallet();
			$this->saldo = $wallet['balance'];
		}else{
			$this->billetera_recargas->setUsuario($id);
			$this->model_billetera_recargas->getSaldos();
			$this->saldo = $this->billetera_recargas->getSaldo();	
		}
		
		$this->billetera_recargas->setUsuario($afiliado);
		$this->model_billetera_recargas->getSaldos();
		$this->disponible = $this->billetera_recargas->getSaldo();
	
		$usuario=$this->general->get_username($id);
		$style=$this->general->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("usuario",$usuario);
		$this->template->set("usuario2",$usuario2);
		$this->template->set("id",$id);
		$this->template->set("afiliado",$afiliado);
		$this->template->set("saldo",$this->saldo);
		$this->template->set("disponible",$this->disponible);
		$this->template->set("api",$account);
	
			
		
		$this->template->build('website/ov/recargas/transferencia/transferencia_usu');
	}
	
	
	
	
function get_red_afiliar()
	{
		$id_red=$_POST['red'];
		$id_afiliado=$_POST['id'];
		
		$red 	 = $this->model_tipo_red->ObtenerFrontalesRed($id_red);
		$frontalidadRed= $red[0]->frontal;
		$profundidadRed=$red[0]->profundidad;

		$INFINITO=0;
		
		if($this->tank_auth->get_user_id()>2){
			$nivel=$_POST['profundidad'];
		}else {
			$nivel=$INFINITO;
			$profundidadRed=$INFINITO;
		}
		
		if(!$this->getHayEspacioParaAfiliarProfundidad ( $nivel ,$profundidadRed))
			return false;


		if($frontalidadRed==$INFINITO){
			$frontalesUsuario = $this->model_perfil_red->get_cantidad_de_frontales($id_afiliado,$id_red);
			$frontalesUsuario=$frontalesUsuario[0]->frontales;
			$frontalidadRed=$frontalesUsuario+1;
		}

		$this->printRedParaAfiliar ( $id_red,$id_afiliado,$frontalidadRed,$nivel);

		
	}

	private function getHayEspacioParaAfiliarProfundidad($nivel,$profundidadRed) {
		if($profundidadRed>0){
			if($nivel >= $profundidadRed){
				return false;
			}
		}
		return true;
	}

	private function printRedParaAfiliar($id_red,$id_afiliado, $frontales,$nivel) {
	
		echo "<ul>";
		for($lado=0;$lado<$frontales;$lado++){
			$afiliado = $this->model_perfil_red->get_afiliado_por_posicion($id_red,$id_afiliado,$lado);
			
			if($afiliado){
				$this->printPosicionAfiliado ( $nivel, $afiliado);
			}else {
				$sponsor=$this->model_perfil_red->get_name($id_afiliado);
				//$this->printEspacioParaAfiliar ($sponsor, $id_afiliado, $lado );

			}
		}
		echo "</ul>";
		
	}
	
	private function printPosicionAfiliado($nivel, $afiliado) {
		$img_perfil = $this->setImagenAfiliado ($afiliado[0]->id_afiliado);
		$colorDirecto=$this->getDirectoColor($afiliado[0]->directo);
		
		echo "  <li id='".$afiliado[0]->id_afiliado."'>
		        	<a class='quitar' onclick='subred(".$afiliado[0]->id_afiliado.",".($nivel+1).")' style='background: url(".$img_perfil."); background-size: cover; background-position: center;' href='javascript:void(0)'></a>
		        	  <div onclick='detalles(".$afiliado[0]->id_afiliado.")' class='".$colorDirecto."'>".$afiliado[0]->afiliado."<br />Detalles</div>
                     <div> <input type='button' class='btn btn-success' value='Agregar' onclick='detalles2(".$afiliado[0]->id_afiliado.")' class='".$colorDirecto."'><br /></div>
		            
            	</li>";
	}
	
	private function getDirectoColor($directo){
		$id_usuario=$this->tank_auth->get_user_id();
		if($id_usuario==$directo)
			return 'todo1';
		return 'todo';
	}
	
	
	
	private function printEspacioParaAfiliar($sponsor,$id_afiliado, $lado) {
		echo "<li>
				<a onclick=\"botbox('".$sponsor[0]->nombre."',".$id_afiliado.",".$lado.")\" href='javascript:void(0)'>Afiliar Aqui</a>
			  </li>	";
	}

	private function setImagenAfiliado($id_afiliado) {
		$image 			 = $this->model_perfil_red->get_images($id_afiliado);
		$img_perfil='/template/img/empresario.jpg';
		foreach ($image as $img)
		{
			$cadena=explode(".", $img->img);
			if($cadena[0]=="user")
			{
				$img_perfil=$img->url;
			}
		}
		
		return $img_perfil;
	}
	
}
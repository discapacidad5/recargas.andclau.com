<?php if (! defined ( 'BASEPATH' )) exit ( 'No direct script access allowed' );

class recargas extends CI_Controller {
	
	function __construct() {
		parent::__construct ();
		
		$this->load->helper ( array ('form','url' ) );
		
		$this->load->library ( 'form_validation' );
		$this->load->library ( 'security' );
		$this->load->library ( 'tank_auth' );
		$this->lang->load ( 'tank_auth' );
		$this->load->model ( 'bo/modelo_dashboard' );
		$this->load->model ( 'bo/model_admin' );
		$this->load->model ( 'bo/model_bonos' );
		$this->load->model ( 'bo/model_mercancia' );
		$this->load->model ( 'bo/general' );
		$this->load->model ( 'bo/recargas/pin' );
		$this->load->model ( 'bo/recargas/model_pin' );
		$this->load->model ( 'bo/recargas/model_recargas' );
		$this->load->model ( 'bo/recargas/model_billetera_recargas' );
		$this->load->model ( 'bo/recargas/factura_recargas' );
		$this->load->model ( 'bo/recargas/recarga' );
	}
	
	function index() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/index' );
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
	
	function pines() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/pines' );
	}
	
	function nuevo_pin() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$this->model_pin->listar_tarifa ();
		$tarifas = $this->pin->getTarifa ();
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		$this->template->set ( "tarifas", $tarifas );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/nuevo_pin' );
	}
	
	function ingresar_pin() {
		$this->pin->setId ( $_POST ['id'] );
		$this->pin->setDescripcion ( isset($_POST ['descripcion']) ? $_POST ['descripcion'] : "no define" );
		$this->pin->setValor( $_POST ['valor'] );
		$this->pin->setCosto($_POST['costo']);
		
		#echo $_POST['id']."|".$_POST['descripcion']."|".$_POST['valor']."|".$_POST['costo'];exit();
		
		echo $this->model_pin->ingresar_pin () ? "Pin Creado Exitosamente" : "Pin no pudo ser Creado";
	}
	
	function listar_pines() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "style", $style );
		
		$this->model_pin->listar_pin ();
		$pin = $this->pin->getPin ();
		
		// echo var_dump($pin);exit();
		
		$this->template->set ( "pines", $pin );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/listar_pines' );
	}
	
	function listar_tarifa() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$style = $this->modelo_dashboard->get_style ( 1 );
		
		$this->template->set ( "style", $style );
		
		$this->model_pin->listar_tarifa ();
		$tarifa = $this->pin->getTarifa ();
		
		// echo var_dump($pin);exit();
		
		$this->template->set ( "tarifas", $tarifa );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/nuevo_pin' );
	}
	
	function editar_pin() {
		// $id = $this->tank_auth->get_user_id();
		// $style = $this->general->get_style($id);
		$this->pin->setId ( $_POST ['id'] );
		$this->model_pin->editar_pin ();
		$pin = $this->pin->getPin ();
		
		// echo "dentro de editar";
		
		$this->model_pin->listar_tarifa ();
		$tarifas = $this->pin->getTarifa ();
		
		$this->template->set ( "tarifas", $tarifas );
		$this->template->set ( "pin", $pin );
		$this->template->build ( 'website/bo/recargas/editar_pin' );
	}
	
	function actualizar_pin() {
		$this->pin->setId ( $_POST ['id'] );
		$this->pin->setDescripcion ( $_POST ['descripcion'] ? $_POST ['descripcion'] : "no define" );
		$this->pin->setValor ( $_POST ['valor'] );
		$this->pin->setCosto($_POST['costo']);
		
		// echo $_POST['id']."|".$_POST['descripcion']."|".$_POST['valor']."|".$_POST['id2'];
		
		echo $this->model_pin->actualizar_pin () ? "Pin actualizado Exitosamente" : "Pin no pudo ser actualizado ";
		// redirect('bo/recargas/listar_pines');
	}
	
	function eliminar_pin() {
		if (isset ( $_POST ['id'] )) {
			$this->pin->setId ( $_POST ['id'] );
		}
		echo $this->model_pin->eliminar_pin () ? "Pin eliminado Exitosamente" : "Pin no pudo ser eliminado";
	}
	
	function listar_pinescompra2()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id              = $this->tank_auth->get_user_id();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->model_pin->listar_pinscompra2();
		$pinc = $this->pin->getPinc();
	
		#echo var_dump($pinc);exit();
	
		$this->template->set("pinesc",$pinc);
	
	
	
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/listar_pinescomprados');
	}
	
	function historialRec() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
		
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
		
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/historial_recargas_transfer' );
	}
	
	function historial_transfer_usuRecarga() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
	
		$id = $this->tank_auth->get_user_id ();
		$usuario = $this->general->get_username ( $id );
	
		if ($usuario [0]->id_tipo_usuario != 1) {
			redirect ( '/auth/logout' );
		}
	
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
	
		$this->model_billetera_recargas->listar_transferencia_recargasG();
		$factura_rec = $this->factura_recargas->getFactura_rec();
	
		#echo var_dump($pin);exit();
	
		$this->template->set("facturas_rec",$factura_rec);
	
	
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/listar_Htransfer_usu' );
	}
	
	
	function listar_historialRecargaGeneral() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		$id = $this->tank_auth->get_user_id ();
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$this->model_recargas->listar_facturaRecargasGeneral ();
		$factura_recG = $this->factura_recargas->getFactura_recG ();
		
		// echo var_dump($pin);exit();
		
		$this->template->set ( "facturas_recG", $factura_recG );
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/historialGeneralR' );
	}
	
	function listar_venta_Saldos() {
		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		$id = $this->tank_auth->get_user_id ();
		$style = $this->modelo_dashboard->get_style ( $id );
	
		$this->template->set ( "style", $style );
	
		$this->model_billetera_recargas->listar_venta_saldo();
		$factura_recG = $this->factura_recargas->getFactura_recG();
	
		//var_dump($factura_recG);exit();
	
		$this->template->set ( "facturas_recG", $factura_recG );
	
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/listar_HVenta_saldos' );
	}
	
	function billetera_bo(){

		if (! $this->tank_auth->is_logged_in ()) { // logged in
			redirect ( '/auth' );
		}
		$id = $this->tank_auth->get_user_id ();
		$style = $this->modelo_dashboard->get_style ( $id );
		
		$this->template->set ( "style", $style );
		
		$wallet = $this->check_wallet();
		$saldo = $wallet['balance'];
		$disponible = $wallet['wallet'];
		
		$this->template->set("saldo",$saldo);
		$this->template->set("disponible",$disponible);
		
		$this->model_pin->listar_pinscompra2();
		$pinc = $this->pin->getPinc();
		
		#echo var_dump($pinc);exit();
		
		$this->template->set("pinesc",$pinc);
		
		
		$this->model_recargas->listar_facturaRecargasGeneral ();
		$factura_recG = $this->factura_recargas->getFactura_recG ();
		
		// echo var_dump($pin);exit();
		
		$this->template->set ( "facturas_recG", $factura_recG );
		
		
		
		$this->model_billetera_recargas->listar_venta_saldo();
		$ventas_recG = $this->factura_recargas->getFactura_recG();
		
		$this->template->set ( "ventas_recG", $ventas_recG );
		
		$this->model_billetera_recargas->listar_transferencia_recargasG();
		$Tranferencia = $this->factura_recargas->getFactura_rec();
		
		#echo var_dump($pin);exit();
		
		$this->template->set("Tranferencia",$Tranferencia);
		
		
		$this->template->set_theme ( 'desktop' );
		$this->template->set_layout ( 'website/main' );
		$this->template->set_partial ( 'header', 'website/bo/header' );
		$this->template->set_partial ( 'footer', 'website/bo/footer' );
		$this->template->build ( 'website/bo/recargas/billetera' );
		
		
		
	}
	
}
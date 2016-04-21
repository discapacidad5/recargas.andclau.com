<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class recargas extends CI_Controller
{
	function __construct()
	{
		parent::__construct();

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->load->library('security');
		$this->load->library('tank_auth');
		$this->lang->load('tank_auth');
		$this->load->model('bo/modelo_dashboard');
		$this->load->model('bo/model_admin');
		$this->load->model('bo/model_bonos');
		$this->load->model('bo/model_mercancia');
		$this->load->model('bo/general');
		$this->load->model('bo/recargas/pin');
		$this->load->model('bo/recargas/model_pin');
		$this->load->model('bo/recargas/model_recargas');
		$this->load->model('bo/recargas/factura_recargas');
	}
	
	function index(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
		redirect('/auth');
		}
		
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
		
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
		
		$style=$this->modelo_dashboard->get_style($id);
		
		$this->template->set("style",$style);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/index');
		
	}
	function pines(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/pines');
	
	}
	
	function nuevo_pin()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/nuevo_pin');
	}
	
	
	function ingresar_pin(){

		$this->pin->setId($_POST['id']);
		$this->pin->setDescripcion($_POST['descripcion'] ? $_POST['descripcion'] : "no define");
		$this->pin->setValor($_POST['valor']);
		//$this->pin->setCredito($_POST['credito']);
		
		#echo $_POST['id']."|".$_POST['descripcion']."|".$_POST['valor'];
		
		echo $this->model_pin->ingresar_pin() ? "Pin Creado Exitosamente" : "Pin no pudo ser Creado";
		
	}
	
	function listar_pines()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$style=$this->modelo_dashboard->get_style(1);
	
		$this->template->set("style",$style);
		
		$this->model_pin->listar_pin();
		$pin = $this->pin->getPin();
		
		#echo var_dump($pin);exit();
		
		$this->template->set("pines",$pin);
		
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/listar_pines');
	}
	
	function listar_tarifa()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$style=$this->modelo_dashboard->get_style(1);
	
		$this->template->set("style",$style);
	
		$this->model_pin->listar_tarifa();
		$tarifa = $this->pin->getTarifa();
	
		#echo var_dump($pin);exit();
	
		$this->template->set("tarifas",$tarifa);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/nuevo_pin');
	}
	
	
	function editar_pin(){
	//	$id              = $this->tank_auth->get_user_id();
		#$style           = $this->general->get_style($id);
		$this->pin->setId($_POST['id']);
		$this->model_pin->editar_pin();
		$pin	 	 = $this->pin->getPin();
		
		#echo "dentro de editar";
	
		$this->template->set("pin",$pin);
		$this->template->build('website/bo/recargas/editar_pin');
	}
	
function actualizar_pin(){
		
$this->pin->setId($_POST['id']);
$this->pin->setDescripcion($_POST['descripcion'] ? $_POST['descripcion'] : "no define");
$this->pin->setValor($_POST['valor']);

#echo $_POST['id']."|".$_POST['descripcion']."|".$_POST['valor']."|".$_POST['id2'];
		
		echo $this->model_pin->actualizar_pin() ? "Pin actualizado Exitosamente" : "Pin no pudo ser actualizado ";
		//redirect('bo/recargas/listar_pines');
		
	}
	
	function eliminar_pin(){
	
		if(isset($_POST['id'])){
			$this->pin->setId($_POST['id']);
				
		}
		echo $this->model_pin->eliminar_pin() ? "Pin eliminado Exitosamente" : "Pin no pudo ser eliminado";
	}
	
	function historialRec(){
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
	
		$id=$this->tank_auth->get_user_id();
		$usuario=$this->general->get_username($id);
	
		if($usuario[0]->id_tipo_usuario!=1)
		{
			redirect('/auth/logout');
		}
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/historial_recargas_transfer');
	
	}
	
	
	
	function listar_historialRecargaGeneral()
	{
		if (!$this->tank_auth->is_logged_in())
		{																		// logged in
			redirect('/auth');
		}
		$id              = $this->tank_auth->get_user_id();
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
	
		$this->model_recargas->listar_facturaRecargasGeneral();
		$factura_recG = $this->factura_recargas->getFactura_recG();
	
		#echo var_dump($pin);exit();
	
		$this->template->set("facturas_recG",$factura_recG);
	
	
	
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/historialGeneralR');
	}
	
	
	
}
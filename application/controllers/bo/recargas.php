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
	
	function listar_pines()
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
		};
	
		$retenciones 	 = $this->model_admin->get_retencion();
	
		$style=$this->modelo_dashboard->get_style($id);
	
		$this->template->set("style",$style);
		$this->template->set("retenciones",$retenciones);
		$this->template->set_theme('desktop');
		$this->template->set_layout('website/main');
		$this->template->set_partial('header', 'website/bo/header');
		$this->template->set_partial('footer', 'website/bo/footer');
		$this->template->build('website/bo/recargas/listar_pines');
	}
	function ingresar_pin(){

		$this->pin->setId($_POST['id']);
		$this->pin->setDescripcion($_POST['descrip']);
		$this->pin->setValor($_POST['valor']);
		$this->pin->setCredito($_POST['credito']);
		
		#echo $_POST['id']."|".$_POST['descrip']."|".$_POST['valor']."|".$_POST['credito'];
		
		echo $this->model_pin->ingresar_pin() ? "Pin Creado Exitosamente" : "Pin no pudo ser Creado";
		
	}
	
	
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_grupo_producto extends CI_Model
{
function __construct()
	{
		parent::__construct();
	}
	
	function Categorias(){
		$categorias = $this->db->query('select gp.id_grupo, tr.nombre as id_red, gp.descripcion, gp.estatus 
				from cat_grupo_producto gp, tipo_red tr where gp.id_red = tr.id');
		return $categorias->result();
	}
	
	function  CrearCategoria(){
		$datos = array(
				'descripcion' => $_POST['nombre'],
				'id_red'	  => $_POST['red'],
				'estatus'	  => $_POST['estado']
		);
		$this->db->insert('cat_grupo_producto', $datos);
		$id=$this->db->insert_id();
		
		isset($_POST['recarga']) 
		? $this->crear_grupo_recarga ( $id ) 
		: '';		
		
		return true;
	}
	
	private function eliminar_grupo_recarga($id){
		$this->db->query("delete from cat_grupo_recarga where id_grupo=".$id);
		return true;
	}
	
	private function crear_grupo_recarga($id) {
		$datos = array(
				'id_grupo' => $id
		);
		$this->db->insert('cat_grupo_recarga', $datos);
	}

	
	function ConsultarCategoria($id){
		$categoria = $this->db->query('select *,
										(case when (
												(select id_grupo 
													from cat_grupo_recarga
													where id_grupo=c.id_grupo)) 
											then "checked" else "" end) recarga
									from cat_grupo_producto c where c.id_grupo ='.$id.'');
		return $categoria->result();
	}
	
	function actualizar_categoria(){
		$datos = array(
				'descripcion' => $_POST['nombre'],
				'id_red'	  => $_POST['red'],
				'estatus'	  => $_POST['estado']
		);
		$this->db->where('id_grupo', $_POST['id']);
		$this->db->update('cat_grupo_producto', $datos);
		
		$recarga = $this->get_grupo_recarga_id();
		
		isset($_POST['recarga'])
		? (!$recarga) 
			? $this->crear_grupo_recarga ($_POST['id']) : ''
		: ($recarga) 
			? $this->eliminar_grupo_recarga ($_POST['id']): '';
		
		return true;
	}
	
	function get_grupo_recarga_id(){
		$q=$this->db->query("select * from cat_grupo_recarga where id_grupo=".$_POST["id"]);
		return $q->result();
	}
	
	function eliminar_categoria(){
		$this->db->query("delete from cat_grupo_producto where id_grupo=".$_POST["id"]);
		return true;
	}
	
	function cambiar_estatus_categoria(){
		
		$this->db->query("update cat_grupo_producto set estatus = '".$_POST['estado']."' where id_grupo=".$_POST["id"]);
		return true;
	}
	
	function VerificarCategoria($id_categoria){
		$q = $this->db->query("select nombre from producto where id_grupo = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from servicio where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from combinado where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from paquete_inscripcion where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		$q = $this->db->query("select nombre from membresia where id_red = ".$id_categoria);
		$pro = $q->result();
		if(isset($pro[0]->nombre)){
			return false;
		}
		
		return true;
	}
}
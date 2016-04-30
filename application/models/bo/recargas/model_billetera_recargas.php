<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');

class model_billetera_recargas extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('ov/model_perfil_red');
		
	}
	
	function Empresa($values){
		
		$this->db->query("DELETE FROM billetera_recargas_saldo 
				WHERE id_billetera in (select id from billetera_recargas where id_user = 2) and tipo = 'API'");
		
		$this->db->query("DELETE FROM billetera_recargas_canjeo
				WHERE id_billetera in (select id from billetera_recargas where id_user = 2) and estatus = 'API'");
		
		$this->agregarSaldo_BilleteraRec(2,$values['balance'],'API');
		
		$this->agregarCanjeo_BilleteraRec(2,$values['wallet'],'API');
		
		$q=$this->db->query("SELECT
								u.id,u.username,b.id bill,
								(select round(sum(valor),2)
									from billetera_recargas_saldo
									where id_billetera = b.id and tipo = 'API') saldo,
								(select round(sum(valor))
									from billetera_recargas_canjeo
									where id_billetera = b.id and estatus = 'API') disponible,
								(select round(sum(valor),2)
									from billetera_recargas_canjeo
									where id_billetera = b.id and estatus = 'DES') mitransfer,
								(select round(sum(valor),2)
									from billetera_recargas_saldo
									where id_billetera not in (b.id) and tipo = 'CARRITO') mercancia,
								(select round(sum(valor),2)
									from billetera_recargas_saldo
									where id_billetera = b.id and tipo in ('CATEGORIA','PIN','VENTA')) ganancia,
								(select round(sum(valor),2)
									from billetera_recargas_canjeo
									where id_billetera not in (b.id) and estatus = 'ACT') consumo
								FROM billetera_recargas b, users u
								WHERE b.id_user = u.id
										and u.id = 2
								ORDER BY u.id");
		$q=$q->result();
	
		$comsumo =  $q[0]->mitransfer + $q[0]->consumo;//+ $q[0]->mercancia;
		$ganancia = $q[0]->ganancia;
		
		//$disponible = $q[0]->disponible - $q[0]->consumo;
		$saldo = ($q[0]->saldo) - $comsumo +$ganancia;
	
		$Saldos = array(
				#'billetera' => $q[0]->saldo,
				'wallet' => $q[0]->disponible,//($disponible<=0.011) ? 0 : $disponible,
				'balance' => ($saldo<=0) ? 0 : $saldo
		);
		
		//echo $saldo;exit();
		//var_dump($Saldos);exit();
	
		return $Saldos;
	}
	
	function getSaldos(){
		$q=$this->db->query("SELECT 
								u.id,u.username,b.id bill,
								(select round(sum(valor),2) 
									from billetera_recargas_saldo 
									where id_billetera = b.id) saldo,
								(select round(sum(valor))
									from billetera_recargas_canjeo 
									where id_billetera = b.id and estatus = 'ACT') disponible,
								(select round(sum(valor),2) 
									from billetera_recargas_canjeo 
									where id_billetera = b.id) quitado,
								(select round(sum(valor),2) 
									from billetera_recargas_retiro 
									where id_billetera = b.id) consumo
								FROM billetera_recargas b, users u
								WHERE b.id_user = u.id 
										and u.id = ".$this->billetera_recargas->getUsuario()."
								ORDER BY u.id");
		$q=$q->result();
		
		$disponible = $q[0]->disponible - $q[0]->consumo;
		$saldo = $q[0]->saldo - $q[0]->quitado;

		$Saldos = array(
				#'billetera' => $q[0]->saldo,
				'disponible' => ($disponible<=0.02) ? 0 : $disponible,
				'saldo' => ($saldo<=0.02) ? 0 : $saldo
		);
		
		$this->billetera_recargas->setSaldos($Saldos);
	}
	
	function agregarSaldoPadre(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor()*0.2,
				'tipo' => 'CATEGORIA'
		);
		
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	function agregarSaldo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'tipo' => 'CARRITO'
		);
	
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	function agregarSaldo_BilleteraRec($id,$monto,$tipo){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'tipo' => $tipo
		);
	
		$this->db->insert("billetera_recargas_saldo",$data);
		return true;
	}
	
	
	function agregarCanjeo(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'estatus' => 'ACT'
		);
	
		$this->db->insert("billetera_recargas_canjeo",$data);
		return true;
	}
	
	function agregarCanjeo_BilleteraRec($id,$monto,$estado){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'estatus' => $estado
				
		);
	
		$this->db->insert("billetera_recargas_canjeo",$data);
		return true;
	}
	
	function add_sub_billeteraRec($tipo,$id,$monto){
	  if ($tipo == "ADD") {
			$id_transac = $this->agregarSaldo_BilleteraRec ( $id, $monto,'EMPRESA');
		} else {
			$id_transac = $this->agregarCanjeo_BilleteraRec ( $id, $monto ,'EMPRESA' );
		}
	return $id_transac;
	}
	
	function agregarRetiro_BilleteraRec($id,$monto,$tipo,$transac){
		$data = array(
				'id_billetera' => $this->getId_($id),
				'valor' => $monto,
				'tipo' => $tipo,
				'id_transaccion' => $transac
		);
	
		$this->db->insert("billetera_recargas_retiro",$data);
		return true;
	}
	
	function agregarRetiro(){
		$this->getId();
		$data = array(
				'id_billetera' => $this->billetera_recargas->getId(),
				'valor' => $this->billetera_recargas->getValor(),
				'tipo' => 'GSM',
				'id_transaccion' => $this->recarga->getId()
		);
	
		$this->db->insert("billetera_recargas_retiro",$data);
		return true;
	}
	
	function getId(){
		$q=$this->db->query("SELECT id from billetera_recargas where id_user = ".$this->billetera_recargas->getUsuario());
		$q=$q->result();
		$this->billetera_recargas->setId($q[0]->id);
	}
		
	function getId_($id){
		$q=$this->db->query("SELECT id from billetera_recargas where id_user = ".$id);
		$q=$q->result();
		return $q[0]->id;
	}
		
	function limpiar($tabla,$id){
		$this->db->query("DELETE FROM billetera_recargas_".$tabla."  where id_billetera = ".$id);
		return 0;
	}
	
	function tranferencia_recargas($id,$afiliado,$cobro){
		$data = array(
				'id_origen' => $id,
				'id_destino' => $afiliado,
				'monto' => $cobro
			
		);
		
		$this->db->insert("transferencia_recargas",$data);
		return true;
	}
	
	function listar_transferencia_recargas($id)
	{
		$q=$this->db->query("select nombre,monto,fecha from user_profiles,
				transferencia_recargas where id_destino=user_id and id_origen=".$id."
				         order by fecha desc ");
		$result=$q->result();
		$this->factura_recargas->setFactura_rec($result);
	}
	
	function listar_transferencia_recargasG()
	{
		$q=$this->db->query("SELECT 
	            (select nombre from user_profiles where user_id = id_origen) origen,
 	            (select nombre from user_profiles where user_id = id_destino) destino,
	            monto,fecha
                            FROM 
	            transferencia_recargas
					order by fecha desc ");
		$result=$q->result();
		$this->factura_recargas->setFactura_rec($result);
	}
	
	function alta_venta_saldo($id,$monto,$valor){
		$data = array(
				'afiliado' => $id,
				'transferido' => $monto,
				'valor' => $valor
		);
	
		$this->db->insert("vender_saldo",$data);
		return true;
	}
	
	function listar_venta_saldo()
	{
		$q=$this->db->query("SELECT afiliado,transferido,valor,fecha  FROM
	            vender_saldo
					order by fecha desc ");
		$result=$q->result();
		$this->factura_recargas->setFactura_recG($result);
	}
	
	
}
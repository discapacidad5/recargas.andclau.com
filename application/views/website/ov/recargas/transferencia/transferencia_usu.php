<div id="spinner-div"></div>
<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<form action="" onmouseenter="" method="POST" id="edit" role="form" class="smart-form">
		
			<legend>Dar Saldo a <?=$usuario2[0]->nombre." ".$usuario2[0]->apellido?></legend>

			<br><br>
			<div style="text-align:left;">
			<table class="table">
													<tbody>
													
													<tr class="success">
														<td><h4><b>Tú Saldo Billetera </b></h4></td>
														<td><h4><b>Saldo Billetera Afiliado </b></h4></td>
													</tr>
													
														<tr class="warning">
															<?php if($saldo<=0){?>
															<td ><b style="color: red"><?php echo $saldo;?></b></td>
															<?php }else {?>
															<td ><b style="color: green"><?php echo $saldo;?></b></td>
														    <?php }?>
															<?php if($disponible<=0){?>
															<td ><b style="color: red"><?php echo $disponible;?></b></td>
														<?php }else {?>
														<td ><b style="color: green"><?php echo $disponible;?></b></td>
       														 <?php }?>
														
       														</tr>
																							</tbody>
													</table>
			
			</div>
			
													<input required type="hidden" id="id" name="id" value="<?=$afiliado?>">
													
			<div class="row">
				<div class="form-group" aling-text="letf">				
					<legend> </legend>
					<br/>
					
					<section class="col col-6">
					<section class="col-md-12">Digite monto:</section>
					<section class="col-md-12">		
						<label class="input">
							<i class="icon-prepend fa fa-money"></i>
							<input name="cobro" type="number" min="1" step="0.01" size="30" class="from-control" id="cobro" required />
						</label>
					</section></section>
					<section class="col col-6">
					<section class="col-md-12">Digite Su Contraseña:</section>
					<section id="mensaje" class="col-md-12">		
						<label  class="input">
							<i class="icon-prepend fa fa-lock"></i>
							<input name="pass" type="password" min="1" step="0.01" size="30" class="from-control" id="pass" placeholder="password" required />
						</label>
					</section></section>
				</div>
			</div>			
			<div class="row">
				
			</div>			
			<div class="row">
				<div class="form-group">				
					<legend> </legend>
					<br/>					
					<section class="col col-8"></section>
					<section class="col col-2">
							<button type="submit" id="dar" class="btn btn-success  btn-next" disabled >Dar Saldo</button>				
					</section>
											
					
				</div>
			</div>
			
						
		</form>	<!-- /form -->
	</div>
					
						
</div>
									
		
		




<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>

<script type="text/javascript">
/*
$("#cobro").keyup(function(){
	if($("#cobro").val()>0){
		$('#dar').attr("disabled", false);
	}else{
		$('#dar').attr("disabled", true);
	}	
});
*/

    $("#pass").keyup(validarPass);
	$("#cobro").keyup(CalcularSaldo);
	$("#pass").change(validarPass);
	$("#cobro").change(CalcularSaldo);
	//$('#dar').attr("disabled", true);
	
//setup_flots();
/* end flot charts */
var pass="";
var neto="";
var val= "";

function validarPass(evt){
	$('#dar').attr("disabled", true);
	$('.msg-val').remove();
	pass = $("#pass").val();

	$.ajax({
		type: "POST",
		url: "/ov/billetera3/validarPass",
		data: {pass: pass},
	})
	.done(function( msg )
	{
		val=msg;
		mensaje();		
	//alert(msg);
	if(pass && val && neto > 0){
		
		$('#dar').attr("disabled", false);
		}else{
			$('#dar').attr("disabled", true);
		}
	});
}

function mensaje(){
	$('.msg-val').remove();
	if(!val){
		$('#mensaje').append("<p class='msg-val txt-color-red'>Contraseña incorrecta<p>");
	}else{
		$('#mensaje').append("<p class='msg-val txt-color-green'>Contraseña Correcta<p>");
	}
}

function CalcularSaldo(evt){
	$('#dar').attr("disabled", true);
	//alert("aqui!");
	var saldo = <?=$saldo?>;
	var pago = $("#cobro").val()/*+ (String.fromCharCode(evt.charCode)*/;	
	neto = saldo-pago;
	if(neto > 0 && pass && val){
		$('#dar').attr("disabled", false);
	}else{
			$('#dar').attr("disabled", true);
	}
	
}


$( "#edit" ).submit(function( event ) {
	event.preventDefault();	
    enviar();
});

function enviar(){
	$.ajax({
		type: "POST",
		url: "/auth/show_dialog",
		data: {message: '¿ Esta seguro que desea Realizar la Transacción ?'},
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: 'Transferir a usuarios',
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
						setiniciarSpinner();	
						$.ajax({
							type: "POST",
							url: "/ov/billetera3/enviar_transferencia",
							data: $('#edit').serialize()
						}).done(function( msg ) {				
							bootbox.dialog({
								message: msg,
								title: 'ATENCION',
								buttons: {
									success: {
										label: "Aceptar",
										className: "btn-success",
										callback: function() {
												location.href="/ov/billetera3/listar_HTransferencia";
												FinalizarSpinner();
										}
									}
								}
							})
						});//fin Done ajax	
					}
				},
			danger: {
					label: "Cancelar!",
					className: "btn-danger",
					callback: function() {

					}
				}
			}
		})
	});	
}



</script>

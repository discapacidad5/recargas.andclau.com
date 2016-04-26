<div id="spinner-div"></div>
<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<form action="" onmouseenter="" method="POST" id="edit" role="form" class="smart-form">
		
			<legend>Modificar Recarga Saldo del Afiliado</legend>

			<br><br>
			<div style="text-align:left;">
			<table class="table">
													<tbody>
													
													<tr class="success">
														<td><h4><b>Saldo Billetera Recargas</b></h4></td>
														<td><h4><b>Saldo Disponible </b></h4></td>
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
			
													<input required type="hidden" id="id" name="id" value="<?=$id?>">
			<div class="row">
				<div class="form-group">				
					<legend> </legend>
					<br/>
					<section class="col col-12">
										</section>
					<section class="col col-3"></section>
					<section class="col col-3">Digite monto:</section>
					<section class="col col-6">		
						<label class="input">
							<i class="icon-prepend fa fa-money"></i>
							<input name="cobro" type="number" min="1" step="0.01" size="30" class="from-control" id="cobro" required />
						</label>
					</section>					
				</div>
			</div>			
						
			<div class="row">
				<div class="form-group">				
					<legend> </legend>
					<br/>					
					<section class="col col-8"></section>
					<section class="col col-2">
							<button type="button" id="ADD" class="btn btn-success  btn-next" disabled >Agregar</button>				
					</section>
					<section class="col col-2">
							<button type="button" id="SUB" class="btn btn-danger btn-prev" disabled >Quitar</button>						
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
var tipo = "";
$("#cobro").keyup(function(){
	if($("#cobro").val()>0){
		$('.btn').attr("disabled", false);
	}else{
		$('.btn').attr("disabled", true);
	}	
});
$( "#ADD" ).click(function( event ) {
	tipo = "ADD";
	event.preventDefault();	
	enviar();
});

$( "#SUB" ).click(function( event ) {
	tipo = "SUB";
	event.preventDefault();	
	enviar();
});

$( "#edit" ).submit(function( event ) {
	event.preventDefault();	
	if(tipo){
		enviar();
	}
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
		title: 'Eliminar Afiliado',
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
						setiniciarSpinner();	
						$("#edit").append("<input value='"+tipo+"' type='hidden' name='tipo'>");
						$.ajax({
							type: "POST",
							url: "/bo/comercial/add_sub_billetera_afiliadoRec",
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
												location.href="/bo/comercial/red_tabla";
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

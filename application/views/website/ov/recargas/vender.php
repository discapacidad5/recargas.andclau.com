<div id="spinner-div"></div>
<div style="background: rgb(255, 255, 255) none repeat scroll 0% 0%; margin-right: 0px; margin-left: 0px; padding-bottom: 3rem;" class="row">
	
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

		<form action="" onmouseenter="" method="POST" id="edit" role="form" class="smart-form">
		
		<!-- <legend>Canjear Saldo Recargas</legend> <br><br>-->	

			

			<div class="form-group">

				<div class="row">
							
									
																<fieldset>
																	<section class="col col-10">
																		<label class="label "><b>Saldo Billetera Recargas</b></label>
																		<label class="input state-disabled state-error">
																			<input type="text" name="saldo"  class="from-control" id="saldo" 
																			value="<?php echo $saldo ?>" readonly />
																		</label>
																	</section>
																	<section class="col col-10">
																		<label class="label"><b>Disponer saldo</b></label>
																		<label class="input">
																			<i class="icon-prepend fa fa-money"></i>
																			<input name="cobro" type="number" min="0" value="0" step="0.01" class="from-control" id="cobro" required/>
																		</label>
																	</section>
																	<section class="col col-10">
																		<label class="label"><b>Saldo Billetera Virtual</b></label>
																		<label class="input state-disabled state-success">
																			<input value="<?php echo $virtual ?>"  type="number" disabled="disabled" name="neto" id="neto" class="from-control" readonly />
																		</label>
																	</section>
																</fieldset>	
																
																<footer>
																	<button type="submit" class="btn btn-success" id="enviar">
																	<i class="glyphicon glyphicon-ok"></i>
																		Vender
																	</button>
																</footer>
																
				</div>
			</div>
			
						
		</form>	<!-- /form -->
	</div>
					
						
</div>
									
		
		




<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>

<script type="text/javascript">

$(document).ready(function() {
	
	// DO NOT REMOVE : GLOBAL FUNCTIONS!
	pageSetUp();

	$("#cobro").keyup(CalcularSaldo);
	$('#enviar').attr("disabled", true);
		});

//setup_flots();
/* end flot charts */

function CalcularSaldo(evt){
	
	var saldo = <?=$saldo?>;
	var pago = $("#cobro").val() /*+ (String.fromCharCode(evt.charCode)*/;
	var neto = (saldo-pago).toFixed(2);
	var virtual = <?=$virtual?>;
	var neto2 = parseInt(virtual)+parseInt(pago);
	$("#saldo").val(neto);
	$("#neto").val(neto2);
	if(neto >= 0){
		$('#enviar').attr("disabled", false);
		}else{
			$('#enviar').attr("disabled", true);
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
		title: 'Eliminar Afiliado',
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
						setiniciarSpinner();	
						$.ajax({
							type: "POST",
							url: "/ov/billetera3/venderSaldo",
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
												location.href="/ov/billetera3/";
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
<!-- 
select U.id, UP.nombre, UP.apellido, U.username, U.email, CS.descripcion as sexo,
CEC.descripcion as estado_civil, CTU.descripcion as tipo_usuario, CE.descripcion as estudio,
CO.descripcion as ocupacion, CTD.descripcion as tiempo_dedicado, CEA.descripcion

from users U, user_profiles UP, cat_sexo CS, cat_edo_civil CEC, cat_tipo_usuario CTU,
cat_estudios CE, cat_ocupacion CO, cat_tiempo_dedicado CTD, cat_estatus_afiliado CEA
 
where UP.id_sexo = CS.id_sexo and UP.id_edo_civil = CEC.id_edo_civil and UP.id_tipo_usuario = CTU.id_tipo_usuario
and UP.id_estudio = CE.id_estudio and UP.id_ocupacion = CO.id_ocupacion and U.id = UP.user_id 
and UP.id_tiempo_dedicado = CTD.id_tiempo_dedicado and UP.id_estatus = CEA.id_estatus

 group by (U.id);
 -->

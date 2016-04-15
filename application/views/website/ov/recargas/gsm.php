<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span>
					<a href="/ov/billetera3/index"> > Billetera Recargas</a> > Recargas
					GSM
				</span>

			</h1>
		</div>
	</div>
	<!-- row -->
	<div class="row"></div>
	<!-- end row -->

	<!-- row -->
	<div class="row">

		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="well" style="background: url('/media/imagenes/andclau/recargate.jpg'); background-size: 100% auto">

				<section id="widget-grid" class="">

					<!-- row -->
					<div class="row">

						<!-- NEW WIDGET START -->
						<div class="col-sm-4 col-md-4 col-lg-4"></div>
						<article class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

							<!-- Widget ID (each widget will need unique ID)-->
							<div class="jarviswidget jarviswidget-color-purity" id="wid-id-1"
								data-widget-editbutton="false" data-widget-colorbutton="true">
								<!-- widget options:
											usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">
							
											data-widget-colorbutton="false"
											data-widget-editbutton="false"
											data-widget-togglebutton="false"
											data-widget-deletebutton="false"
											data-widget-fullscreenbutton="false"
											data-widget-custombutton="false"
											data-widget-collapsed="true"
											data-widget-sortable="false"
							
											-->
								<!-- widget content -->
								<div class="widget-body">
									<div id="myTabContent1" class="tab-content padding-10">
										<h1 class="text-center"></h1>

										<div class="table-responsive">
										<div class="header">
												<div class="col-xs-2 col-md-2" >
												</div>
                    							<h1 class="col-xs-4 col-md-4" >
					                           		<b>Recargate</b>
					                           </h1>
                        			    <a class="col-xs-5 col-md-5" href="http://andclau.com/" target="_blank">
											<img alt="" width="90%" src="/media/imagenes/andclau/andclau-negro-1.png">
										</a>
                        					
                						</div>
										
										</div>




									</div>


									<form action="" method="post" id="edit" name="topup"
										class="smart-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<fieldset><?php // echo $api['url'];?>

												<section class="col-xs-12 col-md-6">
													<label class="label "><b>Saldo Disponible</b></label> 
													<label
														class="input input state-success"> <input type="text"
														name="saldo" class="from-control" id="saldo"
														value="<?php echo number_format($disponible,2)  ?>"
														readonly />
													</label>
												</section>
												<section class="col-xs-12 col-md-6">
													<label class="label"><b>Saldo Final</b></label> 
													<label
														class="input state-disabled state-error"> <input
														type="number" disabled="disabled" name="neto" id="neto"
														value="<?php echo number_format($disponible,2)  ?>"
														class="from-control" readonly />
													</label>
												</section>
										</fieldset>
										<fieldset >	
											<section >
												<label class="label "><b>País</b></label> 
												<select style="width: 100%" class="select2" id="pais"  required	name="pais">
												<option value="">Seleccione País</option>
													<?foreach ( $pais as $key ) {?>
														<option value="<?=$key->code?>">
																<?=$key->name?>
														</option>
													<?}?>
												</select>
											</section>
											<section id="numero_telefono" >
												<label class="label"><b>Numero de Teléfono</b></label>
												
												<label class="input" >
													<div class="col-xs-3 col-md-3">
														<input id="mr_phone_prefix" name="prefix" value="+57"
															maxlength="3" size="5" readonly="readonly" style="background: #c0c0c0"
															class="pagination-centered margin_bottom0 bg_cross_pattern"
															type="text">
													</div>
													<div class="col-xs-9 col-md-9">
														<input data-original-title="" autocomplete="off"
															id="mr_phone_no" name="phone"
															class="from-control mr_phone_no margin_bottom0 pagination-left"
															min="1" value="" type="number" required>
													</div> 
													<div class="margin_top5"> &nbsp;</div> 
													<div class="margin_top5 ">  
														<div class="col col-6" id="validacion"></div>
														<div class="col col-6">
															<input type="button" class="btn btn-primary" value="Elegir Monto" id="validar"/>
														</div>
													</div>
													<div class="margin_top5"> &nbsp;</div>  
												</label>
											</section>
											<hr/>
											<section id="productos">
												<label class="label"><b>Monto</b></label> <label
													class="input"> <i class="icon-prepend fa fa-money"></i> <input
													name="delivered_amount_info" type="number" min="1" step="0.01" class="from-control" readonly required
													id="cobro" />
												</label>
											</section>
												<input type="hidden" name="action" value="simulation" >
												<input class="hide" type="text" id="numero" name="destination_msisdn" value="" readonly >
												<input type="hidden" name="currency" value="USD" >
												<input type="hidden" name="sms" value="nueva recarga" >
												<input type="hidden" name="destination_currency" value="USD" >
										</fieldset>


										<footer id="foo">

											<div class=" col-md-4"></div>
											<div class="col-xs-12 col-md-4">
												<button type="button" class="btn btn-success" id="enviar">
													<i class="glyphicon glyphicon-ok"></i> Recargar
												</button>
											</div>

										</footer>
									</form>

								</div>


								<!-- end widget div -->
							</div>
							<!-- end widget -->

						</article>
					</div>
				</section>
				<!-- end widget grid -->
			</div>
		</div>
		<!-- row -->
	</div>
	<div class="row">
		<div class="col-sm-12">
			<br /> <br />
		</div>
	</div>
	<!-- end row -->

</div>
<!-- END MAIN CONTENT -->

<!-- PAGE RELATED PLUGIN(S) 
		<!-- Morris Chart Dependencies -->
<script src="/template/js/plugin/morris/raphael.min.js"></script>
<script src="/template/js/plugin/morris/morris.min.js"></script>

<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script
	src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script
	src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">
			// PAGE RELATED SCRIPTS

			/*
			 * Run all morris chart on this page
			 */

			var monto="";
			var numero="";
			var neto ="";
			var pago="";
			var saldo=""; 
			var r=0;
			
			$(document).ready(function() {
				
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$("#validar").click(msisdn);	
				$("#mr_phone_no").change(validarCampos);
				if(monto!=""){$('#foo').show();$('#enviar').attr("disabled", false);};
				$("#pais").change(getmsisdn);	
				$("#pais").before(getmsisdn);	
				$('#productos').hide();
				$('#foo').hide();
				$('#enviar').attr("disabled", true);
			});

			//setup_flots();
			/* end flot charts */
			
function selector(html,param){

			if(param = 1){
				$(html).attr("disabled", true);
			}else if(param = 2){
				alert('aqui!');
				$(html).attr("disabled", false);
			}	
				
}
			
function CalcularSaldo(){
				saldo = $("#saldo").val();
				pago = $("#cobro").val(); 
				neto = saldo-pago;
				$("#neto").val(neto);
				var tel = $("#mr_phone_no").val();
				if(pago=""||neto<0){
					$('#foo').hide();
				}
			}

function getproduct(msg){
		
		bootbox.dialog({
			message: msg,
			title: 'Elegir Monto',
			buttons: {
				success: {
				label: "Aceptar",
				className: "btn-success",
				callback: 
					function() {
						if($("#monto:checked")){
							monto = $("#monto:checked").val().split("|");
							pago = monto[1];
							$("#cobro").val(pago);								
							$('#productos').show();	
							$('#foo').show();
							CalcularSaldo();
							$('#enviar').attr("disabled", false);
						}else{
							alert('por favor selecciona monto!')			
						}		
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
}

function msisdn(evt){
	var zip = $("#mr_phone_prefix").val();
	var tel = $("#mr_phone_no").val(); 
	numero = zip+""+tel;
	
	
	if(zip&&tel){
		iniciarSpinner();
		$.ajax({
			type: "POST",
			url: "response_numero",
			data: {
				destination_msisdn:numero,
				action:'msisdn_info'
				}
		})
		.done(function( msg )
		{
			FinalizarSpinner();	
			if(msg){
				getproduct(msg);	
			}else{
				$('#productos').hide();
				$('#foo').hide();
			}
		});//Fin callback bootbox
	}else{
		$('#productos').hide();
		$('#foo').hide();
	}
}

function getmsisdn(evt){
	var pais = $("#pais").val();
	if(pais){
		iniciarSpinner();
		$.ajax({
			type: "POST",
			url: "getmsisdn",
			data: {
					id:pais
				}
		})
		.done(function( msg )
		{
			if(msg){
				
				$("#mr_phone_prefix").val(msg);
				$('#numero_telefono').show();	
							
			}else{
				$('#numero_telefono').hide();
			}
			validarCampos();
		});//Fin callback bootbox
		FinalizarSpinner();
	}else{
		$('#numero_telefono').hide();
	}
}

$( "#enviar" ).click(function( event ) {
	event.preventDefault();	
	r=1;
	if(validarCampos()){
		$('#productos').show();	
		$('#foo').show();
		cobrar();
	}else {
		alert("Los datos de la operación estan incompletos o erroneos");
	}
	
});

function cobrar() {
	$.ajax({
		type: "POST",
		url: "/auth/show_dialog",
		data: {message: '¿ Esta seguro que desea realizar la Recarga ?'},
	})
	.done(function( msg )
	{
		iniciarSpinner();
		bootbox.dialog({
		message: msg,
		title: 'Recarga GSM',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					

					$.ajax({
						type: "POST",
						url: "/ov/billetera3/recargar_gsm",
						data: {
							sku:monto,
							destination_msisdn:numero,
							neto:neto,
							pago:pago,
							saldo:saldo
							} 
					})
					.done(function( msg2 )
					{
						//iniciarSpinner();
						bootbox.dialog({
						message: msg2,
						title: 'ATENCION!!!',
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
								FinalizarSpinner();
								location.href='/ov/billetera3/';
								}
							}
						}
						})//fin done ajax
					});//Fin callback bootbox

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
function validarCampos(){
	
	var zip = $("#mr_phone_prefix").val();
	var tel = $("#mr_phone_no").val();
	numero = zip+""+tel;
	iniciarSpinner();
	$.ajax({
		type: "POST",
		url: "response_numero",
		data: {
			destination_msisdn:numero,
			action:'msisdn_info'
			}
	})
	.done(function( msg )
	{
		if(r==0){
			FinalizarSpinner();
		}	
		$('#productos').hide();
		$('#foo').hide();
		if(!tel){		
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' >Digite Número de telefono</div>");
			return false;
		}else if(!msg){	
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' class='txt-color-red'>Número de telefono no valido</div>");
			return false;			
		}else{
			if(!monto){
				getproduct(msg);				
			}			
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' class='txt-color-green'>Número de telefono Correcto</div>");
			
			return true;
		}
	});
	
	return true;
}
	</script>
	
	<style>
	
	#validar{
		color: #fff;
		background: #3276b1;
	}
	
	</style>
	
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


									<form action="<?php echo $api['url'];?>" method="post" id="edit" name="topup"
										class="smart-form col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<fieldset>

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
										<fieldset>	
											<section >
												<label class="label "><b>País</b></label> 
												<select style="width: 100%" class="select2" id="pais"  required	name="country">
												<option value="">Seleccione País</option>
													<?foreach ( $pais as $key ) {?>
														<option value="<?=$key->code?>">
																<?=$key->name?>
														</option>
													<?}?>
												</select>
											</section>
											<!--  <section >
												<label class="label "><b>Operador</b></label>
												<div class="span8 operators clearfix many many_small">
													<div class="span4 margin_left0 clear clear_on_phone"
														data-operator_name="Claro" data-operator_id="887">
														<div class="operator_name_claro"></div>
													</div>
													<div class="span4 " data-operator_name="Tigo"
														data-operator_id="888">
														<div class="operator_name_tigo"></div>
													</div>
													<div class="span4  clear_on_phone"
														data-operator_name="Movistar" data-operator_id="889">
														<div class="operator_name_movistar"></div>
													</div>
													<div class="span4 margin_left0 clear"
														data-operator_name="Uff" data-operator_id="2305">
														<div class="operator_name_uff"></div>
													</div>
													<div class="span4  clear_on_phone"
														data-operator_name="Virgin Mobile" data-operator_id="2253">
														<div class="operator_name_virgin"></div>
													</div>
													<div class="span4 " data-operator_name="Avantel"
														data-operator_id="2611">
														<div class="operator_name_avantel"></div>
													</div>
													<div class="span4 margin_left0 clear clear_on_phone"
														data-operator_name="ETB" data-operator_id="2671">
														<div class="operator_name_etb"></div>
													</div>
													<div class="span4 " data-operator_name="Une"
														data-operator_id="2663">
														<div class="operator_name_une"></div>
													</div>
												</div>
											</section> -->
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
													<!--  <img
														src="../images/spinner.gif"
														class="margin_horizontal5 mr_input_spinner none">
													<img
														src="../images/check_mark.png"
														class="margin_horizontal5 check_mark none"> -->
													<div class="margin_top5"> &nbsp;</div> 
												</label>
											</section>
											<hr/>
											<section id="productos">
												<label class="label"><b>Monto</b></label> <label
													class="input"> <i class="icon-prepend fa fa-money"></i> <input
													name="delivered_amount_info" type="number" min="1" step="0.01" class="from-control" readonly
													id="cobro" />
												</label>
											</section>
											<input type="hidden" name="login" value="<?php echo $api['login'] ?>" >
												<input type="hidden" name="key" value="<?php echo $api['key'] ?>" >
												<input type="hidden" name="md5" value="<?php echo $api['md5'] ?>" >
												<input type="hidden" name="action" value="msisdn_info" >
												<input class="hide" type="text" id="numero" name="destination_msisdn" value="+573008423480" readonly > 
											   <!-- <input type="hidden" name="delivered_amount_info" value="1" > -->
												<input type="hidden" name="currency" value="USD" >
												<input type="hidden" name="destination_currency" value="USD" >
											  <!--    <input type="hidden" name="product" value="1.0" >
											   <input type="hidden" name="operator" value="Tigo Colombia USD" >
											    <input type="hidden" name="operatorid" value="1578" >--> 
											    <input type="hidden" name="msisdn" value="<?=$usuario[0]->nombre." ".$usuario[0]->apellido?>" >
										</fieldset>


										<footer>

											<div class=" col-md-4"></div>
											<div class="col-xs-12 col-md-4">
												<button type="submit" class="btn btn-primary" id="enviar">
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
			
			$(document).ready(function() {
				
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$("#mr_phone_no").keyup(msisdn);	
				$("#mr_phone_no").before(msisdn);
				$("#pais").change(getmsisdn);	
				$("#pais").before(getmsisdn);	
				$("#cobro").keyup(CalcularSaldo);
				$('#enviar').attr("disabled", true);
					});

			//setup_flots();
			/* end flot charts */
			
function CalcularSaldo(evt){
				
				var saldo = $("#saldo").val();
				var pago = $("#cobro").val() /*+ (String.fromCharCode(evt.charCode)*/;
				var neto = saldo-pago;
				$("#neto").val(neto);
				var tel = $("#mr_phone_no").val();
				if(neto > 0 && tel.length > 0){
					$('#enviar').attr("disabled", false);
					}else{
						$('#enviar').attr("disabled", true);
					}
			}
function msisdn(evt){
	
	var zip = $("#mr_phone_prefix").val();
	var tel = $("#mr_phone_no").val(); /*+ (String.fromCharCode(evt.charCode)*/;
	var numero = zip+""+tel;
	
	//$("#numero").val(numero); 
	//alert(numero);
	if(numero){
		$.ajax({
			type: "POST",
			url: "response_numero",///ov/billetera3/recargar_gsm
			data: {
				destination_msisdn:numero,
				action:'msisdn_info'
				}
		})
		.done(function( msg )
		{
			
			if(msg){
				//alert(msg);
				//$("#mr_phone_prefix").val(msg);
				if(!monto){		
					bootbox.dialog({
						message: msg,
						title: 'Elegir Monto',
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: 
								function() {
								monto = $("#monto:checked").val();	
								alert(monto);	
								$("#cobro").val(monto);		
								$('#productos').show();			
								}
							},
							danger: {
								label: "Cancelar!",
								className: "btn-danger",
								callback: function() {
			
									}
							}
						}
					})//fin done ajax	
				}else{
					$("#cobro").val(monto);
					$('#productos').show();
				}
				
				//$("#productos").html(msg);	
			}else{
				$('#productos').hide();
			}
		});//Fin callback bootbox
	}else{
		$('#productos').hide();
	}
	
	if(numero.length > 10){
		$('#enviar').attr("disabled", false);
		}else{
			$('#enviar').attr("disabled", true);
	}
}

function getmsisdn(evt){
	var pais = $("#pais").val();
	//alert(pais);
	if(pais){
		$.ajax({
			type: "POST",
			url: "getmsisdn",///ov/billetera3/recargar_gsm
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
		});//Fin callback bootbox
	}else{
		$('#numero_telefono').hide();
	}
}

/* $( "#edit" ).submit(function( event ) {
	event.preventDefault();	
	cobrar();
});*/

function cobrar() {

	if(validarCampos()){
	$.ajax({
		type: "POST",
		url: "/auth/show_dialog",
		data: {message: '¿ Esta seguro que desea realizar la Recarga ?'},
	})
	.done(function( msg )
	{
		
		bootbox.dialog({
		message: msg,
		title: 'Recarga GSM',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					iniciarSpinner();
					$.ajax({
						type: "POST",
						url: "<?php echo $api['url'];?>",///ov/billetera3/recargar_gsm
						data: $('#edit').serialize()
					})
					.done(function( msg )
					{
						FinalizarSpinner();
						bootbox.dialog({
						message: msg,
						title: '',
						buttons: {
							success: {
							label: "Aceptar",
							className: "btn-success",
							callback: function() {
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
	}else {
		alert("Los datos de la operación estan incompletos o erroneos");
	}
}
function validarCampos(){

	if(parseInt($('#cobro').val())<=0)
		return false;

	return true;
}
	</script>
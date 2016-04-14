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
											<!--<input type="hidden" name="login" value="<?php echo $api['login'] ?>" >
												<input type="hidden" name="key" value="<?php echo $api['key'] ?>" >
												<input type="hidden" name="md5" value="<?php echo $api['md5'] ?>" >-->
												<input type="hidden" name="action" value="simulation" >
												<input class="hide" type="text" id="numero" name="destination_msisdn" value="" readonly ><!--  +573115654368--> 
											    <!--<input type="hidden" name="delivered_amount_info" value="1" >  -->
												<input type="hidden" name="currency" value="USD" >
												<!--  <input type="hidden" name="originating_currency" value="USD" >-->
												<!--  <input type="hidden" name="sms_sent" value="+573115654368" >-->
												<input type="hidden" name="sms" value="nueva recarga" >
												<input type="hidden" name="destination_currency" value="USD" >
												<!--  <input type="hidden" name="skuid" value="9940" >-->
												<!--  <input type="hidden" name="open_range" value="1" > -->
											   <!--   <input type="hidden" name="product" value="1.41" >-->
											   <!--   <input type="hidden" name="retail_price" value="1.00" >
											    <input type="hidden" name="wholesale_price" value="0.92" >-->
											  	<!--    <input type="hidden" name="operator" value="Tigo Colombia USD" >
											    <input type="hidden" name="operatorid" value="1578" >
											    <input type="hidden" name="country" value="Colombia" >
											    <input type="hidden" name="countryid" value="710" > -->
											    <!--  <input type="hidden" name="msisdn" value="<?=$usuario[0]->nombre." ".$usuario[0]->apellido?>" >-->
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
			
			$(document).ready(function() {
				
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

				$("#validar").click(msisdn);	
				$("#mr_phone_no").change(validarCampos);
				
				//$("#cobro").on("mouseenter",validarCampos);
				if(monto!=""){$('#foo').show();$('#enviar').attr("disabled", false);};
				$("#pais").change(getmsisdn);	
				//$("#pais").change(validarCampos);
				$("#pais").before(getmsisdn);	
				//if($("#cobro").val()){
					//	CalcularSaldo;
				//}
				//$("#cobro").before(CalcularSaldo);
				//$('#enviar').attr("disabled", true);
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
				//alert('aqui!')
				saldo = $("#saldo").val();
				pago = $("#cobro").val(); /*+ (String.fromCharCode(evt.charCode)*/;
				neto = saldo-pago;
				$("#neto").val(neto);
				var tel = $("#mr_phone_no").val();
				if(pago=""||neto<0){
					$('#foo').hide();
				//}else{
					//$('#foo').show();
				}
			}

function getproduct(msg){
	//if(!monto){	
		
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
							//alert(monto[1]);	
							pago = monto[1];
							$("#cobro").val(pago);								
							$('#productos').show();	
							//$('#foo').show();
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
		})//fin done ajax	
	/*}else{					
		$("#cobro").val(monto[1]);
		$('#productos').show();
		$('#enviar').attr("disabled", false);
	}*/
}

function msisdn(evt){
	var zip = $("#mr_phone_prefix").val();
	var tel = $("#mr_phone_no").val(); /*+ (String.fromCharCode(evt.charCode)*/;
	numero = zip+""+tel;
	
	//$("#numero").val(numero); 
	//alert(numero);
	if(zip&&tel){
		iniciarSpinner();
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
			FinalizarSpinner();	
			if(msg){
				
				//alert(msg);
				//$("#mr_phone_prefix").val(msg);
				getproduct(msg);
				//$("#cobro").val(pago);
				//$("#numero").val(numero); 				
				//$('#foo').show();
				//$("#productos").html(msg);	
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
	//alert(pais);
	if(pais){
		iniciarSpinner();
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
			validarCampos();
		});//Fin callback bootbox
		FinalizarSpinner();
	}else{
		$('#numero_telefono').hide();
	}
}

$( "#enviar" ).click(function( event ) {
	event.preventDefault();	
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
		
		bootbox.dialog({
		message: msg,
		title: 'Recarga GSM',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					iniciarSpinner();
					//alert(numero);
					//$('#edit').append("<input value='"+monto[0]+"' type='hidden' name='skuid'>");
					//$('#edit').append("<input value='"+monto[1]+"' type='hidden' name='product'>");
					//$('#edit').append("<input value='"+monto[2]+"' type='hidden' name='retail_price'>");
					//$('#edit').append("<input value='"+monto[3]+"' type='hidden' name='wholesale_price'>");		
					//$('#edit').append("<input value='"+monto+"' type='hidden' name='sku'>");	
					//$('#edit').append("<input value='"+numero+"' type='hidden' name='destination_msisdn'>");				
					$.ajax({
						type: "POST",
						url: "/ov/billetera3/recargar_gsm",
						data: {
							sku:monto,
							destination_msisdn:numero,
							neto:neto,
							pago:pago,
							saldo:saldo
							} /*$('#edit').serialize()*/<?php //echo $api['url'];?>
					})
					.done(function( msg2 )
					{
						iniciarSpinner();
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
		url: "response_numero",///ov/billetera3/recargar_gsm
		data: {
			destination_msisdn:numero,
			action:'msisdn_info'
			}
	})
	.done(function( msg )
	{
		FinalizarSpinner();	
		$('#productos').hide();
		$('#foo').hide();
		if(!tel){
			//return false;			
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' >Digite Número de telefono</div>");
			return false;
		}else if(!msg){
			//return false;			
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' class='txt-color-red'>Número de telefono no valido</div>");
			return false;			
		}else{
			//$('#foo').show();
			if(!monto){
				getproduct(msg);				
			}
			//$("#numero").val(numero);			
			$("#msg_tel").remove();
			$('#validacion').append("<div id='msg_tel' class='txt-color-green'>Número de telefono Correcto</div>");
			
			return true;
		}
	});
	
	//if(!$('#numero').val()){
		//return false;
	//}
	
	return true;
}
	</script>
	
	<style>
	
	#validar{
		color: #fff;
		background: #3276b1;
	}
	
	</style>
	
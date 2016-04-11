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
                    							<h1 class="col-xs-4 col-md-4" >
					                           		<b>Recargate</b>
					                           </h1>
                        			    <a class="col-xs-5 col-md-5" href="http://andclau.com/" target="_blank">
											<img alt="" width="100%" src="/media/imagenes/andclau/andclau-negro-1.png">
										</a>
                        					
                						</div>
										
										</div>




									</div>


									<form action="send_mail" method="post" id="edit"
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
												<select style="width: 100%" class="select2" id="pais" required	name="pais">
													<?foreach ( $pais as $key ) {?>
														<option value="<?=$key->Code?>">
																<?=$key->Name?>
														</option>
													<?}?>
												</select>
											</section>
											<section >
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
											</section>
											<section >
												<label class="label"><b>Numero de Teléfono</b></label>
												
												<label class="input">
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
															min="1" type="number">
													</div> 
													<!--  <img
														src="../images/spinner.gif"
														class="margin_horizontal5 mr_input_spinner none">
													<img
														src="../images/check_mark.png"
														class="margin_horizontal5 check_mark none"> -->
													<div id="number_format_example" class="margin_top5">+57-##########</div>
												</label>
											</section>
											<section>
												<label class="label"><b>Monto</b></label> <label
													class="input"> <i class="icon-prepend fa fa-money"></i> <input
													name="cobro" type="number" min="1" step="0.01" class="from-control" required
													id="cobro" />
												</label>
											</section>
											
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
			$(document).ready(function() {
				
				// DO NOT REMOVE : GLOBAL FUNCTIONS!
				pageSetUp();

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
				if(neto > 0){
					$('#enviar').attr("disabled", false);
					}else{
						$('#enviar').attr("disabled", true);
					}
			}

$( "#edit" ).submit(function( event ) {
	event.preventDefault();	
	cobrar();
});

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
		title: 'Transacion',
		buttons: {
			success: {
			label: "Aceptar",
			className: "btn-success",
			callback: function() {
					iniciarSpinner();
					$.ajax({
						type: "POST",
						url: "/ov/billetera3/recargar_gsm",
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
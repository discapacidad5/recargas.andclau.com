<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> 
				<span>>
								<a href="bo/comercial">Comercial</a> >
								<a href="/bo/comercial/red">Red de Afiliacion</a> >  
								<a href="/bo/recargas/">Recargas</a> > Billetera
							</span> 
			</h1>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<h1 class="page-title txt-color-blueDark" style="padding: 2.7%;">
				<i style="color: #5B835B;" class="fa fa-money"></i> Balance
				<span class="txt-color-black"><b>$ <?=number_format($saldo,2)?> </b></span>
		
			</h1>
			
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" >
			
					<h1 class="page-title txt-color-blueDark " style="padding: 2.7%;">
					<i style="color: #5B835B;" class="fa fa-mobile-phone"></i> Wallet 
					<span class="txt-color-black">
					<b>$ <?=number_format($disponible,2)?> </b></span>
					</h1>
			
		</div>


	</div>
	<div class="row well">
	
		<div role="widget" class="jarviswidget jarviswidget-sortable" id="wid-id-11" data-widget-colorbutton="false" data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-fullscreenbutton="false" data-widget-custombutton="false">
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
								<header role="heading">
									<h2>Historiales</h2>	
									
									<ul id="widget-tab-1" class="nav nav-tabs pull-right">

										<li class="active">

											<a data-toggle="tab" href="#hr1"> <i class="fa fa-lg fa-list-alt"></i> <span class="hidden-mobile hidden-tablet"> Recargas </span> </a>

										</li>

										<li class="">
											<a data-toggle="tab" href="#hr2"> <i class="fa fa-lg fa-list-alt"></i> <span class="hidden-mobile hidden-tablet"> Pines </span></a>
										</li>
										
										<li class="">
											<a data-toggle="tab" href="#hr3"> <i class="fa fa-lg fa-list-alt"></i> <span class="hidden-mobile hidden-tablet"> Transferencias </span></a>
										</li>
										
										<li class="">
											<a data-toggle="tab" href="#hr4"> <i class="fa fa-lg fa-list-alt"></i> <span class="hidden-mobile hidden-tablet"> Ventas </span></a>
										</li>

									</ul>	
									
								<span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

								<!-- widget div-->
								<div role="content">
									
									<!-- widget edit box -->
									<div class="jarviswidget-editbox">
										<!-- This area used as dropdown edit box -->
										
									</div>
									<!-- end widget edit box -->
									
									<!-- widget content -->
									<div class="widget-body no-padding">

										<!-- widget body text-->
										
										<div class="tab-content padding-10">
											<div class="tab-pane fade active in" id="hr1">

				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-2" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>


					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body">
							<div class="tab-pane">
							
														<table id="dt_basic1" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-hide="phone,tablet">fecha</th>
													<th data-class="expand">Afiliado</th>
													<th data-hide="phone,tablet">destination_msisdn</th>
													<th data-hide="phone,tablet">operator</th>
													<th data-hide="phone,tablet">whole_price</th>
													<th data-hide="phone,tablet">retail_price</th>
													<th data-hide="phone,tablet">Precio local</th>
													
												</tr>
											</thead>
											<tbody>
												
												<?foreach ($facturas_recG as $factura_recG) {?>
													<tr>
														<td><?php  echo $factura_recG->fecha;?></td>
														<td><?php echo $factura_recG->nombre; ?></td>
														<td><?php  echo $factura_recG->destination_msisdn; ?></td>
														<td><?php  echo $factura_recG->Country; ?></td>
														<td><?php  echo $factura_recG->wholesale_price; ?></td>
														<td><?php  echo $factura_recG->retail_price; ?></td>
														<td><?php  echo $factura_recG->local;?></td>
														
													</tr>
												<?}?>
											</tbody>
										</table>
										 
								</div>
								
							</div>
						
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			
													
											</div>
											<div class="tab-pane fade" id="hr2">
												
<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>


					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body">
							<div class="tab-pane">
							
														<table id="dt_basic2" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-class="expand">Nombre afiliado</th>
													<th data-class="expand">Numero de Pin</th>
													<th data-hide="phone,tablet">Creditos</th>
													<th data-hide="phone,tablet">Costo</th>
													<th data-hide="phone,tablet">Fecha</th>
													
												</tr>
											</thead>
											<tbody>
												
												<?foreach ($pinesc as $pinc) {?>
													<tr>
														<td><?php echo $pinc->nombre; ?></td>
														<td><?php echo $pinc->id_pin; ?></td>
														<td><?php  echo $pinc->credito; ?></td>
														<td><?php  echo $pinc->costo; ?></td>
														<td><?php  echo $pinc->fecha; ?></td>
														</tr>
												<?}?>
											</tbody>
										</table>
										 
								</div>
								
							</div>
						
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
		<div class="row">         
	        <!-- a blank row to get started -->
	        <div class="col-sm-12">
	            <br />
	            <br />
	        </div>
        </div>            
		<!-- END ROW -->
	</section>
											
											
											</div>
											<div class="tab-pane fade" id="hr3">
												<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>


					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body">
							<div class="tab-pane">
							
														<table id="dt_basic4" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
												   <th data-class="expand">Transferecia Origen</th>
													<th data-class="expand">Transferecia Destino</th>
													<th data-class="expand">Monto de Transferencia</th>
													<th data-hide="phone,tablet">Fecha</th>
													
													
												</tr>
											</thead>
											<tbody>
												
												<?foreach ($Tranferencia as $factura_rec) {?>
													<tr>
														<td><?php  echo $factura_rec->origen;?></td>
														<td><?php  echo $factura_rec->destino;?></td>
														<td><?php echo $factura_rec->monto; ?></td>
														<td><?php  echo $factura_rec->fecha; ?></td>
														
														</tr>
												<?}?>
											</tbody>
										</table>
										 
								</div>
								
							</div>
						
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
		<div class="row">         
	        <!-- a blank row to get started -->
	        <div class="col-sm-12">
	            <br />
	            <br />
	        </div>
        </div>            
		<!-- END ROW -->
	</section>
												</div>
											
											<div class="tab-pane fade" id="hr4">
<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-editbutton="false" data-widget-custombutton="false" data-widget-colorbutton="false"	>


					<!-- widget div-->
					<div>
						
						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->
							
						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body">
							<div class="tab-pane">
							
														<table id="dt_basic3" class="table table-striped table-bordered table-hover" width="100%">
											<thead>			                
												<tr>
													<th data-hide="phone,tablet">Afiliado</th>
													<th data-class="expand">Transferido</th>
													<th data-class="expand">Valor</th>
													<th data-hide="phone,tablet">Fecha</th>
													
												</tr>
											</thead>
											<tbody>
												
												<?foreach ($ventas_recG as $factura_recG) {?>
													<tr>
														<td><?php  echo $factura_recG->afiliado;?></td>
														<td><?php echo $factura_recG->transferido; ?></td>
														<td><?php echo $factura_recG->valor; ?></td>
														<td><?php  echo $factura_recG->fecha; ?></td>
														
													</tr>
												<?}?>
											</tbody>
										</table>
										 
								</div>
								
							</div>
						
						<!-- end widget content -->
						
					</div>
					<!-- end widget div -->
				</div>
				<!-- end widget -->
			</article>
			<!-- END COL -->
		</div>
		<div class="row">         
	        <!-- a blank row to get started -->
	        <div class="col-sm-12">
	            <br />
	            <br />
	        </div>
        </div>            
		<!-- END ROW -->
	</section>
																						</div>
											
										</div>
										
										<!-- end widget body text-->
										
										<!-- widget footer -->
										<div class="widget-footer text-right">
											
											
									
										</div>
										<!-- end widget footer -->
										
									</div>
									<!-- end widget content -->
									
								</div>
								<!-- end widget div -->
								
							</div>
	</div>
</div>
<script src="/template/js/plugin/dropzone/dropzone.min.js"></script>
	<script src="/template/js/plugin/markdown/markdown.min.js"></script>
	<script src="/template/js/plugin/markdown/to-markdown.min.js"></script>
	<script src="/template/js/plugin/markdown/bootstrap-markdown.min.js"></script>
	<script src="/template/js/plugin/datatables/jquery.dataTables.min.js"></script>
	<script src="/template/js/plugin/datatables/dataTables.colVis.min.js"></script>
	<script src="/template/js/plugin/datatables/dataTables.tableTools.min.js"></script>
	<script src="/template/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
	<script src="/template/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
	<script src="/template/js/validacion.js"></script>
<script type="text/javascript">

$(document).ready(function() {
	
	$("#mymarkdown").markdown({
					autofocus:false,
					savable:false
				})


	/* BASIC ;*/
		var responsiveHelper_dt_basic = undefined;
		var responsiveHelper_datatable_fixed_column = undefined;
		var responsiveHelper_datatable_col_reorder = undefined;
		var responsiveHelper_datatable_tabletools = undefined;
		
		var breakpointDefinition = {
			tablet : 1024,
			phone : 480
		};

		$('#dt_basic1').dataTable({
			"bSort": false,
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic1'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});


		$('#dt_basic2').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic2'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});


		$('#dt_basic3').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic3'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});

		$('#dt_basic4').dataTable({
			"sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
				"t"+
				"<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
			"autoWidth" : true,
			"preDrawCallback" : function() {
				// Initialize the responsive datatables helper once.
				if (!responsiveHelper_dt_basic) {
					responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic4'), breakpointDefinition);
				}
			},
			"rowCallback" : function(nRow) {
				responsiveHelper_dt_basic.createExpandIcon(nRow);
			},
			"drawCallback" : function(oSettings) {
				responsiveHelper_dt_basic.respond();
			}
		});
		
		
	/* END BASIC */

	

	pageSetUp();

})

</script>
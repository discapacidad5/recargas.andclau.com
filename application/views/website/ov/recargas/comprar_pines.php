<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/ov"><i class="fa fa-home"></i> Menu</a> 				<span>
					<a href="/ov/billetera3/index"> > Billetera Recargas</a> > Recargas
					Multimedia
				</span>
			</h1>
		</div>
		


	</div>
	<div class="well">
		
			<legend>Recargas Multimedia</legend>
			<div class="col-lg-3 col-md-3 col-xs-12"></div>
			<form  class="smart-form" action="" method="POST" id="pin" role="form">
		<fieldset>
				 <?php  foreach ($creditos as $credito) {   ?>
			
			<div class="well well-sm txt-color-white text-center col-xs-12 col-sm-2 col-md-2 col-lg-2 primary margin2" style="padding: 2px">
						<h3><b><?php echo $credito->credito;?> Creditos</b> </h3>
						<p>$ <?php echo $credito->costo;?> USD</p>
						<input id="credit" type="radio" name="id" value="<?php echo $credito->id."|".$credito->costo."|".$credito->credito;?>" required="required" />		
					</div>
			<?} ?>
			
			<div class="col-lg-2 col-md-2 col-xs-12"><input style="margin: 1rem;margin-bottom: 4rem;" type="submit" value="Comprar" class="btn btn-success pull-right"></div>
			
		</fieldset>	
			</form>
			
		
	</div>
</div>

<script type="text/javascript">
var credito="";
var id=<?=$id?>;
$( "#pin" ).submit(function( event ) {
	credito=$("#credit:checked").val().split("|");	
	event.preventDefault();			
	enviar();
		
});


function enviar() {

	//alert(credito+"|"+id);
	$.ajax({
		type: "POST",
		url: "/auth/show_dialog",
		data: {message: '¿ Esta seguro que desea Comprar este PIN ?'},
	})
	.done(function( msg )
	{
		bootbox.dialog({
		message: msg,
		title: 'Comprar Pin',
		buttons: {
			success: {
				label: "Aceptar",
				className: "btn-success",
				callback: function() {
					iniciarSpinner();
	 					$.ajax({
							type: "POST",
							url: "/ov/billetera3/comprar_pin",
							data: {
                                id:id,
								credito:credito[2],
								valor:credito[1],
	 							pin:credito[0]
								}
						})
						.done(function( msg ) {
							//alert(credito+"|"+id);
									bootbox.dialog({
										message: msg,
										title: "Atención",
										buttons: {
											success: {
											label: "Ok!",
											className: "btn-success",
											callback: function() {
												location.href="/ov/billetera3/";
												FinalizarSpinner();
												}
											}
										}
									});
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

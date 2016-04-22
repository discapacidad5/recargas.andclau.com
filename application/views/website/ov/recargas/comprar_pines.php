<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span>>
					Billetera Recargas </span>
			</h1>
		</div>
		


	</div>
	<div class="well">
		
			<legend>Comprar Pines</legend>
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12"></div>
			<form  class="smart-form" action="" method="POST" id="pin" role="form">
		<fieldset>
				 <?php  foreach ($creditos as $credito) {   ?>
			
			<div class="well well-sm txt-color-white text-center col-xs-12 col-sm-4 col-md-4 col-lg-3 link primary margin2" >
						<h6>$ <?php echo $credito->credito;?></h6>
						<input id="credit" type="radio" name="id" value="<?php echo $credito->id."|".$credito->valor;?>" required="required" />		
					</div>
			<?} ?>
			<br>
			<br>
			<br>
			<br><br><br>
			<div class="col-lg-3 col-sm-4 col-md-4 col-xs-12"></div>
			<input style="margin: 1rem;margin-bottom: 4rem;" type="submit" value="Comprar" class="btn btn-success">
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
	setiniciarSpinner();
	enviar();
		
});


function enviar() {

	//alert(credito+"|"+id);
	 $.ajax({
							type: "POST",
							url: "/ov/billetera3/comprar_pin",
							data: {
                                id:id,
								credito:credito[0],
								valor:credito[1]
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
</script>

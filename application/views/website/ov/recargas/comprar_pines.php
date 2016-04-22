<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span>>
					Billetera Recargas </span>
			</h1>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
			<h1 class="page-title txt-color-blueDark">
				<i style="color: #5B835B;" class="fa fa-money"></i> Saldo Billetera
				<span class="txt-color-black"><b>$ <?=number_format($saldo,2)?> </b></span>
			</h1>
		</div>
		<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" >
			
					<h1 class="page-title txt-color-blueDark " style="padding: 2.7%;"><i style="color: #5B835B;" class="fa fa-mobile-phone"></i> 
					Saldo Recargas <span class="txt-color-black">
					<b>$ <?=number_format($disponible,2)?> </b>
					</span>&nbsp;&nbsp;<span><a onclick='<?php echo $saldo<>0 ? "agregar()" : "notice()" ?>' style="cursor: pointer;" >
						<div class=" btn btn-success txt-color-white text-center " style="width: 7.5em;padding: 0px;">
							<h5>
								<i class="fa fa-plus "></i><i class="fa fa-mobile-phone "></i>&nbsp;&nbsp;Agregar
							</h5>
						</div>
					</a></span></h1>
			
		</div>


	</div>
	<div class="well">
		<fieldset>
			<legend>Comprar Pines</legend>
			<form action="" method="post">
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12"></div>
			 <?php  foreach ($creditos as $credito) {   ?>
			
			<div class="well well-sm txt-color-white text-center col-xs-12 col-sm-4 col-md-4 col-lg-3 link primary margin2" >
						<h6>$ <?php echo $credito->credito;?></h6>
						<input type="radio" value="<?php echo $credito->id;?>" />		
					</div>
			<?} ?>
			</form>
			
			
			
		</fieldset>
	</div>
</div>

<script type="text/javascript">

function comprar(){
	$.ajax({
		type: "POST",
		url: "/ov/billetera3/canjear",
		data: {}
	})
	.done(function( msg )
	{					
		bootbox.dialog({
			message: msg,
			title: 'Agregar Saldo',
			buttons: {
				danger: {
					label: "Volver",
					className: "btn-danger",
					callback: function() {

						}
			}
		}})//fin done ajax
	});//Fin callback bootbox
}	

function notice(){
	alert("No hay saldo para Canjear.")
}

</script>
<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/ov"><i class="fa fa-home"></i> Menu</a> <span>>
					<a href="/ov/billetera3/index"> Billetera Recargas</a>  > Multimedia </span>
			</h1>
		</div>
		


	</div>
	<div class="well">
		<fieldset>
			<legend>Menú Multimedia</legend>
           <div aling="center">
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12"></div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 link"">
				<a href="<?php echo $disponible>0 ? "/ov/billetera3/multimedia" : "/ov/billetera3/#" ?>">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-mobile-phone fa-3x"></i>
						<h5>Nuevo Paquete</h5>
					</div>
				</a>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 link">
				<a href="/ov/billetera3/listar_pinescomprados">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-list-alt fa-3x"></i>
						<h5>Historial Multimedia</h5>
					</div>
				</a>
			</div>
			</div>
		</fieldset>
	</div>
</div>

<script type="text/javascript">

function agregar(){
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
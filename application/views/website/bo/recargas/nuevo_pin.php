		<!-- MAIN CONTENT -->
			<div id="content" >
				<div class="row">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<h1 class="page-title txt-color-blueDark">
							<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a>
							<span>>
								<a href="bo/comercial">Comercial</a> >  
								<a href="/bo/comercial/red">Red de Afiliacion</a> >
								<a href="/bo/recargas/">Recargas</a> >
								<a href="/bo/recargas/pines">Pines</a> > Alta
							</span>
						</h1>
					</div>
				</div>
	<section id="widget-grid" class="">
		<!-- START ROW -->
		<div class="row">
			<!-- NEW COL START -->
			<article class="col-sm-12 col-md-12 col-lg-12">
				<!-- Widget ID (each widget will need unique ID)-->
				<div class="jarviswidget" id="wid-id-1" data-widget-colorbutton="false"
          data-widget-editbutton="false" data-widget-togglebutton="false" data-widget-deletebutton="false" data-widget-sortable="false"
          data-widget-fullscreenbutton="false" data-widget-custombutton="false" data-widget-collapsed="false">
					<div>

						<!-- widget edit box -->
						<div class="jarviswidget-editbox">
							<!-- This area used as dropdown edit box -->

						</div>
						<!-- end widget edit box -->
						<!-- widget content -->
						<div class="widget-body no-padding smart-form">
<div>
    <fieldset id="pswd">
		<form class="smart-form" action="" method="POST" id="pin" role="form">
			<legend>Nuevo PIN </legend><br>
			<div class="form-group" style="width: 20rem;">
			<label style="margin: 1rem;" class="input"><i class="icon-prepend fa fa-check-circle-o"></i>
				<input id='id'  class="form-control" name="id" size="10" pattern="[0-9]{10}" type="number" placeholder="PIN"  required>
	        </label>
	        <label style="margin: 1rem;" class="input">
	       <TEXTAREA id='desc'  class="form-control" name="descripcion" placeholder="Descripcion" rows="3" cols="30" >
</TEXTAREA> 
	        </label>
			<label style="margin: 1rem;" class="select"><i class="icon-prepend fa fa-check-circle-o"></i>	        
	        <select id='porc' class="form-control" name="valor" required>
	        <option value="1">valor: € 10 cubre 2000 créditos </option>
	        <option value="2">valor: € 25 cubre 5000 créditos </option>
	        <option value="3">valor: € 50 cubre 10000 créditos </option>
	        </select>
	        </label>
	       
			<button style="margin: 1rem;margin-bottom: 4rem;" type="submit" class="btn btn-success">Crear</button>
			</div>
		</form>
    </fieldset>
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
	</section>	
				<div class="row">         
			        <!-- a blank row to get started -->
			        <div class="col-sm-12">
			            <br />
			            <br />
			        </div>
		        </div>
			</div>
			<!-- END MAIN CONTENT -->
<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">

function validar(){
	var id = $("#id").val();
	if(id.length==10){
		return true;
	}
}

$( "#pin" ).submit(function( event ) {
	event.preventDefault();	
	if(validar()){
		iniciarSpinner();
		enviar();
	}else{
		alert("la longitud del PIN no debe superar los 10 digitos!")
	}	
});

function enviar(){
	$.ajax({
		type: "POST",
		url: "/bo/recargas/ingresar_pin",
		data: $('#pin').serialize()
	}).done(function( msg ) {				
		bootbox.dialog({
			message: msg,
			title: 'ATENCION',
			buttons: {
				success: {
					label: "Aceptar",
					className: "btn-success",
					callback: function() {
							location.href="/bo/recargas/listar_pines";
							FinalizarSpinner();
					}
				}
			}
		})
	});//fin Done ajax
}

</script>
<style>
.link
{
	margin: 0.5rem;
}
.minh
{
	padding: 50px;
}
.link a:hover
{
	text-decoration: none !important;
}
</style>
			


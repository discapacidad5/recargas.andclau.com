<div id="spinner-div"></div>
<form id="pin" action="/bo/recargas/actualizar_pin" class="smart-form"  role="form" >
							<fieldset>
							<label class="input">
								<input type="text" class="hide"  value="<?php echo $_POST['id']; ?>" name="id2">
								<label class="input"> PIN
<<<<<<< HEAD
								<input type="text" name="id" required placeholder="id" style="width: 50%;" size="10" class="form-control" value="<?php echo $pin[0]->id; ?>" required>
=======
								<input type="number" size="10" pattern="[0-9]{10}" id="id" name="id" required placeholder="id" style="width: 50%;" class="form-control" value="<?php echo $pin[0]->id; ?>" required>
>>>>>>> 10e48bbb14e40faa84379a908072521fa8db9562
								<label class="input"> Descripcion
								<input type="text" name="descripcion"  placeholder="Descripcion" style="width: 50%;" class="form-control" value="<?php echo $pin[0]->descripcion; ?>" required>
								<label class="input"> Valor
							        <select id='porc' class="form-control" name="valor" required>
								        <option value="<?php echo $pin[0]->id_pin_tarifas; ?>" >Seleccione el valor</option>
								        <option value="1">valor: € 10 cubre 2000 créditos </option>
								        <option value="2">valor: € 25 cubre 5000 créditos </option>
								        <option value="3">valor: € 50 cubre 10000 créditos </option>
							        </select>
						        </label>
							</fieldset>
							<footer>
								<button style="margin: 1rem;margin-bottom: 4rem;" type="input" class="btn btn-success">Guardar</button>
								
							</footer>
						</form>

<script src="/template/js/plugin/jquery-form/jquery-form.min.js"></script>
<script src="/template/js/validacion.js"></script>
<script src="/template/js/plugin/fuelux/wizard/wizard.min.js"></script>
<script type="text/javascript">

function validar(){
	var id = $("#id").val();
	if(id.length<=10){
		return true;
	}
}

$( "#pin" ).submit(function( event ) {
	event.preventDefault();	
	if(validar()){
		setiniciarSpinner();
		enviar();
	}else{
		alert("la longitud del PIN no debe superar los 10 digitos!")
	}	
});

function enviar() {
	 $.ajax({
							type: "POST",
							url: "/bo/recargas/actualizar_pin",
							data: $('#pin').serialize()
						})
						.done(function( msg ) {
							
									bootbox.dialog({
										message: msg,
										title: "Atención",
										buttons: {
											success: {
											label: "Ok!",
											className: "btn-success",
											callback: function() {
												location.href="/bo/recargas/listar_pines";
												FinalizarSpinner();
												}
											}
										}
									});
						});//fin Done ajax
		
}
</script>

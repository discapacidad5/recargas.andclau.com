<div id="spinner-div"></div>
<form id="pin" action="/bo/recargas/actualizar_pin" class="smart-form"
	role="form">
	<fieldset style="width: 20rem;">
		<label class="input"> <input type="text" class="hide"
			value="<?php echo $_POST['id']; ?>" name="id2">
		</label>	
		<label class="input">
			PIN <input type="text" name="id" id="id" required placeholder="id" size="10" class="form-control"
				value="<?php echo $pin[0]->id; ?>" required> 
		</label>
		<label class="input">
			Descripcion  <TEXTAREA id='desc'  
			class="form-control" name="descripcion" 
			placeholder="Descripcion" style="padding-left: 3%;"
			rows="3" cols="30" ><?php echo $pin[0]->descripcion; ?></TEXTAREA>
		</label>
		<label class="select"> 
			Valor <select id='porc' class="form-control" name="valor" required>
			<?php foreach ($tarifas as $tarifa){?>							
				<option <?=($pin[0]->id_pin_tarifas==$tarifa->id) ? "selected" : "" ?>  value="<?=$tarifa->id?>">
					Valor: € <?=$tarifa->valor?> cubre <?=$tarifa->credito?> créditos 
				</option>
			<?php }?>
			</select>
		</label>
		<label >Costo en Dólares</label>		
			<label class="input">
			<i class="icon-prepend fa fa-dollar"></i>
				<input id='costo' class="form-control" name="costo" step="0.01" min="0" type="number" value="<?=$pin[0]->costo?>" placeholder="" required>
	       </label>
	</fieldset>
	<footer>
		<input style="margin: 1rem; margin-bottom: 4rem;" type="submit"
			class="btn btn-success" value="Guardar">

	</footer>
</form>

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
		setiniciarSpinner();
		enviar();
	}else{
		alert("la longitud del PIN debe tener los 10 digitos!")
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

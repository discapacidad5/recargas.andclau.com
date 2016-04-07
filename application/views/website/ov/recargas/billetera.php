<!-- MAIN CONTENT -->
<div id="content">
	<div class="row">
		<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
			<h1 class="page-title txt-color-blueDark">
				<a class="backHome" href="/bo"><i class="fa fa-home"></i> Menu</a> <span>>
					Billetera Recargas </span>
			</h1>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
						<h1 class="page-title txt-color-blueDark">
							<i style="color: #5B835B;" class="fa fa-money"></i> Saldo Billetera Recargas <span class="txt-color-black"><b>$ <?=number_format($saldo,2)?> </b></span>
						</h1>
		</div>
	</div>
	<div class="well">
		<fieldset>
			<legend>Menú Recargas</legend>

			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12"></div>
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
				<a href="/ov/reccargas/recargas_gsm">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-mobile-phone fa-3x"></i>
						<h5>Recargas GSM</h5>
					</div>
				</a>
			</div>
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
				<a href="/ov/reccargas/recargas_gsm">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-rss fa-3x"></i>
						<h5>Recargar VOIP</h5>
					</div>
				</a>
			</div>
			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
				<a href="/ov/billetera2/historial">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-laptop fa-2x"></i><i class="fa fa-desktop fa-3x"></i><i class="fa fa-tablet fa-2x"></i>
						<h5>Recargas Multimedia</h5>
					</div>
				</a>
			</div>

			<div class="col-lg-2 col-sm-4 col-md-4 col-xs-12">
				<a href="/ov/billetera2/historial">
					<div class="well well-sm txt-color-white text-center link_dashboard" style="background:<?=$style[0]->btn_1_color?>">
						<i class="fa fa-file-text-o fa-3x"></i><i class="fa fa-refresh fa-3x"></i><i class="fa  fa-file-text-o fa-3x"></i>
						<h5>TRANSFER</h5>
					</div>
				</a>
			</div>

		</fieldset>
	</div>
</div>
<style type="text/css">
	.num-indicadores{
		text-align: center;
	}
</style>
<div class="row">
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Porcentaje realizado</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros_user_porcentaje'])); ?>%</h1>
			</div>
		</div>
	</div>
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Registros por referenciar</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros_user_referenciados'])); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Registros terminados</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros_user_guardados'])); ?></h1>
			</div>
		</div>
	</div>
</div>
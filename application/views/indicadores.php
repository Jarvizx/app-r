<style type="text/css">
	.num-indicadores{
		text-align: center;
	}
</style>
<!--<pre>
	<?php print_r($indicadores); ?>
</pre>-->

<div class="row">
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">Cuantos registros(med. x fuentes) hay?</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros'])); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">Cuantos esta asignados?</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros_asignados'])); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-4 num-indicadores">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">Cuantos estan terminados?</h3>
			</div>
			<div class="panel-body">
				<h1><?php echo reset(reset($indicadores['num_registros_terminados'])); ?></h1>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">Control de Usuarios</h3>
			</div>
			<div class="panel-body">
			<div class="table-responsive">
				<table class="table">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Fecha Ultimo Registro</th>
							<th>Registros asignados/terminados</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($indicadores['num_registros_user'] as $key => $value): ?>
							<tr>
								<td><?php echo $value['username']; ?></td>
								<td><?php echo $value['r_recha_ultimo_registro']; ?></td>
								<td><?php echo $value['r_asignados']; ?>/<?php echo $value['r_terminados']; ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	.num-indicadores{
		text-align: center;
	}
</style>
<?php foreach ($indicadores['num_registros_user_porcentaje'] as $key => $value): ?>
	<?php if ($value['usuario_asignado'] == $this->user->id): ?>
		<div class="row">
			<div class="col-md-4 num-indicadores">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h3 class="panel-title">Porcentaje realizado</h3>
					</div>
					<div class="panel-body">
						<h1><?php echo $value['porcentaje_realizado']; ?>%</h1>
					</div>
				</div>
			</div>
			<div class="col-md-4 num-indicadores">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Registros por referenciar</h3>
					</div>
					<div class="panel-body">
						<h1><?php echo $value['r_por_terminar']; ?></h1>
					</div>
				</div>
			</div>
			<div class="col-md-4 num-indicadores">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Registros terminados</h3>
					</div>
					<div class="panel-body">
						<h1><?php echo $value['r_terminados']; ?></h1>
					</div>
				</div>
			</div>
			<div class="col-md-8">
			<div class="panel panel-warning">
				<div class="panel-heading">
					<h3 class="panel-title">Control de Usuarios</h3>
				</div>
				<div class="panel-body">
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th>Posición</th>
								<th>Nombre</th>
								<th>Porcentaje realizado</th>
								<th>Fecha Ultimo Registro</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($indicadores['num_registros_user_porcentaje'] as $key => $value): ?>
								<?php if ($value['usuario_asignado'] == $this->user->id): ?>
									<tr class="info">
										<td><?php echo $key+1; ?></td>
										<td><?php echo $value['username']; ?></td>
										<td><?php echo $value['porcentaje_realizado']; ?> %</td>
										<td><?php echo $value['r_fecha_ultimo_registro']; ?></td>
									</tr>
								<?php else: ?>
									<tr class="active">
										<td><?php echo $key+1; ?></td>
										<td><?php echo $value['username']; ?></td>
										<td><?php echo $value['porcentaje_realizado']; ?> %</td>
										<td><?php echo $value['r_fecha_ultimo_registro']; ?></td>
									</tr>
								<?php endif ?>
							<?php endforeach ?>
						</tbody>
					</table>
				</div>
				</div>
			</div>
		</div>
		</div>
	<?php endif ?>
<?php endforeach ?>
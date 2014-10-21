<div class="row">
	<div class="col-md-12">
		<a href="/medicamentos/generar_excel" target="_blank" class="btn btn-default">Descargar Consolidado Parcial</a>
		<a href="/medicamentos/generar_excel_all" target="_blank" class="btn btn-default">Descargar Consolidado Total</a>

	</div>
	<div class="col-md-12">
	<h3>Consolidado Parcial</h3>
		<div class="table-responsive" style="overflow-x: auto;">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>id_mercado</th>
						<th>descripcion_mercado</th>
						<th>atc_invima</th>
						<th>descripcion_atc</th>
						<th>forma_farmaceutica</th>
						<th>expediente_ficha</th>
						<th>expediente</th>
						<th>medicamentos</th>
						<th>pais</th>
						<th>fuente</th>
						<th>tipo_precio</th>
						<th>moneda</th>
						<th>precio_referencia</th>
						<th>cantidad</th>
						<th>precio_por_unidad</th>
						<th>casual_no_precio</th>
						<th>link</th>
						<th>nombre_archivo</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($consolidado as $key => $value): ?>
						<tr>
							<td><?php echo $value['id_mercado'];?></td>
							<td><?php echo $value['descripcion_mercado'];?></td>
							<td><?php echo $value['atc_invima'];?></td>
							<td><?php echo $value['descripcion_atc'];?></td>
							<td><?php echo $value['forma_farmaceutica'];?></td>
							<td><?php echo $value['expediente_ficha'];?></td>
							<td><?php echo $value['expediente'];?></td>
							<td><?php echo $value['medicamentos'];?></td>
							<td><?php echo $value['pais'];?></td>
							<td><?php echo $value['fuente'];?></td>
							<td><?php echo $value['tipo_precio'];?></td>
							<td><?php echo $value['moneda'];?></td>
							<td><?php echo $value['precio_referencia'];?></td>
							<td><?php echo $value['cantidad'];?></td>
							<td><?php echo $value['precio_por_unidad'];?></td>
							<td><?php echo $value['casual_no_precio'];?></td>
							<td><?php echo $value['link'];?></td>
							<td><?php echo $value['nombre_archivo'];?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
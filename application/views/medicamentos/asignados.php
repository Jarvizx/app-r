<table class="table">
	<thead>
		<tr>
			<th>Pais</th>
			<th>Fuente</th>
			<th>Nombre Medicamento</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($medicamentos as $key => $value): ?>
	<tr>
		<td><?php echo $value['nombre_pais']; ?></td>
		<td><?php echo $value['nombre_fuente']; ?></td>
		<td><?php echo $value['medicamentos']; ?></td>
		<td><a href="/medicamentos/asignados/<?php echo $value['id']; ?>"><?php echo $value['estado']; ?></a></td>
		<!--<td><a class="btn btn-default" href="/medicamentos/asignados/<?php echo $value['id']; ?>">Referenciar</a></td>-->
	</tr>
	<?php endforeach ?>
	</tbody>
</table>
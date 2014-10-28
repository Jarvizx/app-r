<?php if($this->session->flashdata('message')): echo $this->session->flashdata('message'); endif;?>
	<br>
	<table id="t_asignar" class="table">
		<thead>
			<tr>
				<th># expediente</th>
				<th>Nombre</th>
				<th>Usuario asignado</th>
				<!--<th>Estado</th>-->
			</tr>
		</thead>
		<tbody>
			<?php foreach ($list_asignacion as $key => $value): ?>
				<tr>
					<td><?php echo $value['expediente_ficha']; ?></td>
					<td><p data-toggle="tooltip" data-placement="top" title="<?php echo $value['nombre_db']; ?>"><?php echo $value['medicamentos']; ?></p></td>
					<td>
						<select id-med="<?php echo $value['id']; ?>">
							<option value=""> - Asignar - </option>
							<?php foreach ($usuarios as $keyusr => $valueusr): ?>
								<?php if ($valueusr['id'] == $value['id_usr']): ?>
									<option value="<?php echo $valueusr['id']; ?>" selected><?php echo $valueusr['username']; ?></option>
								<?php else: ?>
									<option value="<?php echo $valueusr['id']; ?>"><?php echo $valueusr['username']; ?></option>
								<?php endif ?>
							<?php endforeach ?>
						</select>
					</td>
					<!--<td><?php echo $value['estado']; ?></td>-->
				</tr>
			<?php endforeach ?>
		</tbody>
	</table>

	<ul class="pagination">
		<?php //print_r($paginacion); ?>
	</ul>

	<script type="text/javascript">


		$(document).ready(function() {

			$('p').tooltip();

			$('select').change(function(){
				var id_usr = $(this).val();
				var id_med = $(this).attr('id-med');
				$.ajax({
					type: "GET",
					url: "/medicamentos/asignar",
					data: { id: id_med, id_usr:id_usr }
				}).done(function(msg){
					console.log('ok...');
				});
			});

			$('#t_asignar').DataTable();
		});

	//ajax
</script>
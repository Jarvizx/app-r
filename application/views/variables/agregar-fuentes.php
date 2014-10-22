<div class="form-dinamic well">
<?php echo form_open_multipart('variables/agregar_fuentes', array('id' => 'form-interaccion', 'role' => 'form')); ?>
	<div class="form-group">
		<label for="pais">Pais *</label>
		<select class="form-control" name="pais">
				<option value=""> - Asignar - </option>
			<?php foreach ($pais as $key => $value): ?>
				<option value="<?php echo $value['id']; ?>"><?php echo $value['nombre'] . '  ['.$value['moneda'].']'; ?></option>
			<?php endforeach; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="nombre">Nombre de la fuente* </label>
		<input class="form-control" type="text" name="nombre-fuente">
	</div>
	<div class="form-group">
		<label for="link">Link</label>
		<input class="form-control" type="text" name="link-fuente">
	</div>
	<div class="form-group">
		<label for="archivo">Archivo</label>
		<input type="file" name="userfile" size="20" />
	</div>
	<div class="form-group">
		<label for="tipo-precio">Tipo Precio *</label>
		<?php foreach ($tipo_precio as $key => $value): ?>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="tipo-precio[][<?php echo $value["id"]; ?>]" value="<?php echo $value["nombre"]; ?>">
					<?php echo $value["nombre"]; ?>
				</label>
			</div>
		<?php endforeach ?>
	</div>
<?php echo form_submit('btnSubmit', 'Guardar', "id='loading-btn' class='btn btn-primary' data-loading-text='Guardando...'") ?>
<?php echo form_close() ?>	
</div>
<?php echo isset($error) ? $error: null;?>

<?php echo form_open_multipart('medicamentos/agregar');?>

<div class="form-group">
<label for="email">Nombre</label>
	<input type="text" class="form-control" id="nombre_db" name="nombre_db" placeholder="este campo es opcional">
</div>
<div class="form-group">
	<label for="exampleInputFile">Archivo</label>
	<input type="file" name="userfile" size="20" />
	<p class="help-block">Recuerde que debe ser un archivo de texto(.csv) delimitado por punta y coma(;). 
		<a href="/assets/uploads/files/csv-ejemplo.csv">descargar ejemplo</a>
	</p>
</div>

<input class="btn" type="submit" value="Enviar" />


<?php print_r($error);?>

<?php echo form_open_multipart('welcome/folder');?>

<div class="form-group">
<label for="exampleInputEmail1">Nombre (opcional)</label>
	<input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
</div>
<div class="form-group">
	<label for="exampleInputFile">Archivo</label>
	<input type="file" name="userfile" size="20" />
	<p class="help-block">Recuerde que debe ser un archivo de texto(.csv) delimitado por punta y coma(;). <a href="#">ejemplo</a></p>
</div>


<input type="submit" value="upload" />
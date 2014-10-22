<?php 
foreach ($paisfuente as $key => $value) {
	$edit['nombre_pais'] = $value['nombre_pais'];
	$edit['moneda'] = $value['moneda'];
	$edit['id'] = $value['id'];
	$edit['fuentes'][$value['nombre']]['nombre'] = $value['nombre'];
	$edit['fuentes'][$value['nombre']]['link'] = $value['link'];
	$edit['fuentes'][$value['nombre']]['nombre_archivo_original'] = $value['nombre_archivo_original'];
	$edit['fuentes'][$value['nombre']]['habilitado'] = $value['habilitado'];
	$edit['fuentes'][$value['nombre']]['tipos'][$value['id_fuente']] = $value['tipo_precio'];
	// los tipos tienen los id de las fuentes, es multiple id :(
}
?>
<?php echo form_open_multipart('variables/agregar_pais', array('id' => 'form-interaccion', 'role' => 'form')); ?>

	<div class="form-group">
		<label for="descripcion">Nombre</label>
		<input class="form-control" type="text" name="nombre" value="<?php echo $edit['nombre_pais'] ?>">
		<input class="form-control" type="hidden" name="id_pais" value="<?php echo $edit['id'] ?>">
	</div>
	<div class="form-group">
		<label for="descripcion">Moneda</label>
		<input class="form-control" type="text" name="moneda" value="<?php echo $edit['moneda'] ?>">
	</div>

	<div class="form-group">
		<button class="btn btn-success agregar-fuente" type="button">Agregar Fuente + </button>
	</div>
													<!--FALTA EL CONTADOR!-->
	<div class="fuentes-dinamica" contador-global="0">
		<?php foreach ($edit['fuentes'] as $keyf => $valuef): ?>
			<div class="form-dinamic well">
				<div class="form-group">
					<label for="descripcion">Nombre de la fuente*</label>
					<input class="form-control" type="text" name="nombre-fuente" value="<?php echo $valuef['nombre'] ?>">
				</div>
				<div class="form-group">
					<label for="descripcion">Link</label>
					<input class="form-control" type="text" name="link-fuente" value="<?php echo $valuef['link'] ?>">
				</div>
				<div class="form-group">
					<label for="descripcion">Archivo:   <?php echo $valuef['nombre_archivo_original']; ?> </label>
					<input type="file" name="userfile" size="20" />
				</div>
				<div class="form-group">
					<label for="descripcion">Tipo Precio</label>
						<?php foreach ($valuef['tipos'] as $key => $value): ?>
						<div class="checkbox">
							<label>
								<input type="checkbox" name="tipo-precio['+id+'][<?php echo $key; ?>]" value="<?php echo $value; ?>" checked disabled>
								<?php echo $value; ?>
							</label>
						</div>
						<?php endforeach ?>
				</div>
				<button type="button" class="btn btn-xs btn-warning deshabilitar-referencia pull-right"> deshabilitar fuente</button>
			</div>
		<?php endforeach ?>

	</div>

<?php echo form_submit('btnSubmit', 'Guardar', "id='loading-btn' class='btn btn-primary' data-loading-text='Guardando...'") ?>
	<hr>
<?php echo form_close() ?>


<!--remembre, por cada tipo precio es nuevo registro-->


<script type="text/javascript">
	
	function boton_agregar_fuente(id){

		return '<div class="form-dinamic well"><div class="form-group"><label for="descripcion">Nombre de la fuente* (Este campo es Obligatorio)</label><input class="form-control" type="text" name="nombre-fuente['+id+']"></div><div class="form-group"><label for="descripcion">Link</label><input class="form-control" type="text" name="link-fuente['+id+']"></div><div class="form-group"><label for="descripcion">Archivo</label><input type="file" name="userfile['+id+']" size="20" /></div><div class="form-group"><label for="descripcion">Tipo Precio</label><?php foreach ($tipo_precio as $key => $value): ?><div class="checkbox"><label><input type="checkbox" name="tipo-precio['+id+'][<?php echo $value["id"]; ?>]" value="<?php echo $value["nombre"]; ?>"><?php echo $value["nombre"]; ?></label></div><?php endforeach ?></div><button class="btn btn-xs btn-warning quitar-referencia pull-right"> - Quitar fuente</button></div>';
	}

	$(".agregar-fuente").on('click', function(){
		var miContador, valor_count;
		valor_count = $('.fuentes-dinamica').attr('contador-global');
		miContador = $('.fuentes-dinamica').attr('contador-global', parseInt(valor_count)+1);
		$('.fuentes-dinamica').append(boton_agregar_fuente(parseInt(valor_count)+1));
	});

	$("#form-interaccion").on('click', '.quitar-referencia', function(){
		$(this).parent().remove();
	});
</script>
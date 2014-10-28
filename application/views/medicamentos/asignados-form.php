<div class="well">
	<div class="row">
		<div class="col-md-12">
			<?php foreach ($dta_reff as $key => $value): ?>	
				<h3>Nombre Medicamento: <?php echo $value['medicamentos']; ?></h3>
				<h4>ATC: <?php echo $value['atc_invima']; ?> | Descripción ATC: <?php echo $value['descripcion_atc']; ?> | Forma farmacéutica: <?php echo $value['forma_farmaceutica']; ?></h4>
			<?php endforeach ?>
		</div>
		<div class="col-md-6">
			<h2 class="page-header">Datos de la Fuente:</h2>
			<?php foreach ($dta_reff as $key => $value): ?>

				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Pais: </strong> <?php echo $value['nombre_pais']; ?></p>
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Moneda: </strong> <?php echo $value['moneda']; ?></p>
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Nombre: </strong> <?php echo $value['nombre_fuente']; ?></p>
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Link: </strong> <?php echo (!empty($value['link_fuente']))? '<a tarjet="_black" href="'.$value['link_fuente'].'" target="_blank">'.$value['link_fuente'].'</a>': '---'; ?></p>
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Descargar archivo: </strong> 
						<?php if ($value['nombre_archivo'] == 'Sin Archivos Registrados'): ?>
							<?php echo $value['nombre_archivo']; ?>
						<?php else: ?>
							<a href="/assets/uploads/fuentes/<?php echo $value['nombre_archivo']; ?>" target="_blank"><?php echo $value['nombre_archivo_original']; ?></a></p>
						<?php endif ?>
				  </div>
				</div>
				<div class="panel panel-default">
				  <div class="panel-body">
					<p><strong>Tipo: </strong> <?php echo $value['tipo_precio']; ?></p>
				  </div>
				</div>
			
				<?php break; ?>

			<?php endforeach ?>
		</div>
		<div class="col-md-6">
			<h2 class="page-header">Formulario de Referencia:</h2>
			<?php 
			if (isset($arrowsright[0]['id'])) {
				$ruta = $arrowsright[0]['id'];
			}else{
				$ruta = null;
			}
			 ?>
			<?php echo form_open_multipart('/medicamentos/guardar_referencia/'.$ruta, array('id' => 'form-referencia', 'role' => 'form')); ?>
			<div class="form-group">
				<label for="descripcion">Precio Referencia</label>
				<input class="form-control block-precio precio_referencia number" type="text" name="precio_referencia" value="<?php echo $dta_reff[0]['precio_referencia']; ?>" <?php echo (!empty($dta_reff[0]['casual_no_precio'])) ? 'disabled': '';?> >
			</div>
			<div class="form-group">
				<label for="descripcion">Cantidad</label>
				<input class="form-control block-precio cantidad" type="text" name="cantidad_referencia" value="<?php echo $dta_reff[0]['cantidad']; ?>" <?php echo (!empty($dta_reff[0]['casual_no_precio'])) ? 'disabled': '';?> >
			</div>
			<div class="form-group">
				<label for="descripcion">Código de Referencia</label>
				<input class="form-control" type="text" name="codigo_de_referencia" value="<?php echo $dta_reff[0]['codigo_de_referencia']; ?>">
			</div>
			<div class="form-group">
				<label for="descripcion">Precio Por Unidad</label>
				<input class="form-control" type="text" name="precio_por_unidad" disabled>
			</div>
			<div class="form-group">
				<label for="descripcion">Causal No Precio</label>
				<select class="form-control precio-casual" name="casual_no_precio" <?php echo (!empty($dta_reff[0]['precio_referencia']) or !empty($dta_reff[0]['precio_referencia'])) ? 'disabled': ''; ?>>
		          
				<?php 
					$opciones_select = array(
											'0'			=>	'No Aplica',
											'No Precio'	=>	'No Precio',
											'No Marca'	=>	'No Marca',
											'No ATC'	=>	'No ATC',
											'NO FF'	=>	'NO FF',
											'NO Concentración'	=>	'NO Concentración',
											'Pagina Caida'	=>	'Pagina Caída',
					); ?>

					<?php foreach ($opciones_select as $key => $value): ?>
						
							<?php if ($key == $dta_reff[0]['casual_no_precio']): ?>
								<option value="<?php echo $key; ?>" selected> <?php echo $value; ?> </option>
							<?php else: ?>
								<option value="<?php echo $key; ?>"> <?php echo $value; ?> </option>
							<?php endif ?>
		          		
		          	<?php endforeach ?>

		        </select>
			</div>
			<div class="form-group">
				<label for="descripcion">Link</label>
				<input class="form-control" type="text" name="link" value="<?php echo $dta_reff[0]['link']; ?>">
				<input class="form-control" type="hidden" name="estado" value="Guardado">
				<input class="form-control" type="hidden" name="id_reff" value="<?php echo $dta_reff[0]['id']; ?>">
			</div>
			<div class="form-group">
				<label for="exampleInputFile">Archivo (opcional)</label>
				<input type="file" name="userfile" size="20" />
				<p class="help-block">Recuerde que no puede pesar mas de 5mg(megas).
				</p>
			</div>
			<div class="form-group">
				<label for="comentario">Comentario</label>
				<textarea class="form-control" name="comentario" value="" id="comentario" maxlength="650"><?php echo $dta_reff[0]['comentario']; ?></textarea>
			</div>
			<?php echo form_submit('btnSubmit', 'Guardar', "id='loading-btn' class='btn btn-primary' data-loading-text='Guardando...'") ?>
			<?php echo form_close() ?>
		</div>
		<div class="col-md-12">
			<a class="btn btn-default pull-left" href="/medicamentos/asignados/<?php echo (isset($arrowsleft[0]['id'])) ? $arrowsleft[0]['id'] : ''; ?>">
				<i class="glyphicon glyphicon-backward"></i> Anterior
			</a>
			<a class="btn btn-default pull-right" href="/medicamentos/asignados/<?php echo (isset($arrowsright[0]['id'])) ? $arrowsright[0]['id'] : ''; ?>">
				<i class="glyphicon glyphicon-forward"></i> Saltar
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(".precio-casual").on('change', function(){
		if ($(this).val() == 0) {
			$('.block-precio').removeAttr('disabled', true);
		}else{
			$('.block-precio').attr('disabled', true);
		}
	});
	$(".block-precio").on('keyup', function(){
		if ($(".precio_referencia").val().length == 0 && $(".cantidad").val().length == 0) {
			$('.precio-casual').removeAttr('disabled', true);
		}else{
			$('.precio-casual').attr('disabled', true);
		}
	});
	// lot ajax
	// autoguardado
	// value: autoguardado
</script>
<?php if($this->session->flashdata('message')): echo $this->session->flashdata('message'); endif;?>
<br>
<a href="/variables/agregar_pais" class="btn btn-default">Agregar un nuevo Pais</a>

<table class="table">
  <thead>
	  <tr>	
	  	<th>Nombre</th>
	  	<th>Moneda</th>
	  	<th>Fuentes</th>
	  	<th>Tipo precio</th>
	  </tr>
  </thead>
  <tbody>
  	<?php foreach ($paisfuente as $key => $value): ?>
		<tr>
			<td><?php echo $value['nombre_pais']; ?></td>
			<td><?php echo $value['moneda']; ?></td>
			<td><?php echo $value['nombre_fuente']; ?></td>
			<td><?php echo $value['tipo_precio']; ?></td>
		</tr>
  	<?php endforeach ?>
  </tbody>
</table>
<table id="t_asignados" class="table">
	<thead>
		<tr>
			<th>Pais</th>
			<th>Fuente</th>
			<th>Nombre Medicamento</th>
			<th>Estado</th>
		</tr>
	</thead>
	<tfoot>
        <tr>
            <th>Pais</th>
			<th>Fuente</th>
			<th>Nombre Medicamento</th>
        </tr>
    </tfoot>
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

<script type="text/javascript">
	$(document).ready(function() {
    	$('#t_asignados').DataTable({
    		initComplete: function () {
	            var api = this.api();
	 
	            api.columns().indexes().flatten().each( function ( i ) {
	                var column = api.column( i );
	                var select = $('<select><option value=""></option></select>')
	                    .appendTo( $(column.footer()).empty() )
	                    .on( 'change', function () {
	                        var val = $(this).val();
	 
	                        column
	                            .search( val ? '^'+val+'$' : '', true, false )
	                            .draw();
	                    } );
	 
	                column.data().unique().sort().each( function ( d, j ) {
	                    select.append( '<option value="'+d+'">'+d+'</option>' )
	                } );
	            } );
	        }

    	});
	});
</script>

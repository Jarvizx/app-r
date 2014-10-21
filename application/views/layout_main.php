<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
	<link rel="stylesheet" type="text/css" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.js"></script>
	<script type="text/javascript" src="http://www.piamed.org/p/assets/grocery_crud/themes/twitter-bootstrap/js/jquery.form.js"></script>
	<script type="text/javascript" src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container-fluid">
	<div class="row">
		<div class="col-md-12">
			
			<h1 class="page-header">
				App R
				<small> version alpha 0.2</small>
			</h1>
		</div>
		
		<div class="col-md-2">	
				
			<?php if (isset($this->user)): ?>
				<p>Hola <?php echo $this->user->first_name; ?>,</p>
			<?php endif ?>
			<ul class="nav nav-pills nav-stacked" style="">

				<li>
					<a href="/">Inicio</a>
				</li>
				<?php // donde 1 es admin y 2 es cordinador
						if(reset($this->ion_auth->get_users_groups($this->user->id)->result())->id == 1
					  	|| reset($this->ion_auth->get_users_groups($this->user->id)->result())->id == 2): ?>
				<li>
					<a href="/variables">Variables del Sistema</a>
				</li>
				<li>
					<a href="/medicamentos/agregar">Ingresar Medicamentos</a>
				</li>
				<li>
					<a href="/medicamentos/asignar">Asignar Datos</a>
				</li>
				<li>
					<a href="/medicamentos/consolidado">Consolidado</a>
				</li>
				<li>
					<a href="/auth">Usuarios</a>
				</li>
				<?php endif ?>
				<li>
					<a href="/medicamentos/asignados">Datos Asignados *</a>
				</li>
				<li>
					<a href="/auth/logout">Cerrar</a>
				</li>

			</ul>
		</div>
		<div class="col-md-10">
			<!--content dinamic-->
			<?php echo $content_for_layout; ?>
		</div>
	</div><!-- close row -->
</div><!-- close <div class="container-fluid"> -->

</body>
</html>
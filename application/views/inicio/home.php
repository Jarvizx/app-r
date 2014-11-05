<?php if($this->session->flashdata('message')): echo $this->session->flashdata('message'); endif;?>

<?php // donde 1 es admin y 2 es cordinador
	if(reset($this->ion_auth->get_users_groups($this->user->id)->result())->id == 1
  	|| reset($this->ion_auth->get_users_groups($this->user->id)->result())->id == 2): ?>
	
	<h1 class="page-header">Indicadores</h1>
	<?php $this->load->view('indicadores', $indicadores); ?>

<?php else:?>	
	<h1 class="page-header">Indicadores</h1>
	<?php $this->load->view('indicadores_usr', $indicadores); ?>
<?php endif?>
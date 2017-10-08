<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'views/header.php';
?>

<div class="panel panel-default panel-login-geral">
  <div class="panel-heading">
    <h3 class="panel-title panel-title-geral">Login</h3>
  </div>
  <div class="panel-body">
  		<form action="<?php echo base_url(); ?>welcome/login" method="POST">
	  		<div class="form-group">
		    	<input type="text" name='login' class="form-control" placeholder="Login">
		   	</div>
		   	<div class="form-group">
		    	<input type="password" name='senha' class="form-control" placeholder="Senha">
		   	</div>

		   	<div class="btn-group btn-group-geral">
		    	<button type="submit" class="btn btn-default">Entrar</button>
		   	</div>
		   	<div class="btn-group btn-group-geral-right">
		    	<a href="welcome/novo"><span class='glyphicon glyphicon-plus'></span>Novo suario</a>
		    </div>
	   	</form>
  </div>
</div>
<div class="panel-login-geral">
	<?php echo validation_errors() ?>
</div>
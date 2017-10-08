<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'views/header.php';
?>

<div class="panel panel-default panel-stp1-geral">
	<div class="panel-heading">
		<h3 class="panel-title panel-title-geral">Novo Usuario</h3>
	</div>
	<form class='form-horizontal' action="<?php echo base_url(); ?>PrimeirosPassos/save_passo1" method="POST">
  		<div class="panel-body">
	  		<div class="row">
		  		<div class="col-sm-10 col-sm-offset-1">
		  			<div class="form-group ">
			    		<input type="text" name='nome' class="form-control" value="<?php echo set_value('nome'); ?>" placeholder="Nome Completo">
			    	</div>
			   	</div>
			</div>
	  		<div class="row">
			   	<div class="col-sm-4 col-sm-offset-1">
			   		<div class="form-group input-group">
						<div class="input-group date" style='float:left'>
						    <input type="text"  name='data_nasc' class="datepicker form-control" value="<?php echo set_value('data_nasc'); ?>" style='margin-top:0px' placeholder="Data de Nascimento">
						    <div class="input-group-addon">
						    	<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
						    </div>
						</div>
				   	</div>
			   	</div>
			   	<div class="col-sm-5 col-sm-offset-1">
			   		<div class="form-group">
						<select name='tipo_usuario' class="form-control">
							<option value="0" disabled>Tipo de Usuario</option>
							<option value="1" <?php echo set_select('tipo_usuario', '1', TRUE); ?>>Admin</option>
							<option value="2" <?php echo set_select('tipo_usuario', '2', TRUE); ?>>Normal</option>
						</select>
					</div>
			    </div>
		   	</div>
			<div class="row">
			   	<div class="col-sm-4 col-sm-offset-1">
			   		<div class="form-group">
			    		<input type="text" name='login' class="form-control" value="<?php echo set_value('login'); ?>" placeholder="Login">
			    	</div>
			   	</div>
			   	<div class="col-sm-5 col-sm-offset-1">
			   		<div class="form-group">
			    		<input type="password" name='senha' class="form-control" value="<?php echo set_value('senha'); ?>" placeholder="Senha">
			    	</div>
			   	</div>
			</div>
		   	<div class="col-sm-11 col-xs-offset-1">
		   		<div class="input-group email">
		        	<span class="input-group-addon">@</span>
		        	<input type="text" class="form-control" name='email' value="<?php echo set_value('email'); ?>" placeholder="Email">
		      	</div>
		   	</div>
  		</div>
	  	<div class="panel-footer panel-footer-geral">
	  		<button type="submit" class="btn btn-default">Proximo<span class='glyphicon glyphicon-chevron-right'></span></button>
	  	</div>
  	</form>
</div>
<div class='panel-stp1-geral'>
	<?php echo validation_errors() ?>
</div>
<script type="text/javascript">
    $('.datepicker').datepicker({
	    format: 'dd-mm-yyyy',
	    startDate: '-3d'
	});
</script>
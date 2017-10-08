<?php
defined('BASEPATH') OR exit('No direct script access allowed');
include_once APPPATH.'views/header.php';
?>

<div class="panel panel-default panel-stp1-geral">
  	<div class="panel-heading">
    	<h3 class="panel-title panel-title-geral">Salario</h3>
  	</div>
	<form action="<?php echo base_url(); ?>PrimeirosPassos/save_passo2" method="POST">
  		<div class="panel-body">
	  		<div class="form-group input-group">
	  			<span class="input-group-addon">$</span>
		    	<input type="text" name='salario_bruto' value="<?php echo set_value('salario_bruto'); ?>" class="form-control" placeholder="Salario Bruto">
		   	</div>
		   	<div class="form-group">
			  <select name='tipo_recebimento' class="form-control" id='flVale2'>
			  	<option value="0" disabled>Tipo de Recebimento</option>
			    <option value="1" <?php echo set_select('tipo_recebimento', '1', TRUE); ?>>Salario</option>
			    <option value="2" <?php echo set_select('tipo_recebimento', '2', TRUE); ?>>Salario e Vale</option>
			  </select>
		   	</div>
		   	<div class="form-group input-group" style="width:100%">
				<div class="input-group date" style='float:left;width:40%'>
				    <input type="text" name="data_salario" value="<?php echo set_value('data_salario'); ?>" class="datepicker form-control" style='margin-top:0px' placeholder="Data Salario">
				    <div class="input-group-addon">
				    	<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
				    </div>
				</div>
				<div class="input-group date" style='float:right;width:44%;display:none' id='dvVale'>
				    <div class="input-group-addon">
				    	<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
				    </div>
				    <input type="text" name="data_vale" value="<?php echo set_value('data_vale'); ?>" class="datepicker form-control" style='margin-top:0px' placeholder="Data Vale">
				</div>
		   	</div>
	   	</div>
	  	<div class="panel-footer panel-footer-geral">
	  		<button type="submit" class="btn btn-default">Cadastrar<span class='glyphicon glyphicon-chevron-right'></span></button>
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
	$('#flVale2').change(function(){
		if($(this).val() == 2)
			$('#dvVale').show();
		else
			$('#dvVale').hide();
	});
	$('#flVale2').change();
</script>
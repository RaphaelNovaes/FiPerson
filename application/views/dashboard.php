<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	include_once APPPATH.'views/header.php';
?>

<div id='container'>
	<div id='add_val'>
		<form action="<?php echo base_url(); ?>dashboard/salvar_valor" method="POST">
			<h4>Adicionar Valor</h4>
			<div class="row">
				<select class='form-control field-add' name='tipo_valor'>
					<option disabled>Tipo Valor</option>
					<option value='1' <?php echo (isset($tipo_valor) && $tipo_valor == 1)?'selected':'' ?>>Entrada</option>
					<option value='2' <?php echo (isset($tipo_valor) && $tipo_valor == 2)?'selected':'' ?>>Saida</option>
				</select>
			</div>
			<div class="row" id='dvSalario'>
				<input type='checkbox' name='flsalario' id='flSalario' <?php echo (isset($flsalario))?'checked':'' ?>>
				<label>Valor sobre o salario</label>
			</div>
			<div class="row" id='dvVale'>
				<input type='checkbox' name='flvale' id='flVale' <?php echo (isset($flvale))?'checked':'' ?>>
				<label>Valor sobre vale</label>
			</div>
			<div class="row" id='dvValor'>
				<input type="text" name='valor' class="form-control field-add" placeholder="Valor" value="<?php echo (isset($valor))?$valor:'' ?>">
			</div>
			<div class="row" style='display:none' id='dvPorcent'>
				<input type="text" name='porcentagem' class="form-control field-add" placeholder="Porcentagem %" value="<?php echo (isset($porcentagem))?$porcentagem:'' ?>">
			</div>
			<div class="row">
				<input type='checkbox' name='flparcela' id='flParcelas' <?php echo (isset($flparcela))?'checked':'' ?>>
				<label>Parcelas Subsequentes</label>
			</div>
			<div class="row" id='dvParcelas'>
				<input type="text" name='parcelas' class="form-control field-add" placeholder="N° Parcelas" value="<?php echo (isset($parcelas))?$parcelas:'' ?>">
			</div>
			<div class="row">
				<div class="input-group date" style='float:left'>
				    <input type="text"  name='data' class="datepicker form-control field-add-data" placeholder="Primeiro Vencimento" value="<?php echo (isset($data))?$data:'' ?>">
				    <div class="input-group-addon div-icon-dt">
				    	<span class="glyphicon glyphicon-th icon-dt" aria-hidden="true"></span>
				    </div>
				</div>
			</div>
			<div class="row">
				<input type="text" name='desc' class="form-control field-add" placeholder="Descrição" value="<?php echo (isset($desc))?$desc:'' ?>">
			</div>
			<div class="row">
		  		<button type="submit" class="btn btn-default field-add-btn">Salvar</button>
		  	</div>
		</form>
		<?php if(validation_errors()) : ?>
		<div class="row error-add">
	  		<?php echo validation_errors() ?>
	  	</div>
	  	<?php endif ?>
	</div>

	<div id='cont-panels'>
		<div class="panels">
			<div class="title-panel">
				Transações
				<form id='FTdata' action="<?php echo base_url(); ?>dashboard" method="POST">
					<input type="text" id='Tdata'  name='Tdata' class="datepickerT form-control field-Tdata" placeholder="Mes/Ano" value="<?php echo (isset($Tdata))?$Tdata:''; ?>">
				</form>
			</div>
			<table class="table-transc" cellspacing="50">
				<tr>
					<td width="10%">Data</td>
					<td width="30%">Descrição</td>
					<td width="20%">Entrada</td>
					<td width="20%">Saida</td>
					<td width="20%">Total</td>
				</tr>
				<tr>
					<td><hr></td>
					<td><hr></td>
					<td><hr></td>
					<td><hr></td>
					<td><hr></td>
				</tr>

				<?php foreach ($dias as $dia) : ?>
					<?php if(isset($entrada[$dia])) : 
							foreach ($entrada[$dia] as $ent) :
								$total += $ent['valor'];
								$color = 'black';
								if($total > 0) $color = 'blue';
								if($total < 0) $color = 'red';
					?>
								<tr>
									<td><?php echo date('d-m-Y', $dia) ?></td>
									<td><?php echo $ent['desc'] ?></td>
									<td style='color:blue'><?php echo $ent['valor'] ?></td>
									<td></td>
									<td style='color:<?php echo $color ?>'><?php echo $total ?></td>
								</tr>
							<?php endforeach ?>
					<?php endif ?>

					<?php if(isset($saida[$dia])) : 
							foreach ($saida[$dia] as $sai) :
								$total -= $sai['valor'];
								$color = 'black';
								if($total > 0) $color = 'blue';
								if($total < 0) $color = 'red';
					?>
								<tr>
									<td><?php echo date('d-m-Y', $dia) ?></td>
									<td><?php echo $sai['desc'] ?></td>
									<td></td>
									<td style='color:red'><?php echo $sai['valor'] ?></td>
									<td style='color:<?php echo $color ?>'><?php echo $total ?></td>
								</tr>
							<?php endforeach ?>
					<?php endif ?>
				<?php endforeach?>
			</table>		
		</div>
	</div>
</div>
<script type="text/javascript">
    $('.datepicker').datepicker({
	    format: 'dd-mm-yyyy',
	    language: "pt-BR"
	});

	$('.datepickerT').datepicker({
        format: 'mm-yyyy',
        language: "pt-BR",
        viewMode: "months", 
    	minViewMode: "months"
	});

	$('#Tdata').on('changeDate',function(ev){
		d = new Date(ev.date);
		m = d.getMonth()+1;
		y = d.getFullYear();

		$(this).val(m+'-'+y);
		
		$('#FTdata').submit();
	});

	$('#flSalario').click(function(){
		if($(this).is(":checked")){
			$('#dvVale').hide();
			$('#dvValor').hide();
			$('#dvPorcent').show();
		}else{
			$('#dvVale').show();
			$('#dvValor').show();
			$('#dvPorcent').hide();
		}
	});

	if($('#flSalario').is(":checked")){
		$('#dvVale').hide();
		$('#dvValor').hide();
		$('#dvPorcent').show();
	}

	$('#flVale').click(function(){
		if($(this).is(":checked")){
			$('#dvSalario').hide();
			$('#dvValor').hide();
			$('#dvPorcent').show();
		}else{
			$('#dvSalario').show();
			$('#dvValor').show();
			$('#dvPorcent').hide();
		}
	});

	if($('#flVale').is(":checked")){
		$('#dvSalario').hide();
		$('#dvValor').hide();
		$('#dvPorcent').show();
	}

	$('#flParcelas').click(function(){
		if($(this).is(":checked")){
			$('#dvParcelas').hide();
		}else{
			$('#dvParcelas').show();
		}
	});

	if($('#flParcelas').is(":checked")){
		$('#dvParcelas').hide();
	}
</script>
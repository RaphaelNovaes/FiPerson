<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>FiPerson - Controle de finanças pessoais</title>
		<!-- INCLUDE CSS -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/bootstrap-3.3.4-dist/css/bootstrap.min.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/datepicker/css/datepicker.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/css/geral.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/css/primeiros_passos.css'); ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('includes/css/dashboard.css'); ?>">

		<!-- INCLUDE JS -->
		<script type="text/javascript" src="<?php echo base_url('includes/jquery-2.1.4.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('includes/bootstrap-3.3.4-dist/js/bootstrap.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('includes/datepicker/js/bootstrap-datepicker.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('includes/js/geral.js'); ?>"></script>
	</head>
	<body>
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <div class="navbar-header" style="width:100%">
		      	<a class="navbar-brand" href="#">FiPerson</a>
				<div class="btn-toolbar" role="toolbar" style="float:right;margin-top:10px">
					<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<span class='glyphicon glyphicon-home'></span>
						</button>
						<ul class="dropdown-menu dropdown-menu-right">
							<li><a href="#">Minhas Configuraçoes</a></li>
							<li><a href="<?php echo base_url(); ?>welcome/logout">Logout</a></li>
					</ul>
					</div> 
				</div>
  				<div style="float:right;margin-top:15px;margin-right:10px"><?php echo $this->session->userdata('nome'); ?></div>
		    </div>
		  </div>
		</nav>
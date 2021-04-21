<!DOCTYPE html>
<html lang="en">
<!--<html xml:lang="ar" lang="ar" dir="" xmlns="http://www.w3.org/1999/xhtml">-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo lang('items'); ?></title>
	<link rel="shortcut icon" href="<?php if(isset($system->logo) && $system->logo != '') echo base_url().'imgs/'.$system->logo; ?>">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Datatables -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

	<!-- bootstrap-progressbar -->
    <link href="<?php echo base_url(); ?>gentelella-master/vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
	
    <!-- Custom Theme Style -->
    <link href="<?php echo base_url(); ?>gentelella-master/build/css/custom.min.css" rel="stylesheet">
	
	<style>
	.multiuserselect {
    //background: #FFF url('down-arrow.png') no-repeat right;
	background: rgba(255, 255, 255, 0);
    appearance:none;
    -webkit-appearance:none; 
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 100%;
    min-height: 550px;
    line-height: 25px;
	}
	.multiuserselect option {		
	float: right;
	//background: rgba(20, 7, 156, 1);
    //background: #2aabd2;
	background: #337ab7;
	color: #FFF;
	text-align: center;
	border-radius: 3px;
	margin: 2px;
	padding: 7px;	
	}
	.multiuserselect option:focus {
	background: red;	
	}

	.multiuserselect1 {
    //background: #FFF url('down-arrow.png') no-repeat right;
	background: rgba(255, 255, 255, 0);
    appearance:none;
    -webkit-appearance:none; 
    -moz-appearance: none;
    text-indent: 0.01px;
    text-overflow: '';
    width: 100%;
    height: 9%;
    line-height: 25px;
	}
	.multiuserselect1 option {		
	float: right;
	//background: rgba(20, 7, 156, 1);
    //background: #2aabd2;
	background: #d9534f;
	color: #FFF;
	text-align: center;
	border-radius: 3px;
	margin: 2px;
	padding: 7px;	
	}
	.multiuserselect1 option:focus {
	background: red;	
	}
	</style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">

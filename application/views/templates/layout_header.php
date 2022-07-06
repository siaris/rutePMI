<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SIMRS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- styles -->
	<link href="<?php echo base_url('assets/css/bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/main.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/DT_bootstrap.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/override.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/select2/select2.css');?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/jquery.slidepanel.css');?>">
	<link href="<?php echo base_url('assets/css/style.css');?>" rel="stylesheet">
	<link href="<?php echo base_url('assets/css/jquery.sliding_menu.css');?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?=site_url('assets/css/form.css');?>">

	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.7.2.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.printElement.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.dataTables.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/DT_bootstrap.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.jeditable.mini.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/table-responsive.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootbox.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/select2/select2.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/main.js');?>"></script>
	<script type="text/javascript" src="<?php //echo base_url('assets/js/enter-tab.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-barcode.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.sliding_menu.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/js_excel/jquery.battatech.excelexport.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.alphanumeric.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.alphanumeric.pack.js');?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js');?>"></script>
	
	<?php if(isset($layout_header)) echo $layout_header; 
	?>

</head>
<body style="background-color:#AECDEE">
	<div id="menu" style="display:none; font-size:12px;">
		<?php $this->load->view('side_menu'); ?>
	</div>
	<header class="navbar">
		<div class="container-fluid expanded-panel">
			<div class="row">
				<div id="logo" class="col-xs-12 col-sm-2">
					<img src="<?php echo site_url(); ?>assets/img/logo_d.png" height="47" style="float:left; margin-top:2px;"> <a href="<?php echo site_url(''); ?>">&nbsp;</a>
					<div style="clear:both"></div>
				</div>
				<div id="top-panel" class="col-xs-12 col-sm-10">
					<div class="row">
						<div class="col-xs-8 col-sm-4">
							<a href="<?= site_url('search/search_simrs');?>" class="show-sidebar">
								<i class="icon-search" id="popup_search"></i>
							</a>
							<form id="search" action="<?php echo base_url('pasien/cari/'); ?>" method="post">							
								<input type="text" name="no_rm" id="no_rms" placeholder="search" autocomplete="off"/>
								<input type="hidden" name="general_search" id="general_search" placeholder="search"/>
								<i class="icon-search" style="color:#000000;"></i>
							</form>
						</div>
						<div class="col-xs-4 col-sm-8 top-panel-right">
							<ul class="nav navbar-nav pull-right panel-menu">
								<li class="dropdown">
									<a href="#" class="dropdown-toggle account" data-toggle="dropdown">
										<div class="avatar">
											<img src="<?php echo site_url(); ?>assets/img/user.png" class="img-rounded" alt="avatar" />
										</div>
										<i class="fa fa-angle-down pull-right"></i>
										<div class="user-mini pull-right">
											<span class="welcome">Welcome,</span>
											<span><?= $this->auth->get_user_name();?></span>
										</div>
									</a>
									
									<ul class="dropdown-menu">
										<li>
											<a href="<?php echo site_url('/user/change_password');?>">
												<i class="fa fa-cog"></i>
												<span class="hidden-sm text">Ganti Password</span>
											</a>
										</li>
										<li>
											<a href="<?php echo site_url('notes');?>">
												<i class="fa fa-cog"><span class="badge" style="background-color:#468847; font-size:11px;">6</span></i>
												<span class="hidden-sm text">Tambah Catatan</span>
											</a>
										</li>
										<li>
											<a href="<?php echo site_url('/user/logout'); ?>">
												<i class="fa fa-power-off"></i>
												<span class="hidden-sm text">Logout</span>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
	<div id="main" class="container-fluid" style="background-color:#FFF;" >
		<div class="row">
			<!--Start Content-->
			<div id="content" class="col-xs-12 col-sm-10" style="width:100%; background-color:#AECDEE;">
				<div class="row">
					<div id="breadcrumb" class="col-md-12" style="position:fixed; z-index:90999">
            <!--
                <ol class="breadcrumb">
                <li>
                <a href="#" class="show-sidebar"> <i class="icon-align-justify" id="sliding_menu_js_btn"></i></a>&nbsp;
                <a href="<?php echo site_url(); ?>">Dashboard</a><font color="#FFFFFF"> / </font><a href="<?php echo site_url('bugs'); ?>">bugs</a></li>
                </ol>
            -->
            <?php echo set_breadcrumb(); ?>
        </div>
    </div> 
    <div style="margin-top:30px;"></div>
</div>
<!--End Content-->
</div>
</div>
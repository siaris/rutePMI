<?define('EMRASSET', ASSETURL.'emr');?>
<!doctype html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="aris-emr-template">
		<meta name="author" content="bikinan-aris">
        
		<link rel="stylesheet" href="<?= EMRASSET ?>/admin-lte/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?= ASSETURL; ?>/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?= EMRASSET; ?>/admin-lte/dist/css/AdminLTE.css">
		<link rel="stylesheet" href="<?= EMRASSET; ?>/admin-lte/dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="<?= EMRASSET; ?>/admin-lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
		<link rel="stylesheet" href="<?= EMRASSET; ?>/admin-lte/plugins/iCheck/all.css">
		<link rel="stylesheet" href="<?= ASSETURL; ?>/css/sweetalert.css">
		<link rel="stylesheet" href="<?= ASSETURL; ?>/css/toastr.min.css">
		<link rel="stylesheet" href="<?= EMRASSET; ?>/fancy-box/source/jquery.fancybox.css" media="screen" />
		<link rel="stylesheet" href="<?= EMRASSET; ?>/css/custom.css">
		<?=isset($css)?$css:'';?>
		<?=isset($js)?$js:'';?>
		<script src="<?= EMRASSET; ?>/admin-lte/plugins/jQuery/jquery-2.2.3.min.js"></script>
		<script src="<?= EMRASSET; ?>/admin-lte/plugins/iCheck/icheck.min.js"></script>
		<script src="<?= EMRASSET; ?>/fancy-box/source/jquery.fancybox.js"></script>
	</head>
	<body class="sidebar-mini skin-red fixed web-body">
		<div class="wrapper">
		<header class="main-header">
		<a href="<?= site_url('administrator/dashboard'); ?>" class="logo">
		<span class="logo-mini"><b>A</b>LT</span>
		<span class="logo-lg"><b></b></span>
		</a>
		<nav class="navbar navbar-static-top">

		<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">

			<li class="dropdown user user-menu">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				
				<span class="hidden-xs"></span>
				</a>
				<ul class="dropdown-menu">
				<li class="user-header">
					
				</li>
				
				<li class="user-footer">
					<div class="pull-left">
					<a href="<?= site_url('administrator/user/profile'); ?>" class="btn btn-default btn-flat">Profile</a>
					</div>
					<div class="pull-right">
					<a href="<?= site_url('administrator/auth/logout'); ?>" class="btn btn-default btn-flat">Sign out</a>
					</div>
				</li>
				</ul>
			</li>
			<li>
				<a href="<?= base_url('administrator/setting'); ?>" data-toggle="control-setting"><i class="fa fa-gears"></i></a>
			</li>
			</ul>
		</div>
		</nav>
	</header>
	<div class="content-wrapper">
		<?= $content?>
	</div>
	<footer class="main-footer">
		<div class="pull-right hidden-xs">
		
		</div>
	</footer>
	
	<div class="control-sidebar-bg"></div>
	</div>
		<script src="<?= ASSETURL; ?>/js/sweetalert.min.js"></script>
		<script src="<?= ASSETURL; ?>/js/toastr.min.js"></script>
		<script src="<?= ASSETURL; ?>/js/jquery-ui.js"></script>
		<script src="<?= EMRASSET; ?>/admin-lte/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?= EMRASSET; ?>/admin-lte/plugins/slimScroll/jquery.slimscroll.min.js"></script>
		<script src="<?= EMRASSET; ?>/admin-lte/dist/js/app.min.js"></script>
		<script src="<?= EMRASSET; ?>/admin-lte/dist/js/demo.js"></script>
		
		<?= $js_bottom_scripts?>
	</body>
</html>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
    	<meta charset="utf-8">
	   	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	   	<meta name="description" content="">
	   	<meta name="author" content="">
		<title>RUTE PMI | App</title>
	   <style>
		     @keyframes blink {
		         0% { color: red; }
		         100% { color: black; }
		     }
		     @-webkit-keyframes blink {
		         0% { color: red; }
		         100% { color: black; }
		     }
		     .blink {
		         -webkit-animation: blink 0.5s linear infinite;
		         -moz-animation: blink 0.5s linear infinite;
		         -ms-animation: blink 0.5s linear infinite;
		         -o-animation: blink 0.5s linear infinite;
		         animation: blink 0.5s linear infinite;
		     }
    	</style>
        <?= $start_header?>
        <?=$css?>
    </head>

	<body class="hold-transition skin-blue sidebar-mini">
		<?= $js_top_scripts ?>
		<div class="wrapper">
		<header class="main-header">
		<nav class="navbar navbar-static-top">
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        	<span class="sr-only">Toggle navigation</span>
      	</a>
		  <div class="navbar-custom-menu">
		  <ul class="nav navbar-nav">
		  <li class="dropdown user user-menu">
		  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <span class="hidden-xs">USER</span>
            </a>	
		</li>
		<li>
            <a href="<?= BASEURL.'/user/logout/'?>" ><i class="fa fa-sign-out"></i></a>
          </li>	
		</ul>	  
		 
	</div>
		</nav>
		<?=$pagetop?>
  		</header>

		<!-- Left side column. contains the logo and sidebar -->
		<aside class="main-sidebar" style="min-height: 0%;"><?=$leftpanel?>
		<div class="sidebar-form">
		<div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search..." autocomplete="off">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
		</div>
		<ul class="sidebar-menu" data-widget="tree">
		<li>
          <a href="<?= BASEURL?>">
            <i class="fa fa-home"></i> <span>Dashboard</span>
          </a>
        </li>
		<li>
          <a href="<?= BASEURL?>/news/">
            <i class="fa fa-address-book"></i> <span>News</span>
          </a>
        </li>
		<li>
          <a href="<?= BASEURL?>/labor/">
            <i class="fa fa-address-book"></i> <span>PMI</span>
          </a>
        </li>
		<li>
          <a href="<?= BASEURL?>/lokasi/set_my/">
            <i class="fa fa-map-marker"></i> <span>Lokasi Simulasi Pemulangan</span>
          </a>
        </li>
		</ul>
		</aside>
		
		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper">
			<?=$content?>
		</div>
		<footer class="main-footer">
    <div class="pull-right hidden-xs">
       1.0
    </div>
    <strong> 2022<?= date('Y') == '2022'?'':' - '.date('Y')?> siaris</strong>
  </footer>
		</div>
		<?=$js?>
        <?=$js_bottom_scripts ?>
	</body>
	<script>
		$('.sidebar-toggle').click()
	</script>
</html>
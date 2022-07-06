<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php print $start_header ?>
<style>
	
	html, body{
		margin:0;
		padding:0;
	}
	#header{
		height:38px;
		padding-bottom:8px;
	}
	#nav_bar{
		height:23px;

	}
	#content_all{
		
		width:100%;
	}
	
	#side_rhs{
		/*margin-left:246px;*/
	}
	
		
	#content_footer{
		width:100%;
		/*height:100%;*/
		clear:both;
	}
	
	#footer{
		width:100%
	}

</style>
<?php print $css?>
</head>
<body>
	<div id="fb-root" style="z-index:999"></div>
	<?php print $js_top_scripts ?>
	<div id="content_all">
	    <div id="side_rhs">
			<div id="content">
				<?php print $content?>
            </div>
		</div>
	</div>
<?php print $js_bottom_scripts ?>
</body>
</html>
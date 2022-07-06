<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">
	   <meta name="description" content="">
	   <meta name="author" content="">
        <?php print $start_header?>
        <?=$css?>
		<?='<script src="'. ASSETURL .'js/jquery-1.7.2.min.js"></script>'?>
    </head>
    <body>
		<div id="main" class="container-fluid" style="background-color:#FFF;" >
			<div class="row">
				<!--Start Content-->
				<div id="content" class="col-xs-12 col-sm-10" style="width:100%; margin-bottom:32mm;">
				   <?=$content?>
				</div>
				<!--End Content-->
			</div>
		</div>
        <?=$js_bottom_scripts ?>
    </body>
</html>
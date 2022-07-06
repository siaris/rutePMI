<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8">
	   <meta name="viewport" content="width=device-width, initial-scale=1.0">
	   <meta name="description" content="">
	   <meta name="author" content="">
        <?php print $start_header?>
        <?=$css?>
    </head>
    <body>
        <?php print $js_top_scripts ?>
		<div id="menu" style="display:none; font-size:12px;">
			 <?=$leftpanel?>
		</div>
		<header class="navbar">
			<?=$pagetop?>
		</header>
		<div id="main" class="container-fluid" style="background-color:#FFF;" >
			<div class="row">
				<!--Start Content-->
				<div id="content" class="col-xs-12 col-sm-10" style="width:100%; background-color:#AECDEE; margin-bottom:32mm;">
				<div class="row">
					<div id="breadcrumb" class="col-md-12" style="position:fixed; z-index:90999">
						<?= $nav?>
					</div>
				</div>
				<!-- <div style="margin-top:50px;"></div> -->
				<hr style="height:10pt; visibility:hidden;" />
				   <?=$flashMessage?>
				   <?=$content?>
				</div>
				<!--End Content-->
			</div>
		</div>
		<div style="position:fixed;right:5%;bottom:50%;z-index:90999;" id="float_content"><?php print isset($float_content)?$float_content:''?></div>
        <div class="footer"><?php print $footer?></div>
        <?=$js?>
        <?=$js_bottom_scripts ?>
    </body>
</html>
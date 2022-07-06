<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">
	<?php print $start_header?>
    <?=$css?>
</head>
<body <? //= isset($_REQUEST['preview'])?'':'onload="javascript:window.print()"'?>>
	<?php print $js_top_scripts ?>
	<div id="main" class="container-fluid" style="background-color:#FFF;" >
		<div class="row">
			<!--Start Content-->
			<div id="content" class="col-xs-12 col-sm-10" style="width:100%; margin-bottom:32mm;">
			   <?=$content?>
			</div>
			<!--End Content-->
		</div>
	</div>
	<?=$js?>
    <?=$js_bottom_scripts ?>
</body>
</html>

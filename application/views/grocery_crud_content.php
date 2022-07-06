<meta http-equiv='cache-control' content='no-cache'>
<meta http-equiv='expires' content='0'>
<meta http-equiv='pragma' content='no-cache'>
<section id="content" class="content">
<main class="main">
	<? echo $extra;?>
	<? echo $output; ?>
</main>
</section>
<?if(isset($css_files)){?>
<? foreach($css_files as $file){ ?>
	<link type="text/css" rel="stylesheet" href="<? echo $file; ?>" />
<?}}?>
<?if(isset($js_files)){?>
<? foreach($js_files as $file){ ?>
	<script src="<? echo $file;?>"></script>
<?}}?>

<?php 	
foreach($css_files as $file): ?>
<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

<style type='text/css'>

</style>

<div class="container-fluid">
  
  <div class="row">
    <div class="col-lg-12">
      <div class="widget-container fluid-height clearfix">
        
        <div class="widget-content padded">
          <div>
            <?php echo $output; ?>
          </div>
        </div>


      </div>
    </div>
  </div>
  
</div>

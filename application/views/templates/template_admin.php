<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="NOINDEX, NOFOLLOW"/>
        <meta name="Author" content="Aris"/>
        <meta http-equiv="imagetoolbar" content="no"/>
        <?php print $start_header?>
        <?=$css?>
    </head>
    <body id="page-top" class="index">
        <?php print $js_top_scripts ?>
		<?=$pagetop?>
		<?=$leftpanel?>
		<?=$content?>
		<?=$footer?>
		
		<?/*-----modal-----*/?>
		<div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
			<div class="modal-content">
				<div class="close-modal" data-dismiss="modal">
					<div class="lr">
						<div class="rl">
						</div>
					</div>
				</div>
				<div class="container">
					<div class="row">
						<div class="col-lg-8 col-lg-offset-2">
							<div class="modal-body">
								<!-- Project Details Go Here -->
								<h2>Project Name</h2>
								<p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
								<img class="img-responsive" src="<?= IMGURL?>/portfolio/roundicons-free.png" alt="">
								<p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
								<p>
									<strong>Want these icons in this portfolio item sample?</strong>You can download 60 of them for free, courtesy of <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">RoundIcons.com</a>, or you can purchase the 1500 icon set <a href="https://getdpd.com/cart/hoplink/18076?referrer=bvbo4kax5k8ogc">here</a>.</p>
								<ul class="list-inline">
									<li>Date: July 2014</li>
									<li>Client: Round Icons</li>
									<li>Category: Graphic Design</li>
								</ul>
								<button type="button" class="btn btn-primary" data-dismiss="modal"><i class="fa fa-times"></i> Close Project</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	
        <?=$js?>
        <?=$js_bottom_scripts ?>
    </body>
</html>

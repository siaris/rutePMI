<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>
        <?/*<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="description"  content=""/>
        <meta name="keywords" content=""/>
        <meta name="robots" content="NOINDEX, NOFOLLOW"/>
        <meta name="Author" content="Aris"/>
        <meta http-equiv="imagetoolbar" content="no"/>*/?>
        <?php print $start_header?>
        <?=$css?>
    </head>
    <body>
        <?php print $js_top_scripts ?>
        <?=$pagetop?>
        <?=$breadcrumb?>
        <div class="main pagesize"> <!-- *** mainpage layout *** -->
            <div class="main-wrap">
                <div class="page clear">
                    <div><?=$notification?></div>
                    <div><?= $content?></div>
                </div>
            </div>
        </div>
        <div class="footer"><?php print $footer?></div>
        <?=$js?>
        <?=$js_bottom_scripts ?>
    </body>
</html>

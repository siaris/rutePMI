<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Active template
|--------------------------------------------------------------------------
|
| The $template['active_template'] setting lets you choose which template 
| group to make active.  By default there is only one group (the 
| "default" group).
|
*/
$template['active_template'] = 'template_admin_panel';

/*
|--------------------------------------------------------------------------
| Explaination of template group variables
|--------------------------------------------------------------------------
|
| ['template'] The filename of your master template file in the Views folder.
|   Typically this file will contain a full XHTML skeleton that outputs your
|   full template or region per region. Include the file extension if other
|   than ".php"
| ['regions'] Places within the template where your content may land. 
|   You may also include default markup, wrappers and attributes here 
|   (though not recommended). Region keys must be translatable into variables 
|   (no spaces or dashes, etc)
| ['parser'] The parser class/library to use for the parse_view() method
|   NOTE: See http://codeigniter.com/forums/viewthread/60050/P0/ for a good
|   Smarty Parser that works perfectly with Template
| ['parse_template'] FALSE (default) to treat master template as a View. TRUE
|   to user parser (see above) on the master template
|
| Region information can be extended by setting the following variables:
| ['content'] Must be an array! Use to set default region content
| ['name'] A string to identify the region beyond what it is defined by its key.
| ['wrapper'] An HTML element to wrap the region contents in. (We 
|   recommend doing this in your template file.)
| ['attributes'] Multidimensional array defining HTML attributes of the 
|   wrapper. (We recommend doing this in your template file.)
|
| Example:
| $template['default']['regions'] = array(
|    'header' => array(
|       'content' => array('<h1>Welcome</h1>','<p>Hello World</p>'),
|       'name' => 'Page Header',
|       'wrapper' => '<div>',
|       'attributes' => array('id' => 'header', 'class' => 'clearfix')
|    )
| );
|
*/

/*
|--------------------------------------------------------------------------
| Default Template Configuration (adjust this or create your own)
|--------------------------------------------------------------------------
*/

/*--------------------------------------------------------------------*/

$template['template_admin_panel']['template'] = 'templates/template_admin_1';
$template['template_admin_panel']['regions'] = [
    'start_header',
    'pagetop',
    'leftpanel',
    'left_menu',
    'content',
    'footer',
    'css',
    'js_top_scripts',
    'js',
    'js_bottom_scripts',
	'flashMessage'];
$template['template_admin_panel']['parser'] = 'parser';
$template['template_admin_panel']['parser_method'] = 'parse';
$template['template_admin_panel']['parse_template'] = FALSE;

/**------------------------------------------------------------ */

$template['template_login']['template'] = 'templates/template_login';
$template['template_login']['regions'] = [];
$template['template_login']['parser'] = 'parser';
$template['template_login']['parser_method'] = 'parse';
$template['template_login']['parse_template'] = FALSE;

$config = $template;

/* End of file template.php */
/* Location: ./system/application/config/template.php */
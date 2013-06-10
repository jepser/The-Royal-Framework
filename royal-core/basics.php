<?php 
// This file is part of the The Royal Theme for WordPress
// http://theroyalframework.com
//
// Copyright (c) 2009-2010 Royal Estudios. All rights reserved.
// http://royalestudios.com
//
// Released under the GPL license
// http://www.opensource.org/licenses/gpl-license.php
//
// **********************************************************************
// This program is distributed in the hope that it will be useful, but
// WITHOUT ANY WARRANTY. 
// **********************************************************************

if (__FILE__ == $_SERVER['SCRIPT_FILENAME']) { die(); }

add_theme_support( 'nav-menus' );
add_theme_support( 'post-thumbnails' );

//loading jquery
function royal_jquery_init() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
}
add_action('wp_enqueue_scripts', 'royal_jquery_init');

//adds a favicon
function favicon_link() {
	$favicon = get_field('favicon','option');
	if($favicon) {	
		echo "\n" . '<link rel="shortcut icon" type="image/ico" href="'. $favicon .'" />' . "\n";
	}	
}
add_action('wp_head', 'favicon_link');

//if there is a code in google analytics will by shown in the header
function google_analytics() { 
	$google_code = get_field('google_code','option');
	if ($google_code) {
		$google_acode = "<script type='text/javascript'>\n";
		$google_acode .= $google_code;
		$google_acode .= "\n</script>";
		echo $google_acode;
 	} //google_analytics
}
add_action('wp_enqueue_scripts', 'google_analytics');

// Widgets plugin: intializes the plugin after the widgets above have passed snuff
	if ( !function_exists('register_sidebars') )
		return;

	// Formats the Sandbox widgets, adding readability-improving whitespace
	$p = array(
		'before_widget'  =>   "\n\t\t\t" . '<div id="%1$s" class="widget %2$s">',
		'after_widget'   =>   "\n\t\t\t</div>\n",
		'before_title'   =>   "\n\t\t\t\t". '<h4 class="widget-title">',
		'after_title'    =>   "</h4>\n"
	);

	// Table for how many? Two? This way, please.
	register_sidebars( 2, $p );



// Adds filters for the description/meta content in archives.php
add_filter( 'archive_meta', 'wptexturize' );
add_filter( 'archive_meta', 'convert_smilies' );
add_filter( 'archive_meta', 'convert_chars' );
add_filter( 'archive_meta', 'wpautop' );

?>
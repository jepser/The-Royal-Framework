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
add_custom_background();


//loading jquery
function royal_jquery_init() {
	if (!is_admin()) {
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'royal_jquery_init');

//adds a favicon
function favicon_link() {
    echo '<link rel="shortcut icon" type="image/ico" href="'. get_bloginfo('template_directory') .'/favicon.ico" />' . "\n";
}
add_action('wp_head', 'favicon_link');

//if there is a code in google analytics will by shown in the header
if (get_option('trf-option["google_code"]') ) {
	function google_analytics() { 
	 $google_acode = "<script type='text/javascript'>\n";
	 $google_acode .= get_option('trf-option["google_code"]');
	 $google_acode .= "\n</script>\n";
	 echo $google_acode;
 	} //google_analytics
add_action('wp_head', 'google_analytics');
}

?>
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

//checking if theme has custom options
$royaltheme = TRF_PATH . 'functions/theme-options.php' ;
if(file_exists($royaltheme)) { include_once( TRF_PATH . 'functions/theme-options.php' ); }


function royal_scripts(){
	wp_register_style( 'trf-style', get_bloginfo('stylesheet_directory') . '/royal-core/styles/admin.css');
	wp_enqueue_style('trf-style');
}
//add_action('admin_init', 'royal_tabs_method');
add_action('admin_enqueue_scripts', 'royal_scripts');


add_action('admin_footer','royal_options_page');

function royal_options_page() { // here's the main function that will generate our options page ?>

<div id="royal-credits">
<?php _e('The Royal Framework is an idea from <a href="http://royalestudios.com">Royale Studios</a> made for you. Love it :)<br />For support visit <a href="http://theroyalframework.com">The Official Theme Website</a>. You are using the Version '. TRF_CORE_VERSION . '.' ,'trf') ?>
</div>
<?php } //royal_options_page() 


?>
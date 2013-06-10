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

function results_highlight($sString, $aWords) {
	if (!is_array ($aWords) || empty ($aWords) || !is_string ($sString)) {
		return false;
	}

	$sWords = implode ('|', $aWords);
 	return preg_replace ('@\b('.$sWords.')\b@si', '<strong style="background-color:yellow">$1</strong>', $sString);
}

register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'trf' ),
) );

add_action('wp_head','add_less', 1);	
function add_less(){
	$less = '<link rel="stylesheet/less" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/style.less">';
	$less .= '<script src="' . get_bloginfo('stylesheet_directory') . '/scripts/less-1.3.0.min.js" type="text/javascript"></script>';
	echo $less;
}

//load_theme_textdomain('your theme domain', get_stylesheet_directory() . '/languages');
	
?>
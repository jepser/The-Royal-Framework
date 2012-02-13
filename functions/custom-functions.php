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

//load_theme_textdomain('your theme domain', get_stylesheet_directory() . '/languages');
	
?>
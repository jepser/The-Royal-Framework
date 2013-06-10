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

//adds a 960 grid system short code for clear div [clear /]
function clear_func($atts) {
	$linkout = '<div class="clear"><!--clear--></div>';
	return $linkout;
}
add_shortcode('clear', 'clear_func');

function five03_redirect(){
	$redirect = get_field('five03','option');
    if(!is_user_logged_in() && $redirect ){
        include( get_template_directory() . '/503.php' );
        exit();
    }
}
add_action( 'template_redirect', 'five03_redirect' );

?>
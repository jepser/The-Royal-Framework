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

//loading tabs
if(is_admin()) {
	wp_register_style( 'trf-style', get_bloginfo('stylesheet_directory') . '/royal-core/styles/admin.css');
	
	function royal_scripts(){
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('royal_upload', get_bloginfo('stylesheet_directory') . '/royal-core/js/init.js', array('jquery','media-upload','thickbox'));
	}
	function royal_style() {
		wp_enqueue_style('thickbox');
		wp_enqueue_style('trf-style');
	}
	//add_action('admin_init', 'royal_tabs_method');
	add_action('wp_enqueue_scripts', 'royal_scripts');
	add_action('wp_enqueue_style', 'royal_style');
} //is_admin
 
if (isset($_GET['page']) && $_GET['page'] == page_slug) {
	add_action('admin_print_scripts', 'royal_scripts');
	add_action('admin_print_styles', 'royal_style');
}

function royal_options_admin_menu()
{
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page(__('Theme Options','trf'), __('Theme Options','trf'), 'edit_themes', page_slug, 'royal_options_page');
}

add_action('admin_menu', 'royal_options_admin_menu');


function royal_register_options(){
	register_setting( 'trf_settings', 'display_breadcrumbs' );
	register_setting( 'trf_settings', 'google_code' );
	register_setting( 'trf_settings', 'favicon' );
	register_setting( 'trf_settings', 'm_mode' );
	
	if(function_exists(theme_settings_register)) {
		theme_settings_register();
	}
}

add_action( 'admin_init', 'royal_register_options' );

function royal_options_page() { // here's the main function that will generate our options page ?>
<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
        <h2 class="nav-tab-wrapper">
        	<?php if(isset($_GET['tab'])) { $tab = $_GET['tab'];  } else { $tab = 'framework'; } ?>
        	<a class="nav-tab<?php echo ($tab == 'framework') ? ' nav-tab-active' : ''; ?>" href="<?php echo "?page=" . page_slug . "&tab=framework"; ?>"><?php _e('Framework Options','trf') ?></a>
            <?php if(function_exists('theme_tabs_options')) { theme_tabs_options($tab); }	?>
        </h2>
        <form action="options.php" method="post">
        <?php if ( isset($_REQUEST['settings-updated']) ) { ?>
        <div id="message" class="updated">
        	<p><?php _e('Options updated.'); ?></p>
        </div>
        <?php } ?>
		<?php //do_settings_fields(page_slug, 'trf_settings' ); ?>

        <?php global $pagenow; if ( $pagenow == 'themes.php' && $_GET['page'] == 'theme-options' ){
           if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab'];
           else $tab = 'framework';
           switch ( $tab ){
               case 'framework':
                    royal_framework_tab();
                    break;
               default :
                    if(function_exists('theme_panes_options')) { theme_panes_options($_GET['tab']); }
                    break;
           } //switch 
    	} //if ?>
        <p><input type="submit" name="search" value="<?php _e('Update Options','trf') ?>" class="button-primary" /></p>
        </form>
</div>
        <div class="clear"></div>
<div id="royal-credits">
<?php _e('The Royal Framework is an idea from <a href="http://royalestudios.com">Royale Studios</a> made for you. Love it :)<br />For support visit <a href="http://theroyalframework.com">The Official Theme Website</a>. You are using the Version '. TRF_CORE_VERSION . '.' ,'trf') ?>
</div>
<?php } //royal_options_page() 


?>
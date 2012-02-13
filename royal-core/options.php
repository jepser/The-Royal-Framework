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
	
	function royal_tabs_method() {
		wp_enqueue_script('jquery-ui-tabs'); 
		wp_enqueue_style('trf-style');
	}
	add_action('admin_init', 'royal_tabs_method');
}
function royal_options_admin_menu()
{
	// here's where we add our theme options page link to the dashboard sidebar
	add_theme_page(__('Theme Options','trf'), __('Theme Options','trf'), 'edit_themes', page_slug, 'royal_options_page');
}

add_action('admin_menu', 'royal_options_admin_menu'); 

function royal_options_page() { // here's the main function that will generate our options page ?>
<div class="wrap">
		<div id="icon-themes" class="icon32"><br /></div>
        <h2 class="nav-tab-wrapper">
        	<?php if(isset($_GET['tab'])) { $tab = $_GET['tab'];  } else { $tab = 'framework'; } ?>
        	<a class="nav-tab<?php echo ($tab == 'framework') ? ' nav-tab-active' : ''; ?>" href="<?php echo "?page=" . page_slug . "&tab=framework"; ?>"><?php _e('Framework Options','trf') ?></a>
            <?php if(function_exists('theme_tabs_options')) { theme_tabs_options($tab); }	?>
        </h2>
        <?php if($_REQUEST['saved']) { //setting the message when saving ?>
         <div class="updated settings-error" id="setting-error-settings_updated"> 
            <p><strong><?php _e('Settings saved!','trf'); ?></strong></p>
        </div>
         <?php } ?>
        <div id="royal_tabs">
            <div class="royal-tabs-wrap trf-wrap">
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
             </div><!--royal-tabs-wrap-->
        </div><!--royal_tabs-->
</div>
        <div class="clear"></div>
<div id="royal-credits">
<?php _e('The Royal Framework is an idea from <a href="http://royalestudios.com">Royale Studios</a> made for you. Love it :)<br />For support visit <a href="http://theroyalframework.com">The Official Theme Website</a>. You are using the Version '. TRF_CORE_VERSION . '.' ,'trf') ?>
</div>
<?php } //royal_options_page() ?>
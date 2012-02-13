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

//creating an array for the tabs options
function theme_tabs_options($current = '') {
	
	//here edit the tabs you want
	$tabs_theme = array(array('name' => 'Profile','id' => 'profile')) ;
	
	foreach($tabs_theme as $thetitletab){
		$class = ( $thetitletab['id'] == $current ) ? ' nav-tab-active' : '';
		echo '<a href="?page=' . page_slug . '&tab=' . $thetitletab['id'] .'" class="nav-tab' . $class . '">'.$thetitletab['name'] . '</a>';
	}
}

function theme_panes_options($tabSelected = '') {
	
	function trf_theme_update() {
	// this is where validation would go
		if(check_admin_referer('trfNonce', 'nonce')){
			update_option('trf-option["profile"]', stripslashes($_POST['profile_bio']));
			update_option('trf-option["twitter"]', $_POST['twitter_username']);
			update_option('trf-option["facebook"]', $_POST['fb_profile']);
			update_option('trf-option["youtube"]', $_POST['youtube_username']);
			update_option('trf-option["gplus"]', $_POST['gplus_username']);			
		}
	}
	if ( $_POST['update_profile_options'] == 'true' ) { trf_theme_update(); } ?>
		<form method="POST" action="<?php echo $_SERVER['REQUEST_URI'] . "&saved=true"; ?>">
        <?php wp_nonce_field('trfNonce','nonce'); ?>
		<input type="hidden" name="update_profile_options" value="true" />
<?php
	switch($tabSelected) {
		case 'profile' :
	?>
	<div class="royal-pcontent" id="profile">
        
            <h4><?php _e('About you','trf') ?></h4>
			<table class="form-table">
            	<tr>
                	<th scope="row"><label for="profile_bio"><?php _e('Write here your bio','trf') ?></label></th>
                    <td><textarea cols="50" rows="5" name="profile_bio" id="profile_bio"><?php echo get_option('trf-option["profile"]'); ?></textarea></td>
                </tr>
            </table>
            <h4><?php _e('Socialmedia','trf') ?></h4>
            <table class="form-table">
            	<tr>
                	<th scope="row"><label for="fb_profile"><?php _e('Facebook Profile','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="fb_profile" name="fb_profile" value="<?php echo get_option('trf-option["facebook"]'); ?>" /><span class="description"><?php _e('Type your profile link','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="twitter_username"><?php _e('Twitter Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="twitter_username" name="twitter_username" value="<?php echo get_option('trf-option["twitter"]'); ?>" /><span class="description"><?php _e('Type your @username (without the @)','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="youtube_username"><?php _e('Youtube Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="youtube_username" name="youtube_username" value="<?php echo get_option('trf-option["youtube"]'); ?>" /><span class="description"><?php _e('Type your Youtube username','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="gplus_username"><?php _e('G+ Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="gplus_username" name="gplus_username" value="<?php echo get_option('trf-option["gplus"]'); ?>" /><span class="description"><?php _e('Type your G+ username','trf') ?></span></td>
                </tr>				
            </table>
            </div><!--royal-pcontent-->
 <?php break;
	default :
		_e('No form for your tab...','trf');
		break;
	} ?>
    <p><input type="submit" name="search" value="<?php _e('Update Options','trf') ?>" class="button-primary" /></p>
</form>
<?php
} //theme_panes_options()
?>
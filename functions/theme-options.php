<?php 
// This file is part of the The Royal Theme for WordPress
// http://theroyalframework.com
//
// Copyright (c) 2009-2012 Royal Estudios. All rights reserved.
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
function theme_settings_register(){
	//here just register your options
	register_setting( 'trf_user', 'profile_bio' );
	register_setting( 'trf_user', 'facebook_username' );
	register_setting( 'trf_user', 'twitter_username' );
	register_setting( 'trf_user', 'youtube_username' );
	register_setting( 'trf_user', 'gplus_username' );
}

function theme_panes_options($tabSelected = '') {
	//global $trf_options; $trf_options = get_option('trf-option');
	//if ( $_REQUEST['settings-updated'] == 'true' ) { trf_theme_update(); }
	switch($tabSelected) {
		case 'profile' :
	?>
    <?php settings_fields( 'trf_user' ); ?>
	<div class="royal-pcontent" id="profile">
    	<pre><?php print_r(get_option('trf-option')); ?></pre>
            <h4><?php _e('About you','trf') ?></h4>
			<table class="form-table">
            	<tr>
                	<th scope="row"><label for="profile_bio"><?php _e('Write here your bio','trf') ?></label></th>
                    <td><textarea cols="50" rows="5" name="profile_bio" id="profile_bio"><?php echo get_option('profile_bio'); ?></textarea></td>
                </tr>
            </table>
            <h4><?php _e('Socialmedia','trf') ?></h4>
            <table class="form-table">
            	<tr>
                	<th scope="row"><label for="facebook_username"><?php _e('Facebook Profile','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="facebook_username" name="facebook_username" value="<?php echo get_option('facebook_username'); ?>" /><span class="description"><?php _e('Type your profile ID or slug (http://facebook.com/"YOUR_PROFILE")','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="twitter_username"><?php _e('Twitter Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="twitter_username" name="twitter_username" value="<?php echo get_option('twitter_username'); ?>" /><span class="description"><?php _e('Type your @username (without the @)','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="youtube_username"><?php _e('Youtube Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="youtube_username" name="youtube_username" value="<?php echo get_option('youtube_username'); ?>" /><span class="description"><?php _e('Type your Youtube username','trf') ?></span></td>
                </tr>
                <tr>
                	<th scope="row"><label for="gplus_username"><?php _e('G+ Username','trf') ?></label></th>
                    <td><input type="text" class="regular-text" id="gplus_username" name="gplus_username" value="<?php echo get_option('gplus_username'); ?>" /><span class="description"><?php _e('Type your G+ username','trf') ?></span></td>
                </tr>				
            </table>
            </div><!--royal-pcontent-->
 <?php break;
	default :
		_e('No form for your tab...','trf');
		break;
	} ?>
<?php
} //theme_panes_options()
?>
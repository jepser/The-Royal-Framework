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

function royal_framework_tab() {
?>
		<?php settings_fields( 'trf_settings' ); ?>
        <div class="royal-pcontent" id="framework"> 
        	<h4><?php _e('Navigation','trf'); ?></h4>
            <table class="form-table">
            	<tr>
                	<th scope="row"><?php _e('Breadcrumbs','trf') ?></th>
                    <td><label for="display_breadcrumbs" class="opt">
                    	<input type="checkbox" name="display_breadcrumbs" id="display_breadcrumbs" <?php echo (get_option('display_breadcrumbs')) ? 'checked' : ''; ?> /> <?php _e('Display Breadcrumbs?','trf') ?></label>
                    </td>
                </tr>
                <tr>
	                <th scope="row"><?php _e('Homepage link','trf') ?></th>
                    <td>
                	<label for="show_home" class="opt"><input type="checkbox" name="show_home" id="show_home" <?php echo (get_option('show_home')) ? 'checked' : ''; ?> /> <?php _e('Include homepage link on breadcrumbs','trf') ?></label>
                    </td>
                </tr>
            </table>
			<h4><?php _e('General Options','trf') ?></h4>
            <table class="form-table">
            	<tr>
                	<th scope="row"><?php _e('Google Analytics','trf') ?></th>
                    <td><textarea cols="60" rows="10" name="google_code" id="gcode"><?php echo stripslashes(get_option('google_code')); ?></textarea><br /><span class="description"><?php _e('Paste your Google Analytics code without the &lt;script&gt;&lt;/script&gt; tags','trf') ?></span></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Upload favicon image','trf'); ?></th>
                    <td><label for="upload_image">
                    <input id="upload_image" type="text" size="36" name="favicon" value="<?php echo get_option('favicon'); ?>" />
                    <input id="upload_image_button" class="button" type="button" value="Upload Image" />
                    <br /><small><?php _e('Enter an URL or upload an image for the banner.','trf'); ?></small>
                    </label></td>
                </tr>
                <tr>
                	<th scope="row"><?php _e('Maintenance Mode','trf'); ?></th>
                    <td><label for="m_mode" class="opt">
                    	<input type="checkbox" name="m_mode" id="m_mode" <?php echo (get_option('m_mode')) ? 'checked' : ''; ?> /> <?php _e('Activate maintenance mode','trf') ?><br/><small><?php _e('Is you want to change the look of your landing page, modify 503.php in your theme.'); ?></small></label>
                    
                    </td>
                </tr>
            </table>
        </div><!--royal-pcontent-->
<?php } //royal_framework_tab() ?>
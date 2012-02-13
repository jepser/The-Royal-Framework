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

function trf_update()
{
	// this is where validation would go
	if(check_admin_referer('trfNonce', 'nonce')){
		if ($_POST['display_breadcrumbs'] == 'on'){ $display = 'checked'; } else { $display = ''; }
		update_option('trf-option["display_breadcrumbs"]', $display);
		update_option('trf-option["google_code"]', stripslashes($_POST['google_code']));
	} else { ?>
    <div class="updated settings-error" id="setting-error-settings_updated"> 
        <p><strong><?php _e('No naugthy business please!','trf'); ?></strong></p>
    </div>
	<?php }
}


function royal_framework_tab() {
?>

        <div class="royal-pcontent" id="framework">
        <?php if ( $_POST['update_trf'] == 'true' ) { trf_update(); } ?>
		<form method="post" action="<?php echo $_SERVER['REQUEST_URI'] . "&saved=true"; ?>">
        	<?php wp_nonce_field('trfNonce','nonce'); ?>
        	<input type="hidden" name="update_trf" value="true" />
        
			<h4><?php _e('General Options','trf') ?></h4>
            <table class="form-table">
            	<tr>
                	<th scope="row"><?php _e('Navigation','trf') ?></th>
                    <td><label for="display_breadcrumbs" class="opt">
                    	<input type="checkbox" name="display_breadcrumbs" id="display_breadcrumbs" <?php echo get_option('trf-option["display_breadcrumbs"]'); ?> /><?php _e('Display Breadcrumbs?','trf') ?></label></td>
                </tr>
                <tr>
                	<th scope="row"><?php _e('Google Analytics','trf') ?></th>
                    <td><textarea cols="50" rows="10" name="google_code" id="google_code"><?php echo stripslashes(get_option('trf-option["google_code"]')); ?></textarea><br /><span class="description"><?php _e('Paste your Google Analytics code without the &lt;script&gt;&lt;/script&gt; tags','trf') ?></span></td>
                </tr>
            </table>  
            <p><input type="submit" name="search" value="<?php _e('Update Options','trf') ?>" class="button-primary" /></p>
		</form>
        </div><!--royal-pcontent-->

<?php } //royal_framework_tab() ?>
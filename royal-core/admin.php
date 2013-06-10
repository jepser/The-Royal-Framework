<?php
// This file is part of the The Royal Theme for WordPress
// http://theroyalframework.com
//
// Copyright (c) 2009-2013 Royal Estudios. All rights reserved.
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

function trf_acf_settings( $options )
{
    // activate add-ons
    $options['activation_codes']['repeater'] = 'QJF7-L4IX-UCNP-RF2W';
    $options['activation_codes']['options_page'] = 'OPN8-FA4J-Y2LW-81LS';
 
    
    // set options page structure
    $options['options_page']['title'] = __('Options','trf');
    $options['options_page']['pages'] = apply_filters('trf-option-pages', array('Framework'));
    
        
    return $options;
    
}
add_filter('acf_settings', 'trf_acf_settings');

$default_framework_options = array (
	
	'id' => 'general_options',
	'title' => __('General Options','trf'),
	'fields' => apply_filters('trf-framework-tab-fields', array(
		array (
			'key' => 'go',
			'label' => __('General Options','trf'),
			'name' => '',
			'type' => 'tab',
		),
		array (
			'key' => 'breadcrumbs',
			'label' => __('Breadcrumbs','trf'),
			'name' => 'breadcrumbs',
			'type' => 'true_false',
			'instructions' => __('Display Breadcrumbs?','trf'),
			'required' => '0',
		),
		array (
			'key' => 'google_code',
			'label' => __('Google Analytics','trf'),
			'name' => 'google_code',
			'type' => 'textarea',
			'instructions' =>  __('Paste your Google Analytics code without the &lt;script&gt;&lt;/script&gt; tags','trf'),
			'required' => '0',
		),
		array (
			'save_format' => 'url',
			'library' => 'all',
			'key' => 'favicon',
			'label' => __('Favicon','trf'),
			'name' => 'favicon',
			'type' => 'file',
		),
		array (
			'key' => 'five03',
			'label' => __('In construction landing page','trf'),
			'name' => 'five03',
			'type' => 'true_false',
			'instructions' => __('Want to display 503 template page until you finish your site?','trf'),
			'required' => '0',
		),
		array (
			'key' => 'profile_tab',
			'label' => __('Profile','trf'),
			'name' => '',
			'type' => 'tab',
		),
		array (
			'key' => 'profile',
			'label' => __('About you','trf'),
			'name' => 'profile',
			'type' => 'textarea',
			'instructions' =>  __('Write here your bio','trf'),
			'required' => '0',
		),
		array (
			'key' => 'facebook_username',
			'label' => __('Facebook Profile','trf'),
			'name' => 'facebook_username',
			'type' => 'text',
			'instructions' =>  __('Type your profile ID or slug (http://facebook.com/"YOUR_PROFILE")','trf'),
			'required' => '0',
		),
		array (
			'key' => 'twitter_username',
			'label' => __('Twitter Username','trf'),
			'name' => 'twitter_username',
			'type' => 'text',
			'instructions' =>  __('Type your @username (without the @)','trf'),
			'required' => '0',
		),
	)),
	'location' => array (
		'rules' => array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-framework',
				'order_no' => '0',
			),
		),
		'allorany' => 'all',
	),
	'options' => 
		array (
			'position' => 'normal',
			'layout' => 'no_box',
			'hide_on_screen' => 
			array (
			),
		),
		'menu_order' => 0,
);
register_field_group($default_framework_options);


?>
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


define('TRF_CORE_VERSION', '0.7');
define('page_slug','theme-options');

if (!defined('TRF_PATH')) {
	define('TRF_PATH', trailingslashit(TEMPLATEPATH));
}

load_theme_textdomain('trf', TRF_PATH . 'royal-core/languages');

include_once(TRF_PATH.'royal-core/options.php');
include_once(TRF_PATH.'royal-core/admin.php');
include_once(TRF_PATH.'royal-core/basics.php');
include_once(TRF_PATH.'royal-core/addons.php');
include_once(TRF_PATH.'royal-core/utility.php');
include_once(TRF_PATH.'royal-core/plugins.php');

?>
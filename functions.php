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

//load_theme_textdomain('client', get_template_directory() . '/languages');

define('TRF_PATH', trailingslashit(TEMPLATEPATH));

include_once(TRF_PATH.'royal-core/the-royal.php');
include_once(TRF_PATH.'functions/custom-functions.php');


?>
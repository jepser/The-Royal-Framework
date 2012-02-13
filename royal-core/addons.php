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

//theme with breadcrumbs incluided
function the_breadcrumbs() {
	$checked = get_option('trf-option["display_breadcrumbs"]');
	if($checked){
    $CPtheFullUrl = $_SERVER["REQUEST_URI"];
    $CPurlArray=explode("/",$CPtheFullUrl);
	echo '<div class="breadcrumbs">';
    echo '<a href="'. get_bloginfo('wpurl') .'">'. __('Home','trf') .'</a>';
    while (list($CPj,$CPtext) = each($CPurlArray)) {
        $CPdir='';
        if ($CPj > 1) {
            $CPi=1;
            while ($CPi < $CPj) {
                $CPdir .= '/' . $CPurlArray[$CPi];
                $CPtext = $CPurlArray[$CPi];
                $CPi++;
            }
            if($CPj < count($CPurlArray)-1) echo ' &raquo; <a href="'.$CPdir.'">' . str_replace("-", " ", $CPtext) . '</a>';
        }
    }
    echo wp_title();
	echo '</div>';
	}
}


//get_block('name of the archive I want to load')
function get_block($nombre_bloque){
	$bloque = include(TRF_PATH .'includes/' . $nombre_bloque . '.php');
	return $bloque;
}

//filter for custom excerpts
//get_custom_excerpt(number of characters, ending default '...')
function get_custom_excerpt($excerpt_num, $separator = '...'){
	$default_excerpt = get_the_excerpt();
	$new_default_excerpt = explode(' ', $default_excerpt, $excerpt_num);
	array_pop($new_default_excerpt);
	$new_excerpt = implode(' ', $new_default_excerpt);
	$new_excerpt .= $separator;
	return $new_excerpt;
}
//custom_excerpt(number of characters, with <p></p> wrap? default true, ending default '...')
function custom_excerpt($excerpt_num, $p = true, $separator = '...'){
	$output = get_custom_excerpt($excerpt_num, $separator);
	if($p == true) { $output = '<p>' . $output . '</p>'; };
	echo $output;
}


//function to get just the thumb url of the current post
// get_thumb_url('thumbnail','medium','large','full') any of this sizes
function get_thumb_url($tsize, $tpost = '') {
	if($tpost == '') $tpost = $post->ID;
	$image_id = get_post_thumbnail_id($tpost);  
	$image_url = wp_get_attachment_image_src($image_id,$tsize);  
	$image_url = $image_url[0];
	return $image_url;
}

//regenerates the use of Wordpress builtin image cropping using Tim Thumb
//get_custom_thumb(any of the get_thumb_url size options,width of the image in px, height of the image in px, class (optional))
function get_custom_thumb($tsize,$thumbw = 9999,$thumbh = 9999,$tclass='sthumb'){
	$thumbtitle = get_the_title();
	$thumb_url = get_thumb_url($tsize);
	echo '<img src="' . get_bloginfo('template_url'). '/royal-core/scripts/timthumb.php?src='. $thumb_url .'&h='. $thumbh . '&w='. $thumbw .'&zc=1" alt="'. $thumbtitle .'" class="'. $tclass .'" title="'. $thumbtitle .'" />';
	
}

//get easily the page ID using its slug
function get_page_id($page_name)
{
	global $wpdb;
	$page_name_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_name = '".$page_name."'");
	return $page_name_id;
}

//get the slug of a post default $post->ID
function get_the_slug($cpostid = ''){
	if($cpostid = '') { $cpostid = get_the_id(); }
	$slug = basename(get_permalink($cpostid));
	return $slug;
}

//adding thumbnails to the RSS credits http://digwp.com/2010/06/show-post-thumbnails-in-feeds/
function royal_post_thumbnail_feeds($content) {
	global $post;
	if(has_post_thumbnail($post->ID)) {
		$content = '<div>' . get_the_post_thumbnail($post->ID) . '</div>' . $content;
	}
	return $content;
}
add_filter('the_excerpt_rss', 'royal_post_thumbnail_feeds');
add_filter('the_content_feed', 'royal_post_thumbnail_feeds');

// remove junk from head via http://digwp.com/2010/03/wordpress-functions-php-template-custom-functions/
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'feed_links', 2);
remove_action('wp_head', 'index_rel_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

?>
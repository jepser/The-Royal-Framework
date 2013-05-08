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
function the_breadcrumbs($args = '') {
	$checked = get_option('display_breadcrumbs');
	if($checked){
	global $post, $wp_query;
	
	if( !$home ) $home = _x('Home', 'trf');
	
	$home_link = home_url();
	
	$defaults = array(
		'delimiter'  => ' &rsaquo; ',
		'wrap_before'  => '<div id="breadcrumb">',
		'wrap_after' => '</div>',
		'before'   => '',
		'after'   => '',
		'home'    => null
	);
	$args = wp_parse_args( $args, $defaults  );
	
	extract( $args, EXTR_SKIP );

	$prepend = '';
	
	if(function_exists('woocommerce_get_page_id')) {
		if ( get_option('show_home') == "on" && woocommerce_get_page_id('shop') && get_option('page_on_front') !== woocommerce_get_page_id('shop') )
			$prepend =  $before . '<a href="' . get_permalink( woocommerce_get_page_id('shop') ) . '">' . get_the_title( woocommerce_get_page_id('shop') ) . '</a> ' . $after . $delimiter;
	}
	if ( (!is_home() && !is_front_page() && !(is_post_type_archive() && get_option('page_on_front')== get_page_id('shop'))) || is_paged() ) :
		echo $wrap_before;
		echo $before  . '<a class="home" href="' . $home_link . '">' . $home . '</a> '  . $after . $delimiter ;
		if ( is_category() ) :
			$cat_obj = $wp_query->get_queried_object();
			$this_category = $cat_obj->term_id;
			$this_category = get_category( $this_category );
			if ($this_category->parent != 0) :
				$parent_category = get_category( $this_category->parent );
				echo get_category_parents($parent_category, TRUE, $delimiter );
			endif;
			echo $before . single_cat_title('', false) . $after;
		
		elseif ( is_tax() ) :
			
			echo $prepend;
			$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
		
			$parents = array();
			$parent = $term->parent;
			while ($parent):
				$parents[] = $parent;
				$new_parent = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
				$parent = $new_parent->parent;
			endwhile;
			
			if(!empty($parents)):
				$parents = array_reverse($parents);
				foreach ($parents as $parent):
					$item = get_term_by( 'id', $parent, get_query_var( 'taxonomy' ));
					echo $before .  '<a href="' . get_term_link( $item->slug, $item->taxonomy ) . '">' . $item->name . '</a>' . $after . $delimiter;
				endforeach;
			endif;
		
			$queried_object = $wp_query->get_queried_object();
			echo $before . $queried_object->name . $after;
		
		elseif ( is_tax('product_tag') ) :
		
			$queried_object = $wp_query->get_queried_object();
			echo $prepend . $before . __('Products tagged &ldquo;', 'trf') . $queried_object->name . '&rdquo;' . $after;
		
		elseif ( is_day() ) :
		
			echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
			echo $before . '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $after . $delimiter;
			echo $before . get_the_time('d') . $after;
		
		elseif ( is_month() ) :
		
			echo $before . '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $after . $delimiter;
			echo $before . get_the_time('F') . $after;
		
		elseif ( is_year() ) :
		
			echo $before . get_the_time('Y') . $after;
		
		elseif ( is_post_type_archive('product') && get_option('page_on_front') !== get_page_id('shop') ) :
		
			$_name = get_page_id('shop') ? get_the_title( get_page_id('shop') ) : ucwords(get_option('woocommerce_shop_slug'));
		
			if (is_search()) :
		
				echo $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $delimiter . __('Search results for &ldquo;', 'trf') . get_search_query() . '&rdquo;' . $after;
		
			else :
		
				echo $before . '<a href="' . get_post_type_archive_link('product') . '">' . $_name . '</a>' . $after;
		
			endif;
		
		elseif ( is_single() && !is_attachment() ) :
		
		if ( get_post_type() == 'product' ) :
		
				echo $prepend;
		
				if ($terms = wp_get_object_terms( $post->ID, 'product_cat' )) :
				$term = current($terms);
				$parents = array();
				$parent = $term->parent;
				while ($parent):
					$parents[] = $parent;
					$new_parent = get_term_by( 'id', $parent, 'product_cat');
					$parent = $new_parent->parent;
				endwhile;
				if(!empty($parents)):
					$parents = array_reverse($parents);
					foreach ($parents as $parent):
						$item = get_term_by( 'id', $parent, 'product_cat');
						echo $before . '<a href="' . get_term_link( $item->slug, 'product_cat' ) . '">' . $item->name . '</a>' . $after . $delimiter;
					endforeach;
				endif;
				echo $before . '<a href="' . get_term_link( $term->slug, 'product_cat' ) . '">' . $term->name . '</a>' . $after . $delimiter;
			endif;
		
			echo $before . get_the_title() . $after;
		
		elseif ( get_post_type() != 'post' ) :
			$post_type = get_post_type_object(get_post_type());
			$slug = $post_type->rewrite;
				echo $before . '<a href="' . get_post_type_archive_link(get_post_type()) . '">' . $post_type->labels->singular_name . '</a>' . $after . $delimiter;
			echo $before . get_the_title() . $after;
		else :
		
			$cat = current(get_the_category());
			
			$current_cat_list = get_category_parents($cat, TRUE, $delimiter);
			echo $current_cat_list;
			echo $before . get_the_title() . $after;
		endif;
		
		elseif ( is_404() ) :
		
			echo $before . __('Error 404', 'trf') . $after;
		
		elseif ( !is_single() && !is_page() && get_post_type() != 'post' ) :
		
			$post_type = get_post_type_object(get_post_type());
			if ($post_type) : echo $before . $post_type->labels->singular_name . $after; endif;
		
		elseif ( is_attachment() ) :
		
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			echo get_category_parents($cat, TRUE, '' . $delimiter);
			echo $before . '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>' . $after . $delimiter;
			echo $before . get_the_title() . $after;
		
		elseif ( is_page() && !$post->post_parent ) :
		
			echo $before . get_the_title() . $after;
		
		elseif ( is_page() && $post->post_parent ) :
		
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			foreach ($breadcrumbs as $crumb) :
				echo $crumb . '' . $delimiter;
			endforeach;
			echo $before . get_the_title() . $after;
		
		elseif ( is_search() ) :
		
			echo $before . __('Search results for &ldquo;', 'trf') . get_search_query() . '&rdquo;' . $after;
		
		elseif ( is_tag() ) :
		
				echo $before . __('Posts tagged &ldquo;', 'trf') . single_tag_title('', false) . '&rdquo;' . $after;
		
		elseif ( is_author() ) :
		
			$userdata = get_userdata($author);
			echo $before . __('Author:', 'trf') . ' ' . $userdata->display_name . $after;
		
		endif;
		
		if ( get_query_var('paged') ) :
		
			echo ' (' . __('Page', 'trf') . ' ' . get_query_var('paged') .')';
		
		endif;
		
		echo $wrap_after;
	
	endif;
	}
}


//get_block('name of the archive I want to load')
function get_block($block_name, $args = array()){
	//global $post;
	
	if($args && is_array($args)){
		global $wp_query; 
		$wp_query->set('custom',$args);
	}
	
	//changes from version 0.7
	/*if(is_child_theme()) {
		$block = include(get_stylesheet_directory() .'/includes/' . $block_name . '.php');
	} else {
		$block = include(TRF_PATH .'includes/' . $block_name . '.php');
	}*/
	locate_template('includes/' . $block_name . '.php', true, false);
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
	if($tpost == '') $tpost = get_the_id();
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

function get_facebook_profile($i = 'all'){
	$fp = get_option('facebook_username');
	
	if(!$fp) {
		return false;
	} else {
		$fp_response = wp_remote_get('http://graph.facebook.com/' . $fp);
	
		if($fp_response['response']['message']) { 
		$json_fb = json_decode($fp_response['body']);
			switch($i){
				case 'all' :
					return $json_fb;
					break;
				case 'name':
					return $json_fb->name;
					break;
				case 'first_name':
					return $json_fb->first_name;
					break;
				case 'last_name':
					return $json_fb->last_name;
					break;
				case 'link':
					return $json_fb->link;
					break;
				case 'username':
					return $json_fb->username;
					break;
				case 'gender':
					return $json_fb->gender;
					break;
				case 'id':
					return $json_fb->id;
					break;
				case 'picture':
					return '<img src="https://graph.facebook.com/' . $json_fb->id . '/picture?type=large">';
					break;
				default :
					return $json_fb;
					break;
			}
		} //$fp*/
	}
}

function twitter_profile($url = true){
	$tw = get_option('twitter_username');
	if($tw){
		if($url == true){
			return 'http://twitter.com/#!/' . $tw;
		} else {
			return $tw;
		} // if($url)
	}
}

function youtube_profile(){
	$yt = get_option('youtube_username');
	return $yt;
}

function gplus_profile(){
	$gp = get_option('gplus_username');
	return $gp;
}

$five05 = get_option('m_mode');
if($five05 && !is_user_logged_in()) {
	function five03_redirect(){
		header('HTTP/1.1 503 Service Temporarily Unavailable');
		header('Retry-After: Sat, 8 Oct 2011 18:27:00 GMT');
		//get_template_part('503');
		//exit();
	}
	add_action('init', 'five03_redirect');
}

?>
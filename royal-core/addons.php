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
	$checked = get_field('breadcrumbs','option');
	if($checked){
	global $post, $wp_query;
	
	
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
	
	$home_link = home_url();
	if( !$home ) $home = __('Home', 'trf');
	
	$prepend = '';
	
	
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
		
			if ( get_post_type() != 'post' ) :
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


//get_block('name of the archive I want to load', your args in array)
function get_block($block_name, $args = array()){
	//global $post;
	
	if($args && is_array($args)){
		global $wp_query; 
		$wp_query->set('custom',$args);
	}
	
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
	$fp = get_field('facebook_username','option');
	
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
	$tw = get_field('twitter_username','option');
	if($tw){
		if($url == true){
			return 'http://twitter.com/' . $tw;
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

?>
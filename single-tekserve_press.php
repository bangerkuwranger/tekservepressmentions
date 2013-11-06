<?php
 
/**
 * Template Name: Tekserve Press Mention - Single
 * Description: Used as a page template to contents of an article, with author, publication, original publication date, and link to the original article.  Genesis only for now...
 */
 
//* Customize the post info function to display custom fields
add_action( 'genesis_after_post_title', 'tekserve_press_date_only' );
function tekserve_press_date_only() {
	$post_info = get_the_date();
	echo '<div id="tekserve-press-date">Originially appeared '.$post_info.' </div>';
}

add_action('genesis_after_post_title', 'tekserve_press_author');
function tekserve_press_author() {
	if ( is_single() && genesis_get_custom_field('tekserve_press_author') ) {
		echo '<div id="tekserve-press-author">By: '. genesis_get_custom_field('tekserve_press_author') .'</div>';
	}
}

add_action('genesis_after_post_title', 'tekserve_press_publication');
function tekserve_press_publication() {
	if ( is_single() && genesis_get_custom_field('tekserve_press_publication') ) {
		echo '<div id="tekserve-press-publication">In: <a href="'.genesis_get_custom_field('tekserve_press_url').'">'.genesis_get_custom_field('tekserve_press_publication') .'</a></div>';
	}
}

/** Remove Post Info */
remove_action( 'genesis_after_post_title', 'genesis_post_meta' );
 
genesis();
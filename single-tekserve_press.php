<?php
 
/**
 * Template Name: Tekserve Press Mention - Single
 * Description: Used as a page template to contents of an article, with author, publication, original publication date, and link to the original article.  Genesis only for now...
 */


 
//enqueue style sheet
if ( function_exists( 'tekserve_press_mentions_enqueue' ) ) {

	add_action( 'wp_enqueue_scripts', 'tekserve_press_mentions_enqueue');

}	//end if ( function_exists( 'tekserve_press_mentions_enqueue' ) )



// Customize the post info function to display custom fields
add_action( 'genesis_after_post_title', 'tekserve_press_mentions_date_only' );
function tekserve_press_mentions_date_only() {

	$post_info = get_the_date();
	echo '<div id="tekserve-press-meta"><a href="' . genesis_get_custom_field( 'tekserve_press_url' ). '" target="_blank"><div id="tekserve-press-date">Originally appeared on ' . $post_info . ' </div>';

}	//end tekserve_press_mentions_date_only()


//display the publication after the title
add_action( 'genesis_after_post_title', 'tekserve_press_mentions_publication' );
function tekserve_press_mentions_publication() {

	if ( is_single() && genesis_get_custom_field( 'tekserve_press_publication' ) ) {
	
		echo '<div id="tekserve-press-publication">in <em>' . genesis_get_custom_field( 'tekserve_press_publication' ) . '</em>.  </div>';
	
	}	//end if ( is_single() && genesis_get_custom_field( 'tekserve_press_publication' ) )

}	//end tekserve_press_mentions_publication()



//display the author after the title
add_action( 'genesis_after_post_title', 'tekserve_press_mentions_author' );
function tekserve_press_mentions_author() {

	if ( is_single() && genesis_get_custom_field( 'tekserve_press_author' ) ) {
	
		echo '<div id="tekserve-press-author">By: ' . genesis_get_custom_field( 'tekserve_press_author' ) . '</div></a></div>';
	
	}	//end if ( is_single() && genesis_get_custom_field( 'tekserve_press_author' ) )

}	//end function tekserve_press_mentions_author()



//display featured image before title
add_action( 'genesis_before_post_title', 'tekserve_press_mentions_logo' );
function tekserve_press_mentions_logo() {

	$press_logo = get_the_post_thumbnail( $post_id, 'full' );
	echo $press_logo;

}	//end tekserve_press_mentions_logo()



//Remove Post Info
remove_action( 'genesis_after_post_title', 'genesis_post_meta' );



//Init Genesis rendering
genesis();
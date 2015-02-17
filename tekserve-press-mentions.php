<?php
/**
 * Plugin Name: Tekserve Press Mentions
 * Plugin URI: https://github.com/bangerkuwranger
 * Description: Custom Post Type for Press Mentions; Includes Custom Fields
 * Version: 1.3
 * Author: Chad A. Carino
 * Author URI: http://www.chadacarino.com
 * License: MIT
 */
/*
The MIT License (MIT)
Copyright (c) 2015 Chad A. Carino
 
Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:
 
The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/



//used for conditional enqueing. standard method for all of our plugins.
$tekserve_press_mentions_queue = array();

//include css to format press mention(s) 
function register_tekserve_press_mentions_styles() {

	wp_register_style( 'tekserve_press_mentions_css', plugins_url().'/tekserve-press-mentions/tekserve_press_mentions.css', array(), '1.3' );

}	//end include_tekserve_press_mentions_styles()

add_action( 'wp_enqueue_scripts', 'register_tekserve_press_mentions_styles' );

function tekserve_press_mentions_enqueue() {

	global $tekserve_press_mentions_queue;
	$tekserve_press_mentions_queue['tekserve_press_mentions_css'] = 'css';
	foreach( $tekserve_press_mentions_queue as $item => $type ) {
	
		if( $type == 'css' ) {
		
			wp_enqueue_style( $item );
		
		}	//end if( $type == 'css' )
		
		if( $type == 'js' ) {
		
			wp_enqueue_script( $item );
		
		}	//end if( $type == 'js' )
		
	}	//end foreach( $tekserve_press_mentions_queue as $item => $type )
	
}	//end tekserve_press_mentions_enqueue()



//create custom post type
add_action( 'init', 'create_post_type_tekserve_press_mentions' );
function create_post_type_tekserve_press_mentions() {

	register_post_type( 'tekserve_press',
		array(
			'labels' => array(
				'name' => __( 'Press Mentions' ),
				'singular_name' => __( 'Press Mention' ),
				'add_new' => 'Add New',
            	'add_new_item' => 'Add New Press Mention',
            	'edit' => 'Edit',
            	'edit_item' => 'Edit Press Mention',
            	'new_item' => 'New Press Mention',
            	'view' => 'View',
            	'view_item' => 'View Press Mention',
            	'search_items' => 'Search Press Mentions',
            	'not_found' => 'No Press Mentions found',
            	'not_found_in_trash' => 'No Press Mentions found in Trash',
            	'parent' => 'Parent Press Mentions',
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array( 'slug' => 'press' ),
            'supports' => array( 'title', 'editor', 'comments', 'excerpt', 'thumbnail' ),
		)
	);

}	//end create_post_type_tekserve_press_mentions()



//add the meta box in the post editor
add_action( 'admin_init', 'tekserve_press_mentions_custom_fields' );
function tekserve_press_mentions_custom_fields() {

    add_meta_box( 'tekserve_press_meta_box',
        'Article Details',
        'display_tekserve_press_mentions_meta_box',
        'tekserve_press', 'normal', 'high'
    );

}	//end tekserve_press_mentions_custom_fields()



// Retrieve current details based on press mention ID
function display_tekserve_press_mentions_meta_box( $tekserve_press_mention ) {

    $tekserve_press_publication = esc_html( get_post_meta( $tekserve_press_mention->ID, 'tekserve_press_publication', true ) );
	$tekserve_press_author = esc_html( get_post_meta( $tekserve_press_mention->ID, 'tekserve_press_author', true ) );
	$tekserve_press_url = esc_html( get_post_meta( $tekserve_press_mention->ID, 'tekserve_press_url', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Publication</td>
            <td><input type="text" size="80" name="tekserve_press_publication" value="<?php echo $tekserve_press_publication; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Author</td>
            <td><input type="text" size="80" name="tekserve_press_author" value="<?php echo $tekserve_press_author; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 100%">Link to Original Article</td>
            <td><input type="text" size="80" name="tekserve_press_url" value="<?php echo $tekserve_press_url; ?>" /></td>
        </tr>
    </table>
    <?php

}	//end display_tekserve_press_mentions_meta_box( $tekserve_press_mention )



//add custom field data and save to db
add_action( 'save_post', 'add_tekserve_press_mentions_fields', 10, 2 );
function add_tekserve_press_mentions_fields( $tekserve_press_mention_id, $tekserve_press ) {

    // Check post type for 'tekserve_press'
    if ( $tekserve_press->post_type == 'tekserve_press' ) {
    
        // Store data in post meta table if present in post data
        if ( isset( $_POST['tekserve_press_publication'] ) && $_POST['tekserve_press_publication'] != '' ) {
        
            update_post_meta( $tekserve_press_mention_id, 'tekserve_press_publication', sanitize_text_field( $_REQUEST['tekserve_press_publication'] ) );
        
        }	//end if ( isset( $_POST['tekserve_press_publication'] ) && $_POST['tekserve_press_publication'] != '' )
        if ( isset( $_POST['tekserve_press_author'] ) && $_POST['tekserve_press_author'] != '' ) {
        
            update_post_meta( $tekserve_press_mention_id, 'tekserve_press_author', sanitize_text_field( $_REQUEST['tekserve_press_author'] ) );
        
        }	//end if ( isset( $_POST['tekserve_press_author'] ) && $_POST['tekserve_press_author'] != '' )
        if ( isset( $_POST['tekserve_press_url'] ) && $_POST['tekserve_press_url'] != '' ) {
        
            update_post_meta( $tekserve_press_mention_id, 'tekserve_press_url', sanitize_text_field( $_REQUEST['tekserve_press_url'] ) );
        
        }	//end if ( isset( $_POST['tekserve_press_url'] ) && $_POST['tekserve_press_url'] != '' )
    
    }	//end if ( $tekserve_press->post_type == 'tekserve_press' )

}	//end add_tekserve_press_mentions_fields( $tekserve_press_mention_id, $tekserve_press )



//use custom template when displaying single entry
add_filter( 'template_include', 'include_tekserve_press_mentions_template_function', 1 );
function include_tekserve_press_mentions_template_function( $template_path ) {
	
	// Check post type for 'tekserve_press'
    if ( get_post_type() == 'tekserve_press' ) {
    
        if ( is_single() ) {
        
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-tekserve_press.php' ) ) ) {
            
                $template_path = $theme_file;
            
            }
            else {
            
                $template_path = plugin_dir_path( __FILE__ ) . 'single-tekserve_press.php';
            
            }	//end if ( $theme_file = locate_template( array ( 'single-tekserve_press.php' ) ) )
        
        }	//end if ( is_single() )
    
    }	//end if ( get_post_type() == 'tekserve_press' )
    return $template_path;

}	//end include_tekserve_press_mentions_template_function( $template_path )

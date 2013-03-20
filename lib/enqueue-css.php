<?php
/*********************
Enqueue the proper CSS
if you use vanilla CSS.
*********************/
function required_style()
{	
	// normalize stylesheet
	wp_register_style( 'required-stylesheet', get_template_directory_uri() . '/stylesheets/normalize.css', array(), '' );

	// foundation stylesheet
	wp_register_style( 'required-stylesheet', get_template_directory_uri() . '/stylesheets/foundation.css', array(), '' );	

	// Register the main style under root directory
	wp_register_style( 'required-stylesheet', get_stylesheet_directory_uri() . '/style.css', array(), '', 'all' );

	wp_enqueue_style( 'required-normalize-stylesheet' );
	wp_enqueue_style( 'required-foundation-stylesheet' );
	wp_enqueue_style( 'required-stylesheet' );

}
add_action( 'wp_enqueue_scripts', 'required_css_style' );
?>
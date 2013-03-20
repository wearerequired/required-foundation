<?php
/*********************
Enqueue the proper CSS
if you use Sass.
*********************/
function required_sass_style()
{
	// Register the main style
	wp_register_style( 'required-stylesheet', get_template_directory_uri() . '/stylesheets/style.css', array(), '', 'all' );
	wp_enqueue_style( 'required-stylesheet' );
}
add_action( 'wp_enqueue_scripts', 'required_sass_style' );
?>
<?php
/**
 * Add the scripts we need on the site in the way the should be included
 * See: http://wp.smashingmagazine.com/2011/10/12/developers-guide-conflict-free-javascript-css-wordpress/
 *
 * @package required+ Foundation
 * @since 	required+ Foundation 0.1.0
 */

/**
 * Register javascript and stylesheets
 * @since  required+ Foundation 0.1.0
 * @return void
 */
function required_load_scripts() {

	// register required-foundation.min.js
	wp_register_script(
        'foundation-js', //handle
        get_template_directory_uri() . '/javascripts/required-foundation.min.js', //source
        array('jquery'), //dependencies
        FOUNDATION_VERSION, //version
	    true //run in footer
    );

	//app.js – depending on foundation.js
	wp_register_script(
        'app-js',
        get_template_directory_uri() . '/javascripts/app.js',
        array( 'foundation-js' ),
        FOUNDATION_VERSION,
        true
	);

    // offcanvas.js - depending on foundation.js
    wp_register_script(
        'offcanvas-js',
        get_template_directory_uri() . '/javascripts/jquery.offcanvas.js',
        array( 'foundation-js' ),
        FOUNDATION_VERSION,
        true
    );

    //theme.js – depending on foundation.js
    wp_register_script(
        'theme-js',
        get_template_directory_uri() . '/javascripts/theme.js',
        array( 'foundation-js', 'app-js' ),
        required_get_theme_version(),
        true
	);

    // The stylesheets
    wp_register_style(
        'foundation-css', //handle
        get_template_directory_uri() . '/stylesheets/foundation.min.css',
        null,   // no dependencies
        FOUNDATION_VERSION //version
    );

    wp_register_style(
        'required-foundation-css', //handle
        get_stylesheet_uri(),
        array( 'foundation-css' ),
        required_get_theme_version() //version
    );

    // Off Canvas Styles, only used on certain page templates
    wp_register_style(
        'offcanvas-css',
        get_template_directory_uri() . '/stylesheets/offcanvas.css',
        array( 'foundation-css' ),
        FOUNDATION_VERSION
    );

    // Enable threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    // Offcanvas CSS & JS only loaded on offcanvas template
    if ( is_page_template( 'page-templates/off-canvas-page.php' ) ) {
        wp_enqueue_style( 'offcanvas-css' );
        wp_enqueue_script( 'offcanvas-js' );
    }

    // Load our Javascript
    wp_enqueue_script( 'theme-js' );

    // Load our Stylesheets
    wp_enqueue_style( 'required-foundation-css' );

}
add_action( 'wp_enqueue_scripts', 'required_load_scripts' );
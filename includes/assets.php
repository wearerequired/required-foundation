<?php
/**
 * Add the scripts we need on the site in the way the should be included
 * See: http://wp.smashingmagazine.com/2011/10/12/developers-guide-conflict-free-javascript-css-wordpress/
 *
 * @package required+ Foundation
 * @since 	required+ Foundation 0.1.0
 */

/**
 * Register javascript
 * @since  required+ Foundation 0.1.0
 * @return void
 */
function required_load_scripts() {

    wp_register_script(
        'modernizr-custom', //handle
        get_template_directory_uri() . '/javascripts/vendor/custom.modernizr.js', //source
        null, //dependencies
        FOUNDATION_VERSION, //version
        false
    );

	wp_register_script(
        'foundation', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.js', //source
        array( 'jquery' ), //dependencies
        FOUNDATION_VERSION, //version
	    true //run in footer
    );

	wp_register_script(
        'foundation-alerts', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.alerts.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-clearing', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.clearing.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-cookie', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.cookie.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-dropdown', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.dropdown.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-forms', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.forms.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-joyride', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.joyride.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-magellan', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.magellan.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-orbit', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.orbit.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-placeholder', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.placeholder.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-reveal', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.reveal.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-section', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.section.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-tooltips', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.tooltips.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    wp_register_script(
        'foundation-topbar', //handle
        get_template_directory_uri() . '/javascripts/foundation/foundation.topbar.js', //source
        array('foundation'), //dependencies
        FOUNDATION_VERSION, //version
        true //run in footer
    );

    // offcanvas.js - depending on foundation.js
    wp_register_script(
        'offcanvas',
        get_template_directory_uri() . '/javascripts/jquery.offcanvas.js',
        array( 'foundation' ),
        FOUNDATION_VERSION,
        true
    );

    //theme.js – depending on foundation.js
    wp_register_script(
        'theme',
        get_template_directory_uri() . '/javascripts/theme.js',
        array(
            'foundation',
            'foundation-alerts',
            'foundation-topbar',
            'foundation-tooltips',
            'foundation-section',
            'foundation-reveal',
            'foundation-placeholder',
            'foundation-orbit',
            'foundation-magellan',
            'foundation-joyride',
            'foundation-forms',
            'foundation-dropdown',
            'foundation-cookie',
            'foundation-clearing'
        ),
        required_get_theme_version(),
        true
	);

    // We need the modernizr script in the head
    wp_enqueue_script( 'modernizr-custom' );

    // Enable threaded comments
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    // Offcanvas JS only loaded on offcanvas template
    if ( is_page_template( 'page-templates/off-canvas-page.php' ) ) {
        wp_enqueue_script( 'offcanvas' );
    }

    // Load our Javascript (all foundation scripts and the theme.js)
    wp_enqueue_script( 'theme' );

}
add_action( 'wp_enqueue_scripts', 'required_load_scripts' );

/**
 * Register the stylesheets
 * @since  required+ Foundation 1.1.0
 * @return void
 */
function required_load_styles() {

    wp_register_style(
        'normalize', //handle
        get_template_directory_uri() . '/stylesheets/normalize.css',
        null,
        FOUNDATION_VERSION //version
    );

    wp_register_style(
        'style', //handle
        get_stylesheet_uri(),
        array( 'normalize' ),
        required_get_theme_version() //version
    );

    // Off Canvas Styles, only used on certain page templates
    wp_register_style(
        'offcanvas',
        get_template_directory_uri() . '/stylesheets/offcanvas.css',
        null,
        FOUNDATION_VERSION
    );

    // Offcanvas CSS & JS only loaded on offcanvas template
    if ( is_page_template( 'page-templates/off-canvas-page.php' ) ) {
        wp_enqueue_style( 'offcanvas' );
    }

    // Load our Stylesheets
    wp_enqueue_style( 'style' );

}
add_action( 'wp_enqueue_scripts', 'required_load_styles' );
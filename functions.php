<?php
/**
 * required+ Foundation functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, required_themesetup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'required_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */

// Set the current Foundation version
define( 'FOUNDATION_VERSION', '4.1.2' );

// Define __DIR__
if ( ! defined( '__DIR__' ) ) define( '__DIR__' , dirname( __FILE__ ) );

// Set $content_width;
if ( ! isset( $content_width ) )
	$content_width = 637;

/**
 * Make Foundation work with WordPress
 *
 * required_pagination()
 * required_menu_fallback()
 * required_active_nav_class()
 * required_active_list_pages_class()
 * REQ_Foundation_Walker()
 * required_side_nav()
 * required_filter_post_class()
 */
require_once( 'includes/foundation.php' );

/**
 * Helpers to make things go smooth, most of them are filters or action hooks
 *
 * required_get_theme_version()
 * required_wp_title()
 * required_auto_excerpt_more()
 * required_custom_excerpt_more()
 * required_body_classes()
 * required_shortcode_empty_paragraph_fix()
 */
require_once( 'includes/helpers.php' );

/**
 * Pluggable functions
 *
 * Overwrite these in your child theme to change the output of:
 * required_continue_reading_link()
 * required_single_content_nav()
 * required_comment()
 * required_posted_on()
 * required_archive_title()
 */
require_once( 'includes/pluggable.php' );

/**
 * Loads the Scripts and Styles
 *
 * required_load_scripts()
 * required_load_styles()
 */
require_once( 'includes/assets.php' );

/**
 * TinyMCE stuff
 *
 * Adds the 'styleselect' dropdown to TinyMCE if it's not yet there, allowing editors to use and set editor styles like
 * button, label, panel and much more, right from the editor.
 *
 * REQ_Editor_Styles()
 */
require_once( 'includes/editor.php' );


if ( ! function_exists( 'required_themesetup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override required_themesetup() in a child theme, add your own required_themesetup to your child theme's
 * functions.php file.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To style the visual editor.
 * @uses add_theme_support() To add support for post thumbnails, automatic feed links, and Post Formats.
 * @uses register_nav_menus() To add support for navigation menus.
 *
 * @since required+ Foundation 0.1.0
 */
function required_themesetup() {
	/* Make required+ Foundation available for translation.
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on required+ Foundation, use a find and replace
	 * to change 'required' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( 'requiredfoundation', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in two locations by default.
	add_theme_support('menus');

	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'requiredfoundation' ),
		'secondary' => __( 'Secondary Menu', 'requiredfoundation' )
	) );

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', array( 'link', 'status', 'quote', 'image' ) );

	// Add support for custom backgrounds. (The wp-head-callback is to make sure nothing happens, when we remove the action in the child theme)
	add_theme_support( 'custom-background', array( 'default-color' => 'ffffff', 'wp-head-callback' => '_custom_background_cb' ) );

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

}
endif; // required_setup

add_action( 'after_setup_theme', 'required_themesetup' );

/**
 * Register the widget zones
 *
 * @uses  register_sidebar
 * @return void
 *
 * @since  required+ Foundation 0.1.0
 */
function required_widgets_init() {

	register_sidebar( array(
		'name' => __( 'Main Sidebar', 'requiredfoundation' ),
		'id' => 'sidebar-main',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area One', 'requiredfoundation' ),
		'id' => 'sidebar-footer-1',
		'description' => __( 'An optional widget area for your site footer', 'requiredfoundation' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Two', 'requiredfoundation' ),
		'id' => 'sidebar-footer-2',
		'description' => __( 'An optional widget area for your site footer', 'requiredfoundation' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

	register_sidebar( array(
		'name' => __( 'Footer Area Three', 'requiredfoundation' ),
		'id' => 'sidebar-footer-3',
		'description' => __( 'An optional widget area for your site footer', 'requiredfoundation' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => "</aside>",
		'before_title' => '<h4 class="widget-title">',
		'after_title' => '</h4>',
	) );

}
add_action( 'widgets_init', 'required_widgets_init' );

/**
 * Manage the layout of the footer sidebars, get it? Pretty clever huh?
 * Just kidding ;-)
 *
 * @return string
 * @since required+ Foundation 0.1.0
 **/
function required_footer_sidebar_columns() {

	// default value
	$required_columns = 'large-4 columns';

	// only the first sidebar is active, go full-width
	if (     is_active_sidebar( 'sidebar-footer-1' )
		&& ! is_active_sidebar( 'sidebar-footer-2' )
		&& ! is_active_sidebar( 'sidebar-footer-3') ) {
		$required_columns = 'large-12 columns';
	}
	// the first one is disabled, go half-half
	else if (	! is_active_sidebar( 'sidebar-footer-1' )
			 &&   is_active_sidebar( 'sidebar-footer-2')
			 &&   is_active_sidebar( 'sidebar-footer-3' ) ) {
		$required_columns = 'large-6 columns';
	}
	// the last one is disabled, go eight-four
	else if ( 	! is_active_sidebar( 'sidebar-footer-3' )
			 &&   is_active_sidebar( 'sidebar-footer-2' )
			 &&   is_active_sidebar( 'sidebar-footer-1' ) ) {
		$required_columns = 'large-8 columns';
	}
	// the middle on is disabled, go four-eight
	else if ( 	! is_active_sidebar( 'sidebar-footer-2' )
			&&    is_active_sidebar( 'sidebar-footer-3' )
			&& 	  is_active_sidebar( 'sidebar-footer-1' ) ) {
		$required_columns = 'large-4 columns reverse';
	}

	return $required_columns;
}

/**
 * Add some love to the footer, of course you can replace that:
 * <code>
 * remove_action( 'required_credits', 'required_sample_credits' );
 * </code>
 */
add_action( 'required_credits', 'required_sample_credits' );

function required_sample_credits() {
	_e( '<p>This site runs on the <a href="http://themes.required.ch/" title="required+ Themes">required+ Foundation</a> Theme. Based on the awesome <a href="http://foundation.zurb.com/" title="Rapid prototyping and building library from ZURB.">Foundation</a> Framework by the humble folks at <a href="http://www.zurb.com/" title="Design for people">ZURB</a>.</p>', 'requiredfoundation' );
}
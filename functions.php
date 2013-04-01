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

if ( ! defined( '__DIR__' ) ) define( '__DIR__' , dirname( __FILE__ ) );

define( 'FOUNDATION_VERSION', '4.0.5' ); 	// Version of ZURB Foundation

if ( ! isset( $content_width ) )
	$content_width = 657;

/**
 * Return the current theme version or parent theme version
 *
 * @since  required+ Foundation 0.6.0
 *
 * @param  boolean $parent By default we get the parent theme
 * @return int     Version of the theme
 */
function required_get_theme_version( $parent = true ) {

	// Name of the parent theme forder
	$stylesheet = 'required-foundation';

	if ( ! $parent ) {
		$stylesheet = get_stylesheet();
	}
	// Get the current theme with the new WP_Theme_API
	$current_theme = wp_get_theme( $stylesheet );

	return $current_theme->Version;
}

/**
 * We add our own nice functions to the theme if you want to change let's say req-scripts.php
 * just create your own /includes/req-scripts.php in your child theme and it get's overloaded.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */
require( get_template_directory() . '/includes/req-foundation.php' ); 		// make foundation work in WordPress
require( get_template_directory() . '/includes/req-scripts.php' ); 			// register the scripts we need the correct way
require( get_template_directory() . '/includes/req-shortcodes.php' ); 		// we got wonderful shortcodes for you
require( get_template_directory() . '/includes/req-mce.php' ); 				// using the power of tinyMCE to add more stuff for you to layout
require( get_template_directory() . '/includes/req-plugin-support.php' );	// Support for your beloved plugins

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

/**
 * Tell WordPress to run required_themesetup() when the 'after_setup_theme' hook is run.
 */
add_action( 'after_setup_theme', 'required_themesetup' );

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
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
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

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since required+ Foundation 0.5.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function required_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'requiredfoundation' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'required_wp_title', 10, 2 );


/**
 * Sets the post excerpt length to 40 words.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 */
function required_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'required_excerpt_length' );

if ( ! function_exists( 'required_continue_reading_link' ) ) :
/**
 * Returns a "Continue Reading" link for excerpts
 */
function required_continue_reading_link() {
	return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( '&hellip; Continue reading &rarr;', 'requiredfoundation' ) . '</a>';
}
endif;

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and required_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function required_auto_excerpt_more( $more ) {
	return required_continue_reading_link();
}
add_filter( 'excerpt_more', 'required_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function required_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= required_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'required_custom_excerpt_more' );

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

if ( ! function_exists( 'required_single_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function required_single_content_nav( ) {
	?>
	<nav class="nav-single">
		<h3 class="assistive-text"><?php _e( 'Post navigation', 'requiredfoundation' ); ?></h3>
		<span class="nav-previous"><?php previous_post_link( '%link', '&larr; %title' ); ?></span>
		<span class="nav-next"><?php next_post_link( '%link', '%title &rarr;' ); ?></span>
	</nav><!-- .nav-single -->
	<?php
}
endif; // required_content_nav

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

if ( ! function_exists( 'required_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own required_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since required+ Foundation 0.1.0
 */
function required_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'requiredfoundation' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'requiredfoundation' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment panel">
			<header class="comment-meta">
				<div class="comment-author">
					<?php
						$avatar_size = 48;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '<h6>%1$s on %2$s <span class="says">said:</span></h6>', 'requiredfoundation' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'requiredfoundation' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

				</div><!-- .comment-author -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'requiredfoundation' ); ?></em>
				<?php endif; ?>

			</header>

			<div class="comment-content"><?php comment_text(); ?> <?php edit_comment_link( __( 'Edit', 'requiredfoundation' ), '<span class="edit-link">', '</span>' ); ?></div>

			<div class="comment-reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'requiredfoundation' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}
endif; // ends check for required_comment()

if ( ! function_exists( 'required_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own required_posted_on to override in a child theme
 *
 * @since required+ Foundation 0.3.0
 */
function required_posted_on() {
	printf( __( '<h6>Posted by <span class="author"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span> on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a></h6>', 'requiredfoundation' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'requiredfoundation' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
endif;

/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 *
 * @since required+ Foundation 0.1.0
 */
function required_body_classes( $classes ) {

	if ( ! is_multi_author() ) {
		$classes[] = 'single-author';
	}

	if ( is_singular() && ! is_home() && ! is_page_template( 'fulldwidth-page.php' ) && ! is_page_template( 'left-sidebar-page.php' ) )
		$classes[] = 'singular';

	if ( is_page_template( 'page-templates/off-canvas-page.php' ) ) {
		$classes[] = 'off-canvas';
	}

	return $classes;
}
add_filter( 'body_class', 'required_body_classes' );


if ( ! function_exists( 'required_archive_title' ) ) :
/**
 * Nice archive titles
 *
 * @return string
 * @since required+ Foundation 0.1.0
 **/

remove_filter('term_description','wpautop');

function required_archive_title () {
	if ( is_category() ) {
		$category_description = category_description();
		echo $panelbool = ! empty( $category_description ) ? '<div class="panel clearfix">' : ''; ?>
			<header class="page-header">
				<h3 class="page-title"><?php
					printf( __( 'Category Archives: %s', 'requiredfoundation' ), '<span>' . single_cat_title( '', false ) . '</span>' );
				?></h3>
				<?php
					if ( ! empty( $category_description ) )
						echo apply_filters( 'category_archive_meta', '<p class="category-archive-meta lead">' . $category_description . '</p>' );
				?>
			</header>
		<?php echo $panelbool = ! empty( $category_description ) ? '</div>' : '';
	}

	if ( is_tag() ) {
		$tag_description = tag_description();
		echo $panelbool = ! empty( $tag_description ) ? '<div class="panel clearfix">' : ''; ?>
			<header class="page-header">
				<h3 class="page-title"><?php
						printf( __( 'Tag Archives: %s', 'requiredfoundation' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?></h3>
				<?php
					if ( ! empty( $tag_description ) )
						echo apply_filters( 'tag_archive_meta', '<p class="lead tag-archive-meta">' . $tag_description . '</p>' );
					?>
			</header>
		<?php echo $panelbool = ! empty( $tag_description ) ? '</div>' : '';
	}

	if ( is_author() ) {
		// If a user has filled out their description, show a bio on their entries.
		if ( get_the_author_meta( 'description' ) ) : ?>
		<header class="page-header">
			<div id="author-info" class="panel clearfix">
				<h3 class="page-title author"><?php printf( __( 'Author Archives: %s', 'requiredfoundation' ), '<span><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h3>
				<div id="author-avatar">
					<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'required_author_bio_avatar_size', 72 ) ); ?>
				</div><!-- #author-avatar -->
				<div id="author-description">
					<h4><?php printf( __( 'About %s', 'requiredfoundation' ), get_the_author() ); ?></h4>
					<p class="lead"><?php the_author_meta( 'description' ); ?></p>
				</div><!-- #author-description	-->
			</div><!-- #entry-author-info -->
		<?php else : ?>
		<header class="page-header">
			<h3 class="page-title author"><?php printf( __( 'Author Archives: %s', 'requiredfoundation' ), '<span><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h3>
		</header>
		<?php endif;
	}
	if ( is_archive() && !is_category() && !is_tag() ) { ?>
		<header class="page-header">
			<h3 class="page-title">
				<?php if ( is_day() ) : ?>
					<?php printf( __( 'Daily Archives: %s', 'requiredfoundation' ), '<span>' . get_the_date() . '</span>' ); ?>
				<?php elseif ( is_month() ) : ?>
					<?php printf( __( 'Monthly Archives: %s', 'requiredfoundation' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'requiredfoundation' ) ) . '</span>' ); ?>
				<?php elseif ( is_year() ) : ?>
					<?php printf( __( 'Yearly Archives: %s', 'requiredfoundation' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'requiredfoundation' ) ) . '</span>' ); ?>
				<?php elseif ( ! is_author() && ! is_category() && ! is_tag() ) : ?>
					<?php _e( 'Blog Archives', 'requiredfoundation' ); ?>
				<?php endif; ?>
			</h3>
		</header><?php
	}
	if ( is_search() ) {
		?>
		<header class="page-header">
			<h3 class="page-title"><?php printf( __( 'Search Results for: %s', 'requiredfoundation' ), '<span>' . get_search_query() . '</span>' ); ?></h3>
		</header>
		<?php
	}
}
endif;
?>
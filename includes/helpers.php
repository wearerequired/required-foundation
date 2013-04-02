<?php
/**
 * Helpers
 */

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

/**
 * We have so many nice shortcodes, we need them to be enabled in the regular text widget!
 */
if ( ! is_admin() ) {
    add_filter( 'widget_text', 'do_shortcode', 11 );
}

/**
 * Remove <p> and <br /> in the shortcodes
 *
 * @return string $content
 * @since required+ Foundation 0.1.0
 */
function required_shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    // replace the strings in the $content
    $content = strtr( $content, $array );
    return $content;
}
add_filter( 'the_content', 'required_shortcode_empty_paragraph_fix' );
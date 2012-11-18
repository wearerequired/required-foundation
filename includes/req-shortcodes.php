<?php
/**
 * Improvments for the shortcode handling.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */

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
function req_shortcode_empty_paragraph_fix( $content ) {
    $array = array (
        '<p>[' => '[',
        ']</p>' => ']',
        ']<br />' => ']'
    );
    // replace the strings in the $content
    $content = strtr( $content, $array );
    return $content;
}
add_filter( 'the_content', 'req_shortcode_empty_paragraph_fix' );
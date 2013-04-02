<?php
/**
 * Yipee we offer you a wonderful selection of styles added to your TinyMCE so you can use whatever you like
 *
 * @package required+ Foundation
 * @since   required+ Foundation 0.1.0
 */

/**
 * Add custom styles to the styleselect dropdown
 *
 * @since   required+ Foundation 0.5.0
 *
 * @param  array $settings
 * @return array
 */
class REQ_Editor_Styles {

    /**
     * Constructor
     */
    public function __construct() {

        add_filter( 'tiny_mce_before_init', array( $this, 'style_formats' ) );
        add_filter( 'tiny_mce_before_init', array( $this, 'add_iframe_support' ) );
        add_filter( 'mce_buttons_2', array( $this, 'add_mce_button' ) );
    }

    /**
     * Add iframe support to TinyMCE
     *
     * @since  required+ Foundation 0.1.0
     *
     * @param array $init valid elements
     * @return array
     */
    public function add_iframe_support( $init ) {

        $valid_iframe = 'iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]';
        if ( isset( $init['extended_valid_elements'] ) ) {
            $init['extended_valid_elements'] .= ',' . $valid_iframe;
        } else {
            $init['extended_valid_elements'] = $valid_iframe;
        }
        return $init;
    }

    /**
     * Define custom styles for the dropdown menu
     *
     * @param array $settings Existing custom styles in TinyMCE
     * @return array
     */
    public function style_formats( $settings ) {

        $style_formats = array(
            array(
                'title'    => __( 'Button', 'requiredfoundation' ),
                'selector' => 'a',
                'classes'  => 'button',
                'exact'    => true
            ),
            array(
                'title' => __( 'Lead Paragraph', 'requiredfoundation' ),
                'selector' => 'p',
                'classes' => 'lead'
            ),
            array(
                'title'  => __( 'Label', 'requiredfoundation' ),
                'inline' => 'span',
                'classes'=> 'label'
            ),
            array(
                'title'   => __( 'Panel', 'requiredfoundation' ),
                'block'   => 'div',
                'classes' => 'panel',
                'wrapper' => true
            ),
            array(
                'title'   => __( 'Panel callout', 'requiredfoundation' ),
                'block'   => 'div',
                'classes' => 'panel callout',
                'wrapper' => true
            ),

            array(
                'title'    => __( 'Radius (Panel, Label, Button)', 'requiredfoundation' ),
                'selector' => 'a.button, span.label, div.panel, div.panel.callout',
                'classes'  => 'radius'
            ),

            array(
                'title'    => __( 'Round (Label, Button)', 'requiredfoundation' ),
                'selector' => 'a.button, span.label',
                'classes'  => 'round'
            ),

            array(
                'title'    => __( 'Alert (Label, Button)', 'requiredfoundation' ),
                'selector' => 'a.button, span.label',
                'classes'  => 'alert'
            ),
            array(
                'title'    => __( 'Success (Label, Button)', 'requiredfoundation' ),
                'selector' => 'a.button, span.label',
                'classes'  => 'success'
            ),
            array(
                'title'    => __( 'Secondary (Label, Button)', 'requiredfoundation' ),
                'selector' => 'a.button, span.label',
                'classes'  => 'secondary'
            ),
            array(
                'title'    => __( 'Subheader (Headings)', 'requiredfoundation' ),
                'selector' => 'h1, h2, h3, h4, h5, h6',
                'classes'  => 'subheader'
            ),
            array(
                'title'  => __( 'Keyboard CMD', 'requiredfoundation' ),
                'inline' => 'kbd'
            )
        );

        // Let devs get a chance to remove and change that stuff.
        $settings['style_formats'] = json_encode( apply_filters( 'req_editor_stlye_args', $style_formats ) );

        return $settings;
    }

    /**
     * Add the Styles dropdown to the visual editor
     *
     * @param array $buttons Array of buttons already registered
     * @return array
     */
    public function add_mce_button( $buttons ) {

        // Just in case somebody already uses a plugin for that...
        if ( ! in_array( 'styleselect', $buttons ) )
            $buttons[] = 'styleselect';
            //array_unshift( $buttons, 'styleselect' );

        return $buttons;
    }

}
new REQ_Editor_Styles();
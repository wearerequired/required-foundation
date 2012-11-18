<?php
/**
 * Implements an optional custom header for required+ Foundation.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @since required+ Foundation 0.5.0
 */

/**
 * Sets up the WordPress core custom header arguments and settings.
 *
 * @uses add_theme_support() to register support for 3.4 and up.
 * @uses required_header_style() to style front-end.
 * @uses required_admin_header_style() to style wp-admin form.
 * @uses required_admin_header_image() to add custom markup to wp-admin form.
 *
 * @since required+ Foundation 0.5.0
 */
function required_custom_header_setup() {
    $args = array(
        // Text color and image (empty to use none).
        'default-text-color'     => '6F6F6F',
        'default-image'          => '',

        // Set height and width, with a maximum value for the width.
        'height'                 => apply_filters( 'required_header_image_height', 288 ),
        'width'                  => apply_filters( 'required_header_image_width', 1000 ),
        'max-width'              => 2000,

        // Support flexible height and width.
        'flex-height'            => true,
        'flex-width'             => true,

        // Random image rotation off by default.
        'random-default'         => false,

        // Callbacks for styling the header and the admin preview.
        'wp-head-callback'       => 'required_header_style',
        'admin-head-callback'    => 'required_admin_header_style',
        'admin-preview-callback' => 'required_admin_header_image',
    );

    add_theme_support( 'custom-header', $args );

    // We'll be using post thumbnails for custom header images on posts and pages.
    // We want them to be the size of the header image that we just defined
    // Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
    set_post_thumbnail_size( $args['width'], $args['height'], true );

    // Add required+ Foundation's custom image sizes.
    // Used for large feature (header) images.
    add_image_size( 'large-feature', $args['width'], $args['height'], true );

}
add_action( 'after_setup_theme', 'required_custom_header_setup' );

if ( ! function_exists( 'required_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @since required+ Foundation 0.5.0
 */
function required_header_style() {
    $text_color = get_header_textcolor();

    // If no custom options for text are set, let's bail
    if ( $text_color == get_theme_support( 'custom-header', 'default-text-color' ) )
        return;

    // If we get this far, we have custom styles. Let's do this.
    ?>
    <style type="text/css">
    <?php
        // Has the text been hidden?
        if ( ! display_header_text() ) :
    ?>
        #site-title,
        #site-description,
        .required-header #searchform     {
            position: absolute !important;
            clip: rect(1px 1px 1px 1px); /* IE6, IE7 */
            clip: rect(1px, 1px, 1px, 1px);
        }
    <?php
        // If the user has set a custom color for the text use that
        else :
    ?>
        #site-description {
            color: #<?php echo $text_color; ?> !important;
        }
        #site-title a {
            color: #2BA6CB;
        }
    <?php endif; ?>
    </style>
    <?php
}
endif; // required_header_style

if ( ! function_exists( 'required_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in required_setup().
 *
 * @since required+ Foundation 0.5.0
 */
function required_admin_header_style() {
?>
    <style type="text/css">
    .appearance_page_custom-header #headimg {
        border: none;
    }
    #headimg h1,
    #desc {
        "Helvetica Neue","Helvetica",Helvetica,Arial,sans-serif;
    }
    #headimg h1 {
        margin: 14px 0;
        line-height: 1.1;
    }
    #headimg h1 a {
        font-size: 44px;
        line-height: 36px;
        text-decoration: none;
        color: #2BA6CB !important;
    }
    #desc {
        font-size: 23px;
        line-height: 1.3;
        margin-bottom: 17px;
        font-weight: 300;
    }
    <?php
        // If the user has set a custom color for the text use that
        if ( get_header_textcolor() != get_theme_support( 'custom-header', 'default-text-color' ) ) :
    ?>
        #site-title a,
        #site-description {
            color: #<?php echo get_header_textcolor(); ?>;
        }
    <?php endif; ?>
    #headimg img {
        max-width: <?php echo get_theme_support( 'custom-header', 'max-width' ); ?>px;
        height: auto;
        width: 100%;
    }
    </style>
<?php
}
endif; // required_admin_header_style

if ( ! function_exists( 'required_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_theme_support('custom-header') in required_setup().
 *
 * @since required+ Foundation 0.5.0
 */
function required_admin_header_image() { ?>
    <div id="headimg">
        <?php
        $color = get_header_textcolor();
        $image = get_header_image();
        if ( $color && $color != 'blank' )
            $style = ' style="color:#' . $color . '"';
        else
            $style = ' style="display:none"';
        ?>
        <h1><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
        <div id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
        <?php if ( $image ) : ?>
            <img src="<?php echo esc_url( $image ); ?>" alt="" />
        <?php endif; ?>
    </div>
<?php }
endif; // required_admin_header_image
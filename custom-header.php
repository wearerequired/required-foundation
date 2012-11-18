<?php
/**
 * This is the template part for the header image
 *
 * What it does is simple, yet clever:
 * If you have custom-header support on, it will
 * check if you have a global header image, if you
 * don't but have a featured image big enough on your
 * page or post, it will display that. Else it will
 * display nothing.
 *
 * @since required+ Foundation 0.5.0
 */
?>
                    <!-- START: custom-header.php -->
                    <?php $header_image = get_header_image();

                    // So we have a header image, nice!
                    if ( $header_image ) {
                    ?>
                        <a class="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php
                        // If we have a thumbnail, we go for that.
                        if ( is_singular() && has_post_thumbnail( $post->ID ) ) {
                            // Houston, we have a new header image!
                            echo get_the_post_thumbnail( $post->ID, 'large-feature' );
                        // Let's go with the header image
                        } else {
                        ?>
                            <img src="<?php header_image(); ?>" alt="" />
                        <?php
                        }
                    ?>
                        </a>
                        <hr />
                    <?php
                    // So there was no header image, but we still have a nice thumbnail, right?
                    } else if ( is_singular() && has_post_thumbnail( $post->ID ) ) {
                    ?>
                        <a class="header-image" href="<?php echo esc_url( home_url( '/' ) ); ?>">
                    <?php
                        // Houston, we have a new header image!
                        echo get_the_post_thumbnail( $post->ID, 'large-feature' );
                    ?>
                        </a>
                        <hr />
                    <?php
                    }
                    ?>
                    <!-- END: custom-header.php -->
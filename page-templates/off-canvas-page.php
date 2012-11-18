<?php
/**
 * Template Name: Off Canvas Page Template
 * Description: A Page Template with a subnavigation on the left side
 * @package required+ Foundation
 * @since required+ Foundation 0.5.0
 */

get_header(); ?>


    <div class="row show-for-small sidebar-menu">
        <div class="menu-action">
            <a class='sidebar-button small secondary button' id='sidebarButton' href="#sidebar">
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
     width="18px" height="18px" viewBox="0 0 48 48" enable-background="new 0 0 48 48" xml:space="preserve">
                    <line fill="none" stroke="#000000" stroke-width="8" stroke-miterlimit="10" x1="0" y1="8.907" x2="48" y2="8.907"/>
                    <line fill="none" stroke="#000000" stroke-width="8" stroke-miterlimit="10" x1="0" y1="24.173" x2="48" y2="24.173"/>
                    <line fill="none" stroke="#000000" stroke-width="8" stroke-miterlimit="10" x1="0" y1="39.439" x2="48" y2="39.439"/>
                    <?php _e( 'Menu', 'requiredfoundation' ); ?>
                </svg>
            </a>
        </div>
    </div>

    <!-- Row for main content area -->
    <div id="content" class="row">

        <section id="main" role="main">
            <div class="post-box">

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php get_template_part( 'content', 'page' ); ?>

                    <?php
                        /**
                         * Seriously I never used comments on a page, what for?
                         */
                        //comments_template( '', true );
                    ?>

                <?php endwhile; // end of the loop. ?>

            </div>
        </section><!-- /#main -->

        <section id="sidebar" role="complementary">
            <?php
                if ( function_exists( 'required_side_nav' ) ) {
                    $args = array(
                        'before' => '<ul class="tabs vertical">',
                        'after' => '</ul>',
                    );
                    required_side_nav( $args );
                }
            ?>
        </section><!-- /#sidebar -->

    </div><!-- End Content row -->

<?php get_footer(); ?>
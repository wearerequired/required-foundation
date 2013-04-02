<?php
/**
 * Pluggable Functions
 *
 * This file contains pluggable helpers used throughout required+ Foundation and its child themes. Pluggable functions you
 * can easily overwrite in the child theme and you recognize them being wrapped in something like:
 * <code>if ( ! function_exists( 'required_themesetup' ) ):</code>
 *
 * @link http://codex.wordpress.org/Pluggable_Functions
 *
 * @since required+ Foundation 1.1.0
 */


if ( ! function_exists( 'required_continue_reading_link' ) ) :
/**
 * Returns a "Continue Reading" link for excerpts
 */
function required_continue_reading_link() {

    return ' <a class="read-more" href="'. esc_url( get_permalink() ) . '">' . __( '&hellip; Continue reading &rarr;', 'requiredfoundation' ) . '</a>';
}
endif;

if ( ! function_exists( 'required_single_content_nav' ) ) :
/**
 * Display navigation to next/previous pages when applicable
 */
function required_single_content_nav() {
    ?>
    <nav class="nav-single">
        <h3 class="assistive-text"><?php _e( 'Post navigation', 'requiredfoundation' ); ?></h3>
        <span class="nav-previous"><?php previous_post_link( '%link', '&larr; %title' ); ?></span>
        <span class="nav-next"><?php next_post_link( '%link', '%title &rarr;' ); ?></span>
    </nav><!-- .nav-single -->
    <?php
}
endif; // required_content_nav

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
                </div><!-- #author-description  -->
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
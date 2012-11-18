<?php
/**
 * Entry meta in the footer of posts of all post formats
 *
 * Overwrite entry-meta.php in child theme or use entry-meta-{$post-format}.php
 * to overwrite this for specific content on each post format.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.6.0
 */
?>
            <!-- START: entry-meta.php -->
            <?php $show_sep = false; ?>
            <?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $categories_list = get_the_category_list( __( ', ', 'requiredfoundation' ) );
                if ( $categories_list ):
            ?>
            <span class="cat-links">
                <?php printf( __( '<span class="%1$s">Posted in</span> %2$s', 'requiredfoundation' ), 'entry-utility-prep entry-utility-prep-cat-links', $categories_list );
                $show_sep = true; ?>
            </span>
            <?php endif; // End if categories ?>
            <?php
                /* translators: used between list items, there is a space after the comma */
                $tags_list = get_the_tag_list( '', __( ', ', 'requiredfoundation' ) );
                if ( $tags_list ):
                if ( $show_sep ) : ?>
            <span class="sep"> | </span>
                <?php endif; // End if $show_sep ?>
            <span class="tag-links">
                <?php printf( __( '<span class="%1$s">Tagged</span> %2$s', 'requiredfoundation' ), 'entry-utility-prep entry-utility-prep-tag-links', $tags_list );
                $show_sep = true; ?>
            </span>
            <?php endif; // End if $tags_list ?>
            <?php endif; // End if 'post' == get_post_type() ?>

            <?php if ( comments_open() ) : ?>
            <?php if ( $show_sep ) : ?>
            <span class="sep"> | </span>
            <?php endif; // End if $show_sep ?>
            <span class="comments-link"><?php comments_popup_link( '<span class="leave-reply">' . __( 'Leave a reply', 'requiredfoundation' ) . '</span>', __( '<b>1</b> Reply', 'requiredfoundation' ), __( '<b>%</b> Replies', 'requiredfoundation' ) ); ?></span>
            <?php endif; // End if comments_open() ?>

            <?php if ( is_singular() && get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
            <div id="author-info">
                <div id="author-avatar">
                    <?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'required_author_bio_avatar_size', 68 ) ); ?>
                </div><!-- #author-avatar -->
                <div id="author-description">
                    <h2><?php printf( esc_attr__( 'About %s', 'requiredfoundation' ), get_the_author() ); ?></h2>
                    <?php the_author_meta( 'description' ); ?>
                    <div id="author-link">
                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
                        <?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'requiredfoundation' ), get_the_author() ); ?>
                        </a>
                    </div><!-- #author-link -->
                </div><!-- #author-description -->
            </div><!-- #entry-author-info -->
            <?php endif; ?>
            <!-- END: entry-meta.php -->
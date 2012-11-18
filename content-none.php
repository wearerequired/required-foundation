<?php
/**
 * The template for displaying a "No posts found" message.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.6.0
 */
?>
    <!-- START: content-none.php -->
    <article id="post-0" class="post no-results not-found">
        <header class="entry-header">
            <h1 class="entry-title"><?php _e( 'Nothing Found', 'requiredfoundation' ); ?></h1>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'requiredfoundation' ); ?></p>
            <?php get_search_form(); ?>
        </div><!-- .entry-content -->
    </article><!-- #post-0 -->
    <!-- END: content-none.php -->
<?php
/**
 * The default template for displaying content
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */
?>

	<!-- START: content-quote.php -->
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<div class="entry-meta">
			<?php required_posted_on(); ?>
			<span class="label radius secondary"><a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'requiredfoundation' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php _ex( 'Quote', 'Post format title', 'requiredfoundation' ); ?></a></span>
		</div>
		<div class="entry-content">
			<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'requiredfoundation' ) ); ?>
		</div><!-- .entry-content -->
		<footer class="entry-meta">
			<?php get_template_part('entry-meta', get_post_format() ); ?>
		</footer><!-- #entry-meta -->
	</article><!-- #post -->
	<!-- END: content-quote.php -->
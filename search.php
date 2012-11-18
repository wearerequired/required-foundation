<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */

get_header(); ?>

	<!-- Row for main content area -->
	<div id="content" class="row">

		<div id="main" class="eight columns" role="main">
			<div class="post-box">

			<?php if ( have_posts() ) : ?>

				<?php required_archive_title(); ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						get_template_part( 'content', get_post_format() );
					?>

				<?php endwhile; ?>

			<?php else : ?>
				<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>

			<?php if ( function_exists( 'required_pagination' ) ) {
				required_pagination();
			} ?>

			</div>
		</div>

		<aside id="sidebar" class="four columns" role="complementary">
			<div class="sidebar-box">
				<?php get_sidebar(); ?>
			</div>
		</aside><!-- /#sidebar -->
	</div>
<?php get_footer(); ?>
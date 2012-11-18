<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.2.0
 */

get_header(); ?>

	<!-- Row for main content area -->
	<div id="content" class="row">

		<div id="main" class="twelve columns" role="main">
			<div class="post-box">

				<article id="post-0" class="post error404 not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( '404 &ndash; What have you done? You broke the internet!', 'requiredfoundation' ); ?></h1>
					</header>

					<div class="entry-content">
						<div class="row">
							<div class="twelve columns">
								<div class="panel">
									<p class="lead"><?php _e( 'The page you are looking for is gone. Perhaps searching or one of the links below will get you back on track.', 'requiredfoundation' ); ?></p>
									<?php get_search_form(); ?>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="four columns">
								<?php the_widget( 'WP_Widget_Recent_Posts', array( 'number' => 5 ), array( 'widget_id' => '404', 'before_title' => '<h4 class="widgettitle">','after_title' => '</h4>' ) ); ?>
							</div>
							<div class="four columns">
								<div class="widget">
									<h4 class="widgettitle"><?php _e( 'Most Used Categories', 'requiredfoundation' ); ?></h4>
									<ul>
										<?php wp_list_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 5 ) ); ?>
									</ul>
								</div>
							</div>
							<div class="four columns">
								<?php
									$archive_content = '<p>' . __( 'Try looking in the monthly archives.', 'requiredfoundation' ) . '</p>';
									the_widget( 'WP_Widget_Archives', array('count' => 0 , 'dropdown' => 1 ), array( 'before_title' => '<h4 class="widgettitle">','after_title' => '</h4>'.$archive_content ) );
								?>
								<?php the_widget( 'WP_Widget_Tag_Cloud', array(), array( 'before_title' => '<h4 class="widgettitle">','after_title' => '</h4>' ) ); ?>
							</div>
						</div>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->
			</div>
		</div>
	</div>
<?php get_footer(); ?>
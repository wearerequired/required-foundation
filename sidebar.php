<?php
/**
 * The Sidebar containing the main widget area.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */
?>
        <!-- START: sidebar.php -->
		<div id="secondary" class="widget-area" role="complementary">
			<?php if ( ! dynamic_sidebar( 'sidebar-main' ) ) : ?>

				<?php if ( is_user_logged_in() ) : ?>
                <aside class="widget panel radius">
                    <h3 class="widget-title"><?php _e( 'There are no widgets yet!', 'requiredfoundation' ); ?></h3>
                    <p><?php _e('Please add some real widgets, because otherwise your visitors get nothing but whitespace here.', 'requiredfoundation' ); ?></p>
                    <p><a class="button small radius" href="<?php echo admin_url('widgets.php'); ?>"><?php _e( 'Add widgets', 'requiredfoundation' ); ?></a></p>
                </aside>
                <?php endif; ?>

			<?php endif; // end sidebar widget area ?>
		</div><!-- #secondary .widget-area -->
        <!-- END: sidebar.php -->
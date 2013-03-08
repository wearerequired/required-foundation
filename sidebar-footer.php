<?php
/**
 * The Footer widget areas.
 *
 * @package required+ Foundation
 * @since required+ Foundation 0.1.0
 */
?>

<?php
	/* The footer widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (   ! is_active_sidebar( 'sidebar-footer-1' )
		&& ! is_active_sidebar( 'sidebar-footer-2' )
		&& ! is_active_sidebar( 'sidebar-footer-3' )
	)
		return;
	// If we get this far, we have widgets. Let do this.
?>
<!-- START: sidebar-footer.php -->
<div id="supplementary" class="row">
	<div class="large-12 columns">
		<hr />
	</div>
	<?php if ( is_active_sidebar( 'sidebar-footer-1' ) ) : ?>
	<div id="first" class="widget-area <?php echo required_footer_sidebar_columns(); ?>">
		<?php dynamic_sidebar( 'sidebar-footer-1' ); ?>
	</div><!-- #first .widget-area -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-footer-2' ) ) : ?>
	<div id="second" class="widget-area <?php echo $required_c = (required_footer_sidebar_columns() == 'large-8 columns' ? 'large-4 columns' : required_footer_sidebar_columns()); ?>">
		<?php dynamic_sidebar( 'sidebar-footer-2' ); ?>
	</div><!-- #second .widget-area -->
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'sidebar-footer-3' ) ) : ?>
	<div id="third" class="widget-area <?php echo $required_c = (required_footer_sidebar_columns() == 'large-4 columns reverse' ? 'large-8 columns' : required_footer_sidebar_columns()); ?>">
		<?php dynamic_sidebar( 'sidebar-footer-3' ); ?>
	</div><!-- #third .widget-area -->
	<?php endif; ?>
</div><!-- #supplementary -->
<!-- END: sidebar-footer.php -->
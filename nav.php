<?php
/**
 * Template part for the main navigation
 *
 * Used to display the main navigation with
 * our custom Walker Class to make sure the
 * navigation is rendered the way Foundation
 * does.
 *
 * @since  required+ Foundation 0.1.0
 */
?>
				<!-- START: nav.php -->
				<nav id="access" role="navigation">
					<?php
					    wp_nav_menu( array(
							'theme_location' => 'primary',
							'depth' => 2,
							'items_wrap' => '<ul class="nav-bar">%3$s</ul>',
							'fallback_cb' => 'required_menu_fallback', // workaround to show a message to set up a menu
							'walker' => new REQ_Foundation_Walker()
						) );
					?>
				</nav>
				<!-- END: nav.php -->
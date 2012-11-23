<?php
/**
 * Make the ZURB foundation work with WordPress
 *
 * @package required+ Foundation
 * @since 	required+ Foundation 0.1.0
 */

/**
 * Display the list for paginated links according to ZURB Foundation
 * Code from: http://themefortress.com/reverie/
 *
 * @since  required+ Foundation 0.3.1
 *
 * @return string
 */
function required_pagination() {
	global $wp_query;

	$big = 999999999; // This needs to be an unlikely integer

	// For more options and info view the docs for paginate_links()
	// http://codex.wordpress.org/Function_Reference/paginate_links
	$paginate_links = paginate_links( array(
		'base' => str_replace( $big, '%#%', get_pagenum_link($big) ),
		'current' => max( 1, get_query_var('paged') ),
		'total' => $wp_query->max_num_pages,
		'mid_size' => 5,
		'prev_next' => True,
	    'prev_text' => __('&laquo;'),
	    'next_text' => __('&raquo;'),
		'type' => 'list'
	) );

	// Display the pagination if more than one page is found
	if ( $paginate_links ) {
		echo '<div class="required-pagination">';
		echo $paginate_links;
		echo '</div><!--// end .pagination -->';
	}
}

/**
 * A fallback when no navigation is selected by default, otherwise it throws some nasty errors in your face.
 *
 * @since  required+ Foundation 0.2.0
 *
 * @return string
 */
function required_menu_fallback() {
	echo '<div class="alert-box secondary">';
	// Translators 1: Link to Menus, 2: Link to Customize
  	printf( __( 'Please assign a menu to the primary menu location under %1$s or %2$s the design.', 'requiredfoundation' ),
  		sprintf(  __( '<a href="%s">Menus</a>', 'requiredfoundation' ),
  			get_admin_url( get_current_blog_id(), 'nav-menus.php' )
  		),
  		sprintf(  __( '<a href="%s">Customize</a>', 'requiredfoundation' ),
  			get_admin_url( get_current_blog_id(), 'customize.php' )
  		)
  	);
  	echo '</div>';
}
/**
 * Use the active class of the ZURB Foundation for the current menu item.
 * From: https://github.com/milohuang/reverie/blob/master/functions.php
 *
 * @since  required+ Foundation 0.3.0
 *
 * @param  array 	$classes
 * @param  obj 		$item
 * @return array
 */
function required_active_nav_class( $classes, $item ) {
    if ( $item->current == 1 || $item->current_item_ancestor == true ) {
        $classes[] = 'active';
    }
    return $classes;
}
add_filter( 'nav_menu_css_class', 'required_active_nav_class', 10, 2 );

/**
 * Use the active class of ZURB Foundation on wp_list_pages output.
 * @param  string $input
 * @return string
 *
 * @since required+ Foundation 0.5.0
 */
function required_active_list_pages_class( $input ) {

	$pattern = '/current_page_item/';
    $replace = 'current_page_item active';

    $output = preg_replace( $pattern, $replace, $input );

    return $output;
}
add_filter( 'wp_list_pages', 'required_active_list_pages_class', 10, 2 );

/**
 * class required_walker
 *
 * Custom output to enable the the ZURB Navigation style.
 * Courtesy of Kriesi.at. http://www.kriesi.at/archives/improve-your-wordpress-navigation-menu-output
 *
 * @since  required+ Foundation 0.1.0
 *
 * @return string the code of the full navigation menu
 */
class REQ_Foundation_Walker extends Walker_Nav_Menu {

	/**
	 * Specify the item type to allow different walkers
	 * @var array
	 */
	var $nav_bar = '';

	function __construct( $nav_args = '' ) {

		$defaults = array(
			'item_type' => 'li',
			'in_top_bar' => false,
		);
		$this->nav_bar = apply_filters( 'req_nav_args', wp_parse_args( $nav_args, $defaults ) );
	}

	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

        $id_field = $this->db_fields['id'];
        if ( is_object( $args[0] ) ) {
            $args[0]->has_children = ! empty( $children_elements[$element->$id_field] );
        }
        return parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
    }

	function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {

		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;
		$classes[] = 'menu-item-' . $item->ID;

		// Check for flyout
		$flyout_toggle = '';
		if ( $args->has_children && $this->nav_bar['item_type'] == 'li' ) {

			if ( $depth == 0 && $this->nav_bar['in_top_bar'] == false ) {

				$classes[] = 'has-flyout';
				$flyout_toggle = '<a href="#" class="flyout-toggle"><span></span></a>';

			} else if ( $this->nav_bar['in_top_bar'] == true ) {

				$classes[] = 'has-dropdown';
				$flyout_toggle = '';
			}

		}

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args ) );
		$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

		if ( $depth > 0 ) {
			$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		} else {
			$output .= $indent . ( $this->nav_bar['in_top_bar'] == true ? '<li class="divider"></li>' : '' ) . '<' . $this->nav_bar['item_type'] . ' id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
		}

		$attributes  = ! empty( $item->attr_title ) ? ' title="'  . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target )     ? ' target="' . esc_attr( $item->target     ) .'"' : '';
		$attributes .= ! empty( $item->xfn )        ? ' rel="'    . esc_attr( $item->xfn        ) .'"' : '';
		$attributes .= ! empty( $item->url )        ? ' href="'   . esc_attr( $item->url        ) .'"' : '';

		$item_output  = $args->before;
		$item_output .= '<a '. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '</a>';
		$item_output .= $flyout_toggle; // Add possible flyout toggle
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}

	function end_el( &$output, $item, $depth = 0, $args = array() ) {

		if ( $depth > 0 ) {
			$output .= "</li>\n";
		} else {
			$output .= "</" . $this->nav_bar['item_type'] . ">\n";
		}
	}

	function start_lvl( &$output, $depth = 0, $args = array() ) {

		if ( $depth == 0 && $this->nav_bar['item_type'] == 'li' ) {
			$indent = str_repeat("\t", 1);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"flyout\">\n";
    	} else {
			$indent = str_repeat("\t", $depth);
    		$output .= $this->nav_bar['in_top_bar'] == true ? "\n$indent<ul class=\"dropdown\">\n" : "\n$indent<ul class=\"level-$depth\">\n";
		}
  	}
}

// Yes you can overwrite the whole function
if ( ! function_exists( 'required_side_nav' ) ) :
/**
 * Displays a simple subnav with child pages of the current
 * or page above. See usage in page-templates/left-nav-page.php
 *
 * @param  integer $depth  		Levels of child pages to show, default is 1
 * @param  string  $before 		List to start the nav, you could use something like <ul class="nav-bar vertical">
 * @param  string  $after 		Closing </ul>
 * @param  bool    $show_home	Show a home link? Default: false
 * @param  string  $item_type	Usually an li, if not we use dd for you buddy!
 * @return string  Echo out the whole navigation
 *
 * @since required+ Foundation 0.5.0
 */
function required_side_nav( $nav_args = '' ) {

	global $post;

	$defaults = array(
		'show_home' => false,
		'depth'		=> 1,
		'before'	=> '<ul class="side-nav">',
		'after'		=> '</ul>',
		'item_type' => 'li',
	);

	$nav_args = apply_filters( 'req_side_nav_args', wp_parse_args( $nav_args, $defaults ) );

	$args = array(
		'title_li' 		=> '',
		'depth'			=> $nav_args['depth'],
		'sort_column'	=> 'menu_order',
		'echo'			=> 0,
	);

	// Make sure the dl only shows 1 level
	if ( $nav_args['item_type'] != 'li' ) {
		$args['depth'] = 0;
	}

	if ( $post->post_parent ) {
		// So we have a post parent
    	$args['child_of'] = $post->post_parent;
    } else {
    	// So we don't have a post parent, so you are!
    	$args['child_of'] = $post->ID;
    }

    // Filter the $args if you want to do something different!
    $children = wp_list_pages( $args );

    // Point as back home or not?
    if ( $nav_args['show_home'] == true ) {
    	$nav_args['before'] .= '<li><a href="' . get_home_url() . '">' . __( '&larr; Home', 'requiredfoundation' ) . '</a></li><li class="divider"></li>';
    }

    // Do we have children?
    if ( $children ) {

		$output = $nav_args['before'] . $children . $nav_args['after'];


		// Replace the output if we are on a definition list
		if ( $nav_args['item_type'] != 'li' ) {

    		$pattern_start = '/<li/';
    		$pattern_end = '/<\/li>/';

    		$replace_start = '<dd';
    		$replace_end = '</dd>';

    		$output = preg_replace($pattern_start, $replace_start, $output);
    		$output = preg_replace($pattern_end, $replace_end, $output);
    	}

    	echo $output;
    }
}
endif;
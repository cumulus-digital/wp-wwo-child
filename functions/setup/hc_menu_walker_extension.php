<?php
/**
 * Init custom menu
 */

namespace WWO_Child;

use Walker_Nav_Menu;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

/*
 * Adds menu data support for HC Off-canvas Nav
 */

class HC_Walker_Nav_Menu extends Walker_Nav_Menu {

public function start_lvl( &$output, $depth = 0, $args = [] ) {
		global $hc_nav_menu_walker;
		$hc_nav_menu_walker->start_lvl( $output, $depth, $args );
	}

	public function end_lvl( &$output, $depth = 0, $args = [] ) {
		global $hc_nav_menu_walker;
		$hc_nav_menu_walker->end_lvl( $output, $depth, $args );
	}

	public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		global $hc_nav_menu_walker;

		$item_output = '';

		$hc_nav_menu_walker->start_el( $item_output, $item, $depth, $args, $id );

		if ( $item->current_item_parent ) {
			$item_output = \preg_replace( '/<li/', '<li data-nav-active', $item_output, 1 );
		}

		if ( $item->current ) {
			$item_output = \preg_replace( '/<li/', '<li data-nav-highlight', $item_output, 1 );
		}

		$output .= $item_output;
	}

	public function end_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		global $hc_nav_menu_walker;
		$hc_nav_menu_walker->end_el( $output, $item, $depth, $args, $id );
	}
}

\add_filter( 'wp_nav_menu_args', function ( $args ) {
	global $hc_nav_menu_walker;

	if ( ! empty( $args['walker'] ) ) {
		$hc_nav_menu_walker = $args['walker'];
	} else {
		$hc_nav_menu_walker = new Walker_Nav_Menu();
	}

	$args['walker'] = new HC_Walker_Nav_Menu();

	return $args;
} );

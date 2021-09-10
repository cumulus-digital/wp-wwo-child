<?php
/**
 * Custom menu walker to clean up menu displays and add data attributes
 */

namespace WWO_Child;

use Walker_Nav_Menu;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

class LeveledMenuWalker extends Walker_Nav_Menu {

public function start_el( &$output, $item, $depth = 0, $args = [], $id = 0 ) {
		$indent = ( $depth ) ? \str_repeat( "\t", $depth ) : '';

		$class_names = $value = '';

		$classes = empty( $item->classes ) ? [] : (array) $item->classes;

		$class_names = \join(
			' ',
			\apply_filters(
				'nav_menu_css_class',
				\array_filter( $classes ),
				$item
			)
		);
		$class_names = ' class="' . \esc_attr( $class_names ) . '"';

		$props = [];

		if ( $item->current_item_parent === true ) {
			$props[] = 'data-nav-active';
		}

		if ( $item->current ) {
			$props[] = 'data-nav-highlight';
		}
		$props = \join( ' ', $props );

		$output .= $indent . '<li ' . $props . ' itemprop="name" id="menu-item-' . $item->ID . '"' . $value . $class_names . ' data-level="' . $depth . '">';

		$attributes = ! empty( $item->attr_title ) ?
			' title="' . \esc_attr( $item->attr_title ) . '"' : '';
		$attributes .= ! empty( $item->target ) ?
			' target="' . \esc_attr( $item->target ) . '"' : '';
		$attributes .= ! empty( $item->xfn ) ?
			' rel="' . \esc_attr( $item->xfn ) . '"' : '';
		$attributes .= ! empty( $item->url ) ?
			' href="' . \esc_attr( $item->url ) . '"' : '';
		$attributes .= ' itemprop="url"';

		if ( \is_array( $args ) ) {
			$args = (object) $args;
		}
		$item_output = $args->before;
		$item_output .= '<a' . $attributes . '>';
		$item_output .= $args->link_before . \apply_filters( 'the_title', $item->title, $item->ID );
		$item_output .= $args->link_after;
		$item_output .= ! empty( $item->description ) ? '<small>' . $item->description . '</small>' : '';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= \apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}

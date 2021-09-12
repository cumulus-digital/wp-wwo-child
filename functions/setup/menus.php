<?php
/**
 * Init custom menu
 */

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

function makeMenu( $location, $options = [] ) {
	$defaults = [
		'theme_location'  => $location,
		'menu'            => '',
		'container'       => '',
		'container_class' => 'menu-{menu slug}-container',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '<ul itemscope itemtype="http://www.schema.org/SiteNavigationElement" class="%2$s">%3$s</ul>',
		'depth'           => 0,
		//'walker'          => new LeveledMenuWalker(),
		'walker' => new \CMLS_Base\CleanMenuWalker(),
	];
	$resolved = \array_merge( $defaults, $options );
	\wp_nav_menu( $resolved );
}

function header_menu() {
	makeMenu( 'header-menu' );
}

function has_header_menu() {
	return \has_nav_menu( 'header-menu' );
}

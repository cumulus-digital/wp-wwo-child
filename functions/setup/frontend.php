<?php

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

function frontendScriptsAndStyles() {
	if (
		$GLOBALS['pagenow'] != 'wp-login.php'
		&& ! \is_admin()
	) {
		$assets = include \CMLS_Base\child_theme_path() . '/build/child_frontend.asset.php';
		\wp_register_script(
			CHILD_PREFIX . '_script-frontend',
			\CMLS_Base\child_theme_url() . '/build/child_frontend.js',
			\array_merge(
				$assets['dependencies'],
				[
					PARENT_PREFIX . '_script-frontend',
				]
			),
			$assets['version'],
			true
		);
		\wp_enqueue_script( CHILD_PREFIX . '_script-frontend' );

		\wp_register_style(
			CHILD_PREFIX . '_style',
			\CMLS_Base\child_theme_url() . '/build/child_frontend.css',
			[PARENT_PREFIX . '_style'],
			null,
			'all'
		);
		\wp_enqueue_style( CHILD_PREFIX . '_style' );
	}
}
\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\frontendScriptsAndStyles' );

// Do not add srcset if we specifically request full size images
\add_filter( 'post_thumbnail_size', function ( $size ) {
	if ( \is_string( $size ) && 'full' === $size ) {
		\add_filter(
			'wp_calculate_image_srcset_meta',
			__NAMESPACE__ . '\\__return_null_and_remove_current_filter'
		);
	}

	return $size;
} );
function __return_null_and_remove_current_filter( $var ) {
	\remove_filter( \current_filter(), __FUNCTION__ );

	return null;
}

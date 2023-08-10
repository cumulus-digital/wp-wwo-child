<?php

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

function frontendScriptsAndStyles()
{
	if (
		$GLOBALS['pagenow'] !== 'wp-login.php'
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
\add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\frontendScriptsAndStyles', 1 );

// Do not add srcset if we specifically request full size images
/*
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
*/

// Blog posts should display author and date in search
\add_filter( 'display-archive-all', function ( $args ) {
	if ( \is_search() && \in_the_loop() && \has_category( ['blog', 'podcast-insights'] ) ) {
		$args['show_author'] = true;
		$args['show_date']   = true;
	}

	return $args;
} );

// Singular blog posts should display author and date
\add_action( 'cmls_template-post-after_title', function () {
	if ( \is_singular() && \has_category( ['blog', 'podcast-insights'] ) ) {
		?>
		<div class="page_title-meta">
			<span class="page_title-meta__date"><?php \the_date(); ?></span>
			By <span class="page_title-meta__author"><?php \the_author(); ?></span>
		</div>
		<?php
	}
} );

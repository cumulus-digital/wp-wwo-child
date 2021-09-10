<?php
/**
 * CMLS Base Theme
 * Template
 * Masthead Menu
 */

namespace WWO_Child;

\defined( 'ABSPATH' ) || exit( 'No direct access allowed.' );

if ( has_header_menu() ):
?>
<nav class="menu-container">
	<button class="hamburger hamburger--spin" type="button"
			aria-label="Open menu" aria-controls="header_menu" aria-expanded="false">
		<span class="hamburger-box">
		<span class="hamburger-inner"></span>
		</span>
	</button>
	<div class="menu" id="header_menu">
		<?php header_menu(); ?>
		<?php if ( \CMLS_Base\themeMods::get( 'setting-main_menu-include_search' ) ): ?>
			<?php \CMLS_Base\cmls_get_template_part( 'templates/masthead/search' ); ?>
		<?php endif; ?>
		<?php if ( \CMLS_Base\has_social_menu() ): ?>
			<?php \CMLS_Base\social_menu( [
				'menu_class' => 'social social-link-icons',
			] ); ?>
		<?php endif; ?>
	</div>
</nav>
<?php
endif;

/**
 * Initialize and handle the HC OffCanvas Menu
 */
import jQuery from 'jquery';
const $j = jQuery.noConflict();

const hcOffcanvasNav = require('hc-offcanvas-nav');

(function ($, window, undefined) {

	// Disable base theme's menu handling.
	$('html').off(
		`click.{window.THEME_PREFIX} focusin.{window.THEME_PREFIX}`
	);

	const $hamburger = $('.masthead .hamburger');
	const $originalNav = $('#header_menu');
	if ($originalNav && $originalNav.length) {
		const Nav = new hcOffcanvasNav($originalNav.get(0), {
			//navTitle: 'Westwood One',
			navClass: $originalNav.hasClass('has-social-menu') ? 'has-social-menu' : '',
			insertClose: false,
			disableBody: true,
			levelTitles: true,
			levelTitleAsBack: true,
			insertBack: -5,
			labelBack: 'Home',
			position: 'right',
			width: 300,
		});
		if (Nav && Nav.hasOwnProperty('on')) {
			// Move back links above level title
			const $Nav = $(Nav);
			$Nav.find('.nav-wrapper .nav-back').each(function () {
				const $back = $(this);
				const $thisLevel = $back.parentsUntil('.nav-content');
				$back.detach();
				$thisLevel.parent().prepend($back);
			});

			// Hamburger toggles menu
			Nav.on('toggle', () => $hamburger.toggleClass('is-active'));
			$hamburger.on('click.' + window.THEME_PREFIX, () => Nav.toggle());

			// Handle body clicks when menu is open
			Nav.on('open', () => {
				$('html').on(
					`click.{window.THEME_PREFIX}-hc-offcanvas-nav`,
					(e) => {
						const context = {
							'menu': $(Nav),
							'hamburger': $('body > header .hamburger')
						};

						// Close menu if click is anywhere outside menu
						if (!(context.menu.is(e.target) || context.menu.has(e.target).length)) {
							Nav.close();
							return;
						}
					}
				);
			});
			Nav.on('close', () => {
				$('html').off(`click.{window.THEME_PREFIX}-hc-offcanvas-nav`);
			});
		}
	}
})($j, window.self);
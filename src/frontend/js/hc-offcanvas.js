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
	const Nav = new hcOffcanvasNav('#header_menu', {
		//navTitle: 'Westwood One',
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
})($j, window.self);
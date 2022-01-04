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
		// Initialize hcOffcanvasNav with our menu
		const Nav = new hcOffcanvasNav($originalNav.get(0), {
			//navTitle: 'Westwood One',
			navClass: $originalNav.hasClass('has-social-menu') ? 'has-social-menu' : '',
			customToggle: 'body > header .hamburger',
			insertClose: false,
			disableBody: true,
			levelTitles: true,
			levelTitleAsBack: true,
			insertBack: -5,
			labelBack: 'Home',
			position: 'right',
			width: 300,
			removeOriginalNav: true,
		});
		if (Nav && Nav.hasOwnProperty('on')) {
			const $Nav = $(Nav);

			// Add some accessibility back
			$Nav.find('.hc-chk').each(function () {
				// hc-offcanvas uses checkboxes for submenu state with no label...
				const $cbox = $(this);
				const $link = $cbox.siblings('.nav-item-wrapper').first().find('a');
				if (!$link.attr('id')) {
					$link.attr('id', `nav-${$cbox.attr('value')}`);
				}
				if ($link.length) {
					$cbox.attr('title', `Expand ${$link.text()} Menu`);
					$cbox.attr('aria-labelledby', `nav-${$cbox.attr('value')}`);
				}
			});
			// No need for a role on the search container
			$Nav.find('ul.search').attr('role', '');

			// Move back links above level title
			$Nav.find('.nav-wrapper .nav-back').each(function () {
				const $back = $(this);
				const $thisLevel = $back.parentsUntil('.nav-content');
				$back.detach();
				$thisLevel.parent().prepend($back);
			});

			// Hamburger toggles menu
			Nav.on('toggle', () => $hamburger.toggleClass('is-active'));
			//$hamburger.on('click.' + window.THEME_PREFIX, () => Nav.toggle());

			Nav.on('open', (e) => {
				// Focus first tabbable element in open level
				let $firstTab = $Nav.find('li.level-open:last .nav-content:first [tabindex=0]:first');
				if (!$firstTab.length) {
					$firstTab = $Nav.find('.nav-content:first [tabindex=0]:first');
				}
				$firstTab.get(0).focus();

				// Handle focus outside and body clicks when menu is open
				$('html').on(
					`click.{window.THEME_PREFIX}-hc-offcanvas-nav`,
					//focusin.{window.THEME_PREFIX}-hc-offcanvas-nav`,
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

				// handle focus on elements in other levels
				/*
				$Nav.find('a[tabindex=0]').on('focusin', (e) => {
					if (Nav.isOpen() && !$Nav.find('li.level-open:last .nav-wrapper').first().has(e.target).length) {
						const $parent = $(e.target).parentsUntil('.nav-wrapper').last().parent();
						console.log($parent, Nav);
						if ($parent.length) {
							//Nav.open($parent.attr('data-level'), $parent.attr('data-index'));
							Nav.closeLevel();
						}
					}
				});
				*/
			});
			Nav.on('close', () => {
				$('html').off(`click.{window.THEME_PREFIX}-hc-offcanvas-nav`);
			});
		}
	}
})($j, window.self);
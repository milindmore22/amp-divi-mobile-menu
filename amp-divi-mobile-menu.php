<?php
/**
 * Plugin Name: AMP Divi Mobile Menu Compat.
 * Plugin URI: https://wpindia.co.in/
 * Description: Plugin adds mobile menu without javascript usages to support AMP.
 * Version: 0.1
 * Author: milindmore22
 * Author URI: https://wpindia.co.in/
 * License: GNU General Public License v2 (or later)
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package div-mobile-menu
 */

add_action(
	'wp',
	function() {
		if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
			remove_action( 'et_header_top', 'et_add_mobile_navigation' );
			add_action( 'et_header_top', 'custom_divi_mobile_navigation' );
			add_action( 'wp_enqueue_scripts', 'custom_divi_theme_styles' );
		}

	}
);

/**
 * Adds Custom CSS.
 */
function custom_divi_theme_styles() {
	wp_enqueue_style( 'divi_custom_style', plugin_dir_url( __FILE__ ) . 'css/divi-custom.css', '', '0.1' );
}

/**
 * Add custom elegant theme location.
 */
function custom_divi_mobile_navigation() {

	$primary_nav = wp_nav_menu(
		array(
			'theme_location' => 'primary-menu',
			'container'      => '',
			'fallback_cb'    => '',
			'menu_class'     => 'et_mobile_menu',
			'menu_id'        => 'mobile_menu',
			'echo'           => false,
		)
	);

	if ( is_customize_preview() || ( 'slide' !== et_get_option( 'header_style', 'left' ) && 'fullscreen' !== et_get_option( 'header_style', 'left' ) ) ) {
		printf(
			'<div id="et_mobile_nav_menu">
				<div class="mobile_nav closed">
					<span class="select_page">%1$s</span>
					<span class="mobile_menu_bar mobile_menu_bar_toggle"></span>
				</div>
				%2$s
			</div>',
			esc_html__( 'Select Page', 'Divi' ),
			$primary_nav
		);
	}
}

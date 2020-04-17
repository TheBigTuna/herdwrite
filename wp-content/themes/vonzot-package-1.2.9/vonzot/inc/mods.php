<?php
/**
 * Vonzot customizer mods
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Initialize customizer mods
 */
function vonzot_customizer_get_mods() {
	return apply_filters( 'vonzot_customizer_mods', array() );
}

/**
 * Initialize customizer mods
 */
function vonzot_customizer_get_mod_files() {
	$mod_files = array(
		'logo',
		'colors',
		'navigation',
		'socials',
		'fonts',
		'header',
		'header-image',
		'blog',
		'shop',
		'background-image',
		'footer',
		'footer-bg',
	);
	return apply_filters( 'vonzot_customizer_mod_files', $mod_files );
}

/**
 * Include customizer mods files
 */
function vonzot_include_mod_files() {

	$mod_files = vonzot_customizer_get_mod_files();

	foreach ( $mod_files as $filename ) {
		vonzot_include( 'inc/customizer/mods/' . sanitize_file_name( $filename ) . '.php' );
	}

	new Vonzot_Customizer_Library( vonzot_customizer_get_mods() );
}
vonzot_include_mod_files();

/**
 * Add selective refresh functionality to certain settings
 */
function vonzot_register_settings_partials( $wp_customize ) {

	/* Abort if selective refresh is not available. */
	if ( ! isset( $wp_customize->selective_refresh ) ) {
		return;
	}

	$wp_customize->get_setting( 'logo_svg' )->transport = 'postMessage';
	$wp_customize->get_setting( 'logo_dark' )->transport = 'postMessage';
	$wp_customize->get_setting( 'logo_light' )->transport = 'postMessage';
	$wp_customize->get_setting( 'header_image' )->transport = 'postMessage';

	$wp_customize->selective_refresh->add_partial( 'logo_svg', array(
		'selector' => '.logo-container',
		'settings' => array( 'logo_svg', 'logo_dark', 'logo_light' ),
		'render_callback' => 'vonzot_logo',
	) );

	$wp_customize->selective_refresh->add_partial( 'header_image', array(
		'selector' => '.post-header-container',
		'settings' => array( 'header_image' ),
		'render_callback' => 'vonzot_output_hero_background',
	) );
}

/**
 * Removes the core 'Menus' panel from the Customizer.
 *
 * As we have added a lot of menu item options with a Walker class we don't want the menu to be save and reset all the options
 *
 * @link https://core.trac.wordpress.org/ticket/33411
 *
 * @param array $components Core Customizer components list.
 * @return array (Maybe) modified components list.
 */
function vonzot_remove_nav_menus_panel( $wp_customize ) {

	$wp_customize->get_panel( 'nav_menus' )->active_callback = '__return_false';
}
add_action( 'customize_register', 'vonzot_remove_nav_menus_panel', 1000 );
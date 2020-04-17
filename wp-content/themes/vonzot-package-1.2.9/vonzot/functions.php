<?php
/**
 * Vonzot functions and definitions
 *
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Sets up theme defaults and registers support for various WordPress features using the VONZOT function
 *
 * @see inc/framework.php
 */
function vonzot_setup_config() {

	/**
	 *  Require the wolf themes framework core file
	 */
	require_once get_template_directory() . '/inc/framework.php';

	/**
	 * Set theme main settings
	 *
	 * We this array to configure the main theme settings
	 */
	$vonzot_settings = array(

		/* Menus */
		'menus' => array(
			'primary' => esc_html__( 'Primary Menu', 'vonzot' ),
			'secondary' => esc_html__( 'Secondary Menu', 'vonzot' ),
			'mobile' => esc_html__( 'Mobile Menu (optional)', 'vonzot' ),
		),

		/**
		 *  We define wordpress thumbnail sizes that we will use in our design
		 */
		'image_sizes' => array(

			/**
			 * Create custom image sizes if the Wolf WPBakery Page Builder extension plugin is not installed
			 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
			 */
			'vonzot-slide' =>array( 750, 300, true ),
			'vonzot-photo' => array( 500, 500, false ),
			'vonzot-metro' => array( 550, 999, false ),
			'vonzot-masonry' =>array( 500, 2000, false ),
			'vonzot-masonry-small' =>array( 400, 400, false ),
			'vonzot-XL' => array( 2000, 3000, false ),
		),
	);

	VONZOT( $vonzot_settings ); // let's go
}
vonzot_setup_config();
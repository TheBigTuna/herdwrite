<?php
/**
 * Plugin Name: Wolf Playlist
 * Plugin URI: https://wolfthemes.com/plugin/wolf-playlist-manager
 * Description: A plugin to manage your playlists
 * Version: 1.2.7
 * Author: WolfThemes
 * Author URI: https://wolfthemes.com
 * Requires at least: 4.4.1
 * Tested up to: 5.3
 *
 * Text Domain: wolf-playlist-manager
 * Domain Path: /languages/
 *
 * @package WolfPlaylistManager
 * @category Core
 * @author WolfThemes
 *
 * Being a free product, this plugin is distributed as-is without official support.
 * Verified customers however, who have purchased a premium theme
 * at https://wlfthm.es/tf
 * will have access to support for this plugin in the forums
 * https://help.wolfthemes.com/
 *
 * Copyright (C) 2013 Constantin Saguin
 * This WordPress Plugin is a free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * It is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * See https://www.gnu.org/licenses/gpl-3.0.html
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Playlist_Manager' ) ) {
	/**
	 * Main Wolf_Playlist_Manager Class
	 *
	 * Contains the main functions for Wolf_Playlist_Manager
	 *
	 * @class Wolf_Playlist_Manager
	 * @version 1.2.7
	 * @since 1.0.0
	 */
	class Wolf_Playlist_Manager {

		/**
		 * @var string
		 */
		private $required_php_version = '5.4.0';

		/**
		 * @var string
		 */
		public $version = '1.2.7';

		/**
		 * @var Wolf Playlist The single instance of the class
		 */
		protected static $_instance = null;

		/**
		 * @var string
		 */
		private $update_url = 'https://plugins.wolfthemes.com/update';

		/**
		 * @var the support forum URL
		 */
		private $support_url = 'https://help.wolfthemes.com/';

		/**
		 * @var string
		 */
		public $template_url;

		/**
		 * Main Wolf Playlist Instance
		 *
		 * Ensures only one instance of Wolf Playlist is loaded or can be loaded.
		 *
		 * @static
		 * @see WPM()
		 * @return Wolf Playlist - Main instance
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Wolf Playlist Constructor.
		 */
		public function __construct() {

			if ( phpversion() < $this->required_php_version ) {
				add_action( 'admin_notices', array( $this, 'warning_php_version' ) );
				return;
			}

			$this->define_constants();
			$this->includes();
			$this->init_hooks();

			do_action( 'wpm_loaded' );
		}

		/**
		 * Display error notice if PHP version is too low
		 */
		public function warning_php_version() {
			?>
			<div class="notice notice-error">
				<p><?php

				printf(
					esc_html__( '%1$s needs at least PHP %2$s installed on your server. You have version %3$s currently installed. Please contact your hosting service provider if you\'re not able to update PHP by yourself.', 'wolf-playlist-manager' ),
					'Wolf Playlist',
					$this->required_php_version,
					phpversion()
				);
				?></p>
			</div>
			<?php
		}

		/**
		 * Hook into actions and filters
		 */
		private function init_hooks() {
			add_action( 'after_setup_theme', array( $this, 'include_template_functions' ), 11 );
			add_action( 'init', array( $this, 'init' ), 0 );
			register_activation_hook( __FILE__, array( $this, 'activate' ) );
		}

		/**
		 * Add a flag that will allow to flush the rewrite rules when needed.
		 */
		public function activate() {
			if ( ! get_option( '_wpm_flush_rewrite_rules_flag' ) ) {
				add_option( '_wpm_flush_rewrite_rules_flag', true );
			}
		}

		/**
		 * Flush rewrite rules on plugin activation to avoid 404 error
		 */
		public function flush_rewrite_rules(){
			if ( get_option( '_wpm_flush_rewrite_rules_flag' ) ) {
				flush_rewrite_rules();
				delete_option( '_wpm_flush_rewrite_rules_flag' );
			}
		}

		/**
		 * Define WPM Constants
		 */
		private function define_constants() {

			$constants = array(
				'WPM_DEV' => false,
				'WPM_DIR' => $this->plugin_path(),
				'WPM_URI' => $this->plugin_url(),
				'WPM_CSS' => $this->plugin_url() . '/assets/css',
				'WPM_JS' => $this->plugin_url() . '/assets/js',
				'WPM_SLUG' => plugin_basename( dirname( __FILE__ ) ),
				'WPM_PATH' => plugin_basename( __FILE__ ),
				'WPM_VERSION' => $this->version,
				'WPM_UPDATE_URL' => $this->update_url,
				'WPM_SUPPORT_URL' => $this->support_url,
				'WPM_DOC_URI' => 'https://docs.wolfthemes.com/documentation/plugins/' . plugin_basename( dirname( __FILE__ ) ),
				'WPM_WOLF_DOMAIN' => 'wolfthemes.com',
			);

			foreach ( $constants as $name => $value ) {
				$this->define( $name, $value );
			}
		}

		/**
		 * Define constant if not already set
		 * @param  string $name
		 * @param  string|bool $value
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * What type of request is this?
		 * string $type ajax, frontend or admin
		 * @return bool
		 */
		private function is_request( $type ) {
			switch ( $type ) {
				case 'admin' :
					return is_admin();
				case 'ajax' :
					return defined( 'DOING_AJAX' );
				case 'cron' :
					return defined( 'DOING_CRON' );
				case 'frontend' :
					return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
			}
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 */
		public function includes() {

			/**
			 * Functions used in frontend and admin
			 */
			include_once( 'inc/wpm-core-functions.php' );

			include_once( 'inc/frontend/wpm-functions.php' );

			if ( $this->is_request( 'admin' ) ) {
				include_once( 'inc/admin/class-wpm-admin.php' );
			}

			if ( $this->is_request( 'ajax' ) ) {
				include_once( 'inc/ajax/wpm-ajax-functions.php' );
			}

			if ( $this->is_request( 'frontend' ) ) {
				include_once( 'inc/frontend/wpm-template-hooks.php' );
				include_once( 'inc/frontend/class-wpm-shortcode.php' );
			}
		}

		/**
		 * Function used to Init Wolf Playlist Template Functions - This makes them pluggable by plugins and themes.
		 */
		public function include_template_functions() {
			include_once( 'inc/frontend/wpm-template-functions.php' );
		}

		/**
		 * register_widget function.
		 *
		 * @access public
		 * @return void
		 */
		public function register_widget() {

			// Include
			include_once( 'inc/class-wpm-playlist-widget.php' );

			// Register widget
			register_widget( 'WPM_Playlist_Widget' );
		}

		/**
		 * Init Wolf Playlist when WordPress Initialises.
		 */
		public function init() {
			// Before init action
			do_action( 'before_wolf_playlist_manager_init' );

			// Set up localisation
			$this->load_plugin_textdomain();

			// Variables
			$this->template_url = apply_filters( 'wolf_playlist_manager_url', 'wolf-playlist-manager/' );

			// Classes/actions loaded for the frontend and for ajax requests
			if ( ! is_admin() || defined( 'DOING_AJAX' ) ) {

				// Hooks
				add_filter( 'template_include', array( $this, 'template_loader' ) );

			}

			// Hooks
			add_action( 'widgets_init', array( $this, 'register_widget' ) );

			$this->register_post_type();

			$this->flush_rewrite_rules();

			// Init action
			do_action( 'wolf_playlist_manager_init' );
		}

		/**
		 * Register post type
		 */
		public function register_post_type() {
			include_once( 'inc/wpm-register-post-type.php' );
		}

		/**
		 * Load a template.
		 *
		 * Handles template usage so that we can use our own templates instead of the themes.
		 *
		 * @param mixed $template
		 * @return string
		 */
		public function template_loader( $template ) {

			$find = array();
			$file = '';

			if ( is_single() && 'wpm_playlist' == get_post_type() ) {

				$file    = 'single-wpm_playlist.php';
				$find[] = $file;
				$find[] = $this->template_url . $file;

			// } elseif ( is_tax( 'wpm_playlist_type' ) ) {

			// 	$term = get_queried_object();

			// 	$file   = 'taxonomy-' . $term->taxonomy . '.php';
			// 	$find[] = 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			// 	$find[] = $this->template_url . 'taxonomy-' . $term->taxonomy . '-' . $term->slug . '.php';
			// 	$find[] = $file;
			// 	$find[] = $this->template_url . $file;


			}

			if ( $file ) {
				$template = locate_template( $find );
				if ( ! $template ) $template = $this->plugin_path() . '/templates/' . $file;
			}

			return $template;
		}

		/**
		 * Loads the plugin text domain for translation
		 */
		public function load_plugin_textdomain() {

			$domain = 'wolf-playlist-manager';
			$locale = apply_filters( 'wolf-playlist-manager', get_locale(), $domain );
			load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );
			load_plugin_textdomain( $domain, FALSE, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}

		/**
		 * Get the plugin url.
		 * @return string
		 */
		public function plugin_url() {
			return untrailingslashit( plugins_url( '/', __FILE__ ) );
		}

		/**
		 * Get the plugin path.
		 * @return string
		 */
		public function plugin_path() {
			return untrailingslashit( plugin_dir_path( __FILE__ ) );
		}

		/**
		 * Get the template path.
		 * @return string
		 */
		public function template_path() {
			return apply_filters( 'wpm_template_path', 'wpm/' );
		}

		/**
		 * Get Ajax URL.
		 * @return string
		 */
		public function ajax_url() {
			return admin_url( 'admin-ajax.php', 'relative' );
		}
	}
} // endif class exists

/**
 * Returns the main instance of WPM to prevent the need to use globals.
 *
 * @return Wolf_Playlist_Manager
 */
function WPM() {
	return Wolf_Playlist_Manager::instance();
}

WPM(); // Go
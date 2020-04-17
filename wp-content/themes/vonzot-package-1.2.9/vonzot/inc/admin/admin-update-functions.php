<?php
/**
 * Vonzot admin theme update functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Update theme version
 *
 * Compare and update theme version and fire update hook to do stuff if needed
 */
function vonzot_update() {

	$theme_version = vonzot_get_theme_version();
	$theme_slug = vonzot_get_theme_slug();

	if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( $theme_slug . '_version' ) != $theme_version ) ) {
		do_action( 'vonzot_do_update' );
		delete_option( $theme_slug . '_version' );
		add_option( $theme_slug . '_version', $theme_version );
		do_action( 'vonzot_updated' );
	}
}
add_action( 'admin_init', 'vonzot_update', 0 );

/**
 * Fetch XML changelog file from remote server
 *
 * Get the theme changelog and cache it in a transient key
 *
 * @return string
 */
function vonzot_get_theme_changelog() {

	$xml = null;
	$update_url = 'https://updates.wolfthemes.com';
	$changelog_url = $update_url . '/' . vonzot_get_theme_slug() .'/changelog.xml';
	$trans_key = '_latest_theme_version_' . vonzot_get_theme_slug();

	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {

		$response = wp_remote_get( $changelog_url , array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response ); // use the content
			set_transient( $trans_key, $xml, 6 * HOUR_IN_SECONDS );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {
		return @simplexml_load_string( $xml );
	}
}

/**
 * Display the theme update notification notice fro important update
 *
 * @param bool $link
 * @return string
 */
function vonzot_update_notification_message() {

	$changelog = vonzot_get_theme_changelog();
	$cookie_name = vonzot_get_theme_slug() . '_update_notice';
	$message = '';
	$is_envato_plugin_page = ( isset( $_GET['page'] ) && 'envato-market' === $_GET['page'] );

	/* Stop if update is not critical and the update notification is disabled */
	if ( $changelog && isset( $changelog->updatenotification ) && 'no' === (string)$changelog->updatenotification ) {
		return;
	}
	if ( $changelog && isset( $changelog->latest ) && -1 == version_compare( vonzot_get_parent_theme_version(), $changelog->latest ) && ! $is_envato_plugin_page ) {

		$class = 'vonzot-admin-notice notice notice-info is-dismissible';

		$message .= '<p>';
		$message .= sprintf(
			wp_kses_post(
				__( 'There is a new version of <strong>%s</strong> available. You have version %s installed. It is recommended to update.', 'vonzot' )
			),
			vonzot_get_parent_theme_name(),
			vonzot_get_parent_theme_version()
		);
		$message .= '</p>';
		$href = ( class_exists( 'Envato_Market' ) ) ? admin_url( 'update-core.php' ) : 'https://wolfthemes.ticksy.com/article/11658/';
		$target = ( class_exists( 'Envato_Market' ) ) ? '_parent' : '_blank';

		$message .= '<p>';
		$message .= '<a class="button button-primary vonzot-admin-notice-button" href="' . esc_url( $href ) . '" target="' . esc_attr( $target ) .'">';
		$message .= sprintf( esc_html__( 'Update to version %s', 'vonzot' ), $changelog->latest );
		$message .= '</a>';

		$message .= ' <a id="' . esc_attr( $cookie_name ) . '" class="button vonzot-dismiss-admin-notice" href="#">';
		$message .= esc_html__( 'Hide update notices permanently', 'vonzot' );
		$message .= '</a>';
		$message .= '</p>';

		if ( ! isset( $_COOKIE[ $cookie_name ] ) ) {
			printf( '<div class="%1$s">%2$s</div>', $class, $message );
		}
	}
}
add_action( 'admin_notices', 'vonzot_update_notification_message' );


/**
 * Display the info notice for important message
 *
 * @param bool $link
 * @return string
 */
function vonzot_info_notification_message() {

	$changelog = vonzot_get_theme_changelog();
	$info = ( $changelog && isset( $changelog->info ) ) ? (string)$changelog->info : null;
	$cookie_id = vonzot_get_theme_slug() . '_info_notice';
	$message = '';

	if ( $info ) {

		vonzot_admin_notice( $info, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}

}
add_action( 'admin_notices', 'vonzot_info_notification_message' );
<?php
/**
 * Displays sidebar content
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( vonzot_is_woocommerce_page() ) {

	dynamic_sidebar( 'sidebar-shop' );

} else {

	if ( function_exists( 'wolf_sidebar' ) ) {

		wolf_sidebar();

	} else {

		dynamic_sidebar( 'sidebar-page' );
	}
}
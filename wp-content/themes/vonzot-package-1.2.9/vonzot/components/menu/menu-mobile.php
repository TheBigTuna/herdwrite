<?php
/**
 * The main navigation for mobile
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( vonzot_do_onepage_menu() ) {

	echo vonzot_one_page_menu( 'mobile' );

} else {

	if ( has_nav_menu( 'mobile' ) ) {

		wp_nav_menu( vonzot_get_menu_args( 'mobile', 'mobile' ) );

	} else {
		wp_nav_menu( vonzot_get_menu_args( 'primary', 'mobile' ) );
	}
}
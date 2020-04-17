<?php
/**
 * The main navigation for vertical menus
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( vonzot_do_onepage_menu() ) {

	echo vonzot_one_page_menu();

} else {

	if ( has_nav_menu( 'vertical' ) ) {

		wp_nav_menu( vonzot_get_menu_args( 'vertical', 'vertical' ) );

	} else {
		wp_nav_menu( vonzot_get_menu_args( 'primary', 'vertical' ) );
	}
}
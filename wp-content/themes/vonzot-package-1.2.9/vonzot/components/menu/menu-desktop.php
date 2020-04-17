<?php
/**
 * The main navigation for desktop
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( vonzot_do_onepage_menu() ) {

	echo vonzot_one_page_menu();

} else {
	wp_nav_menu( vonzot_get_menu_args() );
}

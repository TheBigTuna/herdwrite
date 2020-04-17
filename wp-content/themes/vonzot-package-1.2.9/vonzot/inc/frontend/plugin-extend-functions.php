<?php
/**
 * Vonzot plugin extend functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get single work layout
 *
 * @return string $layout
 */
function vonzot_get_single_work_layout() {

	$single_work_layout = ( get_post_meta( get_the_ID(), '_single_work_layout', true ) ) ? get_post_meta( get_the_ID(), '_single_work_layout', true ) : 'small-width';

	if ( is_singular( 'work' ) ) {
		return apply_filters( 'vonzot_single_work_layout', $single_work_layout );
	}
}

/**
 * Filter add to wishlist button class
 *
 * @return string $layout
 */
function vonzot_filter_addo_to_wishlist_button_class( $class ) {

	$class = str_replace( 'button', '', $class );

	return $class;
}
add_filter( 'wolf_add_to_wishlist_class', 'vonzot_filter_addo_to_wishlist_button_class' );

/**
 * Set Wolf Gram widget lightbox
 *
 * @return string $lightbox
 */
function vonzot_set_wolf_gram_lightbox( $lightbox ) {

	return 'fancybox';
}
add_filter( 'wolf_gram_lightbox', 'vonzot_set_wolf_gram_lightbox' );

/**
 * Filter ticket link CSS class
 *
 * @param string $class
 * @param string $class
 */
function vonzot_filter_ticket_link_css_class( $class ) {
	return 'button ticket-button';
}
add_filter( 'we_ticket_link_class', 'vonzot_filter_ticket_link_css_class' );
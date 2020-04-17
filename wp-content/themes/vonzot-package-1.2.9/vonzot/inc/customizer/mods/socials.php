<?php
/**
 * Vonzot Socials
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_socials_mods( $mods ) {

	if ( function_exists( 'wvc_get_socials' ) ) {

		$socials = wvc_get_socials();

		$mods['socials'] = array(
			'id' => 'socials',
			'title' => esc_html__( 'Social Networks', 'vonzot' ),
			'icon' => 'share',
			'options' => array(),
		);

		foreach ( $socials as $social ) {
			$mods['socials']['options'][ $social ] = array(
				'id' => $social,
				'label' => ucfirst( $social ),
				'type' => 'text',
			);
		}
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_socials_mods' );
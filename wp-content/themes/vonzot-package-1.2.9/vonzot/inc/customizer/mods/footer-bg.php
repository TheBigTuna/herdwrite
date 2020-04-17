<?php
/**
 * Vonzot footer_bg
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_footer_bg_mods( $mods ) {

	$mods['footer_bg'] = array(
		'id' =>'footer_bg',
		'label' => esc_html__( 'Footer Background', 'vonzot' ),
		'background' => true,
		'font_color' => true,
		'icon' => 'format-image',
	);

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_footer_bg_mods' );
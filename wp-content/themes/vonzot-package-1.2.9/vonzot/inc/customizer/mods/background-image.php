<?php
/**
 * Vonzot background_image
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_background_image_mods( $mods ) {
	$mods['background_image'] = array(
		'icon' => 'format-image',
		'id' => 'background_image',
		'title' => esc_html__( 'Background Image', 'vonzot' ),
		'options' => array(),
	);

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_background_image_mods' );
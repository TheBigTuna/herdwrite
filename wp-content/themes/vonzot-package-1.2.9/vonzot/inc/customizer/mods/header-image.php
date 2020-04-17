<?php
/**
 * Vonzot header_image
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;


function vonzot_set_header_image_mods( $mods ) {

	/* Move header image setting here and rename the section title */
	$mods['header_image'] = array(
		'id' => 'header_image',
		'title' => esc_html__( 'Header Image', 'vonzot' ),
		'icon' => 'format-image',
		'options' => array(),
	);

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_header_image_mods' );
<?php
/**
 * Vonzot extra
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_extra_mods( $mods ) {

	$mods['extra'] = array(

		'id' => 'extra',
		'title' => esc_html__( 'Extra', 'vonzot' ),
		'icon' => 'plus-alt',
		'options' => array(
			array(
				'label'	=> esc_html__( 'Enable Scroll Animations on Mobile (not recommended)', 'vonzot' ),
				'id'	=> 'enable_mobile_animations',
				'type'	=> 'checkbox',
			),
			array(
				'label'	=> esc_html__( 'Enable Parallax on Mobile (not recommended)', 'vonzot' ),
				'id'	=> 'enable_mobile_parallax',
				'type'	=> 'checkbox',
			),
		),
	);
	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_extra_mods' );
<?php
/**
 * Vonzot loading
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_loading_mods( $mods ) {

	$mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'vonzot' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loading Animation Type', 'vonzot' ),
				'id' => 'loading_animation_type',
				'type' => 'select',
				'choices' => array(
					'spinner' => esc_html__( 'Spinner', 'vonzot' ),
		 			'none' => esc_html__( 'None', 'vonzot' ),
				),
			),
		),
	);
	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_loading_mods' );
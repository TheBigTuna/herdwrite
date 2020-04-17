<?php
/**
 * Vonzot customizer logo mods
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set color schemes
 */
function vonzot_set_logo_mods( $mods ) {

	$mods['logo'] = array(
		'id' => 'logo',
		'title' => esc_html__( 'Logo', 'vonzot' ),
		'icon' => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%d &times; %d</strong> pixels and set the maximum width to <strong>%d</strong> below.', 'vonzot' ),
				array(
					'strong' => array(),
				)
			),
			360, 160, 180
		),
		'options' => array(

			'logo_dark' => array(
				'id' => 'logo_dark',
				'label' => esc_html__( 'Logo - Dark Version', 'vonzot' ),
				'type' => 'image',
			),

			'logo_light' => array(
				'id' => 'logo_light',
				'label' => esc_html__( 'Logo - Light Version', 'vonzot' ),
				'type' => 'image',
			),

			'logo_max_width' => array(
				'id' => 'logo_max_width',
				'label' => esc_html__( 'Logo Max Width (don\'t ommit px )', 'vonzot' ),
				'type' => 'text',
			),

			'logo_visibility' => array(
				'id' => 'logo_visibility',
				'label' => esc_html__( 'Visibility', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'always' => esc_html__( 'Always', 'vonzot' ),
					'sticky_menu' => esc_html__( 'When menu is sticky only', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	return $mods;

}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_logo_mods' );
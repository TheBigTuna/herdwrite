<?php
/**
 * Vonzot footer
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_footer_mods( $mods ) {

	$mods['footer'] = array(

		'id' => 'footer',
		'title' => esc_html__( 'Footer', 'vonzot' ),
		'icon' => 'welcome-widgets-menus',
		'options' => array(

			'footer_type' => array(
				'label' => esc_html__( 'Footer Type', 'vonzot' ),
				'id' => 'footer_type',
				'type' => 'select',
				'choices' => array(
		 			'standard' => esc_html__( 'Standard', 'vonzot' ),
					'uncover' => esc_html__( 'Uncover', 'vonzot' ),
					'hidden' => esc_html__( 'No Footer', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Footer Width', 'vonzot' ),
				'id' => 'footer_layout',
				'type' => 'select',
				'choices' => array(
		 			'boxed' => esc_html__( 'Boxed', 'vonzot' ),
					'wide' => esc_html__( 'Wide', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Foot Widgets Layout', 'vonzot' ),
				'id' => 'footer_widgets_layout',
				'type' => 'select',
				'choices' => array(
		 			'3-cols' => esc_html__( '3 Columns', 'vonzot' ),
					'4-cols' => esc_html__( '4 Columns', 'vonzot' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'vonzot' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Bottom Bar Layout', 'vonzot' ),
				'id' => 'bottom_bar_layout',
				'type' => 'select',
				'choices' => array(
					'centered' => esc_html__( 'Centered', 'vonzot' ),
					'inline' => esc_html__( 'Inline', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'footer_socials' => array(
				'id' => 'footer_socials',
				'label' => esc_html__( 'Socials', 'vonzot' ),
				'type' => 'text',
				'description' => esc_html__( 'The list of social services to display in the bottom bar. (eg: facebook,twitter,instagram)', 'vonzot' ),
			),

			'copyright' => array(
				'id' => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'vonzot' ),
				'type' => 'text',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['footer']['options']['footer_type']['description'] = sprintf(
			vonzot_kses(
				__( 'This is the default footer settings. You can leave the fields below empty and use a <a href="%s" target="_blank">content block</a> instead for more flexibility. See the customizer "Layout" tab or the page options below your text editor.', 'vonzot' )
			),
			'http://wlfthm.es/content-blocks'
		); 
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_footer_mods' );
<?php
/**
 * Vonzot header_settings
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_header_settings_mods( $mods ) {

	$mods['header_settings'] = array(

		'id' => 'header_settings',
		'title' => esc_html__( 'Header Layout', 'vonzot' ),
		'icon' => 'editor-table',
		'options' => array(

			'hero_layout' => array(
				'label'	=> esc_html__( 'Page Header Layout', 'vonzot' ),
				'id'	=> 'hero_layout',
				'type'	=> 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'vonzot' ),
					'big' => esc_html__( 'Big', 'vonzot' ),
					'small' => esc_html__( 'Small', 'vonzot' ),
					'fullheight' => esc_html__( 'Full Height', 'vonzot' ),
					'none' => esc_html__( 'No header', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'hero_background_effect' => array(
				'id' =>'hero_background_effect',
				'label' => esc_html__( 'Header Image Effect', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'parallax' => esc_html__( 'Parallax', 'vonzot' ),
					'zoomin' => esc_html__( 'Zoom', 'vonzot' ),
					'none' => esc_html__( 'None', 'vonzot' ),
				),
			),

			'hero_scrolldown_arrow' => array(
				'id' =>'hero_scrolldown_arrow',
				'label' => esc_html__( 'Scroll Down arrow', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'vonzot' ),
					'' => esc_html__( 'No', 'vonzot' ),
				),
			),

			array(
				'label'	=> esc_html__( 'Header Overlay', 'vonzot' ),
				'id'	=> 'hero_overlay',
				'type'	=> 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'vonzot' ),
					'custom' => esc_html__( 'Custom', 'vonzot' ),
					'none' => esc_html__( 'None', 'vonzot' ),
				),
			),

			array(
				'label'	=> esc_html__( 'Overlay Color', 'vonzot' ),
				'id'	=> 'hero_overlay_color',
				'type'	=> 'color',
				'value' 	=> '#000000',
			),

			array(
				'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'vonzot' ),
				'id'	=> 'hero_overlay_opacity',
				'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'vonzot' ),
				'type'	=> 'text',
				'value'	=> 40,
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {
		$mods['header_settings']['options']['hero_layout']['description'] = sprintf(
			vonzot_kses(
				__( 'The header can be overwritten by a <a href="%s" target="_blank">content block</a> on all pages or on specific pages. See the customizer "Layout" tab or the page options below your text editor.', 'vonzot' )
			),
			'http://wlfthm.es/content-blocks'
		); 
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_header_settings_mods' );
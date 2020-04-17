<?php
/**
 * Vonzot customizer font mods
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Set color schemes
 */
function vonzot_set_font_mods( $mods ) {

	/**
	 * Get Google Fonts from Font loader
	 */
	$_fonts = apply_filters( 'vonzot_mods_fonts', vonzot_get_google_fonts_options() );

	$font_choices = array( 'default' => esc_html__( 'Default', 'vonzot' ) );

	foreach ( $_fonts as $key => $value ) {
		$font_choices[ $key ] = $key;
	}

	$mods['fonts'] = array(
		'id' => 'fonts',
		'title' => esc_html__( 'Fonts', 'vonzot' ),
		'icon' => 'editor-textcolor',
		'options' => array(),
	);

	$mods['fonts']['options']['body_font_name'] = array(
		'label' => esc_html__( 'Body Font Name', 'vonzot' ),
		'id' => 'body_font_name',
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['body_font_size'] = array(
		'label' => esc_html__( 'Body Font Size', 'vonzot' ),
		'id' => 'body_font_size',
		'type' => 'text',
		'transport' => 'postMessage',
		'description' => esc_html__( 'Don\'t ommit px. Leave empty to use the default font size.', 'vonzot' ),
	);

	/*************************Menu****************************/

	$mods['fonts']['options']['menu_font_name'] = array(
		'id' => 'menu_font_name',
		'label' => esc_html__( 'Menu Font', 'vonzot' ),
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_weight'] = array(
		'label' => esc_html__( 'Menu Font Weight', 'vonzot' ),
		'id' => 'menu_font_weight',
		'type' => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_transform'] = array(
		'id' => 'menu_font_transform',
		'label' => esc_html__( 'Menu Font Transform', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'vonzot' ),
			'uppercase' => esc_html__( 'Uppercase', 'vonzot' ),
			'lowercase' => esc_html__( 'Lowercase', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Menu Letter Spacing (omit px)', 'vonzot' ),
		'id' => 'menu_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['menu_font_style'] = array(
		'id' => 'menu_font_style',
		'label' => esc_html__( 'Menu Font Style', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'vonzot' ),
			'italic' => esc_html__( 'Italic', 'vonzot' ),
			'oblique' => esc_html__( 'Oblique', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_name'] = array(
		'id' => 'submenu_font_name',
		'label' => esc_html__( 'Submenu Font', 'vonzot' ),
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_weight'] = array(
		'label' => esc_html__( 'Submenu Font Weight', 'vonzot' ),
		'id' => 'submenu_font_weight',
		'type' => 'text',
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_transform'] = array(
		'id' => 'submenu_font_transform',
		'label' => esc_html__( 'Submenu Font Transform', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'vonzot' ),
			'uppercase' => esc_html__( 'Uppercase', 'vonzot' ),
			'lowercase' => esc_html__( 'Lowercase', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_style'] = array(
		'id' => 'submenu_font_style',
		'label' => esc_html__( 'Submenu Font Style', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'vonzot' ),
			'italic' => esc_html__( 'Italic', 'vonzot' ),
			'oblique' => esc_html__( 'Oblique', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['submenu_font_letter_spacing'] = array(
		'label' => esc_html__( 'Submenu Letter Spacing (omit px)', 'vonzot' ),
		'id' => 'submenu_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	/*************************Heading****************************/

	$mods['fonts']['options']['heading_font_name'] = array(
		'id' => 'heading_font_name',
		'label' => esc_html__( 'Heading Font', 'vonzot' ),
		'type' => 'select',
		'choices' => $font_choices,
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_weight'] = array(
		'label' => esc_html__( 'Heading Font weight', 'vonzot' ),
		'id' => 'heading_font_weight',
		'type' => 'text',
		'description' => esc_html__( 'For example: "400" is normal, "700" is bold.The available font weights depend on the font.', 'vonzot' ),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_transform'] = array(
		'id' => 'heading_font_transform',
		'label' => esc_html__( 'Heading Font Transform', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'vonzot' ),
			'uppercase' => esc_html__( 'Uppercase', 'vonzot' ),
			'lowercase' => esc_html__( 'Lowercase', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_style'] = array(
		'id' => 'heading_font_style',
		'label' => esc_html__( 'Heading Font Style', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'normal' => esc_html__( 'Normal', 'vonzot' ),
			'italic' => esc_html__( 'Italic', 'vonzot' ),
			'oblique' => esc_html__( 'Oblique', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['fonts']['options']['heading_font_letter_spacing'] = array(
		'label' => esc_html__( 'Heading Letter Spacing (omit px)', 'vonzot' ),
		'id' => 'heading_font_letter_spacing',
		'type' => 'int',
		'transport' => 'postMessage',
	);

	return $mods;

}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_font_mods', 10 );
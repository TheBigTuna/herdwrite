<?php
/**
 * Vonzot navigation
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_navigation_mods( $mods ) {

	$mods['navigation'] = array(
		'id' => 'navigation',
		'icon' => 'menu',
		'title' => esc_html__( 'Navigation', 'vonzot' ),
		'options' => array(

			'menu_layout' => array(
				'id' => 'menu_layout',
				'label' => esc_html__( 'Main Menu Layout', 'vonzot' ),
				'type' => 'select',
				'default' => 'top-justify',
				'choices' => array(
					'top-right' => esc_html__( 'Top Right', 'vonzot' ),
					'top-justify' => esc_html__( 'Top Justify', 'vonzot' ),
					'top-justify-left' => esc_html__( 'Top Justify Left', 'vonzot' ),
					'centered-logo' => esc_html__( 'Centered', 'vonzot' ),
					'top-left' => esc_html__( 'Top Left', 'vonzot' ),
					'offcanvas' => esc_html__( 'Off Canvas', 'vonzot' ),
					'overlay' => esc_html__( 'Overlay', 'vonzot' ),
					'lateral' => esc_html__( 'Lateral', 'vonzot' ),
				),
			),

			'menu_width' => array(
				'id' => 'menu_width',
				'label' => esc_html__( 'Main Menu Width', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'wide' => esc_html__( 'Wide', 'vonzot' ),
					'boxed' => esc_html__( 'Boxed', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'menu_style' => array(
				'id' =>'menu_style',
				'label' => esc_html__( 'Main Menu Style', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'vonzot' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'vonzot' ),
					'solid' => esc_html__( 'Solid', 'vonzot' ),
					'transparent' => esc_html__( 'Transparent', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'menu_hover_style' => array(
				'id' => 'menu_hover_style',
				'label' => esc_html__( 'Main Menu Hover Style', 'vonzot' ),
				'type' => 'select',
				'choices' => apply_filters( 'vonzot_main_menu_hover_style_options', array(
					'none' => esc_html__( 'None', 'vonzot' ),
					'opacity' => esc_html__( 'Opacity', 'vonzot' ),
					'underline' => esc_html__( 'Underline', 'vonzot' ),
					'underline-centered' => esc_html__( 'Underline Centered', 'vonzot' ),
					'border-top' => esc_html__( 'Border Top', 'vonzot' ),
					'plain' => esc_html__( 'Plain', 'vonzot' ),
				) ),
				'transport' => 'postMessage',
			),

			'mega_menu_width' => array(
				'id' => 'mega_menu_width',
				'label' => esc_html__( 'Mega Menu Width', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'vonzot' ),
					'wide' => esc_html__( 'Wide', 'vonzot' ),
					'fullwidth' => esc_html__( 'Full Width', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'menu_breakpoint' => array(
				'id' =>'menu_breakpoint',
				'label' => esc_html__( 'Main Menu Breakpoint', 'vonzot' ),
				'type' => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'vonzot' ),
			),

			'menu_sticky_type' => array(
				'id' =>'menu_sticky_type',
				'label' => esc_html__( 'Sticky Menu', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'none' => esc_html__( 'Disabled', 'vonzot' ),
					'soft' => esc_html__( 'Sticky on scroll up', 'vonzot' ),
					'hard' => esc_html__( 'Always sticky', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			/*'search_menu_item' => array(
				'label' => esc_html__( 'Search Menu Item', 'vonzot' ),
				'id' => 'search_menu_item',
				'type' => 'checkbox',
			),*/

			'menu_skin' => array(
				'id' => 'menu_skin',
				'label' => esc_html__( 'Menu Skin', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'light' => esc_html__( 'Light', 'vonzot' ),
					'dark' => esc_html__( 'Dark', 'vonzot' ),
				),
				'transport' => 'postMessage',
				'description' => esc_html__( 'Can be overwite on single page.', 'vonzot' ),
			),

			'menu_cta_content_type' => array(
				'id' => 'menu_cta_content_type',
				'label' => esc_html__( 'Additional Content', 'vonzot' ),
				'type' => 'select',
				'default' => 'icons',
				'choices' => apply_filters( 'vonzot_menu_cta_content_type_options', array(
					'search_icon' => esc_html__( 'Search Icon', 'vonzot' ),
					'secondary-menu' => esc_html__( 'Secondary Menu', 'vonzot' ),
					'none' => esc_html__( 'None', 'vonzot' ),
				) ),
			),
		)
	);

	$mods['navigation']['options']['menu_socials'] = array(
		'id' => 'menu_socials',
		'label' => esc_html__( 'Menu Socials', 'vonzot' ),
		'type' => 'text',
		'description' => esc_html__( 'The list of social services to display in the menu. (eg: facebook,twitter,instagram)', 'vonzot' ),
	);

	$mods['navigation']['options']['side_panel_position'] = array(
		'id' => 'side_panel_position',
		'label' => esc_html__( 'Side Panel', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'none' => esc_html__( 'None', 'vonzot' ),
			'right' => esc_html__( 'At Right', 'vonzot' ),
			'left' => esc_html__( 'At Left', 'vonzot' ),
		),
		'description' => esc_html__( 'Note that it will be disable with a vertical menu layout (offcanvas and lateral layout).', 'vonzot' ),
	);

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_navigation_mods' );
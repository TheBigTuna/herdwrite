<?php
/**
 * Vonzot shop
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_product_mods( $mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$mods['shop'] = array(
			'id' => 'shop',
			'title' => esc_html__( 'Shop', 'vonzot' ),
			'icon' => 'cart',
			'options' => array(

				'product_layout' => array(
					'id' => 'product_layout',
					'label' => esc_html__( 'Products Layout', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'vonzot' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'product_display' => array(
					'id' =>'product_display',
					'label' => esc_html__( 'Products Archive Display', 'vonzot' ),
					'type' => 'select',
					'choices' => apply_filters( 'vonzot_product_display_options', array(
						'grid_classic' => esc_html__( 'Grid', 'vonzot' ),
					) ),
				),
				'product_single_layout' => array(
					'id' => 'product_single_layout',
					'label' => esc_html__( 'Single Product Layout', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'vonzot' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full Width', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'product_columns' => array(
					'id' => 'product_columns',
					'label' => esc_html__( 'Columns', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'default' => esc_html__( 'Auto', 'vonzot' ),
						3 => 3,
						2 => 2,
						4 => 4,
						6 => 6,
					),
				),

				'product_item_animation' => array(
					'label' => esc_html__( 'Shop Archive Item Animation', 'vonzot' ),
					'id' => 'product_item_animation',
					'type' => 'select',
					'choices' => vonzot_get_animations(),
				),

				'product_zoom' => array(
					'label' => esc_html__( 'Single Product Zoom', 'vonzot' ),
					'id' => 'product_zoom',
					'type' => 'checkbox',
				),

				'related_products_carousel' => array(
					'label' => esc_html__( 'Related Products Carousel', 'vonzot' ),
					'id' => 'related_products_carousel',
					'type' => 'checkbox',
				),

				'cart_menu_item' => array(
					'label' => esc_html__( 'Add a "Cart" Menu Item', 'vonzot' ),
					'id' => 'cart_menu_item',
					'type' => 'checkbox',
				),

				'account_menu_item' => array(
					'label' => esc_html__( 'Add a "Account" Menu Item', 'vonzot' ),
					'id' => 'account_menu_item',
					'type' => 'checkbox',
				),

				'shop_search_menu_item' => array(
					'label' => esc_html__( 'Search Menu Item', 'vonzot' ),
					'id' => 'shop_search_menu_item',
					'type' => 'checkbox',
				),

				'products_per_page' => array(
					'label' => esc_html__( 'Products per Page', 'vonzot' ),
					'id' => 'products_per_page',
					'type' => 'text',
					'placeholder' => 12,
				),
			),
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['wishlist_menu_item'] = array(
				'label' => esc_html__( 'Wishlist Menu Item', 'vonzot' ),
				'id' => 'wishlist_menu_item',
				'type' => 'checkbox',
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_product_mods' );
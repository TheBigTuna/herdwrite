<?php
/**
* Layouts Settings.
*
* @package Store Lite
*/

$default = store_lite_get_default_theme_options();

// Woocommerce Setting For Theme.
$wp_customize->add_section( 'store_lite_woocommerce_setting',
	array(
	'title'      => esc_html__( 'Theme Settings', 'store-lite' ),
	'priority'   => 60,
	'capability' => 'edit_theme_options',
	'panel'      => 'woocommerce',
	)
);

// Product Single Sidebar Layout.
$wp_customize->add_setting( 'product_sidebar_layout',
	array(
	'default'           => $default['product_sidebar_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'store_lite_sanitize_select',
	)
);
$wp_customize->add_control( 'product_sidebar_layout',
	array(
	'label'       => esc_html__( 'Single Product Sidebar Layout', 'store-lite' ),
	'section'     => 'store_lite_woocommerce_setting',
	'type'        => 'select',
	'choices'     => array(
		'right-sidebar' => esc_html__( 'Right Sidebar', 'store-lite' ),
		'left-sidebar'  => esc_html__( 'Left Sidebar', 'store-lite' ),
		'no-sidebar'    => esc_html__( 'No Sidebar', 'store-lite' ),
	    ),
	)
);

$wp_customize->add_setting('ed_after_add_to_cart_popup',
    array(
        'default' => $default['ed_after_add_to_cart_popup'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_after_add_to_cart_popup',
    array(
        'label' => esc_html__('Enable After Add To Cart Popup', 'store-lite'),
        'section' => 'store_lite_woocommerce_setting',
        'type' => 'checkbox',
        'priority' => 10,
    )
);
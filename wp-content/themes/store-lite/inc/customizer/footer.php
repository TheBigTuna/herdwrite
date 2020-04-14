<?php
/**
* Footer Settings.
*
* @package Store Lite
*/

$default = store_lite_get_default_theme_options();
$store_lite_page_lists = store_lite_page_lists();

// Footer Section.
$wp_customize->add_section( 'footer_setting',
	array(
	'title'      => esc_html__( 'Footer Settings', 'store-lite' ),
	'priority'   => 200,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Footer Layout.
$wp_customize->add_setting( 'footer_column_layout',
	array(
	'default'           => $default['footer_column_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'store_lite_sanitize_select',
	)
);
$wp_customize->add_control( 'footer_column_layout',
	array(
	'label'       => esc_html__( 'Top Footer Column Layout', 'store-lite' ),
	'section'     => 'footer_setting',
	'type'        => 'select',
	'choices'               => array(
		'1' => esc_html__( 'One Column', 'store-lite' ),
		'2' => esc_html__( 'Two Column', 'store-lite' ),
		'3' => esc_html__( 'Three Column', 'store-lite' ),
	    ),
	)
);

// Header Image Ad Link.
$wp_customize->add_setting( 'footer_copyright_text',
	array(
	'default'           => $default['footer_copyright_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'footer_copyright_text',
	array(
	'label'    => esc_html__( 'Footer Copyright Text', 'store-lite' ),
	'section'  => 'footer_setting',
	'type'     => 'text',
	)
);

// Better Business Bureau Enable Disable.
$wp_customize->add_setting('ed_bbb_icon',
    array(
        'default' => $default['ed_bbb_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_bbb_icon',
    array(
        'label' => esc_html__('Enable Better Business Bureau Icon', 'store-lite'),
        'section' => 'footer_setting',
        'type' => 'checkbox',
    )
);

// Visa Enable Disable.
$wp_customize->add_setting('ed_visa_icon',
    array(
        'default' => $default['ed_visa_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_visa_icon',
    array(
        'label' => esc_html__('Enable Visa Icon', 'store-lite'),
        'section' => 'footer_setting',
        'type' => 'checkbox',
    )
);

// Mastercard Enable Disable.
$wp_customize->add_setting('ed_mastercard_icon',
    array(
        'default' => $default['ed_mastercard_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_mastercard_icon',
    array(
        'label' => esc_html__('Enable Mastercard Icon', 'store-lite'),
        'section' => 'footer_setting',
        'type' => 'checkbox',
    )
);

// American Express Enable Disable.
$wp_customize->add_setting('ed_american_express_icon',
    array(
        'default' => $default['ed_american_express_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_american_express_icon',
    array(
        'label' => esc_html__('Enable American Express Icon', 'store-lite'),
        'section' => 'footer_setting',
        'type' => 'checkbox',
    )
);

// Discover Enable Disable.
$wp_customize->add_setting('ed_discover_icon',
    array(
        'default' => $default['ed_discover_icon'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_discover_icon',
    array(
        'label' => esc_html__('Enable Discover Icon', 'store-lite'),
        'section' => 'footer_setting',
        'type' => 'checkbox',
    )
);
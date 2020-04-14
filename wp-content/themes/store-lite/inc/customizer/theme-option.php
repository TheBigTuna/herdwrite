<?php
/**
* Theme Options.
*
* @package Store Lite
*/

$default = store_lite_get_default_theme_options();

// Theme Options Panel.
$wp_customize->add_panel( 'theme_option_panel',
	array(
		'title'      => esc_html__( 'Theme Options', 'store-lite' ),
		'priority'   => 200,
		'capability' => 'edit_theme_options',
	)
);
// Breadcrumb Section.
$wp_customize->add_section( 'breadcrumb_section',
	array(
	'title'      => esc_html__( 'Breadcrumb Settings', 'store-lite' ),
	'priority'   => 50,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Breadcrumb Layout.
$wp_customize->add_setting( 'breadcrumb_layout',
	array(
	'default'           => $default['breadcrumb_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'store_lite_sanitize_select',
	)
);
$wp_customize->add_control( 'breadcrumb_layout',
	array(
	'label'       => esc_html__( 'Breadcrumb Layout', 'store-lite' ),
	'description' => sprintf( esc_html__( 'Advanced: Requires %1$sBreadcrumb NavXT%2$s plugin.', 'store-lite' ), '<a href="https://wordpress.org/plugins/breadcrumb-navxt/" target="_blank">','</a>' ),
	'section'     => 'breadcrumb_section',
	'type'        => 'select',
	'choices'               => array(
		'disable' => esc_html__( 'Disabled', 'store-lite' ),
		'simple' => esc_html__( 'Simple', 'store-lite' ),
		'advanced' => esc_html__( 'Advanced', 'store-lite' ),
	    ),
	'priority'    => 10,
	)
);

// Pagination Section.
$wp_customize->add_section( 'pagination_section',
	array(
	'title'      => esc_html__( 'Pagination Settings', 'store-lite' ),
	'priority'   => 80,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Pagination Layout.
$wp_customize->add_setting( 'pagination_layout',
	array(
	'default'           => $default['pagination_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'store_lite_sanitize_select',
	)
);
$wp_customize->add_control( 'pagination_layout',
	array(
	'label'       => esc_html__( 'Pagination Layout', 'store-lite' ),
	'section'     => 'pagination_section',
	'type'        => 'select',
	'choices'               => array(
		'classic' => esc_html__( 'Classic(Previous/Next)', 'store-lite' ),
		'numeric' => esc_html__( 'Numeric', 'store-lite' ),
	    ),
	'priority'    => 10,
	)
);

// Preloader Section.
$wp_customize->add_section( 'preloader_section',
	array(
	'title'      => esc_html__( 'Preloader Settings', 'store-lite' ),
	'priority'   => 5,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Enable Disable Preloader.
$wp_customize->add_setting('ed_preloader',
    array(
        'default' => $default['ed_preloader'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_checkbox',
    )
);
$wp_customize->add_control('ed_preloader',
    array(
        'label' => esc_html__('Enable Preloader', 'store-lite'),
        'description' => esc_html__('Enable/Disable Loading Animation.', 'store-lite'),
        'section' => 'preloader_section',
        'type' => 'checkbox',
    )
);

// Footer Mailchimp Section Desc.
$wp_customize->add_setting( 'preloader_text',
	array(
	'default'           => $default['preloader_text'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control( 'preloader_text',
	array(
	'label'    => esc_html__( 'Preloader Text', 'store-lite' ),
	'section'  => 'preloader_section',
	'type'     => 'text',
	)
);
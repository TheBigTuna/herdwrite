<?php
/**
* Header Media Options.
*
* @package Store Lite
*/

$default = store_lite_get_default_theme_options();

// Banner Text.
$wp_customize->add_setting( 'header_medai_text',
    array(
    'default'           => $default['header_medai_text'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_medai_text',
    array(
    'label'    => esc_html__( 'Banner Text', 'store-lite' ),
    'section'  => 'header_image',
    'type'     => 'text',
    )
);

// Banner Button.
$wp_customize->add_setting( 'header_medai_button_label',
    array(
    'default'           => $default['header_medai_button_label'],
    'capability'        => 'edit_theme_options',
    'sanitize_callback' => 'sanitize_text_field',
    )
);
$wp_customize->add_control( 'header_medai_button_label',
    array(
    'label'    => esc_html__( 'Banner Butten Label', 'store-lite' ),
    'section'  => 'header_image',
    'type'     => 'text',
    )
);

// Banner Text Link.
$wp_customize->add_setting( 'header_medai_text_link',
	array(
	'default'           => '',
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'esc_url_raw',
	)
);
$wp_customize->add_control( 'header_medai_text_link',
	array(
	'label'    => esc_html__( 'Banner Button Link', 'store-lite' ),
	'section'  => 'header_image',
	'type'     => 'text',
	)
);

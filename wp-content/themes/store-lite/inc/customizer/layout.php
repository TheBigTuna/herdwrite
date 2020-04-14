<?php
/**
* Layouts Settings.
*
* @package Store Lite
*/

$default = store_lite_get_default_theme_options();

// Layout Section.
$wp_customize->add_section( 'layout_setting',
	array(
	'title'      => esc_html__( 'Layout Settings', 'store-lite' ),
	'priority'   => 60,
	'capability' => 'edit_theme_options',
	'panel'      => 'theme_option_panel',
	)
);

// Global Sidebar Layout.
$wp_customize->add_setting( 'global_sidebar_layout',
	array(
	'default'           => $default['global_sidebar_layout'],
	'capability'        => 'edit_theme_options',
	'sanitize_callback' => 'store_lite_sanitize_select',
	)
);
$wp_customize->add_control( 'global_sidebar_layout',
	array(
	'label'       => esc_html__( 'Global Sidebar Layout', 'store-lite' ),
	'section'     => 'layout_setting',
	'type'        => 'select',
	'choices'     => array(
		'right-sidebar' => esc_html__( 'Right Sidebar', 'store-lite' ),
		'left-sidebar'  => esc_html__( 'Left Sidebar', 'store-lite' ),
		'no-sidebar'    => esc_html__( 'No Sidebar', 'store-lite' ),
	    ),
	)
);

// Archive Layout.
$wp_customize->add_setting(
    'store_lite_archive_layout',
    array(
        'default' 			=> $default['store_lite_archive_layout'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'store_lite_sanitize_select'
    )
);
$wp_customize->add_control(
    new Store_Lite_Custom_Radio_Image_Control( 
        $wp_customize,
        'store_lite_archive_layout',
        array(
            'settings'      => 'store_lite_archive_layout',
            'section'       => 'layout_setting',
            'label'         => esc_html__( 'Archive Layout', 'store-lite' ),
            'choices'       => array(
                'archive-layout-1'  => get_template_directory_uri() . '/assets/images/Layout-style-1.png',
                'archive-layout-2'  => get_template_directory_uri() . '/assets/images/Layout-style-2.png',
            )
        )
    )
);
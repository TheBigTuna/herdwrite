<?php
/**
 * Vonzot customizer blog mods
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_post_mods( $mods ) {

	$mods['blog'] = array(
		'id' => 'blog',
		'icon' => 'welcome-write-blog',
		'title' => esc_html__( 'Blog', 'vonzot' ),
		'options' => array(

			'post_layout' => array(
				'id' =>'post_layout',
				'label' => esc_html__( 'Blog Archive Layout', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'vonzot' ),
					'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'vonzot' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'vonzot' ),
				),
				'transport' => 'postMessage',
				'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'vonzot' ),
			),

			'post_display' => array(
				'id' =>'post_display',
				'label' => esc_html__( 'Blog Archive Display', 'vonzot' ),
				'type' => 'select',
				'choices' => apply_filters( 'vonzot_post_display_options', array(
					'standard' => esc_html__( 'Standard', 'vonzot' ),
				) ),
			),

			'post_grid_padding' => array(
				'id' => 'post_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'vonzot' ),
					'no' => esc_html__( 'No', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),

			'date_format' => array(
				'id' => 'date_format',
				'label' => esc_html__( 'Blog Date Format', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default', 'vonzot' ),
					'human_diff' => esc_html__( '"X Time ago"', 'vonzot' ),
				),
			),

			'post_pagination' => array(
				'id' => 'post_pagination',
				'label' => esc_html__( 'Blog Archive Pagination', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'standard_pagination' => esc_html__( 'Numeric Pagination', 'vonzot' ),
					'load_more' => esc_html__( 'Load More Button', 'vonzot' ),
				),
			),

			'post_excerpt_type' => array(
				'id' =>'post_excerpt_type',
				'label' => esc_html__( 'Blog Archive Post Excerpt Type', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'auto' => esc_html__( 'Auto', 'vonzot' ),
					'manual' => esc_html__( 'Manual', 'vonzot' ),
				),
				'description' => sprintf( vonzot_kses( __( 'Only for the "Standard" display type. To split your post manually, you can use the <a href="%s" target="_blank">"read more"</a> tag.', 'vonzot' ) ), 'https://codex.wordpress.org/Customizing_the_Read_More' ),
			),

			'post_single_layout' => array(
				'id' =>'post_single_layout',
				'label' => esc_html__( 'Single Post Layout', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Sidebar Right', 'vonzot' ),
					'sidebar-left' => esc_html__( 'Sidebar Left', 'vonzot' ),
					'no-sidebar' => esc_html__( 'No Sidebar', 'vonzot' ),
					'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
				),
			),

			'post_author_box' => array(
				'id' =>'post_author_box',
				'label' => esc_html__( 'Single Post Author Box', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'vonzot' ),
					'no' => esc_html__( 'No', 'vonzot' ),
				),
			),

			'post_related_posts' => array(
				'id' =>'post_related_posts',
				'label' => esc_html__( 'Single Post Related Posts', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'vonzot' ),
					'no' => esc_html__( 'No', 'vonzot' ),
				),
			),

			'post_item_animation' => array(
				'label' => esc_html__( 'Blog Archive Item Animation', 'vonzot' ),
				'id' => 'post_item_animation',
				'type' => 'select',
				'choices' => vonzot_get_animations(),
			),

			'post_display_elements' => array(
				'id' => 'post_display_elements',
				'label' => esc_html__( 'Elements to show by default', 'vonzot' ),
				'type' => 'group_checkbox',
				'choices' => array(
					'show_thumbnail' => esc_html__( 'Thumbnail', 'vonzot' ),
					'show_date' => esc_html__( 'Date', 'vonzot' ),
					'show_text' => esc_html__( 'Text', 'vonzot' ),
					'show_category' => esc_html__( 'Category', 'vonzot' ),
					'show_author' => esc_html__( 'Author', 'vonzot' ),
					'show_tags' => esc_html__( 'Tags', 'vonzot' ),
					'show_extra_meta' => esc_html__( 'Extra Meta', 'vonzot' ),
				),
				'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'vonzot' ),
			),
		),
	);

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

		$mods['blog']['options'][] = array(
			'label' => esc_html__( 'Enable Custom Post Meta', 'vonzot' ),
			'id' => 'enable_custom_post_meta',
			'type' => 'group_checkbox',
			'choices' => array(
				'post_enable_views' => esc_html__( 'Views', 'vonzot' ),
				'post_enable_likes' => esc_html__( 'Likes', 'vonzot' ),
				'post_enable_reading_time' => esc_html__( 'Reading Time', 'vonzot' ),
			),
		);
	}


	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_post_mods' );
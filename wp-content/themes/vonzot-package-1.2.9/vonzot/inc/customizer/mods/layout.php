<?php
/**
 * Vonzot layout
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_layout_mods( $mods ) {

	$mods['layout'] = array(

		'id' => 'layout',
		'title' => esc_html__( 'Layout', 'vonzot' ),
		'icon' => 'layout',
		'options' => array(

			'site_layout' => array(
				'id' => 'site_layout',
				'label' => esc_html__( 'General', 'vonzot' ),
				'type' => 'radio_images',
				'default' => 'wide',
				'choices' => array(
					array(
						'key' => 'wide',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/wide.png' ),
						'text' => esc_html__( 'Wide', 'vonzot' ),
					),

					array(
						'key' => 'boxed',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/boxed.png' ),
						'text' => esc_html__( 'Boxed', 'vonzot' ),
					),

					array(
						'key' => 'frame',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/frame.png' ),
						'text' => esc_html__( 'Frame', 'vonzot' ),
					),
				),
				'transport' => 'postMessage',
			),

			'button_style' => array(
				'id' => 'button_style',
				'label' => esc_html__( 'Button Shape', 'vonzot' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'vonzot' ),
					'square' => esc_html__( 'Square', 'vonzot' ),
					'round' => esc_html__( 'Round', 'vonzot' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) ) {

		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array( '' => esc_html__( 'None', 'vonzot' ) );
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'vonzot' );
		}

		/*
		$mods['layout']['options']['top_bar_block_id'] = array(
			'label'	=> esc_html__( 'Top Bar Block', 'vonzot' ),
			'id'	=> 'top_bar_block_id',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display above the navigation.', 'vonzot' ),
		);
		*/

		$mods['layout']['options']['after_header_block'] = array(
			'label'	=> esc_html__( 'Post-header Block', 'vonzot' ),
			'id'	=> 'after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display below to header or in replacement of the header.', 'vonzot' ),
		);

		$mods['layout']['options']['before_footer_block'] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'vonzot' ),
			'id'	=> 'before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display above to footer or in replacement of the footer.', 'vonzot' ),
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_layout_mods' );
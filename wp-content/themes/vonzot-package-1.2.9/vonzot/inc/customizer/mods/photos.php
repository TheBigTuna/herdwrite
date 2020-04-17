<?php
/**
 * Vonzot photos
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_attachment_mods( $mods ) {

	if ( class_exists( 'Wolf_Photos' ) ) {
		$mods['photos'] = array(
			'priority' => 45,
			'id' => 'photos',
			'title' => esc_html__( 'Stock Photos', 'vonzot' ),
			'icon' => 'camera',
			'options' => array(

				'attachment_layout' => array(
					'id' => 'attachment_layout',
					'label' => esc_html__( 'Layout', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_display' => array(
					'id' =>'attachment_display',
					'label' => esc_html__( 'Photos Display', 'vonzot' ),
					'type' => 'select',
					'choices' => apply_filters( 'vonzot_attachment_display_options', array(
						'grid' => esc_html__( 'Grid', 'vonzot' ),
					) ),
				),

				'attachment_grid_padding' => array(
					'id' => 'attachment_grid_padding',
					'label' => esc_html__( 'Padding', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'vonzot' ),
						'no' => esc_html__( 'No', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'attachment_author' => array(
					'id' => 'attachment_author',
					'label' => esc_html__( 'Display Author on Single Page', 'vonzot' ),
					'type' => 'checkbox',
				),

				'attachment_likes' => array(
					'id' => 'attachment_likes',
					'label' => esc_html__( 'Display Likes', 'vonzot' ),
					'type' => 'checkbox',
				),

				'attachment_multiple_sizes_download' => array(
					'id' => 'attachment_multiple_sizes_download',
					'label' => esc_html__( 'Allow multiple sizes options for downloadable photos.', 'vonzot' ),
					'type' => 'checkbox',
				),

				'attachments_per_page' => array(
					'label' => esc_html__( 'Photos per Page', 'vonzot' ),
					'id' => 'attachments_per_page',
					'type' => 'text',
				),

				'attachments_pagination' => array(
					'id' => 'attachments_pagination',
					'label' => esc_html__( 'Pagination Type', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'infinitescroll' => esc_html__( 'Infinite Scroll', 'vonzot' ),
						'numbers' => esc_html__( 'Numbers', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_attachment_mods' );
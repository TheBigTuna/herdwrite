<?php
/**
 * Vonzot events
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_artist_mods( $mods ) {

	if ( class_exists( 'Wolf_Artists' ) ) {
		$mods['wolf_artists'] = array(
			'priority' => 45,
			'id' => 'wolf_artists',
			'title' => esc_html__( 'Artists', 'vonzot' ),
			'icon' => 'admin-users',
			'options' => array(

				'artist_layout' => array(
					'id' => 'artist_layout',
					'label' => esc_html__( 'Layout', 'vonzot' ),
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

				'artist_display' => array(
					'id' => 'artist_display',
					'label' => esc_html__( 'Display', 'vonzot' ),
					'type' => 'select',
					'choices' => apply_filters( 'vonzot_artist_display_options', array(
						'list' => esc_html__( 'List', 'vonzot' ),
					) ),
				),

				'artist_grid_padding' => array(
					'id' => 'artist_grid_padding',
					'label' => esc_html__( 'Padding', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'vonzot' ),
						'no' => esc_html__( 'No', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'artist_pagination' => array(
					'id' => 'artist_pagination',
					'label' => esc_html__( 'Artists Archive Pagination', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'none' => esc_html__( 'None', 'vonzot' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'vonzot' ),
						'load_more' => esc_html__( 'Load More Button', 'vonzot' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'vonzot' ),
				),

				'artists_per_page' => array(
					'label' => esc_html__( 'Artists per Page', 'vonzot' ),
					'id' => 'artists_per_page',
					'type' => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_artist_mods' );
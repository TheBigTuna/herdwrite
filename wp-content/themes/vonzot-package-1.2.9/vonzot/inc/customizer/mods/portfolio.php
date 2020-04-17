<?php
/**
 * Vonzot customizer blog mods
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_work_mods( $mods ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {

		$mods['portfolio'] = array(
			'id' => 'portfolio',
			'icon' => 'portfolio',
			'title' => esc_html__( 'Portfolio', 'vonzot' ),
			'options' => array(

				'work_layout' => array(
					'id' =>'work_layout',
					'label' => esc_html__( 'Portfolio Layout', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
					),
				),

				'work_display' => array(
					'id' =>'work_display',
					'label' => esc_html__( 'Portfolio Display', 'vonzot' ),
					'type' => 'select',
					'choices' => apply_filters( 'vonzot_work_display_options', array(
						'grid' => esc_html__( 'Grid', 'vonzot' ),
					) ),
				),

				'work_grid_padding' => array(
					'id' => 'work_grid_padding',
					'label' => esc_html__( 'Padding (for grid style display only)', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'yes' => esc_html__( 'Yes', 'vonzot' ),
						'no' => esc_html__( 'No', 'vonzot' ),
					),
					'transport' => 'postMessage',
				),

				'work_item_animation' => array(
					'label' => esc_html__( 'Portfolio Post Animation', 'vonzot' ),
					'id' => 'work_item_animation',
					'type' => 'select',
					'choices' => vonzot_get_animations(),
				),

				'work_pagination' => array(
					'id' => 'work_pagination',
					'label' => esc_html__( 'Portfolio Archive Pagination', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'none' => esc_html__( 'None', 'vonzot' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'vonzot' ),
						'load_more' => esc_html__( 'Load More Button', 'vonzot' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'vonzot' ),
				),

				'works_per_page' => array(
					'label' => esc_html__( 'Works per Page', 'vonzot' ),
					'id' => 'works_per_page',
					'type' => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_work_mods' );
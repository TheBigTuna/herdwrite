<?php
/**
 * Vonzot Page Builder
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

function vonzot_set_wvc_mods( $mods ) {

	if ( class_exists( 'Wolf_Visual_Composer' ) ) {
		$mods['blog']['options']['newsletter'] = array(
			'id' =>'newsletter_form_single_blog_post',
			'label' => esc_html__( 'Add newsletter form below single post', 'vonzot' ),
			'type' => 'checkbox',
			'description' => esc_html__( 'Display a newsletter sign up form at the bottom of each blog post.', 'vonzot' ),
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_set_wvc_mods' );
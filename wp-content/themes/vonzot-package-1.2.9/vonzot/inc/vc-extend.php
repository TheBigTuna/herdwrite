<?php
/**
 * WPBakery Page Builder Extension theme related functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

/**
 * Set WPBPB as theme
 */
function vonzot_set_as_theme() {
	vc_set_as_theme();
}
add_action( 'vc_before_init', 'vonzot_set_as_theme' );

/**
 * Disable WPBPB frontend
 */
function vonzot_vc_remove_frontend_links() {

	if ( defined( 'WVC_VERSION' ) && version_compare( WVC_VERSION, '3.1.4', '<' ) ) {
		vc_disable_frontend();
	}
}
add_action( 'vc_after_init', 'vonzot_vc_remove_frontend_links' );

/**
 * Add theme accent color to shared colors
 */
function vonzot_wvc_add_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Accent Color', 'vonzot' ) => 'accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'vonzot_wvc_add_accent_color_option', 14 );

/**
 * Add row css class
 */
function vonzot_wvc_add_row_css_class( $classes ) {

	$classes[] = 'section';

	return $classes;
}
add_filter( 'wvc_row_css_class', 'vonzot_wvc_add_row_css_class' );

/**
 * Set VC default post types
 */
function vonzot_vc_default_post_types() {

	vc_set_default_editor_post_types( vonzot_get_default_post_types() );
}
add_action( 'vc_after_init', 'vonzot_vc_default_post_types' );

/**
 * Set WVC default post types
 */
function vonzot_wvc_default_post_types( $post_types ) {
	$default_post_types = vonzot_get_default_post_types();

	return wp_parse_args( $post_types, $default_post_types );
}
add_filter( 'wvc_default_post_types', 'vonzot_wvc_default_post_types' );

/**
 * Filter WVC theme accent color
 */
function vonzot_set_wvc_theme_accent_color( $color ) {
	return vonzot_get_inherit_mod( 'accent_color' );
}
add_filter( 'wvc_theme_accent_color', 'vonzot_set_wvc_theme_accent_color' );

/**
 * Add post types to post module
 */
function vonzot_set_wvc_post_types( $post_types ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {
		$post_types[ esc_html__( 'Work', 'vonzot' ) ] = 'work';
	}

	if ( class_exists( 'Wolf_Albums' ) ) {
		$post_types[ esc_html__( 'Gallery', 'vonzot' ) ] = 'gallery';
	}

	if ( class_exists( 'Wolf_Discography' ) ) {
		$post_types[ esc_html__( 'Release', 'vonzot' ) ] = 'release';
	}

	if ( class_exists( 'Wolf_Videos' ) ) {
		$post_types[ esc_html__( 'Videos', 'vonzot' ) ] = 'videos';
	}

	if ( class_exists( 'Wolf_Events' ) ) {
		$post_types[ esc_html__( 'Events', 'vonzot' ) ] = 'events';
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$post_types[ esc_html__( 'Product', 'vonzot' ) ] = 'product';
	}

	return $post_types;
}
add_filter( 'vonzot_available_post_types', 'vonzot_set_wvc_post_types' );

/**
 * Add theme templates to WPBPB from XML feed
 *
 * @param array $default_templates
 * @return array $default_templates
 */
function vonzot_add_vc_templates( $default_templates ) {
	
	$templates = array();

	$cache_duration = 60 * 60 * 1; // 1 hour
	$cache_duration = 1;

	$trans_key = '_vc_templates_' . vonzot_get_theme_slug();

	$xml = null;
	
	$theme_slug = vonzot_get_theme_slug();

	$template_xml_root = 'https://updates.wolfthemes.com/' . $theme_slug ;
	$template_xml_url = $template_xml_root .'/vc-templates/vc-templates.xml';

	/* Get XML feed */
	if ( false === ( $cached_xml = get_transient( $trans_key ) ) ) {

		$response = wp_remote_get( $template_xml_url , array( 'timeout' => 10 ) );

		if ( ! is_wp_error( $response ) && is_array( $response ) ) {
			$xml = wp_remote_retrieve_body( $response ); // use the content
		}

		if ( $xml ) {
			set_transient( $trans_key, $xml, $cache_duration );
		}
	} else {
		$xml = $cached_xml;
	}

	if ( $xml ) {

		/* Parse XML */
		$xml_templates = new SimpleXMLElement( $xml );
		$type_slug = 'default_templates';

		/* Loop */
		foreach ( $xml_templates as $xml_template ) {

			$slug = ( $xml_template && isset( $xml_template->slug ) ) ? (string)$xml_template->slug : '';
			$name = ( $xml_template && isset( $xml_template->name ) ) ? (string)$xml_template->name : '';
			$custom_class = ( $xml_template && isset( $xml_template->custom_class ) ) ? (string)$xml_template->custom_class : '';
			$content = ( $xml_template && isset( $xml_template->content ) ) ? (string)$xml_template->content : '';
			
			$template = array();
			$template['name'] = $name;
			$template['custom_class'] = $custom_class;
			$template['content'] = $content;

			array_unshift( $default_templates, $template );
		}
	}

	return $default_templates;
}
//add_filter( 'vc_load_default_templates', 'vonzot_add_vc_templates' );
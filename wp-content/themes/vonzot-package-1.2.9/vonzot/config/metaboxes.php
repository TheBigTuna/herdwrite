<?php
/**
 * Vonzot metaboxes
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register metaboxes
 *
 * Pass a metabox array to generate metabox with the  Wolf Metaboxes plugin
 */
function vonzot_register_metabox() {

	$body_metaboxes = array(
		'site_settings' => array(
			'title' => esc_html__( 'General', 'vonzot' ),
			'page' => apply_filters( 'vonzot_site_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Accent Color', 'vonzot' ),
					'id'	=> '_post_accent_color',
					'type'	=> 'colorpicker',
				),

				array(
					'label'	=> esc_html__( 'Content Background Color', 'vonzot' ),
					'id'	=> '_post_content_inner_bg_color',
					'type'	=> 'colorpicker',
					'desc' => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background color.', 'vonzot' ),
				),

				array(
					'label' => esc_html__( 'Loading Animation Type', 'vonzot' ),
					'id' => '_post_loading_animation_type',
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'overlay' => esc_html__( 'Overlay', 'vonzot' ),
		 				//'vonzot' => esc_html__( 'Overlay with percent animation on vinyl', 'vonzot' ),
		 				'none' => esc_html__( 'None', 'vonzot' ),
					),
				),
			),
		),
	);

	$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'vonzot' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		// Content block option
		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
			'none' => esc_html__( 'None', 'vonzot' ),
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'vonzot' );
		}

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Post-header Block', 'vonzot' ),
			'id'	=> '_post_after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'vonzot' ),
			'id'	=> '_post_before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

	}

	$header_metaboxes = array(
		'header_settings' => array(
			'title' => esc_html__( 'Header', 'vonzot' ),
			'page' => apply_filters( 'vonzot_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Header Layout', 'vonzot' ),
					'id'	=> '_post_hero_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'big' => esc_html__( 'Big', 'vonzot' ),
						'small' => esc_html__( 'Small', 'vonzot' ),
						'fullheight' => esc_html__( 'Full Height', 'vonzot' ),
						'none' => esc_html__( 'No Header', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Title Font Family', 'vonzot' ),
					'id'	=> '_post_hero_title_font_family',
					'type'	=> 'font_family',
				),

				array(
					'label'	=> esc_html__( 'Font Transform', 'vonzot' ),
					'id'	=> '_post_hero_title_font_transform',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'uppercase' => esc_html__( 'Uppercase', 'vonzot' ),
						'none' => esc_html__( 'None', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Big Text', 'vonzot' ),
					'id'	=> '_post_hero_title_bigtext',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Enable "Big Text" for the title?', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Font Tone', 'vonzot' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'vonzot' ),
						'dark' => esc_html__( 'Dark', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Background Type', 'vonzot' ),
					'id'	=> '_post_hero_background_type',
					'type'	=> 'select',
					'choices' => array(
						'featured-image' => esc_html__( 'Featured Image', 'vonzot' ),
						'image' => esc_html__( 'Image', 'vonzot' ),
						'video' => esc_html__( 'Video', 'vonzot' ),
						'slideshow' => esc_html__( 'Slideshow', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Slideshow Images', 'vonzot' ),
					'id'	=> '_post_hero_slideshow_ids',
					'type'	=> 'multiple_images',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'slideshow' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background', 'vonzot' ),
					'id'	=> '_post_hero_background',
					'type'	=> 'background',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background Effect', 'vonzot' ),
					'id'	=> '_post_hero_background_effect',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'zoomin' => esc_html__( 'Zoom', 'vonzot' ),
						'parallax' => esc_html__( 'Parallax', 'vonzot' ),
						'none' => esc_html__( 'None', 'vonzot' ),
					),
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Video URL', 'vonzot' ),
					'id'	=> '_post_hero_background_video_url',
					'type'	=> 'video',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'video' ) ),
					'desc' => esc_html__( 'A mp4 or YouTube URL. The featured image will be used as image fallback when the video cannot be displayed.', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Overlay', 'vonzot' ),
					'id'	=> '_post_hero_overlay',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'custom' => esc_html__( 'Custom', 'vonzot' ),
						'none' => esc_html__( 'None', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Overlay Color', 'vonzot' ),
					'id'	=> '_post_hero_overlay_color',
					'type'	=> 'colorpicker',
					//'value' 	=> '#000000',
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

				array(
					'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'vonzot' ),
					'id'	=> '_post_hero_overlay_opacity',
					'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'vonzot' ),
					'type'	=> 'int',
					'placeholder'	=> 40,
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

			),
		),
	);

	$menu_metaboxes = array(
			'menu_settings' => array(
				'title' => esc_html__( 'Menu', 'vonzot' ),
				'page' => apply_filters( 'vonzot_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Menu Layout', 'vonzot' ),
					'id'	=> '_post_menu_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'top-right' => esc_html__( 'Top Right', 'vonzot' ),
						'top-justify' => esc_html__( 'Top Justify', 'vonzot' ),
						'top-justify-left' => esc_html__( 'Top Justify Left', 'vonzot' ),
						'centered-logo' => esc_html__( 'Centered', 'vonzot' ),
						'top-left' => esc_html__( 'Top Left', 'vonzot' ),
						'offcanvas' => esc_html__( 'Off Canvas', 'vonzot' ),
						//'overlay' => esc_html__( 'Overlay', 'vonzot' ),
						'lateral' => esc_html__( 'Lateral', 'vonzot' ),
						'none' => esc_html__( 'No Menu', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Width', 'vonzot' ),
					'id'	=> '_post_menu_width',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'wide' => esc_html__( 'Wide', 'vonzot' ),
						'boxed' => esc_html__( 'Boxed', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'vonzot' ),
					'id'	=> '_post_menu_style',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'solid' => esc_html__( 'Solid', 'vonzot' ),
						'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'vonzot' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'vonzot' ),
						'transparent' => esc_html__( 'Transparent', 'vonzot' ),
						//'none' => esc_html__( 'No Menu', 'vonzot' ),
					),
				),

				/*array(
					'label'	=> esc_html__( 'Menu Skin', 'vonzot' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'vonzot' ),
						'dark' => esc_html__( 'Dark', 'vonzot' ),
						//'none' => esc_html__( 'No Menu', 'vonzot' ),
					),
				),*/

				'menu_sticky_type' => array(
					'id' =>'_post_menu_sticky_type',
					'label' => esc_html__( 'Sticky Menu', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'none' => esc_html__( 'Disabled', 'vonzot' ),
						'soft' => esc_html__( 'Sticky on scroll up', 'vonzot' ),
						'hard' => esc_html__( 'Always sticky', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Sticky Menu Skin', 'vonzot' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'vonzot' ),
						'dark' => esc_html__( 'Dark', 'vonzot' ),
						//'none' => esc_html__( 'No Menu', 'vonzot' ),
					),
				),

				array(
					'id' => '_post_menu_cta_content_type',
					'label' => esc_html__( 'Additional Content', 'vonzot' ),
					'type' => 'select',
					'default' => 'icons',
					'choices' => array_merge(
						array(
							'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						),
						apply_filters( 'vonzot_menu_cta_content_type_options', array(
							'search_icon' => esc_html__( 'Search Icon', 'vonzot' ),
							'secondary-menu' => esc_html__( 'Secondary Menu', 'vonzot' ),
						) ),
						array( 'none' => esc_html__( 'None', 'vonzot' ) )
					),
				),

				array(
					'id' => '_post_show_nav_player',
					'label' => esc_html__( 'Show Navigation Player', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'vonzot' ),
						'no' => esc_html__( 'No', 'vonzot' ),
					),
				),

				array(
					'id' => '_post_side_panel_position',
					'label' => esc_html__( 'Side Panel', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'none' => esc_html__( 'None', 'vonzot' ),
						'right' => esc_html__( 'At Right', 'vonzot' ),
						'left' => esc_html__( 'At Left', 'vonzot' ),
					),
					'desc' => esc_html__( 'Note that it will be disable with a vertical menu layout (overlay, offcanvas etc...).', 'vonzot' ),
				),

				array(
					'id' => '_post_logo_visibility',
					'label' => esc_html__( 'Logo Visibility', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'always' => esc_html__( 'Always', 'vonzot' ),
						'sticky_menu' => esc_html__( 'When menu is sticky only', 'vonzot' ),
						'hidden' => esc_html__( 'Hidden', 'vonzot' ),
					),
				),

				array(
					'id' => '_post_menu_items_visibility',
					'label' => esc_html__( 'Menu Items Visibility', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'show' => esc_html__( 'Visible', 'vonzot' ),
						'hidden' => esc_html__( 'Hidden', 'vonzot' ),
					),
					'desc' => esc_html__( 'If, for some reason, you need to hide the menu items but leave the logo, additional content and side panel.', 'vonzot' ),
				),

				'menu_breakpoint' => array(
					'id' =>'_post_menu_breakpoint',
					'label' => esc_html__( 'Mobile Menu Breakpoint', 'vonzot' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use this field if you want to overwrite the mobile menu breakpoint.', 'vonzot' ),
				),
			),
		)
	);

	$footer_metaboxes = array(
		'footer_settings' => array(
				'title' => esc_html__( 'Footer', 'vonzot' ),
				'page' => apply_filters( 'vonzot_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Page Footer', 'vonzot' ),
					'id'	=> '_post_footer_type',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'hidden' => esc_html__( 'No Footer', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Bottom Bar', 'vonzot' ),
					'id'	=> '_post_bottom_bar_hidden',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'vonzot' ),
						'yes' => esc_html__( 'Yes', 'vonzot' ),
					),
				),
			),
		)
	);

	/************** Post options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'vonzot' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {
			
			$product_options[] = esc_html__( 'Not linked', 'vonzot' );
			
			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'vonzot' ) ] = 0;
		}
	}

	$post_metaboxes = array(
		'post_settings' => array(
			'title' => esc_html__( 'Post', 'vonzot' ),
			'page' => array( 'post' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Post Layout', 'vonzot' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'sidebar-right' => esc_html__( 'Sidebar Right', 'vonzot' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'vonzot' ),
						'no-sidebar' => esc_html__( 'No Sidebar', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full width', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Feature a Product', 'vonzot' ),
					'id'	=> '_post_wc_product_id',
					'type'	=> 'select',
					'choices' => $product_options,
					'desc'	=> esc_html__( 'A "Shop Now" buton will be displayed in the metro layout.', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Featured', 'vonzot' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'Will be displayed bigger in the "metro" layout (auto pattern).', 'vonzot' ),
				),
			),
		),
	);

	/************** Product options ******************/
	$product_metaboxes = array(

		'product_options' => array(
			'title' => esc_html__( 'Product', 'vonzot' ),
			'page' => array( 'product' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Label', 'vonzot' ),
					'id'	=> '_post_product_label',
					'type'	=> 'text',
					'placeholder' => esc_html__( '-30%', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'vonzot' ),
					'id'	=> '_post_product_single_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'vonzot' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full Width', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'MP3', 'vonzot' ),
					'id'	=> '_post_product_mp3',
					'type'	=> 'file',
					'desc' => esc_html__( 'If you want to display a player for a song you want to sell, paste the mp3 URL here.', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'MP3 Label', 'vonzot' ),
					'id'	=> '_post_product_mp3_label',
					'type'	=> 'text',
					'desc' => esc_html__( 'An optional label to describe the song.', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Hide Player on Single Product Page', 'vonzot' ),
					'id'	=> '_post_wc_product_hide_mp3_player',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Size Chart Image', 'vonzot' ),
					'id'	=> '_post_wc_product_size_chart_img',
					'type'	=> 'image',
					'desc' => esc_html__( 'You can set a size chart image in the product category options. You can overwrite the category size chart for this product by uploading another image here.', 'vonzot' ),
				),

				array(
					'label'	=> esc_html__( 'Hide Size Chart Image', 'vonzot' ),
					'id'	=> '_post_wc_product_hide_size_chart_img',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Menu Font Tone', 'vonzot' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'vonzot' ),
						'dark' => esc_html__( 'Dark', 'vonzot' ),
					),
					'desc' => esc_html__( 'By default the menu style is set to "solid" on single product page. If you change the menu style, you may need to adujst the menu color tone here.', 'vonzot' ),
				),

				'menu_sticky_type' => array(
					'id' =>'_post_product_sticky',
					'label' => esc_html__( 'Stacked Images', 'vonzot' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'vonzot' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'vonzot' ),
						'no' => esc_html__( 'No', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Disable Image Zoom', 'vonzot' ),
					'id'	=> '_post_product_disable_easyzoom',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Disable image zoom on this product if it\'s enabled in the customizer.', 'vonzot' ),
				),
			),
		),
	);

	/************** Product options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'vonzot' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {
			
			$product_options[] = esc_html__( 'Not linked', 'vonzot' );
			
			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'vonzot' ) ] = 0;
		}
	}

	if ( class_exists( 'Wolf_Playlist_Manager' ) ) {
		// Player option
		$playlist_posts = get_posts( 'post_type="wpm_playlist"&numberposts=-1' );

		$playlist = array( '' => esc_html__( 'None', 'vonzot' ) );
		if ( $playlist_posts ) {
			foreach ( $playlist_posts as $playlist_options ) {
				$playlist[ $playlist_options->ID ] = $playlist_options->post_title;
			}
		} else {
			$playlist[0] = esc_html__( 'No Playlist Yet', 'vonzot' );
		}

		$product_metaboxes['product_options']['metafields'][] = array(
			'label'	=> esc_html__( 'Playlist', 'vonzot' ),
			'id'	=> '_post_product_playlist_id',
			'type'	=> 'select',
			'choices' => $playlist,
			'desc' => esc_html__( 'It will overwrite the single player.', 'vonzot' ),
		);

		$product_metaboxes['product_options']['metafields'][] = array(
			'label'	=> esc_html__( 'Playlist Skin', 'vonzot' ),
			'id'	=> '_post_product_playlist_skin',
			'type'	=> 'select',
			'choices' => array(
				'dark' => esc_html__( 'Dark', 'vonzot' ),
				'light' => esc_html__( 'Light', 'vonzot' ),
			),
		);
	}

	/************** Portfolio options ******************/
	$work_metaboxes = array(

		'work_options' => array(
			'title' => esc_html__( 'Work', 'vonzot' ),
			'page' => array( 'work' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Client', 'vonzot' ),
					'id'	=> '_work_client',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Link', 'vonzot' ),
					'id'		=> '_work_link',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Width', 'vonzot' ),
					'id'	=> '_post_width',
					'type'	=> 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'vonzot' ),
						'wide' => esc_html__( 'Wide', 'vonzot' ),
						'fullwidth' => esc_html__( 'Full Width', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'vonzot' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'centered' => esc_html__( 'Centered', 'vonzot' ),
						'sidebar-right' => esc_html__( 'Excerpt & Info at Right', 'vonzot' ),
						'sidebar-left' => esc_html__( 'Excerpt & Info at Left', 'vonzot' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Excerpt & Info Position', 'vonzot' ),
					'id'	=> '_post_work_info_position',
					'type'	=> 'select',
					'choices' => array(
						'after' => esc_html__( 'After Content', 'vonzot' ),
						'before' => esc_html__( 'Before Content', 'vonzot' ),
						'none' => esc_html__( 'Hidden', 'vonzot' ),
					),
				),

				// array(
				// 	'label'	=> esc_html__( 'Featured', 'vonzot' ),
				// 	'id'	=> '_post_featured',
				// 	'type'	=> 'checkbox',
				// 	'desc'	=> esc_html__( 'The featured image will be display bigger in the "metro" layout.', 'vonzot' ),
				// ),
			),
		),
	);


	/************** One pager options ******************/
	$one_page_metaboxes = array(
		'one_page_settings' => array(
			'title' => esc_html__( 'One-Page', 'vonzot' ),
			'page' => array( 'post', 'page', 'work', 'product' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'One-Page Navigation', 'vonzot' ),
					'id'	=> '_post_one_page_menu',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'vonzot' ),
						'replace_main_nav' => esc_html__( 'Yes', 'vonzot' ),
					),
					'desc'	=> vonzot_kses( __( 'Activate to replace the main menu by a one-page scroll navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'vonzot' ) ),
				),
				array(
					'label'	=> esc_html__( 'One-Page Bullet Navigation', 'vonzot' ),
					'id'	=> '_post_scroller',
					'type'	=> 'checkbox',
					'desc'	=> vonzot_kses( __( 'Activate to create a section scroller navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'vonzot' ) ),
				),
				array(
					'label'	=> sprintf( esc_html__( 'Enable %s animations', 'vonzot' ), 'fullPage' ),
					'id'	=> '_post_fullpage',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'vonzot' ),
						'yes' => esc_html__( 'Yes', 'vonzot' ),
					),
					'desc' => esc_html__( 'Activate to enable advanced scroll animations between sections. Some of your row setting may be disabled to suit the global page design.', 'vonzot' ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation transition', 'vonzot' ), 'fullPage' ),
					'id'	=> '_post_fullpage_transition',
					'type'	=> 'select',
					'choices' => array(
						'mix' => esc_html__( 'Special', 'vonzot' ),
						'parallax' => esc_html__( 'Parallax', 'vonzot' ),
						'fade' => esc_html__( 'Fade', 'vonzot' ),
						'zoom' => esc_html__( 'Zoom', 'vonzot' ),
						'curtain' => esc_html__( 'Curtain', 'vonzot' ),
						'slide' => esc_html__( 'Slide', 'vonzot' ),
					),
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),

				array(
					'label'	=> sprintf( esc_html__( '%s animation duration', 'vonzot' ), 'fullPage' ),
					'id'	=> '_post_fullpage_animtime',
					'type'	=> 'text',
					'placeholder' => 1000,
					'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				),
			),
		),
	);

	$all_metaboxes = array_merge(
		apply_filters( 'vonzot_body_metaboxes', $body_metaboxes ),
		apply_filters( 'vonzot_post_metaboxes', $post_metaboxes ),
		apply_filters( 'vonzot_product_metaboxes', $product_metaboxes ),
		apply_filters( 'vonzot_work_metaboxes',  $work_metaboxes ),
		apply_filters( 'vonzot_header_metaboxes', $header_metaboxes ),
		apply_filters( 'vonzot_menu_metaboxes', $menu_metaboxes ),
		apply_filters( 'vonzot_footer_metaboxes', $footer_metaboxes )
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$all_metaboxes = $all_metaboxes + apply_filters( 'vonzot_one_page_metaboxes', $one_page_metaboxes );
	}

	if ( class_exists( 'Wolf_Metaboxes' ) ) {
		new Wolf_Metaboxes( apply_filters( 'vonzot_metaboxes', $all_metaboxes ) );
	}
}
vonzot_register_metabox();
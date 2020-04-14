<?php
/**
 * Default theme options.
 *
 * @package Store Lite
 */

if ( ! function_exists( 'store_lite_get_default_theme_options' ) ) :

	/**
	 * Get default theme options
	 *
	 * @since 1.0.0
	 *
	 * @return array Default theme options.
	 */
	function store_lite_get_default_theme_options() {

		$defaults = array();
		
		
		// Home options.

		$defaults['twp_store_lite_home_sections'] 	= array(
										                
            array(
                    'home_section_type' => 'slide-banner',
                    'product_category'    => '',
                    'section_ed'		=> 'no',
                    'slider_banner_type'		=> 'category',
                    'banner_slide_buy_new_button_label_1'     => esc_html__('Buy Now','store-lite'),
                    'banner_slide_buy_new_button_label_2'     => esc_html__('Buy Now','store-lite'),
                    'banner_slide_buy_new_button_label_3'     => esc_html__('Buy Now','store-lite'),
                    'slider_autoplay'	=> 'yes',
                    'slider_dots'		=> 'no',
                    'slider_arrows'		=> 'yes',
                    'banner_slide_product_1'    => '',
                    'banner_slide_product_2'    => '',
                    'banner_slide_product_3'    => '',
                    'banner_slide_page_1'    => '',
                    'banner_slide_page_2'    => '',
                    'banner_slide_page_3'    => '',
                    'banner_slide_page_4'    => '',
                    'slider_overlay'	=> 'no',
                    'slider_banner_height'	=> 'medium',
            ),
            array(
                    'home_section_type' => 'product-category',
                    'product_category'    => '',
                    'section_ed'		=> 'no',
                    'section_title'     => esc_html__('Featured Categories','store-lite'),
                    'slider_overlay'	=> 'yes',
            ),
            array(
                    'home_section_type' => 'tab-block-1',
                    'product_category'    => '',
                    'section_title'     => esc_html__('Vertical Tab','store-lite'),
                    'section_ed'		=> 'no',
                    'slide_image_1'		=> '',
                    'slide_image_2'		=> '',
                    'slide_image_3'		=> '',
                    'image_link_1'		=> '',
                    'image_link_2'		=> '',
                    'image_link_3'		=> '',
                    'slider_autoplay'   => 'yes',
                    'slider_dots'       => 'no',
                    'slider_arrows'     => 'yes',
            ),

            array(
                    'home_section_type' => 'carousel',
                    'product_category'    => '',
                    'section_ed'		=> 'no',
                    'section_title'     => esc_html__('Carousel Posts','store-lite'),
                    'slider_autoplay'	=> 'yes',
                    'slider_dots'		=> 'no',
                    'slider_arrows'		=> 'yes',
            ),
            array(
                    'home_section_type' => 'tab-block-2',
                    'product_category'    => '',
                    'section_title'     => esc_html__('Horizontal Tab','store-lite'),
                    'section_ed'		=> 'no',
                    'slide_image_1'		=> '',
                    'slide_image_2'		=> '',
                    'slide_image_3'		=> '',
                    'image_link_1'		=> '',
                    'image_link_2'		=> '',
                    'image_link_3'		=> '',
                    'slider_autoplay'   => 'yes',
                    'slider_dots'       => 'no',
                    'slider_arrows'     => 'yes',
            ),
            array(
                    'home_section_type' => 'cta',
                    'product_category'  => '',
                    'cta_title'			=> '',
                    'section_ed'		=> 'no',
                    'cta_sub_title'		=> '',
                    'cta_button_label'	=> esc_html__('Signup Now','store-lite'),
                    'cta_button_link'	=> '',
                    'cta_bg'			=> '',
                    'slider_overlay'	=> 'no',
                    'fixed_background'	=> 'yes',
                    'cta_type'			=> 'page',
                    'slider_banner_height' => 'small',
                    'banner_slide_page_1'  => '',
            ),
            array(
                    'home_section_type' => 'best-deal-slide',
                    'product_category'  => '',
                    'section_ed'		=> 'no',
                    'section_title'     => esc_html__('Trending Hot Deals','store-lite'),
                    'section_title_2'   => esc_html__('Best Selling Items','store-lite'),
                    'slider_autoplay'	=> 'yes',
                    'slider_dots'		=> 'no',
                    'slider_arrows'		=> 'yes',
                    'enable_review_comment'     => 'yes',
                    'sorting_type'		=> 'latest',
            ),
            array(
                    'home_section_type' => 'latest-post',
                    'section_title'     => '',
                    'section_ed'		=> 'yes',
                    'slider_ed'			=> 'yes',
                    'slider_category'   => '',
                    'slider_autoplay'	=> 'yes',
                    'slider_dots'		=> 'no',
                    'slider_arrows'		=> 'yes',
                    'sidebar_layout' 	=> 'right-sidebar',
                    'latest_post_layout'=> 'index-layout-1',
            ),

             array(
                    'home_section_type' => 'latest-news',
                    'section_title'     => esc_html__('Latest News','store-lite'),
                    'post_category'     => '',
                    'section_ed'		=> 'yes',
                    'advertise_link'	=> 'no',
                    'ed_relevant_cat'	=> 'no',
                    'section_desc'		=> '',
            ),
            
            array(
                    'home_section_type' => 'testimonial',
                    'post_category'    	=> '',
                    'section_ed'		=> 'no',
                    'testimonial_content_type'		=> 'product-review',
                    'testimonial_layout'			=> 'slide',
                    'section_title'     	=> esc_html__('Kind words from our Clients','store-lite'),
                    'slider_autoplay'		=> 'yes',
                    'slider_dots'			=> 'no',
                    'slider_arrows'			=> 'yes',
                    'banner_slide_page_1'   => '',
                    'banner_slide_page_2'   => '',
                    'banner_slide_page_3'   => '',
                    'banner_slide_page_4'   => '',
            ),
            array(
                    'home_section_type' => 'client',
                    'post_category'    	=> '',
                    'slider_client_type'    => 'category',
                    'section_ed'		=> 'no',
                    'slider_autoplay'	=> 'yes',
                    'slider_dots'		=> 'no',
                    'slider_arrows'		=> 'yes',
                    'banner_slide_page_1'    => '',
                    'banner_slide_page_2'    => '',
                    'banner_slide_page_3'    => '',
                    'banner_slide_page_4'    => '',
                    'banner_slide_page_5'    => '',
                    'banner_slide_page_6'    => '',
                    'banner_slide_page_7'    => '',
                    'banner_slide_page_8'    => '',
                    'banner_slide_page_9'    => '',
                    'banner_slide_page_10'    => '',
            ),
            array(
                    'home_section_type' => 'advertise-area',
                    'advertise_link'    => '',
                    'advertise_image'   => '',
                    'section_ed'		=> 'no',
            ),
            array(
                    'home_section_type' => 'subscribe',
                    'section_ed'		=> 'no',
                    'subacribe_ed_all_page'     => 'no',
                    'section_title'     => esc_html__('Sign Up For Our Newsletter','store-lite'),
                    'section_desc'     => esc_html__('Subscribe our newsletter and get discount 20% Off','store-lite'),
                    'mailchimp_shortcode'		=> '',
            ),
            array(
                    'home_section_type' => 'info',
                    'section_ed'        => 'no',
                    'quick_info_1'    => '',
                    'quick_info_2'    => '',
                    'quick_info_3'    => '',
                    'quick_info_4'    => '',
            ),
        );

		// Theme Options
		$defaults['ed_mid_header_product_category']			= 0;
		$defaults['ed_mid_header_search']			= 1;
		$defaults['ed_mid_header_wishlist']			= 1;
		$defaults['ed_mid_header_login_reg']			= 1;
		$defaults['header_product_category_title'] 			= esc_html__( 'Shop By Categories', 'store-lite' );
		$defaults['preloader_text'] 			= esc_html__( 'Site Loading', 'store-lite' );
		$defaults['header_medai_button_label'] 			= esc_html__( 'Learn More', 'store-lite' );
		$defaults['breadcrumb_layout']				= 'simple';
		$defaults['pagination_layout']				= 'numeric';
		$defaults['ed_preloader']					= 1;
		$defaults['header_wishlist_page_link']			= esc_url( home_url().'/wishlist');
		$defaults['header_login_page_link']			= esc_url( home_url().'/login');
        $defaults['header_medai_text']          = esc_html__( 'Signup Now', 'store-lite' );
		
		// Single Posts Option.
		$defaults['ed_related_post']				= 1;
		$defaults['related_post_title']				= esc_html__('Related Post','store-lite');
		$defaults['ed_author_section']				= 1;

		// Layout Options.
		$defaults['global_sidebar_layout'] 			= 'right-sidebar';
		$defaults['store_lite_archive_layout'] 		= 'archive-layout-1';

		// Footer Options.
		$defaults['footer_column_layout'] 			= 3;
		$defaults['footer_copyright_text'] 			= esc_html__( 'Copyright All Rights Reserved.', 'store-lite' );
		$defaults['footer_newsletter_title'] 			= esc_html__( 'Sign Up For Our Newsletter', 'store-lite' );
		$defaults['footer_newsletter_desc'] 			= esc_html__( 'Subscribe our newsletter and get discount 20% Off', 'store-lite' );
		$defaults['ed_bbb_icon'] 			= 1;
		$defaults['ed_paypal_icon'] 			= 1;
		$defaults['ed_visa_icon'] 			= 1;
		$defaults['ed_mastercard_icon'] 			= 1;
		$defaults['ed_american_express_icon'] 			= 1;
		$defaults['ed_discover_icon'] 			= 1;

		// Woocommerce.
		$defaults['product_sidebar_layout']			= 'no-sidebar';
        $defaults['ed_after_add_to_cart_popup']     = 1;

		// Pass through filter.
		$defaults = apply_filters( 'store_lite_filter_default_theme_options', $defaults );

		return $defaults;

	}

endif;

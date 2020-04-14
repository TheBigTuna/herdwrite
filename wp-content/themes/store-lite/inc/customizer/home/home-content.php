<?php
/**
* Sections Repeater Options.
*
* @package Store Lite
*/

$store_lite_post_category_list = store_lite_post_category_list();
$store_lite_product_category_list = store_lite_product_category_list();
$store_lite_page_lists = store_lite_page_lists();
$store_lite_product_lists = store_lite_product_lists();
$default = store_lite_get_default_theme_options();
$home_sections = array(
    'slide-banner' => esc_html__('Slide Banner Block','store-lite'),
    'product-category' => esc_html__('Product Category Block','store-lite'),
    'tab-block-1' => esc_html__('Tab Block 1','store-lite'),
    'carousel' => esc_html__('Carousel Block','store-lite'),
    'tab-block-2' => esc_html__('Tab Block 2','store-lite'),
    'cta' => esc_html__('Call To Action Block','store-lite'),
    'best-deal-slide' => esc_html__('Best Deal Slide','store-lite'),
    'latest-post' => esc_html__('Latest Blog Block','store-lite'),
    'latest-news' => esc_html__('Latest News Block','store-lite'),
    'testimonial' => esc_html__('Testimonial Block','store-lite'),
    'client' => esc_html__('Client Block','store-lite'),
    'advertise-area' => esc_html__('Advertise Area Block','store-lite'),
    'subscribe' => esc_html__('Subscribe Block','store-lite'),
    'info' => esc_html__('Info Block','store-lite'),
    );

$home_sidebar = array(
        'right-sidebar' => esc_html__( 'Right Sidebar', 'store-lite' ),
        'left-sidebar'  => esc_html__( 'Left Sidebar', 'store-lite' ),
        'no-sidebar'    => esc_html__( 'No Sidebar', 'store-lite' ),
    );
$testimonial_layout = array(
        'slide' => esc_html__( 'Single Slide', 'store-lite' ),
        'carousel'  => esc_html__( 'Carousel Slide', 'store-lite' ),
    );
$sorting_option = array(
        'latest' => esc_html__( 'Latest Product', 'store-lite' ),
        'sellers'  => esc_html__( 'Best Sellers', 'store-lite' ),
    );
$testimonial_type = array(
        'product-review' => esc_html__( 'Product Review', 'store-lite' ),
        'post-cat'  => esc_html__( 'Post Category', 'store-lite' ),
        'page'    => esc_html__( 'Pages', 'store-lite' ),
    );
$home_layout = array(
        'index-layout-1' => esc_html__( 'Grid Layout', 'store-lite' ),
        'index-layout-2'  => esc_html__( 'Full Width Layout', 'store-lite' ),
    );

$cta_type = array(
        'page' => esc_html__( 'Page', 'store-lite' ),
        'custom'  => esc_html__( 'Custom Fields', 'store-lite' ),
    );

$store_lite_slide_banner_type = array(
        'category' => esc_html__( 'Category', 'store-lite' ),
        'product'  => esc_html__( 'Products', 'store-lite' ),
        'page'  => esc_html__( 'Page', 'store-lite' ),
    );

$store_lite_slide_banner_height = array(
        'small' => esc_html__( 'Small', 'store-lite' ),
        'medium'  => esc_html__( 'Medium', 'store-lite' ),
        'large'  => esc_html__( 'Large', 'store-lite' ),
    );

$store_lite_client_type = array(
        'category' => esc_html__( 'Category', 'store-lite' ),
        'page'  => esc_html__( 'Page', 'store-lite' ),
    );

// Slider Section.
$wp_customize->add_section( 'home_sections_repeater',
	array(
    	'title'      => esc_html__( 'Homepage Content', 'store-lite' ),
    	'priority'   => 150,
    	'capability' => 'edit_theme_options',
	)
);

// Recommended Posts Enable Disable.
$wp_customize->add_setting( 'twp_store_lite_home_sections', array(
    'sanitize_callback' => 'store_lite_sanitize_repeater',
    'default' => json_encode( $default['twp_store_lite_home_sections'] ),
));

$wp_customize->add_control(  new Store_lite_Repeater_Controler( $wp_customize, 'twp_store_lite_home_sections', 
    array(
        'section' => 'home_sections_repeater',
        'settings' => 'twp_store_lite_home_sections',
        'store_lite_box_label' => esc_html__('New Section','store-lite'),
        'store_lite_box_add_control' => esc_html__('Add New Section','store-lite'),
    ),
        array(
            'section_ed' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Section', 'store-lite' ),
                'class'       => 'home-section-ed'
            ),
            'subacribe_ed_all_page' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Subscribe Section on All Page', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs subscribe-fields'
            ),
            'home_section_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Section Type', 'store-lite' ),
                'options'     => $home_sections,
                'class'       => 'home-section-type'
            ),
            'slider_ed' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Slider', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-post-fields'
            ),
            'slider_category' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Slider Category', 'store-lite' ),
                'options'     => $store_lite_post_category_list,
                'class'       => 'home-repeater-fields-hs latest-post-fields'
            ),
            'section_title' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Section Title', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-news-fields carousel-fields tab-block-1-fields tab-block-2-fields best-deal-slide-fields testimonial-fields product-category-fields subscribe-fields'
            ),
            'section_desc' => array(
                'type'        => 'textarea',
                'label'       => esc_html__( 'Section Description', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs subscribe-fields latest-news-fields'
            ),
            'mailchimp_shortcode' => array(
                'type'        => 'textarea',
                'label'       => esc_html__( 'Mailchimp Shortcode', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs subscribe-fields'
            ),
            'quick_info_1' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Quick Info Page 1', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs info-fields'
            ),
            'quick_info_2' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Quick Info Page 2', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs info-fields'
            ),
            'quick_info_3' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Quick Info Page 3', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs info-fields'
            ),
            'quick_info_4' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Quick Info Page 4', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs info-fields'
            ),
            'slider_banner_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Slider Banner Type', 'store-lite' ),
                'options'     => $store_lite_slide_banner_type,
                'class'       => 'home-repeater-fields-hs home-ac-banner-type slide-banner-fields'
            ),
            'slider_overlay' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Overlay', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields product-category-fields cta-fields'
            ),
            'fixed_background' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Fixed Background', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields'
            ),
            'slider_banner_height' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Slider Banner Height', 'store-lite' ),
                'options'     => $store_lite_slide_banner_height,
                'class'       => 'home-repeater-fields-hs slide-banner-fields cta-fields'
            ),
            'slider_client_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Client Content Type', 'store-lite' ),
                'options'     => $store_lite_client_type,
                'class'       => 'home-repeater-fields-hs client-fields slider-client-type-ac'
            ),
            'testimonial_layout' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Testimonial Layout', 'store-lite' ),
                'options'     => $testimonial_layout,
                'class'       => 'home-repeater-fields-hs testimonial-fields'
            ),
            'testimonial_content_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Testimonial Type', 'store-lite' ),
                'options'     => $testimonial_type,
                'class'       => 'home-repeater-fields-hs testimonial-fields testimonial-content-type-ac'

            ),
            'post_category' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Post Category', 'store-lite' ),
                'options'     => $store_lite_post_category_list,
                'class'       => 'home-repeater-fields-hs carousel-posts-fields grid-posts-fields latest-news-fields slide-banner-fields testimonial-fields client-fields post-category-ac'
            ),
            'cta_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Call To Action Method', 'store-lite' ),
                'options'     => $cta_type,
                'class'       => 'home-repeater-fields-hs cta-fields cta-type-ac'
            ),
            'banner_slide_page_1' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 1', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields cta-fields testimonial-fields client-fields banner-lide-page-1-ac'
            ),
            'banner_slide_link_1' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Link 1', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields banner-slide-link-1-ac'
            ),
            'banner_slide_buy_new_button_label_1' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Button Label 1', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields btn-lbl-1-ac'
            ),
            'banner_slide_page_2' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 2', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields testimonial-fields client-fields banner-lide-page-2-ac'
            ),
            'banner_slide_link_2' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Link 2', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields banner-slide-link-2-ac'
            ),
             'banner_slide_buy_new_button_label_2' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Button Label 2', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields btn-lbl-2-ac'
            ),
            'banner_slide_page_3' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 3', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields testimonial-fields client-fields banner-lide-page-3-ac'
            ),
            'banner_slide_link_3' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Link 3', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields banner-slide-link-3-ac'
            ),
            'banner_slide_buy_new_button_label_3' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Button Label 3', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs slide-banner-fields btn-lbl-3-ac'
            ),
            'banner_slide_page_4' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 4', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs testimonial-fields client-fields banner-lide-page-4-ac'
            ),
            'banner_slide_page_5' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 5', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-5-ac'
            ),
            'banner_slide_page_6' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 6', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-6-ac'
            ),
            'banner_slide_page_7' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 7', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-7-ac'
            ),
            'banner_slide_page_8' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 8', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-8-ac'
            ),
            'banner_slide_page_9' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 9', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-9-ac'
            ),
            'banner_slide_page_10' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Page 10', 'store-lite' ),
                'options'     => $store_lite_page_lists,
                'class'       => 'home-repeater-fields-hs client-fields banner-lide-page-10-ac'
            ),
            'banner_slide_product_1' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product 1', 'store-lite' ),
                'options'     => $store_lite_product_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields prdct-1-ac'
            ),
            'banner_slide_product_2' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product 2', 'store-lite' ),
                'options'     => $store_lite_product_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields prdct-2-ac'
            ),
            'banner_slide_product_3' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product 3', 'store-lite' ),
                'options'     => $store_lite_product_lists,
                'class'       => 'home-repeater-fields-hs slide-banner-fields prdct-3-ac'
            ),
            'ed_relevant_cat' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Show Relevant Category Only', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-news-fields'
            ),
            'ed_escerpt_content' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Excerpt Content', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs multiple-category-posts-fields'
            ),
            'advertise_image' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'Advertise Image', 'store-lite' ),
                'description' => esc_html__( 'Recommended Image Size is 970x250 PX.', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs advertise-area-fields'
            ),
            'advertise_link' => array(
                'type'        => 'link',
                'label'       => esc_html__( 'Advertise Image Link', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs advertise-area-fields'
            ),
            'product_category' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Category', 'store-lite' ),
                'options'     => $store_lite_product_category_list,
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields carousel-fields best-deal-slide-fields product-category-fields'
            ),
            'enable_review_comment' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Review Comment Content', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs best-deal-slide-fields'
            ),
            'section_title_2' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Best Selling Section Title', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs best-deal-slide-fields'
            ),
            'sorting_type' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Sorting', 'store-lite' ),
                'options'     => $sorting_option,
                'class'       => 'home-repeater-fields-hs best-deal-slide-fields'
            ),
            'product_category_2' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Category Two', 'store-lite' ),
                'options'     => $store_lite_product_category_list,
                'class'       => 'home-repeater-fields-hs best-deal-slide-fields product-category-fields'
            ),
            'product_category_3' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Category Three', 'store-lite' ),
                'options'     => $store_lite_product_category_list,
                'class'       => 'home-repeater-fields-hs product-category-fields'
            ),
            'product_category_4' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Category Four', 'store-lite' ),
                'options'     => $store_lite_product_category_list,
                'class'       => 'home-repeater-fields-hs product-category-fields'
            ),
            'product_category_5' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Product Category Five', 'store-lite' ),
                'options'     => $store_lite_product_category_list,
                'class'       => 'home-repeater-fields-hs product-category-fields'
            ),
            'slider_arrows' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Arrows', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-post-fields carousel-fields slide-banner-fields best-deal-slide-fields testimonial-fields client-fields tab-block-2-fields tab-block-1-fields'
            ),
            'slider_dots' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Dots', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-post-fields carousel-fields slide-banner-fields best-deal-slide-fields testimonial-fields client-fields tab-block-2-fields tab-block-1-fields'
            ),
            'slider_autoplay' => array(
                'type'        => 'checkbox',
                'label'       => esc_html__( 'Enable Autoplay', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs latest-post-fields carousel-fields slide-banner-fields best-deal-slide-fields testimonial-fields client-fields tab-block-2-fields tab-block-1-fields'
            ),
            'sidebar_layout' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Sidebar Layout', 'store-lite' ),
                'options'     => $home_sidebar,
                'class'       => 'home-repeater-fields-hs latest-post-fields'
            ),
            'latest_post_layout' => array(
                'type'        => 'select',
                'label'       => esc_html__( 'Latest Posts Layout', 'store-lite' ),
                'options'     => $home_layout,
                'class'       => 'home-repeater-fields-hs latest-post-fields'
            ),
            'slide_image_1' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'Banner Image 1', 'store-lite' ),
                'description' => esc_html__( 'Recommended Image Size is 270x630 PX.', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'image_link_1' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Banner Image Link 1', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'slide_image_2' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'Banner Image 2', 'store-lite' ),
                'description' => esc_html__( 'Recommended Image Size is 270x630 PX.', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'image_link_2' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Banner Image Link 2', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'slide_image_3' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'Banner Image 3', 'store-lite' ),
                'description' => esc_html__( 'Recommended Image Size is 270x630 PX.', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'image_link_3' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'Banner Image Link 3', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs tab-block-1-fields tab-block-2-fields'
            ),
            'cta_title' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'CTA Title', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields cta-title-ac'
            ),
            'cta_sub_title' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'CTA Sub Title', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields cta-sub-title-ac'
            ),
            'cta_button_label' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'CTA Button Label', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields cta-button-label-ac'
            ),
            'cta_button_link' => array(
                'type'        => 'text',
                'label'       => esc_html__( 'CTA Button Link', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields cta-button-link-ac'
            ),
            'cta_bg' => array(
                'type'        => 'upload',
                'label'       => esc_html__( 'CTA Background', 'store-lite' ),
                'description' => esc_html__( 'Recommended Image Size is 270x630 PX.', 'store-lite' ),
                'class'       => 'home-repeater-fields-hs cta-fields cta-bg-ac'
            ),
            

    )
));


// Info.
$wp_customize->add_setting(
    'store_lite_notiece_info',
    array(
        'default'           => '',
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field'
    )
);
$wp_customize->add_control(
    new Store_Lite_Info_Notiece_Control( 
        $wp_customize,
        'store_lite_notiece_info',
        array(
            'settings' => 'store_lite_notiece_info',
            'section'       => 'home_sections_repeater',
            'label'         => esc_html__( 'Info', 'store-lite' ),
        )
    )
);
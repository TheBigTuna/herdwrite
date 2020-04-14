<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Store_Lite
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function store_lite_body_classes($classes)
{   
    $default = store_lite_get_default_theme_options();
    global $post;
    // Adds a class of hfeed to non-singular pages.
    if ( !is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( !is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    $global_sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout',$default['global_sidebar_layout'] ) );
    
    if ( ! is_active_sidebar( 'sidebar-1' ) ) { $global_sidebar_layout = 'no-sidebar'; }
    if( store_lite_check_woocommerce_page() ){ if ( ! is_active_sidebar( 'store-lite-woocommerce-widget' ) ) { $global_sidebar_layout = 'no-sidebar'; } }
    
    if( is_front_page() || is_single() || is_page() ){

        if( ( is_front_page() && !is_home() && is_page() ) || ( is_single() || is_page() ) ){

            if( store_lite_check_woocommerce_page() && is_product() ){

                $store_lite_post_sidebar = esc_html( get_theme_mod( 'product_sidebar_layout',$default['product_sidebar_layout'] ) );
                
            }elseif( store_lite_check_woocommerce_page() && ( is_cart() || is_checkout() ) ){
                $store_lite_post_sidebar = 'no-sidebar';
            }else{

                $store_lite_post_sidebar = esc_html( get_post_meta( $post->ID, 'store_lite_post_sidebar_option', true ) );
                if( $store_lite_post_sidebar == 'global-sidebar' || empty( $store_lite_post_sidebar ) ){ $store_lite_post_sidebar = $global_sidebar_layout; }
            }
            
            $classes[] = $store_lite_post_sidebar;

        }else{
            $default = store_lite_get_default_theme_options();
            $twp_store_lite_home_sections = get_theme_mod( 'twp_store_lite_home_sections', json_encode( $default['twp_store_lite_home_sections'] ) );
            $twp_store_lite_home_sections = json_decode( $twp_store_lite_home_sections );
            foreach( $twp_store_lite_home_sections as $store_lite_home_section ){

                $home_section_type = isset( $store_lite_home_section->home_section_type ) ? $store_lite_home_section->home_section_type : '' ;
                switch( $home_section_type ){
                    case 'latest-post':
                    $global_sidebar_layout = isset( $store_lite_home_section->sidebar_layout ) ? $store_lite_home_section->sidebar_layout : '' ;
                    break;
                }

            }
            $classes[] = $global_sidebar_layout;

        }
        
    }else{

        if( is_404() ){

            $classes[] = 'no-sidebar';

        }else{

            $classes[] = $global_sidebar_layout;

        }
    }

    if( is_search() || is_archive() || ( is_home() && !is_front_page() ) ){
        $store_lite_archive_layout = esc_html( get_theme_mod( 'store_lite_archive_layout',$default['store_lite_archive_layout'] ) );
        $classes[] = $store_lite_archive_layout;
    }

    if( is_front_page() && is_home() ){
        $latest_post_layout = '';
        $default = store_lite_get_default_theme_options();
        $twp_store_lite_home_sections = get_theme_mod( 'twp_store_lite_home_sections', json_encode( $default['twp_store_lite_home_sections'] ) );
        $twp_store_lite_home_sections = json_decode( $twp_store_lite_home_sections );
        foreach( $twp_store_lite_home_sections as $store_lite_home_section ){
            
            $home_section_type = isset( $store_lite_home_section->home_section_type ) ? $store_lite_home_section->home_section_type : '' ;
            switch( $home_section_type ){
                case 'latest-post':
                $latest_post_layout = isset( $store_lite_home_section->latest_post_layout ) ? $store_lite_home_section->latest_post_layout : '' ;
                break;
            }
        }
        $classes[] = $latest_post_layout;
    }

    if( has_header_video() ){
        $classes[] = 'twp-has-video';
    }
    if( has_header_image() ){
        $classes[] = 'twp-has-image';
    }

    return $classes;
}

add_filter('body_class', 'store_lite_body_classes');

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function store_lite_pingback_header()
{
    if ( is_singular() && pings_open() ) {
        printf('<link rel="pingback" href="%s">', esc_url( get_bloginfo('pingback_url') ) );
    }
}

add_action('wp_head', 'store_lite_pingback_header');

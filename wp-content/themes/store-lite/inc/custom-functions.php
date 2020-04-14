<?php
/**
* Custom Functions.
*
* @package Store Lite
*/

if( !function_exists( 'store_lite_fonts_url' ) ) :

    //Google Fonts URL
    function store_lite_fonts_url(){

        $fonts_url = '';
        $fonts = array();

        $store_lite_font_1 = 'Open+Sans:300,300i,400,400i,600,600i,700,700i';

        $store_lite_fonts = array();
        $store_lite_fonts[] = $store_lite_font_1;

        $store_lite_fonts_stylesheet = '//fonts.googleapis.com/css?family=';

        $i = 0;
        for ( $i = 0; $i < count( $store_lite_fonts ); $i++ ) {

            if ( 'off' !== sprintf( _x( 'on', '%s font: on or off', 'store-lite' ), $store_lite_fonts[$i] ) ) {
                $fonts[] = $store_lite_fonts[$i];
            }

        }

        if ( $fonts ) {
            $fonts_url = add_query_arg( array(
                'family' => urldecode( implode( '|', $fonts ) ),
            ), 'https://fonts.googleapis.com/css' );
        }

        return esc_url_raw($fonts_url);
    }

endif;

if( !function_exists( 'store_lite_post_category_list' ) ) :

    // Post Category List.
    function store_lite_post_category_list(){

        $post_cat_lists = get_categories(
            array(
                'hide_empty' => '0',
                'exclude' => '1',
            )
        );

        $post_cat_cat_array = array();
        $post_cat_cat_array[''] = esc_html__( '--Select Category--','store-lite' );

        foreach ( $post_cat_lists as $post_cat_list ) {

            $post_cat_cat_array[$post_cat_list->slug] = $post_cat_list->name;

        }

        return $post_cat_cat_array;
    }

endif;


if( !function_exists( 'store_lite_product_category_list' ) ) :

    // Post Category List.
    function store_lite_product_category_list(){

        $post_cat_lists = get_categories(
            array(
                'taxonomy'     => 'product_cat',
                'orderby'      => 'name',
                'show_count'   => 0,
                'pad_counts'   => 0,
                'hide_empty' => '0',
                'exclude' => '1',
            )
        );

        $post_cat_cat_array = array();
        $post_cat_cat_array[''] = esc_html__( '--Select Category--','store-lite' );

        foreach ( $post_cat_lists as $post_cat_list ) {

            $post_cat_cat_array[$post_cat_list->slug] = $post_cat_list->name;

        }

        return $post_cat_cat_array;
    }

endif;

if( !function_exists( 'store_lite_sanitize_sidebar_option' ) ) :

    // Sidebar Option Sanitize.
    function store_lite_sanitize_sidebar_option( $input ){
        $metabox_options = array( 'global-sidebar','left-sidebar','right-sidebar','no-sidebar' );
        if( in_array( $input,$metabox_options ) ){
            return $input;
        }
        else{
            return '';
        }
    }

endif;


if( !function_exists( 'store_lite_sanitize_image_option' ) ) :

    // Sidebar Option Sanitize.
    function store_lite_sanitize_image_option( $input ){
        $metabox_options = array( 'global-image','enable-image','disable-image' );
        if( in_array( $input,$metabox_options ) ){
            return $input;
        }
        else{
            return '';
        }
    }

endif;

if( !function_exists( 'store_lite_posts_navigation' ) ) :

     // Posts Navigations.
    function store_lite_posts_navigation(){

        $default = store_lite_get_default_theme_options();
        $pagination_layout = esc_html( get_theme_mod( 'pagination_layout',$default['pagination_layout'] ) );

        if( $pagination_layout == 'classic' ){
            the_posts_navigation();
        }else{
            the_posts_pagination();
        }

    }

endif;

if( !function_exists( 'store_lite_breadcrumb' ) ) :

    // Trail Breadcrumb.
    function store_lite_breadcrumb(){ ?>

        <div class="twp-inner-banner">
            <div class="wrapper">

                <?php 
                $default = store_lite_get_default_theme_options();
                $breadcrumb_layout = get_theme_mod('breadcrumb_layout',$default['breadcrumb_layout']);

                if( $breadcrumb_layout != 'disable' && !is_front_page() ):
                        breadcrumb_trail();
                endif; ?>

                <div class="twp-banner-details">

                    <?php
                    if( is_single() || is_page() ){

                        while (have_posts()) :
                            the_post();

                            if ( 'post' === get_post_type() ){
                                echo '<div class="entry-meta entry-meta-category">';
                                store_lite_entry_footer( $cats = true,$tags = false,$edits = false );
                                echo '</div>';
                            }

                            echo '<header class="entry-header">';
                            
                                echo '<h1 class="entry-title entry-title-big">';
                                the_title();
                                echo '</h1>';

                                if ( 'post' === get_post_type() ){ ?>

                                    <div class="entry-meta">
                                        <?php
                                        store_lite_posted_by();
                                        echo "<span class='sep-date-author'><i class='ion ion-ios-remove'></i></span>";
                                        store_lite_posted_on();
                                        ?>
                                    </div><!-- .entry-meta -->

                                <?php }

                                echo "</header>";

                            $store_lite_post_image = esc_html( get_post_meta( get_the_ID(), 'store_lite_post_image_option', true ) );

                            if( $store_lite_post_image == 'global-image' || $store_lite_post_image == '' ){

                                $ed_featured_image = get_theme_mod('ed_featured_image');
                                if( $ed_featured_image ){

                                    $ed_featured_image = false;

                                }else{

                                    $ed_featured_image = true;

                                }

                            }elseif( $store_lite_post_image == 'disable-image'){

                                $ed_featured_image = false;

                            }else{

                                $ed_featured_image = true;

                            }

                            if( $ed_featured_image ){
                                store_lite_post_thumbnail();
                            }

                            if( has_excerpt() ){
                                echo '<div class="twp-banner-excerpt">';
                                the_excerpt();
                                echo '</div>';
                            }

                        endwhile;

                    }

                    if( is_archive() ){ ?>
                        
                        <header class="page-header">
                            <?php
                            the_archive_title( '<h1 class="page-title">', '</h1>' );
                            the_archive_description( '<div class="archive-description">', '</div>' );
                            ?>
                        </header><!-- .page-header -->

                    <?php 
                    }

                    if( is_search() ){ ?>

                        <header class="page-header">
                            <h1 class="page-title">
                                <?php
                                /* translators: %s: search query. */
                                printf( esc_html__( 'Search Results for: %s', 'store-lite' ), '<span>' . get_search_query() . '</span>' );
                                ?>
                            </h1>
                        </header><!-- .page-header -->

                    <?php } ?>

                </div>

            </div>
        </div>
    <?php
    }

endif;
add_action( 'store_lite_header_banner_x','store_lite_breadcrumb',20 );

if( !function_exists('store_lite_post_formate_icon') ):

    // Post Formate Icon.
    function store_lite_post_formate_icon( $formate ){

        if( $formate == 'video' ){
            $icon = 'ion-ios-play';
        }elseif( $formate == 'audio' ){
            $icon = 'ion-ios-musical-notes';
        }elseif( $formate == 'gallery' ){
            $icon = 'ion-md-images';
        }elseif( $formate == 'quote' ){
            $icon = 'ion-md-quote';
        }elseif( $formate == 'image' ){
            $icon = 'ion-ios-camera';
        }else{
            $icon = '';
        }

        return $icon;
    }

endif;

if( !function_exists('store_lite_check_woocommerce_page') ):
    
    // Check if woocommerce pages.
    function store_lite_check_woocommerce_page(){

        if( !class_exists( 'WooCommerce' ) ):
            return false;
        endif;

        if( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ){
            return true;
        }else{
            return false;
        }

    }
endif;

if( !function_exists('store_lite_page_lists') ):

    // Page Lists
    function store_lite_page_lists(){

        $pages = get_pages();

        $page_list = array();
        $page_list[] = esc_html__('--Select Page--','store-lite');

        if( $pages ){

            foreach( $pages as $page ){
                $page_list[$page->ID] = $page->post_title;
            }
        }

        return $page_list;
    }

endif;

if( !function_exists('store_lite_product_lists') ){

    // Products List
    function store_lite_product_lists(){

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
        );
        $product_list = array();
        $product_list[] = esc_html__('--Select Product--','store-lite');
        $products = new WP_Query( $args );

        if( $products->have_posts() ):

            while ( $products->have_posts() ) : $products->the_post();

               $product_list[ get_the_ID() ] = get_the_title();

            endwhile;

            wp_reset_query();

        endif;

        return $product_list;
    }

}

if ( ! function_exists( 'store_lite_cart_subtotal_escape' ) ) :
    
    /**
    * Sanitise Cart Subtotal
    */
    function store_lite_cart_subtotal_escape($input){

        $all_tags = array(
            'span'=>array(
                'class'=>array()
            )
         );
        return wp_kses($input,$all_tags);
        
    }
endif;

if( !function_exists('store_lite_assign_menu') ):
   
    // Assign menus to their locations.
    function store_lite_assign_menu() {
        
        $main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
        $main_menu = get_term_by( 'name', 'Secondary Menu', 'nav_menu' );
        $main_menu = get_term_by( 'name', 'Top Menu', 'nav_menu' );
        $footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );
        $social_menu = get_term_by( 'name', 'Social Menu', 'nav_menu' );
        set_theme_mod( 'nav_menu_locations', array(
                'twp-primary-menu' => $main_menu->term_id,
                'twp-secondary-menu' => $main_menu->term_id,
                'twp-top-menu' => $main_menu->term_id,
                'twp-footer-menu' => $footer_menu->term_id,
                'twp-social-menu' => $social_menu->term_id,
            )
        );
    }
endif;
add_action( 'pt-ocdi/after_import', 'store_lite_assign_menu' );
<?php
/**
* Tab Block 1 Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_tab_block_1' ) ):

    // Header Featured Post.
    function store_lite_tab_block_1( $store_lite_home_section,$repeat_times ){

        $categories = '';
        $product_category = isset( $store_lite_home_section->product_category ) ? $store_lite_home_section->product_category : '' ;
        $cat_array = array();
        $cat_array[] = $product_category;
        
        $tab_1_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;

        $slide_image_1 = isset( $store_lite_home_section->slide_image_1 ) ? $store_lite_home_section->slide_image_1 : '' ;
        $slide_image_2 = isset( $store_lite_home_section->slide_image_2 ) ? $store_lite_home_section->slide_image_2 : '' ;
        $slide_image_3 = isset( $store_lite_home_section->slide_image_3 ) ? $store_lite_home_section->slide_image_3 : '' ;

        $image_link_1 = isset( $store_lite_home_section->image_link_1 ) ? $store_lite_home_section->image_link_1 : '' ;
        $image_link_2 = isset( $store_lite_home_section->image_link_2 ) ? $store_lite_home_section->image_link_2 : '' ;
        $image_link_3 = isset( $store_lite_home_section->image_link_3 ) ? $store_lite_home_section->image_link_3 : '' ;

        $ed_slider_autoplay = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_dots     = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
        $ed_slider_arrows   = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;

        if ( $ed_slider_autoplay != 'no' ) {
            $autoplay = 'true';
        }else{
            $autoplay = 'false';
        }
        if( $ed_slider_dots != 'no' ) {
            $dots = 'true';
        }else {
            $dots = 'false';
        }
        if( $ed_slider_arrows != 'no' ) {
            $arrows = 'true';
        }else {
            $arrows = 'false';
        }
        if( is_rtl() ) {
            $rtl = 'true';
        }else{
            $rtl = 'false';
        }

        if( empty( $slide_image_1 ) && empty( $slide_image_2 ) && empty( $slide_image_3 ) ){
            $wraper_class = 'col-md-10';
        }else{
            $wraper_class = 'col-md-7';
        }

        if( $product_category ){

            $term = get_term_by('slug', $product_category, 'product_cat');
            if( $term ){
                $categories = get_terms( 'product_cat', ['child_of' => $term->term_id] );
            }

            if( $categories ){
                foreach( $categories as $category ){
                    $cat_array[] = $category->slug;
                }
            }

        }

        if( $product_category ){
            
            $tab_1_product_query = new WP_Query(
                array( 
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $product_category,
                            ),
                        ),
                ) 
            );

        }else{

             $tab_1_product_query = new WP_Query(
                array( 
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                ) 
            );

        } ?>
        
        <div class="twp-blocks twp-block-1">
            <div class="container">
                <?php
                if( $tab_1_title ){ ?>
                    <header class="block-title-wrapper">
                        <h2 class="block-title">
                            <?php echo esc_html( $tab_1_title ); ?>
                        </h2>
                    </header>
                <?php } ?>

                <div class="row row-collapse light-bg">
                    
                    <div class="col-md-2 col-sm-3">
                        <div class="twp-categories-list">
                            <ul class="nav twp-nav-tabs twp-tabs-vertical" role="tablist">
                                
                                <li role="presentation"  class="active">
                                    <a tab-layout="vertical" class="content-added" href="#new-arrive-<?php echo absint( $repeat_times ) ?>" indicator="new-arrive" main-cat="<?php echo esc_attr( $product_category ); ?>" aria-controls="new-arrive-<?php echo absint( $repeat_times ) ?>" role="tab" data-toggle="tab"><?php esc_html_e('New Arrivals','store-lite'); ?></a>
                                </li>
                                <li role="presentation">
                                    <a tab-layout="vertical" href="#twp-best-seller-<?php echo absint( $repeat_times ) ?>" indicator="twp-best-seller" main-cat="<?php echo esc_attr( $product_category ); ?>" aria-controls="twp-best-seller-<?php echo absint( $repeat_times ) ?>" role="tab" data-toggle="tab"><?php esc_html_e('Best Sellers','store-lite'); ?></a>
                                </li>

                                <li role="presentation">
                                    <a tab-layout="vertical" href="#best-deals-<?php echo absint( $repeat_times ) ?>" indicator="best-deals" main-cat="<?php echo esc_attr( $product_category ); ?>" aria-controls="best-deals-<?php echo absint( $repeat_times ) ?>" role="tab" data-toggle="tab"><?php esc_html_e('Best Deals','store-lite'); ?></a>
                                </li>
                                <?php
                                if( $categories ){
                                    foreach( $categories as $category ){ ?>
                                        <li role="presentation">
                                            <a tab-layout="vertical" href="#<?php echo esc_attr( $category->slug.'-'.$repeat_times ); ?>" indicator="other-cat" main-cat="<?php echo esc_attr( $category->slug ); ?>" aria-controls="<?php echo esc_attr( $category->slug ); ?>-<?php echo absint( $repeat_times ) ?>" role="tab" data-toggle="tab"><?php echo esc_html( $category->name ); ?></a>
                                        </li>
                                    <?php }
                                } ?>

                            </ul>

                        </div>
                    </div>

                    <?php if( $slide_image_1 || $slide_image_2 || $slide_image_3 ){

                     ?>
                        <div class="col-md-3 hidden-sm hidden-xs">
                            <div class="twp-lead-images">
                                <div class="twp-lead-slider nav-slider-hidden slick-dotted" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "arrows": <?php echo esc_attr( $arrows ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                                    <?php if( $slide_image_1 ){

                                        $attach_id_1 = attachment_url_to_postid( $slide_image_1 );
                                        $slide_image_1 = wp_get_attachment_image_src($attach_id_1, 'full')[0];
                                        $thumb_alt_1 = get_post_meta( $attach_id_1, '_wp_attachment_image_alt', true ); ?>
                                        <div class="twp-lead-items">
                                            <div class="twp-lead-image">
                                                <a href="<?php echo esc_url( $image_link_1 ); ?>" class="bg-image bg-image-lead">
                                                    <img src="<?php echo esc_url( $slide_image_1 ); ?>" alt="<?php echo esc_attr( $thumb_alt_1 ); ?>" title="<?php echo esc_attr( $thumb_alt_1 ); ?>" >
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if( $slide_image_2 ){

                                        $attach_id_2 = attachment_url_to_postid( $slide_image_2 );
                                        $slide_image_2 = wp_get_attachment_image_src($attach_id_2, 'full')[0];
                                        $thumb_alt_2 = get_post_meta( $attach_id_2, '_wp_attachment_image_alt', true ); ?>
                                        <div class="twp-lead-items">
                                            <div class="twp-lead-image">
                                                <a href="<?php echo esc_url( $image_link_2 ); ?>" class="bg-image bg-image-lead">
                                                    <img src="<?php echo esc_url( $slide_image_2 ); ?>" alt="<?php echo esc_attr( $thumb_alt_2 ); ?>" title="<?php echo esc_attr( $thumb_alt_2 ); ?>" >
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if( $slide_image_3 ){

                                        $attach_id_3 = attachment_url_to_postid( $slide_image_3 );
                                        $slide_image_3 = wp_get_attachment_image_src($attach_id_3, 'full')[0]; 
                                        $thumb_alt_3 = get_post_meta( $attach_id_3, '_wp_attachment_image_alt', true ); ?>
                                        <div class="twp-lead-items">
                                            <div class="twp-lead-image">
                                                <a href="<?php echo esc_url( $image_link_3 ); ?>" class="bg-image bg-image-lead">
                                                    <img src="<?php echo esc_url( $slide_image_3 ); ?>" alt="<?php echo esc_attr( $thumb_alt_3 ); ?>" title="<?php echo esc_attr( $thumb_alt_3 ); ?>" >
                                                </a>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="<?php echo esc_attr( $wraper_class ); ?> col-sm-9">
                        <div class="tab-content twp-tab-content clearfix">

                            <?php 
                            if( $tab_1_product_query->have_posts() ){ ?>

                                <div role="tabpanel" class="tab-pane active" id="new-arrive-<?php echo absint( $repeat_times ) ?>">
                                    <div class="twp-products-wrapper">
                                        <ul class="twp-products-list clearfix">

                                            <?php
                                            while( $tab_1_product_query->have_posts() ){
                                                $tab_1_product_query->the_post();
                                                
                                                    wc_get_template_part( 'content', 'product' );

                                            } ?>

                                        </ul>
                                    </div>
                                </div>

                            <?php wp_reset_postdata();
                            } ?>

                            <div role="tabpanel" class="tab-pane" id="twp-best-seller-<?php echo absint( $repeat_times ) ?>">
                                <ul class="twp-products-list clearfix">

                                </ul>
                            </div>

                            
                            <div role="tabpanel" class="tab-pane" id="best-deals-<?php echo absint( $repeat_times ) ?>">
                                <ul class="twp-products-list clearfix">

                                </ul>
                            </div>

                            <?php
                            if( $product_category && $categories ){
                                foreach( $categories as $category ){ ?>
                                    <div role="tabpanel" class="tab-pane" id="<?php echo esc_attr( $category->slug.'-'.$repeat_times ); ?>">
                                        <ul class="twp-products-list clearfix">
                                                
                                        </ul>
                                    </div>
                                <?php }
                            } ?>
                            
                        </div>

                    </div>

                </div>
            </div>
        </div>
    
    <?php
    }

endif;
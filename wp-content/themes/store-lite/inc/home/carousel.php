<?php
/**
* Carousel Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_tab_carousel' ) ):

    // Header Featured Post.
    function store_lite_tab_carousel( $store_lite_home_section,$repeat_times ){

        $product_category = isset( $store_lite_home_section->product_category ) ? $store_lite_home_section->product_category : '' ;
        $section_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
        $ed_slider_autoplay = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_dots = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
        $ed_slider_arrows  = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;

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
        if( is_rtl() ) {
            $rtl = 'true';
        }else{
            $rtl = 'false';
        }

        if( $product_category ){

            $tab_product_query = new WP_Query(
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

            $tab_product_query = new WP_Query(
                array( 
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                ) 
            );

        } ?>
        
        <div class="twp-blocks twp-blocks-alt twp-block-carousal">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <header class="block-title-header">
                            <div class="block-title-wrapper">

                                <?php if( $section_title ){ ?>
                                    <h2 class="block-title">
                                        <?php echo esc_html( $section_title ); ?>
                                    </h2>
                                <?php } ?>

                                <?php if( $ed_slider_arrows != 'no' ){ ?>
                                    <div class="title-controls">
                                        <div class="slide-icon-1 slide-prev-1-<?php echo absint($repeat_times); ?> slick-arrow">
                                            <i class="ion-ios-arrow-back slick-arrow"></i>
                                        </div>
                                        <div class="slide-icon-1 slide-next-1-<?php echo absint($repeat_times); ?> slick-arrow">
                                            <i class="ion-ios-arrow-forward slick-arrow"></i>
                                        </div>
                                    </div>
                                <?php } ?>

                            </div>
                            <div class="twp-seperator"></div>
                        </header>
                    </div>

                    <?php 
                    if( $tab_product_query->have_posts() ){ ?>

                        <div class="col-md-12">
                            <div loop-count="<?php echo absint($repeat_times); ?>" class="twp-carousel carousel-space" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                                <?php
                                while( $tab_product_query->have_posts() ){
                                    $tab_product_query->the_post();

                                    wc_get_template_part( 'content', 'product' );

                                } ?>

                            </div>
                        </div>

                    <?php wp_reset_postdata();
                    } ?>

                </div>
            </div>
        </div>
    
    <?php
    }

endif;
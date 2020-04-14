<?php
/**
* Client Function.
*
* @package Store Lite
*/

if( !function_exists('store_lite_client') ):

    // Recommended Posts Functions.
    function store_lite_client( $store_lite_home_section ){

        $client_post_category = isset( $store_lite_home_section->post_category ) ? $store_lite_home_section->post_category : '' ;
        $slider_client_type = isset( $store_lite_home_section->slider_client_type ) ? $store_lite_home_section->slider_client_type : '' ;
        $banner_slide_page_1 = isset( $store_lite_home_section->banner_slide_page_1 ) ? $store_lite_home_section->banner_slide_page_1 : '' ;
        $banner_slide_page_2 = isset( $store_lite_home_section->banner_slide_page_2 ) ? $store_lite_home_section->banner_slide_page_2 : '' ;
        $banner_slide_page_3 = isset( $store_lite_home_section->banner_slide_page_3 ) ? $store_lite_home_section->banner_slide_page_3 : '' ;
        $banner_slide_page_4 = isset( $store_lite_home_section->banner_slide_page_4 ) ? $store_lite_home_section->banner_slide_page_4 : '' ;
        $banner_slide_page_5 = isset( $store_lite_home_section->banner_slide_page_5 ) ? $store_lite_home_section->banner_slide_page_5 : '' ;
        $banner_slide_page_6 = isset( $store_lite_home_section->banner_slide_page_6 ) ? $store_lite_home_section->banner_slide_page_6 : '' ;
        $banner_slide_page_7 = isset( $store_lite_home_section->banner_slide_page_7 ) ? $store_lite_home_section->banner_slide_page_7 : '' ;
        $banner_slide_page_8 = isset( $store_lite_home_section->banner_slide_page_8 ) ? $store_lite_home_section->banner_slide_page_8 : '' ;
        $banner_slide_page_9 = isset( $store_lite_home_section->banner_slide_page_9 ) ? $store_lite_home_section->banner_slide_page_9 : '' ;
        $banner_slide_page_10 = isset( $store_lite_home_section->banner_slide_page_10 ) ? $store_lite_home_section->banner_slide_page_10 : '' ;
        $ed_slider_autoplay    = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_arrows  = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;
        $ed_slider_dots    =  isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;

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

        $page_array = array( $banner_slide_page_1,$banner_slide_page_2,$banner_slide_page_3,$banner_slide_page_4,$banner_slide_page_5,$banner_slide_page_6,$banner_slide_page_7,$banner_slide_page_8,$banner_slide_page_9,$banner_slide_page_10 );
        

        if( $client_post_category || $banner_slide_page_1 || $banner_slide_page_2 || $banner_slide_page_3 || $banner_slide_page_4 || $banner_slide_page_5 || $banner_slide_page_6 || $banner_slide_page_7 || $banner_slide_page_8 || $banner_slide_page_9 || $banner_slide_page_10 ){ ?>

            <div class="twp-clients twp-blocks twp-blocks-alt">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <div class="twp-clients-carousal nav-slider-hidden" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "arrows": <?php echo esc_attr( $arrows ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                                <?php
                                if( $slider_client_type == 'category' ){

                                    $client_post_query = new WP_Query( array( 'post_type' => 'post','posts_per_page' => 10, 'category_name' => esc_html( $client_post_category ) ) );

                                    if( $client_post_query->have_posts() ):

                                        while( $client_post_query->have_posts() ){
                                            $client_post_query->the_post();
                                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );

                                            if( $featured_image[0] ){ ?>

                                                <div class="clients-items">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <img src="<?php echo esc_url( $featured_image[0] ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                    </a>
                                                </div>

                                            <?php
                                            }
                                        }
                                        wp_reset_postdata();
                                    endif;

                                }else{

                                    foreach( $page_array as $post_id ){

                                        if( $post_id ){

                                            $client_post_query_2 = new WP_Query( array( 'post_type' => 'page','posts_per_page' => 10, 'post__in' => array( $post_id ) ) );

                                            if( $client_post_query_2->have_posts() ):

                                                while( $client_post_query_2->have_posts() ){
                                                    $client_post_query_2->the_post();
                                                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );

                                                    if( $featured_image[0] ){ ?>

                                                        <div class="clients-items">
                                                            <a href="<?php the_permalink(); ?>">
                                                                <img src="<?php echo esc_url( $featured_image[0] ); ?>" title="<?php the_title_attribute(); ?>" alt="<?php the_title_attribute(); ?>">
                                                            </a>
                                                        </div>

                                                    <?php
                                                    }
                                                }
                                                wp_reset_postdata();

                                            endif;

                                        }

                                    }


                                } ?>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        <?php
        }
    }

endif;
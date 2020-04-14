<?php
/**
* Info Function.
*
* @package Store Lite
*/

if( !function_exists('store_lite_info') ):

    function store_lite_info( $store_lite_home_section ){

        $footer_quick_info_page_1 = isset( $store_lite_home_section->quick_info_1 ) ? $store_lite_home_section->quick_info_1 : '' ;
        $footer_quick_info_page_2 = isset( $store_lite_home_section->quick_info_2 ) ? $store_lite_home_section->quick_info_2 : '' ;
        $footer_quick_info_page_3 = isset( $store_lite_home_section->quick_info_3 ) ? $store_lite_home_section->quick_info_3 : '' ;
        $footer_quick_info_page_4 = isset( $store_lite_home_section->quick_info_4 ) ? $store_lite_home_section->quick_info_4 : '' ;

        $page_array = array( $footer_quick_info_page_1,$footer_quick_info_page_2,$footer_quick_info_page_3,$footer_quick_info_page_4 );
        
        ?>
        <div class="twp-blocks twp-blocks-bg twp-info-block">

            <div class="upper-footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="quickinfo-block">
                                <div class="row">

                                    <?php
                                    foreach( $page_array as $post_id ){

                                        if( $post_id ){

                                            $quick_info_query = new WP_Query( array( 'post_type' => 'page','posts_per_page' => 4, 'post__in' => array( $post_id ) ) );

                                            if( $quick_info_query->have_posts() ):
                                                while( $quick_info_query->have_posts() ){

                                                    $quick_info_query->the_post();
                                                    $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' ); ?>

                                                    <div class="col-lg-3 col-md-6 col-sm-6 quickinfo-block-grid">
                                                        <div class="quickinfo-single">

                                                            <?php if( $featured_image[0] ){ ?>
                                                                <div class="quickinfo-icon">
                                                                    <img src="<?php echo esc_url( $featured_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                                </div>
                                                            <?php } ?>

                                                            <div class="quickinfo-details">
                                                                <h3 class="quickinfo-title">
                                                                    <?php the_title(); ?>
                                                                </h3>
                                                                <div class="quickinfo-desc">
                                                                    <?php if( has_excerpt() ){

                                                                      the_excerpt();

                                                                    }else{

                                                                        if( get_the_content() ){

                                                                            echo wp_kses_post( wp_trim_words( get_the_content(),20,'...') );

                                                                        }

                                                                    } ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                                }
                                                wp_reset_postdata();
                                            endif;

                                        }


                                    } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    <?php
    }

endif;
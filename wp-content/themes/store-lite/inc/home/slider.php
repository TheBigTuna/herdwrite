<?php
/**
* Slider Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_slider' ) ):

    // Header Slider
    function store_lite_slider( $store_lite_home_section ){

        $ed_slider  = isset( $store_lite_home_section->slider_ed ) ? $store_lite_home_section->slider_ed : '' ;
        

        if( $ed_slider != 'no' ) {
            
            $slider_category = isset( $store_lite_home_section->slider_category ) ? $store_lite_home_section->slider_category : '' ;
            $slider_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4, 'category_name' => esc_html( $slider_category ) ) );

            if ( $slider_query->have_posts() ):

                $ed_slider_autoplay = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
                $ed_slider_dots = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
                $ed_slider_arrows = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;

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

                ?>
                <div class="latest-slider" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "arrows": <?php echo esc_attr( $arrows ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                    <?php while( $slider_query->have_posts() ):

                        $slider_query->the_post();
                        $slider_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'large' ); ?>

                        <div class="slide-item">
                            <a href="<?php the_permalink(); ?>" class="slide-bg data-bg" data-background="<?php echo esc_url( $slider_image[0] ); ?>"></a>
                            <div class="slide-details">

                                <div class="entry-meta entry-meta-category">
                                    <?php store_lite_entry_footer( $cats = true,$tags = false ); ?>
                                </div>
                                
                                <h2 class="entry-title entry-title-medium">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h2>
                            </div>
                        </div>

                    <?php endwhile; ?>

                </div>
                <?php
                wp_reset_postdata();
            endif;
        }
    }

endif;
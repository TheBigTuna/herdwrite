<?php
/**
 * Testimonial Function.
 *
 * @package Store Lite
 */


if (!function_exists('store_lite_testimonial')):

    // Testimonial Function
    function store_lite_testimonial($store_lite_home_section)
    {
        $testimonial_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
        $testimonial_type = isset( $store_lite_home_section->testimonial_content_type ) ? $store_lite_home_section->testimonial_content_type : '' ;
        $testimonial_layout = isset( $store_lite_home_section->testimonial_layout ) ? $store_lite_home_section->testimonial_layout : '' ;
        $post_category = isset( $store_lite_home_section->post_category ) ? $store_lite_home_section->post_category : '' ;
        $banner_slide_page_1 = isset( $store_lite_home_section->banner_slide_page_1 ) ? $store_lite_home_section->banner_slide_page_1 : '' ;
        $banner_slide_page_2 = isset( $store_lite_home_section->banner_slide_page_2 ) ? $store_lite_home_section->banner_slide_page_2 : '' ;
        $banner_slide_page_3 = isset( $store_lite_home_section->banner_slide_page_3 ) ? $store_lite_home_section->banner_slide_page_3 : '' ;
        $banner_slide_page_4 = isset( $store_lite_home_section->banner_slide_page_4 ) ? $store_lite_home_section->banner_slide_page_4 : '' ;
        $ed_slider_autoplay    = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_dots    = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
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

        $page_array = array($banner_slide_page_1, $banner_slide_page_2, $banner_slide_page_3, $banner_slide_page_4);

        if ($testimonial_layout == 'carousel') {
            $layout_class = 'testimonials-carousal carousel-space';
        } else {
            $layout_class = 'testimonials-slider';
        }

        $comments = get_comments(
            array(
                'number' => 4,
                'status' => 'approve',
                'post_status' => 'publish',
                'post_type' => 'product',
                'parent' => 0,
            )
        ); // WPCS: override ok.

        ?>
        <div class="twp-blocks twp-blocks-bg twp-testmonials">
            <div class="container">
                <?php if ($testimonial_title) { ?>
                    <div class="row">
                        <div class="col-md-12">
                            <header class="block-title-header-2">
                                <div class="block-title-wrapper">
                                    <h2 class="block-title">
                                        <?php echo esc_html($testimonial_title); ?>
                                    </h2>
                                </div>
                            </header>
                        </div>
                    </div>
                <?php } ?>

                <div class="row">
                    <div class="col-md-12">
                        <div class="<?php echo esc_attr($layout_class); ?> nav-slider-hidden" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "arrows": <?php echo esc_attr( $arrows ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                            <?php if ( $testimonial_type == 'product-review' && $comments ) {

                                echo wp_kses_post( apply_filters( 'woocommerce_before_widget_product_review_list','' ) );
                                foreach ((array)$comments as $comment) {

                                    $image_url = get_avatar_url( $comment->comment_author_email , array( 'size' => '200' ) );
                                    $rating = absint(get_post_meta($comment->comment_post_ID, '_wc_average_rating', true)); ?>
                                    <div class="testimonials-items">
                                        <div class="testimonials-caption">

                                            <?php if(  $testimonial_layout == 'slide' && $image_url ){ ?>
                                                <div class="twp-author-avatar bg-image">
                                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_html_e('Reviewer Avatar','store-lite'); ?>" title="<?php esc_html_e('Reviewer Avatar','store-lite'); ?>" >
                                                </div>
                                            <?php } ?>

                                            <?php if ($rating) { ?>
                                                <div class="twp-item-ratings">
                                                    <?php $percent = $rating * 2 * 10; ?>
                                                    <div class="star-rating" role="img" aria-label="<?php esc_html_e('Rated', 'store-lite'); ?> <?php echo absint($rating); ?> <?php esc_html_e('out of 5', 'store-lite'); ?>">
                                                        
                                                        <span style="width:<?php echo absint($percent); ?>%">

                                                            <?php esc_html_e('Rated', 'store-lite'); ?>
                                                            <strong class="rating"><?php echo absint($rating); ?> </strong>
                                                            <?php esc_html_e('out of 5', 'store-lite'); ?>

                                                        </span>

                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div class="testimonials-lead">
                                                <?php echo esc_html($comment->comment_content); ?>
                                            </div>
                                        </div>
                                        <div class="testimonials-author">
                                            
                                            <?php if( $testimonial_layout == 'carousel' && $image_url ){ ?>
                                                <div class="twp-author-avatar bg-image">
                                                    <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php esc_html_e('Reviewer Avatar','store-lite'); ?>" title="<?php esc_html_e('Reviewer Avatar','store-lite'); ?>" >
                                                </div>
                                            <?php } ?>

                                            <div class="twp-author-desc">
                                                <strong><?php echo esc_html($comment->comment_author); ?></strong>
                                                <?php esc_html_e('on', 'store-lite'); ?>
                                                <a href="<?php echo esc_url(get_permalink($comment->comment_post_ID)); ?>">
                                                    <?php echo get_the_title($comment->comment_post_ID); ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php }
                                echo wp_kses_post( apply_filters( 'woocommerce_after_widget_product_review_list','' ) );
                            }

                            if ( $testimonial_type == 'page' && ( $banner_slide_page_1 || $banner_slide_page_1 || $banner_slide_page_2 || $banner_slide_page_3 || $banner_slide_page_4 ) ) {

                                foreach( $page_array as $post_id ){

                                    if( $post_id ){
                                        $banner_test_query_1 = new WP_Query( array( 'post_type' => 'page', 'posts_per_page' => 4, 'post__in' => array( $post_id ) ) );

                                        while ($banner_test_query_1->have_posts()) {
                                            $banner_test_query_1->the_post();

                                            $slider_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' ); ?>
                                            <div class="testimonials-items">
                                                <div class="testimonials-caption">

                                                    <?php if( $testimonial_layout == 'slide' && $slider_image[0] ){ ?>
                                                        <div class="twp-author-avatar bg-image">
                                                            <img src="<?php echo esc_url( $slider_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                        </div>
                                                    <?php } ?>


                                                    <div class="testimonials-lead">
                                                        <?php if (has_excerpt()) {
                                                            the_excerpt();
                                                        } else {
                                                            if (get_the_content()) {
                                                                echo wp_kses_post(wp_trim_words(get_the_content(), 50, '...'));
                                                            }
                                                        } ?>
                                                    </div>
                                                </div>
                                                <div class="testimonials-author">

                                                    <?php if( $testimonial_layout == 'carousel' && $slider_image[0] ){ ?>
                                                        <div class="twp-author-avatar bg-image">
                                                            <img src="<?php echo esc_url( $slider_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                        </div>
                                                    <?php } ?>

                                                    <div class="twp-author-desc">
                                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php
                                        }
                                        wp_reset_postdata();
                                    }

                                }

                            }else{

                                if ($testimonial_type == 'post-cat' && $post_category) {
                                    $testimonial_type_2 = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 4, 'category_name' => esc_html( $post_category ) ) );

                                    while ($testimonial_type_2->have_posts()) {
                                        $testimonial_type_2->the_post();
                                        $slider_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' ); ?>
                                        <div class="testimonials-items">
                                            <div class="testimonials-caption">

                                                <?php if( $testimonial_layout == 'slide' && $slider_image[0] ){ ?>
                                                    <div class="twp-author-avatar bg-image">
                                                        <img src="<?php echo esc_url( $slider_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                    </div>
                                                <?php } ?>


                                                <div class="testimonials-lead">
                                                    <?php if (has_excerpt()) {
                                                        the_excerpt();
                                                    } else {
                                                        if (get_the_content()) {
                                                            echo wp_kses_post(wp_trim_words(get_the_content(), 50, '...'));
                                                        }
                                                    } ?>
                                                </div>
                                            </div>
                                            <div class="testimonials-author">

                                                <?php if( $testimonial_layout == 'carousel' && $slider_image[0] ){ ?>
                                                    <div class="twp-author-avatar bg-image">
                                                        <img src="<?php echo esc_url( $slider_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                    </div>
                                                <?php } ?>

                                                <div class="twp-author-desc">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php wp_reset_postdata();
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
endif;
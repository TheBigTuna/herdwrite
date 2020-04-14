<?php
/**
 * Slide Banner Function.
 *
 * @package Store Lite
 */

if (!function_exists('store_lite_slide_banner')):

    // Recommended Posts Functions.
    function store_lite_slide_banner($store_lite_home_section,$repeat_times)
    {

        $slide_banner_post_category = isset( $store_lite_home_section->post_category ) ? $store_lite_home_section->post_category : '' ;
        $slider_banner_type = isset( $store_lite_home_section->slider_banner_type ) ? $store_lite_home_section->slider_banner_type : '' ;
        $slider_banner_height = isset( $store_lite_home_section->slider_banner_height ) ? $store_lite_home_section->slider_banner_height : '';
        $slider_banner_height = 'twp-'.$slider_banner_height.'-height';
        $ed_slider_autoplay = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_dots = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
        $ed_slider_arrows = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;
        $slider_overlay = isset( $store_lite_home_section->slider_overlay ) ? $store_lite_home_section->slider_overlay : '' ;

        if ($ed_slider_autoplay != 'no') {
            $autoplay = 'true';
        } else {
            $autoplay = 'false';
        }
        if ($ed_slider_dots != 'no') {
            $dots = 'true';
        } else {
            $dots = 'false';
        }
        if (is_rtl()) {
            $rtl = 'true';
        } else {
            $rtl = 'false';
        } ?>

        <div class="twp-blocks twp-blocks-nospace twp-banner-block <?php echo esc_attr($slider_banner_height);
        if ($slider_overlay != 'no') {
            echo ' twp-banner-overlay';
        } ?>">
            <div class="fullwidth-wrapper">
                <div loop-count="<?php echo absint($repeat_times); ?>" class="main-slider"
                     data-slick='{"autoplay": <?php echo esc_attr($autoplay); ?>, "dots": <?php echo esc_attr($dots); ?>, "rtl": <?php echo esc_attr($rtl); ?>}'>

                    <?php
                    if ($slider_banner_type == 'page') {

                        for ($x = 1; $x <= 3; $x++) {

                            $page_id_1 = 'banner_slide_page_' . $x;
                            $banner_slide_page = absint($store_lite_home_section->$page_id_1);

                            $link_1 = 'banner_slide_link_' . $x;
                            $banner_slide_link = esc_url($store_lite_home_section->$link_1);
                            if( empty( $banner_slide_link ) ){
                                $banner_slide_link = esc_url( get_the_permalink() );
                            }

                            $button_label_1 = 'banner_slide_buy_new_button_label_' . $x;
                            $banner_slide_button_label = esc_html($store_lite_home_section->$button_label_1);


                            if ($banner_slide_page) {

                                $banner_slide_page_query = new WP_Query(array('post_type' => 'page', 'posts_per_page' => 1, 'post__in' => array($banner_slide_page)));

                                while ($banner_slide_page_query->have_posts()) {
                                    $banner_slide_page_query->the_post();
                                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>

                                    <div class="slide-item">

                                        <div class="slide-image">
                                            <a class="data-bg data-bg-slider" href="<?php echo esc_url($banner_slide_link); ?>" data-background="<?php echo esc_url($featured_image[0]); ?>">
                                                <?php if ($slider_overlay != 'no') { ?>
                                                    <span class="bg-slider-overlay"></span>
                                                <?php } ?>
                                            </a>
                                        </div>

                                        <div class="slide-content-wrapper">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-1">
                                                        <div class="slide-content">
                                                            <?php if ($slider_banner_type != 'page') { ?>
                                                                <div class="entry-meta entry-meta-category">
                                                                    <?php store_lite_entry_footer($cats = true, $tags = false, $edits = false); ?>
                                                                </div>
                                                            <?php } ?>

                                                            <h2 class="entry-title entry-title-large">
                                                                <a href="<?php echo esc_url($banner_slide_link); ?>">
                                                                    <?php the_title(); ?>
                                                                </a>
                                                            </h2>

                                                            <?php if( $banner_slide_button_label ){ ?>

                                                                <div class="block-link">
                                                                    <a class="twp-btn twp-btn-radius twp-btn-primary twp-btn-medium" href="<?php echo esc_url($banner_slide_link); ?>">
                                                                        <?php echo esc_html($banner_slide_button_label); ?>
                                                                    </a>
                                                                </div>

                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php }
                                wp_reset_postdata();
                            }
                        }

                    } elseif ($slider_banner_type == 'product') {

                        $product_1 = $store_lite_home_section->banner_slide_product_1;
                        $product_2 = $store_lite_home_section->banner_slide_product_2;
                        $product_3 = $store_lite_home_section->banner_slide_product_3;

                        if ($product_1 || $product_2 || $product_3 ) {

                            $slide_banner_product_query = new WP_Query( array( 'post_type' => 'product', 'posts_per_page' => 3, 'post__in' => array($product_1, $product_2, $product_3 ) ) );

                            if ($slide_banner_product_query->have_posts()) {

                                $i = 1;
                                while ($slide_banner_product_query->have_posts()) {
                                    $slide_banner_product_query->the_post();

                                    $button_label_1 = 'banner_slide_buy_new_button_label_' . $i;
                                    $banner_slide_button_label = esc_html($store_lite_home_section->$button_label_1);
                                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full'); ?>

                                    <div class="slide-item">

                                        <div class="slide-image">
                                            <a class="data-bg data-bg-slider" href="<?php the_permalink(); ?>" data-background="<?php echo esc_url($featured_image[0]); ?>">
                                                <?php if ($slider_overlay != 'no') { ?>
                                                    <span class="bg-slider-overlay"></span>
                                                <?php } ?>
                                            </a>
                                        </div>

                                        <div class="slide-content-wrapper">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-md-8 col-md-offset-1">
                                                        <div class="slide-content">

                                                            <h2 class="entry-title entry-title-large">
                                                                <a href="<?php the_permalink(); ?>">
                                                                    <?php the_title(); ?>
                                                                </a>
                                                            </h2>

                                                            <?php if( $banner_slide_button_label ){ ?>

                                                                <div class="block-link">
                                                                    <a class="twp-btn twp-btn-radius twp-btn-primary twp-btn-medium" href="<?php the_permalink(); ?>">
                                                                        <?php echo esc_html( $banner_slide_button_label ); ?>
                                                                    </a>
                                                                </div>

                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <?php
                                $i++;
                                }
                                wp_reset_postdata();
                            }
                        }

                    } else {

                        $slide_banner_post_query = new WP_Query(array('post_type' => 'post', 'posts_per_page' => 3, 'category_name' => esc_html($slide_banner_post_category)));

                        if ($slide_banner_post_query->have_posts()) {

                            $j = 1;
                            while ($slide_banner_post_query->have_posts()) {
                                $slide_banner_post_query->the_post();

                                $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(), 'full');

                                $link_2 = 'banner_slide_link_' . $j;
                                $banner_slide_link_2 = esc_url($store_lite_home_section->$link_2);
                                if( empty( $banner_slide_link_2 ) ){

                                    $banner_slide_link_2 = esc_url( get_the_permalink() );

                                }

                                $button_label_2 = 'banner_slide_buy_new_button_label_' . $j;
                                $banner_slide_button_label = esc_html($store_lite_home_section->$button_label_2); ?>

                                <div class="slide-item">

                                    <div class="slide-image">
                                        <a class="data-bg data-bg-slider" href="<?php echo esc_url($banner_slide_link_2); ?>" data-background="<?php echo esc_url($featured_image[0]); ?>">
                                            <?php if ($slider_overlay != 'no') { ?>
                                                <span class="bg-slider-overlay"></span>
                                            <?php } ?>
                                        </a>
                                    </div>

                                    <div class="slide-content-wrapper">
                                        <div class="container">
                                            <div class="row">
                                                <div class="col-md-8 col-md-offset-1">
                                                    <div class="slide-content">

                                                        <?php if ($slider_banner_type != 'page') { ?>
                                                            <div class="entry-meta entry-meta-category">
                                                                <?php store_lite_entry_footer($cats = true, $tags = false, $edits = false); ?>
                                                            </div>
                                                        <?php } ?>

                                                        <h2 class="entry-title entry-title-large">
                                                            <a href="<?php echo esc_url($banner_slide_link_2); ?>">
                                                                <?php the_title(); ?>
                                                            </a>
                                                        </h2>

                                                        <?php if( $banner_slide_button_label ){ ?>

                                                            <div class="block-link">
                                                                <a class="twp-btn twp-btn-radius twp-btn-primary twp-btn-medium" href="<?php echo esc_url($banner_slide_link_2); ?>">
                                                                    <?php echo esc_html($banner_slide_button_label); ?>
                                                                </a>
                                                            </div>

                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                $j++;
                            }
                            wp_reset_postdata();
                        }

                    } ?>

                </div>
            </div>

            <?php if ($ed_slider_arrows != 'no') { ?>
                <div class="title-controls">
                    <div class="container">
                        <div class="twp-slide-prev slide-icon-primary slide-prev-primary-<?php echo absint($repeat_times); ?>">
                            <i class="ion-ios-arrow-back slick-arrow"></i>
                        </div>
                        <div class="twp-slide-next slide-icon-primary slide-next-primary-<?php echo absint($repeat_times); ?>">
                            <i class="ion-ios-arrow-forward slick-arrow"></i>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

        <?php
    }

endif;
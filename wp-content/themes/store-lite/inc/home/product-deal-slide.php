<?php
/**
* Product Deal Slide Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_product_deal_slide' ) ):

    // Header Featured Post.
    function store_lite_product_deal_slide( $store_lite_home_section,$repeat_times ){

        $product_category = isset( $store_lite_home_section->product_category ) ? $store_lite_home_section->product_category : '' ;
        $product_category_2 = isset( $store_lite_home_section->product_category_2 ) ? $store_lite_home_section->product_category_2 : '' ;
        $section_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
        $section_title_2 = isset( $store_lite_home_section->section_title_2 ) ? $store_lite_home_section->section_title_2 : '' ;
        $ed_slider_autoplay    = isset( $store_lite_home_section->slider_autoplay ) ? $store_lite_home_section->slider_autoplay : '' ;
        $ed_slider_dots    = isset( $store_lite_home_section->slider_dots ) ? $store_lite_home_section->slider_dots : '' ;
        $ed_slider_arrows  = isset( $store_lite_home_section->slider_arrows ) ? $store_lite_home_section->slider_arrows : '' ;
        $sorting_type  = isset( $store_lite_home_section->sorting_type ) ? $store_lite_home_section->sorting_type : '' ;
        $enable_review_comment  = isset( $store_lite_home_section->enable_review_comment ) ? $store_lite_home_section->enable_review_comment : '' ;

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
                    'post_type'      => 'product',
                    'posts_per_page' => 5,
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array( // Variable products type
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        )
                    ),
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
                    'post_type'      => 'product',
                    'posts_per_page' => 5,
                    'meta_query'     => array(
                        'relation' => 'OR',
                        array( // Simple products type
                            'key'           => '_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        ),
                        array( // Variable products type
                            'key'           => '_min_variation_sale_price',
                            'value'         => 0,
                            'compare'       => '>',
                            'type'          => 'numeric'
                        )
                    ),
                )
            );

        }


        if( $product_category_2 ){

            if( $sorting_type == 'sellers' ){

                $tab_product_query_2 = new WP_Query(
                    array( 
                        'post_type' => 'product',
                        'posts_per_page' => 15,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $product_category_2,
                            ),
                        ),
                    ) 
                );

            }else{

                $tab_product_query_2 = new WP_Query(
                    array( 
                        'post_type' => 'product',
                        'posts_per_page' => 15,
                        'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $product_category_2,
                            ),
                        ),
                    ) 
                );

            }
            
        }else{

            if( $sorting_type == 'sellers' ){

                $tab_product_query_2 = new WP_Query(
                    array( 
                        'post_type' => 'product',
                        'posts_per_page' => 15,
                        'meta_key' => 'total_sales',
                        'orderby' => 'meta_value_num',
                    ) 
                );
            }else{

                $tab_product_query_2 = new WP_Query(
                    array( 
                        'post_type' => 'product',
                        'posts_per_page' => 15,
                    ) 
                );
            }

        }

        $posts_array = array();
        if( $tab_product_query_2->have_posts() ){
            while( $tab_product_query_2->have_posts() ){
                $tab_product_query_2->the_post();

                $posts_array[] = get_the_ID();

            }
            wp_reset_postdata();
        }

        $posts_array = array_chunk($posts_array, 5);
        
        ?>
        
        <div class="twp-blocks twp-blocks-alt twp-deals-block">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <div class="deals-block-wrapper">

                            <header class="block-title-header-1">
                                <div class="twp-seperator-1"></div>
                                <div class="block-title-wrapper">
                                    <?php if( $section_title ){ ?>
                                        <h2 class="block-title">
                                            <?php echo esc_html( $section_title ); ?>
                                        </h2>
                                    <?php } ?>

                                    <?php if( $ed_slider_arrows == 'yes' ){ ?>
                                        <div class="title-controls">
                                            <div class="slide-icon-1 slide-prev-2-<?php echo absint($repeat_times); ?> slick-arrow">
                                                <i class="ion-ios-arrow-back slick-arrow"></i>
                                            </div>
                                            <div class="slide-icon-1 slide-next-2-<?php echo absint($repeat_times); ?> slick-arrow">
                                                <i class="ion-ios-arrow-forward slick-arrow"></i>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </header>

                            <?php if( $tab_product_query->have_posts() ): get_header( 'shop' ); ?>

                                <div class="twp-deals-container woocommerce">
                                    <div loop-count="<?php echo absint($repeat_times); ?>" class="twp-deals-slider" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "rtl": <?php echo esc_attr( $rtl ); ?>}'>
                                        <?php while( $tab_product_query->have_posts() ){
                                            $tab_product_query->the_post();
                                            global $product;
                                            $attachment_ids = $product->get_gallery_image_ids(); ?>
                                            <div class="deals-item product <?php if( $attachment_ids ){ echo 'twp-has-thumbnail'; } ?>">

                                                <div class="twp-product-gallery">
                                                    <?php
                                                    /**
                                                     * Hook: woocommerce_before_single_product_summary.
                                                     *
                                                     * @hooked woocommerce_show_product_sale_flash - 10
                                                     * @hooked woocommerce_show_product_images - 20
                                                     */
                                                    do_action( 'woocommerce_before_single_product_summary' );
                                                    ?>
                                                </div>

                                                <div class="twp-deals-details">
                                                    <div class="twp-product-content">

                                                        <h2 class="twp-item-title twp-item-small-1">
                                                            <a href="<?php the_permalink() ?>">
                                                                <?php the_title(); ?>
                                                            </a>
                                                        </h2>

                                                        <div class="twp-item-price">
                                                            <?php woocommerce_template_loop_price(); ?>
                                                        </div>

                                                        <div class="twp-item-status">
                                                                <?php esc_html_e('Status:','store-lite'); ?>
                                                                <span>
                                                                    <?php if ( method_exists( $product, 'get_stock_status' ) ) {
                                                                        $stock_status = $product->get_stock_status(); // For version 3.0+
                                                                    }else{
                                                                        $stock_status = $product->stock_status; // Older than version 3.0
                                                                    }
                                                                    if( $stock_status == 'outofstock' ){

                                                                        esc_html_e('Out of stock','store-lite');

                                                                    }elseif( $stock_status == 'onbackorder' ){

                                                                        esc_html_e('On backorder','store-lite');

                                                                    }else{

                                                                        esc_html_e('In Stock','store-lite');

                                                                    } ?>
                                                                </span>
                                                        </div>

                                                        <?php woocommerce_template_loop_add_to_cart();

                                                        $count = $product->get_review_count(); ?>

                                                        <?php if ( $count && wc_review_ratings_enabled() ){ ?>
                                                            <div class="twp-review-info">

                                                                <h4 class="twp-average-title">
                                                                    <?php esc_html_e( 'Average Rating', 'store-lite' ); ?>
                                                                </h4>

                                                                <?php
                                                                $average_rating = round( $product->get_average_rating(), 2 );
                                                                if ( $average_rating > 0 ){ ?>
                                                                    <h3 class="average-percent"><?php echo number_format( $average_rating, 2 ); ?></h3>
                                                                <?php } ?>

                                                                <?php
                                                                if ( function_exists( 'woocommerce_template_single_rating' ) ) {
                                                                    woocommerce_template_single_rating();
                                                                } ?>

                                                            </div>
                                                        <?php } ?>


                                                    </div>
                                                </div>

                                                <?php
                                                if( $enable_review_comment != 'no' ){
                                                    $comment_args = array(
                                                        'number'      => 3,
                                                        'status'      => 'approve',
                                                        'post_status' => 'publish',
                                                        'post_id'     => get_the_ID(),
                                                    );

                                                    $comments = get_comments( $comment_args ); ?>

                                                    <?php if ( !empty( $comments ) ):?>
                                                        <div class="twp-bestdeal-comment clearfix">
                                                            <div class="bestdeal-comment-slider" data-slick='{"rtl": <?php echo esc_attr( $rtl ); ?>}'>
                                                                <?php foreach ( $comments as $key => $comment ):
                                                                	$rating = get_comment_meta($comment->comment_ID, 'rating', true);
                                                                	$rating_width = $rating*2*10; ?>
                                                                    <div class="bestdeal-comment-items">
                                                                        <div class="twp-row twp-row-sm">
                                                                            <div class="column column-two">
                                                                                <div class="twp-author-avatar">
		                                                                            <?php
		                                                                            echo wp_kses_post( get_avatar( $comment->comment_author_email, 150 ) ); ?>

		                                                                        </div>
                                                                            </div>
                                                                            <div class="column column-eight">
                                                                                <div class="comments-content">
                                                                                    <strong>
                                                                                        <?php echo wp_kses_post( get_comment_author_link( $comment ) ); ?>
                                                                                    </strong>
                                                                                    <span class="twp-hasgiven"><?php echo esc_html__('has reviewed','store-lite'); ?></span>

		                                                                            <div class="star-rating" role="img" aria-label="<?php echo esc_html__('Rated ','store-lite').absint( $rating ). esc_html__(' out of 5','store-lite'); ?>">

		                                                                                <span style="width:<?php echo absint($rating_width); ?>%">
		                                                                                    <?php echo esc_html__('Rated ','store-lite'); ?>

		                                                                                    <strong class="rating"><?php echo absint( $rating ); ?> </strong>

		                                                                                    <?php echo esc_html__(' out of 5','store-lite'); ?>

		                                                                                </span>
		                                                                            </div>

		                                                                            <div class="twp-comment-date">
		                                                                                <?php echo esc_html ( get_comment_date('',$comment->comment_ID) ); ?>
		                                                                            </div>
                                                                                    <h3 class="entry-title entry-title-small">
                                                                                        <?php echo esc_html ( $comment->comment_content ); ?>
                                                                                    </h3>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                <?php endforeach;?>
                                                            </div>
                                                        </div>
                                                    <?php endif;
                                                } ?>

                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>

                                <?php
                                wp_reset_postdata();
                            endif; ?>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="twp-best-sellers">
                            <div class="block-title-wrapper">
                                <?php if( $section_title_2 ){ ?>
                                    <h2 class="block-title">
                                        <?php echo esc_html( $section_title_2 ); ?>
                                    </h2>
                                <?php } ?>
                            </div>
                            <?php if( $tab_product_query_2->have_posts() && $posts_array ){ ?>

                                <div class="twp-vertical-slider" data-slick='{"autoplay": <?php echo esc_attr( $autoplay ); ?>, "dots": <?php echo esc_attr( $dots ); ?>, "arrows": false, "rtl": <?php echo esc_attr( $rtl ); ?>}'>

                                    <?php foreach( $posts_array as $postid ){
                                        $tab_product_query_sec = new WP_Query( array( 
                                                'post_type'      => 'product',
                                                'posts_per_page' => 5,
                                                'post__in'     => $postid
                                            )
                                        );

                                        if( $tab_product_query_sec->have_posts() ){ ?>

                                            <div class="deals-item-group">

                                                <?php while( $tab_product_query_sec->have_posts() ){
                                                    $tab_product_query_sec->the_post(); ?>

                                                    <div class="deals-item">
                                                        <div class="deals-item-wrapper">
                                                            <div class="vertical-item-image">
                                                                <?php woocommerce_template_loop_product_thumbnail(); ?>
                                                            </div>
                                                            <div class="verticle-item-content">
                                                                <div class="twp-product-content">
                                                                    <h2 class="twp-item-title twp-item-small">
                                                                        <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                                                                    </h2>
                                                                    <div class="twp-item-ratings">
                                                                        <?php woocommerce_template_loop_rating(); ?>
                                                                    </div>
                                                                    <div class="twp-item-price">
                                                                        <?php woocommerce_template_loop_price(); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php } ?>

                                            </div>

                                            <?php
                                            wp_reset_postdata();
                                        }
                                    } ?>

                                </div>

                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    
    <?php
    }

endif;
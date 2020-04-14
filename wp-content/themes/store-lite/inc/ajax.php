<?php
/**
* Recommended Posts Function.
*
* @package Store Lite
*/

add_action('wp_ajax_store_lite_latest_posts', 'store_lite_latest_posts_callback');
add_action('wp_ajax_nopriv_store_lite_latest_posts', 'store_lite_latest_posts_callback');

// Recommendec Post Ajax Call Function.
function store_lite_latest_posts_callback() {

    $paged = absint( $_POST['page'] );
    $recommended_post_category = esc_html( $_POST['category'] );
    $recommended_post_query = new WP_Query( array( 'post_type' => 'post','posts_per_page' => 3, 'category_name' => esc_html( $recommended_post_category ), 'paged'=> absint( $paged ) ) );

    if ( $recommended_post_query->have_posts() ) :
        
        $i = 0;
        while ( $recommended_post_query->have_posts() ) : $recommended_post_query->the_post();

            if( $i == 1 ){
                $delay = '0.5s';
            }elseif( $i == 2 ){
                $delay = '0.7s';
            }else{
                $delay = '0.3s';
            }

            $format = get_post_format( get_the_ID() ) ? : 'standard';
            $icon = store_lite_post_formate_icon( $format );
            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium_large' ); ?>

            <div class="col-md-4 col-sm-6 col-xs-12 latest-news-load wow fadeInUp ajax-added-posts" data-wow-delay="<?php echo esc_attr( $delay ); ?>" >
                <article class="latest-news-article">
                    <div class="post-thumb">
                        <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="data-bg data-bg-big" data-background="<?php echo esc_url( $featured_image[0] ); ?>">
                            <?php if( !empty( $icon ) ){ ?>
                                <span class="format-icon">
                                    <i class="ion <?php echo esc_attr( $icon ); ?>"></i>
                                </span>
                            <?php } ?>
                        </a>
                    </div>

                    <div class="entry-content">
                        <div class="entry-meta entry-meta-category">
                            <?php store_lite_entry_footer( $cats = true,$tags = false, $edits = false ); ?>
                        </div>

                        <h3 class="entry-title entry-title-medium">
                            <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
                        </h3>
                    </div>

                </article>
            </div>
        <?php
        $i++;
        endwhile;
        wp_reset_postdata();
    endif;
 
    wp_die();
}

add_action('wp_ajax_store_lite_tab_posts', 'store_lite_tab_posts_callback');
add_action('wp_ajax_nopriv_store_lite_tab_posts', 'store_lite_tab_posts_callback');

// Recommendec Post Ajax Call Function.
function store_lite_tab_posts_callback() {

    $cat_slug = esc_attr( $_POST['cat_slug'] );
    $tab_id = esc_attr( $_POST['tab_id'] );
    $indicator = esc_attr( $_POST['indicator'] );
    $tab_layout = esc_attr( $_POST['tab_layout'] );

    if( $indicator == 'twp-best-seller' ){

        if( $cat_slug ){
            $tab_product_query = new WP_Query(
                array( 
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                    'tax_query' => array(
                            array(
                                'taxonomy' => 'product_cat',
                                'field'    => 'slug',
                                'terms'    => $cat_slug,
                            ),
                        ),
                ) 
            );
        }else{

            $tab_product_query = new WP_Query(
                array( 
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'meta_key' => 'total_sales',
                    'orderby' => 'meta_value_num',
                ) 
            );

        }

    }elseif( $indicator == 'best-deals' ){

        if( $cat_slug ){
            $tab_product_query = new WP_Query(
                array( 
                    'post_type'      => 'product',
                    'posts_per_page' => 6,
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
                                'terms'    => $cat_slug,
                            ),
                        ),
                ) 
            );
        }else{

             $tab_product_query = new WP_Query(
                array( 
                    'post_type'      => 'product',
                    'posts_per_page' => 6,
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

    }elseif( $indicator == 'other-cat' ){

         $tab_product_query = new WP_Query(
            array( 
                'post_type' => 'product',
                'posts_per_page' => 6,
                'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field'    => 'slug',
                            'terms'    => $cat_slug,
                        ),
                    ),
            ) 
        );
         
    }

    while( $tab_product_query->have_posts() ){
        $tab_product_query->the_post();
        
        if( $tab_layout == 'horizontal' ){
            wc_get_template_part( 'content', 'product-2' );
        }else{
            wc_get_template_part( 'content', 'product' );
        }

    }

    wp_die();

}
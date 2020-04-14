<?php
/**
 * Recent Post Widgets.
 *
 * @package Store Lite
 */


if ( !function_exists('store_lite_product_lists_widgets') ) :

    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function store_lite_product_lists_widgets(){
        // Recent Post widget.
        register_widget('Store_Lite_Sidebar_Product_lists_Widget');

    }

endif;
add_action('widgets_init', 'store_lite_product_lists_widgets');

// Recent Post widget
if ( !class_exists('Store_Lite_Sidebar_Product_lists_Widget') ) :

    /**
     * Recent Post.
     *
     * @since 1.0.0
     */
    class Store_Lite_Sidebar_Product_lists_Widget extends Store_Lite_Widget_Base
    {

        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        public function __construct()
        {
            $opts = array(
                'classname' => 'store_lite_product_lists_sidebar_widget',
                'description' => esc_html__('Displays post form selected category specific for popular post in sidebars.', 'store-lite'),
                'customize_selective_refresh' => true,
            );

            $fields = array(
                'title' => array(
                    'label' => esc_html__('Title:', 'store-lite'),
                    'type' => 'text',
                    'class' => 'widefat',
                ),
                'product_category' => array(
                    'label' => esc_html__('Product Category:', 'store-lite'),
                    'type' => 'product_select',
                ),
                'product_short' => array(
                    'label' => esc_html__('Product Shorting:', 'store-lite'),
                    'type' => 'select',
                    'options' => array( 
                        'latest-product' => esc_html__('Latest Product','store-lite'),
                        'best-sellers' => esc_html__('Best Sellers','store-lite'),
                        'best-deals' => esc_html__('Best Deals','store-lite'),
                    ),
                ),
                'post_number' => array(
                    'label' => esc_html__('Number of Products:', 'store-lite'),
                    'type' => 'number',
                    'default' => 4,
                    'css' => 'max-width:60px;',
                    'min' => 1,
                    'max' => 9,
                ),
            );

            parent::__construct( 'store-lite-product-list-sidebar', esc_html__('SL: Product Lists Widget', 'store-lite'), $opts, array(), $fields );
        }

        /**
         * Outputs the content for the current widget instance.
         *
         * @since 1.0.0
         *
         * @param array $args Display arguments.
         * @param array $instance Settings for the current widget instance.
         */
        function widget( $args, $instance )
        {

            $params = $this->get_params( $instance );

            echo $args['before_widget'];

            if ( !empty( $params['title'] ) ) {
                echo $args['before_title'] . $params['title'] . $args['after_title'];
            }

            $product_category = $params['product_category'];

            $product_short = $params['product_short'];

            if( $product_short == 'best-sellers' ){

                if( $product_category ){

                    $product_query = new WP_Query(
                        array( 
                            'post_type' => 'product',
                            'posts_per_page' => $params['post_number'],
                            'meta_key' => 'total_sales',
                            'orderby' => 'meta_value_num',
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

                    $product_query = new WP_Query(
                        array( 
                            'post_type' => 'product',
                            'posts_per_page' => $params['post_number'],
                            'meta_key' => 'total_sales',
                            'orderby' => 'meta_value_num',
                        ) 
                    );

                }

            }elseif( $product_short == 'best-deals' ){

                if( $product_category ){

                    $product_query = new WP_Query(
                        array( 
                            'post_type'      => 'product',
                            'posts_per_page' => $params['post_number'],
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

                     $product_query = new WP_Query(
                        array( 
                            'post_type'      => 'product',
                            'posts_per_page' => $params['post_number'],
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

            }else{

                if( $product_category ){

                    $product_query = new WP_Query(
                        array( 
                            'post_type' => 'product',
                            'posts_per_page' => $params['post_number'],
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

                     $product_query = new WP_Query(
                        array( 
                            'post_type' => 'product',
                            'posts_per_page' => $params['post_number'],
                        ) 
                    );

                }

            }

            if ( $product_query->have_posts() ) : ?>

                <div class="twp-recent-widget">                
                    <ul class="twp-widget-list recent-widget-list">

                        <?php
                        while ( $product_query->have_posts() ) :

                            $product_query->the_post(); ?>
                            <li>
                                <article class="article-list">
                                    <div class="twp-row twp-row-sm">
                                        <div class="column column-three">
                                            <div class="article-image">
                                                <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'midium'); ?>
                                                <a href="<?php the_permalink();?>" class="data-bg data-bg-small" data-background="<?php echo esc_url( $image[0] ); ?>"></a>
                                            </div>
                                        </div>
                                        <div class="column column-seven">
                                            <div class="article-body">
                                                
                                                <h3 class="twp-item-title twp-item-small">
                                                    <a href="<?php the_permalink();?>">
                                                        <?php the_title();?>
                                                    </a>
                                                </h3>

                                                <div class="twp-item-ratings">
                                                    <?php woocommerce_template_loop_rating(); ?>
                                                </div>

                                                <div class="twp-item-price">
                                                    <?php woocommerce_template_loop_price(); ?>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </article>
                            </li>

                        <?php
                        endwhile; ?>

                    </ul>
                </div>

                <?php wp_reset_postdata(); ?>

            <?php endif; ?>

        <?php echo $args['after_widget'];
        }
    }
endif;
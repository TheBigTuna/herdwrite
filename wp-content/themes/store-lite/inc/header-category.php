<?php
/**
 * Header Product category Function.
 *
 * @package Store Lite
 */


if (!function_exists('store_lite_bottom_header_product_category')):

    // Header product category.
    function store_lite_bottom_header_product_category(){

        $default = store_lite_get_default_theme_options();
        $header_product_cat = array();

        $j = 1;
        while ($j <= 10) {

            $header_product = get_theme_mod('header_product_cat_' . $j);
            if ($header_product) {
                $header_product_cat[] = get_theme_mod('header_product_cat_' . $j);
            }
            $j++;
        }

        if ( $header_product_cat ) {
        	$header_product_category_title = get_theme_mod( 'header_product_category_title',$default['header_product_category_title'] ); ?>

        	<div class="twp-headerarea-left">
                <div class="dropdown-category-wrapper">
                    <div class="twp-dropdown-category">
                        
                        <div class="twp-dropdown-title">
                            <span id="hamburger-one" class="twp-hamburger-icon">
                                <span></span>
                                <span></span>
                                <span></span>
                                <span></span>
                            </span>

                            <span class="hidden-sm hidden-xs hidden-md">
                                <?php if( $header_product_category_title ){ echo esc_html( $header_product_category_title ); } ?>
                                <svg class="dropdown-arrow-icon" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32">
                                  <g fill="none" stroke="#2175FF" stroke-width="1.5" stroke-linejoin="round" stroke-miterlimit="10">
                                    <circle class="dropdown-arrow-icon--circle" cx="16" cy="16" r="15.12"></circle>
                                    <path class="dropdown-arrow-icon--arrow" d="M16.14 9.93L22.21 16l-6.07 6.07M8.23 16h13.98"></path>
                                  </g>
                                </svg>
                            </span>
                        </div>

                        <div id="twp-dropdown-categories" class="twp-dropdown-items">
                            <ul class="twp-categories-list">
                                <?php foreach ($header_product_cat as $header_product_cat_slug) {
                                    $term = get_term_by('slug', $header_product_cat_slug, 'product_cat');

                                    if( $term ){

                                        $cat_link = get_term_link($term->term_id, 'product_cat');
                                        $categories = '';
                                        $cat_array = array();
                                        $categories = get_terms('product_cat', ['child_of' => $term->term_id]);

                                        if ($categories) {
                                            foreach ($categories as $category) {
                                                $cat_array[] = $category->slug;
                                            }
                                        } ?>
                                        <li class="twp-categories-item">
                                            <a href="<?php echo esc_url($cat_link); ?>" class="twp-categories-item-title">
                                                <?php echo esc_html($term->name); ?>
                                            </a>
                                            <ul class="twp-submenu-items">
                                                <li class="categories-item-details">
                                                    <div class="twp-submenu-group">
                                                        <?php if ($categories) {
                                                            foreach ($cat_array as $cat_slug) {
                                                                $term_child = get_term_by('slug', $cat_slug, 'product_cat');
                                                                $child_product_query = new WP_Query(
                                                                    array(
                                                                        'post_type' => 'product',
                                                                        'posts_per_page' => 4,
                                                                        'tax_query' => array(
                                                                            array(
                                                                                'taxonomy' => 'product_cat',
                                                                                'field' => 'slug',
                                                                                'terms' => $cat_slug,
                                                                            ),
                                                                        ),
                                                                    )
                                                                ); ?>
                                                                <div class="twp-submenu-details <?php if( $cat_array ){ echo 'twp-has-subcat'; } ?>">
                                                                    <div class="twp-submenu-title">
                                                                        <a href="">
                                                                            <?php echo esc_html($term_child->name); ?>
                                                                            <span><?php echo absint($term_child->count) . esc_html__(' Items', 'store-lite'); ?></span>
                                                                        </a>
                                                                    </div>
                                                                    <?php if ($child_product_query->have_posts()): ?>
                                                                        <div class="twp-submenu-products">
                                                                            <?php while ($child_product_query->have_posts()) {
                                                                                $child_product_query->the_post();
                                                                                $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail' ); ?>
                                                                                <div class="submenu-individual-item">
                                                                                    <div class="individual-item-wrapper">

                                                                                        <?php if( $featured_image[0] ){ ?>

                                                                                            <div class="submenu-item-image twp-hover-animate">
                                                                                                <a href="<?php the_permalink(); ?>">
                                                                                                    <img src="<?php echo esc_url( $featured_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                                                                </a>
                                                                                            </div>

                                                                                        <?php } ?>

                                                                                        <div class="submenu-item-content">
                                                                                            <h3 class="twp-item-title twp-item-small">
                                                                                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
                                                                            <?php } ?>
                                                                        </div>
                                                                    <?php wp_reset_postdata();
                                                                    endif; ?>
                                                                </div>
                                                            <?php }
                                                        } else {

                                                            $child_product_query_2 = new WP_Query(
                                                                array(
                                                                    'post_type' => 'product',
                                                                    'posts_per_page' => 4,
                                                                    'tax_query' => array(
                                                                        array(
                                                                            'taxonomy' => 'product_cat',
                                                                            'field' => 'slug',
                                                                            'terms' => $header_product_cat_slug,
                                                                        ),
                                                                    ),
                                                                )
                                                            ); ?>

                                                            <div class="twp-submenu-details">
                                                                <?php if ($child_product_query_2->have_posts()): ?>
                                                                    <div class="twp-submenu-products">
                                                                        <?php while ($child_product_query_2->have_posts()) {
                                                                            $child_product_query_2->the_post();
                                                                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'thumbnail' ); ?>
                                                                            <div class="submenu-individual-item">
                                                                                <div class="individual-item-wrapper">
                                                                                    
                                                                                    <?php if( $featured_image[0] ){ ?>

                                                                                        <div class="submenu-item-image twp-hover-animate">
                                                                                            <a href="<?php the_permalink(); ?>">
                                                                                                <img src="<?php echo esc_url( $featured_image[0] ); ?>" alt="<?php the_title_attribute(); ?>" title="<?php the_title_attribute(); ?>" >
                                                                                            </a>
                                                                                        </div>

                                                                                    <?php } ?>

                                                                                    <div class="submenu-item-content">
                                                                                        <h3 class="twp-item-title twp-item-small">
                                                                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
                                                                        <?php } ?>
                                                                    </div>
                                                                <?php wp_reset_postdata();
                                                                endif; ?>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </li>
                                            </ul>

                                        </li>

                                    <?php
                                    }
                                } ?>

                            </ul>
                        </div>
                        
                    </div>
                </div>
            </div>
                
        <?php
        } 
    }

endif;
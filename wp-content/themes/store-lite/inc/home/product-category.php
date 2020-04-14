<?php
/**
* Product Category Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_product_category' ) ):

	// Product Category Function
	function store_lite_product_category( $store_lite_home_section ){

		$section_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
		$product_category_1 = isset( $store_lite_home_section->product_category ) ? $store_lite_home_section->product_category : '' ;
		$product_category_2 = isset( $store_lite_home_section->product_category_2 ) ? $store_lite_home_section->product_category_2 : '' ;
		$product_category_3 = isset( $store_lite_home_section->product_category_3 ) ? $store_lite_home_section->product_category_3 : '' ;
		$product_category_4 = isset( $store_lite_home_section->product_category_4 ) ? $store_lite_home_section->product_category_4 : '' ;
		$product_category_5 = isset( $store_lite_home_section->product_category_5 ) ? $store_lite_home_section->product_category_5 : '' ;
		$slider_overlay = isset( $store_lite_home_section->slider_overlay ) ? $store_lite_home_section->slider_overlay : '' ;

		$product_category_array = array( $product_category_1,$product_category_2,$product_category_3,$product_category_4,$product_category_5 );
		?>

		<div class="twp-blocks twp-block-categories">
		    <div class="container">

		    	<?php if( $section_title ){ ?>
			        <div class="row">
			            <div class="col-md-12">
			                <header class="block-title-header">
			                    <div class="block-title-wrapper">

			                        <h2 class="block-title"><?php echo esc_html( $section_title ); ?></h2>

			                    </div>
			                    <div class="twp-seperator"></div>
			                </header>
			            </div>
			        </div>
			    <?php } ?>

		        <div class="row twp-row-sm">
		        	<?php if( $product_category_1 || $product_category_2 || $product_category_3 || $product_category_4 ){
		        		
			        	foreach( $product_category_array as $product_slug ){
			        		$term_content = get_term_by( 'slug', $product_slug, 'product_cat' );
			        		if( $term_content ){
				        		$term_link = get_term_link( $term_content->term_id, 'product_cat' );
				        		$thumbnail_id = get_term_meta( $term_content->term_id, 'thumbnail_id', true ); 
								$image = wp_get_attachment_image_src( $thumbnail_id,'large' );

								$deals_product_query = new WP_Query(
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
					                                'terms'    => $product_slug,
					                            ),
					                        ),
					                ) 
					            ); ?>

					            <div class="col-md-6">
					                <div class="twp-featured-categories featured-categories-large">
					                    <div class="featured-categories-image twp-bg-zoom">
					                        <a class="data-bg data-bg-large" href="<?php echo esc_url( $term_link ); ?>" data-background="<?php echo esc_url( $image[0] ); ?>">
	                                            <?php if( $slider_overlay == 'yes' ){ ?>
	                                                <span class="bg-slider-overlay"></span>
	                                            <?php } ?>
					                        </a>
					                    </div>
					                    <div class="featured-categories-content">
					                    	<?php if( isset( $term_content->name ) ){ ?>
						                        <h2 class="entry-title entry-title-medium">
	                                                <a href="<?php echo esc_url( $term_link ); ?>">
						                                <?php echo esc_html( $term_content->name ); ?>
	                                                </a>
						                        </h2>
						                    <?php } ?>

					                        <div class="categories-meta-fields">

					                        	<?php if( isset( $term_content->count ) ){ ?>
						                            <div class="categories-product-count twp-categories-count">
						                                <div class="twp-count-digit">
						                                    <?php echo esc_html( $term_content->count ); ?>
						                                </div>
						                                <div class="twp-count-info">
						                                    <?php esc_html_e('items','store-lite'); ?>
						                                </div>
						                            </div>
					                            <?php } ?>

					                            <?php if( isset( $deals_product_query->found_posts ) ){ ?>
						                            <div class="categories-sale-count twp-categories-count">
						                                <div class="twp-count-digit">
						                                    <?php echo esc_html( $deals_product_query->found_posts ); ?>
						                                </div>
						                                <div class="twp-count-info">
						                                    <?php esc_html_e('sale','store-lite'); ?>
						                                </div>
						                            </div>
						                        <?php } ?>

					                        </div>
					                    </div>
					                </div>
					            </div>

					        <?php
					    	}
				        break;
				        }
				        
			        } ?>

		            <div class="col-md-6">
                        <div class="row twp-row-sm">
                            <?php if( $product_category_1 || $product_category_2 || $product_category_3 || $product_category_4 ){

                                $i = 1;
                                foreach( $product_category_array as $product_slug ){

                                    if( $i != 1 && $product_slug ){

                                        $term_content = get_term_by( 'slug', $product_slug, 'product_cat' );
                                        if( $term_content ){
	                                        $term_link = get_term_link( $term_content->term_id, 'product_cat' );
	                                        $thumbnail_id = get_term_meta( $term_content->term_id, 'thumbnail_id', true );
	                                        $image = wp_get_attachment_image_src( $thumbnail_id,'large' );

	                                        $deals_product_query = new WP_Query(
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
	                                                            'terms'    => $product_slug,
	                                                        ),
	                                                    ),
	                                            )
	                                        ); ?>

	                                        <div class="col-md-6 col-sm-6">
	                                            <div class="twp-featured-categories featured-categories-large">
	                                                <div class="featured-categories-image twp-bg-zoom">
	                                                    <a class="data-bg data-bg-big" href="<?php echo esc_url( $term_link ); ?>" data-background="<?php echo esc_url( $image[0] ); ?>">
	                                                        <?php if( $slider_overlay == 'yes' ){ ?>
	                                                            <span class="bg-slider-overlay"></span>
	                                                        <?php } ?>
	                                                    </a>
	                                                </div>
	                                                <div class="featured-categories-content">
	                                                    <?php if( isset( $term_content->name ) ){ ?>
	                                                        <h2 class="entry-title entry-title-medium">
	                                                            <a href="<?php echo esc_url( $term_link ); ?>">
	                                                                <?php echo esc_html( $term_content->name ); ?>
	                                                            </a>
	                                                        </h2>
	                                                    <?php } ?>

	                                                    <div class="categories-meta-fields">
	                                                        <?php if( isset( $term_content->count ) ){ ?>
	                                                            <div class="categories-product-count twp-categories-count">
	                                                                <div class="twp-count-digit">
	                                                                    <?php echo esc_html( $term_content->count ); ?>
	                                                                </div>
	                                                                <div class="twp-count-info">
	                                                                    <?php esc_html_e('items','store-lite'); ?>
	                                                                </div>
	                                                            </div>
	                                                        <?php } ?>

	                                                        <?php if( isset( $deals_product_query->found_posts ) ){ ?>
	                                                            <div class="categories-sale-count twp-categories-count">
	                                                                <div class="twp-count-digit">
	                                                                    <?php echo esc_html ( $deals_product_query->found_posts ); ?>
	                                                                </div>
	                                                                <div class="twp-count-info">
	                                                                    <?php esc_html_e('sale','store-lite'); ?>
	                                                                </div>
	                                                            </div>
	                                                        <?php } ?>
	                                                    </div>
	                                                </div>
	                                            </div>
	                                        </div>

		                                <?php
		                                }
                                    }
                                    $i++;
                                }
                            } ?>
                        </div>
		            </div>
		        </div>
		    </div>
		</div>

	<?php }

endif; ?>
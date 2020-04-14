<?php
/**
* Call To Action Function.
*
* @package Store Lite
*/


if( !function_exists('store_lite_cta') ):

	// CTA Function
	function store_lite_cta( $store_lite_home_section ){

		$cta_type = isset( $store_lite_home_section->cta_type ) ? $store_lite_home_section->cta_type : '' ;
		$cta_button_label = isset( $store_lite_home_section->cta_button_label ) ? $store_lite_home_section->cta_button_label : '' ;
		$cta_button_link = isset( $store_lite_home_section->cta_button_link ) ? $store_lite_home_section->cta_button_link : '' ;
		$slider_overlay = isset( $store_lite_home_section->slider_overlay ) ? $store_lite_home_section->slider_overlay : '' ;
		$fixed_background = isset( $store_lite_home_section->fixed_background ) ? $store_lite_home_section->fixed_background : '' ;
		$slider_banner_height = isset( $store_lite_home_section->slider_banner_height ) ? $store_lite_home_section->slider_banner_height : '' ;
		$cta_title = '';
		$cta_sub_title = '';
		$cta_bg = '';

		if( $cta_type == 'custom' ){

			$cta_title = isset( $store_lite_home_section->cta_title ) ? $store_lite_home_section->cta_title : '' ;
			$cta_sub_title = isset( $store_lite_home_section->cta_sub_title ) ? $store_lite_home_section->cta_sub_title : '' ;
			$cta_bg = isset( $store_lite_home_section->cta_bg ) ? $store_lite_home_section->cta_bg : '' ;

		}else{

			$banner_slide_page_1 = isset( $store_lite_home_section->banner_slide_page_1 ) ? $store_lite_home_section->banner_slide_page_1 : '' ;
			if( $banner_slide_page_1 ){

				$cta_query = new WP_Query( array( 'post_type' => 'page', 'post_per_page' => -1, 'post__in' => array( $banner_slide_page_1 ) ) );
				if( $cta_query->have_posts() ){

					while( $cta_query->have_posts() ){
						$cta_query->the_post();

						$cta_title = get_the_title();

						if( has_excerpt() ){
							$cta_sub_title = the_excerpt();
						}else{
							$cta_sub_title = esc_html( wp_trim_words( get_the_content(),20,'...' ) );
						}

						$cta_button_label = $store_lite_home_section->cta_button_label;
						if( empty( $cta_button_link ) ){
							$cta_button_link = get_the_permalink();
						}
						$cta_bg = $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium_large' );
						$cta_bg = $cta_bg[0];

					}
					wp_reset_postdata();
				}
			}


		} ?>
		<div class="twp-blocks twp-blocks-alt data-bg twp-cta-block cta-block-<?php echo esc_attr( $slider_banner_height ); ?> <?php if( $fixed_background != 'no' ){ ?>cta-block-fixed <?php } ?> <?php if( $slider_overlay == 'yes' ){ echo esc_attr('twp-cta-overlay'); } ?>" data-background="<?php echo esc_url( $cta_bg ); ?>">
		    <div class="cta-block-wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="cta-block-content">
                                <?php if( $cta_title ){ ?>
                                    <h2 class="entry-title entry-title-large">
                                        <?php echo esc_html( $cta_title ); ?>
                                    </h2>
                                <?php } ?>

                                <?php if( $cta_sub_title ){ ?>
                                    <div class="cta-block-details">
                                        <?php echo esc_html( $cta_sub_title ); ?>
                                    </div>
                                <?php } ?>

                                <?php if( $cta_button_link ){ ?>
                                    <div class="block-link">
                                        <a href="<?php echo esc_url( $cta_button_link ); ?>" class="twp-btn twp-btn-radius twp-btn-primary">
                                            <?php echo esc_html ( $cta_button_label ); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if( $slider_overlay == 'yes' ){ ?>
	            <div class="bg-slider-overlay"></div>
	        <?php } ?>

		</div>
		<?php
	}
endif;
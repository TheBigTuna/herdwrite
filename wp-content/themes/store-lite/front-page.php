<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store Lite
 */

get_header();
$default = store_lite_get_default_theme_options();
$twp_store_lite_home_sections = get_theme_mod( 'twp_store_lite_home_sections', json_encode( $default['twp_store_lite_home_sections'] ) );
$paged_active = false;
if ( !is_paged() ) {
	$paged_active = true;
}
$twp_store_lite_home_sections = json_decode( $twp_store_lite_home_sections );
$repeat_times = 1;
foreach( $twp_store_lite_home_sections as $store_lite_home_section ){
	
	$home_section_type = isset( $store_lite_home_section->home_section_type ) ? $store_lite_home_section->home_section_type : '' ;

	switch( $home_section_type ){

        case 'latest-post':
        $ed_latest_post = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;

        if( $ed_latest_post != 'no' ){

        $default = store_lite_get_default_theme_options(); ?>

		<div id="content" class="site-content">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					
					<?php 
			        if( is_front_page() ):
			            store_lite_slider( $store_lite_home_section);
			        endif;
				    
					if ( have_posts() ) :

						if ( is_home() && ! is_front_page() ) : ?>

							<header>
								<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
							</header>

						<?php endif; ?>

						<div class="twp-main-container">

							<?php
							/* Start the Loop */
							while ( have_posts() ) :
								the_post();

								/*
								 * Include the Post-Type-specific template for the content.
								 * If you want to override this in a child theme, then include a file
								 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
								 */
								get_template_part( 'template-parts/content', get_post_type() );

							endwhile; ?>
							
						</div>

						<?php store_lite_posts_navigation();

					else :

						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>

				</main><!-- #main -->
			</div><!-- #primary -->

			<?php
			if( is_front_page() && !is_home() ){

				$global_sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout',$default['global_sidebar_layout'] ) );
				$store_lite_post_sidebar_option = esc_html( get_post_meta( $post->ID, 'store_lite_post_sidebar_option', true ) );

				if( $store_lite_post_sidebar_option == 'global-sidebar' || empty( $store_lite_post_sidebar_option ) ){
					$store_lite_post_sidebar_option = $global_sidebar_layout;
				}

				if( $store_lite_post_sidebar_option != 'no-sidebar' ):

					if( store_lite_check_woocommerce_page() && is_active_sidebar( 'store-lite-woocommerce-widget' ) && !is_cart() && !is_checkout() ){ ?>

						<aside id="secondary" class="widget-area">
							<?php dynamic_sidebar( 'store-lite-woocommerce-widget' ); ?>
						</aside><!-- #secondary -->
							
					<?php
					}else{
						get_sidebar();
					}
					

				endif;

			}else{

				$sidebar_layout = isset( $store_lite_home_section->sidebar_layout ) ? $store_lite_home_section->sidebar_layout : '' ;
				if( $sidebar_layout != 'no-sidebar' ):
					get_sidebar();
				endif;

			} ?>

		</div>
		<?php
	
		}
		
        break;

        case 'latest-news':
		
		$ed_recommended_posts = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_recommended_posts == 'yes' && $paged_active ){
	        store_lite_latest_posts( $store_lite_home_section,$repeat_times );
	    }

        break;

        case 'tab-block-1':
		
		$ed_tab_block_1_posts = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( class_exists( 'WooCommerce' ) && $ed_tab_block_1_posts == 'yes' && $paged_active ){
	        store_lite_tab_block_1( $store_lite_home_section,$repeat_times );
	    }

        break;

         case 'tab-block-2':
		
		$ed_tab_block_2_posts = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( class_exists( 'WooCommerce' ) && $ed_tab_block_2_posts == 'yes' && $paged_active ){
	        store_lite_tab_block_2( $store_lite_home_section,$repeat_times );
	    }

        break;

        case 'carousel':
		
		$ed_carousel_posts = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( class_exists( 'WooCommerce' ) && $ed_carousel_posts == 'yes' && $paged_active ){
	        store_lite_tab_carousel( $store_lite_home_section,$repeat_times );
	    }

        break;

        case 'best-deal-slide':
		
		$ed_best_deal_slide_posts = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( class_exists( 'WooCommerce' ) && $ed_best_deal_slide_posts == 'yes' && $paged_active ){
	        store_lite_product_deal_slide( $store_lite_home_section,$repeat_times );
	    }

        break;

        case 'slide-banner':
		
		$ed_slide_banner_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_slide_banner_ed== 'yes' && $paged_active ){
	        store_lite_slide_banner( $store_lite_home_section,$repeat_times );
	    }

        break;

        case 'cta':
		
		$ed_cta_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_cta_ed== 'yes' && $paged_active ){
	        store_lite_cta( $store_lite_home_section );
	    }

        break;

        case 'testimonial':
		
		$ed_testimonial_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_testimonial_ed== 'yes' && $paged_active ){
	        store_lite_testimonial( $store_lite_home_section );
	    }

        break;

        case 'product-category':
		
		$ed_product_cat_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( class_exists( 'WooCommerce' ) && $ed_product_cat_ed== 'yes' && $paged_active ){
	        store_lite_product_category( $store_lite_home_section );
	    }

        break;

        case 'client':
		
		$ed_client_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_client_ed== 'yes' && $paged_active ){
	        store_lite_client( $store_lite_home_section );
	    }

        break;

        case 'advertise-area':
		
		$ed_advertise = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;

		if( $ed_advertise == 'yes' && $paged_active ){
	        store_lite_advertise( $store_lite_home_section );
	    }

        break;

        case 'subscribe':
		
		$ed_subscribe = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;

		if( $ed_subscribe == 'yes' && $paged_active ){
	        store_lite_subscribe( $store_lite_home_section );
	    }

        break;

        case 'info':
		
		$ed_info = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;

		if( $ed_info == 'yes' && $paged_active ){
	        store_lite_info( $store_lite_home_section );
	    }

        break;

        default:

        $ed_slide_banner_ed = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		
		if( $ed_slide_banner_ed== 'yes' && $paged_active ){
	        store_lite_slide_banner( $store_lite_home_section,$repeat_times );
	    }

		break;

	}
$repeat_times++;
}

get_footer();

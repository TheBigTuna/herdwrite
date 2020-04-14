<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store Lite
 */

get_header();
$default = store_lite_get_default_theme_options();
global $post;
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<?php 
	        if( is_front_page() ):
	            store_lite_slider();
	        endif;

	        if( is_front_page() && !is_home() ){ ?>
	        	<header class="entry-header"><h1 class="entry-title entry-title-big"><?php the_title(); ?></h1></header>
	        <?php }

			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
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

get_footer();

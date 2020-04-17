<?php
/**
 * Vonzot Navigation hook functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output the main menu in the header
 */
function vonzot_output_main_navigation() {

	if ( 'none' === vonzot_get_inherit_mod( 'menu_layout', 'top-right' ) ) {
		return;
	}

	$desktop_menu_layout = vonzot_get_inherit_mod( 'menu_layout', 'top-right' );
	$mobile_menu_layout = apply_filters( 'vonzot_mobile_menu_template', 'content-mobile' );
	?>
	<div id="desktop-navigation" class="clearfix">
		<?php
			/**
			 * Desktop Navigation
			 */
			get_template_part( 'components/navigation/content', $desktop_menu_layout );

			/**
			 * Search form
			 */
			vonzot_nav_search_form();
		?>
	</div><!-- #desktop-navigation -->

	<?php
	?>

	<div id="mobile-navigation">
		<?php
			/**
			 * Mobile Navigation
			 */
			get_template_part( 'components/navigation/' . $mobile_menu_layout );

			/**
			 * Search form
			 */
			vonzot_nav_search_form();
		?>
	</div><!-- #mobile-navigation -->
	<?php
}
add_action( 'vonzot_main_navigation', 'vonzot_output_main_navigation' );

/**
 * Output hamburger
 */
function wolfttheme_output_sidepanel_hamburger() {
	?>
	<div class="hamburger-container hamburger-container-side-panel">
		<?php
			/**
			 * Menu hamburger icon
			 */
			vonzot_hamburger_icon( 'toggle-side-panel' );
		?>
	</div><!-- .hamburger-container -->
	<?php
}
add_action( 'vonzot_sidepanel_hamburger', 'wolfttheme_output_sidepanel_hamburger' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function vonzot_output_complementary_menu( $context = 'desktop' ) {

	$cta_content = vonzot_get_inherit_mod( 'menu_cta_content_type', 'none' );

	/**
	 * Force shop icons on woocommerce pages
	 */
	$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == vonzot_get_woocommerce_shop_page_id() && vonzot_get_woocommerce_shop_page_id();
	$is_wc = vonzot_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

	if ( apply_filters( 'vonzot_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case
		$cta_content = 'shop_icons';
	}

	/**
	 * If shop icons are set on discography page, apply on all release pages
	 */
	$is_disco_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == vonzot_get_discography_page_id() && vonzot_get_discography_page_id();
	$is_disco_page = is_page( vonzot_get_discography_page_id() ) || is_singular( 'release' ) || $is_disco_page_child;

	if ( $is_disco_page && get_post_meta( vonzot_get_discography_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( vonzot_get_discography_page_id(), '_post_menu_cta_content_type', true );
	}

	/**
	 * If shop icons are set on events page, apply on all event pages
	 */
	$is_events_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == vonzot_get_events_page_id() && vonzot_get_events_page_id();
	$is_events_page = is_page( vonzot_get_events_page_id() ) || is_singular( 'event' ) || $is_events_page_child;

	if ( $is_events_page && get_post_meta( vonzot_get_events_page_id(), '_post_menu_cta_content_type', true ) ) {
		$cta_content = get_post_meta( vonzot_get_events_page_id(), '_post_menu_cta_content_type', true );
	}
	?>
	<?php if ( 'shop_icons' === $cta_content && 'desktop' === $context ) { ?>
		<?php if ( vonzot_display_shop_search_menu_item() ) : ?>
				<div class="search-container cta-item">
					<?php
						/**
						 * Search
						 */
						echo vonzot_search_menu_item();
					?>
				</div><!-- .search-container -->
			<?php endif; ?>
			<?php if ( vonzot_display_account_menu_item() ) : ?>
				<div class="account-container cta-item">
					<?php
						/**
						 * account icon
						 */
						vonzot_account_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( vonzot_display_wishlist_menu_item() ) : ?>
				<div class="wishlist-container cta-item">
					<?php
						/**
						 * Wishlist icon
						 */
						vonzot_wishlist_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>
			<?php if ( vonzot_display_cart_menu_item() ) : ?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						vonzot_cart_menu_item();

						/**
						 * Cart panel
						 */
						echo vonzot_cart_panel();
					?>
				</div><!-- .cart-container -->
			<?php endif; ?>

	<?php } elseif ( 'search_icon' === $cta_content && 'desktop' === $context ) { ?>

		<div class="search-container cta-item">
			<?php
				/**
				 * Search
				 */
				echo vonzot_search_menu_item();
			?>
		</div><!-- .search-container -->

	<?php } elseif ( 'socials' === $cta_content ) {

		if ( vonzot_is_wvc_activated() && function_exists( 'wvc_socials' ) ) {
			echo wvc_socials( array( 'services' => vonzot_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ), ) );
		}

	} elseif ( 'secondary-menu' === $cta_content && 'desktop' === $context ) {

		vonzot_secondary_desktop_navigation();

	} elseif ( 'wpml' === $cta_content && 'desktop' === $context ) {

		do_action( 'wpml_add_language_selector' );

	} elseif ( 'custom' === $cta_content && 'desktop' === $context ) {

		do_action( 'vonzot_custom_menu_cta_content' );

	} // end type
}
add_action( 'vonzot_secondary_menu', 'vonzot_output_complementary_menu', 10, 1 );

/**
 * Add side panel
 */
function vonzot_side_panel() {

	if ( vonzot_can_display_sidepanel() ) {
		get_template_part( 'components/layout/sidepanel' );
	}
}
add_action( 'vonzot_body_start', 'vonzot_side_panel' );

/**
 * Overwrite sidepanel position for non-top menu
 */
function vonzot_overwrite_side_panel_position( $position ) {

	$menu_layout = vonzot_get_inherit_mod( 'menu_layout', 'top-right' );

	if ( $position && 'overlay' === $menu_layout ) {
		$position = 'left';
	}

	return $position;
}
add_action( 'vonzot_side_panel_position', 'vonzot_overwrite_side_panel_position' );

/**
 * Off Canvas menus
 */
function vonzot_offcanvas_menu() {

	if ( 'offcanvas' !== vonzot_get_inherit_mod( 'menu_layout' ) ) {
		return;
	}
	?>
	<div class="offcanvas-menu-panel">
		<?php 
			/* Off-Canvas Menu Panel start hook */
			do_action( 'vonzot_offcanvas_menu_start' );
		?>
		<div class="offcanvas-menu-panel-inner">
			<?php
			/**
			 * Menu
			 */
			vonzot_primary_vertical_navigation();
		?>
		</div><!-- .offcanvas-menu-panel-inner -->
	</div><!-- .offcanvas-menu-panel -->
	<?php
}
add_action( 'vonzot_body_start', 'vonzot_offcanvas_menu' );

/**
 * Infinite scroll pagination
 *
 * @param object $query
 * @param string $pagination_type
 */
function vonzot_output_pagination( $query = null, $pagination_args = array() ) {

	if ( ! $query ) {
		global $wp_query;
		$main_query = $wp_query;
		$query = $wp_query;
	}

	$pagination_args = extract( wp_parse_args( $pagination_args,
		array(
			'post_type' => 'post',
			'pagination_type' => '',
			'product_category_link_id' => '',
			'video_category_link_id' => '',
			'paged' => 1,
			'container_id' => '',
		)
	) );

	$max = $query->max_num_pages;

	$pagination_type = ( $pagination_type ) ? $pagination_type : apply_filters( 'vonzot_post_pagination', vonzot_get_theme_mod( 'post_pagination' ) );

	$button_class = apply_filters( 'vonzot_loadmore_button_class', 'button', $pagination_type );

	$container_class = apply_filters( 'vonzot_loadmore_container_class', 'trigger-container wvc-element' );

	if ( 'link_to_blog' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_blog_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_posts_text', esc_html__( 'View more posts', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_shop' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_shop_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_products_text', esc_html__( 'View more products', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_shop_category' === $pagination_type && $product_category_link_id ) {
		$cat_url = get_category_link( $product_category_link_id );
		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><?php echo apply_filters( 'vonzot_view_more_products_text', esc_html__( 'View more products', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_portfolio' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_portfolio_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_works_text', esc_html__( 'View more works', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_events' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_events_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_events_text', esc_html__( 'View more events', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_videos' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_videos_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_videos_text', esc_html__( 'View more videos', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_video_category' === $pagination_type && $video_category_link_id ) {
		$cat_url = get_category_link( $video_category_link_id );
		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo esc_url( $cat_url ); ?>"><?php echo apply_filters( 'vonzot_view_more_products_text', esc_html__( 'View more products', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_artists' === $pagination_type ) {

		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo wolf_artists_get_page_link(); ?>"><?php echo apply_filters( 'vonzot_view_more_artists_text', esc_html__( 'View more artists', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_albums' === $pagination_type ) {
		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_albums_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_albums_text', esc_html__( 'View more albums', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_discography' === $pagination_type ) {
		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_discography_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_releases_text', esc_html__( 'View more releases', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'link_to_attachments' === $pagination_type && function_exists( 'vonzot_get_photos_url' ) && vonzot_get_photos_url() ) {
		?>
		<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
			<a class="<?php echo esc_attr( $button_class ); ?>" data-aos="fade" data-aos-once="true" href="<?php echo vonzot_get_photos_url(); ?>"><?php echo apply_filters( 'vonzot_view_more_albums_text', esc_html__( 'View more photos', 'vonzot' ) ); ?></a>
		</div>
		<?php

	} elseif ( 'load_more' === $pagination_type ) {

		wp_enqueue_script( 'vonzot-loadposts' );
		
		$next_page = $paged + 1;

		$next_page_href = get_pagenum_link( $next_page  );
		?>
		<?php if ( 1 < $max && $next_page <= $max ) : ?>
			<div class="<?php echo vonzot_sanitize_html_classes( $container_class ); ?>">
				<a data-current-page="1" data-next-page="<?php echo absint( $next_page ); ?>" data-max-pages="<?php echo absint( $max ); ?>" class="<?php echo esc_attr( $button_class ); ?> loadmore-button" data-current-url="<?php echo vonzot_get_current_url(); ?>" href="<?php echo esc_url( $next_page_href ); ?>"><span><?php echo apply_filters( 'vonzot_load_more_posts_text', esc_html__( 'Load More', 'vonzot' ) ); ?></span></a>
			</div><!-- .trigger-containe -->
		<?php endif; ?>
		<?php

	} elseif ( 'infinitescroll' === $pagination_type ) {

		if ( 'attachment' === $post_type ) {
			vonzot_paging_nav( $query );
		}

	} elseif ( 'none' !== $pagination_type && ( 'numbers' === $pagination_type || 'standard_pagination' === $pagination_type ) ) {
		
		/**
		 * Pagination numbers
		 */
		if ( ! vonzot_is_home_as_blog() ) {
			$GLOBALS['wp_query']->max_num_pages = $max; // overwrite max_num_pages with custom query
			$GLOBALS['wp_query']->query_vars['paged'] = $paged;
		}

		the_posts_pagination( apply_filters( 'vonzot_the_post_pagination_args', array(
			'prev_text' => '<i class="pagination-icon-prev"></i>',
			'next_text' => '<i class="pagination-icon-next"></i>',
		) ) );
	}
}
add_action( 'vonzot_pagination', 'vonzot_output_pagination', 10, 3 );
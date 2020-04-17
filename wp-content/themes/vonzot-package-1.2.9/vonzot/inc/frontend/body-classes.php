<?php
/**
 * Vonzot body classes
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'vonzot_body_classes' ) ) {
	/**
	 * Add specific class to the body depending on theme mods and page template
	 *
	 * @version 1.2.9
	 * @param array $classes
	 * @return array $classes
	 */
	function vonzot_body_classes( $classes ) {

		$classes[] = 'wolf';

		$classes[] = vonzot_get_theme_slug();
		if ( isset( $_COOKIE[ vonzot_get_theme_slug() . '_session_loaded' ] ) ) {
			$classes[] = 'session-loaded';
		}

		if ( vonzot_is_edge() ) {
			$classes[] = 'is-edge';
		} else {
			$classes[] = 'not-edge';
		}

		/* Loading animation type */
		$classes[] = 'loading-animation-type-' . vonzot_get_inherit_mod( 'loading_animation_type' );

		/* Site Layout */
		$classes[] = 'site-layout-' . vonzot_get_inherit_mod( 'site_layout', 'wide' ); // layout

		/* Body BG */
		$background_img_meta = get_post_meta( vonzot_get_inherit_post_id(), '_post_body_background_img', true );

		if ( $background_img_meta ) {
			$classes[] = 'custom-background';
		}

		/* Button Style */
		$classes[] = 'button-style-' . vonzot_get_theme_mod( 'button_style', 'standard' );
		
		if ( is_single() && post_password_required() ) {
			$classes[] = 'password-protected';
		}

		/* Global skin */
		$classes[] = 'global-skin-' . vonzot_get_color_scheme_option(); // global skin

		if ( ! vonzot_is_vc() ) {
			/*
			* Output skin class on non page builder pages only
			*/
			$classes[] = 'skin-' . vonzot_get_color_scheme_option();
		}

		/* Menu Layout */
		$classes[] = 'menu-layout-' .  vonzot_get_menu_layout();

		if ( 'none' !== vonzot_get_menu_layout() ) {
			/* Menu Style */
			$classes[] = 'menu-style-' . vonzot_get_menu_style();
		}

		/* Menu Skin */
		$menu_skin = vonzot_get_inherit_mod( 'menu_skin', 'light' );

		if ( vonzot_get_theme_mod( 'nav_bar_bg_img' ) ) {
			$menu_skin = 'light';
			$classes[] = 'nav-bar-has-bg';
		}

		if ( vonzot_get_inherit_mod( 'top_bar_block_id' ) && ! isset( $_COOKIE['top_bar_closed'] ) ) {
			$classes[] = 'has-top-bar';
		}

		$classes[] = 'menu-skin-' .  vonzot_get_inherit_mod( 'menu_skin', 'light' );

		/* Menu Width */
		$classes[] = 'menu-width-' . vonzot_get_inherit_mod( 'menu_width', 'boxed' );

		/* Mega Menu Width */
		$classes[] = 'mega-menu-width-' . vonzot_get_inherit_mod( 'mega_menu_width', 'boxed' );

		/* Menu Hover Style */
		$classes[] = 'menu-hover-style-' . vonzot_get_inherit_mod( 'menu_hover_style', 'none' );

		/* Menu Sticky */
		$classes[] = 'menu-sticky-' . vonzot_get_inherit_mod( 'menu_sticky_type', 'soft' );

		/* Sub menu color adjustment */
		if ( 'light' === vonzot_get_color_tone( vonzot_get_theme_mod( 'submenu_background_color' ) ) ) {
			$classes[] = 'submenu-bg-light';
		} else {
			$classes[] = 'submenu-bg-dark';
		}

		/* Accent color tune */
		if ( 'light' === vonzot_get_color_tone( vonzot_get_inherit_mod( 'accent_color' ) ) ) {
			$classes[] = 'accent-color-light';
		} else {
			$classes[] = 'accent-color-dark';

			if ( vonzot_color_is_black( vonzot_get_inherit_mod( 'accent_color' ) ) ) {
				$classes[] = 'accent-color-is-black';
			}
		}

		if ( 'none' === vonzot_get_menu_cta_content_type() ) {
			$classes[] = 'no-menu-cta';
		}

		/* Mobile Menu BG */
		if ( vonzot_get_theme_mod( 'mobile_menu_bg_img' ) ) {
			$classes[] = 'mobile-menu-has-bg';
		}

		/* Menu items visiblity */
		$classes[] = 'menu-items-visibility-' . vonzot_get_inherit_mod( 'menu_items_visibility' );

		/* Side Panel */
		if ( vonzot_can_display_sidepanel() ) {
			$classes[] = 'side-panel-position-' . vonzot_get_inherit_mod( 'side_panel_position', 'right' );

			if ( vonzot_get_theme_mod( 'side_panel_bg_img' ) ) {
				$classes[] = 'side-panel-has-bg';
			} else {
				if ( 'light' === vonzot_get_color_tone( vonzot_get_inherit_mod( 'submenu_background_color' ) ) ) {
					$classes[] = 'side-panel-bg-light';
				} else {
					$classes[] = 'side-panel-bg-dark';
				}
			}
		}

		if ( vonzot_get_theme_mod( 'lateral_menu_bg_img' ) ) {
			$classes[] = 'lateral-menu-has-bg';
		}

		if ( vonzot_get_theme_mod( 'mega_menu_bg_img' ) ) {
			$classes[] = 'mega-menu-has-bg';
		}

		if ( vonzot_get_theme_mod( 'overlay_menu_bg_img' ) ) {
			$classes[] = 'overlay-menu-has-bg';
		}

		/* Hero */
		$classes[] = ( vonzot_has_hero() ) ? 'has-hero' : 'no-hero';

		/* Header font tone */
		$classes[] = 'hero-font-' . vonzot_get_header_font_tone();

		/*
		Font class. Allow font size customization depending on font if needed
		*/
		$classes[] = 'body-font-' . sanitize_title( vonzot_get_theme_mod( 'body_font_name' ) );
		$classes[] = 'heading-font-' . sanitize_title( vonzot_get_theme_mod( 'heading_font_name' ) );
		$classes[] = 'menu-font-' . sanitize_title( vonzot_get_theme_mod( 'menu_font_name' ) );
		$classes[] = 'submenu-font-' . sanitize_title( vonzot_get_theme_mod( 'submenu_font_name' ) );

		/* Default Header Image */
		if ( get_header_image() ) {
			$classes[] = 'has-default-header';
		}

		/* Transition animation type */
		$classes[] = 'transition-animation-type-' . vonzot_get_inherit_mod( 'transition_animation_type' );

		/* No logo */
		if ( ! vonzot_get_theme_mod( 'logo_svg' ) && ! vonzot_get_theme_mod( 'logo_light' ) && ! vonzot_get_theme_mod( 'logo_dark' ) ) {
			$classes[] = 'has-text-logo';
		}

		/* Logo visibility */
		$classes[] = 'logo-visibility-' . vonzot_get_inherit_mod( 'logo_visibility' );

		/**
		 * Ajax navigation
		 */
		if ( vonzot_do_ajax_nav() ) {
			$classes[] = 'is-ajax-nav';
		}

		/* Home Blog */
		if ( vonzot_is_home_as_blog() ) {
			$classes[] = 'is-blog-home';
		}

		/* Blog index page */
		if ( vonzot_is_blog_index() ) {
			$classes[] = 'is-blog-index'; // archive blog index (page for posts)
		}

		/* Is WVC activated? */
		if ( vonzot_is_wvc_activated() ) {
			$classes[] = 'has-wvc';
		} else {
			$classes[] = 'no-wvc';
		}

		/* Single post */
		if ( is_singular( 'post' ) ) {

			if ( ! vonzot_display_sidebar() || ! is_active_sidebar( 'sidebar-main' ) ) {
				$classes[] = 'sidebar-disabled';
			}

			$classes[] = 'single-post-layout-' . vonzot_get_single_post_layout();

			$classes[] = vonzot_get_single_post_wvc_layout();

			if ( vonzot_get_theme_mod( 'newsletter_form_single_blog_post' ) ) {
				$classes[] = 'show-newsletter-form';
			} else {
				$classes[] = 'no-newsletter-form';
			}

			if ( vonzot_get_theme_mod( 'post_author_box' ) ) {
				$classes[] = 'show-author-box';
			} else {
				$classes[] = 'no-author-box';
			}

			if ( vonzot_get_theme_mod( 'post_related_posts' ) ) {
				$classes[] = 'show-related-post';
			} else {
				$classes[] = 'no-related-post';
			}
		}

		/* Blog pages */
		if ( vonzot_is_blog() || is_search() && ! vonzot_is_woocommerce_page() ) {
			$classes[] = 'is-blog';
			$classes[] = 'layout-' . vonzot_get_theme_mod( 'post_layout', 'standard' );
			$classes[] = 'display-' . vonzot_get_theme_mod( 'post_display', 'standard' );
		}

		if ( 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ) && function_exists( 'is_account_page' ) && is_account_page() ) {

			$classes[] = 'wc-registration-allowed';
		}

		/* Portfolio */
		if ( vonzot_is_portfolio() ) {
			$classes[] = 'is-portfolio';
			$classes[] = 'layout-' . apply_filters( 'vonzot_portfolio_layout', vonzot_get_theme_mod( 'work_layout', 'standard' ) );
		}

		/* Albums */
		if ( vonzot_is_albums() ) {
			$classes[] = 'is-albums';
			$classes[] = 'layout-' . apply_filters( 'vonzot_albums_layout', vonzot_get_theme_mod( 'gallery_layout', 'standard' ) );
		}

		/* Photos */
		if ( vonzot_is_photos() ) {
			$classes[] = 'is-photos';
			$classes[] = 'layout-' . apply_filters( 'vonzot_photos_layout', vonzot_get_theme_mod( 'attachment_layout', 'standard' ) );
		}

		/* Videos */
		if ( vonzot_is_videos() ) {
			$classes[] = 'is-videos';
			$classes[] = 'layout-' . apply_filters( 'vonzot_videos_layout', vonzot_get_theme_mod( 'video_layout', 'standard' ) );
		}

		/* Artists */
		if ( vonzot_is_artists() ) {
			$classes[] = 'is-artists';
			$classes[] = 'layout-' . apply_filters( 'vonzot_artists_layout', vonzot_get_theme_mod( 'artist_layout', 'standard' ) );
		}

		/* Single video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-post-layout-' . vonzot_get_single_video_layout();
		}

		/* Single MP Event */
		if ( is_singular( 'mp-event' ) ) {
			$classes[] = 'single-post-layout-' . vonzot_get_single_mp_event_layout();
		}

		/* Single MP Column */
		if ( is_singular( 'mp-column' ) ) {
			$classes[] = 'single-post-layout-' . vonzot_get_single_mp_column_layout();
		}

		/* Discography */
		if ( vonzot_is_discography() ) {
			$classes[] = 'is-discography';
			$classes[] = 'layout-' . apply_filters( 'vonzot_discography_layout', vonzot_get_theme_mod( 'release_layout', 'standard' ) );
		}

		/* Event */
		if ( vonzot_is_events() ) {
			$classes[] = 'is-events';
			$classes[] = 'layout-' . apply_filters( 'vonzot_events_layout', vonzot_get_theme_mod( 'event_layout', 'standard' ) );
		}

		/* WooCommerce */
		if ( vonzot_is_woocommerce_page() ) {

			if ( is_singular( 'product' ) ) {
				$classes[] = 'single-product-layout-' . vonzot_get_inherit_mod( 'product_single_layout', 'standard' );
			} else {
				$classes[] = 'is-shop';
				$classes[] = 'layout-' . vonzot_get_theme_mod( 'product_layout', 'standard' );
			}
		}

		/* Single work */
		if ( is_singular( 'work' ) ) {
			$classes[] = 'single-work-layout-' . vonzot_get_single_post_layout();
			$classes[] = 'single-work-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Release */
		if ( is_singular( 'release' ) ) {
			$classes[] = 'single-release-layout-' . vonzot_get_single_post_layout( get_the_ID(), 'sidebar-left' );
			$classes[] = 'single-release-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Video */
		if ( is_singular( 'video' ) ) {
			$classes[] = 'single-video-layout-' . vonzot_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$classes[] = 'single-video-width-' . get_post_meta( get_the_ID(), '_post_width', true );
		}

		/* Single Artist */
		if ( is_singular( 'artist' ) ) {
			$classes[] = 'single-artist-layout-' . vonzot_get_single_post_layout( get_the_ID(), 'fullwidth' );
			$single_artist_content_width = vonzot_get_theme_mod( 'artist_single_layout' );

			if ( get_post_meta( get_the_ID(), '_post_width', true ) ) {
				$single_artist_content_width = get_post_meta( get_the_ID(), '_post_width', true );
			}

			$classes[] = 'single-artist-width-' . $single_artist_content_width;

			if ( get_post_meta( get_the_ID(), '_artist_hide_pagination', true ) ) {
				$classes[] = 'single-artist-hide-pagination';
			}
		}

		/* Page template clean classes */
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-default';
		}

		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-full-width';
		}

		if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) {
			$classes[] = 'page-sidebar-right';
		}

		if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) {
			$classes[] = 'page-sidebar-left';
		}

		if ( is_page_template( 'page-templates/post-archives.php' ) ) {
			$classes[] = 'page-post-archives';
		}

		/* Hero */

		$hero_layout = vonzot_get_inherit_mod( 'hero_layout' );

		$post_hero_layout_meta = get_post_meta( get_the_ID(), '_post_hero_layout', true );
		$show_hero = ( 'none' !== $post_hero_layout_meta );

		if ( is_single() && $show_hero ) {

			if ( $post_hero_layout_meta ) {
				$hero_layout = $post_hero_layout_meta;
			
			} else {
				
				$hero_post_types = array( 'post', 'gallery', 'work', 'release', 'event', 'video', 'artist' );

				foreach ( $hero_post_types as $post_type ) {
					
					$post_type_hero_layout_mod = vonzot_get_theme_mod( $post_type . '_hero_layout' );

					if ( is_singular( $post_type ) && $post_type_hero_layout_mod && $show_hero ) {

						$hero_layout = $post_type_hero_layout_mod;
				
					} else {
						$hero_layout = $hero_layout;
					}
				}
			}

		}

		$classes[] = 'hero-layout-' . $hero_layout;

		if ( get_post_meta( vonzot_get_inherit_post_id(), '_post_hide_title_text', true ) ) {

			$classes[] = 'post-hide-title-text';
		} else {

			$classes[] = 'post-is-title-text';
		}

		/* Post title */
		if ( 'none' === vonzot_get_inherit_mod( 'hero_type' ) ) {

			$classes[] = 'post-hide-hero';

		} else {

			$classes[] = 'post-is-hero';
		}

		/* Footer widget area layout */
		$classes[] = 'footer-type-' . vonzot_get_inherit_mod( 'footer_type' );
		$classes[] = 'footer-skin-' . vonzot_get_inherit_mod( 'footer_skin', 'dark' );
		$classes[] = 'footer-widgets-layout-' . vonzot_get_theme_mod( 'footer_widgets_layout', '4-cols' );
		$classes[] = 'footer-layout-' . vonzot_get_theme_mod( 'footer_layout', 'boxed' );

		/* Bottom bar layout */
		$classes[] = 'bottom-bar-layout-' . vonzot_get_theme_mod( 'bottom_bar_layout', 'centered' );

		if ( get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true ) ) {
			$classes[] = 'bottom-bar-hidden';
		} else {
			$classes[] = 'bottom-bar-visible';
		}

		if ( class_exists( 'Wolf_404_Error_Page' ) || class_exists( 'PP_404Page' ) ) {
			$classes[] = 'has-404-plugin';
		} else {
			$classes[] = 'no-404-plugin';
		}

		return $classes;
	}
	add_filter( 'body_class', 'vonzot_body_classes' );
}

/**
 * Add data attribute to body
 *
 * @version 1.2.9
 * @param array $classes
 * @return array $classes
 */
function vonzot_body_data( $classes ) {
   
    $classes[] = '" data-hero-font-tone="' . vonzot_get_header_font_tone() . '';

    return $classes;
}
add_filter( 'body_class', 'vonzot_body_data', 9999 );
<?php
/**
 * Vonzot site hook functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function vonzot_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", get_bloginfo( 'pingback_url' ) );
	}
}
add_action( 'wp_head', 'vonzot_pingback_header' );

/**
 * Output anchor at the very top of the page
 */
function vonzot_output_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'vonzot_body_start', 'vonzot_output_top_anchor' );

/**
 * Output loader overlay
 */
function vonzot_page_loading_overlay() {

	$show_overlay = apply_filters( 'vonzot_display_loading_overlay', 'none' != vonzot_get_inherit_mod( 'loading_animation_type', 'none' ) );

	if ( ! $show_overlay ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php vonzot_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'vonzot_body_start', 'vonzot_page_loading_overlay' );

/**
 * Output ajax loader overlay
 */
function vonzot_ajax_loading_overlay() {

	if ( 'none' === vonzot_get_theme_mod( 'ajax_animation_type', 'none' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php vonzot_spinner(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'vonzot_ajax_loading_overlay' );

/**
 * Add panel closer overlay
 */
function vonzot_add_panel_closer_overlay() {
	$toggle_class = 'toggle-side-panel';

	if ( 'offcanvas' === vonzot_get_inherit_mod( 'menu_layout' ) ) {
		$toggle_class = 'toggle-offcanvas-menu';
	}

	$toggle_class = apply_filters( 'vonzot_panel_closer_overlay_class', $toggle_class );
	?>
	<div id="panel-closer-overlay" class="panel-closer-overlay <?php echo vonzot_sanitize_html_classes( $toggle_class ); ?>"></div>
	<?php
}
add_action( 'vonzot_main_content_start', 'vonzot_add_panel_closer_overlay' );

/**
 * Scroll to top arrow
 */
function vonzot_scroll_top_link() {
	?>
	<a href="#top" id="back-to-top"><?php echo apply_filters( 'vonzot_backtop_text', esc_html__( 'Back to the top', 'vonzot' ) ); ?></a>
	<?php
}
add_action( 'vonzot_body_start', 'vonzot_scroll_top_link' );

/**
 * Output frame
 */
function vonzot_frame_border() {

	if ( 'frame' === vonzot_get_inherit_mod( 'site_layout' ) || vonzot_is_customizer() ) {
		?>
		<span class="frame-border frame-border-top"></span>
		<span class="frame-border frame-border-bottom"></span>
		<span class="frame-border frame-border-left"></span>
		<span class="frame-border frame-border-right"></span>
		<?php
	}
}
add_action( 'vonzot_body_start', 'vonzot_frame_border' );

/**
 * Hero
 */
function vonzot_output_hero_content() {

	$show_hero = true;

	$no_hero_post_types = apply_filters( 'vonzot_no_header_post_types', array( 'product', 'release', 'event', 'proof_gallery', 'attachment' ) );
	
	if ( is_single() && in_array( get_post_type(), $no_hero_post_types ) ) {
		$show_hero = false;
	}

	if ( is_single() && 'none' === get_post_meta( get_the_ID(), '_post_hero_layout', true ) ) {
		$show_hero = false;
	}

	if ( apply_filters( 'vonzot_show_hero', $show_hero ) ) {
		get_template_part( 'components/layout/hero', 'content' );
	}
}
add_action( 'vonzot_hero', 'vonzot_output_hero_content' );

/**
 * Output Hero background
 *
 * Diplsay the hero background through the hero_background hook
 */
function vonzot_output_hero_background() {

	echo vonzot_get_hero_background();

	if ( vonzot_get_inherit_mod( 'hero_scrolldown_arrow' ) ) {
		echo '<a class="scroll-down" id="hero-scroll-down-arrow" href="#"><i class="fa scroll-down-icon"></i></a>';
	}
}
add_action( 'vonzot_hero_background', 'vonzot_output_hero_background' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function vonzot_bottom_bar() {

	$class = 'site-infos wrap';
	$hide_bottom_bar = get_post_meta( get_the_ID(), '_post_bottom_bar_hidden', true );
	$services = sanitize_text_field( vonzot_get_theme_mod( 'footer_socials' ) );
	$display_menu = has_nav_menu( 'tertiary' );
	$display_menu = false;
	$credits = vonzot_get_theme_mod( 'copyright' );

	if ( 'yes' === $hide_bottom_bar ) {
		return;
	}

	if ( $services || $display_menu || $credits ) :
	?>
	<div class="site-infos clearfix">
		<div class="wrap">
			<div class="bottom-social-links">
				<?php
					/**
					 * Social icons
					 */
					if ( function_exists( 'wvc_socials' ) && $services ) {
						echo wvc_socials( array( 'services' => $services, 'size' => 'fa-1x' ) );
					}
				?>
			</div><!-- .bottom-social-links -->
			<?php
				/**
				 * Fires in the Vonzot bottom menu
				 *
				 */
				do_action( 'vonzot_bottom_menu' );
			?>
			<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
			<div class="clear"></div>
			<?php endif; ?>
			<div class="credits">
				<?php
					/**
					 * Fires in the Vonzot footer text for customization.
					 *
					 * @since Vonzot 1.0
					 */
					do_action( 'vonzot_credits' );
				?>
			</div><!-- .credits -->
		</div>
	</div><!-- .site-infos -->
	<?php
	endif;

}
add_action( 'vonzot_bottom_bar', 'vonzot_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since Vonzot 1.0.0
 */
function vonzot_site_infos() {

	$footer_text = vonzot_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		echo apply_filters( 'vonzot_copyright_text', $footer_text );
	}
}
add_action( 'vonzot_credits', 'vonzot_site_infos' );

/**
 * Output top block beafore header using WVC Content Block plugin function
 */
function vonzot_output_top_bar_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = vonzot_get_the_ID();

	$block_mod = vonzot_get_theme_mod( 'top_bar_block_id' );
	$block_meta = get_post_meta( $post_id, '_post_top_bar_block_id', true );
	
	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( vonzot_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == vonzot_get_woocommerce_shop_page_id();
	
	$is_wc = vonzot_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'vonzot_force_display_shop_top_bar_block_id', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta = get_post_meta( $blog_page_id, '_post_top_bar_block_id', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	
	$is_blog = vonzot_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'vonzot_force_display_blog_top_bar_block_id', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = vonzot_get_videos_page_id();
	$video_meta = get_post_meta( $video_page_id, '_post_top_bar_block_id', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;
	
	$is_video = vonzot_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta && apply_filters( 'vonzot_force_display_video_top_bar_block_id', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = vonzot_get_portfolio_page_id();
	$portfolio_meta = get_post_meta( $portfolio_page_id, '_post_top_bar_block_id', true );
	$is_portfolio_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $portfolio_page_id;
	
	$is_portfolio = vonzot_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta && apply_filters( 'vonzot_force_display_portfolio_top_bar_block_id', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = vonzot_get_artists_page_id();
	$artists_meta = get_post_meta( $artists_page_id, '_post_top_bar_block_id', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;
	
	$is_artists = vonzot_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta && apply_filters( 'vonzot_force_display_artists_top_bar_block_id', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = vonzot_get_discography_page_id();
	$releases_meta = get_post_meta( $releases_page_id, '_post_top_bar_block_id', true );
	$is_releases_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $releases_page_id;
	
	$is_releases = vonzot_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta && apply_filters( 'vonzot_force_display_releases_top_bar_block_id', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = vonzot_get_events_page_id();
	$events_meta = get_post_meta( $events_page_id, '_post_top_bar_block_id', true );
	$is_events_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $events_page_id;
	
	$is_events = vonzot_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta && apply_filters( 'vonzot_force_display_events_top_bar_block_id', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {

			$block = get_post_meta( vonzot_get_woocommerce_shop_page_id(), '_post_top_bar_block_id', true );
		
		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_top_bar_block_id', true );
		}
	}

	if ( $block && 'none' !== $block && function_exists( 'wccb_block' ) ) {
		
		wp_enqueue_script( 'js-cookie' );

		echo '<div id="top-bar-block">';
		echo wccb_block( $block );

		if ( 'yes' === vonzot_get_inherit_mod( 'top_bar_closable' ) ) {
			echo '<a href="#" id="top-bar-close">' . esc_html__( 'Close', 'vonzot' ) . '</a>';
		}

		echo '</div>';
	}
}
add_action( 'vonzot_top_bar_block', 'vonzot_output_top_bar_block' );

/**
 * Output top block after header using WVC Content Block plugin function
 */
function vonzot_output_after_header_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = vonzot_get_the_ID();

	$block_mod = vonzot_get_theme_mod( 'after_header_block' );
	$block_meta = get_post_meta( $post_id, '_post_after_header_block', true );
	
	if ( ! is_single() && ! is_page() ) {
		$block_meta = null;
	}

	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( vonzot_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == vonzot_get_woocommerce_shop_page_id();
	
	$is_wc = vonzot_is_woocommerce_page() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'vonzot_force_display_shop_after_header_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta = get_post_meta( $blog_page_id, '_post_after_header_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	
	$is_blog = vonzot_is_blog() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'vonzot_force_display_blog_after_header_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	/* Video page inheritance */
	$video_page_id = vonzot_get_videos_page_id();
	$video_meta = get_post_meta( $video_page_id, '_post_after_header_block', true );
	$is_video_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $video_page_id;
	
	$is_video = vonzot_is_videos() && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $video_meta && apply_filters( 'vonzot_force_display_video_after_header_block', $is_video ) ) {
		$block = $video_meta;
	}

	/* Portfolio page inheritance */
	$portfolio_page_id = vonzot_get_portfolio_page_id();
	$portfolio_meta = get_post_meta( $portfolio_page_id, '_post_after_header_block', true );
	$is_portfolio_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $portfolio_page_id;
	
	$is_portfolio = vonzot_is_portfolio() || is_singular( 'work' );

	if ( ! $block_meta && 'none' !== $block_meta && $portfolio_meta && apply_filters( 'vonzot_force_display_portfolio_after_header_block', $is_portfolio ) ) {
		$block = $portfolio_meta;
	}

	/* Artists page inheritance */
	$artists_page_id = vonzot_get_artists_page_id();
	$artists_meta = get_post_meta( $artists_page_id, '_post_after_header_block', true );
	$is_artists_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $artists_page_id;
	
	$is_artists = vonzot_is_artists() || is_singular( 'artist' );

	if ( ! $block_meta && 'none' !== $block_meta && $artists_meta && apply_filters( 'vonzot_force_display_artists_after_header_block', $is_artists ) ) {
		$block = $artists_meta;
	}

	/* Releases page inheritance */
	$releases_page_id = vonzot_get_discography_page_id();
	$releases_meta = get_post_meta( $releases_page_id, '_post_after_header_block', true );
	$is_releases_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $releases_page_id;
	
	$is_releases = vonzot_is_discography() || is_singular( 'release' );

	if ( ! $block_meta && 'none' !== $block_meta && $releases_meta && apply_filters( 'vonzot_force_display_releases_after_header_block', $is_releases ) ) {
		$block = $releases_meta;
	}

	/* Events page inheritance */
	$events_page_id = vonzot_get_events_page_id();
	$events_meta = get_post_meta( $events_page_id, '_post_after_header_block', true );
	$is_events_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $events_page_id;
	
	$is_events = vonzot_is_events() || is_singular( 'event' );

	if ( ! $block_meta && 'none' !== $block_meta && $events_meta && apply_filters( 'vonzot_force_display_events_after_header_block', $is_events ) ) {
		$block = $events_meta;
	}

	if ( is_search() ) {
		$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );

		if ( isset( $_GET['post_type'] ) && 'product' === $_GET['post_type'] ) {

			$block = get_post_meta( vonzot_get_woocommerce_shop_page_id(), '_post_after_header_block', true );
		
		} else {
			$block = get_post_meta( get_option( 'page_for_posts' ), '_post_after_header_block', true );
		}
	}

	$block = apply_filters( 'vonzot_after_header_block_id', $block );

	if ( $block && 'none' !== $block && function_exists( 'wccb_block' ) ) {
		echo wccb_block( $block );
	}
}
add_action( 'vonzot_after_header_block', 'vonzot_output_after_header_block' );

/**
 * Output bottom block before footer using WVC Content Block plugin function
 */
function vonzot_output_before_footer_block() {

	if ( ! class_exists( 'Wolf_Vc_Content_Block' ) || ! defined( 'WPB_VC_VERSION' ) ) {
		return;
	}

	if ( is_404() ) {
		return;
	}

	$post_id = vonzot_get_the_ID();

	$block_mod = vonzot_get_theme_mod( 'before_footer_block' );
	$block_meta = get_post_meta( $post_id, '_post_before_footer_block', true );
	$block = ( $block_meta ) ? $block_meta : $block_mod;

	/* Shop page inheritance */
	$wc_meta = get_post_meta( vonzot_get_woocommerce_shop_page_id(), '_post_before_footer_block', true );
	$is_wc_page_child = is_page() && wp_get_post_parent_id( $post_id ) == vonzot_get_woocommerce_shop_page_id();
	$is_wc = ( vonzot_is_woocommerce_page() || $is_wc_page_child || is_singular( 'product' ) );

	if ( ! $block_meta && 'none' !== $block_meta && $wc_meta && apply_filters( 'vonzot_force_display_shop_pre_footer_block', $is_wc ) ) {
		$block = $wc_meta;
	}

	/* Blog page inheritance */
	$blog_page_id = get_option( 'page_for_posts' );
	$blog_meta = get_post_meta( $blog_page_id, '_post_before_footer_block', true );
	$is_blog_page_child = is_page() && wp_get_post_parent_id( $post_id ) == $blog_page_id;
	$is_blog = ( vonzot_is_blog() || $is_blog_page_child ) && ! is_single();

	if ( ! $block_meta && 'none' !== $block_meta && $blog_meta && apply_filters( 'vonzot_force_display_blog_pre_footer_block', $is_blog ) ) {
		$block = $blog_meta;
	}

	$block = apply_filters( 'vonzot_before_footer_block_id', $block );

	if ( $block && 'none' !== $block && function_exists( 'wccb_block' ) ) {
		echo wccb_block( $block );
	}
}
add_action( 'vonzot_before_footer_block', 'vonzot_output_before_footer_block', 28 );


/**
 * Output music network icons
 *
 * @see Wolf Music Network http://wolfthemes.com/plugin/wolf-music-network/
 */
function vonzot_output_music_network() {

	if ( function_exists( 'wolf_music_network' ) ) {
		echo '<div class="music-social-icons-container clearfix">';
			wolf_music_network();
		echo '</div><!--.music-social-icons-container-->';
	}

}
add_action( 'vonzot_before_footer_block', 'vonzot_output_music_network' );

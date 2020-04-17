<?php
/**
 * Vonzot admin import functions functions
 *
 * @link https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Disable OCDI PT branding
 *
 * @param bool
 * @return bool
 */
function vonzot_disable_ocdi_pt_branding( $bool ) {
	return true;
}
add_filter( 'pt-ocdi/disable_pt_branding', 'vonzot_disable_ocdi_pt_branding' );

/**
 * Flush rewrite rules before import
 *
 * Make sure all CPT are registered
 */
function vonzot_flush_rewrite_rules_before_import() {
	flush_rewrite_rules();
}
add_action( 'pt-ocdi/before_content_import_execution', 'vonzot_flush_rewrite_rules_before_import' );

/**
 * Set menu location after demo import
 *
 * @param array $menu_name
 */
function vonzot_set_menu_locations( $menus = array() ) {

	$menu_to_insert = array();

	foreach ( $menus as $location => $name ) {
		$menu = get_term_by( 'name', $name, 'nav_menu' );

		if ( $menu ) {
			$menu_to_insert[ $location ] = $menu->term_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $menu_to_insert );
}

/**
 * Set pages after import
 *
 * Assign each possible page from plugin (Home and Blog pages, Wolf plugins pages, WooCommerce pages etc...)
 */
function vonzot_set_pages_after_import() {

	/* Assign front page and posts page (blog page). */
	$front_page = get_page_by_title( 'Home' );
	$blog_page  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );

	if ( $front_page ) {
		update_option( 'page_on_front', $front_page->ID );
	} else {
		$front_page = get_page_by_title( 'Main Home' );

		if ( $front_page ) {
			update_option( 'page_on_front', $front_page->ID );
		}
	}

	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}

	/* Assign plugins pages */
	$wolf_pages = array(
		'Portfolio', 'Albums', 'Videos', 'Discography', 'Events', 'Artists', 'Wishlist',
	);

	foreach ( $wolf_pages as $page_title ) {

		$page = get_page_by_title( $page_title );

		if ( $page ) {
			update_option( '_wolf_' . strtolower( $page_title ) . '_page_id', $page->ID );
		}
	}

	/* Assign WooCommerce pages */
	$woocommerce_pages = array(
		'Shop', 'Cart', 'Checkout', 'My Account', 'Terms & Conditions'
	);

	foreach ( $woocommerce_pages as $page_title ) {

		$page = get_page_by_title( $page_title );

		if ( 'My Account' == $page_title ) {

			$page_slug = 'myaccount';

		} elseif ( 'Terms & Conditions' == $page_title ) {

			$page_slug = 'terms';

		} else {
			$page_slug = strtolower( $page_title );
		}

		if ( $page ) {
			update_option( 'woocommerce_' . $page_slug . '_page_id', $page->ID );
		}
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_set_pages_after_import' );

/**
 * Demo importer Intro text
 *
 * @param string $default_text
 * @return string
 */
function vonzot_plugin_intro_text( $default_text ) {

	ob_start();
	?>
	<div class="vonzot-ocdi-intro-text">

		<h1><?php esc_html_e( 'Install demo content', 'vonzot' ); ?></h1>

		<p class="about-description">
			<?php esc_html_e( 'Importing demo data is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch.', 'vonzot' ); ?>
		</p>

		<hr>

		<p><?php esc_html_e( 'When you import the data, the following things might happen', 'vonzot' ); ?>:</p>

		<ul>
			<li><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'vonzot' ); ?></li>
			<li><?php esc_html_e( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'vonzot' ); ?></li>
			<li><?php esc_html_e( 'Images will be downloaded from our server.', 'vonzot' ); ?></li>
			<li><?php esc_html_e( 'Please click on the "Import" button only once and wait, it can take a few minutes.', 'vonzot' ); ?></li>
		</ul>

		<div class="vonzot-ocdi-notice">
			<h4><?php esc_html_e( 'Important', 'vonzot' ); ?></h4>

			<ul>
				<li>
					<?php
					printf(
						vonzot_kses( __( 'Before you begin, <strong>make sure that your server settings fulfill the <a href="%s">server requirements</a></strong>.', 'vonzot' ) ),
						admin_url( 'themes.php?page=vonzot-theme-about' )
					);
				?></li>
				<li><?php esc_html_e( 'Make sure all the required plugins are activated.', 'vonzot' ); ?></li>
				<li><?php
					printf(
						vonzot_kses( __( 'The <strong>Site Language</strong> must be set to "%s" in the "Settings" > "General" panel . You will be able to chage it afterwards.', 'vonzot' ) ),
						'English (United States)'
					);
				?></li>
				<li><?php esc_html_e( 'Deactivate all 3rd party plugins except the one recommended by the theme.', 'vonzot' ); ?></li>
				<li><?php esc_html_e( 'It is recommended to delete all pages that may have been created by plugins and empty the trash to avoid duplicate content.', 'vonzot' ); ?></li>
				<li><?php esc_html_e( 'It is always recommended to run the import on a fresh WordPress installation.', 'vonzot' ); ?></li>
				<li><?php esc_html_e( 'Some of the images may be replaced by placeholder images if they are copyrighted material.', 'vonzot' ); ?></li>
				<li><?php esc_html_e( 'As custom scripts may be used on the demo website to showcase layout variation options, some layout example pages may show the default customizer settings.', 'vonzot' ); ?></li>
				<li><?php
					printf(
						vonzot_kses( __( 'In the case of import failure, we recommend resetting your install before try it again using <a href="%s" target="_blank">WordPress Reset</a> plugin.', 'vonzot' ) ),
						'https://wordpress.org/plugins/wordpress-reset/'
					);
				?></li>
				<li><?php
					printf(
						vonzot_kses( __( 'If you have any issue importing the demo content, please check the <a href="%s" target="_blank">plugin troubleshooting documentation</a>.', 'vonzot' ) ),
						'https://github.com/proteusthemes/one-click-demo-import/blob/master/docs/import-problems.md'
					);
				?></li>
				<li><?php printf(
						vonzot_kses( __( 'Importing the demo content may <strong>take a while</strong>. Have a snack and don\'t refresh the page or close the window until it\'s done!', 'vonzot' ) ) ); ?></li>
			</ul>
		</div><!-- .vonzot-ocdi-notice -->
		<hr>
		<h4><?php esc_html_e( 'Warning', 'vonzot' ); ?></h4>
		<p><?php
			printf(
				vonzot_kses( __( 'Successfully importing the demo data into WordPress is not something we can guaranty at 100&#37; for all users.<br>There are a lot of variables that come into play, over which we have no control. Most of the time, the main issues are <a href="%s" target="_blank">bad shared hosting servers</a>.<br>If you are not able to import the demo data using the one-click demo importer, you can still use the alternative way described at the end of <a href="%s" target="_blank">this post</a>.', 'vonzot' ) ),
				'https://wolfthemes.ticksy.com/article/11668/',
				'https://wolfthemes.ticksy.com/article/11656/'
			);
		?></p>
		<p><?php
			printf(
				vonzot_kses( __( '<strong>Do you want us to take care of everything for you? <a target="_blank" href="%s">Learn more &rarr;</a></strong>', 'vonzot' ) ),
				'https://wolfthemes.com/services'
			);
		?></p>
		<hr>
	</div><!-- .vonzot-ocdi-intro-text -->
	<?php
	return ob_get_clean();
}
add_filter( 'pt-ocdi/plugin_intro_text', 'vonzot_plugin_intro_text' );

/**
 * Replace hard coded URLs from demo data content to local URL
 *
 * Scan external URL and replace them by local ones in post content
 */
function vonzot_replace_wvc_content_urls_after_import() {

	$pages = get_posts( array( 'posts_per_page' => -1, ) );
	$url_regex = '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=_-]+/';
	$demo_url_reg_ex = '/(http|https)?:\/\/([a-z0-9.]+)\wolfthemes.com/';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post( $page_id )->post_content; // check this
		$content = preg_replace_callback( $url_regex, function ( $matches ) use ( $demo_url_reg_ex ) {

			$output = '';

			if ( isset( $matches[0] ) ) {
				$url = $matches[0];
				if ( preg_match( $demo_url_reg_ex, $url, $matches ) ) {

					if ( isset( $matches[0] ) ) {

						$vonzot_root_url = $matches[0];
						$site_url = home_url( '/' ); // current site url
						$url_array = explode( '/', $url );
						if ( isset( $url_array[3] ) ) {

							$demo_slug = $url_array[3];
							$vonzot_url = $vonzot_root_url . '/' . $demo_slug . '/';
							$output .= str_replace( $vonzot_url, $site_url, $url );
						}
					}
				}
			}

			return $output;

		}, $content );

		/* Update content */
		$post = array(
			'ID' => $page_id,
			'post_content' => $content,
		);

		/* Update the post into the database */
		wp_update_post( $post );
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_replace_wvc_content_urls_after_import' );

/**
 * Replace hard coded URLs from demo data to local URL
 */
function vonzot_replace_menu_item_custom_urls_after_import() {

	/* Update hard coded links in menu items */
	$main_menu = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
	$demo_url_reg_ex = '/(http|https)?:\/\/([a-z0-9.]+)\wolfthemes.com/';

	if ( $main_menu ) {

		$nav_items = wp_get_nav_menu_items( $main_menu->term_id );

		foreach ( $nav_items as $nav_item ) {

			if ( 'custom' === $nav_item->type ) {

				$nav_item_url = $nav_item->url;
				if ( preg_match( $demo_url_reg_ex, $nav_item_url, $matches ) ) {

					if ( isset( $matches[0] ) ) {
						$vonzot_root_url = $matches[0];

						$site_url = home_url( '/' ); // current site url
						$url_array = explode( '/', $nav_item_url );

						if ( isset( $url_array[3] ) ) {
							$demo_slug = $url_array[3];

							$vonzot_url = $vonzot_root_url . '/' . $demo_slug . '/';
							$new_nav_item_url = str_replace( $vonzot_url, $site_url, $nav_item_url );
							$menu_item_db_id = $nav_item->ID;
							update_post_meta( $menu_item_db_id, '_menu_item_url', esc_url_raw( $new_nav_item_url ) );
						}
					}
				}
			}
		}
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_replace_menu_item_custom_urls_after_import' );

/**
 * Remove image mods like logos
 *
 * As they logo image previews don't appear after import, it may be confusing for users
 * We will remove the logo mods until it's fixed by the cusomizer import/export plugin or WordPress core
 */
function vonzot_remove_mods_after_import() {
	remove_theme_mod( 'logo_dark' );
	remove_theme_mod( 'logo_light' );
	remove_theme_mod( 'logo_svg' );
	remove_theme_mod( 'custom_css' );
	remove_theme_mod( 'wp_css' );
}
add_action( 'pt-ocdi/after_import', 'vonzot_remove_mods_after_import' );

/**
 * Set permalinks after import
 */
function vonzot_set_permalinks_and_flags_after_import() {

	add_option( vonzot_get_theme_slug() . '_demo_data_imported', true );

	/* Set pretty permalinks if they're not set yet */
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%year%/%monthnum%/%postname%/' );
		flush_rewrite_rules();
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_set_permalinks_and_flags_after_import' );

/**
 * Get all image we don't want in the demo for copyright reasons and replace them by placeholders
 */
function vonzot_replace_excluded_attachment_from_demo_data() {
	$args = array(
		'post_status' => 'inherit',
		'post_type' => array( 'attachment' ),
		'posts_per_page' => -1,
		'meta_key' => '_wolf_exclude_attachment_from_demo_data',
	);

	$all_sizes = array();
	$attachments = get_posts( $args );

	$default_image_sizes = get_intermediate_image_sizes();
	global $_wp_additional_image_sizes;

	if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
		$all_sizes = array_merge( $default_image_sizes, array_keys( $_wp_additional_image_sizes ) );
	}
	foreach ( $attachments as $post ) {

		$post_id = $post->ID;

		$rand = rand( 0, 1084 ); 
			wp_delete_attachment( $post_id, true );
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_replace_excluded_attachment_from_demo_data' );
//add_action( 'admin_init', 'vonzot_replace_excluded_attachment_from_demo_data' );
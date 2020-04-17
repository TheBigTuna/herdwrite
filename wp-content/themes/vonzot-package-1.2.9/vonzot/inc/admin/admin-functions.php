<?php
/**
 * Vonzot admin functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Enables the Excerpt meta box in Work & Release edit screen.
 *
 * For old version of Wolf Portfolio & Wolf Discography
 */
function vonzot_add_excerpt_support_for_post_types() {
	add_post_type_support( 'work', 'excerpt' );
	add_post_type_support( 'release', 'excerpt' );
}
add_action( 'init', 'vonzot_add_excerpt_support_for_post_types' );

/**
 * Add helper admin notice on work post
 */
function vonzot_help_admin_notice() {

	global $pagenow;

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) {
		$post_type = esc_attr( $_GET['post_type'] );

	} elseif ( isset( $_GET['post'] ) ) {
		$post_type = get_post_type( absint( $_GET['post'] ) );
	}

	/* Offer to import demo content */

	$theme_slug = vonzot_get_theme_slug();
	if ( isset( $_GET[ $theme_slug . '-dismiss-demo-data-import'] ) && 'yes' === esc_attr( $_GET[ $theme_slug . '-dismiss-demo-data-import'] ) ) {
		update_option( $theme_slug . '_dismiss_demo_data_import', true );
	}
	$import_demo_flag = get_option( $theme_slug . '_demo_data_imported' );
	$dissmissed_import_demo_flag = get_option( $theme_slug . '_dismiss_demo_data_import' );
	$is_ocdi_page = ( isset( $_GET['page'] ) && 'pt-one-click-demo-import' === $_GET['page'] );

	if ( ! $import_demo_flag && ! $dissmissed_import_demo_flag && ! $is_ocdi_page && class_exists( 'OCDI_Plugin' ) && 'index.php' === $pagenow ) {
		
		$cookie_id = $theme_slug . '_wolf_install_demo_data';

		$message = '<h3>';
		$message .= esc_html__( 'Hey there, would you like to import the demo content to help you to get started?', 'vonzot' );
		$message .= '</h3>';

		$message .= '<h4>';
		$message .= esc_html__( 'In this case, please ignore the plugin page setups.', 'vonzot' );
		$message .= '</h4>';

		$message .= '<p>';
		$message .= sprintf( vonzot_kses( __( 'If you dismiss this notification, you can still access the demo import page via the "Appearance > <a href="%s">Import Demo Data</a>" panel.', 'vonzot' ) ),
			esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) )
		);
		$message .= '</p><br>';

		$message .= sprintf(
			vonzot_kses( __( '<a href="%s" class="button button-primary button-hero">Install demo data</a><br>', 'vonzot' ) ),
			esc_url( admin_url( 'themes.php?page=pt-one-click-demo-import' ) )
		);

		$message .= '<br><p>';
		$message .= sprintf(
			vonzot_kses( __( '<a href="%1$s">No thanks</a><br>', 'vonzot' ) ),
			esc_url( admin_url( 'index.php?' . $theme_slug . '-dismiss-demo-data-import=yes' ) )
		);
		$message .= '</p>';

		vonzot_admin_notice( $message, 'info' );
	}

	/*----------------------------*/

	if ( $import_demo_flag && class_exists( 'WooCommerce' ) && 'index.php' === $pagenow ) {

		$cookie_id = $theme_slug . '_wolf_woocommerce_pages_set';

		$message = esc_html__( 'The demo data was successfully imported. ', 'vonzot' );

		$message .= sprintf(
			vonzot_kses( __( '<a href="%1$s" class="button button-primary button-hero">Install demo data</a><br>', 'vonzot' ) ),
			esc_url( admin_url( 'admin.php?page=wc-settings&tab=products&section=display' ) )
		);
	}

	/*----------------------------*/

	/* Info Work */
	if ( 'work' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'Please use the main text editor to showcase your media content and the "excerpt" box to insert an explanatory text in the page.', 'vonzot' );
		$cookie_id = $theme_slug . '_wolf_work_help';

		vonzot_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}

	/* Release */
	if ( 'release' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'You can use the main text editor to showcase your media content usign the page builder, with a playlist for example. In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'vonzot' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		vonzot_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}

	/* Artist */
	if ( 'artist' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {
		$message = esc_html__( 'You can use the main text editor for the "Biography" tab and the "Excerpt" box for an additional text below the artist\'s name. If you use the page builder for the bio, it is recommended to set your row "Content Width" to "Full Width". If you want to use the page builder to build your page entirely, you must choose the "Custom" layout option in the options below the text editor.', 'vonzot' );
		$cookie_id = $theme_slug . '_wolf_release_help';

		vonzot_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}

	/* Set exceprt content recommendation */
	if ( ( 'mp-event' === $post_type || 'mp-colum' === $post_type ) && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {

		$message = esc_html__( 'If your post content is designed with the page builder, it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'vonzot' );
		$cookie_id = $theme_slug . '_wolf_mp_timetable_help';

		vonzot_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}

	/* Set exceprt content recommendation */
	if ( 'post' === $post_type && ( 'post.php' === $pagenow || 'post-new.php' === $pagenow  ) ) {

		if ( vonzot_has_vc_content() ) {
			$message = esc_html__( 'If your post content is designed with the page builder, it is recommended to enter a post text sample in the "excerpt" box.', 'vonzot' );
			$message .= ' ' . esc_html__( 'In this case it is recommended to set your row "Content Width" to "Full Width" and the background settings to "No Background".', 'vonzot' );
			$cookie_id = $theme_slug . '_wolf_post_help';

			vonzot_admin_notice( $message, 'info', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
		}
	}

	/* Gutenberg */
	$gutenberg_disable = ( $gutenberg_disable = get_option( 'wpb_js_gutenberg_disable' ) ) ? $gutenberg_disable : false;

	if ( ! $gutenberg_disable && defined( 'WPB_VC_VERSION' ) && 'index.php' === $pagenow && ! defined( 'DOING_AJAX' ) ) {
		$message = sprintf(
			vonzot_kses( __( 'It seems that both <strong>%1$s</strong> and <strong>%2$s</strong> are enabled. You can disable %2$s in the <a href="%3$s">%4$s</a><br>', 'vonzot' ) ),
			'WPBakery Page Builder',
			'Gutenberg',
			esc_url( admin_url( 'admin.php?page=vc-general' ) ),
			'WPBakery Page Builder General Settings.'
		);
		$cookie_id = $theme_slug . '_wolf_gutenberg_not_disabled';

		vonzot_admin_notice( $message, 'warning', $cookie_id, esc_html__( 'Dismiss this notice', 'vonzot' ) );
	}
}
add_action( 'admin_init', 'vonzot_help_admin_notice' );

/**
 * Custom admin notice
 *
 * @param string $message
 * @param string $type error|warning|info|success
 * @param string $cookie_id if set a cookie will be use to hide the notice permanently
 */
function vonzot_admin_notice( $message = null, $type = null, $cookie_id = null, $dismiss_text = null ) {

	if ( ! $message ) {
		return;
	}

	$is_dismissible = ( 'error' == $message ) ? '' : 'is-dismissible';

	if ( $cookie_id ) {

		if ( ! $dismiss_text ) {
			$dismiss_text = esc_html__( 'Hide permanently', 'vonzot' );
		}

		if ( $cookie_id ) {
			if ( ! isset( $_COOKIE[ $cookie_id ] ) ) {
				$href = esc_url( admin_url( 'themes.php?page=' . vonzot_get_theme_slug() . '-about&amp;dismiss=' . $cookie_id ) );
				echo "<div class='notice notice-$type $is_dismissible'><p>$message</p><p><a href='$href' id='$cookie_id' class='button vonzot-dismiss-admin-notice'>$dismiss_text</a></p></div>";
			}
		}
	} else {
		echo "<div class='notice notice-$type $is_dismissible'><p>$message</p></div>";
	}
	return false;
}
add_action( 'admin_notices', 'vonzot_admin_notice' );

/**
 * Remove post formats on work posts
 */
function vonzot_remove_work_post_formats() {

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) {
		$post_type = esc_attr( $_GET['post_type'] );

	} elseif ( isset( $_GET['post'] ) ) {
		$post_type = get_post_type( absint( $_GET['post'] ) );
	}

	if ( 'work' === $post_type ) {
		remove_theme_support( 'post-formats' );
	}

}
add_action( 'load-post.php', 'vonzot_remove_work_post_formats' );
add_action( 'load-post-new.php', 'vonzot_remove_work_post_formats' );

/**
 * Remove unwanted plugin submenu
 */
function vonzot_remove_wolf_plugin_submenu() {
	remove_submenu_page( 'edit.php?post_type=work', 'wolf-portfolio-shortcode' );
	remove_submenu_page( 'edit.php?post_type=gallery', 'wolf-albums-shortcode' );
	remove_submenu_page( 'edit.php?post_type=video', 'wolf-videos-shortcode' );
	remove_submenu_page( 'edit.php?post_type=release', 'wolf-discography-shortcode' );
	remove_submenu_page( 'edit.php?post_type=wpm_playlist', 'wolf-playlist-manager-settings' );
	remove_submenu_page( 'themes.php', 'wolf-custom-post-meta-settings' );

	if ( defined( 'VC_PAGE_MAIN_SLUG' ) ) {
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-socials' );
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'wvc-fonts' );
		remove_submenu_page( VC_PAGE_MAIN_SLUG, 'edit.php?post_type=vc_grid_item' );
	}
}
add_action( 'admin_menu', 'vonzot_remove_wolf_plugin_submenu', 999 );

/**
 * Get the content of a file using wp_remote_get
 *
 * @param string $file path from theme folder
 */
function vonzot_file_get_contents( $file ) {

	$file = vonzot_get_theme_uri( $file );

	if ( $file ) {
		$response = wp_remote_get( $file );
		if ( is_array( $response ) ) {
			return wp_remote_retrieve_body( $response );
		}
	}
}

/**
 * Check if a string is an external URL to prevent hot linking when importing default mods on theme activation
 *
 * @param string $string
 * @return bool
 */
function vonzot_is_external_url( $string ) {

	if ( filter_var( $string, FILTER_VALIDATE_URL ) && parse_url( site_url(), PHP_URL_HOST) != parse_url( $string, PHP_URL_HOST ) ) {
		return parse_url( $string, PHP_URL_HOST );
	}
}

/**
 * Sync theme font option with WWPBPBE plugin
 *
 * @param array $options
 * @return array $options
 */
function vonzot_sync_theme_font_options_with_wvc( $options ) {
	if ( isset( $options['google_fonts'] ) && vonzot_is_wvc_activated() && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'fonts', 'google_fonts', $options['google_fonts'] );
	}

	return $options;
}
add_action( 'vonzot_after_' . vonzot_get_theme_slug() . '_font_settings_options_save', 'vonzot_sync_theme_font_options_with_wvc', 10, 1 );

/**
 * Sync WWPBPBE plugin fonts option with theme fonts
 *
 * @param array $options
 * @return array $options
 */
function vonzot_sync_wvc_font_options_with_theme( $options ) {
	if ( isset( $options['google_fonts'] ) ) {
		$fonts = $options['google_fonts'];
		vonzot_update_option( 'font', 'google_fonts', $fonts );
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'vonzot_sync_wvc_font_options_with_theme', 10, 1 );

/**
 * Sync theme social mods with WWPBPBE plugin options
 *
 * Save social profiles URL from customizer to plugin settings
 */
function vonzot_sync_theme_social_mods_with_wvc() {
	
	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			$mod = get_theme_mod( $service );

			if ( $mod ) {
				wvc_update_option( 'socials', $service, $mod );
			}
		}
	}
}
add_action( 'customize_save_after', 'vonzot_sync_theme_social_mods_with_wvc' );

/**
 * Sync WWPBPBE social options with theme mods
 *
 * Hook plugin option save to sync social networks theme mods
 *
 * @param array $options
 * @return array $options
 */
function vonzot_sync_wvc_social_options_with_theme( $options ) {
	if ( function_exists( 'wvc_get_socials' ) ) {
		$wvc_socials = wvc_get_socials();

		foreach ( $wvc_socials as $service ) {
			if ( isset( $options[ $service ] ) ) {
				set_theme_mod( $service, esc_attr( $options[ $service ] ) );
			}
		}
	}

	return $options;
}
add_action( 'wvc_after_options_save', 'vonzot_sync_wvc_social_options_with_theme' );


/**
 * Add CTA menu content type options
 *
 * @param array $options
 * @return array $options
 */
function vonzot_add_cta_menu_content_types( $options ) {

	if ( vonzot_is_wvc_activated() ) {
		$options['socials'] = esc_html__( 'Socials', 'vonzot' );
	}

	if ( vonzot_is_wc_activated() ) {
		$options['shop_icons'] = esc_html__( 'Shop Icons', 'vonzot' );
	}

	if ( function_exists( 'icl_object_id' ) ) {
		$options['wpml'] = esc_html__( 'Language Switcher', 'vonzot' );
	}

	return $options;
}
add_filter( 'vonzot_menu_cta_content_type_options', 'vonzot_add_cta_menu_content_types' );

/**
 * Filter theme menu layout mod
 *
 * If WPM is not installed and the menu with language switcher is set, return another menu layout instead
 *
 * @param array $mod
 * @return array $mod
 */
function vonzot_filter_menu_cta_content_type( $mod ) {

	if ( 'socials' === $mod && ! vonzot_is_wvc_activated() ) {
		$mod = 'icons';
	}

	if ( 'wpml' === $mod && ! vonzot_is_wvc_activated() ) {
		$mod = 'icons';
	}

	return $mod;
}
add_filter( 'theme_mod_cta_content', 'vonzot_filter_menu_layout_theme_mods' );

/**
 * Check if current post content has VC content in it
 *
 * @return bool
 */
function vonzot_has_vc_content() {

	if ( isset( $_GET['post'] ) ) {
		$post = get_post( absint( $_GET['post'] ) );

		if ( is_object( $post ) && preg_match( '/vc_row/', $post->post_content, $match ) ) {
			return true;
		}
	}
}

/**
 * Get the rev slider list
 *
 * @see http://themeforest.net/forums/thread/add-rev-slider-to-theme-please-authors-reply/97711
 * @return array $result
 */
function vonzot_get_revsliders() {

	if ( class_exists( 'RevSlider' ) ) {
		$theslider     = new RevSlider();
		$arrSliders = $theslider->getArrSliders();
		$arrA     = array();
		$arrT     = array();
		foreach( $arrSliders as $slider ) {
			$arrA[]     = $slider->getAlias();
			$arrT[]     = $slider->getTitle();
		}

		if ( $arrA && $arrT ) {
			$result = array_combine( $arrA, $arrT );
		} else {
			$result = array( '' => esc_html__( 'No slider yet', 'vonzot' ) );
		}
		
		return $result;
	}
}

/*---------------------------------------------------------------

	Tiny MCE custom class

-----------------------------------------------------------------*/

/**
 * Callback function to insert 'styleselect' into the $buttons array
 */
function vonzot_mce_styleselect_button( $buttons ) {
	array_unshift( $buttons, 'styleselect' );
	return $buttons;
}
add_filter( 'mce_buttons_2', 'vonzot_mce_styleselect_button' );

/**
 * Callback function to filter the MCE settings
 */
function vonzot_mce_before_init_insert_formats( $init_array ) {  

	$style_formats = array(  
		array(  
			'title' => esc_html__( 'Accent Color', 'vonzot' ),
			'inline' => 'span',
			'classes' => 'accent',
			'wrapper' => false,
		),

		array(  
			'title' => esc_html__( 'Caption', 'vonzot' ),
			'inline' => 'span',
			'classes' => 'caption',
			'wrapper' => false,
		),
	);

	$style_formats =apply_filters( 'vonzot_tiny_mce_style_formats', $style_formats );
	$init_array['style_formats'] = json_encode( $style_formats );
	
	return $init_array;  
}
add_filter( 'tiny_mce_before_init', 'vonzot_mce_before_init_insert_formats' );
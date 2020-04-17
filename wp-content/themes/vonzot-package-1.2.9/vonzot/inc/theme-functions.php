<?php
/**
 * Vonzot frontend theme specific functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Add custom font
 */
function vonzot_add_google_font( $google_fonts ) {

	$default_fonts = array(
		'Source Sans Pro' =>  'Source+Sans+Pro:400,500,700',
		'Didact Gothic' => 'Didact+Gothic:400,500,700',
		'Oswald' => 'Oswald:400,500,600,700,800',
		'Playfair Display' => 'Playfair+Display:400,700',
		'Montserrat' => 'Montserrat:400,500,700',
	);

	foreach ( $default_fonts as $key => $value ) {
		if ( ! isset( $google_fonts[ $key ] ) ) {
			$google_fonts[ $key ] = $value;
		}
	}

	return $google_fonts;
}
add_filter( 'vonzot_google_fonts', 'vonzot_add_google_font' );

/**
 * Overwrite standard post entry slider image size
 */
function vonzot_overwrite_entry_slider_img_size( $size ) {

	add_image_size( 'vonzot-slide', 847, 508, true );

}
add_action( 'after_setup_theme', 'vonzot_overwrite_entry_slider_img_size', 50 );

add_filter( 'vonzot_release_img_size', function( $size ) {
	return '600x600';
} );

/**
 * Post excerpt read more
 */
function vonzot_output_post_grid_classic_excerpt_read_more() {
	?>
	<p class="post-grid-read-more-container"><a href="<?php the_permalink(); ?>" class="<?php echo esc_attr( apply_filters( 'vonzot_more_link_button_class', 'more-link' ) ); ?>"><?php echo vonzot_more_text(); ?></a></p>
	<?php
}
add_action( 'vonzot_post_grid_classic_excerpt', 'vonzot_output_post_grid_classic_excerpt_read_more', 44 );
add_action( 'vonzot_post_masonry_excerpt', 'vonzot_output_post_grid_classic_excerpt_read_more', 44 );

/**
 * Add custom elements to theme
 *
 * @param array $elements
 * @return  array $elements
 */
function vonzot_add_available_wvc_elements( $elements ) {
	$elements[] = 'album-disc';
	$elements[] = 'album-tracklist';
	$elements[] = 'album-tracklist-item';
	$elements[] = 'bandsintown-tracking-button';

	if ( class_exists( 'WooCommerce' ) ) {
		$elements[] = 'wc-searchform';
		$elements[] = 'login-form';
		$elements[] = 'product-presentation';
	}

	return $elements;
}
add_filter( 'wvc_element_list', 'vonzot_add_available_wvc_elements', 44 );

/**
 * Disable default loading and transition animation
 *
 * @param bool $bool
 * @return bool
 */
function vonzot_reset_loading_anim( $bool ) {
	return false;
}
add_filter( 'vonzot_display_loading_logo', 'vonzot_reset_loading_anim' );
add_filter( 'vonzot_display_loading_overlay', 'vonzot_reset_loading_anim' );
add_filter( 'vonzot_default_page_loading_animation', 'vonzot_reset_loading_anim' );
add_filter( 'vonzot_default_page_transition_animation', 'vonzot_reset_loading_anim' );

/**
 * Loading title markup
 *
 * @param bool $bool
 * @return bool
 */
function vonzot_loading_animation_markup() {

	if ( 'none' !== vonzot_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) :
	?>
	<div class="vonzot-loader-overlay">
		<div class="vonzot-loader">
			<?php if ( 'vonzot' === vonzot_get_inherit_mod( 'loading_animation_type', 'overlay' ) ) : ?>
				<div id="vonzot-vinly"></div>
				<div id="vonzot-percent">0%</div>
			<?php endif; ?>
		</div><!-- .vonzot-loader -->
	</div><!-- .vonzot-loader-overlay -->
	<?php endif;
}
add_action( 'vonzot_body_start', 'vonzot_loading_animation_markup', 0 );

/**
 * Add lateral menu for the vertical bar
 */
function vonzot_add_lateral_menu( $menus ) {

	$menus['vertical'] = esc_html__( 'Vertical Menu (optional)', 'vonzot' );

	return $menus;

}
add_filter( 'vonzot_menus', 'vonzot_add_lateral_menu' );

/**
 * Login popup markup
 *
 * @param bool $bool
 * @return bool
 */
function vonzot_login_form_markup() {
	if ( function_exists( 'wvc_login_form' ) && class_exists( 'WooCommerce' ) ) {
		?>
		<div id="loginform-overlay">
			<div id="loginform-overlay-inner">
				<div id="loginform-overlay-content" class="wvc-font-dark">
					<a href="#" id="close-vertical-bar-menu-icon" class="close-panel-button close-loginform-button">X</a>
					<?php //echo wvc_login_form(); ?>
				</div>
			</div>
		</div>
		<?php
	}
}
add_action( 'vonzot_body_start', 'vonzot_login_form_markup', 5 );

/**
 * Get available display options for posts
 *
 * @return array
 */
function vonzot_set_post_display_options() {

	return array(
		'standard' => esc_html__( 'Standard', 'vonzot' ),
		'grid_classic' => esc_html__( 'Simple Grid', 'vonzot' ),
		'masonry' => esc_html__( 'Masonry', 'vonzot' ),
	);
}
add_filter( 'vonzot_post_display_options', 'vonzot_set_post_display_options' );

/**
 * Set default metro thumbnail size dimension
 */
function vonzot_set_metro_thumbnail_sizes( $size ) {
	add_image_size( 'vonzot-metro', 550, 702 );
}

/**
 * Returns large
 */
function vonzot_set_large_metro_thumbnail_size() {
	return 'large';
}

/**
 * Filter metro thumnail size depending on row context
 */
function vonzot_optimize_metro_thumbnail_size( $atts ) {

	$column_type = isset( $atts['column_type'] ) ? $atts['column_type'] : null;
	$content_width = isset( $atts['content_width'] ) ? $atts['content_width'] : null;

	if ( 'column' === $column_type ) {
		if ( 'full' === $content_width || 'large' === $content_width ) {
			add_filter( 'vonzot_metro_thumbnail_size_name', 'vonzot_set_large_metro_thumbnail_size' );
		}
	}
}
add_action( 'wvc_add_row_filters', 'vonzot_optimize_metro_thumbnail_size', 10, 1 );

/* Remove metro thumbnail size filter */
add_action( 'wvc_remove_row_filters', function() {
	remove_filter( 'vonzot_metro_thumbnail_size_name', 'vonzot_set_large_metro_thumbnail_size' );
} );

/**
 * Get available display options for pages
 *
 * @return array
 */
function vonzot_set_page_display_options() {

	return array(
		'grid_overlay' => esc_html__( 'Image Grid', 'vonzot' ),
		'masonry' => esc_html__( 'Masonry', 'vonzot' ),
	);
}
add_filter( 'vonzot_page_display_options', 'vonzot_set_page_display_options' );

/**
 * Get available display options for works
 *
 * @return array
 */
function vonzot_set_work_display_options() {

	return array(
		'grid' => esc_html__( 'Grid', 'vonzot' ),
		'masonry' => esc_html__( 'Masonry', 'vonzot' ),
	);
}
add_filter( 'vonzot_work_display_options', 'vonzot_set_work_display_options' );

/**
 * Portfolio masonry thumbnail size
 */
function vonzot_set_portfolio_masonry_thumbnail_size( $size ) {

	if ( ! vonzot_is_gif( get_post_thumbnail_id() ) ) {
		$size = 'vonzot-masonry-small';
	}

	return $size;

}
add_filter( 'vonzot_portfolio_masonry_thumbnail_size', 'vonzot_set_portfolio_masonry_thumbnail_size' );

/**
 * Set portfolio template folder
 */
function vonzot_set_portfolio_template_url( $template_url ) {

	return 'portfolio/';
}
add_filter( 'wolf_portfolio_template_url', 'vonzot_set_portfolio_template_url' );

/**
 * Set mobile menu template
 *
 * @param string $string
 * @return string
 */
function vonzot_set_mobile_menu_template( $string ) {

	return 'content-mobile-alt';
}
add_filter( 'vonzot_mobile_menu_template', 'vonzot_set_mobile_menu_template' );

/**
 * Add mobile closer overlay
 */
function vonzot_add_mobile_panel_closer_overlay() {
	?>
	<div id="mobile-panel-closer-overlay" class="panel-closer-overlay toggle-mobile-menu"></div>
	<?php
}
add_action( 'vonzot_main_content_start', 'vonzot_add_mobile_panel_closer_overlay' );

/**
 * Off mobile menu
 */
function vonzot_mobile_alt_menu() {
	?>
	<div id="mobile-menu-panel">
		<a href="#" id="close-mobile-menu-icon" class="close-panel-button toggle-mobile-menu">X</a>
		<div id="mobile-menu-panel-inner">
		<?php
			/**
			 * Menu
			 */
			vonzot_primary_mobile_navigation();
		?>
		</div><!-- .mobile-menu-panel-inner -->
	</div><!-- #mobile-menu-panel -->
	<?php
}
add_action( 'vonzot_body_start', 'vonzot_mobile_alt_menu' );

/**
 * Add panel closer icon
 */
function vonzot_add_side_panel_close_button() {
	?>
	<a href="#" id="close-side-panel-icon" class="close-panel-button toggle-side-panel">X</a>
	<?php
}
add_action( 'vonzot_sidepanel_start', 'vonzot_add_side_panel_close_button' );

/**
 * Add offcanvas menu closer icon
 */
function vonzot_add_offcanvas_menu_close_button() {
	?>
	<a href="#" id="close-side-panel-icon" class="close-panel-button toggle-offcanvas-menu">X</a>
	<?php
}
add_action( 'vonzot_offcanvas_menu_start', 'vonzot_add_offcanvas_menu_close_button' );

/**
 * Secondary navigation hook
 *
 * Display cart icons, social icons or secondary menu depending on cuzstimizer option
 */
function vonzot_output_mobile_complementary_menu( $context = 'desktop' ) {
	if ( 'mobile' === $context ) {
		$cta_content = vonzot_get_inherit_mod( 'menu_cta_content_type', 'none' );

		/**
		 * Force shop icons on woocommerce pages
		 */
		$is_wc_page_child = is_page() && wp_get_post_parent_id( get_the_ID() ) == vonzot_get_woocommerce_shop_page_id() && vonzot_get_woocommerce_shop_page_id();
		$is_wc = vonzot_is_woocommerce_page() || is_singular( 'product' ) || $is_wc_page_child;

		if ( apply_filters( 'vonzot_force_display_nav_shop_icons', $is_wc ) ) { // can be disable just in case
			$cta_content = 'shop_icons';
		}

		if ( 'shop_icons' === $cta_content ) {

			if ( vonzot_display_shop_search_menu_item() ) : ?>
				<div class="search-container cta-item">
					<?php
						/**
						 * search icon
						 */
						echo vonzot_search_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif;

			if ( vonzot_display_account_menu_item() ) : ?>
				<div class="account-container cta-item">
					<?php
						/**
						 * account icon
						 */
						vonzot_account_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php endif; 
			
			if ( vonzot_display_cart_menu_item() ) {
			?>
				<div class="cart-container cta-item">
					<?php
						/**
						 * Cart icon
						 */
						vonzot_cart_menu_item();
					?>
				</div><!-- .cart-container -->
			<?php
			}
		}
	}
}
add_action( 'vonzot_secondary_menu', 'vonzot_output_mobile_complementary_menu', 10, 1 );

/**
 * Side Panel font class
 */
function vonzot_set_side_panel_class( $class ) {

	if ( vonzot_get_theme_mod( 'side_panel_bg_img' ) ) {
		$class .= ' wvc-font-light';
	}

	return $class;
}
add_filter( 'vonzot_side_panel_class', 'vonzot_set_side_panel_class' );

/**
 * Overwrite hamburger icon
 */
function vonzot_set_hamburger_icon( $html, $class, $title_attr ) {

	$title_attr = esc_html__( 'Menu', 'vonzot' );

	ob_start();
	?>
	<a class="hamburger-icon <?php echo esc_attr( $class ); ?>" href="#" title="<?php echo esc_attr( $title_attr ); ?>">
		<span class="line line-first"></span>
		<span class="line line-second"></span>
		<span class="line line-third"></span>
		<span class="cross">
			<span></span>
			<span></span>
		</span>
	</a>
	<?php
	$html = ob_get_clean();

	return $html;

}
add_filter( 'wolfthemes_hamburger_icon', 'vonzot_set_hamburger_icon', 10, 3 );

/**
 * Filter fullPage Transition
 *
 * @return array
 */
function vonzot_set_fullpage_transition( $transition ) {

	if ( is_page() || is_single() ) {
		if ( get_post_meta( wvc_get_the_ID(), '_post_fullpage', true ) ) {
			$transition = get_post_meta( wvc_get_the_ID(), '_post_fullpage_transition', true );
		}
	}

	return $transition;
}
add_filter( 'wvc_fp_transition_effect', 'vonzot_set_fullpage_transition' );

/**
 * Product Subheading
 */
function vonzot_add_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( 'product' === get_post_type() && $subheading ) {
		?>
		<span class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</span>
		<?php
	}

}
add_action( 'vonzot_after_shop_loop_item_title', 'vonzot_add_product_subheading' );
add_action( 'vonzot_wc_after_widget_product_item_title', 'vonzot_add_product_subheading' );
add_action( 'wwcqv_product_summary', 'vonzot_add_product_subheading', 5 );

/**
 * Single Product Subheading
 */
function vonzot_add_single_product_subheading() {

	$subheading = get_post_meta( get_the_ID(), '_post_subheading', true );

	if ( is_single() && $subheading ) {
		?>
		<div class="product-subheading">
			<?php echo sanitize_text_field( $subheading ); ?>
		</div>
		<?php
	}

}
add_action( 'woocommerce_single_product_summary', 'vonzot_add_single_product_subheading', 6 );

/**
 * Related post count
 */

/**
 * Standard row width
 */
add_filter( 'wvc_row_standard_width', function( $string ) {
	return '1300px';
}, 40 );

/**
 * Load more pagination hash change
 */
add_filter( 'vonzot_loadmore_pagination_hashchange', function( $size ) {
	return false;
}, 40 );


/**
 * WC gallery aimeg size overwrite
 */
add_filter( 'woocommerce_gallery_thumbnail_size', function( $size ) {
	return array( 100, 137 );
}, 40 );

/**
 * Category thumbnail fields.
 */
function vonzot_add_category_fields() {
	?>
	<div class="form-field term-thumbnail-wrap">
		<label><?php esc_html_e( 'Size Chart', 'vonzot' ); ?></label>
		<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" width="60px" height="60px" /></div>
		<div style="line-height: 60px;">
			<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" />
			<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'vonzot' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'vonzot' ); ?></button>
		</div>
		<script type="text/javascript">
			if ( ! jQuery( '#product_cat_sizechart_img_id' ).val() ) {
				jQuery( '#remove_sizechart_image_button' ).hide();
			}
			var sizechart_frame;

			jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

				event.preventDefault();
				if ( sizechart_frame ) {
					sizechart_frame.open();
					return;
				}
				sizechart_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php esc_html_e( 'Choose an image', 'vonzot' ); ?>',
					button: {
						text: '<?php esc_html_e( 'Use image', 'vonzot' ); ?>'
					},
					multiple: false
				} );
				sizechart_frame.on( 'select', function() {
					var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
					var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

					jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
					jQuery( '#remove_sizechart_image_button' ).show();
				} );
				sizechart_frame.open();
			} );

			jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
				jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
				jQuery( '#product_cat_sizechart_img_id' ).val( '' );
				jQuery( '#remove_sizechart_image_button' ).hide();
				return false;
			} );

			jQuery( document ).ajaxComplete( function( event, request, options ) {
				if ( request && 4 === request.readyState && 200 === request.status
					&& options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

					var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
					if ( ! res || res.errors ) {
						return;
					}
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					jQuery( '#display_type' ).val( '' );
					return;
				}
			} );

		</script>
		<div class="clear"></div>
	</div>
	<?php
}
add_action( 'product_cat_add_form_fields', 'vonzot_add_category_fields', 100 );

/**
* Edit category thumbnail field.
*
* @param mixed $term Term (category) being edited
*/
function vonzot_edit_category_fields( $term ) {

	$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

	if ( $sizechart_id ) {
		$image = wp_get_attachment_thumb_url( $sizechart_id );
	} else {
		$image = wc_placeholder_img_src();
	}
	?>
	<tr class="form-field">
		<th scope="row" valign="top"><label><?php esc_html_e( 'Size Chart', 'vonzot' ); ?></label></th>
		<td>
			<div id="sizechart_img" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
			<div style="line-height: 60px;">
				<input type="hidden" id="product_cat_sizechart_img_id" name="product_cat_sizechart_img_id" value="<?php echo absint( $sizechart_id ); ?>" />
				<button type="button" id="upload_sizechart_image_button" class="upload_sizechart_image_button button"><?php esc_html_e( 'Upload/Add image', 'vonzot' ); ?></button>
				<button type="button" id="remove_sizechart_image_button" class="remove_sizechart_image_button button" style="display:none;"><?php esc_html_e( 'Remove image', 'vonzot' ); ?></button>
			</div>
			<script type="text/javascript">
				if ( jQuery( '#product_cat_sizechart_img_id' ).val() ) {
					jQuery( '#remove_sizechart_image_button' ).show();
				}
				var sizechart_frame;

				jQuery( document ).on( 'click', '#upload_sizechart_image_button', function( event ) {

					event.preventDefault();
					if ( sizechart_frame ) {
						sizechart_frame.open();
						return;
					}
					sizechart_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php esc_html_e( 'Choose an image', 'vonzot' ); ?>',
						button: {
							text: '<?php esc_html_e( 'Use image', 'vonzot' ); ?>'
						},
						multiple: false
					} );
					sizechart_frame.on( 'select', function() {
						var attachment           = sizechart_frame.state().get( 'selection' ).first().toJSON();
						var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

						jQuery( '#product_cat_sizechart_img_id' ).val( attachment.id );
						jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
						jQuery( '#remove_sizechart_image_button' ).show();
					} );
					sizechart_frame.open();
				} );

				jQuery( document ).on( 'click', '#remove_sizechart_image_button', function() {
					jQuery( '#sizechart_img' ).find( 'img' ).attr( 'src', '<?php echo esc_js( wc_placeholder_img_src() ); ?>' );
					jQuery( '#product_cat_sizechart_img_id' ).val( '' );
					jQuery( '#remove_sizechart_image_button' ).hide();
					return false;
				} );

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}
add_action( 'product_cat_edit_form_fields', 'vonzot_edit_category_fields', 100 );

/**
* save_category_fields function.
*
* @param mixed  $term_id Term ID being saved
* @param mixed  $tt_id
* @param string $taxonomy
*/
function vonzot_save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
	
	if ( isset( $_POST['product_cat_sizechart_img_id'] ) && 'product_cat' === $taxonomy ) {
		update_woocommerce_term_meta( $term_id, 'sizechart_id', absint( $_POST['product_cat_sizechart_img_id'] ) );
	}
}
add_action( 'created_term', 'vonzot_save_category_fields', 10, 3 );
add_action( 'edit_term', 'vonzot_save_category_fields', 10, 3 );

/**
 * Product Size Chart Image
 */
function vonzot_product_size_chart_img() {
	
	$hide_sizechart = get_post_meta( get_the_ID(), '_post_wc_product_hide_size_chart_img', true );
	
	if ( $hide_sizechart || ! is_singular( 'product' ) ) {
		return;
	}

	global $post;
	$sc_img = null;
	$terms = get_the_terms( $post, 'product_cat' );

	foreach ( $terms as $term ) {

		$sizechart_id = absint( get_term_meta( $term->term_id, 'sizechart_id', true ) );

		if ( $sizechart_id ) {
			$sc_img = $sizechart_id;
		}
	}

	if ( get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true ) ) {
		$sc_img = get_post_meta( get_the_ID(), '_post_wc_product_size_chart_img', true );
	}

	if ( is_single() && $sc_img ) {
		$href = vonzot_get_url_from_attachment_id( $sc_img, 'vonzot-XL' );
		?>
		<div class="size-chart-img">
			<a href="<?php echo esc_url( $href ); ?>" class="lightbox"><?php esc_html_e( 'Size Chart', 'vonzot' ); ?></a>
		</div>
		<?php
	}
}
add_action( 'woocommerce_single_product_summary', 'vonzot_product_size_chart_img', 25 );

add_filter( 'vonzot_work_meta_separator', function() {
	return ' &bull; ';
} );

add_filter( 'vonzot_entry_tag_list_separator', function() {
	return ' / ';
} );

/**
 * Quickview product excerpt lenght
 */
add_filter( 'wwcqv_excerpt_length', function() {
	return 28;
} );

/**
 * After quickview summary hook
 */
add_action( 'wwcqv_product_summary', function() {
	?>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'vonzot' ); ?></span>
		<?php vonzot_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
	<?php
}, 20 );

/**
 * After summary hook
 */
add_action( 'woocommerce_single_product_summary', function() {
	?>
	<div class="single-add-to-wishlist">
		<span class="single-add-to-wishlist-label"><?php esc_html_e( 'Wishlist', 'vonzot' ); ?></span>
		<?php vonzot_add_to_wishlist(); ?>
	</div><!-- .single-add-to-wishlist -->
	<?php
}, 25 );

/**
 * Filter post modules
 *
 * @param array $atts
 * @return array $atts
 */
function vonzot_filter_post_module_atts( $atts ) {

	if ( 'add_noise' === $atts['work_layout'] ) {
		$atts['work_layout'] = 'overlay';
		$atts['el_class'] .= ' hover-noise';
	}

	return $atts;
}

/**
 * No header post types
 */
function vonzot_filter_no_hero_post_types( $post_types ) {

	$post_types = array( 'product', 'attachment', 'wpm_playlist' );

	return $post_types;
}
add_filter( 'vonzot_no_header_post_types', 'vonzot_filter_no_hero_post_types', 40 );

function vonzot_show_shop_header_content_block_single_product( $bool ) {

	if ( is_singular( 'product' ) ) {
		$bool = true;
	}
	
	return $bool;
}
add_filter( 'vonzot_force_display_shop_after_header_block', 'vonzot_show_shop_header_content_block_single_product' );

/**
 * Disable single post pagination
 *
 * @param bool $bool
 * @return bool
 */
add_filter( 'vonzot_disable_single_post_pagination', '__return_true' );

/**
 * Read more text
 */
function vonzot_view_post_text( $string ) {
	return esc_html__( 'Read more', 'vonzot' );
}
add_filter( 'vonzot_view_post_text', 'vonzot_view_post_text' );

/**
 * Search form placeholder
 */
function vonzot_set_searchform_placeholder( $string ) {
	return esc_attr_x( 'Search&hellip;', 'placeholder', 'vonzot' );
}
add_filter( 'vonzot_searchform_placeholder', 'vonzot_set_searchform_placeholder', 40 );

/**
 * Filter WVC theme accent color
 *
 * @param string $color
 * @return string $color
 */
function vonzot_set_wvc_secondary_theme_accent_color( $color ) {
	return vonzot_get_inherit_mod( 'secondary_accent_color' );
}
add_filter( 'wvc_theme_secondary_accent_color', 'vonzot_set_wvc_theme_secondary_accent_color' );

/**
 * Add theme secondary accent color to shared colors
 *
 * @param array $colors
 * @return array $colors
 */
function vonzot_wvc_add_secondary_accent_color_option( $colors ) {

	$colors = array( esc_html__( 'Theme Secondary Accent Color', 'vonzot' ) => 'secondary_accent' ) + $colors;

	return $colors;
}
add_filter( 'wvc_shared_colors', 'vonzot_wvc_add_secondary_accent_color_option' );

/**
 * Filter WVC shared color hex
 *
 * @param array $colors
 * @return array $colors
 */
function vonzot_add_secondary_accent_color_hex( $colors ) {
	
	$secondary_accent_color = get_theme_mod( 'secondary_accent_color' );

	if ( $secondary_accent_color ) {
		$colors['secondary_accent'] = $secondary_accent_color;
	}

	return $colors;
}
add_filter( 'wvc_shared_colors_hex', 'vonzot_add_secondary_accent_color_hex' );

/**
 * Add form in no result page
 */
function vonzot_add_no_result_form() {
	get_search_form();
}
add_action( 'vonzot_no_result_end', 'vonzot_add_no_result_form' );

/**
 * Set release taxonomy before string
 */
function vonzot_set_breadcrump_delimiter( $string ) {

	return ' / ';

}
add_filter( 'wvc_breadcrumb_delimiter', 'vonzot_set_breadcrump_delimiter' );

/**
 * Remove unused mods
 */
function vonzot_remove_mods( $mods ) {
	unset( $mods['layout']['options']['button_style'] );
	unset( $mods['layout']['options']['site_layout'] );
	
	unset( $mods['fonts']['options']['body_font_size'] );

	unset( $mods['shop']['options']['product_display'] );

	unset( $mods['navigation']['options']['menu_hover_style'] );
	unset( $mods['navigation']['options']['menu_layout']['choices']['overlay'] );
	unset( $mods['navigation']['options']['menu_skin'] );

	unset( $mods['header_settings']['options']['hero_scrolldown_arrow'] );

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_remove_mods', 20 );

/**
 * Disable parallax effect in masonry
 *
 * @param string $string
 * @return string
 */
function vonzot_disable_masonry_parallax_effect( $string ) {

	return 'none';
}
add_filter( 'vonzot_masonry_modern_image_format_effect', 'vonzot_disable_masonry_parallax_effect' );

/**
 * Custom button types
 */
function vonzot_custom_button_types() {
	return array(
		esc_html__( 'Default', 'vonzot' ) => 'default',
		esc_html__( 'Special Primary', 'vonzot' ) => 'vonzot-button-special-primary',
		esc_html__( 'Special Secondary', 'vonzot' ) => 'vonzot-button-special-secondary',
		esc_html__( 'Primary', 'vonzot' ) => 'vonzot-button-primary',
		esc_html__( 'Secondary', 'vonzot' ) => 'vonzot-button-secondary',
		esc_html__( 'Primary Alt', 'vonzot' ) => 'vonzot-button-primary-alt',
		esc_html__( 'Secondary Alt', 'vonzot' ) => 'vonzot-button-secondary-alt',
		esc_html__( 'Simple Text', 'vonzot' ) => 'vonzot-button-simple',
	);
}

/**
 * Custom backgorund effect output
 */
function vonzot_get_noise_effect( $html ) {

	ob_start();
	?>
	<div class="vonzot-bg-overlay"></div>
	<?php
	$html = ob_get_clean();

	return $html;
}
add_filter( 'wvc_background_effect', 'vonzot_get_noise_effect' );

/**
 * Custom backgorund effect output
 */
function vonzot_output_noise_effect() {
	?>
	<div class="vonzot-bg-overlay"></div>
	<?php
}
add_action( 'vonzot_overlay_menu_panel_start', 'vonzot_output_noise_effect', 40 );
add_action( 'vonzot_sidepanel_start', 'vonzot_output_noise_effect', 40 );
add_action( 'vonzot_lateral_menu_panel_start', 'vonzot_output_noise_effect', 40 );
add_action( 'vonzot_offcanvas_menu_start', 'vonzot_output_noise_effect', 40 );

/**
 *  Add phase background effect
 *
 * @param string $effects
 * @return string $effects
 */
function vonzot_add_wvc_custom_background_effect( $effects ) {
	
	if ( function_exists( 'vc_add_param' ) ) {
		vc_add_param(
			'vc_row',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Noise Effect', 'vonzot' ),
				'param_name' => 'add_effect',
				'group' => esc_html__( 'Style', 'vonzot' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Noise Effect', 'vonzot' ),
				'param_name' => 'add_effect',
				'group' => esc_html__( 'Style', 'vonzot' ),
			)
		);

		vc_add_param(
			'vc_column_inner',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Film Grain Effect', 'vonzot' ),
				'param_name' => 'add_effect',
				'group' => esc_html__( 'Style', 'vonzot' ),
			)
		);

		vc_add_param(
			'wvc_advanced_slide',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Film Grain Effect', 'vonzot' ),
				'param_name' => 'add_effect',
			)
		);

		vc_add_param(
			'wvc_interactive_link_item',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Film Grain Effect', 'vonzot' ),
				'param_name' => 'add_effect',
				'group' => esc_html__( 'Background', 'vonzot' ),
			)
		);

		vc_add_param(
			'vc_column',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Add Film Grain Effect', 'vonzot' ),
				'param_name' => 'add_effect',
				'group' => esc_html__( 'Style', 'vonzot' ),
			)
		);

		vc_add_param(
			'rev_slider_vc',
			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Preloader Background', 'vonzot' ),
				'param_name' => 'preloader_bg',
			)
		);
	}
}
add_action( 'init', 'vonzot_add_wvc_custom_background_effect' );

/**
 * Add theme button option
 */
function vonzot_add_button_dependency_params() {

	if ( ! class_exists( 'WPBMap' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WVC_OK' ) || ! WVC_OK ) {
		return;
	}

	$param = WPBMap::getParam( 'vc_button', 'color' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_button', 'shape' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_button', 'hover_effect' );
	$param['dependency'] = array(
		'element' => 'button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_button', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_color' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	
	vc_update_shortcode_param( 'vc_cta', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_shape' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );

	$param = WPBMap::getParam( 'vc_cta', 'btn_hover_effect' );
	$param['dependency'] = array(
		'element' => 'btn_button_type',
		'value' => 'default',
	);
	vc_update_shortcode_param( 'vc_cta', $param );
}
add_action( 'init', 'vonzot_add_button_dependency_params', 15 );

/**
 * Filter button attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_button_atts( $atts ) {
	if ( isset( $atts['button_type'] ) && 'default' !== $atts['button_type'] ) {
		$atts['shape'] = '';
		$atts['color'] = '';
		$atts['hover_effect'] = '';
		$atts['el_class'] .= ' ' . $atts['button_type'];
	}

	return $atts;
}
add_filter( 'wvc_button_atts', 'woltheme_filter_button_atts' );

/**
 * Filter button attribute
 *
 * @param array $atts the shortcode atts we get
 * @param array $btn_params the button attribute to filter
 * @return array $btn_params
 */
function woltheme_filter_elements_button_atts( $btn_params, $atts ) {
	if (
		isset( $atts['btn_button_type'] ) && 'default' !== $atts['btn_button_type']
	) {
		$btn_params['shape'] = '';
		$btn_params['color'] = '';
		$btn_params['hover_effect'] = '';

		if ( isset( $btn_params['el_class'] ) ) {
			$btn_params['el_class'] .= ' ' . $atts['btn_button_type'];
		} else {
			$btn_params['el_class'] = ' ' . $atts['btn_button_type'];
		}
	
	} 

	if ( isset( $atts['b1_button_type'] ) && 'default' !== $atts['b1_button_type'] ) {

		$btn_params['shape'] = '';
		$btn_params['color'] = '';
		$btn_params['hover_effect'] = '';

		if ( isset( $btn_params['el_class'] ) ) {
			$btn_params['el_class'] .= ' ' . $atts['b1_button_type'];
		} else {
			$btn_params['el_class'] = ' ' . $atts['b1_button_type'];
		}

	} 

	return $btn_params;
}
add_filter( 'wvc_cta_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );
add_filter( 'wvc_banner_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );
add_filter( 'wvc_advanced_slider_b1_button_atts', 'woltheme_filter_elements_button_atts', 10, 2 );

add_filter( 'wvc_advanced_slider_b2_button_atts', function( $btn_params, $atts ) {

	if ( isset( $atts['b2_button_type'] ) && 'default' !== $atts['b2_button_type'] ) {

		$btn_params['shape'] = '';
		$btn_params['color'] = '';
		$btn_params['hover_effect'] = '';

		if ( isset( $btn_params['el_class'] ) ) {
			$btn_params['el_class'] .= ' ' . $atts['b2_button_type'];
		} else {
			$btn_params['el_class'] = ' ' . $atts['b2_button_type'];
		}

	}

	return $btn_params;

}, 10, 2 );

add_filter( 'wvc_revslider_container_class', function( $class, $atts ) {

	if ( isset( $atts['preloader_bg'] ) && 'true' === $atts['preloader_bg'] ) {
		$class .= ' wvc-preloader-bg';
	}

	return $class;

}, 10, 2 );

/**
 * Add theme button option to Button element
 */
function vonzot_add_theme_buttons() {

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_button',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'vonzot' ),
					'param_name' => 'button_type',
					'type' => 'dropdown',
					'value' => vonzot_custom_button_types(),
					'weight' => 1000,
				),
			)
		);

		vc_add_params(
			'vc_cta',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'vonzot' ),
					'param_name' => 'btn_button_type',
					'type' => 'dropdown',
					'value' => vonzot_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button', 'vonzot' ),
				),
			)
		);

		vc_add_params(
			'wvc_banner',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'vonzot' ),
					'param_name' => 'btn_button_type',
					'type' => 'dropdown',
					'value' => vonzot_custom_button_types(),
					'group' => esc_html__( 'Button', 'vonzot' ),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'vonzot' ),
					'param_name' => 'b1_button_type',
					'type' => 'dropdown',
					'value' => vonzot_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button 1', 'vonzot' ),
					'dependency' => array(
						'element' => 'add_button_1',
						'value' => array( 'true' ),
					),
				),
			)
		);

		vc_add_params(
			'wvc_advanced_slide',
			array(
				array(
					'heading' => esc_html__( 'Button Type', 'vonzot' ),
					'param_name' => 'b2_button_type',
					'type' => 'dropdown',
					'value' => vonzot_custom_button_types(),
					'weight' => 10,
					'group' => esc_html__( 'Button 2', 'vonzot' ),
					'dependency' => array(
						'element' => 'add_button_2',
						'value' => array( 'true' ),
					),
				),
			)
		);
	}
}
add_action( 'init', 'vonzot_add_theme_buttons' );

/**
 * Filter heading attribute
 *
 * @param array $atts
 * @return array $atts
 */
function woltheme_filter_heading_atts( $atts ) {
	if ( isset( $atts['style'] ) ) {
		$atts['el_class'] = $atts['el_class'] . ' ' . $atts['style'];
	}

	return $atts;
}

/**
 * Add style option to tabs element
 */
function vonzot_add_vc_accordion_and_tabs_options() {
	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_tabs',
			array(
				array(
					'heading' => esc_html__( 'Background', 'vonzot' ),
					'param_name' => 'background',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Solid', 'vonzot' ) => 'solid',
						esc_html__( 'Transparent', 'vonzot' ) => 'transparent',
					),
					'weight' => 1000,
				),
			)
		);
	}

	if ( function_exists( 'vc_add_params' ) ) {
		vc_add_params(
			'vc_accordion',
			array(
				array(
					'heading' => esc_html__( 'Background', 'vonzot' ),
					'param_name' => 'background',
					'type' => 'dropdown',
					'value' => array(
						esc_html__( 'Solid', 'vonzot' ) => 'solid',
						esc_html__( 'Transparent', 'vonzot' ) => 'transparent',
					),
					'weight' => 1000,
				),
			)
		);
	}
}
add_action( 'init', 'vonzot_add_vc_accordion_and_tabs_options' );

/**
 * Filter tabs shortcode attribute
 */
function vonzot_add_vc_tabs_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-tabs-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_tabs', 'vonzot_add_vc_tabs_params' );

/**
 * Filter accordion shortcode attribute
 */
function vonzot_add_vc_accordion_params( $params ) {

	if ( isset( $params['background'] ) ) {
		$params['el_class'] = $params['el_class'] . ' wvc-accordion-background-' . $params['background'];
	}

	return $params;
}
add_filter( 'shortcode_atts_vc_accordion', 'vonzot_add_vc_accordion_params' );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function vonzot_set_default_wvc_button_shape( $shape ) {
	return 'rouded';
}
add_filter( 'wvc_default_button_shape', 'vonzot_set_default_wvc_button_shape', 40 );

/**
 *  Set default button shape
 *
 * @param string $shape
 * @return string $shape
 */
function vonzot_set_default_theme_button_shape( $shape ) {
	return 'standard';
}
add_filter( 'vonzot_mod_button_style', 'vonzot_set_default_theme_button_shape', 40 );

/**
 *  Set default button font weight
 *
 * @param string $shape
 * @return string $shape
 */
function vonzot_set_default_wvc_button_font_weight( $font_weight ) {
	return 700;
}
add_filter( 'wvc_button_default_font_weight', 'vonzot_set_default_wvc_button_font_weight', 40 );

/**
 *  Set default pie chart line width
 *
 * @param string $width
 * @return string $width
 */
function wvc_set_default_pie_chart_line_width( $width ) {

	return 3;
}
add_filter( 'wvc_default_pie_chart_line_width', 'wvc_set_default_pie_chart_line_width', 40 );

/**
 *  Set testimonial alignement
 *
 * @param string $shape
 * @return string $shape
 */
function vonzot_set_default_testimonial_slider_text_alignment( $shape ) {
	return 'left';
}
add_filter( 'wvc_default_testimonial_slider_text_alignment', 'vonzot_set_default_testimonial_slider_text_alignment', 40 );

/**
 *  Set default icon font
 *
 * @param string $shape
 * @return string $shape
 */
function vonzot_set_default_icon_font( $shape ) {
	return 'dripicons';
}
add_filter( 'wvc_default_icon_font', 'vonzot_set_default_icon_font', 40 );

/**
 * Added selector to menu_selectors
 *
 * @param array $selectors
 * @return array $selectors
 */
function vonzot_add_menu_selectors( $selectors ) {

	$selectors[] = '.category-filter ul li a';
	$selectors[] = '.cart-panel-buttons a';

	return $selectors;
}
add_filter( 'vonzot_menu_selectors', 'vonzot_add_menu_selectors' );
/**
 * Added selector to heading_family_selectors
 *
 * @param array $selectors
 * @return array $selectors
 */
function vonzot_add_heading_family_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-button';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.button';
	$selectors[] = '.onsale, .category-label';
	$selectors[] = 'input[type=submit], .wvc-mailchimp-submit';
	$selectors[] = '.nav-next,.nav-previous';
	$selectors[] = '.wvc-embed-video-play-button';
	$selectors[] = '.wvc-ati-title';
	$selectors[] = '.wvc-team-member-role';
	$selectors[] = '.wvc-svc-item-tagline';
	$selectors[] = '.entry-metro insta-username';
	$selectors[] = '.wvc-testimonial-cite';
	$selectors[] = '.vonzot-button-dir-aware';
	$selectors[] = '.preqelle-button-dir-aware-alt';
	$selectors[] = '.vonzot-button-outline';
	$selectors[] = '.vonzot-button-outline-alt';
	$selectors[] = '.vonzot-button-simple';
	$selectors[] = '.wvc-wc-cat-title';
	$selectors[] = '.wvc-pricing-table-button a';
	$selectors[] = '.view-post';
	$selectors[] = '.wolf-gram-follow-button';
	$selectors[] = '#vonzot-percent';

	return $selectors;
}
add_filter( 'vonzot_heading_family_selectors', 'vonzot_add_heading_family_selectors' );

/**
 * Added selector to heading_family_selectors
 *
 * @param array $selectors
 * @return array $selectors
 */
function vonzot_add_vonzot_heading_selectors( $selectors ) {

	$selectors[] = '.wvc-tabs-menu li a';
	$selectors[] = '.woocommerce-tabs ul.tabs li a';
	$selectors[] = '.wvc-process-number';
	$selectors[] = '.wvc-svc-item-title';
	$selectors[] = '.wvc-wc-cat-title';

	return $selectors;
}
add_filter( 'vonzot_heading_selectors', 'vonzot_add_vonzot_heading_selectors' );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_default_custom_heading_font_size( $font_size ) {
	return 36;
}
add_filter( 'wvc_default_custom_heading_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font size
 *
 * @param int $font_size
 * @return int $font_size
 */
function wvc_set_advanced_slide_title_font_size( $font_size ) {
	return 54;
}
add_filter( 'wvc_default_advanced_slide_title_font_size', 'wvc_set_default_custom_heading_font_size', 40 );

/**
 *  Set default heading font weight
 *
 * @param int $font_weight
 * @return int $font_weight
 */
function wvc_set_default_custom_heading_font_weight( $font_weight ) {
	return 700;
}
add_filter( 'wvc_default_custom_heading_font_weight', 'wvc_set_default_custom_heading_font_weight', 40 );
add_filter( 'wvc_default_advanced_slide_title_font_weight', 'wvc_set_default_custom_heading_font_weight', 40 );

/**
 *  Set default heading font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_cta_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_cta_font_size', 'wvc_set_default_cta_font_size', 40 );

/**
 *  Set default heading layout
 *
 * @param string $layout
 * @return string $layout
 */
function wvc_set_default_team_member_layout( $layout ) {
	return 'overlay';
}
add_filter( 'wvc_default_team_member_layout', 'wvc_set_default_team_member_layout', 40 );

/**
 *  Set default team member title font size
 *
 * @param string $font_size
 * @return string $font_size
 */
function wvc_set_default_team_member_font_size( $font_size ) {
	return 24;
}
add_filter( 'wvc_default_team_member_title_font_size', 'wvc_set_default_team_member_font_size', 40 );
add_filter( 'wvc_default_single_image_title_font_size', 'wvc_set_default_team_member_font_size', 40 );

/**
 * Primary buttons class
 *
 * @param string $string
 * @return string
 */
function vonzot_set_primary_button_class( $class ) {

	$vonzot_button_class = 'vonzot-button-primary-alt';

	$class = $vonzot_button_class . ' wvc-button wvc-button-size-xs';

	return $class;
}
add_filter( 'wvc_last_posts_big_slide_button_class', 'vonzot_set_primary_button_class' );
add_filter( 'vonzot_404_button_class', 'vonzot_set_primary_button_class' );
add_filter( 'vonzot_post_product_button', 'vonzot_set_primary_button_class' );

/**
 * Load more buttons class
 *
 * @param string $string
 * @return string
 */
function vonzot_set_loadmore_button_class( $class ) {

	$phase_button_class = 'vonzot-button-primary-alt';

	$class = $phase_button_class . ' wvc-button wvc-button-size-lg';

	return $class;
}
add_filter( 'vonzot_loadmore_button_class', 'vonzot_set_loadmore_button_class' );

/**
 * Reod more buttons class
 *
 * @param string $string
 * @return string
 */
function vonzot_set_readmore_button_class( $class ) {

	$phase_button_class = 'vonzot-button-simple';

	$class = $phase_button_class . ' wvc-button wvc-button-size-sm';

	return $class;
}
add_filter( 'vonzot_more_link_button_class', 'vonzot_set_readmore_button_class' );

/**
 * Author box buttons class
 *
 * @param string $string
 * @return string
 */
function vonzot_set_author_box_button_class( $class ) {

	$class = ' wvc-button wvc-button-size-xs vonzot-button-primary-alt';

	return $class;
}
add_filter( 'vonzot_author_page_link_button_class', 'vonzot_set_author_box_button_class' );

/**
 *  Set entry author prefix
 *
 * @param string $icon
 * @return string $icon
 */
function vonzot_set_author_name_meta( $author_name ) {

	return sprintf( esc_html__( 'By %s', 'vonzot' ), '<span class="author-name">' . $author_name . '</span>' );
}
add_filter( 'vonzot_author_name_meta', 'vonzot_set_author_name_meta', 40 );


/**
 * Excerpt more
 *
 * Add span to allow more CSS tricks
 *
 * @return string
 */
function vonzot_custom_more_text( $string ) {

	$text = '<span>' . esc_html__( 'Read more', 'vonzot' ) . '</span>';

	return $text;
}
add_filter( 'vonzot_more_text', 'vonzot_custom_more_text', 40 );

/**
 * Filter empty p tags in excerpt
 */
function vonzot_filter_excerpt_empty_p_tags( $excerpt ) {

	return str_replace( '<p></p>', '', $excerpt );

}
add_filter( 'get_the_excerpt', 'vonzot_filter_excerpt_empty_p_tags', 100 );

/**
 * Set related posts text
 *
 * @param string $string
 * @return string
 */
function vonzot_set_related_posts_text( $text ) {

	return esc_html__( 'You May Also Like', 'vonzot' );
}
add_filter( 'vonzot_related_posts_text', 'vonzot_set_related_posts_text' );

/**
 *  Set entry slider animation
 *
 * @param string $animation
 * @return string $animation
 */
function vonzot_set_entry_slider_animation( $animation ) {
	return 'slide';
}
add_filter( 'vonzot_entry_slider_animation', 'vonzot_set_entry_slider_animation', 40 );

/**
 *  Set default item overlay color
 *
 * @param string $color
 * @return string $color
 */
function vonzot_set_default_item_overlay_color( $color ) {
	return 'accent';
}
add_filter( 'wvc_default_item_overlay_color', 'vonzot_set_default_item_overlay_color', 40 );

/**
 *  Set default item overlay text color
 *
 * @param string $color
 * @return string $color
 */
function vonzot_set_item_overlay_text_color( $color ) {
	return 'white';
}
add_filter( 'wvc_default_item_overlay_text_color', 'vonzot_set_item_overlay_text_color', 40 );

/**
 *  Set default item overlay opacity
 *
 * @param int $color
 * @return int $color
 */
function vonzot_set_item_overlay_opacity( $opacity ) {
	return 100;
}
add_filter( 'wvc_default_item_overlay_opacity', 'vonzot_set_item_overlay_opacity', 40 );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function vonzot_overwrite_excerpt_length( $length ) {

	return 14;
}
add_filter( 'vonzot_excerpt_length', 'vonzot_overwrite_excerpt_length' );

/**
 * Excerpt length hook
 * Set the number of character to display in the excerpt
 *
 * @param int $length
 * @return int
 */
function vonzot_overwrite_sticky_menu_height( $length ) {

	return 60;
}
add_filter( 'vonzot_sticky_menu_height', 'vonzot_overwrite_sticky_menu_height' );

/**
 *  Set menu skin
 *
 * @param string $skin
 * @return string $skin
 */
function vonzot_set_menu_skin( $skin ) {
	return 'light';
}
add_filter( 'vonzot_mod_menu_skin', 'vonzot_set_menu_skin', 40 );

/**
 * Set menu hover effect
 *
 * @param string $string
 * @return string
 */
function vonzot_set_menu_hover_style( $string ) {

	return 'underline';
}
add_filter( 'vonzot_mod_menu_hover_style', 'vonzot_set_menu_hover_style' );

/*=========================================
	Loop posts
==========================================*/
/**
 * Redefine post standard hook
 */
function vonzot_remove_loop_post_default_hooks() {
	
	remove_action( 'vonzot_before_post_content_standard_title', 'vonzot_output_post_content_standard_date' );
	remove_action( 'vonzot_after_post_content_standard', 'vonzot_output_post_content_standard_meta' );

	add_action( 'vonzot_before_post_content_standard_title', 'vonzot_output_post_content_standard_top_meta', 10, 1 );
	
}
add_action( 'init', 'vonzot_remove_loop_post_default_hooks' );

/**
 * Add post meta before title
 */
function vonzot_output_post_content_standard_top_meta( $post_display_elements ) {
	
	echo '<header class="entry-meta">';

	if ( in_array( 'show_date', $post_display_elements ) && '' == get_post_format() || 'video' === get_post_format() || 'gallery' === get_post_format() || 'image' === get_post_format() || 'audio' === get_post_format() ) { ?>
		<span class="entry-date">
			<?php vonzot_entry_date( true, true ); ?>
		</span>
	<?php
	}

	$show_author = ( in_array( 'show_author', $post_display_elements ) );
	$show_category = ( in_array( 'show_category', $post_display_elements ) );
	$show_tags = ( in_array( 'show_tags', $post_display_elements ) );
	$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );
	?>
	<?php if ( ( $show_author || $show_extra_meta || $show_category || vonzot_edit_post_link( false ) ) && ! vonzot_is_short_post_format() ) : ?>
			
				<?php if ( $show_author ) : ?>
					<?php vonzot_get_author_avatar(); ?>
				<?php endif; ?>
				<?php if ( $show_category ) : ?>
					<span class="entry-category-list">
						<?php echo apply_filters( 'vonzot_entry_category_list_icon', '<span class="meta-icon category-icon"></span>' ); ?>
						<?php echo get_the_term_list( get_the_ID(), 'category', '', esc_html__( ', ', 'vonzot' ), '' ) ?>
					</span>
				<?php endif; ?>
				<?php if ( $show_tags ) : ?>
					<?php vonzot_entry_tags(); ?>
				<?php endif; ?>
				<?php if ( $show_extra_meta ) : ?>
					<?php vonzot_get_extra_meta(); ?>
				<?php endif; ?>
				<?php vonzot_edit_post_link(); ?>
		<?php endif; ?>
	<?php
	echo '</header>';
}

/**
 * Get available display options for products
 *
 * @return array
 */
function vonzot_set_product_display_options() {

	return array(
		'grid' => esc_html__( 'Grid', 'vonzot' ),
		'metro' => esc_html__( 'Metro', 'vonzot' ),
	);
}
add_filter( 'vonzot_product_display_options', 'vonzot_set_product_display_options' );

/**
 * Set default shop display
 *
 * @param string $string
 * @return string
 */
function vonzot_set_product_display( $string ) {

	return 'grid';
}
add_filter( 'vonzot_mod_product_display', 'vonzot_set_product_display' );

/**
 * Display sale label condition
 *
 * @param bool $bool
 * @return bool
 */
function vonzot_do_show_sale_label( $bool ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$bool = true;
	}

	return $bool;
}
add_filter( 'vonzot_show_sale_label', 'vonzot_do_show_sale_label' );

/**
 * Sale label text
 *
 * @param string $string
 * @return string
 */
function vonzot_sale_label( $string ) {

	if ( get_post_meta( get_the_ID(), '_post_product_label', true ) ) {
		$string = '<span class="onsale">' . esc_attr( get_post_meta( get_the_ID(), '_post_product_label', true ) ) . '</span>';
	}

	return $string;
}
add_filter( 'woocommerce_sale_flash', 'vonzot_sale_label' );

/**
 * Product quickview button
 *
 * @param string $string
 * @return string
 */
function vonzot_output_product_quickview_button() {

	if ( function_exists( 'wolf_quickview_button' ) ) {
		wolf_quickview_button();
	}
}
add_filter( 'vonzot_product_quickview_button', 'vonzot_output_product_quickview_button' );

/**
 * Product wishlist button
 *
 * @param string $string
 * @return string
 */
function vonzot_output_product_wishlist_button() {

	if ( function_exists( 'wolf_add_to_wishlist' ) ) {
		wolf_add_to_wishlist();
	}
}
add_filter( 'vonzot_add_to_wishlist_button', 'vonzot_output_product_wishlist_button' );

/**
 * Product Add to cart button
 *
 * @param string $string
 * @return string
 */
function vonzot_output_product_add_to_cart_button() {

	global $product;

	if ( $product->is_type( 'variable' ) ) {

		echo '<a class="product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'Select option', 'vonzot' ) ). '"></span></a>';

	} elseif ( $product->is_type( 'external' ) || $product->is_type( 'grouped' ) ) {

		echo '<a class="product-add-to-cart" href="' . esc_url( get_permalink() ) . '"><span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'View product', 'vonzot' ) ). '"></span></a>';

	} else {

		echo vonzot_add_to_cart(
			get_the_ID(),
			'product-add-to-cart',
			'<span class="hastip fa product-add-to-cart-icon" title="' . esc_attr( __( 'Add to cart', 'vonzot' ) ). '"></span>'
		);
	}

	
}
add_filter( 'vonzot_product_add_to_cart_button', 'vonzot_output_product_add_to_cart_button' );

/**
 * Product more button
 *
 * @param string $string
 * @return string
 */
function vonzot_output_product_more_button() {

	?>
	<a class="product-quickview-button product-more-button" href="<?php the_permalink(); ?>" title="<?php esc_attr_e( 'More details', 'vonzot' ) ?>"><span class="fa ion-android-more-vertical"></span></a>
	<?php
}
add_filter( 'vonzot_product_more_button', 'vonzot_output_product_more_button' );

/*=========================================
	Loop products
==========================================*/
/**
 * Redefine product hook
 */
function vonzot_remove_loop_item_default_wc_hooks() {
	
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price' );
	remove_action( 'woocommerce_after_shop_loop_item', 'www_output_add_to_wishlist_button', 15 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close' );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );

	add_action( 'woocommerce_before_shop_loop_item', 'vonzot_wc_loop_thumbnail', 10, 1 );
	add_action( 'woocommerce_after_shop_loop_item', 'vonzot_wc_loop_summary' );
}
add_action( 'woocommerce_init', 'vonzot_remove_loop_item_default_wc_hooks' );

/**
 * WC loop thumbnail
 */
function vonzot_wc_loop_thumbnail( $template_args ) {

	extract( wp_parse_args( $template_args, array(
		'display' => '',
	) ) );

	$product_thumbnail_size = ( 'metro' === $display ) ? 'vonzot-metro' : 'woocommerce_thumbnail';
	$product_thumbnail_size = apply_filters( 'vonzot_' . $display . '_thumbnail_size_name', $product_thumbnail_size );
	$product_thumbnail_size = ( vonzot_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $product_thumbnail_size;
	?>
	<div class="product-thumbnail-container clearfix">
		<div class="product-thumbnail-inner">
			<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
			<?php vonzot_minimal_player(); ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			<?php echo woocommerce_get_product_thumbnail( $product_thumbnail_size ); ?>
			<?php vonzot_woocommerce_second_product_thumbnail( $product_thumbnail_size ); ?>
			<div class="product-actions">
				<?php
					/**
					 * Quickview button
					 */
					do_action( 'vonzot_product_quickview_button' );
				?>
				<?php
					/**
					 * Wishlist button
					 */
					do_action( 'vonzot_add_to_wishlist_button' );
				?>
			</div><!-- .product-actions -->
		</div><!-- .product-thumbnail-inner -->
	</div><!-- .product-thumbnail-container -->
	<?php
}

function vonzot_wc_loop_summary() {
	?>
	<div class="product-summary clearfix">
		<div class="product-summary-cell-left">
			<?php woocommerce_template_loop_product_link_open(); ?>
				<?php woocommerce_template_loop_product_title(); ?>
				<?php woocommerce_template_loop_price(); ?>
				<?php
					/**
					 * After title
					 */
					do_action( 'vonzot_after_shop_loop_item_title' );
				?>
			<?php woocommerce_template_loop_product_link_close(); ?>
		</div>
		<div class="product-summary-cell-right">
			<?php
				/**
				 * Add to cart button
				 */
				do_action( 'vonzot_product_add_to_cart_button' );
			?>
		</div>
	</div><!-- .product-summary -->
	<?php
}

/**
 * Quickview product excerpt lenght
 */
add_filter( 'vonzot_show_single_product_wishlist_button', function() {
	return false;
} );

/**
 * Product stacked images + sticky details
 */
function vonzot_single_product_sticky_layout() {

	if ( ! vonzot_get_inherit_mod( 'product_sticky' ) || 'no' === vonzot_get_inherit_mod( 'product_sticky' ) ) {
		return;
	}

	/* Remove default images */
	remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );

	global $product;

	$product_id = $product->get_id();

	echo '<div class="images">';

	woocommerce_show_product_sale_flash();
	/**
	 * If gallery
	 */
	$attachment_ids = $product->get_gallery_image_ids();

	if ( is_array( $attachment_ids ) && ! empty( $attachment_ids ) ) {

		echo '<ul>';

		if ( has_post_thumbnail( $product_id ) ) {

			$caption = get_post_field( 'post_excerpt', get_post_thumbnail_id( $post_thumbnail_id ) );
			?>
			<li class="stacked-image">
				<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
					<?php echo vonzot_kses( $product->get_image( 'large' ) ); ?>
				</a>
			</li>
			<?php
		}

		foreach ( $attachment_ids as $attachment_id ) {
			if ( wp_attachment_is_image( $attachment_id ) ) {

				$caption = get_post_field( 'post_excerpt', $attachment_id );
				?>
				<li class="stacked-image">
					<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo wp_get_attachment_url( $attachment_id, 'full' ); ?>" data-caption="<?php echo esc_attr( $caption ); ?>">
						<?php echo wp_get_attachment_image( $attachment_id, 'large' ); ?>
					</a>
				</li>
				<?php
			}
		}

		echo '</ul>';

	/**
	 * If featured image only
	 */
	} elseif ( has_post_thumbnail( $product_id ) ) {
		?>
		<span class="stacked-image">
			<a class="lightbox" data-fancybox="wc-stacked-images-<?php echo absint( $product_id ); ?>" href="<?php echo get_the_post_thumbnail_url( $product_id, 'full' ); ?>">
				<?php echo vonzot_kses( $product->get_image( 'large' ) ); ?>
			</a>
		</span>
		<?php
	/**
	 * Placeholder
	 */
	} else {
		
		$html  = '<span class="woocommerce-product-gallery__image--placeholder">';
		$html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'vonzot' ) );
		$html .= '</span>';

		echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
	}

	echo '</div>';
}
add_action( 'woocommerce_before_single_product_summary', 'vonzot_single_product_sticky_layout' );

/**
 * Add mods
 *
 * @param array $mods
 * @return array $mods
 */
function vonzot_add_mods( $mods ) {

	$color_scheme = vonzot_get_color_scheme();

	$mods['colors']['options']['secondary_accent_color'] = array(
		'id' => 'secondary_accent_color',
		'label' => esc_html__( 'Secondary Accent Color', 'vonzot' ),
		'type' => 'color',
		'transport' => 'postMessage',
		'default' => $color_scheme[8],
	);

	$mods['loading'] = array(

		'id' => 'loading',
		'title' => esc_html__( 'Loading', 'vonzot' ),
		'icon' => 'update',
		'options' => array(

			array(
				'label' => esc_html__( 'Loading Animation Type', 'vonzot' ),
				'id' => 'loading_animation_type',
				'type' => 'select',
				'choices' => array(
					'none' => esc_html__( 'None', 'vonzot' ),
		 			'overlay' => esc_html__( 'Overlay', 'vonzot' ),
				),
			),
		),
	);

	$mods['navigation']['options']['menu_style'] = array(
		'id' =>'menu_style',
		'label' => esc_html__( 'Main Menu Style', 'vonzot' ),
		'type' => 'select',
		'choices' => array(
			'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'vonzot' ),
			'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'vonzot' ),
			'solid' => esc_html__( 'Solid Light', 'vonzot' ),
			'solid-dark' => esc_html__( 'Solid Dark', 'vonzot' ),
			'transparent' => esc_html__( 'Transparent', 'vonzot' ),
		),
		'transport' => 'postMessage',
	);

	$mods['navigation']['options']['side_panel_bg_img'] = array(
		'label'	=> esc_html__( 'Side Panel Background', 'vonzot' ),
		'id'	=> 'side_panel_bg_img',
		'type'	=> 'image',
	);

	$mods['navigation']['options']['nav_player_mp3'] = array(
		'label'	=> esc_html__( 'Add a minimalist player to the navbar', 'vonzot' ),
		'id'	=> 'nav_player_mp3',
		'type'	=> 'media',
	);

	$mods['navigation']['options']['show_nav_player'] = array(
		'label'	=> esc_html__( 'Show Navigation Player by Default', 'vonzot' ),
		'id'	=> 'show_nav_player',
		'type'	=> 'select',
		'choices' => array(
			'' => esc_html__( 'No', 'vonzot' ),
			'yes' => esc_html__( 'Yes', 'vonzot' ),
		),
	);

	$mods['blog']['options']['post_hero_layout'] = array(
		'label'	=> esc_html__( 'Single Post Header Layout', 'vonzot' ),
		'id'	=> 'post_hero_layout',
		'type'	=> 'select',
		'choices' => array(
			'' => esc_html__( 'Default', 'vonzot' ),
			'standard' => esc_html__( 'Standard', 'vonzot' ),
			'big' => esc_html__( 'Big', 'vonzot' ),
			'small' => esc_html__( 'Small', 'vonzot' ),
			'fullheight' => esc_html__( 'Full Height', 'vonzot' ),
			'none' => esc_html__( 'No header', 'vonzot' ),
		),
	);

	if ( isset( $mods['portfolio'] ) ) {
		$mods['portfolio']['options']['work_hero_layout'] = array(
			'label'	=> esc_html__( 'Single Work Header Layout', 'vonzot' ),
			'id'	=> 'work_hero_layout',
			'type'	=> 'select',
			'choices' => array(
				'' => esc_html__( 'Default', 'vonzot' ),
				'standard' => esc_html__( 'Standard', 'vonzot' ),
				'big' => esc_html__( 'Big', 'vonzot' ),
				'small' => esc_html__( 'Small', 'vonzot' ),
				'fullheight' => esc_html__( 'Full Height', 'vonzot' ),
				'none' => esc_html__( 'No header', 'vonzot' ),
			),
		);
	}

	if ( isset( $mods['shop'] ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['product_sticky'] = array(
			'label'	=> esc_html__( 'Stacked Images with Sticky Product Details', 'vonzot' ),
			'id'	=> 'product_sticky',
			'type'	=> 'checkbox',
			'description' => esc_html__( 'Not compatible with sidebar layouts.', 'vonzot' ),
		);
	}

	return $mods;
}
add_filter( 'vonzot_customizer_mods', 'vonzot_add_mods', 40 );

/**
 * Remove some params
 */
function vonzot_remove_vc_params() {

	if ( function_exists( 'vc_remove_element' ) ) {
		vc_remove_element( 'wvc_page_index' );
		vc_remove_element( 'wvc_interactive_overlays' );
	}

	if ( function_exists( 'vc_remove_param' ) ) {
		vc_remove_param( 'wvc_product_index', 'product_text_align' );
	
		vc_remove_param( 'wvc_interactive_links', 'align' );
		vc_remove_param( 'wvc_interactive_links', 'display' );
		vc_remove_param( 'wvc_interactive_overlays', 'align' );
		vc_remove_param( 'wvc_interactive_overlays', 'display' );

		vc_remove_param( 'wvc_team_member', 'layout' );
		vc_remove_param( 'wvc_team_member', 'alignment' );
		vc_remove_param( 'wvc_team_member', 'v_alignment' );

		vc_remove_param( 'wvc_testimonial_slide', 'avatar' );
	}
}
add_action( 'init', 'vonzot_remove_vc_params' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function vonzot_set_smooth_scroll_speed( $speed ) {
	return 1400;
}
add_filter( 'vonzot_smooth_scroll_speed', 'vonzot_set_smooth_scroll_speed' );
add_filter( 'wvc_smooth_scroll_speed', 'vonzot_set_smooth_scroll_speed' );

/**
 *  Set smooth scroll speed
 *
 * @param string $speed
 * @return string $speed
 */
function vonzot_set_fp_anim_time( $speed ) {
	return 1000;
}
add_filter( 'wvc_fp_anim_time', 'vonzot_set_fp_anim_time' );

/**
 * Add additional JS scripts and functions
 */
function vonzot_enqueue_additional_scripts() {
	
	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : vonzot_get_theme_version();

	if ( ! vonzot_is_wvc_activated() ) {

		wp_register_style( 'dripicons', get_template_directory_uri() . '/assets/css/lib/fonts/dripicons-v2/dripicons.min.css', array(), vonzot_get_theme_version() );
		
		wp_register_script( 'countup', get_template_directory_uri() . '/assets/js/lib/countUp.min.js', array(), '1.9.3', true );
	}

	wp_enqueue_style( 'dripicons' );

	wp_enqueue_script( 'countup' );

	wp_enqueue_script( 'jquery-effects-core' );
	wp_enqueue_script( 'vonzot-custom', get_template_directory_uri() . '/assets/js/t/vonzot.js', array( 'jquery' ), $version, true );
}
add_action( 'wp_enqueue_scripts', 'vonzot_enqueue_additional_scripts', 100 );

/**
 *  Set smooth scroll easing effect
 *
 * @param string $ease
 * @return string $ease
 */
function vonzot_set_smooth_scroll_ease( $ease ) {
	return 'easeOutCubic';
}
add_filter( 'vonzot_smooth_scroll_ease', 'vonzot_set_smooth_scroll_ease' );
add_filter( 'wvc_smooth_scroll_ease', 'vonzot_set_smooth_scroll_ease' );
add_filter( 'wvc_fp_easing', 'vonzot_set_smooth_scroll_ease' );

/**
 * Add mobile alt body class
 *
 * @param array
 * @return array
 */
function vonzot_additional_bodu_classes( $classes ) {

	$classes[] = 'mobile-menu-alt';

	$sticky_details_meta = vonzot_get_inherit_mod( 'product_sticky' ) && 'no' !== vonzot_get_inherit_mod( 'product_sticky' );
	$single_product_layout = vonzot_get_inherit_mod( 'product_single_layout' );

	if ( is_singular( 'product' ) && $sticky_details_meta && 'sidebar-right' !== $single_product_layout && 'sidebar-left' !== $single_product_layout ) {
		$classes[] = 'sticky-product-details';
	}

	return $classes;

}
add_filter( 'body_class', 'vonzot_additional_bodu_classes' );

/**
 * Returns CSS for the color schemes.
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function vonzot_edit_color_scheme_css( $output, $colors ) {

	extract( $colors );

	$output = '';

	$border_color = vsprintf( 'rgba( %s, 0.03)', vonzot_hex_to_rgb( $strong_text_color ) );
	$overlay_panel_bg_color = vsprintf( 'rgba( %s, 0.95)', vonzot_hex_to_rgb( $submenu_background_color ) );

	$link_selector = '.link, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview)';
	$link_selector_after = '.link:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):not(.gallery-quickview):after';

	$output .= "/* Color Scheme */

	/* Body Background Color */
	body,
	.frame-border{
		background-color: $body_background_color;
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#logo-bar,
	.nav-bar,
	.loading-overlay,
	.no-hero #hero,
	.wvc-font-default,
	#topbar{
		background-color: $page_background_color;
	}

	.spinner:before,
	.spinner:after{
		background-color: $page_background_color;
	}

	/* Submenu color */
	#site-navigation-primary-desktop .mega-menu-panel,
	#site-navigation-primary-desktop ul.sub-menu,
	#mobile-menu-panel,
	.offcanvas-menu-panel,
	.lateral-menu-panel,
	.cart-panel{
		background:$submenu_background_color;
	}

	.cart-panel{
		background:$submenu_background_color!important;
	}

	.menu-hover-style-border-top .nav-menu li:hover,
	.menu-hover-style-border-top .nav-menu li.current_page_item,
	.menu-hover-style-border-top .nav-menu li.current-menu-parent,
	.menu-hover-style-border-top .nav-menu li.current-menu-ancestor,
	.menu-hover-style-border-top .nav-menu li.current-menu-item,
	.menu-hover-style-border-top .nav-menu li.menu-link-active{
		box-shadow: inset 0px 5px 0px 0px $submenu_background_color;
	}

	.menu-hover-style-plain .nav-menu li:hover,
	.menu-hover-style-plain .nav-menu li.current_page_item,
	.menu-hover-style-plain .nav-menu li.current-menu-parent,
	.menu-hover-style-plain .nav-menu li.current-menu-ancestor,
	.menu-hover-style-plain .nav-menu li.current-menu-item,
	.menu-hover-style-plain .nav-menu li.menu-link-active{
		background:$submenu_background_color;
	}

	.panel-closer-overlay{
		background:$submenu_background_color;
	}

	.overlay-menu-panel{
		background:$overlay_panel_bg_color;
	}

	/* Sub menu Font Color */
	.nav-menu-desktop li ul li:not(.menu-button-primary):not(.menu-button-secondary) .menu-item-text-container,
	.nav-menu-desktop li ul.sub-menu li:not(.menu-button-primary):not(.menu-button-secondary).menu-item-has-children > a:before,
	.nav-menu-desktop li ul li.not-linked > a:first-child .menu-item-text-container{
		color: $submenu_font_color;
	}
	
	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}

	#close-side-panel-icon{
		color: $submenu_font_color!important;
	}

	.nav-menu-vertical li a,
	.nav-menu-mobile li a,
	.nav-menu-vertical li.menu-item-has-children:before,
	.nav-menu-vertical li.page_item_has_children:before,
	.nav-menu-vertical li.active:before,
	.nav-menu-mobile li.menu-item-has-children:before,
	.nav-menu-mobile li.page_item_has_children:before,
	.nav-menu-mobile li.active:before{
		color: $submenu_font_color!important;
	}

	.lateral-menu-panel .wvc-icon:before{
		color: $submenu_font_color!important;
	}

	.nav-menu-desktop li ul.sub-menu li.menu-item-has-children > a:before{
		color: $submenu_font_color;
	}

	body.wolf.side-panel-toggle.menu-style-transparent .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-white .hamburger-icon .line,
	body.wolf.side-panel-toggle.menu-style-semi-transparent-black .hamburger-icon .line {
	}

	.cart-panel,
	.cart-panel a,
	.cart-panel strong,
	.cart-panel b{
		color: $submenu_font_color!important;
	}
	
	/* Accent Color */
	.accent{
		color:$accent_color;
	}

	#vonzot-loading-point{
		color:$accent_color;
	}

	.wvc-single-image-overlay-title span:after,
	.work-meta-value a:hover{
		color:$accent_color;
	}

	.nav-menu li.sale .menu-item-text-container:before,
	.nav-menu-mobile li.sale .menu-item-text-container:before,
	.wolf-share-button-count{
		background:$accent_color!important;
	}

	.menu-hover-style-s-underline .nav-menu-desktop li a span.menu-item-text-container:after{
		background-color:$accent_color!important;
	}



	.widget_price_filter .ui-slider .ui-slider-range,
	mark,
	p.demo_store,
	.woocommerce-store-notice{
		background-color:$accent_color;
	}

	.button-secondary{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-primary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
		background-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner{
		border-color:$accent_color;
	}

	.nav-menu li.menu-button-secondary > a:first-child > .menu-item-inner:hover{
		background-color:$accent_color;
	}

	.fancybox-thumbs>ul>li:before{
		border-color:$accent_color;
	}

	.added_to_cart, .button, .button-download, .more-link, .wvc-mailchimp-submit, input[type=submit]{
		background-color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-background-color-accent{
		background-color:$accent_color;
	}

	.wvc-highlight-accent{
		background-color:$accent_color;
		color:#fff;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-button-background-color-accent{
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-button-background-color-accent .wvc-button-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	.wvc-svg-icon-color-accent svg * {
		stroke:$accent_color!important;
	}

	.wvc-one-page-nav-bullet-tip{
		background-color: $accent_color;
	}

	.wvc-one-page-nav-bullet-tip:before{
		border-color: transparent transparent transparent $accent_color;
	}

	.accent,
	.comment-reply-link,
	.bypostauthor .avatar{
		color:$accent_color;
	}

	.wvc-button-color-button-accent,
	.more-link,
	.buton-accent{
		background-color: $accent_color;
		border-color: $accent_color;
	}

	.wvc-ils-active .wvc-ils-item-title:after,
	.wvc-interactive-link-item a:hover .wvc-ils-item-title:after {
	    color:$accent_color;
	}

	.wvc-io-active .wvc-io-item-title:after,
	.wvc-interactive-overlay-item a:hover .wvc-io-item-title:after {
	    color:$accent_color;
	}

	.wolf-twitter-widget a.wolf-tweet-link:hover,
	.widget.widget_categories a:hover,
	.widget.widget_pages a:hover,
	.widget .tagcloud a:hover,
	.widget.widget_recent_comments a:hover,
	.widget.widget_recent_entries a:hover,
	.widget.widget_archive a:hover,
	.widget.widget_meta a:hover,
	.widget.widget_product_categories a:hover,
	.widget.widget_nav_menu a:hover,
	a.rsswidget:hover{
		color:$accent_color!important;
	}

	.group_table td a:hover{
		color:$accent_color;
	} 
	
	/* WVC icons */
	.wvc-icon-color-accent{
		color:$accent_color;
	}

	.wvc-icon-background-color-accent{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
		color:$accent_color;
		border-color:$accent_color;
	}

	.wvc-icon-background-color-accent .wvc-icon-background-fill{
		box-shadow:0 0 0 0 $accent_color;
		background-color:$accent_color;
	}

	#ajax-progress-bar,
	.cart-icon-product-count{
		background:$accent_color;
	}

	.background-accent,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
		background: $accent_color!important;
	}

	.trigger{
		background-color: $accent_color!important;
		border : solid 1px $accent_color;
	}

	.bypostauthor .avatar {
		border: 3px solid $accent_color;
	}

	::selection {
		background: $accent_color;
	}
	::-moz-selection {
		background: $accent_color;
	}

	.spinner{
		color:$accent_color;
	}

	/*********************
		WVC
	***********************/

	.wvc-icon-box.wvc-icon-type-circle .wvc-icon-no-custom-style.wvc-hover-fill-in:hover, .wvc-icon-box.wvc-icon-type-square .wvc-icon-no-custom-style.wvc-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em $accent_color;
		box-shadow: inset 0 0 0 1em $accent_color;
		border-color: $accent_color;
	}

	.wvc-pricing-table-featured-text,
	.wvc-pricing-table-featured .wvc-pricing-table-button a{
		background: $accent_color;
	}

	.wvc-pricing-table-featured .wvc-pricing-table-price,
	.wvc-pricing-table-featured .wvc-pricing-table-currency {
		color: $accent_color;
	}
	
	.wvc-pricing-table-featured .wvc-pricing-table-price-strike:before {
		background-color: $accent_color;
	}

	.wvc-team-member-social-container a:hover{
		color: $accent_color;
	}

	/* Main Text Color */
	body,
	.nav-label{
		color:$main_text_color;
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: $main_text_color!important;
	}

	/* Secondary Text Color */
	
	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: $strong_text_color;
	}

	.menu-hover-style-p-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline .nav-menu-desktop li a span.menu-item-text-container:after,
	.menu-hover-style-underline-centered .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $strong_text_color;
	}

	body.wolf.menu-hover-style-overline .nav-menu-desktop li a span.menu-item-text-container:after{
		background: $accent_color!important;
	}

	.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
		background-color: $strong_text_color;
	}

	.bit-widget-container,
	.entry-link{
		color: $strong_text_color;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: $strong_text_color!important;
	}

	/* Border Color */
	.author-box,
	input[type=text],
	input[type=search],
	input[type=tel],
	input[type=time],
	input[type=url],
	input[type=week],
	input[type=password],
	input[type=checkbox],
	input[type=color],
	input[type=date],
	input[type=datetime],
	input[type=datetime-local],
	input[type=email],
	input[type=month],
	input[type=number],
	select,
	textarea{
		border-color:$border_color;
	}

	.widget-title,
	.woocommerce-tabs ul.tabs{
		border-bottom-color:$border_color;
	}

	.widget_layered_nav_filters ul li a{
		border-color:$border_color;
	}

	hr{
		background:$border_color;
	}
	";

	$link_selector_after = '.link:after, .underline:after, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):after';
	$link_selector_before = '.link:before, .underline:before, p:not(.attachment) > a:not(.no-link-style):not(.button):not(.button-download):not(.added_to_cart):not(.button-secondary):not(.menu-link):not(.filter-link):not(.entry-link):not(.more-link):not(.wvc-image-inner):not(.wvc-button):not(.wvc-bigtext-link):not(.wvc-fittext-link):not(.ui-tabs-anchor):not(.wvc-icon-title-link):not(.wvc-icon-link):not(.wvc-social-icon-link):not(.wvc-team-member-social):not(.wolf-tweet-link):not(.author-link):before';

	$output .= "

		$link_selector_after,
		$link_selector_before{
		}

		.category-filter ul li a:before{
		/*	background-color:$accent_color!important;*/
		}

		.category-label{
			background:$accent_color!important;
		}

		#back-to-top:hover{
			background:$accent_color!important;
		}

		.entry-video:hover .video-play-button,
		.video-opener:hover{
			border-left-color:$accent_color!important;
		}

		body.wolf.menu-hover-style-highlight .nav-menu-desktop li a span.menu-item-text-container:after{
			background: $accent_color!important;
		}
	
		.widget.widget_pages ul li a:hover,
		.widget.widget_recent_entries ul li a:hover,
		.widget.widget_recent_comments ul li a:hover,
		.widget.widget_archive ul li a:hover,
		.widget.widget_categories ul li a:hover,
		.widget.widget_meta ul li a:hover,
		.widget.widget_product_categories ul li a:hover,
		.widget.widget_nav_menu ul li a:hover,

		.wvc-font-dark .widget.widget_pages ul li a:hover,
		.wvc-font-dark .widget.widget_recent_entries ul li a:hover,
		.wvc-font-dark .widget.widget_recent_comments ul li a:hover,
		.wvc-font-dark .widget.widget_archive ul li a:hover,
		.wvc-font-dark .widget.widget_categories ul li a:hover,
		.wvc-font-dark .widget.widget_meta ul li a:hover,
		.wvc-font-dark .widget.widget_product_categories ul li a:hover,
		.wvc-font-dark .widget.widget_nav_menu ul li a:hover,

		.wvc-font-light .widget.widget_pages ul li a:hover,
		.wvc-font-light .widget.widget_recent_entries ul li a:hover,
		.wvc-font-light .widget.widget_recent_comments ul li a:hover,
		.wvc-font-light .widget.widget_archive ul li a:hover,
		.wvc-font-light .widget.widget_categories ul li a:hover,
		.wvc-font-light .widget.widget_meta ul li a:hover,
		.wvc-font-light .widget.widget_product_categories ul li a:hover,
		.wvc-font-light .widget.widget_nav_menu ul li a:hover{
			color:$accent_color!important;
		}
	
		.widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-dark .widget.widget_tag_cloud .tagcloud a:hover,
		.wvc-font-light .widget.widget_tag_cloud .tagcloud a:hover{
			color:$accent_color!important;
		}

		.wvc-breadcrumb a:hover{
			color:$accent_color!important;
		}

		.nav-menu-desktop > li:not(.menu-button-primary):not(.menu-button-secondary) > a:first-child .menu-item-text-container:before{
			color:$accent_color;
		}

		.wolf-tweet-link:hover{
			color:$accent_color;
		}

		.accent-color-light #back-to-top:hover:after{
			color:#333!important;
		}

		.accent-color-dark #back-to-top:hover:after{
			color:#fff!important;
		}

		.coupon .button:hover{
			background:$accent_color!important;
			border-color:$accent_color!important;
		}

		.vonzot-button-primary,
		.vonzot-button-special-primary{
			background-color:$accent_color;
			border-color:$accent_color;
		}

		.vonzot-button-secondary,
		.vonzot-button-special-secondary{
			background-color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.vonzot-button-primary-alt:hover{
			background-color:$accent_color;
			border-color:$accent_color;
		}

		.vonzot-button-secondary-alt:hover{
			background-color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		button.wvc-mailchimp-submit,
		.login-submit #wp-submit,
		.single_add_to_cart_button,
		.wc-proceed-to-checkout .button,
		.woocommerce-form-login .button,
		.woocommerce-alert .button,
		.woocommerce-message .button{
			background:$accent_color;
			border-color:$accent_color;
		}

		.audio-shortcode-container .mejs-container .mejs-controls > .mejs-playpause-button{
			background:$accent_color;
		}

		ul.wc-tabs li:hover:after,
		ul.wc-tabs li.ui-tabs-active:after,
		ul.wc-tabs li.active:after,
		ul.wvc-tabs-menu li:hover:after,
		ul.wvc-tabs-menu li.ui-tabs-active:after,
		ul.wvc-tabs-menu li.active:after
		{
			background-color:$accent_color!important;
		}

		.wvc-accordion .wvc-accordion-tab.ui-state-active {
    			border-bottom-color: $accent_color;
    		}

		/* Secondary accent color */
		.wvc-text-color-secondary_accent{
			color:$secondary_accent_color;
		}
		
		.entry-product ins .woocommerce-Price-amount,
		.entry-single-product ins .woocommerce-Price-amount{
			color:$accent_color;
		}
	
		.wolf-tweet-text a,
		.wolf ul.wolf-tweet-list li:before,
		.wolf-bigtweet-content:before,
		.wolf-bigtweet-content a{
			color:$accent_color!important;
		}

		.wvc-background-color-secondary_accent{
			background-color:$secondary_accent_color;
		}

		.wvc-highlight-secondary_accent{
			background-color:$secondary_accent_color;
			color:#fff;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent{
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-button-background-color-secondary_accent .wvc-button-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

		.wvc-svg-icon-color-secondary_accent svg * {
			stroke:$secondary_accent_color!important;
		}

		.wvc-button-color-button-secondary_accent{
			background-color: $secondary_accent_color;
			border-color: $secondary_accent_color;
		}
				
		/* WVC icons */
		.wvc-icon-color-secondary_accent{
			color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
			color:$secondary_accent_color;
			border-color:$secondary_accent_color;
		}

		.wvc-icon-background-color-secondary_accent .wvc-icon-background-fill{
			box-shadow:0 0 0 0 $secondary_accent_color;
			background-color:$secondary_accent_color;
		}

	";

	$heading_selectors = apply_filters( 'vonzot_heading_selectors', vonzot_list_to_array( 'h1:not(.wvc-bigtext), h2:not(.wvc-bigtext), h3:not(.wvc-bigtext), h4:not(.wvc-bigtext), h5:not(.wvc-bigtext), .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wvc-counter-text, .wvc-countdown-period, .location-title, .logo-text, .wvc-interactive-links, .wvc-interactive-overlays, .heading-font' ) );

	$heading_selectors = vonzot_array_to_list( $heading_selectors );
	$output .= "$heading_selectors{text-rendering: auto;}";
	if ( preg_match( '/dark/', vonzot_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-light{
			background-color:$page_background_color;
		}";
	}
	if ( preg_match( '/light/', vonzot_get_theme_mod( 'color_scheme' ) ) ) {
		$output .= ".wvc-background-color-default.wvc-font-dark{
			background-color:$page_background_color;
		}";
	}

	return $output;
}
add_filter( 'vonzot_color_scheme_output', 'vonzot_edit_color_scheme_css', 10, 2 );

/**
 * Vertical bar colors
 */
function vonzot_output_additional_styles() {

	$output = '';

	/* Content inner background */
	$c_ci_bg_color = vonzot_get_inherit_mod( 'content_inner_bg_color' );

	if ( $c_ci_bg_color ) {
		$output .= ".content-inner{
	background-color: $c_ci_bg_color;
}";
	}

	/* Product thumbnail padding */
	$p_t_padding = vonzot_get_inherit_mod( 'product_thumbnail_padding' );

	if ( $p_t_padding ) {
		$p_t_padding = vonzot_sanitize_css_value( $p_t_padding );
		$output .= ".entry-product-masonry_overlay_quickview .product-thumbnail-container,
.entry-product-grid_overlay_quickview .product-thumbnail-container,
.wwcq-product-quickview-container .product-images .slide-content img{
	padding: $p_t_padding;
}";
	}


	if ( ! SCRIPT_DEBUG ) {
		$output = vonzot_compact_css( $output );
	}

	wp_add_inline_style( 'vonzot-style', $output );
}
add_action( 'wp_enqueue_scripts', 'vonzot_output_additional_styles', 999 );

/**
 * Save modal window content after import
 */
function vonzot_set_modal_window_content_after_import() {
	$post = get_page_by_title( 'Modal Window Content', OBJECT, 'wvc_content_block' );

	if ( $post && function_exists( 'wvc_update_option' ) ) {
		wvc_update_option( 'modal_window', 'content_block_id', $post->ID );
	}
}
add_action( 'pt-ocdi/after_import', 'vonzot_set_modal_window_content_after_import' );

/**
 * Filter lightbox settings
 */
function vonzot_filter_lightbox_settings( $settings ) {

	$settings['transitionEffect'] = 'fade';
	$settings['buttons'] = array(
		'zoom',
		'close',
	);

	return $settings;
}
add_filter( 'vonzot_fancybox_settings', 'vonzot_filter_lightbox_settings' );

/*----------------------------------------------------------------------------------

	Player function

--------------------------------------------------------------------------------------*/
/**
 * Minimal player
 *
 * Displays a play/pause audio player on product grid
 */
function vonzot_minimal_player( $post_id = null ) {
	$post_id = ( $post_id ) ? $post_id : get_the_ID();
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );
	$rand = rand( 0, 99999 );

	if ( ! $audio_meta ) {
		return;
	}
	?>
	<a href="#" class="minimal-player-play-button">
	<i class="minimal-player-icon minimal-player-play"></i><i class="minimal-player-icon minimal-player-pause"></i>
	</a>
	<audio preload="none" class="minimal-player-audio" id="minimal-player-audio-<?php echo absint( $rand ); ?>" src="<?php echo esc_url( $audio_meta ); ?> "></audio>
	<?php
}


function vonzot_add_menu_cta_content_type_options( $array ) {

	$array['play_button'] = esc_html__( 'Play/Pause Button', 'vonzot' );

	return $array;
}


function vonzot_add_play_pause_button_to_secondary_menu( $context ) {

	$mp3_id = vonzot_get_inherit_mod( 'nav_player_mp3' );
	$show_player = vonzot_get_inherit_mod( 'show_nav_player' );

	if ( $mp3_id && 'yes' === $show_player && 'desktop' === $context ) {
		$mp3_url = wp_get_attachment_url( $mp3_id );
		echo '<div id="nav-player-container" class="nav-player-container cta-item">';
		echo '<span class="fa nav-play-icon nav-play-button" title="' . esc_attr( __( 'Play', 'vonzot' ) ) . '"></span>';
		echo '<audio class="nav-player" id="' . uniqid( 'nav-player-' ) . '" src="' . esc_url( $mp3_url ) . '"></audio>';
		echo '</div>';
	}
	
}
add_action( 'vonzot_secondary_menu', 'vonzot_add_play_pause_button_to_secondary_menu', 10, 1 );

/**
 * Add label
 */
function vonzot_add_single_product_page_label() {

	$output = '';
	$label = get_post_meta( get_the_ID(), '_post_product_mp3_label', true );

	if ( $label ) {
		echo '<span class="single-product-song-label">' . $label . '</span>';
	}

	echo vonzot_kses( $output );
}
add_action( 'woocommerce_single_product_summary', 'vonzot_add_single_product_page_label', 15 );

/**
 * Add MP3 player on single product page
 */
function vonzot_add_audio_player_on_single_product_page() {

	$output = '';
	$playlist_id = get_post_meta( get_the_ID(), '_post_product_playlist_id', true );
	$hide_audio = get_post_meta( get_the_ID(), '_post_wc_product_hide_mp3_player', true );
	$audio_meta = get_post_meta( get_the_ID(), '_post_product_mp3', true );

	if ( $audio_meta && ! $hide_audio && ! $playlist_id ) {
		$audio_attrs = array(
			'src' => esc_url( $audio_meta ),
			'loop' => false,
			'autoplay' => false,
			'preload'  => 'auto',
		);

		$output = wp_audio_shortcode( $audio_attrs );
	}

	echo $output;
}
add_action( 'woocommerce_single_product_summary', 'vonzot_add_audio_player_on_single_product_page', 15 );

/**
 * Add MP3 player on single product page
 */
function vonzot_add_wpm_playlist_on_single_product_page() {

	$playlist_id = get_post_meta( get_the_ID(), '_post_product_playlist_id', true );
	$skin = get_post_meta( get_the_ID(), '_post_sticky_playlist_skin', true );

	if ( $playlist_id ) {

		$attrs = array(
		);

		if ( $skin ) {
			$attrs['theme'] = $skin;
		}

		if ( function_exists( 'wpm_playlist' ) ) {
			wpm_playlist( $playlist_id, $attrs );
		}
	}
}
add_action( 'woocommerce_single_product_summary', 'vonzot_add_wpm_playlist_on_single_product_page', 15 );

/**
 * ADD META FIELD TO SEARCH QUERY
 *
 * @param string $field
 */
function vonzot_add_meta_field_to_search_query( $field ){
	
	if ( isset( $GLOBALS['added_meta_field_to_search_query'] ) ) {
		$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';
		return;
	}

	$GLOBALS['added_meta_field_to_search_query'] = array();
	$GLOBALS['added_meta_field_to_search_query'][] = '\'' . $field . '\'';

	add_filter( 'posts_join', function( $join ) {
		global $wpdb;

		if ( is_search() ) {
			$join .= " LEFT JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
		}

		return $join;
	} );

	add_filter( 'posts_groupby', function( $groupby ) {
		global $wpdb;

		if ( is_search() ) {    
			$groupby = "$wpdb->posts.ID";
		}

		return $groupby;
	} );

	add_filter( 'posts_search', function( $search_sql ) {
		global $wpdb;

		$search_terms = get_query_var( 'search_terms' );

		if ( ! empty( $search_terms ) ) {
			foreach ( $search_terms as $search_term ) {
				$old_or = "OR ({$wpdb->posts}.post_content LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}')";
				$new_or = $old_or . " OR ({$wpdb->postmeta}.meta_value LIKE '{$wpdb->placeholder_escape()}{$search_term}{$wpdb->placeholder_escape()}' AND {$wpdb->postmeta}.meta_key IN (" . implode(', ', $GLOBALS['added_meta_field_to_search_query']) . "))";
				$search_sql = str_replace( $old_or, $new_or, $search_sql );
			}
		}

		$search_sql = str_replace( " ORDER BY ", " GROUP BY $wpdb->posts.ID ORDER BY ", $search_sql );

		return $search_sql;
	} );
}
vonzot_add_meta_field_to_search_query( '_post_subheading' );
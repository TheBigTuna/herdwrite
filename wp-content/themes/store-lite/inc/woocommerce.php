<?php
/**
 * Woocommerce Compatibility.
 *
 * @link https://woocommerce.com/
 *
 * @package Store Lite
 */

/**
 * Remove WooCommerce Default Sidebar.
 */

remove_action('wp_footer', 'woocommerce_demo_store', 10);
remove_action( 'woocommerce_sidebar','woocommerce_get_sidebar',10 );

if( !function_exists('store_lite_woocommerce_get_sidebar' ) ):

	// Woocommerce Custom Sidebars.
	function store_lite_woocommerce_get_sidebar(){

		$default = store_lite_get_default_theme_options();

		if( is_product() ){
			$sidebar_layout = esc_html( get_theme_mod( 'product_sidebar_layout',$default['product_sidebar_layout'] ) );
		}else{
			$sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout', $default['global_sidebar_layout'] ) );
		}

		if( $sidebar_layout != 'no-sidebar' ){

			if ( ! is_active_sidebar( 'store-lite-woocommerce-widget' ) ) {
			return;
			} ?>

			<aside id="secondary" class="widget-area">
				<?php dynamic_sidebar( 'store-lite-woocommerce-widget' ); ?>
			</aside><!-- #secondary -->

		<?php }
	}

endif;
add_action( 'woocommerce_sidebar','store_lite_woocommerce_get_sidebar',10 );

/**
 * Woocommerce support.
 */
function store_lite_woocommerce_setup() {

	add_theme_support( 'woocommerce' );
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
	add_theme_support( 'woocommerce', array(
		'gallery_thumbnail_image_width' => 300,
	) );

}
add_action( 'after_setup_theme', 'store_lite_woocommerce_setup' );
/**
* Woocommerce Widget Area.
*/
function store_lite_woocommerc_widgets_init()
{   

    register_sidebar( array(
        'name' => esc_html__('WooCommerce Sidebar', 'store-lite'),
        'id' => 'store-lite-woocommerce-widget',
        'description' => esc_html__('Add widgets here.', 'store-lite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

}
add_action('widgets_init', 'store_lite_woocommerc_widgets_init');

/**
 * Woocommerce Enqueue Scripts.
 */
function store_lite_woocommerce_scripts() {

	wp_enqueue_style( 'store-lite-woocommerce-style', get_template_directory_uri() . '/assets/lib/twp/css/woocommerce.css' );

}
add_action( 'wp_enqueue_scripts', 'store_lite_woocommerce_scripts' );


if ( ! function_exists( 'store_lite_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function store_lite_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		store_lite_woocommerce_cart_link();
		$fragments['.cart-total-item'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'store_lite_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'store_lite_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function store_lite_woocommerce_cart_link() { ?>

		<div <?php if( WC()->cart->get_cart_contents_count() <= 0 ){ ?>style="opacity: 0" <?php } ?> class="cart-total-item">
			<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'store-lite' ); ?>">
				<?php
				$item_count_text = sprintf(
					/* translators: number of items in the mini cart. */
					_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'store-lite' ),
					WC()->cart->get_cart_contents_count()
				);
				?>
				<span class="amount"><?php echo store_lite_cart_subtotal_escape( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
			</a>
			<span class="item-count"><?php echo absint( WC()->cart->get_cart_contents_count() ); ?></span>
		</div>
	<?php
	}
}

if ( ! function_exists( 'store_lite_woocommerce_header_cart()' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function store_lite_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
			<div class="minicart-title-handle">
                <div class="twp-cart-icon"></div>
				<?php store_lite_woocommerce_cart_link() ?>
			</div>
	        <div class="minicart-content">
	            <div class="site-header-cart">
	                <div class="total-details <?php echo esc_attr( $class ); ?>">
	                	<?php store_lite_woocommerce_cart_link() ?>
	                </div>
	                <div class="twp-minicart-content">
	                    <?php
	                    $instance = array(
	                        'title' => '',
	                    );

	                    the_widget( 'WC_Widget_Cart', $instance );
	                    ?>
	                </div>
	            </div>
	        </div>
		<?php
	}
}

if ( !function_exists('store_lite_yith_quickview_button') ) {

    /**
     * Display YITH Quickview Buttons.
     *
     */
    function store_lite_yith_quickview_button()
    {
        if (!function_exists('yith_wcqv_install'))
        return;

        global $product, $post;
        $product_id = $post->ID;
        $label = 'Compare';

        if (!$product_id) {
            $product instanceof WC_Product && $product_id = yit_get_prop($product, 'id', true);
        }

        $button = '';
        if ($product_id) {
        	$button .= '<div class="twp-quicknav-item quicknav-item-quick">';
            $button .= '<a href="javascript:void(0)" class="button yith-wcqv-button" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Quick View','store-lite').'" data-product_id="' . absint( $product_id ) . '"><i class="ion ion-ios-eye twp-quick-icons" aria-hidden="true"></i></a>';
            $button .= '</div>';
        }
        echo $button;


    }
}

add_action('store_lite_yith_quick_view_button', 'store_lite_yith_quickview_button', 10);

if (!function_exists('store_lite_yith_wishlist_button')) {

    /**
     * Display YITH wishlist Buttons
     *
     */
    function store_lite_yith_wishlist_button()
    {

        if (!function_exists('YITH_WCWL')) {
            return;
        }
        ?><div class="twp-quicknav-item quicknav-item-wishlist"><?php
        echo do_shortcode("[yith_wcwl_add_to_wishlist]");
        ?></div><?php
    }
}

add_action('store_lite_add_to_wishlist_button', 'store_lite_yith_wishlist_button', 15);

if (!function_exists('store_lite_yith_compare_button')) {

    /**
     * Display YITH Compare
     *
     */
    function store_lite_yith_compare_button()
    {
        if (!class_exists('YITH_Woocompare')) {
            return;
        }

            $id = get_the_ID();
            $cp_link = str_replace('&', '&amp;',add_query_arg( array('action' => 'yith-woocompare-add-product','id' => $id )));
            ?><div class="twp-quicknav-item quicknav-item-compare"><?php
            echo'<div class="woocommerce product compare-button"><a href="'.esc_url($cp_link).'" class="compare" data-toggle="tooltip" data-placement="top" title="'.esc_html__('Add To Compare','store-lite').'" data-product_id="'.absint($id).'" rel="nofollow"><i class="ion ion-ios-shuffle twp-quick-icons"></i><span class="screen-reader-text">'.esc_html__('Compare','store-lite').'</span></a></div>';
            ?></div><?php

    }
}

add_action('store_lite_compare_button', 'store_lite_yith_compare_button', 20);

/*
* Update Wishlist Count Ajax.
*/
add_action( 'wp_ajax_store_lite_update_wishlist_count', 'store_lite_update_wishlist_count' );
add_action( 'wp_ajax_nopriv_store_lite_update_wishlist_count', 'store_lite_update_wishlist_count' );

if( ! function_exists('store_lite_update_wishlist_count') ){

	// Return Wishlist Count
    function store_lite_update_wishlist_count(){

        if( function_exists( 'YITH_WCWL' ) ){
        	wp_send_json( YITH_WCWL()->count_products() );
        }
    }

}

add_filter( 'add_to_cart_text', 'store_lite_add_to_cart_button_icon' );
add_filter( 'woocommerce_product_add_to_cart_text', 'store_lite_add_to_cart_button_icon' );
function store_lite_add_to_cart_button_icon() {
  
    return '<span class="twp-cart-icon twp-quick-icons"></span>';
  
}

if( ! function_exists('store_lite_scripts_woocommerce_gallery') ):

	// Product Gallery Support Home
	function store_lite_scripts_woocommerce_gallery(){

		if( version_compare( WC()->version, '3.0.0', '>=' ) ) {

	      	if( current_theme_supports('wc-product-gallery-zoom') ) {
		        wp_enqueue_script('zoom');
		    }

		    if( current_theme_supports('wc-product-gallery-lightbox') ) {
		        wp_enqueue_script('photoswipe-ui-default');
		        wp_enqueue_style('photoswipe-default-skin');
		        if( has_action('wp_footer', 'woocommerce_photoswipe') === FALSE ) {
		            add_action('wp_footer', 'woocommerce_photoswipe', 15);
		        }
		    }
	    wp_enqueue_script('wc-single-product');
		}

	}

endif;
add_action('wp_enqueue_scripts', 'store_lite_scripts_woocommerce_gallery');
 
add_action( 'woocommerce_before_add_to_cart_quantity', 'store_lite_display_quantity_plus' );
 
function store_lite_display_quantity_plus() {
	echo '<div class="twp-qty-wrap">';
   	echo '<button type="button" class="twp-plus-upward" ><i class="ion ion-ios-add"></i></button>';
}
 
add_action( 'woocommerce_after_add_to_cart_quantity', 'store_lite_display_quantity_minus' );
 
function store_lite_display_quantity_minus() {
   echo '<button type="button" class="twp-minus-downward" ><i class="ion ion-ios-remove"></i></button>';
   echo '</div>';
}
<?php
/**
 * Add to wishlist button template
 *
 * @author Your Inspiration Themes
 * @package YITH WooCommerce Wishlist
 * @version 2.0.8
 */

if ( ! defined( 'YITH_WCWL' ) ) {
    exit;
} // Exit if accessed directly

global $product;
?>

<a href="<?php echo esc_url( add_query_arg( 'add_to_wishlist', $product_id ) )?>" rel="nofollow" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Add To Wishlist','store-lite'); ?>" data-product-id="<?php echo absint( $product_id) ?>" data-product-type="<?php echo esc_attr( $product_type )?>" class="<?php echo esc_attr( $link_classes ) ?>" >
	<?php if( $exists && !$available_multi_wishlist ){ ?>
    	<i class="ion ion-ios-heart twp-quick-icons" aria-hidden="true"></i>
    <?php }else{ ?>
    	<i class="ion ion-ios-heart-empty twp-quick-icons" aria-hidden="true"></i>
    <?php } ?>
</a>
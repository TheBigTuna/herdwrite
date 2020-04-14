<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( 'twp-individual-product', $product ); ?>>
    
    <div class="individual-product-wrapper">
                                            
        <div class="twp-product-details">
            <div class="twp-product-content">
                <h2 class="twp-item-title twp-item-small">
                    <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
                </h2>
                <div class="twp-item-ratings">
                    <?php woocommerce_template_loop_rating(); ?>
                </div>
                <div class="twp-item-price">
                    <?php woocommerce_template_loop_price(); ?>
                </div>
            </div>
        </div>

        <?php $attachment_ids = $product->get_gallery_image_ids(); ?>
        <div class="twp-product-image-holder <?php if( $attachment_ids ){ echo "image-switch-enabled"; } ?>">

            <a href="<?php the_permalink() ?>" class="twp-product-link" target="_self">
                <?php woocommerce_show_product_loop_sale_flash(); ?>

                <?php
                /**
                * woocommerce_before_shop_loop_item_title hook
                *
                * @hooked woocommerce_show_product_loop_sale_flash - 10
                * @hooked woocommerce_template_loop_product_thumbnail - 10
                */
                woocommerce_template_loop_product_thumbnail();
                ?>

                <?php
                if( $attachment_ids ){
                    $i = 1;
                    foreach( $attachment_ids as $attachment_id ) {
                        if( $i == 1 ){
                            $image_link = wp_get_attachment_image_src( $attachment_id,'woocommerce_thumbnail' ); ?>
                             <div class="twp-product-cover">
                                <img src="<?php echo esc_url( $image_link[0] ); ?>" alt="">
                             </div>
                        <?php break; }
                    $i++; }
                } ?>
            </a>

            <div class="twp-quicknav-items">
                
                <div class="twp-quicknav-item quicknav-item-cart" data-toggle="tooltip" data-placement="top" title="<?php esc_html_e('Add To Cart','store-lite'); ?>">
                    <?php woocommerce_template_loop_add_to_cart(); ?>
                </div>

                <?php do_action('store_lite_add_to_wishlist_button'); ?>

                <?php do_action('store_lite_yith_quick_view_button'); ?>

                <?php do_action('store_lite_compare_button'); ?>

            </div>

        </div>
        
    </div>

</li>

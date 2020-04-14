<?php
/**
 * Header Product category Function.
 *
 * @package Store Lite
 */


if (!function_exists('store_lite_bottom_header')):

    // Header product category.
    function store_lite_bottom_header(){

        $default = store_lite_get_default_theme_options();
        $ed_mid_header_product_category = get_theme_mod( 'ed_mid_header_product_category',$default['ed_mid_header_product_category'] );
        $ed_mid_header_search = get_theme_mod( 'ed_mid_header_search',$default['ed_mid_header_search'] );
        $ed_mid_header_wishlist = get_theme_mod( 'ed_mid_header_wishlist',$default['ed_mid_header_wishlist'] );
        $header_login_page_link = get_theme_mod( 'header_login_page_link',$default['header_login_page_link'] );
        $ed_mid_header_login_reg = get_theme_mod( 'ed_mid_header_login_reg',$default['ed_mid_header_login_reg'] );
        $header_product_cat = array(); ?>

            <div class="twp-secondary-navbar">
                <div class="container">
                    <div class="twp-header-area">
                        
                        <?php
                        if ( class_exists('WooCommerce') && $ed_mid_header_product_category ) {

                            store_lite_bottom_header_product_category();

                        }

                        if ( class_exists('WooCommerce') && $ed_mid_header_search ) { ?>
                            <div class="twp-headerarea-center hidden-xs">
                                <?php store_lite_product_search(); ?>
                            </div>
                        <?php }

                        if( class_exists('WooCommerce') && ( $ed_mid_header_login_reg || $ed_mid_header_wishlist ) ){ ?>

                            <div class="twp-headerarea-right">

                                <?php if( $ed_mid_header_login_reg ){ ?>

                                    <div class="twp-user-mgmt header-right-item">
                                        <div class="twp-user-icon">
                                            <a href="<?php echo esc_url( $header_login_page_link ); ?>">
                                                <i class="nav-icon-right twp-user-contact"></i>
                                            </a>
                                        </div>
                                        <?php if( !is_user_logged_in() ): ?>
                                        <div class="twp-user-tools hidden-sm hidden-xs">
                                            <a href="<?php echo esc_url( $header_login_page_link ); ?>" class="user-tools-link twp-user-login">
                                                <?php esc_html_e('Log in','store-lite'); ?>
                                            </a>
                                            <a href="<?php echo esc_url( $header_login_page_link ); ?>" class="user-tools-link twp-user-register">
                                                <?php esc_html_e('Register','store-lite'); ?>
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="twp-user-tools hidden-sm hidden-xs">
                                            <a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="user-tools-link twp-user-myaccount">
                                                <?php esc_html_e('My Account','store-lite'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>

                                    </div>

                                <?php } ?>

                                <?php if ( class_exists('YITH_WCWL') && $ed_mid_header_wishlist ) {
                                $header_wishlist_page_link = get_theme_mod( 'header_wishlist_page_link',$default['header_wishlist_page_link'] ); ?>
                                    <div class="twp-wishlist-count header-right-item">
                                        <a href="<?php echo esc_url( $header_wishlist_page_link ); ?>" class="twp-header-wishlist">
                                            <i class="nav-icon-right ion ion-md-heart-empty" aria-hidden="true"></i>
                                            <span class="twp-wishlist-count">
                                                <?php echo absint( yith_wcwl_count_all_products() ); ?>
                                            </span>
                                        </a>
                                    </div>
                                <?php } ?>

                            </div>

                        <?php } ?>

                    </div>
                </div>
            </div>
    <?php
    }

endif;
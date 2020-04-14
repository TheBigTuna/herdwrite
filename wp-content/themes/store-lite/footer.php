<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store_Lite
 */

?>
<?php if ( !is_front_page() || ( is_front_page() && class_exists( 'WooCommerce' ) && is_shop() ) ): ?>
</div><!-- #content -->
<?php endif; ?>

<?php get_template_part('template-parts/header/offcanvas', 'menu'); ?>
<?php get_template_part('template-parts/footer/footer', 'component'); ?>
<?php
if( !is_home() && !is_front_page() ){
    get_template_part('template-parts/footer/footer', 'subscribe');
}
$default = store_lite_get_default_theme_options();
?>

<footer id="colophon" class="site-footer">
    <?php
    
    if ( is_active_sidebar('store-lite-footer-widget-0') || is_active_sidebar('store-lite-footer-widget-1') || is_active_sidebar('store-lite-footer-widget-2') ):

        
        $footer_column_layout = absint( get_theme_mod('footer_column_layout', $default['footer_column_layout'] ) ); ?>

        <div class="footer-top <?php echo 'footer-column-' . absint($footer_column_layout); ?>">
            <div class="wrapper">
                <div class="footer-grid twp-row">
                    <?php if ( is_active_sidebar('store-lite-footer-widget-0') ): ?>
                        <div class="column column-1">
                            <?php dynamic_sidebar('store-lite-footer-widget-0'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar('store-lite-footer-widget-1') ): ?>
                        <div class="column column-2">
                            <?php dynamic_sidebar('store-lite-footer-widget-1'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ( is_active_sidebar('store-lite-footer-widget-2') ): ?>
                        <div class="column column-3">
                            <?php dynamic_sidebar('store-lite-footer-widget-2'); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    <?php endif; ?>

    <?php if( has_nav_menu('twp-social-menu') || has_nav_menu('twp-footer-menu') ) { ?>
        <div class="footer-middle">
            <div class="container">
                <div class="twp-row">

                    <div class="column">
                        <div class="footer-middle-seperator"></div>
                    </div>
                    
                    <?php if (has_nav_menu('twp-social-menu')) { ?>
                        <div class="column column-three column-full-sm">
                            <div class="footer-social">
                                <div class="social-icons">
                                    <?php
                                    wp_nav_menu(
                                        array('theme_location' => 'twp-social-menu',
                                            'link_before' => '<span class="screen-reader-text">',
                                            'link_after' => '</span>',
                                            'menu_id' => 'social-menu',
                                            'fallback_cb' => false,
                                            'menu_class' => false
                                        )); ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    
                    <?php if ( has_nav_menu('twp-footer-menu') ) { ?>
                        <div class="column column-seven column-full-sm">
                            <div class="footer-menu">
                                <?php wp_nav_menu( array(
                                    'theme_location' => 'twp-footer-menu',
                                    'menu_id' => 'footer-menu',
                                    'container' => 'div',
                                    'container_class' => 'menu',
                                    'depth' => 1,
                                ) ); ?>
                            </div>
                        </div>
                    <?php } ?>
                    

                    <div class="column">
                        <div class="footer-middle-seperator"></div>
                    </div>

                </div>
            </div>
        </div>
    <?php } ?>

    <div class="footer-bottom">
        <div class="wrapper">
            <div class="footer-info">
                
                <div class="site-info">
                    <?php
                    $footer_copyright_text = wp_kses_post( get_theme_mod( 'footer_copyright_text',$default['footer_copyright_text'] ) );
                    if (!empty( $footer_copyright_text ) ) {
                        echo wp_kses_post( $footer_copyright_text );
                    }
                    ?>
                    <?php
                    /* translators: 1: Theme name, 2: Theme author. */
                    printf(esc_html__('Theme: %1$s by %2$s', 'store-lite'), '<span>Store Lite</span>', '<a href="https://www.themeinwp.com/"><span>Themeinwp</span></a>');
                    ?>
                </div>

                <?php
                $ed_bbb_icon = absint( get_theme_mod( 'ed_bbb_icon',$default['ed_bbb_icon'] ) );
                $ed_visa_icon = absint( get_theme_mod( 'ed_visa_icon',$default['ed_visa_icon'] ) );
                $ed_mastercard_icon = absint( get_theme_mod( 'ed_mastercard_icon',$default['ed_mastercard_icon'] ) );
                $ed_american_express_icon = absint( get_theme_mod( 'ed_american_express_icon',$default['ed_american_express_icon'] ) );
                $ed_discover_icon = absint( get_theme_mod( 'ed_discover_icon',$default['ed_discover_icon'] ) );

                if( $ed_bbb_icon || 
                    $ed_visa_icon || 
                    $ed_mastercard_icon || 
                    $ed_american_express_icon || 
                    $ed_discover_icon ){ ?>

                    <div class="twp-payment-processor">
                        <ul>
                            <?php if( $ed_bbb_icon ){ ?>
                                <li>
                                    <span class="twp-payment-icon twp-icon-bbb"></span>
                                </li>
                            <?php } ?>

                            <?php if( $ed_visa_icon ){ ?>
                                <li>
                                    <span class="twp-payment-icon twp-icon-visa"></span>
                                </li>
                            <?php } ?>

                            <?php if( $ed_mastercard_icon ){ ?>
                                <li>
                                    <span class="twp-payment-icon twp-icon-mastercard"></span>
                                </li>
                            <?php } ?>

                            <?php if( $ed_american_express_icon ){ ?>
                                <li>
                                    <span class="twp-payment-icon twp-icon-amex"></span>
                                </li>
                            <?php } ?>

                            <?php if( $ed_discover_icon ){ ?>
                                <li>
                                    <span class="twp-payment-icon twp-icon-discover"></span>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>

                <?php } ?>

            </div>
        </div>
    </div>
</footer>
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>

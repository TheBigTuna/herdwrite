<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Store Lite
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <link rel="profile" href="https://gmpg.org/xfn/11">

        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?>>
<?php
if ( function_exists( 'wp_body_open' ) ) {
    wp_body_open();
}

$default = store_lite_get_default_theme_options();
$ed_preloader = absint( get_theme_mod('ed_preloader', $default['ed_preloader'] ) );

if ( $ed_preloader && !is_customize_preview() ) {

    $preloader_text = esc_html( get_theme_mod('preloader_text', $default['preloader_text'] ) ); ?>

    <div class="preloader">
        <div class="layer"></div>
        <div class="inner">
            <figure>
                <div class="preloader-spinner"></div>
            </figure>
            <?php if( $preloader_text ){ ?>
                <span><?php echo esc_html( $preloader_text ); ?></span>
            <?php } ?>
        </div>
    </div>

    <div class="page-transition">
        <div class="layer"></div>
    </div>

<?php } ?>


<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e('Skip to content', 'store-lite'); ?></a>

<div class="top-leadbar">
    <?php
    $header_advertise_image = esc_url(get_theme_mod('header_advertise_image'));
    $header_advertise_link = esc_url(get_theme_mod('header_advertise_link'));

    if ($header_advertise_image) { ?>
        <div class="top-lead-banner">
            <?php if ($header_advertise_link) { ?>
                <a target="_blank" href="<?php echo esc_url($header_advertise_link) ?>">
                    <?php } ?>
                    <img src="<?php echo esc_url($header_advertise_image) ?>">
                    <?php if ($header_advertise_link) { ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<div class="site-topbar">
    <div class="container">
        <div class="twp-topbar-area">
            <div class="topbar-left">
                <?php if( is_active_sidebar('store-lite-offcanvas-widget') ): ?>
                    <button id="widgets-nav" class="icon-sidr">
                        <div class="trigger-icon">
                            <span class="icon-bar top"></span>
                            <span class="icon-bar middle"></span>
                            <span class="icon-bar bottom"></span>
                        </div>
                    </button>
                <?php endif; ?>

                <?php if( has_nav_menu('twp-top-menu') ) { ?>
                    <div class="topbar-nav hidden-xs hidden-sm">
                        <?php
                        wp_nav_menu(
                            array('theme_location' => 'twp-top-menu',
                                'menu_id' => 'top-menu',
                                'fallback_cb' => false,
                                'menu_class' => false,
                                'depth' => 1,
                            )); ?>
                    </div>
                <?php } ?>

            </div>
            <div class="topbar-right">
                <?php if (has_nav_menu('twp-social-menu')) { ?>
                    <div class="social-icons">
                        <?php
                        wp_nav_menu(
                            array('theme_location' => 'twp-social-menu',
                                'link_before' => '<span class="screen-reader-text">',
                                'link_after' => '</span>',
                                'menu_id' => 'social-menu',
                                'fallback_cb' => false,
                                'menu_class' => false,
                                'depth' => 1,
                            )); ?>
                    </div>
                <?php } ?>

                <?php
                    $header_currency_switcher_shortcode = get_theme_mod('header_currency_switcher_shortcode');
                    if( $header_currency_switcher_shortcode ){
                        echo "<div class='twp-currency-switcher'>";
                        echo do_shortcode($header_currency_switcher_shortcode);
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<header id="masthead" class="site-header">
    <div class="container">
        <div class="twp-header-area">
            <div class="twp-headerarea-left">
                <div class="site-branding">
                    <?php
                    the_custom_logo();
                    if (is_front_page() && is_home()) :
                        ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>"
                               rel="home"><?php bloginfo('name'); ?></a>
                        </h1>
                    <?php
                    else :
                        ?>
                        <p class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>"
                               rel="home"><?php bloginfo('name'); ?></a>
                        </p>
                    <?php
                    endif;
                    $store_lite_description = get_bloginfo('description', 'display');
                    if ($store_lite_description || is_customize_preview()) :
                        ?>
                        <p class="site-description">
                            <span><?php echo esc_html($store_lite_description); /* WPCS: xss ok. */ ?></span>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="twp-headerarea-right">
                <nav id="site-navigation" class="main-navigation">
                    <div class="main-navigation-primary">
                        <div class="toggle-menu" aria-controls="primary-menu" aria-expanded="false">
                            <a class="offcanvas-toggle" href="#">
                                <div class="offcanvas-trigger">
                                   <span class="menu-label">
                                        <?php esc_html_e('Menu', 'store-lite'); ?>
                                    </span>
                                </div>
                            </a>
                        </div>

                        <?php
                        if( has_nav_menu('twp-primary-menu') ){

                             wp_nav_menu(array(
                                'theme_location' => 'twp-primary-menu',
                                'menu_id' => 'primary-menu',
                                'container' => 'div',
                                'container_class' => 'menu',
                                'walker' => new store_lite\Store_lite_Walkernav(),

                            ));

                        }else{

                            wp_nav_menu(array(
                                'theme_location' => 'twp-primary-menu',
                                'menu_id' => 'primary-menu',
                                'container' => 'div',
                                'container_class' => 'menu',
                            ));

                        } ?>
                    </div>

                </nav>

                <?php
                 if ( class_exists('WooCommerce') ) { ?>
                    <span class="twp-minicart">
                        <?php store_lite_woocommerce_header_cart(); ?>
                    </span>
                <?php } ?>
            </div>
        </div>
    </div>
</header>

<?php
$ed_mid_header_product_category = esc_html( get_theme_mod( 'ed_mid_header_product_category',$default['ed_mid_header_product_category'] ) );
$ed_mid_header_search = esc_html( get_theme_mod( 'ed_mid_header_search',$default['ed_mid_header_search'] ) );
$ed_mid_header_wishlist = esc_html( get_theme_mod( 'ed_mid_header_wishlist',$default['ed_mid_header_wishlist'] ) );
$ed_mid_header_login_reg = esc_html( get_theme_mod( 'ed_mid_header_login_reg',$default['ed_mid_header_login_reg'] ) );

if( $ed_mid_header_product_category || 
    $ed_mid_header_search || 
    $ed_mid_header_wishlist || 
    $ed_mid_header_login_reg ){

    store_lite_bottom_header();

} ?>

<?php if (class_exists('WooCommerce')) {
    
    if ( is_store_notice_showing() ) { ?>

        <div class="twp-wc-notice">
            <?php woocommerce_demo_store(); ?>
        </div>
    
    <?php
    }

} ?>

<?php if ( ( store_lite_check_woocommerce_page() && ( is_cart() || is_checkout() ) ) || ( !store_lite_check_woocommerce_page() && !is_home() && !is_front_page() && !is_page_template( 'template-parts/woocommerce-login.php' ) ) ) {
    do_action('store_lite_header_banner_x');
} ?>

<?php if( has_custom_header() && is_home() && is_front_page() ){

    $header_medai_text = esc_html( get_theme_mod('header_medai_text') );
    $header_medai_button_label = esc_html( get_theme_mod('header_medai_button_label',$default['header_medai_button_label'] ) );
    $header_medai_text_link = esc_url( get_theme_mod('header_medai_text_link') );

    echo '<div class="twp-header-banner">';

        the_custom_header_markup();

        if( $header_medai_text ){ ?>
            <div class="header-intro">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="entry-content">

                                <h2 class="entry-title entry-title-large"><?php echo esc_html( $header_medai_text ); ?></h2>
                                <div class="block-link">
                                    <a href="<?php echo esc_url($header_medai_text_link); ?>" title="<?php echo esc_attr($header_medai_button_label); ?>" class="twp-btn twp-btn-radius twp-btn-outline">
                                        <?php echo esc_html($header_medai_button_label); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
    echo '</div>';
} ?>

<?php if ( !is_front_page() || ( is_front_page() && class_exists( 'WooCommerce' ) && is_shop() ) ): ?>
    <div id="content" class="site-content">
<?php endif; ?>
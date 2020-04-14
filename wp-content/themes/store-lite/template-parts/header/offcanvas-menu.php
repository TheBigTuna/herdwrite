<?php
/**
 * Template for Off canvas Menu
 * @since store-lite 1.0.0
 */
?>
<div id="offcanvas-menu">
    <div class="close-offcanvas-menu offcanvas-item">
        <div class="offcanvas-close">
            <span>
               <?php echo esc_html__('Close', 'store-lite'); ?>
            </span>
            <span class="ion-ios-close-empty meta-icon meta-icon-large"></span>
        </div>
    </div>
    <?php if (has_nav_menu('twp-top-menu')) { ?>
        <div id="top-nav-offcanvas" class="offcanvas-navigation offcanvas-item">
            <div class="offcanvas-title">
                <?php esc_html_e('Top Navigation', 'store-lite'); ?>
            </div>
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

    <?php if (has_nav_menu('twp-primary-menu')) { ?>
        <div id="primary-nav-offcanvas" class="offcanvas-navigation offcanvas-item">
            <div class="offcanvas-title">
                <?php esc_html_e('Main Navigation', 'store-lite'); ?>
            </div>
            <?php wp_nav_menu(array(
                'theme_location' => 'twp-primary-menu',
                'menu_id' => 'primary-menu',
                'container' => 'div',
                'container_class' => 'menu'
            )); ?>
        </div>
    <?php } ?>


    <?php if (has_nav_menu('twp-primary-menu')) { ?>
        <div id="secondary-nav-offcanvas" class="offcanvas-navigation offcanvas-item">
            <div class="offcanvas-title">
                <?php esc_html_e('Secondary Navigation', 'store-lite'); ?>
            </div>
            <?php wp_nav_menu(array(
                'theme_location' => 'twp-secondary-menu',
                'menu_id' => 'secondary-menu',
                'container' => 'div',
                'container_class' => 'menu'
            )); ?>
        </div>
    <?php } ?>

    <?php if (has_nav_menu('twp-social-menu')) { ?>
        <div class="offcanvas-social offcanvas-item">
            <div class="offcanvas-title">
                <?php esc_html_e('Social profiles', 'store-lite'); ?>
            </div>
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
    <?php } ?>
</div>
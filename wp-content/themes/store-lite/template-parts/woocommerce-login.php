<?php
/**
 * Template Name: Woocommerce Login/Register
 **/
get_header();

    if ( class_exists( 'WooCommerce' ) ) {

        if ( is_active_sidebar('store-lite-login-page-widget') ){
            $wraper_class = 'col-md-6';
        }else{
            $wraper_class = 'col-md-6 col-md-offset-3';
        } ?>
        <div class="twp-blocks twp-no-bg twp-blocks-account">
            <div class="container">
                <div class="row">
                    <div class="<?php echo esc_attr( $wraper_class ); ?>">
                        <div class="twp-account-panel">
                            <div class="twp-account-header">
                                <ul class="nav twp-nav-tabs twp-tabs-horizontal" role="tablist">
                                    <li role="presentation" class="active">
                                        <a href="#twp-login-area" aria-controls="twp-login-area" role="tab" data-toggle="tab">
                                            <?php esc_html_e('Login','store-lite'); ?>
                                        </a>
                                    </li>
                                    <li role="presentation">
                                        <a href="#twp-register-area" aria-controls="twp-register-area" role="tab" data-toggle="tab">
                                            <?php esc_html_e('Register','store-lite'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="twp-login-area">
                                    <div class="twp-account-box twp-login-box">
                                        <?php do_action('store_lite_login_form_woocommerce_action'); ?>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="twp-register-area">
                                    <div class="twp-account-box twp-register-box">
                                        <?php do_action('store_lite_register_form_woocommerce_action'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ( is_active_sidebar('store-lite-login-page-widget') ): ?>
                        <div class="col-md-6">
                            <?php dynamic_sidebar('store-lite-login-page-widget'); ?>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    <?php
    }
get_footer();
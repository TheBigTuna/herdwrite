<?php
/**
* Mailchimp Function.
*
* @package Store Lite
*/

if( !function_exists('store_lite_subscribe') ):

    function store_lite_subscribe( $store_lite_home_section ){

        $footer_newsletter_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
        $footer_newsletter_desc = isset( $store_lite_home_section->section_desc ) ? $store_lite_home_section->section_desc : '' ;
        $footer_newsletter_shortcode = isset( $store_lite_home_section->mailchimp_shortcode ) ? $store_lite_home_section->mailchimp_shortcode : '' ;
        ?>
        <div class="twp-blocks twp-blocks-bg twp-newsletter-subscription">
            <div class="upper-footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="newsletter-block">
                                <div class="row">
                                    <div class="col-md-6">

                                        <?php if( $footer_newsletter_title ){ ?>
                                            <h2 class="entry-title entry-title-medium">
                                                <?php echo esc_html ( $footer_newsletter_title ); ?>
                                            </h2>
                                        <?php } ?>

                                        <?php if( $footer_newsletter_desc ){ ?>
                                            <div class="block-subtitle">
                                                <?php echo esc_html ( $footer_newsletter_desc ); ?>
                                            </div>
                                        <?php } ?>

                                    </div>

                                    <?php if( $footer_newsletter_shortcode ){ ?>
                                        <div class="col-md-6">
                                            <?php echo do_shortcode( $footer_newsletter_shortcode ); ?>
                                        </div>
                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }

endif;
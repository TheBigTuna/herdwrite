<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Store_Lite
 */

get_header();
$default = store_lite_get_default_theme_options();
global $post;
?>

    <div id="primary" class="content-area">
        <main id="main" class="site-main">

            <?php
            while (have_posts()) :
                the_post();

                get_template_part('template-parts/content', get_post_type());
                ?>

                <div class="twp-navigation-wrapper"><?php

                // Previous/next post navigation.
                the_post_navigation(array(
                    'next_text' => '<h2 class="entry-title entry-title-medium" aria-hidden="true">' . esc_html__('Next', 'store-lite') . '</h2> ' .
                        '<span class="screen-reader-text">' . esc_html__('Next post:', 'store-lite') . '</span> ' .
                        '<h3 class="entry-title entry-title-small">%title</h3>',
                    'prev_text' => '<h2 class="entry-title entry-title-medium" aria-hidden="true">' . esc_html__('Previous', 'store-lite') . '</h2> ' .
                        '<span class="screen-reader-text">' . esc_html__('Previous post:', 'store-lite') . '</span> ' .
                        '<h3 class="entry-title entry-title-small">%title</h3>',
                )); ?>

                </div><?php

                // If comments are open or we have at least one comment, load up the comment template.
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;

            endwhile; // End of the loop.
            ?>

        </main><!-- #main -->
    </div><!-- #primary -->

<?php
$global_sidebar_layout = esc_html( get_theme_mod( 'global_sidebar_layout', $default['global_sidebar_layout'] ) );
$store_lite_post_sidebar_option = esc_html( get_post_meta( $post->ID, 'store_lite_post_sidebar_option', true ) );

if ( $store_lite_post_sidebar_option == 'global-sidebar' || empty( $store_lite_post_sidebar_option ) ) {
    $store_lite_post_sidebar_option = $global_sidebar_layout;
}

if ( $store_lite_post_sidebar_option != 'no-sidebar' ):

    get_sidebar();

endif;

get_footer();

<?php
/**
* Widget FUnctions.
*
* @package Store Lite
*/

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function store_lite_widgets_init()
{   
    $default = store_lite_get_default_theme_options();
    
    register_sidebar( array(
        'name' => esc_html__('Sidebar', 'store-lite'),
        'id' => 'sidebar-1',
        'description' => esc_html__('Add widgets here.', 'store-lite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar( array(
        'name' => esc_html__('Offcanvas Widget', 'store-lite'),
        'id' => 'store-lite-offcanvas-widget',
        'description' => esc_html__('Add widgets here.', 'store-lite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    register_sidebar( array(
        'name' => esc_html__('Login Page Widget', 'store-lite'),
        'id' => 'store-lite-login-page-widget',
        'description' => esc_html__('Add widgets here.', 'store-lite'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
    ));

    $footer_column_layout = absint( get_theme_mod( 'footer_column_layout',$default['footer_column_layout'] ) );

    for( $i = 0; $i < $footer_column_layout; $i++ ){
    	
    	if( $i == 0 ){ $count = esc_html__('One','store-lite'); }
    	if( $i == 1 ){ $count = esc_html__('Two','store-lite'); }
    	if( $i == 2 ){ $count = esc_html__('Three','store-lite'); }

	    register_sidebar( array(
	        'name' => esc_html__('Footer Widget ', 'store-lite').$count,
	        'id' => 'store-lite-footer-widget-'.$i,
	        'description' => esc_html__('Add widgets here.', 'store-lite'),
	        'before_widget' => '<div id="%1$s" class="widget %2$s">',
	        'after_widget' => '</div>',
	        'before_title' => '<h2 class="widget-title">',
	        'after_title' => '</h2>',
	    ));
	}

}

add_action('widgets_init', 'store_lite_widgets_init');

/**
 * Widget Base Class.
 */
require get_template_directory() . '/inc/widgets/widget-base-class.php';

/**
 * Recent Post Widget.
 */
require get_template_directory() . '/inc/widgets/recent-post.php';

/**
 * Social Link Widget.
 */
require get_template_directory() . '/inc/widgets/social-link.php';

/**
 * Author Widget.
 */
require get_template_directory() . '/inc/widgets/author.php';

/**
 * Post Tabs Widget.
 */
require get_template_directory() . '/inc/widgets/tab-posts.php';

if ( class_exists( 'WooCommerce' ) ) {

    /**
     * Product Tabs Widget.
     */
    require get_template_directory() . '/inc/widgets/products-tab.php';

    /**
     * Product Lists Widget.
     */
    require get_template_directory() . '/inc/widgets/product-lists.php';

    /**
     * Product Category Widget.
     */
    require get_template_directory() . '/inc/widgets/product-category.php';

}

/**
 * Category Widget.
 */
require get_template_directory() . '/inc/widgets/category.php';
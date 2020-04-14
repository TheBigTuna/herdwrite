<?php
/**
 * Store Lite functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Store_Lite
 */

if (!function_exists('store_lite_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function store_lite_setup()
    {
        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on Store Lite, use a find and replace
         * to change 'store-lite' to the name of your theme in all the template files.
         */
        load_theme_textdomain('store-lite', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        // Starter Content
        add_theme_support( 'starter-content', array(
                'posts' => array(
                    'login' => array(
                        'post_type' => 'page',
                        'post_title' => esc_html__('Login','store-lite'),
                        'template' => 'template-parts/woocommerce-login.php',
                    ),
                    'wishlist' => array(
                        'post_type' => 'page',
                        'post_title' => esc_html__('Wishlist','store-lite'),
                        'post_content' => esc_html('[yith_wcwl_wishlist]','store-lite'),
                    ),
                ),
            )
        );

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
         */
        add_theme_support('post-thumbnails');

        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'twp-primary-menu' => esc_html__('Primary Menu', 'store-lite'),
            'twp-secondary-menu' => esc_html__('Secondary Menu', 'store-lite'),
            'twp-top-menu' => esc_html__('Top Menu', 'store-lite'),
            'twp-footer-menu' => esc_html__('Footer Menu', 'store-lite'),
            'twp-social-menu' => esc_html__('Social Menu', 'store-lite'),
        ));

        /*
         * Switch default core markup for search form, comment form, and comments
         * to output valid HTML5.
         */
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('store_lite_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        /*
         * Posts Formate.
         *
         * https://wordpress.org/support/article/post-formats/
         */
        add_theme_support( 'post-formats', array(
            'video',
            'audio',
            'gallery',
            'quote',
            'image'
        ) );

        // Add theme support for selective refresh for widgets.
        add_theme_support('customize-selective-refresh-widgets');

        /**
         * Add support for core custom logo.
         *
         * @link https://codex.wordpress.org/Theme_Logo
         */
        add_theme_support('custom-logo', array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        ));

        /**
         * Add theme support for gutenberg block
         *
         */
        add_theme_support( 'align-wide' );
    }
endif;
add_action('after_setup_theme', 'store_lite_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function store_lite_content_width()
{
    // This variable is intended to be overruled from themes.
    // Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
    // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
    $GLOBALS['content_width'] = apply_filters('store_lite_content_width', 730);
}

add_action('after_setup_theme', 'store_lite_content_width', 0);


/**
 * Enqueue scripts and styles.
 */
function store_lite_scripts()
{
    $fonts_url = store_lite_fonts_url();
    if (!empty($fonts_url)) {
        wp_enqueue_style('store-lite-google-fonts', $fonts_url, array(), null);
    }
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('ionicons', get_template_directory_uri() . '/assets/lib/ionicons/css/ionicons.min.css');
    wp_enqueue_style('slick', get_template_directory_uri() . '/assets/lib/slick/css/slick.min.css');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/magnific-popup.css');
    wp_enqueue_style('sidr-nav', get_template_directory_uri() . '/assets/lib/sidr/css/jquery.sidr.dark.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/lib/wow/css/animate.css');
    wp_enqueue_style('store-lite-style', get_stylesheet_uri());
   
    if( class_exists( 'WooCommerce' ) && is_home() ){
        wp_enqueue_script('flexslider-home', get_template_directory_uri() . '/assets/lib/flexslider/jquery.flexslider.min.js', array('jquery'), '', true);
    }

    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/lib/bootstrap/js/bootstrap.min.js', array('jquery'), '', true);
    wp_enqueue_script('store-lite-skip-link-focus-fix', get_template_directory_uri() . '/assets/lib/default/js/skip-link-focus-fix.js', array(), '20151215', true);
    wp_enqueue_script('slick', get_template_directory_uri() . '/assets/lib/slick/js/slick.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-magnific-popup', get_template_directory_uri() . '/assets/lib/magnific-popup/jquery.magnific-popup.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-sidr', get_template_directory_uri() . '/assets/lib/sidr/js/jquery.sidr.min.js', array('jquery'), '', true);
    wp_enqueue_script('theia-sticky-sidebar', get_template_directory_uri() . '/assets/lib/theiaStickySidebar/theia-sticky-sidebar.min.js', array('jquery'), '', true);
    wp_enqueue_script('jquery-matchHeight', get_template_directory_uri() . '/assets/lib/jquery-match-height/js/jquery.matchHeight.min.js', array('jquery'), '', true);
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/lib/wow/js/wow.min.js', array('jquery'), '', true);
    wp_enqueue_script('store-lite-custom-script', get_template_directory_uri() . '/assets/lib/twp/js/script.js', array('jquery'), '', 1);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_script( 'store-lite-ajax', get_template_directory_uri() . '/assets/lib/twp/js/ajax.js', array('jquery'), '', true );

    wp_localize_script( 
        'store-lite-ajax', 
        'store_lite_ajax',
        array(
            'ajax_url'   => esc_url( admin_url( 'admin-ajax.php' ) ),
            'loadmore'   => esc_html__( 'Load More', 'store-lite' ),
            'nomore'     => esc_html__( 'No More Posts', 'store-lite' ),
            'loading'    => esc_html__( 'Loading...', 'store-lite' ),
         )
    );

}

add_action('wp_enqueue_scripts', 'store_lite_scripts',100);

/**
 * Admin enqueue scripts and styles.
 */
function store_lite_admin_scripts()
{

    wp_enqueue_style('store-lite-admin', get_template_directory_uri() . '/assets/lib/twp/css/admin.css');
    // Enqueue Script Only On Widget Page.
    wp_enqueue_media();
    wp_enqueue_script('store-lite-custom-widgets', get_template_directory_uri() . '/assets/lib/twp/js/widget.js', array('jquery'), '1.0.0', true);

}

add_action('admin_enqueue_scripts', 'store_lite_admin_scripts');

/**
 * Customizer Enqueue scripts and styles.
 */
function store_lite_customizer_scripts()
{   
    wp_enqueue_script('jquery-ui-button');
    
    wp_enqueue_style('sifter', get_template_directory_uri() . '/assets/lib/twp/css/sifter.css');
    wp_enqueue_style('store-lite-customizer', get_template_directory_uri() . '/assets/lib/twp/css/customizer.css');
    wp_enqueue_script('store-lite-customizer', get_template_directory_uri() . '/assets/lib/twp/js/customizer.js', array('jquery','customize-controls'), '', 1);
    wp_enqueue_script('sifter', get_template_directory_uri() . '/assets/lib/twp/js/sifter.js', array('jquery','customize-controls'), '', 1);
    wp_enqueue_script('store-lite-repeater', get_template_directory_uri() . '/assets/lib/twp/js/repeater.js', array('jquery','customize-controls'), '', 1);
    wp_localize_script( 
        'store-lite-repeater', 
        'store_lite_repeater',
        array(
            'optionns'   =>  "<option value='slide-banner'>". esc_html__('Slide Banner Block','store-lite')."</option>
            <option value='product-category'>". esc_html__('Product Category Block','store-lite')."</option>
            <option value='tab-block-1'>". esc_html__('Tab Block 1','store-lite')."</option>
            <option value='carousel'>". esc_html__('Carousel Block','store-lite')."</option>
            <option value='tab-block-2'>". esc_html__('Tab Block 2','store-lite')."</option>
            <option value='cta'>". esc_html__('Call To Action','store-lite')."</option>
            <option value='best-deal-slide'>". esc_html__('Best Deal Slide','store-lite')."</option>
            <option value='latest-news'>". esc_html__('Latest News Block','store-lite')."</option>
            <option value='testimonial'>". esc_html__('Testimonial','store-lite')."</option>
            <option value='client'>". esc_html__('Client','store-lite')."</option>
            <option value='info'>". esc_html__('Info Block','store-lite')."</option>
            <option value='advertise-area'>". esc_html__('Advertisement Block','store-lite')."</option>",
             'new_section'   =>  esc_html__('New Section','store-lite'),
             'upload_image'   =>  esc_html__('Choose Image','store-lite'),
             'use_imahe'   =>  esc_html__('Select','store-lite'),
         )
    );
}

add_action('customize_controls_enqueue_scripts', 'store_lite_customizer_scripts');

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Custom Functions.
 */
require get_template_directory() . '/inc/custom-functions.php';

/**
 * Slider Functions.
 */
require get_template_directory() . '/inc/home/slider.php';

/**
 * Recommended Posts Functions.
 */
require get_template_directory() . '/inc/home/latest-news.php';

/**
 * Tab Block 1 Functions.
 */
require get_template_directory() . '/inc/home/tab-block-1.php';

/**
 * Tab Block 2 Functions.
 */
require get_template_directory() . '/inc/home/tab-block-2.php';

/**
 * Carousel Functions.
 */
require get_template_directory() . '/inc/home/carousel.php';

/**
 * Product Deal Functions.
 */
require get_template_directory() . '/inc/home/product-deal-slide.php';

/**
 * CTA Functions.
 */
require get_template_directory() . '/inc/home/cta.php';

/**
 * Testimonial Functions.
 */
require get_template_directory() . '/inc/home/testimonial.php';

/**
 * Product Category Functions.
 */
require get_template_directory() . '/inc/home/product-category.php';

/**
 * Client Functions.
 */
require get_template_directory() . '/inc/home/client.php';

/**
 * Slide Banner Block Functions.
 */
require get_template_directory() . '/inc/home/slide-banner.php';

/**
 * Slide Banner Block Functions.
 */
require get_template_directory() . '/inc/home/advertise.php';

/**
 * Subscribe Block Functions.
 */
require get_template_directory() . '/inc/home/subscribe.php';

/**
 * Info Block Functions.
 */
require get_template_directory() . '/inc/home/info.php';

/**
 * Header Product Category Functions.
 */
require get_template_directory() . '/inc/header-category.php';

/**
 * Bottom Header Functions.
 */
require get_template_directory() . '/inc/bottom-header.php';

/**
 * Recommended Posts Functions.
 */
require get_template_directory() . '/inc/ajax.php';

/**
 * Related Posts Functions.
 */
require get_template_directory() . '/inc/single/related-posts.php';

/**
 * Sidebar Metabox.
 */
require get_template_directory() . '/inc/single/sidebar-metabox.php';

/**
 * Image Metabox.
 */
require get_template_directory() . '/inc/single/image-ed-metabox.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer/customizer.php';

/**
 * Breadcrumb Trail
 */
require get_template_directory() . '/inc/breadcrumbs.php';

/**
* Megamenu Fields
**/
require get_template_directory() . '/inc/mega-menu/megamenu-custom-fields.php';

/**
* Frontend Fields
**/
require get_template_directory() . '/inc/mega-menu/walkernav.php';

/**
 * Widget Register
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * TGM Plugin Recommendation.
 */
require get_template_directory() . '/inc/tgmpa/recommended-plugins.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined('JETPACK__VERSION') ) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Woocommerce Plugin SUpport.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/advance-product-search.php';
    require get_template_directory() . '/inc/woocommerce.php';
    
    /**
    * Woocommerce Login Form
    **/
    require get_template_directory() . '/inc/woocommerce-login.php';
}

add_filter('wp_nav_menu_items', 'store_lite_add_admin_link', 1, 2);
function store_lite_add_admin_link($items, $args){
    if( $args->theme_location == 'twp-primary-menu' ){
        $item = '<li class="brand-home"><a title="Home" href="'. esc_url( home_url() ) .'">' . "<span class='icon ion-ios-home'></span>" . '</a></li>';
        $items = $item . $items;
    }
    return $items;
}
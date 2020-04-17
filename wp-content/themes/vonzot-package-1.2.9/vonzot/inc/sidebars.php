<?php
/**
 * Vonzot sidebars
 *
 * Register default sidebar for the theme with the vonzot_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage Vonzot
 * @since 1.0.0
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register blog and page sidebar and footer widget area.
 */
function vonzot_sidebars_init() {

	/* Blog Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Blog Sidebar', 'vonzot' ),
			'id'            		=> 'sidebar-main',
			'description'		=> esc_html__( 'Add widgets here to appear in your blog sidebar.', 'vonzot' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'  		=> '</div></aside>',
			'before_title' 	 	=> '<h3 class="widget-title">',
			'after_title'  	 	=> '</h3>',
		)
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		/* Page Sidebar */
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Page Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-page',
				'description'		=> esc_html__( 'Add widgets here to appear in your page sidebar.', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	if ( apply_filters( 'vonzot_allow_side_panel', true ) ) {
		/* Side Panel Sidebar */
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Side Panel Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-side-panel',
				'description'		=> esc_html__( 'Add widgets here to appear in your side panel if enabled.', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title' 	 	=> '<h3 class="widget-title">',
				'after_title'  	 	=> '</h3>',
			)
		);
	}

	/* Footer Sidebar */
	register_sidebar(
		array(
			'name'          		=> esc_html__( 'Footer Widget Area', 'vonzot' ),
			'id'            		=> 'sidebar-footer',
			'description'		=> esc_html__( 'Add widgets here to appear in your footer.', 'vonzot' ),
			'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
			'after_widget'		=> '</div></aside>',
			'before_title'  		=> '<h3 class="widget-title">',
			'after_title'   		=> '</h3>',
		)
	);

	/* Discography Siderbar */
	if ( class_exists( 'Wolf_Discography' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Discography Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-discography',
				'description'   		=> esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Videos Siderbar */
	if ( class_exists( 'Wolf_Videos' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Videos Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-videos',
				'description'   		=> esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Albums Siderbar */
	if ( class_exists( 'Wolf_Albums' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Albums Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-albums',
				'description'   		=> esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Photos Siderbar */
	if ( class_exists( 'Wolf_Photos' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Photo Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-attachment',
				'description'   		=> esc_html__( 'Appears before the image details on single photo pages', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Photo Sidebar Secondary', 'vonzot' ),
				'id'            		=> 'sidebar-attachment-secondary',
				'description'   		=> esc_html__( 'Appears after the image details on single photo pages', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Events Siderbar */
	if ( class_exists( 'Wolf_Events' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Events Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-events',
				'description'   		=> esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Events Siderbar */
	if ( class_exists( 'Mp_Time_Table' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Timetable Event Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-mp-event',
				'description'   		=> esc_html__( 'Appears on the single event pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);

		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Timetable Column Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-mp-column',
				'description'   		=> esc_html__( 'Appears on the single column pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Artists Siderbar */
	if ( class_exists( 'Wolf_Artists' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Artists Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-artists',
				'description'   		=> esc_html__( 'Appears on the artists pages if a layout with sidebar is set', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}

	/* Woocommerce Siderbar */
	if ( class_exists( 'Woocommerce' ) ) {
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Shop Sidebar', 'vonzot' ),
				'id'            		=> 'sidebar-shop',
				'description'   		=> esc_html__( 'Add widgets here to appear in your shop page if a sidebar is visible.', 'vonzot' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'vonzot_sidebars_init' );
<?php
/**
 * Product index Visual Composer template
 *
 * The arguments are passed to the vonzot_posts hook so we can do whatever we want with it
 *
 * @author WolfThemes
 * @category Core
 * @package %PACKAGENAME%/Templates
 * @version 1.2.9
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* retrieve shortcode attributes */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

$atts['post_type'] = 'product';

/* hook passing VC arguments */
do_action( 'vonzot_posts', $atts );
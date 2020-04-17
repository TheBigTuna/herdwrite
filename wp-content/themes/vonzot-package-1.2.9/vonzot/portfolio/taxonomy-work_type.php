<?php
/**
 * The portoflio taxonomy template file.
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">
			<?php
				/**
				 * Output post loop through hook so we can do the magic however we want
				 */
				do_action( 'vonzot_posts', array(
					'work_index' => true,
					'el_id' => 'portfolio-index',
					'post_type' => 'work',
					'pagination' => vonzot_get_theme_mod( 'work_pagination', '' ),
					'works_per_page' => vonzot_get_theme_mod( 'works_per_page', '' ),
					'grid_padding' => vonzot_get_theme_mod( 'work_grid_padding', 'yes' ),
					'item_animation' => vonzot_get_theme_mod( 'work_item_animation' ),
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'portfolio' );
get_footer();
?>
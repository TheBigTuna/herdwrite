<?php
/**
 * Template part for displaying mp events with the "grid" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

extract( wp_parse_args( $template_args, array(
	'overlay_color' => 'accent',
) ) );
?>
<article <?php vonzot_post_attr(); ?>>
	<div class="entry-container">
		<?php
		/**
		 * Hook: vonzot_before_mp_event_content_grid.
		 */
		do_action( 'vonzot_before_mp_event_content_grid', $template_args );

		/**
		 * Hook: vonzot_before_mp_event_content_grid_title.
		 *
		 * @hooked vonzot_output_mp_event_content_grid_category - 10
		 */
		do_action( 'vonzot_before_mp_event_content_grid_title', $template_args );

		/**
		 * Hook: vonzot_mp_event_content_grid_title.
		 *
		 * @hooked vonzot_output_mp_event_content_grid_title - 10
		 */
		do_action( 'vonzot_mp_event_content_grid_title', $template_args );

		/**
		 * Hook: vonzot_after_mp_event_content_grid_title.
		 *
		 * @hooked vonzot_output_mp_event_content_grid_excerpt - 10
		 */
		do_action( 'vonzot_after_mp_event_content_grid_title', $template_args );

		/**
		 * Hook: vonzot_after_mp_event_content_grid.
		 */
		do_action( 'vonzot_after_mp_event_content_grid', $template_args );
		?>
	</div>
</article><!-- #post-## -->
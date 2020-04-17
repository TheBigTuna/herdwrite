<?php
/**
 * Template part for displaying posts with the "grid" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

extract( wp_parse_args( $template_args, array(
	'display' => 'masonry',
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category',
) ) );

$post_display_elements = vonzot_list_to_array( $post_display_elements );
?>
<article <?php vonzot_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-box">
		<div class="entry-container">
			<?php
				/**
				 * Hook: vonzot_before_post_content_masonry.
				 *
				 * @hooked vonzot_output_post_content_masonry_sticky_label - 10
				 */
				do_action( 'vonzot_before_post_content_masonry', $post_display_elements, $display );

				/**
				 * Hook: vonzot_before_post_content_masonry_title.
				 *
				 * @hooked vonzot_output_post_content_masonry_media - 10
				 * @hooked vonzot_output_post_content_masonry_date - 10
				 */
				do_action( 'vonzot_before_post_content_masonry_title', $post_display_elements );

				/**
				 * Hook: vonzot_post_content_masonry_title.
				 *
				 * @hooked vonzot_output_post_content_masonry_title - 10
				 */
				do_action( 'vonzot_post_content_masonry_title', $post_display_elements, $display );

				/**
				 * Hook: vonzot_after_post_content_masonry_title.
				 *
				 * @hooked vonzot_output_post_content_masonry_excerpt - 10
				 */
				do_action( 'vonzot_after_post_content_masonry_title', $post_display_elements, $post_excerpt_type );

				/**
				 * Hook: vonzot_after_post_content_masonry.
				 *
				 * @hooked vonzot_output_post_content_masonry_meta - 10
				 */
				do_action( 'vonzot_after_post_content_masonry', $post_display_elements );
			?>
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->
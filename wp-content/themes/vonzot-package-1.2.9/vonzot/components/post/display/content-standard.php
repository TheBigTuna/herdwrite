<?php
/**
 * Template part for displaying posts with the "classic" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
if ( has_post_thumbnail() && ( vonzot_is_short_post_format() ) ) {
	$style = 'background-image:url(' . get_the_post_thumbnail_url( get_the_ID(), 'large' ) . ');';
}

extract( wp_parse_args( $template_args, array(
	'post_excerpt_type' => 'auto',
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category,show_extra_meta',
) ) );

$post_display_elements = vonzot_list_to_array( $post_display_elements );
?>
<article <?php vonzot_post_attr( 'post-excert-type-' . $post_excerpt_type ); ?>>
	<div class="entry-container">
		<?php
		/**
		 * Hook: vonzot_before_post_content_standard.
		 *
		 * @hooked vonzot_output_post_content_standard_sticky_label - 10
		 */
		do_action( 'vonzot_before_post_content_standard', $post_display_elements );

		/**
		 * Hook: vonzot_before_post_content_standard_title.
		 *
		 * @hooked vonzot_output_post_content_standard_media - 10
		 * @hooked vonzot_output_post_content_standard_date - 10
		 */
		do_action( 'vonzot_before_post_content_standard_title', $post_display_elements, $display );

		/**
		 * Hook: vonzot_post_content_standard_title.
		 *
		 * @hooked vonzot_output_post_content_standard_title - 10
		 */
		do_action( 'vonzot_post_content_standard_title', $post_display_elements, $display );

		/**
		 * Hook: vonzot_after_post_content_standard_title.
		 *
		 * @hooked vonzot_output_post_content_standard_excerpt - 10
		 */
		do_action( 'vonzot_after_post_content_standard_title', $post_display_elements, $post_excerpt_type );

		/**
		 * Hook: vonzot_after_post_content_standard.
		 *
		 * @hooked vonzot_output_post_content_standard_meta - 10
		 */
		do_action( 'vonzot_after_post_content_standard', $post_display_elements );
		?>
	</div>
</article><!-- #post-## -->
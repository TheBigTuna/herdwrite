<?php
/**
 * Template part for displaying related posts
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<article <?php vonzot_post_attr(); ?>>
	<?php
		/**
		 * Output related post content
		 */
		do_action( 'vonzot_related_post_content' );
	?>
</article><!-- #post-## -->
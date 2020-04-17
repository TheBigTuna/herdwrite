<?php
/**
 * Template part for displaying page content in page.php
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

/**
 * vonzot_post_content_start hook
 *
 * @see inc/fontend/hooks.php
 */
do_action( 'vonzot_post_content_start' );
?>
<div class="page-entry-content clearfix">
	<?php the_content(); ?>
	<?php wp_link_pages( array( 'before' => '<div class="clear"></div><div class="page-links clearfix"><span class="page-links-title">' . esc_html__( 'Pages:', 'vonzot' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
</div><!-- .page-entry-content -->

<footer class="entry-meta page-entry-meta">
	<?php edit_post_link( esc_html__( 'Edit', 'vonzot' ), '<span class="edit-link">', '</span>' ); ?>
</footer><!-- .entry-meta -->
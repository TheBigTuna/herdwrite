<?php
/**
 * Template part for displaying the content when no post is found
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div class="no-results not-found">
	<div class="entry-no-result wrap">
		<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( wp_kses_post( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'vonzot' ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php else : ?>

			<p><?php esc_html_e( 'Ouch. It seems we can&rsquo;t find what you&rsquo;re looking for.', 'vonzot' ); ?></p>

			<?php do_action( 'vonzot_no_result_end' ); ?>
		<?php endif; ?>
	</div><!-- .entry-container -->
</div><!-- #post-## -->
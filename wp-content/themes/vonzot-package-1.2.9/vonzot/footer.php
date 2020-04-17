<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing divs of the main content and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
						</div><!-- .content-wrapper -->
					</div><!-- .content-inner -->
					<?php
						/**
						 * vonzot_after_content
						 */
						do_action( 'vonzot_before_footer_block' );
					?>
				</div><!-- .site-content -->
			</div><!-- #main -->
		</div><!-- #page-content -->
		<div class="clear"></div>
		<?php
			/**
			 * vonzot_footer_before hook
			 */
			do_action( 'vonzot_footer_before' );
		?>
		<?php
			if ( 'hidden' !== vonzot_get_inherit_mod( 'footer_type' ) && is_active_sidebar( 'sidebar-footer' ) ) : ?>
			<footer id="colophon" class="<?php echo apply_filters( 'vonzot_site_footer_class', '' ); ?> site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="footer-inner clearfix">
					<?php get_sidebar( 'footer' ); ?>
				</div><!-- .footer-inner -->
			</footer><!-- footer#colophon .site-footer -->
		<?php endif; ?>
		<?php
			/**
			 * Fires the Vonzot bottom bar
			 */
			do_action( 'vonzot_bottom_bar' );
		?>
	</div><!-- #page .hfeed .site -->
</div><!-- .site-container -->
<?php
	/**
	 * Fires the Vonzot bottom bar
	 */
	do_action( 'vonzot_body_end' );
?>
<?php wp_footer(); ?>
</body>
</html>
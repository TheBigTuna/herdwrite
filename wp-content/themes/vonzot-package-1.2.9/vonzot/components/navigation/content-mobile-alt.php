<?php
/**
 * Displays mobile navigation
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div id="mobile-bar" class="nav-bar">
	<div class="flex-mobile-wrap">
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				vonzot_logo();
			?>
		</div><!-- .logo-container -->
		<div class="cta-container">
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'vonzot_secondary_menu', 'mobile' );
			?>
		</div><!-- .cta-container -->
		<div class="hamburger-container">
			<?php
				/**
				 * Menu hamburger icon
				 */
				vonzot_hamburger_icon( 'toggle-mobile-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
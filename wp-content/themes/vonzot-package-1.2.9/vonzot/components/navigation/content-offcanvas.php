<?php
/**
 * Displays offcanvas navigation type
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div id="nav-bar" class="nav-bar" data-menu-layout="offcanvas">
	<div class="flex-wrap">
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
				do_action( 'vonzot_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<div class="hamburger-container">
			<?php
				/**
				 * Menu hamburger icon
				 */
				vonzot_hamburger_icon( 'toggle-offcanvas-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
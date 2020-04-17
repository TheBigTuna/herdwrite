<?php
/**
 * Displays top center navigation type
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div class="logo-bar">
	<div class="logo-container">
		<?php
			/**
			 * Logo
			 */
			vonzot_logo();
		?>
	</div><!-- .logo-container -->
</div><!-- .logo-bar -->
<div id="nav-bar" class="nav-bar" data-menu-layout="top-center">
	<div class="flex-wrap">
		<?php
			if ( 'left' === vonzot_get_inherit_mod( 'side_panel_position' ) && vonzot_can_display_sidepanel() ) {
				/**
				 * Output sidepanel hamburger
				 */
				do_action( 'vonzot_sidepanel_hamburger' );
			}
		?>
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				vonzot_primary_desktop_navigation();
			?>
		</nav><!-- .menu-container -->
		<div class="cta-container">
			<?php
				/**
				 * Secondary menu hook
				 */
				do_action( 'vonzot_secondary_menu', 'desktop' );
			?>
		</div><!-- .cta-container -->
		<?php
			if ( 'right' === vonzot_get_inherit_mod( 'side_panel_position' ) && vonzot_can_display_sidepanel() ) {
				/**
				 * Output sidepanel hamburger
				 */
				do_action( 'vonzot_sidepanel_hamburger' );
			}
		?>
	</div><!-- .flex-wrap -->
</div><!-- #nav-bar -->
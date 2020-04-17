<?php
/**
 * Displays overlay navigation type
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div id="<?php echo apply_filters( 'vonzot_overlay_menu_nav_bar_id', 'nav-bar' ); ?>" class="nav-bar" data-menu-layout="overlay">
	<div class="flex-wrap">
		<?php
			if ( 'left' === vonzot_get_inherit_mod( 'side_panel_position' ) && vonzot_can_display_sidepanel() ) {
				?>
				<div class="hamburger-container hamburger-container-side-panel">
					<?php
						/**
						 * Menu hamburger icon
						 */
						vonzot_hamburger_icon( 'toggle-side-panel' );
					?>
				</div><!-- .hamburger-container -->
				<?php
			}
		?>
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
				vonzot_hamburger_icon( 'toggle-overlay-menu' );
			?>
		</div><!-- .hamburger-container -->
	</div><!-- .flex-wrap -->
</div><!-- #navbar-container -->
<div class="overlay-menu-panel">
	<?php
		/**
		 * overlay_menu_panel_start hook
		 */
		do_action( 'vonzot_overlay_menu_panel_start' );
	?>
	<div class="overlay-menu-table">
		<div class="overlay-menu-panel-inner">
			<div class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
				<?php
					/**
					 * Menu
					 */
					vonzot_primary_vertical_navigation();
				?>
			</div>
		</div><!-- .overlay-menu-panel-inner -->
	</div>
</div><!-- .overlay-menu-panel -->
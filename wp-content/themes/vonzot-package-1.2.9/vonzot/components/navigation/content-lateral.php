<?php
/**
 * Displays lateral navigation type
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<div class="lateral-menu-panel" data-menu-layout="lateral">
	<?php
		/**
		 * lateral_menu_panel_start hook
		 */
		do_action( 'vonzot_lateral_menu_panel_start' );
	?>
	<div class="lateral-menu-panel-inner">
		<div class="logo-container">
			<?php
				/**
				 * Logo
				 */
				vonzot_logo();
			?>
		</div><!-- .logo-container -->
		<nav class="menu-container" itemscope="itemscope"  itemtype="https://schema.org/SiteNavigationElement">
			<?php
				/**
				 * Menu
				 */
				vonzot_primary_vertical_navigation();
			?>
		</nav>
		<?php if ( vonzot_is_wvc_activated() )  : ?>
			<div class="lateral-menu-socials">
				<?php echo wvc_socials( array(
					'alignment' => 'left',
					//'size' => 'fa-1x',
					'services' => vonzot_get_inherit_mod( 'menu_socials', 'facebook,twitter,instagram' ), ) ); ?>
			</div><!-- .lateral-menu-socials -->
		<?php endif; ?>
	</div><!-- .lateral-menu-panel-inner -->
</div><!-- .lateral-menu-panel -->
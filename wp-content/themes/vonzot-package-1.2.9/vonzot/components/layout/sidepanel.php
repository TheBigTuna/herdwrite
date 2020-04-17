<?php
/**
 * Displays side panel
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
$sp_classes = apply_filters( 'vonzot_side_panel_class', '' );
?>
<div class="side-panel <?php echo vonzot_sanitize_html_classes( $sp_classes ) ?>">
	<div class="side-panel-inner">
		<?php
			/* Side Panel start hook */
			do_action( 'vonzot_sidepanel_start' );
		
			get_sidebar( 'side-panel' );
		?>
	</div><!-- .side-panel-inner -->
</div><!-- .side-panel -->
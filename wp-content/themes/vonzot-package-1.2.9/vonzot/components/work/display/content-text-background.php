<?php
/**
 * Template part for displaying posts with the "list" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
?>
<li <?php vonzot_post_attr(); ?>>
	<?php
		$style = '';

		if ( has_post_thumbnail() ) {
			$style = 'background-image:url(' . get_the_post_thumbnail_url( '', '%SLUG-XL%' ) . ')';
		}
	?>
	<h2 class="entry-title">
		<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
		<span class="entry-title-text-container">
			<span style="<?php echo vonzot_sanitize_style_attr( $style ); ?>" class="entry-title-text">
				<?php the_title(); ?>
			</span>
		</span>
	</h2>
</li>
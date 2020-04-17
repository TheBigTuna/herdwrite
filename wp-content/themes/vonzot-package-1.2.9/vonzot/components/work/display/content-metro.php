<?php
/**
 * Template part for displaying posts with the "metro" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
extract( wp_parse_args( $template_args, array(
	'layout' => '',
	'overlay_color' => 'auto',
	'overlay_custom_color' => '',
	'overlay_opacity' => 88,
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
) ) );
$text_style = '';

if ( function_exists( 'wvc_convert_color_class_to_hex_value' ) && $overlay_text_color && 'overlay' === $layout ) {
	$text_color = wvc_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . vonzot_sanitize_color( $text_color ) . ';';
	}
}

$dominant_color = vonzot_get_image_dominant_color( get_post_thumbnail_id() );
$actual_overlay_color = '';

if ( 'auto' === $overlay_color ) {

	$actual_overlay_color = $dominant_color;

} else {
	$actual_overlay_color = wvc_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . vonzot_get_color_tone( $actual_overlay_color );
$featured = get_post_meta( get_the_ID(), '_post_featured', true );
?>
<figure <?php vonzot_post_attr( array( $overlay_tone_class ) ); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="entry-image">
					<div class="entry-cover">
						<?php
							$metro_size = apply_filters( 'vonzot_metro_thumbnail_size', 'vonzot-photo' );

							if ( $featured || vonzot_is_latest_post( 'work' ) ) {
								$metro_size = 'large';
							}

							$size = ( vonzot_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $metro_size;

							echo vonzot_background_img( array( 'background_img_size' => $size, ) );
							remove_filter( 'vonzot_metro_thumbnail_size', 10, 1 );
						?>
					</div><!-- entry-cover -->
				</div>
				<div class="entry-inner">
					<div class="entry-inner-padding">
						<?php
							
							if ( $dominant_color && 'auto' === $overlay_color ) {
								$overlay_custom_color = $dominant_color;
							}

							/**
							 * Overlay
							 */
							echo vonzot_background_overlay( array(
								'overlay_color' => $overlay_color,
								'overlay_custom_color' => $overlay_custom_color,
								'overlay_opacity' => $overlay_opacity, )
							);
						?>
						<div style="<?php echo vonzot_esc_style_attr( $text_style ); ?>" class="entry-summary">
							<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo vonzot_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
							<div class="entry-taxonomy">
								<?php echo get_the_term_list( get_the_ID(), 'work_type', '', ' <span class="work-taxonomy-separator">/</span> ', '' ); ?>
							</div><!-- .entry-taxonomy -->
						</div><!--  .entry-summary  -->
					</div><!-- .entry-inner-padding -->
				</div><!-- .entry-inner -->
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</figure><!-- #post-## -->
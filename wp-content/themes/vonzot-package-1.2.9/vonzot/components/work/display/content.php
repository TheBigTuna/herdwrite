<?php
/**
 * Template part for displaying work posts common layout
 *
 * As all work posts share the same markup, we use this common template.
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
	'work_is_gallery' => '',
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

} elseif ( function_exists( 'wvc_convert_color_class_to_hex_value' ) ) {
	$actual_overlay_color = wvc_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . vonzot_get_color_tone( $actual_overlay_color );

$the_permalink = ( $work_is_gallery ) ? '#' : get_the_permalink();
$gallery_params = ( $work_is_gallery && function_exists( 'vonzot_get_gallery_params' ) ) ? vonzot_get_gallery_params() : '';
$link_class = ( $work_is_gallery ) ? 'gallery-quickview entry-link entry-link-mask' : 'entry-link entry-link-mask';
?>
<figure <?php vonzot_post_attr( array( $overlay_tone_class ) ); ?>>
	<div class="entry-box">
		<div class="entry-container">
			<a data-gallery-params="<?php echo esc_js( json_encode( $gallery_params ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $the_permalink ); ?>"></a>
			<div class="entry-image">
				<div class="entry-cover">
					<?php
						$size = ( vonzot_is_gif( get_post_thumbnail_id() ) ) ? 'full' : 'medium_large';
						echo vonzot_background_img( array( 'background_img_size' => $size, ) );
					?>
				</div><!-- .entry-cover -->
			</div><!-- .entry-image -->
			<div class="entry-inner">
				<a data-gallery-params="<?php echo esc_js( json_encode( $gallery_params ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $the_permalink ); ?>"></a>
				<div class="entry-inner-padding">
					<?php
						$dominant_color = vonzot_get_image_dominant_color( get_post_thumbnail_id() );

						if ( $dominant_color && 'auto' === $overlay_color ) {
							$overlay_custom_color = $dominant_color;
						}

						echo vonzot_background_overlay( array(
							'overlay_color' => $overlay_color,
							'overlay_custom_color' => $overlay_custom_color,
							'overlay_opacity' => $overlay_opacity, )
						);
					?>
					<div style="<?php echo vonzot_esc_style_attr( $text_style ); ?>" class="entry-summary">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo vonzot_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
						<div style="<?php echo vonzot_esc_style_attr( $text_style ); ?>" class="entry-taxonomy">
							<?php echo get_the_term_list( get_the_ID(), 'work_type', '', ' <span class="work-taxonomy-separator">/</span> ', '' ); ?>
						</div><!-- .entry-taxonomy -->
					</div><!--  .entry-summary -->
				</div><!-- .entry-inner-padding -->
			</div><!--  .entry-inner -->
		</div>
	</div><!-- .entry-container -->
</figure><!-- #post-## -->
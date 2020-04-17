<?php
/**
 * Template part for displaying the post metro layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */
extract( wp_parse_args( $template_args, array(
	'post_excerpt_length' => 'shorten',
	'post_display_elements' => 'show_thumbnail,show_date,show_category',
) ) );

$post_display_elements = vonzot_list_to_array( $post_display_elements );
$show_thumbnail = ( in_array( 'show_thumbnail', $post_display_elements ) );
$show_date = ( in_array( 'show_date', $post_display_elements ) );
$show_text = ( in_array( 'show_text', $post_display_elements ) );
$show_author = ( in_array( 'show_author', $post_display_elements ) );
$show_category = ( in_array( 'show_category', $post_display_elements ) );
$show_tags = ( in_array( 'show_tags', $post_display_elements ) );
$show_extra_meta = ( in_array( 'show_extra_meta', $post_display_elements ) );

$featured = get_post_meta( get_the_ID(), '_post_featured', true );
?>
<article <?php vonzot_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="entry-image">
					<div class="entry-cover">
						<?php
							$metro_size = apply_filters( 'vonzot_metro_thumbnail_size', 'vonzot-photo' );

							if ( $featured || vonzot_is_latest_post() || 'image' === get_post_format() ) {
								$metro_size = 'large';
							}

							$size = ( vonzot_is_gif( get_post_thumbnail_id() ) ) ? 'full' : $metro_size;
							echo vonzot_background_img( array( 'background_img_size' => $size, ) );
						?>
					</div><!-- entry-cover -->
					<div class="entry-post-metro-overlay"></div>
				</div>
				<div class="entry-inner">
					<?php if ( $show_category ) : ?>
						<a class="category-label" href="<?php echo vonzot_get_first_category_url(); ?>"><?php echo vonzot_get_first_category(); ?></a>
					<?php endif; ?>
					<?php
						if ( is_sticky() && ! is_paged() ) {
							echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'vonzot' ) ) . '"></span>';
						}
					?>
					<div class="entry-summary">
						<div class="entry-summary-inner">
							<?php if ( $show_date ) : ?>
								<span class="entry-date">
									<?php vonzot_entry_date(); ?>
								</span>
							<?php endif; ?>
							<h2 class="entry-title">
								<?php the_title(); ?>
							</h2>
							<?php if ( $show_text ) : ?>
								<div class="entry-excerpt">
									<?php echo vonzot_sample( get_the_excerpt(), 5 ); ?>
								</div><!-- .entry-excerpt -->
							<?php endif; ?>
							<?php if ( $show_author || $show_tags || $show_extra_meta || vonzot_edit_post_link( false ) ) : ?>
								<div class="entry-meta">
									<?php if ( $show_author ) : ?>
										<?php vonzot_get_author_avatar(); ?>
									<?php endif; ?>
									<?php if ( $show_tags ) : ?>
										<?php vonzot_entry_tags(); ?>
									<?php endif; ?>
									<?php if ( $show_extra_meta ) : ?>
										<?php vonzot_get_extra_meta(); ?>
									<?php endif; ?>
									<?php vonzot_edit_post_link(); ?>
								</div><!-- .entry-meta -->
							<?php endif; ?>
						</div><!-- .entry-summary-inner -->
					</div><!--  .entry-summary  -->
				</div>
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->
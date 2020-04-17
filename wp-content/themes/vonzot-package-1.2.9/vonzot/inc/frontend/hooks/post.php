<?php
/**
 * Vonzot post hook functions
 *
 * @package WordPress
 * @subpackage Vonzot
 * @version 1.2.9
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'vonzot_single_header_post_meta' ) ) {
/**
 * Header post meta
 */
function vonzot_single_header_post_meta() {

	global $post, $wp_query;
	$post_id = get_the_ID();
	$output = '';
	$desc = '';
	$subheading = vonzot_get_the_subheading();
	if ( vonzot_is_home_as_blog() ) {
		$desc = '';
	}

	/* Search result count */
	if ( is_search() ) {

		global $wp_query;
		
		if ( $wp_query && is_object( $wp_query ) && isset( $wp_query->found_posts ) ) {
			$subheading = sprintf(
				/* translators: 1: number of comments, 2: post title */
				_n(
					'%d result',
					'%d results',
					'vonzot'
				),
				$wp_query->found_posts
			);
		}
	}
	if ( is_tax() ) {
		
		$queried_object = get_queried_object();

		if ( is_object( $queried_object ) && isset( $queried_object->name ) ) {
			$desc = get_queried_object()->description;
		}
	}

	if ( is_category() ) {
		$cat_id = get_the_category();
		$desc = category_description( $cat_id[0] );
	}

	if ( $desc ) {
		$output .= '<div class="description">' . sanitize_text_field( apply_filters( 'vonzot_post_description', $desc ) ) . '</div><!--.description-->';
	}

	if ( $subheading ) {
		$output .= '<div class="subheading">' . sanitize_text_field( apply_filters( 'vonzot_post_subheading', $subheading ) ) . '</div>';
	}

	if ( is_singular( 'post' ) ) {

		if ( 'human_diff' === vonzot_get_theme_mod( 'date_format' ) ) {
			$output .= sprintf( esc_html__( 'Posted %s', 'vonzot' ), vonzot_entry_date( false ) );
		} else {
			$output .= sprintf( esc_html__( 'Posted On %s', 'vonzot' ), vonzot_entry_date( false ) );
		}
		

		if ( vonzot_get_first_category() ) {
			$output .= '<span class="post-meta-separator"></span>';

			$output .= sprintf( wp_kses_post( __( 'In <a href="%s" title="View all posts in the %s category">%s</a>', 'vonzot' ) ),
				vonzot_get_first_category_url(),
				vonzot_get_first_category(),
				vonzot_get_first_category()
			);
		}

		if ( is_multi_author() && get_the_author() ) {
			$output .= '<span class="post-meta-separator"></span>';

			$output .= '<span class="author-meta">';

			$output .= sprintf(
				'<span id="post-title-author">by <span class="author vcard">
				<a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span></span>',
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
				esc_attr( sprintf( __( 'View all posts by %s', 'vonzot' ), get_the_author() ) ),
				get_the_author()
			);
			$output .= '</span>';
		}

	} // end if post

	elseif ( is_singular( 'work' ) ) {

		$output .= get_the_term_list( $post_id, 'work_type', esc_html__( 'In', 'vonzot' ) . ' ', esc_html__( ', ', 'vonzot' ), '' );

	} elseif ( is_singular( 'gallery' ) ) {

		$term_list = get_the_term_list( $post_id, 'gallery_type', esc_html__( 'In', 'vonzot' ) . ' ', esc_html__( ', ', 'vonzot' ), '' );

		$output .= $term_list;

		if ( $term_list ) {
			$output .= '<span class="post-meta-separator"></span>';
		}

		$output .= sprintf( __( '<a class="scroll link" href="#content">%d Photos</a>', 'vonzot' ),
			vonzot_get_first_gallery_image_count()
		);

	} elseif ( is_singular( 'product' ) ) {

		$output .= get_the_term_list(
			$post_id,
			'product_cat',
			esc_html__( 'In', 'vonzot' ) . ' ',
			esc_html__( ', ', 'vonzot' )
		);

	}

	echo vonzot_kses( $output );
}
add_action( 'vonzot_hero_meta', 'vonzot_single_header_post_meta' );
} // end function check

/**
 * Add custom post meta above and below the post content
 */
function vonzot_add_custom_post_meta() {
	if ( is_singular( 'post' ) ) {
		if ( ! vonzot_is_vc() || 'wvc-single-post-sidebar' === vonzot_get_single_post_wvc_layout() ) {
			vonzot_get_extra_meta();
		}
	}
}
add_action( 'vonzot_post_content_start', 'vonzot_add_custom_post_meta' );

/**
 * Add share buttons above and below the post content
 */
function vonzot_add_share_buttons() {
	
	if ( function_exists( 'wolf_share' ) && function_exists( 'wolf_share_get_option' ) ) {

		$enabled_post_types = ( wolf_share_get_option( 'post_types' ) ) ? wolf_share_get_option( 'post_types' ) : array();
		$current_post_type = get_post_type();

		if ( isset( $enabled_post_types[ $current_post_type ] ) ) {

			if ( is_singular( 'product' ) ) {
				echo '<hr>';
			}

			wp_enqueue_style( 'socicon' );
			
			wolf_share();
		}
	}
}
add_action( 'vonzot_share', 'vonzot_add_share_buttons' );
add_action( 'vonzot_post_content_end', 'vonzot_add_share_buttons', 15 );
add_action( 'vonzot_work_meta', 'vonzot_add_share_buttons', 15 ); // display in single work
add_action( 'woocommerce_share', 'vonzot_add_share_buttons' ); // display in single product
add_action( 'wpm_playlist_post_end', 'vonzot_add_share_buttons' ); // display in single playlist

/**
 * Output author box
 */
function vonzot_output_author_box() {

	if ( 'yes' === vonzot_get_theme_mod( 'post_author_box', 'yes' ) ) {
		if ( 'post' === get_post_type() ) {
			get_template_part( 'components/post/author' );
		}
	}
}
add_action( 'vonzot_post_content_after', 'vonzot_output_author_box' );

/**
 * Output related posts
 */
function vonzot_output_related_posts() {

	if ( 'yes' === vonzot_get_theme_mod( 'post_related_posts', 'yes' ) ) {
		if ( 'post' === get_post_type() ) {
			get_template_part( 'components/post/related', 'posts' );
		}
	}
}
add_action( 'vonzot_post_content_after', 'vonzot_output_related_posts', 20 );

/**
 * Output related posts
 */
function vonzot_output_related_post_content() {
	?>
	<div class="entry-box">
		<div class="entry-container">
			<a href="<?php the_permalink() ?>" class="entry-link">
				<?php the_post_thumbnail( apply_filters( 'vonzot_related_post_thumbnail_size', 'medium_large' ), array( 'class' => 'entry-bg cover' ) ); ?>
				<div class="entry-overlay"></div>
				<div class="entry-inner">
					<div class="entry-summary">
						<?php the_title( '<h4 class="entry-title">', '</h4>' ); ?>
						<span class="entry-date">
							<?php vonzot_entry_date(); ?>
						</span>
					</div><!-- .entry-summary -->
				</div><!-- .entry-inner -->
			</a>
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
	<?php
}
add_action( 'vonzot_related_post_content', 'vonzot_output_related_post_content' );

/**
 * Remove share buttons filter
 *
 * This is will allow more control for where we want to output the share buttons
 */
function vonzot_remove_share_buttons_filter() {
	remove_filter( 'the_content', 'wolf_share_output_social_buttons' );
}
add_action( 'init', 'vonzot_remove_share_buttons_filter' );

/**
 * Remove custom post meta filter
 *
 * This is will allow more control for where we want to output the share buttons
 */
function vonzot_remove_custom_post_meta_filter() {
	remove_filter( 'the_content', 'wolf_output_custom_post_meta' );
}
add_action( 'init', 'vonzot_remove_custom_post_meta_filter' );

/**
 * Newsletter form
 */
function vonzot_add_newsletter_form() {

	if (
		function_exists( 'wvc_mailchimp' )
		&& vonzot_get_theme_mod( 'newsletter_form_single_blog_post' )
		&& is_singular( 'post' )
	)
	{
		$list_id = wolf_vc_get_option( 'mailchimp', 'default_mailchimp_list_id' );
		?>
		<section class="newsletter-container entry-section clearfix">
			<div class="newsletter-signup">
				<?php echo wvc_mailchimp( array( 'size' => 'large', 'submit_button_class' => 'theme-button-outline', ) ); ?>
			</div><!-- .newsletter-signup -->
		</section><!-- .newsletter-container -->
		<?php
	}
}
add_action( 'vonzot_post_content_after', 'vonzot_add_newsletter_form' );

/**
 * Output single post pagination
 */
function vonzot_output_single_post_pagination() {

	if ( is_singular( 'event' ) || is_singular( 'proof_gallery' ) || is_singular( 'attachment' ) ) {
		return; // event are ordered by custom date so it's better to hide the pagination
	}

	if ( apply_filters( 'vonzot_disable_single_post_pagination', false ) ) {
		return;
	}

	global $post;
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous || ! is_single() || 'wvc_content_block' === get_post_type() ) {
		return;
	}

	$index_url = vonzot_get_blog_url();
	$index_id = vonzot_get_blog_index_id();

	if ( 'work' === get_post_type() && function_exists( 'wolf_portfolio_get_page_id' ) && function_exists( 'wolf_get_portfolio_url' ) ) {
		$index_id = wolf_portfolio_get_page_id();
		$index_url = wolf_get_portfolio_url();
	}

	if ( 'gallery' === get_post_type() && function_exists( 'wolf_albums_get_page_id' ) && function_exists( 'wolf_get_albums_url' ) ) {
		$index_id = wolf_albums_get_page_id();
		$index_url = wolf_get_albums_url();
	}

	if ( 'video' === get_post_type() && function_exists( 'wolf_videos_get_page_id' ) && function_exists( 'wolf_get_videos_url' ) ) {
		$index_id = wolf_videos_get_page_id();
		$index_url = wolf_get_videos_url();
	}

	if ( 'event' === get_post_type() && function_exists( 'wolf_events_get_page_id' ) && function_exists( 'wolf_get_events_url' ) ) {
		$index_id = wolf_events_get_page_id();
		$index_url = wolf_get_events_url();
	}

	if ( 'release' === get_post_type() && function_exists( 'wolf_discography_get_page_id' ) && function_exists( 'wolf_discography_get_page_link' ) ) {
		$index_id = wolf_discography_get_page_id();
		$index_url = wolf_discography_get_page_link();
	}

	if ( 'product' === get_post_type() && function_exists( 'vonzot_get_woocommerce_shop_page_id' ) ) {
		$index_id = vonzot_get_woocommerce_shop_page_id();
		$index_url = get_permalink( vonzot_get_woocommerce_shop_page_id() );
	}

	$prev_post = get_previous_post();
	$next_post = get_next_post();

	$prev_post_id = ( is_object( $prev_post ) && isset( $prev_post->ID ) ) ? $prev_post->ID : null;
	$next_post_id = ( is_object( $next_post ) && isset( $next_post->ID ) ) ? $next_post->ID : null;

	$index_post_featured_img_id = ( $index_id && get_post_thumbnail_id( $index_id ) ) ? get_post_thumbnail_id( $index_id ) : vonzot_get_hero_image_id();
	$prev_post_featured_img_id = ( $prev_post_id ) ? get_post_thumbnail_id( $prev_post_id ) : null;
	$next_post_featured_img_id = ( $next_post_id ) ? get_post_thumbnail_id( $next_post_id ) : null;

	$index_class = 'nav-index';
	$prev_class = 'nav-previous';
	$next_class = 'nav-next';

	if ( apply_filters( 'vonzot_enable_single_post_pagination_backgrounds', true ) ) {
		if ( $index_post_featured_img_id && vonzot_background_img( array( 'background_img' => $index_post_featured_img_id ) ) ) {
			$index_class .= ' nav-has-bg';
		}

		if ( $prev_post_featured_img_id && vonzot_background_img( array( 'background_img' => $prev_post_featured_img_id ) ) ) {
			$prev_class .= ' nav-has-bg';
		}

		if ( $next_post_featured_img_id && vonzot_background_img( array( 'background_img' => $next_post_featured_img_id ) ) ) {
			$next_class .= ' nav-has-bg';
		}
	}
	?>
	<nav class="single-post-pagination clearfix">
		<div class="<?php echo vonzot_sanitize_html_classes( $prev_class ); ?>">
			<?php
				if ( apply_filters( 'vonzot_enable_single_post_pagination_backgrounds', true ) ) {
				/**
				 * BG
				 */
					echo vonzot_background_img( array( 'background_img' => $prev_post_featured_img_id ) );
				}
			?>
			<?php previous_post_link( '%link', '<span class="nav-label"><i class="meta-icon single-pagination-prev" aria-hidden="true"></i> ' . esc_html__( 'Previous', 'vonzot' ) . '</span><span class="meta-nav"></span> %title' ); ?>
		</div><!-- .nav-previous -->
		<div class="<?php echo vonzot_sanitize_html_classes( $index_class ); ?>">
			<?php
				if ( apply_filters( 'vonzot_enable_single_post_pagination_backgrounds', true ) ) {
					/**
					 * BG
					 */
					echo vonzot_background_img( array( 'background_img' => $index_post_featured_img_id ) );
				}
			?>
			<a href="<?php echo esc_url( $index_url ); ?>">
				<!-- <i class="fa fa-th-large" aria-hidden="true"></i> -->
				<span class="nav-index-icon"> <?php esc_html_e( 'Main Page', 'vonzot' ); ?></span>
			</a>
		</div>
		<div class="<?php echo vonzot_sanitize_html_classes( $next_class ); ?>">
			<?php
				if ( apply_filters( 'vonzot_enable_single_post_pagination_backgrounds', true ) ) {
					/**
					 * BG
					 */
					echo vonzot_background_img( array( 'background_img' => $next_post_featured_img_id ) );
				}
			?>
			<?php next_post_link( '%link', '<span class="nav-label">' . esc_html__( 'Next', 'vonzot' ) . ' <i class="meta-icon single-pagination-next" aria-hidden="true"></i></span> %title <span class="meta-nav"></span>' ); ?>
		</div><!-- .nav-next -->
	</nav><!-- .single-post-pagination -->
	<?php
}
add_action( 'vonzot_before_footer_block', 'vonzot_output_single_post_pagination', 14 );

/**
 * Output categories & tags below single post content
 */
function vonzot_ouput_single_post_taxonomy() {

	if ( 'post' !== get_post_type() ) {
		return;
	}

	echo '<div class="single-post-taxonomy-container clearfix">';
		echo '<span class="single-post-taxonomy categories single-post-categories">';
			the_category( ' ' );
		echo '</span>';
		the_tags( '<span class="single-post-taxonomy tagcloud single-post-tagcloud">', '', '</span>' );
	echo '</div><!-- .single-post-taxonomy -->';

}
add_action( 'vonzot_post_content_end', 'vonzot_ouput_single_post_taxonomy' );

/**
 * Output modern grid slideshow arrows
 */
function vonzot_output_post_grid_slideshow_arrows() {
	?>
	<div class="slideshow-gallery-direction-nav">
		<a href="#" class="slideshow-gallery-direction-nav-prev">
			<span class="slideshow-gallery-direction-nav-prev-icon"></span>
		</a>
		<a href="#" class="slideshow-gallery-direction-nav-next">
			<span class="slideshow-gallery-direction-nav-next-icon"></span>
		</a>
	</div>
	<?php
}
add_action( 'vonzot_post_grid_slideshow_arrows', 'vonzot_output_post_grid_slideshow_arrows' );

/**
 * Add custom post meta above and below the post content
 */
function vonzot_add_vc_post_custom_post_meta() {
	if ( is_singular( 'post' ) ) {
		if ( 'wvc-single-post-fullwidth' === vonzot_get_single_post_wvc_layout() ) {
			vonzot_get_extra_meta();
		}
	}
}
add_action( 'vonzot_post_content_end', 'vonzot_add_vc_post_custom_post_meta' );

/**
 * Output single post bottom separator
 */
function vonzot_ouput_single_post_end_separator() {

	echo '<hr class="single-post-bottom-line">';

}
add_action( 'vonzot_post_content_end', 'vonzot_ouput_single_post_end_separator', 100 );

/**
 * Output work single post meta
 */
function vonzot_ouput_work_meta() {
	/**
	 * Work meta
	 */
	if ( function_exists( 'vonzot_work_meta' ) ) {
		vonzot_work_meta();
	}

}
add_action( 'vonzot_work_meta', 'vonzot_ouput_work_meta' );

/**
 * Output release single post meta
 */
function vonzot_ouput_release_meta() {
	/**
	 * Release meta
	 */
	if ( function_exists( 'vonzot_release_meta' ) ) {
		vonzot_release_meta();
	}

}
add_action( 'vonzot_release_meta', 'vonzot_ouput_release_meta' );

/**
 * Output artist single post meta
 */
function vonzot_ouput_artist_meta() {
	/**
	 * artist meta
	 */
	if ( function_exists( 'vonzot_artist_meta' ) ) {
		vonzot_artist_meta();
	}

}
add_action( 'vonzot_artist_meta', 'vonzot_ouput_artist_meta' );

/**
 * Output artist single post content
 */
function vonzot_ouput_artist_content() {
	/**
	 * artist content
	 */
	if ( function_exists( 'vonzot_artist_content' ) ) {
		vonzot_artist_content();
	}

}
add_action( 'vonzot_artist_content', 'vonzot_ouput_artist_content' );

/**
 * Output post grid summary
 */
function vonzot_output_post_grid_summary() {

	$format = get_post_format();

	if ( vonzot_is_short_post_format() || 'audio' === $format ) {
		?>
		<div class="entry-image">
			<div class="entry-cover">
				<?php
					echo vonzot_background_img( array(
						'background_img_size' => 'large',
						'placeholder_fallback' => true,
					) );
				?>
			</div><!-- entry-cover -->
		</div>
		<?php
	}

	if ( 'image' === $format && vonzot_is_instagram_post()  ) {
					
		echo vonzot_get_instagram_image();

		if ( vonzot_get_author_instagram_username() ) {
			echo '<span class="insta-username">' . vonzot_get_author_instagram_username() . '</span>';
		}

	} elseif ( 'gallery' === $format && vonzot_background_slideshow() ) {

		echo vonzot_background_slideshow( array(
			'slideshow_image_size' => 'vonzot-large',
			'slideshow_img_count' => 3,
		) );

		do_action( 'vonzot_post_grid_slideshow_arrows' );

		vonzot_post_grid_entry_title();

	} elseif ( 'video' === $format ) {

		if ( vonzot_background_video() ) { // if we can get a video background
			echo vonzot_background_video();
		}
		vonzot_post_grid_entry_title();

	} elseif ( 'audio' === $format && vonzot_featured_media() ) {

		vonzot_post_grid_entry_title();

	} elseif ( 'aside' === $format || 'status' === $format ) {

		vonzot_post_grid_entry_title( vonzot_sample( get_the_content(), 30 ) );

	} elseif ( 'quote' === $format ) {

		vonzot_post_grid_entry_title( vonzot_get_first_quote() );

	} elseif ( 'link' === $format ) {
		
		vonzot_post_grid_entry_title();
	
	} else { // most likely standard format
	?>
	<div class="entry-image">
		<div class="entry-cover">
			<?php
				echo vonzot_background_img( array(
					'background_img_size' => 'large',
					'placeholder_fallback' => true,
				) );
			?>
		</div><!-- entry-cover -->
	</div>
	<?php vonzot_post_grid_entry_title(); ?>
<?php }
}
add_action( 'vonzot_post_grid_summary', 'vonzot_output_post_grid_summary' );

/**
 * Post Grid classic excerpt
 */
function vonzot_output_post_grid_classic_excerpt( $post_excerpt_length ) {

	if ( 'full' === $post_excerpt_length ) : ?>
		<p><?php echo vonzot_sample( get_the_excerpt(), 1000 ); ?></p>
	<?php else : ?>
		<p><?php echo vonzot_sample( get_the_excerpt(), vonzot_get_excerpt_lenght() ); ?></p>
	<?php endif;
}
add_action( 'vonzot_post_grid_classic_excerpt', 'vonzot_output_post_grid_classic_excerpt', 10, 1 );
add_action( 'vonzot_post_grid_excerpt', 'vonzot_output_post_grid_classic_excerpt', 10, 1 );

/**
 * Post Grid classic excerpt
 */
function vonzot_output_post_masonry_excerpt( $post_excerpt_length ) {

	if ( 'full' === $post_excerpt_length ) : ?>
		<p><?php echo vonzot_sample( get_the_excerpt(), 1000 ); ?></p>
	<?php elseif ( is_numeric( $post_excerpt_length ) ) : ?>
		<p><?php echo vonzot_sample( get_the_excerpt(), absint( $post_excerpt_length ) ); ?></p>
	<?php else : ?>
		<p><?php echo vonzot_sample( get_the_excerpt(), vonzot_get_excerpt_lenght() ); ?></p>
	<?php endif;
}
add_action( 'vonzot_post_masonry_excerpt', 'vonzot_output_post_masonry_excerpt', 10, 1 );
add_action( 'vonzot_post_metro_excerpt', 'vonzot_output_post_masonry_excerpt', 10, 1 );
add_action( 'vonzot_post_search_excerpt', 'vonzot_output_post_masonry_excerpt', 10,1  );

/**
 * Output the excerpt
 *
 * @param string $post_excerpt_type
 */
function vonzot_output_the_excerpt( $post_excerpt_type ) {
	
	/* Case page builder is used */
	if ( preg_match( '#vc_row#', get_the_content() ) ) {

		$content = ( get_the_excerpt() ) ? get_the_excerpt() : get_the_content();
		echo '<p>' . vonzot_sample( $content, 100 ) . '...</p>';

		if ( $content ) {
			echo '<p>' . vonzot_more_button() . '</p>';
		}
			
	} else {

		if ( 'auto' === $post_excerpt_type ) {

			echo '<p>';
			echo( get_the_excerpt() );
			echo '</p>';

		} else {
			echo vonzot_content( vonzot_more_text() );
		}
	}
}
add_action( 'vonzot_the_excerpt', 'vonzot_output_the_excerpt', 10, 1 );
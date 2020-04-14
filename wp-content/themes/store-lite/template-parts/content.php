<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Store_Lite
 */
?>

<article id="post-<?php the_ID(); ?>"  <?php if( is_archive() || is_home() ){  ?> <?php post_class('wow fadeInUp'); ?> data-wow-delay="0.3s" <?php }else{ post_class(); } ?>>

	<?php if( is_archive() || is_home() ){ ?>
		<div class="article-wrapper">
	<?php } ?>
		
		<?php if( is_archive() || is_home() ){ store_lite_post_thumbnail(); } ?>

		<div class="article-details">
			
			<?php if( is_archive() || is_home() ) : ?>

				<header class="entry-header">

					<?php

					if ( 'post' === get_post_type() ){
	                    echo '<div class="entry-meta entry-meta-category">';
	                    store_lite_entry_footer( $cats = true,$tags = false );
	                    echo '</div>';
	                }

					the_title( '<h2 class="entry-title entry-title-medium"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

					<div class="entry-meta">
                        <?php
                        store_lite_posted_by();
                        echo "<span class='sep-date-author'><i class='ion ion-ios-remove'></i></span>";
                        store_lite_posted_on();
                        ?>
                    </div><!-- .entry-meta -->

				</header><!-- .entry-header -->

			<?php endif; ?>

			<div class="entry-content">
				<?php
				if( is_single() ):

					the_content();

				else:

					if( has_excerpt() ){
						
						the_excerpt();

					}else{

						echo esc_html( wp_trim_words( get_the_content(),30,'...' ) );

					}

				endif;

				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'store-lite' ),
					'after'  => '</div>',
				) );
				?>
			</div><!-- .entry-content -->

			<?php
				if( is_single() ){
					$tags = true;
				}else{
					$tags = false;
				}
			?>
			<footer class="entry-footer">
				<?php store_lite_entry_footer( $cats = false,$tags ); ?>
			</footer><!-- .entry-footer -->

		</div>

	<?php if( is_archive() || is_home() ){ ?>
		</div>
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->
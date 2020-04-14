<?php
/**
* Related Posts Functions.
*
* @package Store Lite
*/

if( !function_exists('store_lite_related_posts') ):

	// Single Posts Related Posts.
	function store_lite_related_posts(){
		global $post;

		$default = store_lite_get_default_theme_options();

		$cats = get_the_category( $post->ID );
		$category = array();
        if( $cats ){
            foreach( $cats as $cat ){
                $category[] = $cat->term_id; 
            }
        }

        $related_posts_query = new WP_Query( array( 'post_type' => 'post', 'posts_per_page' => 6, 'post__not_in' => array( $post->ID ), 'category__in' => $category ) );

		$ed_related_post = absint( get_theme_mod( 'ed_related_post',$default['ed_related_post'] ) );
		if( $ed_related_post && $related_posts_query->have_posts() ): ?>

			<div class="site-related twp-blocks">
			    <div class="wrapper">
			        <div class="twp-row">

			        	<?php $related_post_title = esc_html( get_theme_mod( 'related_post_title',$default['related_post_title'] ) ); 
			        	if( $related_post_title ){ ?>
				            <div class="column column-two column-full-sm">
				                <header class="block-title-wrapper">
				                    <h2 class="block-title">
				                        <?php echo esc_html( $related_post_title ); ?> <i class="ion ion-md-arrow-dropright"></i>
				                    </h2>
				                </header>
				            </div>
				        <?php } ?>

			            <div class="column column-eight column-full-sm">
			                <div class="twp-row">
			                	<?php while( $related_posts_query->have_posts() ):
			                		$related_posts_query->the_post(); 
			                		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium' );?>

				                    <div class="column column-five">
				                        <article class="related-items" data-mh="related-post">

				                            <div class="post-thumb">
				                                <a href="<?php the_permalink(); ?>" class="data-bg data-bg-small" data-background="<?php echo esc_url( $featured_image[0] ); ?>"></a>
				                            </div>

				                            <div class="post-content">
				                                <h3 class="entry-title entry-title-small">
				                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
				                                </h3>
                                                <div class="entry-meta entry-meta-1">
                                                    <span class="posted-on">
                                                        <?php the_time('j M Y'); ?>
                                                    </span>
                                                </div>
				                            </div>
				                            
				                        </article>
				                    </div>
				                <?php endwhile; ?>
			                </div>
			            </div>

			        </div>
			    </div>
			</div>

		<?php
		wp_reset_postdata();
		endif;
	}

endif;
<?php
/**
* Recommended Posts Function.
*
* @package Store Lite
*/

if( !function_exists('store_lite_latest_posts') ):

	// Recommended Posts Functions.
	function store_lite_latest_posts( $store_lite_home_section,$repeat_times ){

		$recommended_post_title = isset( $store_lite_home_section->section_title ) ? $store_lite_home_section->section_title : '' ;
		$section_desc = isset( $store_lite_home_section->section_desc ) ? $store_lite_home_section->section_desc : '' ;
		$recommended_post_category = isset( $store_lite_home_section->post_category ) ? $store_lite_home_section->post_category : '' ;

        global $paged;
		$paged = ( get_query_var( 'page' ) ) ? absint( get_query_var( 'page' ) ) : 1;
        $recommended_post_query = new WP_Query( array( 'post_type' => 'post','posts_per_page' => 3, 'category_name' => esc_html( $recommended_post_category ), 'paged'=>$paged,'post__not_in' => get_option("sticky_posts") ) );

        if ( $recommended_post_query->have_posts() ): ?>

        	<div class="twp-blocks twp-blocks-bg site-latest-news twp-latest-post-<?php echo esc_attr( $repeat_times ); ?>">
			    <div class="container">
			        <?php
			        if( $recommended_post_title ){ ?>
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <header class="block-title-header-2">
                                    <div class="block-title-wrapper">
                                        
                                        <h2 class="block-title">
                                            <?php echo esc_html( $recommended_post_title ); ?>
                                        </h2>

                                        <?php if( $section_desc ){ ?>
	                                        <div class="block-subtitle">
	                                            <?php echo esc_html( $section_desc ); ?>
	                                        </div>
	                                    <?php } ?>

                                    </div>
                                </header>
                            </div>
                        </div>
				    <?php } ?>

			        <div class="row latest-blog-wrapper">
			        	<?php while( $recommended_post_query->have_posts() ):
			        		$recommended_post_query->the_post();

			        		$format = get_post_format( get_the_ID() ) ? : 'standard';
                            $icon = store_lite_post_formate_icon( $format );
                            $featured_image = wp_get_attachment_image_src( get_post_thumbnail_id(),'medium_large' ); ?>

				            <div class="col-md-4 col-sm-6 col-xs-12 latest-news-load wow fadeInUp" data-wow-delay="0.3s">
				                <article class="latest-news-article">
				                    <div class="post-thumb">
				                        <a href="<?php echo esc_url( get_the_permalink() ); ?>" class="data-bg data-bg-big"
				                           data-background="<?php echo esc_url( $featured_image[0] ); ?>">

			                                <?php if( !empty( $icon ) ){ ?>
                                                <span class="format-icon">
                                                    <i class="ion <?php echo esc_attr( $icon ); ?>"></i>
                                                </span>
                                            <?php } ?>

				                        </a>
				                    </div>

				                    <div class="entry-content">
                                        <div class="entry-meta entry-meta-category">
                                            <?php store_lite_entry_footer( $cats = true,$tags = false, $edits = false ); ?>
                                        </div>

				                        <h3 class="entry-title entry-title-medium">
				                            <a href="<?php echo esc_url( get_the_permalink() ); ?>"><?php the_title(); ?></a>
				                        </h3>
				                    </div>

				                </article>
				            </div>

			        	<?php endwhile; ?>

			        </div>

			        <a href="javascript:void(0)" class="infinity-btn">
                        <span paged="2" repeat-time="<?php echo esc_attr( $repeat_times ); ?>" data-cat="<?php echo esc_attr( $recommended_post_category ); ?>" class="loadmore"><?php echo esc_html('Load More Posts','store-lite'); ?></span>
                    </a>

			    </div>
			</div>

		<?php
		wp_reset_postdata();
        endif;

	}

endif;
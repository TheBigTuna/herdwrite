<?php
/**
* Advertise Image Function.
*
* @package Store Lite
*/

if ( !function_exists( 'store_lite_advertise' ) ):

	function store_lite_advertise( $store_lite_home_section ){

		$advertise_image = isset( $store_lite_home_section->advertise_image ) ? $store_lite_home_section->advertise_image : '' ;
		$advertise_link = isset( $store_lite_home_section->advertise_link ) ? $store_lite_home_section->advertise_link : '' ;
		if( $advertise_image ){ ?>

			<div class="home-lead-block twp-blocks">
			    <div class="wrapper">
			        <div class="twp-row">
			            <div class="column">
			                <a href="<?php echo esc_url( $advertise_link ); ?>" target="_blank" class="home-lead-link">
			                    <img src="<?php echo esc_url( $advertise_image ); ?>" alt="<?php esc_html_e('Advertise Image','store-lite'); ?>">
			                </a>
			            </div>
			        </div>
			    </div>
			</div>

		<?php
		}
	}

endif; ?>
<?php
$default = store_lite_get_default_theme_options();
$twp_store_lite_home_sections = get_theme_mod( 'twp_store_lite_home_sections', json_encode( $default['twp_store_lite_home_sections'] ) );
$paged_active = false;
if ( !is_paged() ) {
	$paged_active = true;
}
$twp_store_lite_home_sections = json_decode( $twp_store_lite_home_sections );

foreach( $twp_store_lite_home_sections as $store_lite_home_section ){

	$home_section_type = isset( $store_lite_home_section->home_section_type ) ? $store_lite_home_section->home_section_type : '' ;
    switch( $home_section_type ){

        case 'subscribe':
		
		$ed_subscribe = isset( $store_lite_home_section->section_ed ) ? $store_lite_home_section->section_ed : '' ;
		$subacribe_ed_all_page = isset( $store_lite_home_section->subacribe_ed_all_page ) ? $store_lite_home_section->subacribe_ed_all_page : '' ;

		if( $ed_subscribe == 'yes' && $subacribe_ed_all_page == 'yes' && $paged_active ){
	        store_lite_subscribe( $store_lite_home_section );
	    }

        break;

        default:

		break;

	}

}

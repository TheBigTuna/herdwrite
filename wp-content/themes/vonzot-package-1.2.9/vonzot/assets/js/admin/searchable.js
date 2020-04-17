/**
 *  Searchable dropdown
 */
 /* global VonzotAdminParams */
;( function( $ ) {

	'use strict';

	$( '.vonzot-searchable' ).chosen( {
		no_results_text: VonzotAdminParams.noResult,
		width: '100%'
	} );

	$( document ).on( 'hover', '#menu-to-edit .pending', function() {
		if ( ! $( this ).find( '.chosen-container' ).length && $( this ).find( '.vonzot-searchable' ).length ) {
			$( this ).find( '.vonzot-searchable' ).chosen( {
				no_results_text: VonzotAdminParams.noResult,
				width: '100%'
			} );
		}
	} );

} )( jQuery );
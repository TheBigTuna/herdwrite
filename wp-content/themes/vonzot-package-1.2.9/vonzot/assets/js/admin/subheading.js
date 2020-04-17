/**
 *  Subheading
 */
 /* global VonzotAdminParams */
;( function( $ ) {

	'use strict';

	$( 'input#_post_subheading' ).parents( '.option-section-_post_subheading' )
		.hide()
		.find( 'input' )
		.attr( { 'tabindex': 1, 'placeholder' : VonzotAdminParams.subHeadingPlaceholder } )
		.css( {
			'width' : '100%'
		} )
		.insertAfter( $( '#title' ) );

} )( jQuery );
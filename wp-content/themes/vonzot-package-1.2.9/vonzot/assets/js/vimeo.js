/*!
 * Vimeo
 *
 * Vonzot 1.2.9
 */
/* jshint -W062 */

/* global Vimeo */
var VonzotVimeo = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.vimeo-bg' ).each( function() {
				var iframe = $( this )[0],
					player = new Vimeo.Player( iframe );
				
				player.setVolume( 0 );
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		VonzotVimeo.init();
	} );

} )( jQuery );
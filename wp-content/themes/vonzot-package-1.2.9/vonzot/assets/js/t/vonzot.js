/*!
 * Additional Theme Methods
 *
 * Vonzot 1.2.9
 */
/* jshint -W062 */

/* global VonzotParams, VonzotUi, WVC, Cookies, Event, WVCParams, CountUp */
var Vonzot = function( $ ) {

	'use strict';

	return {
		initFlag : false,
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isWVC : 'undefined' !== typeof WVC,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		loaded : false,

		/**
		 * Init all functions
		 */
		init : function () {

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			this.wcLiveSearch();
			this.quickView();
			this.loginPopup();
			this.stickyProductDetails();
			this.transitionCosmetic();
			this.startPercent();

			this.isMobile = VonzotParams.isMobile;

			if ( this.isWVC ) {
				
			}

			$( window ).on( 'wwcq_product_quickview_loaded', function( event ) {
				
			} );

			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.backToTopSkin( scrollTop );
			} );

			this.initFlag = true;
		},

		/**
		 * WC live search
		 */
		wcLiveSearch : function () {
			$( '.wvc-wc-search-form' ).addClass( 'live-search-form' ).append( '<span style="display:none" class="fa search-form-loader fa-circle-o-notch fa-spin hide"></span>' );

			VonzotUi.liveSearch();
		},

		/**
		 * Product quickview
		 */
		quickView : function () {

			$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
				if ( $button.hasClass( 'product-add-to-cart' ) ) {
					//console.log( 'good?' );
					$button.attr( 'href', VonzotParams.WooCommerceCartUrl );
					$button.find( 'span' ).attr( 'title', VonzotParams.l10n.viewCart );
					$button.removeClass( 'ajax_add_to_cart' );
				}
			} );
		},

		/**
		 * Sticky product layout
		 */
		stickyProductDetails : function() {
			if ( $.isFunction( $.fn.stick_in_parent ) ) {
				if ( $( 'body' ).hasClass( 'sticky-product-details' ) ) {
					$( '.entry-single-product .summary' ).stick_in_parent( {
						offset_top : parseInt( VonzotParams.portfolioSidebarOffsetTop, 10 ) + 40
					} );
				}
			}
		},

		/**
		 * Check back to top color
		 */
		backToTopSkin : function( scrollTop ) {
			
			if ( scrollTop < 550 ) {
				return;
			}

			$( '.wvc-row' ).each( function() {

				if ( $( this ).hasClass( 'wvc-font-light' ) && ! $( this ).hasClass( 'wvc-row-bg-transparent' ) ) {

						var $button = $( '#back-to-top' ),
						buttonOffset = $button.position().top + $button.width() / 2 ,
						sectionTop = $( this ).offset().top - scrollTop,
						sectionBottom = sectionTop + $( this ).outerHeight();

					if ( sectionTop < buttonOffset && sectionBottom > buttonOffset ) {
						$button.addClass( 'back-to-top-light' );
					} else {
						$button.removeClass( 'back-to-top-light' );
					}
				}
			} );
		},

		loginPopup : function() {

			var $body = $( 'body' );

			$( document ).on( 'click', '.account-item-icon-user-not-logged-in, .close-loginform-button', function( event ) {
				event.preventDefault();

				if ( $body.hasClass( 'loginform-popup-toggle' ) ) {

					$body.removeClass( 'loginform-popup-toggle' );

				} else {
					
					$body.removeClass( 'overlay-menu-toggle' );

					if ( $( '.wvc-login-form' ).length ) {

						$body.addClass( 'loginform-popup-toggle' );

					} else {
						/* AJAX call */
						$.post( VonzotParams.ajaxUrl, { action : 'vonzot_ajax_get_wc_login_form' }, function( response ) {
							
							console.log( response );

							if ( response ) {

								$( '#loginform-overlay-content' ).append( response );

								$body.addClass( 'loginform-popup-toggle' );
							}
						} );
					}
				}
			} );

			if ( ! this.isMobile ) {

				$( document ).mouseup( function( event ) {

					if ( 1 !== event.which ) {
						return;
					}

					var $container = $( '#loginform-overlay-content' );

					if ( ! $container.is( event.target ) && $container.has( event.target ).length === 0 ) {
						$body.removeClass( 'loginform-popup-toggle' );
					}
				} );
			}
		},

		/**
		 * Overlay transition
		 */
		transitionCosmetic : function() {

			$( document ).on( 'click', '.internal-link:not(.disabled)', function( event ) {

				if ( ! event.ctrlKey ) {

					event.preventDefault();

					var $link = $( this );

					$( 'body' ).removeClass( 'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle loginform-popup-toggle' );
					$( 'body' ).addClass( 'loading transitioning' );

					Cookies.set( VonzotParams.themeSlug + '_session_loaded', true, { expires: null } );

					if ( $( '.vonzot-loader-overlay' ).length ) {
						$( '.vonzot-loader-overlay' ).one( VonzotUi.transitionEventEnd(), function() {
							Cookies.remove( VonzotParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );
					} else {
						window.location = $link.attr( 'href' );
					}
				}
			} );
		},

		/**
		 * Star counter loader
		 */
		startPercent : function() {

			if ( $( '#vonzot-percent' ).length ) {

				var _this = this,
					$vinyl = $( '#vonzot-vinly' ),
					progressNumber = 'vonzot-percent',
					$progressNumber = $( '#' + progressNumber ),
					duration = 3,
					numAnimText,
					options = {
						useEasing: true,
						useGrouping: true,
						separator: ',',
						decimal: '.',
						suffix: '%'
					};
				
				$vinyl.fadeIn( '', function() {
					$progressNumber.addClass( 'vonzot-percent-show' ).one( VonzotUi.transitionEventEnd(), function() {
						
						numAnimText = new CountUp( progressNumber, 0, 100, 0, duration, options );
						
						numAnimText.start( function() {
							$progressNumber
								.removeClass( 'vonzot-percent-show' )
								.addClass( 'vonzot-percent-hide' )
								.one( VonzotUi.transitionEventEnd(), function() {
									_this.reveal();
								} );
						} );
					} );
				} );
			}
		},

		reveal : function() {

			var _this = this;

			$( 'body' ).addClass( 'loaded reveal' );
			_this.fireContent();
		},

		/**
		* Page Load
		*/
		loadingAnimation : function () {

			var _this = this,
				delay = 50;

		    	if ( $( '#vonzot-percent' ).length ) {
		    		return;
		    	}

			setTimeout( function() {

				$( 'body' ).addClass( 'loaded' );

				if ( $( '.vonzot-loader-overlay' ).length ) {

					$( 'body' ).addClass( 'reveal' );

					$( '.vonzot-loader-overlay' ).one( VonzotUi.transitionEventEnd(), function() {

						_this.fireContent();

						setTimeout( function() {

							$( 'body' ).addClass( 'one-sec-loaded' );

						}, 100 );
					} );
				
				} else {

					$( 'body' ).addClass( 'reveal' );

					_this.fireContent();

					setTimeout( function() {

						$( 'body' ).addClass( 'one-sec-loaded' );

					}, 100 );
				}
			}, delay );
 		},

		fireContent : function () {
			
			var _this = this;

			// Animate
			$( window ).trigger( 'page_loaded' );
			VonzotUi.wowAnimate();
			window.dispatchEvent( new Event( 'resize' ) );
			window.dispatchEvent( new Event( 'scroll' ) ); // Force WOW effect
			$( window ).trigger( 'just_loaded' );
			$( 'body' ).addClass( 'one-sec-loaded' );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		Vonzot.init();
	} );

	$( window ).load( function() {
		Vonzot.loadingAnimation();
	} );

} )( jQuery );
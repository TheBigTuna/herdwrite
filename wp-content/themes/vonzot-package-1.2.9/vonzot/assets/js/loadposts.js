/*!
 * Infinite scroll blog
 *
 * Vonzot 1.2.9
 */
/* jshint -W062 */
/* global VonzotParams,
VonzotUi,
VonzotMasonry,
VonzotYTVideoBg,
VonzotUi,
WPM,
WVC,
WVCBigText,
WolfCustomPostMeta,
VonzotAjaxNav,
_gaq, ga,
alert, console,
Event */

var VonzotLoadPosts = function ( $ ) {
	'use strict';

	return {

		isWVC : 'undefined' !== typeof WVC,

		/**
		 * Init blog
		 */
		init : function () {
			this.loadMorePosts();
		},

		loadMorePosts : function () {

			var _this = this;

			$( document ).on( 'click', '.loadmore-button', function( event ) {

				event.preventDefault();

				if ( VonzotParams.isCustomizer ) {
					event.stopPropagation();
					alert( VonzotParams.l10n.infiniteScrollDisabledMsg );
					return;
				}

				var $button = $( this ),
					href = $button.attr( 'href' );

				if ( $button.hasClass( 'trigger-loading' ) ) {
					return;
				}

				$button.addClass( 'trigger-loading' );

				$button.html( VonzotParams.l10n.infiniteScrollMsg ); // loading message

				$.get( href, function( response ) {
					if ( response ) {
						_this.processContent( response, $button );
					} else {
						console.log( 'empty response' );
					}
				} );
			} );
		},

		/**
		 * Process response data
		 */
		processContent : function ( response, $button ) {

			if ( response ) {

				var _this = this,
					href = $button.attr( 'href' ),
					containerId = $button.parent().prev().attr( 'id' ),
					$container = $( '#' + containerId ),
					entryEffect = $container.find( '.entry:first-child' ).attr( 'data-aos' ),
					max = parseInt( $button.attr( 'data-max-pages' ), 10 ),
					newItems,
					$lastItem = $container.find( '.entry:last-child' ),
					lastItemOffsetBottom = $lastItem.offset().top + $lastItem.height(),
					$dom,
					nextPage;

				$dom = $( document.createElement( 'html' ) ); // Create HTML content
				$dom[0].innerHTML = response; // Set AJAX response as HTML dom
				newItems = $dom.find( '#' + containerId ).html(),
				nextPage = parseInt( $dom.find( '.loadmore-button' ).attr( 'data-next-page' ), 10 );

				if ( _this.isWVC && entryEffect ) {
					$dom.find( '#' + containerId ).find( '.entry' ).each( function() {
						$( this ).addClass( 'aos-disabled' );
						$( this ).attr( 'data-aos-delay', 1500 );
					} );

					newItems = $dom.find( '#' + containerId ).html();
				}

				$container.append( newItems );

				_this.trackPageView( href );

				if ( VonzotParams.doLoadMorePaginationHashChange ) {
					history.pushState( null, null, href );
				}


				/* Update button */
				if ( max < nextPage || undefined === nextPage || isNaN( nextPage ) ) {

					$button.html( VonzotParams.l10n.infiniteScrollEndMsg );

					setTimeout( function() {
						$button.fadeOut( 500, function() {
							$( this ).remove();
						} );
					}, 3000 );

				} else {

					/* Get next page link and update button attrs */
					$.post( VonzotParams.ajaxUrl, {

						action: 'vonzot_ajax_get_next_page_link',
						href : $button.attr( 'href' )

					}, function( response ) {

						if ( response ) {

							if ( $.parseJSON( response ) ) {

								response = $.parseJSON( response );
								$button.attr( 'data-current-page', response.currentPage );
								$button.attr( 'data-next-page', response.nextPage );
								$button.attr( 'href', response.href );
							}
						}

						$button.removeClass( 'trigger-loading' );
						$button.html( VonzotParams.l10n.loadMoreMsg );
					} );
				}

				_this.callBack( $container );

				if ( $container.hasClass( 'grid-padding-yes' ) ) {
					lastItemOffsetBottom += 14;
				}

				if ( $container.hasClass( 'display-metro' ) || $container.hasClass( 'display-masonry' ) || $container.hasClass( 'display-masonry_modern' ) ) {
					setTimeout( function() {
						_this.scrollToPoint( $( window ).scrollTop() + 200 ); // scroll 200px
					}, 1000 );

				} else {
					setTimeout( function() {
						_this.scrollToPoint( lastItemOffsetBottom );
					}, 1000 );
				}
				setTimeout( function() {
					window.dispatchEvent( new Event( 'resize' ) );

				}, 1500 );
			}
		},

		/**
		 * Decode URI
		 */
		urldecode : function( url ) {
			var txt = document.createElement( 'textarea' );
				txt.innerHTML = url;
			
			return txt.value;
		},

		/**
		 * Scroll to point smoothly after posts are loaded
		 */
		scrollToPoint : function ( scrollPoint ) {

			$( 'html, body' ).stop().animate( {

				scrollTop: scrollPoint - VonzotUi.getToolBarOffset()

			}, 1E3, 'swing' );
		},

		/**
		 * Track page view if Google analytics is found
		 */
		trackPageView : function ( url ) {

			if ( 'undefined' !== typeof _gaq ) {
				_gaq.push( [ '_trackPageview', url ] );
			}
			else if ( 'undefined' !== typeof ga ) {
				ga( 'send', 'pageview', { 'page' : url } );
			}
		},

		/**
		 * Callback
		 */
		callBack : function ( $container ) {

			$container = $container || $( '.items' );
				
			var entryEffect = $container.find( '.entry:first-child' ).attr( 'data-aos' );

			if ( 'undefined' !== typeof VonzotUi ) {
				VonzotUi.adjustmentClasses();
				VonzotUi.resizeVideoBackground();
				VonzotUi.lazyLoad();
				VonzotUi.fluidVideos( $container, true );
				VonzotUi.flexSlider();
				VonzotUi.lightbox();
				VonzotUi.addItemAnimationDelay();
				VonzotUi.parallax();
				VonzotUi.setInternalLinkClass();
				VonzotUi.muteVimeoBackgrounds();

				setTimeout( function() {
					VonzotUi.videoThumbnailPlayOnHover();
				}, 200 );
			}

			/* YT background */
			if ( 'undefined' !== typeof VonzotYTVideoBg ) {
				VonzotYTVideoBg.init( $container );
				VonzotYTVideoBg.playVideo( $container );
			}

			if ( $( '.masonry-container' ).length || $( '.metro-container' ).length ) {
				VonzotMasonry.masonry();
				VonzotMasonry.resizeTimer();

				if ( $container.data( 'isotope' ) ) {
					$container.isotope( 'reloadItems' ).isotope();
				}
			}

			if ( $( '.fleximages-container' ).length ) {
				VonzotMasonry.flexImages();
			}

			/* AJAX nav */
			if ( 'undefined' !== typeof VonzotAjaxNav ) {
			}

			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			/* Big Text */
			if ( 'undefined' !== typeof WVCBigText ) {
				WVCBigText.init();
			}

			/* Likes post meta */
			if ( 'undefined' !== typeof WolfCustomPostMeta ) {
				WolfCustomPostMeta.checkLikedPosts();
			}

			if ( $container.find( '.twitter-tweet' ).length ) {
				$.getScript( 'http://platform.twitter.com/widgets.js' );
			}

			if ( $container.find( '.instagram-media' ).length ) {

				$.getScript( '//platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			if ( $container.find( 'audio:not(.minimal-player-audio):not(.loop-post-player-audio),video' ).length ) {
				$container.find( 'audio,video' ).mediaelementplayer();
			}

			if ( this.isWVC && entryEffect ) {
				
				setTimeout( function() {

					$container.find( '.aos-disabled' ).each( function() {
						$( this ).removeClass( 'aos-disabled' );
					} );

				}, 1000 );
			}
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		VonzotLoadPosts.init();
	} );

} )( jQuery );
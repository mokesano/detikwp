/**
 * Copyright (c) 2018 Gian MR
 * Gian MR Theme Custom Javascript For Woocommerce
 */

(function(){
	"use strict";
	var s = document.querySelector( '.woocommerce-ordering select' );
	if ( s ) {
		NiceSelect.bind( s );
	}
})();

(function(){
	"use strict";
	var btnTag = document.querySelectorAll( '.gmr-woo-menuparent' ), i;
	for ( i = 0; i < btnTag.length; i++ ) {
		if ( btnTag[i] ) {
			btnTag[i].addEventListener(
				'click',
				function( e ) {
					e.stopPropagation();
					e.preventDefault();
					/* console.log ( this.nextElementSibling ); */
					var dropdowns = this.nextElementSibling;
					if ( dropdowns !== null ) {
						dropdowns.classList.toggle( 'show' );
						if (e.target.className !== 'gmr-woo-classsubmenu' ) {
							document.addEventListener(
								'click',
								function( e ) {
									if ( dropdowns !== e.target && ! dropdowns.contains( e.target ) ) {
										if ( dropdowns.classList.contains( 'show' ) ) {
											dropdowns.classList.remove( 'show' );
										}
									}
								}
							);
						}
					}
				}
			);
		}
	}
})();

/**
 * Search Click Toggle
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */

/* Click Dropdown Search */
(function(){
	"use strict";

	var btn = document.getElementById( 'search-menu-button' );

	// Close the dropdown menu if the user clicks outside of it.
	if ( btn ) {
		btn.addEventListener(
			'click',
			function( e ) {
				e.stopPropagation();
				e.preventDefault();
				var dropdowns = document.querySelector( '.search-dropdown' );
				dropdowns.classList.toggle( 'active' );
				if ( dropdowns.classList.contains( 'active' ) ) {
					btn.classList.add( 'toggled-on' );
				} else {
					btn.classList.remove( 'toggled-on' );
				}
				var getid = document.getElementById( 'search-dropdown-container' );
				document.addEventListener(
					'click',
					function( e ) {
						if ( getid !== e.target && ! getid.contains( e.target ) ) {
							if ( dropdowns.classList.contains( 'active' ) ) {
								dropdowns.classList.remove( 'active' );
								btn.classList.remove( 'toggled-on' );
							}
						}
					}
				);
			}
		);
	}

})();

/**
 * Darkmode Button
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */

/* Dark Mode */
(function(){

	var root = document.body;
	var btn  = document.querySelector( '.darkmode-button' );

	var nightBtn = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="0.95em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 17"><g fill="#888888" fill-rule="evenodd"><path d="M10.705 13.274A6.888 6.888 0 0 1 6.334 1.065C2.748 1.892.072 5.099.072 8.936a8.084 8.084 0 0 0 8.084 8.085c3.838 0 7.043-2.676 7.871-6.263a6.868 6.868 0 0 1-5.322 2.516z"/><path d="M12.719 1.021l1.025 2.203l2.293.352l-1.658 1.715l.391 2.42l-2.051-1.143l-2.051 1.143l.391-2.42l-1.661-1.715l2.294-.352l1.027-2.203z"/></g></svg>';

	var sunBtn = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M15 2h2v5h-2z" fill="#888888"/><path d="M21.687 8.9l3.506-3.507l1.414 1.415l-3.506 3.506z" fill="#888888"/><path d="M25 15h5v2h-5z" fill="#888888"/><path d="M21.687 23.1l1.414-1.414l3.506 3.506l-1.414 1.415z" fill="#888888"/><path d="M15 25h2v5h-2z" fill="#888888"/><path d="M5.394 25.192L8.9 21.686l1.414 1.415l-3.506 3.506z" fill="#888888"/><path d="M2 15h5v2H2z" fill="#888888"/><path d="M5.394 6.808l1.414-1.415L10.314 8.9L8.9 10.314z" fill="#888888"/><path d="M16 10a6 6 0 1 0 6 6a6 6 0 0 0-6-6z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg>';

	var currentTheme = localStorage.getItem( 'theme' );
	if ( currentTheme == 'dark' ) {
		root.classList.toggle( 'dark-theme' );
		btn.innerHTML = sunBtn;
	} else if ( currentTheme == 'light' ) {
		btn.innerHTML = nightBtn;
	}

	if ( btn ) {
		btn.addEventListener(
			'click',
			function( e ) {
				e.preventDefault();
				/* root.classList.toggle( 'dark-theme' ); */
				root.classList.toggle( 'dark-theme' );
				if ( root.classList.contains( 'dark-theme' ) ) {
					btn.innerHTML = sunBtn;
					var theme     = 'dark';
				} else {
					btn.innerHTML = nightBtn;
					var theme     = 'light';
				}
				localStorage.setItem( 'theme', theme );
			}
		);
	}
})();

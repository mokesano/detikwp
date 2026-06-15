/**
 * This for popup upload image in user field.
 * Copyright (c) 2020 Gian MR
 * Gian MR Theme Custom Javascript
 *
 * @package wpberita
 */

(function( $ ) {
	'use strict';

	var mediaControl = {

		/**
		 * Initializes a new media manager or returns an existing frame.
		 *
		 * @see wp.media.featuredImage.frame()
		 */
		selector: null,
		size: null,
		container: null,
		frame: function() {
			if ( this._frame ) {
				return this._frame;

			}

			this._frame = wp.media(
				{
					title: 'Media',
					button: {
						text: 'Update'
					},
					multiple: false
				}
			);

			this._frame.on( 'open', this.updateFrame ).state( 'library' ).on( 'select', this.select );

			return this._frame;

		},

		select: function() {
			var context    = $( '#custom-profile-image' ),
				input      = context.find( '#custom-image-ap' ),
				image      = context.find( 'img' ),
				attachment = mediaControl.frame().state().get( 'selection' ).first().toJSON();

			image.attr( 'src', attachment.url );
			input.val( attachment.url );

		},

		init: function() {
			var context = $( '#custom-profile-image' );
			context.on(
				'click',
				'#add-image',
				function( e ) {
					e.preventDefault();
					mediaControl.frame().open();
				}
			);

			context.on(
				'click',
				'#remove-image',
				function( e ) {
					var context = $( '#custom-profile-image' ),
						input   = context.find( '#custom-image-ap' ),
						image   = context.find( 'img' );

					e.preventDefault();

					input.val( '' );
					image.attr( 'src', image.data( 'default' ) );
				}
			);

		}

	};

	$( document ).ready(
		function() {
			mediaControl.init();
		}
	);

})( jQuery );

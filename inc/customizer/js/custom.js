/**
 * Googe Font Select Custom Control
 *
 * @author Anthony Hortin <http://maddisondesigns.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 * @link https://github.com/maddisondesigns
 * @package wpberita
 */

jQuery( document ).ready(
	function($) {
		"use strict";
		$( '.google-fonts-list' ).each(
			function ( i, obj ) {
				if ( ! $( obj ).hasClass( 'select2-hidden-accessible' ) ) {
					$( obj ).select2();
				}
			}
		);

		$( '.google-fonts-list' ).on(
			'change',
			function() {
				var elementRegularWeight      = $( this ).parent().parent().find( '.google-fonts-regularweight-style' );
				var elementItalicWeight       = $( this ).parent().parent().find( '.google-fonts-italicweight-style' );
				var elementBoldWeight         = $( this ).parent().parent().find( '.google-fonts-boldweight-style' );
				var selectedFont              = $( this ).val();
				var customizerControlName     = $( this ).attr( 'control-name' );
				var elementRegularWeightCount = 0;
				var elementItalicWeightCount  = 0;
				var elementBoldWeightCount    = 0;

				/* Clear Weight/Style dropdowns */
				elementRegularWeight.empty();
				elementItalicWeight.empty();
				elementBoldWeight.empty();

				/* Make sure Italic & Bold dropdowns are enabled */
				elementRegularWeight.prop( 'disabled', false );
				elementItalicWeight.prop( 'disabled', false );
				elementBoldWeight.prop( 'disabled', false );

				/* Get the Google Fonts control object */
				var bodyfontcontrol = _wpCustomizeSettings.controls[customizerControlName];

				/* Find the index of the selected font */
				var indexes = $.map(
					bodyfontcontrol.idthemefontslist,
					function( obj, index ) {
						if ( obj.f === selectedFont ) {
							return index;
						}
					}
				);

				var index = indexes[0];

				/* For the selected Google font show the available weight/style variants */
				$.each(
					bodyfontcontrol.idthemefontslist[index].v,
					function( val, text ) {
						if (text.indexOf( "italic" ) >= 0) {
							elementItalicWeight.append(
								$( '<option></option>' ).val( text ).html( text )
							);
							elementItalicWeightCount++;
						} else {
							elementRegularWeight.append(
								$( '<option></option>' ).val( text ).html( text )
							);
							elementRegularWeightCount++;
							elementBoldWeight.append(
								$( '<option></option>' ).val( text ).html( text )
							);
							elementBoldWeightCount++;
						}
					}
				);

				if ( elementRegularWeightCount == 0 ) {
					elementRegularWeight.append(
						$( '<option></option>' ).val( '' ).html( 'Not Available for this font' )
					);
					elementRegularWeight.prop( 'disabled', 'disabled' );
				}
				if (elementItalicWeightCount == 0) {
					elementItalicWeight.append(
						$( '<option></option>' ).val( '' ).html( 'Not Available for this font' )
					);
					elementItalicWeight.prop( 'disabled', 'disabled' );
				}
				if (elementBoldWeightCount == 0) {
					elementBoldWeight.append(
						$( '<option></option>' ).val( '' ).html( 'Not Available for this font' )
					);
					elementBoldWeight.prop( 'disabled', 'disabled' );
				}

				idthemeGetAllSelects( $( this ).parent().parent() );
			}
		);

		$( '.google_fonts_select_control select' ).on(
			'change',
			function() {
				idthemeGetAllSelects( $( this ).parent().parent() );
			}
		);

		function idthemeGetAllSelects($element) {
			var selectedFont = {
				font: $element.find( '.google-fonts-list' ).val(),
				regularweight: $element.find( '.google-fonts-regularweight-style' ).val(),
				italicweight: $element.find( '.google-fonts-italicweight-style' ).val(),
				boldweight: $element.find( '.google-fonts-boldweight-style' ).val(),
			};

			/* Important! Make sure to trigger change event so Customizer knows it has to save the field */
			$element.find( '.customize-control-google-font-selection' ).val( JSON.stringify( selectedFont ) ).trigger( 'change' );
		}

	}
);

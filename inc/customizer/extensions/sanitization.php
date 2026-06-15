<?php
/**
 * Customizer Sanization
 *
 * @package Customizer_Library
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

if ( ! function_exists( 'customizer_library_sanitize_text' ) ) :
	/**
	 * Sanitize a string to allow only tags in the allowedtags array.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string $string The unsanitized string.
	 */
	function customizer_library_sanitize_text( $string ) {
		$allowedtags = array(
			'a'      => array(
				'class' => array(),
				'href'  => array(),
				'rel'   => array(),
				'title' => array(),
			),
			'b'      => array(),
			'div'    => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'i'      => array(),
			'img'    => array(
				'alt'    => array(),
				'class'  => array(),
				'height' => array(),
				'src'    => array(),
				'width'  => array(),
			),
			'li'     => array(
				'class' => array(),
			),
			'ol'     => array(
				'class' => array(),
			),
			'p'      => array(
				'class' => array(),
			),
			'q'      => array(
				'cite'  => array(),
				'title' => array(),
			),
			'span'   => array(
				'class' => array(),
				'title' => array(),
				'style' => array(),
			),
			'strong' => array(),
			'ul'     => array(
				'class' => array(),
			),
		);
		return wp_kses( $string, $allowedtags );
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_textareajsallowed' ) ) :
	/**
	 * Sanitize a string to allow only tags in the allowedtags array.
	 *
	 * @since  1.0.0.
	 *
	 * @param  string $string The unsanitized string.
	 * @return string The sanitized string.
	 */
	function customizer_library_sanitize_textareajsallowed( $string ) {
		if ( current_user_can( 'unfiltered_html' ) ) {
			return $string;
		} else {
			return wp_kses_post( $string );
		}
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_checkbox' ) ) :
	/**
	 * Sanitize a checkbox to only allow 0 or 1
	 *
	 * @since  1.0.0.
	 *
	 * @param  boolean $value The unsanitized value.
	 */
	function customizer_library_sanitize_checkbox( $value ) {
		if ( $value == 1 ) {
			return 1;
		} else {
			return 0;
		}
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_choices' ) ) :
	/**
	 * Sanitize a value from a list of allowed values.
	 *
	 * @since 1.0.0.
	 *
	 * @param  mixed $value   The value to sanitize.
	 * @param  mixed $setting The setting for which the sanitizing is occurring.
	 */
	function customizer_library_sanitize_choices( $value, $setting ) {
		if ( is_object( $setting ) ) {
			$setting = $setting->id;
		}

		$choices         = customizer_library_get_choices( $setting );
		$allowed_choices = array_keys( $choices );

		if ( ! in_array( $value, $allowed_choices ) ) {
			$value = customizer_library_get_default( $setting );
		}

		return $value;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_file_url' ) ) :
	/**
	 * Sanitize the url of uploaded media.
	 *
	 * @since 1.0.0.
	 *
	 * @param  string $url The url to sanitize.
	 */
	function customizer_library_sanitize_file_url( $url ) {

		$output = '';

		$filetype = wp_check_filetype( $url );
		if ( $filetype['ext'] ) {
			$output = esc_url_raw( $url );
		}

		return $output;
	}
endif;

if ( ! function_exists( 'sanitize_hex_color' ) ) :
	/**
	 * Sanitizes a hex color.
	 *
	 * Returns either '', a 3 or 6 digit hex color (with #), or null.
	 * For sanitizing values without a #, see sanitize_hex_color_no_hash().
	 *
	 * @since 3.4.0
	 *
	 * @param string $color Color hex.
	 * @return string|null
	 */
	function sanitize_hex_color( $color ) {
		if ( '' === $color ) {
			return '';
		}

		// 3 or 6 hex digits, or the empty string.
		if ( preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) ) {
			return $color;
		}

		return null;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_range' ) ) :
	/**
	 * Sanitizes a range value
	 *
	 * @since 1.3.0
	 *
	 * @param number $value Options value.
	 * @return string|null
	 */
	function customizer_library_sanitize_range( $value ) {
		if ( is_numeric( $value ) ) {
			return $value;
		}
		return 0;
	}
endif;

if ( ! function_exists( 'customizer_library_sanitize_number' ) ) :
	/**
	 * Sanitizes a range value
	 *
	 * @since 1.3.0
	 *
	 * @param number $value Options value.
	 * @return string|null
	 */
	function customizer_library_sanitize_number( $value ) {
		if ( is_numeric( $value ) ) {
			return $value;
		}
		return 0;
	}
endif;


if ( ! function_exists( 'customizer_library_sanitize_google_font' ) ) {
	/**
	 * Google Font sanitization
	 *
	 * @since 1.3.0
	 *
	 * @param string $input JSON string to be sanitized.
	 * @return string Sanitized input
	 */
	function customizer_library_sanitize_google_font( $input ) {
		$val = json_decode( $input, true );
		if ( is_array( $val ) ) {
			foreach ( $val as $key => $value ) {
				$val[ $key ] = sanitize_text_field( $value );
			}
			$input = wp_json_encode( $val );
		} else {
			$input = wp_json_encode( sanitize_text_field( $val ) );
		}
		return $input;
	}
}

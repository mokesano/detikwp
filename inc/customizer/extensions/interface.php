<?php
/**
 * Builds out customizer options
 *
 * @package       Customizer_Library
 * @new option by gmr theme
 * - image_crop base on https://make.wordpress.org/core/2015/07/16/new-customizer-media-controls-in-4-3-and-4-2/
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

if ( ! function_exists( 'customizer_library_register' ) ) :
	/**
	 * Configure settings and controls for the theme customizer
	 *
	 * @since  1.0.0.
	 *
	 * @param  object $wp_customize The global customizer object.
	 *
	 * @return void
	 */
	function customizer_library_register( $wp_customize ) {

		$customizer_library = Customizer_Library::Instance();

		$options = $customizer_library->get_options();

		// Bail early if we don't have any options.
		if ( empty( $options ) ) {
			return;
		}

		// Add the sections.
		if ( isset( $options['sections'] ) ) {
			customizer_library_add_sections( $options['sections'], $wp_customize );
		}

		// Add the sections.
		if ( isset( $options['panels'] ) ) {
			customizer_library_add_panels( $options['panels'], $wp_customize );
		}

		// Sets the priority for each control added.
		$loop = 0;

		// Loops through each of the options.
		foreach ( $options as $option ) {

			// Set blank description if one isn't set.
			if ( ! isset( $option['description'] ) ) {
				$option['description'] = '';
			}

			if ( isset( $option['type'] ) ) {

				$loop ++;

				// Apply a default sanitization if one isn't set.
				if ( ! isset( $option['sanitize_callback'] ) ) {
					$option['sanitize_callback'] = customizer_library_get_sanitization( $option['type'] );
				}

				// Set blank active_callback if one isn't set.
				if ( ! isset( $option['active_callback'] ) ) {
					$option['active_callback'] = '';
				}

				// Set default mime_type to image.
				if ( ! isset( $option['mime_type'] ) ) {
					$option['mime_type'] = 'image';
				}

				// Set blank width if one isn't set.
				if ( ! isset( $option['width'] ) ) {
					$option['width'] = '';
				}

				// Set blank height if one isn't set.
				if ( ! isset( $option['height'] ) ) {
					$option['height'] = '';
				}

				// Set false flex_width if one isn't set.
				if ( ! isset( $option['flex_width'] ) ) {
					$option['flex_width'] = false;
				}

				// Set false flex_height if one isn't set.
				if ( ! isset( $option['flex_height'] ) ) {
					$option['flex_height'] = false;
				}

				// Add the setting.
				customizer_library_add_setting( $option, $wp_customize );

				// Priority for control.
				if ( ! isset( $option['priority'] ) ) {
					$option['priority'] = $loop;
				}

				// Adds control based on control type.
				switch ( $option['type'] ) {

					case 'text':
					case 'url':
					case 'select':
					case 'radio':
					case 'checkbox':
					case 'range':
					case 'number':
					case 'textarea':
					case 'dropdown-pages':
						$wp_customize->add_control(
							$option['id'],
							$option
						);
						break;
					case 'color':
						$wp_customize->add_control(
							new WP_Customize_Color_Control(
								$wp_customize,
								$option['id'],
								$option
							)
						);
						break;
					case 'image':
						$wp_customize->add_control(
							new WP_Customize_Image_Control(
								$wp_customize,
								$option['id'],
								array(
									'label'             => $option['label'],
									'section'           => $option['section'],
									'sanitize_callback' => $option['sanitize_callback'],
									'priority'          => $option['priority'],
									'active_callback'   => $option['active_callback'],
									'description'       => $option['description'],
								)
							)
						);

						break;

					case 'media':
						$wp_customize->add_control(
							new WP_Customize_Media_Control(
								$wp_customize,
								$option['id'],
								array(
									'label'             => $option['label'],
									'section'           => $option['section'],
									'sanitize_callback' => $option['sanitize_callback'],
									'priority'          => $option['priority'],
									'active_callback'   => $option['active_callback'],
									'description'       => $option['description'],
									'mime_type'         => $option['mime_type'],
								)
							)
						);
						break;

					case 'cropped_image':
						$wp_customize->add_control(
							new WP_Customize_Cropped_Image_Control(
								$wp_customize,
								$option['id'],
								array(
									'label'             => $option['label'],
									'section'           => $option['section'],
									'sanitize_callback' => $option['sanitize_callback'],
									'priority'          => $option['priority'],
									'flex_width'        => $option['flex_width'], // Allow any width, making the specified value recommended. False by default.
									'flex_height'       => $option['flex_height'], // Require the resulting image to be exactly as tall as the height attribute (default).
									'width'             => $option['width'],
									'height'            => $option['height'],
									'active_callback'   => $option['active_callback'],
									'description'       => $option['description'],
								)
							)
						);

						break;

					case 'upload':
						$wp_customize->add_control(
							new WP_Customize_Upload_Control(
								$wp_customize,
								$option['id'],
								array(
									'label'             => $option['label'],
									'section'           => $option['section'],
									'sanitize_callback' => $option['sanitize_callback'],
									'priority'          => $option['priority'],
									'active_callback'   => $option['active_callback'],
									'description'       => $option['description'],
								)
							)
						);

						break;

					case 'content':
					case 'line':
						// error log( print_r( $option ) );.
						$wp_customize->add_control(
							new Customizer_Library_Content(
								$wp_customize,
								$option['id'],
								$option
							)
						);
						$wp_customize->register_control_type( 'Customizer_Library_Content' );
						break;

					case 'category-select':
						// error log( print_r( $option ) );.
						$wp_customize->add_control(
							new Customizer_Library_Categories(
								$wp_customize,
								$option['id'],
								$option
							)
						);
						$wp_customize->register_control_type( 'Customizer_Library_Categories' );
						break;

					case 'googlefonts':
						// error log( print_r( $option ) );.
						$wp_customize->add_control(
							new Customizer_Library_Google_Font(
								$wp_customize,
								$option['id'],
								$option
							)
						);
						break;
				}
			}
		}
	}

endif;

add_action( 'customize_register', 'customizer_library_register', 100 );

/**
 * Add the customizer sections
 *
 * @since  1.2.0.
 *
 * @param  array  $sections Options Sections.
 * @param  String $wp_customize Options Cutomizr.
 *
 * @return void
 */
function customizer_library_add_sections( $sections, $wp_customize ) {

	foreach ( $sections as $section ) {

		if ( ! isset( $section['description'] ) ) {
			$section['description'] = false;
		}

		$wp_customize->add_section( $section['id'], $section );
	}

}

/**
 * Add the customizer panels
 *
 * @since  1.2.0.
 *
 * @param  array  $panels Panels Options.
 * @param  String $wp_customize Options Cutomizr.
 *
 * @return void
 */
function customizer_library_add_panels( $panels, $wp_customize ) {

	foreach ( $panels as $panel ) {

		if ( ! isset( $panel['description'] ) ) {
			$panel['description'] = false;
		}

		$wp_customize->add_panel( $panel['id'], $panel );
	}

}

/**
 * Add the setting and proper sanitization
 *
 * @since  1.2.0.
 *
 * @param  array  $option Options.
 * @param  String $wp_customize Options Cutomizr.
 *
 * @return void
 */
function customizer_library_add_setting( $option, $wp_customize ) {

	$settings_default = array(
		'default'              => null,
		'option_type'          => 'theme_mod',
		'capability'           => 'edit_theme_options',
		'theme_supports'       => null,
		'transport'            => null,
		'sanitize_callback'    => 'wp_kses_post',
		'sanitize_js_callback' => null,
	);

	// Settings defaults.
	$settings = array_merge( $settings_default, $option );

	// Arguments for $wp_customize->add_setting.
	$wp_customize->add_setting(
		$option['id'],
		array(
			'default'              => $settings['default'],
			'type'                 => $settings['option_type'],
			'capability'           => $settings['capability'],
			'theme_supports'       => $settings['theme_supports'],
			'transport'            => $settings['transport'],
			'sanitize_callback'    => $settings['sanitize_callback'],
			'sanitize_js_callback' => $settings['sanitize_js_callback'],
		)
	);

}

/**
 * Get default sanitization function for option type
 *
 * @since  1.2.0.
 *
 * @param array $type Options.
 *
 * @return string
 */
function customizer_library_get_sanitization( $type ) {

	if ( 'select' === $type || 'radio' === $type ) {
		return 'customizer_library_sanitize_choices';
	}

	if ( 'checkbox' === $type ) {
		return 'customizer_library_sanitize_checkbox';
	}

	if ( 'color' === $type ) {
		return 'sanitize_hex_color';
	}

	if ( 'upload' === $type || 'image' === $type ) {
		return 'customizer_library_sanitize_file_url';
	}

	if ( 'dropdown-pages' === $type || 'media' === $type || 'cropped_image' === $type || 'category-select' === $type ) {
		return 'absint';
	}

	if ( 'text' === $type || 'textarea' === $type ) {
		return 'customizer_library_sanitize_text';
	}

	if ( 'url' === $type ) {
		return 'esc_url';
	}

	if ( 'range' === $type ) {
		return 'customizer_library_sanitize_range';
	}

	if ( 'number' === $type ) {
		return 'customizer_library_sanitize_number';
	}

	if ( 'googlefonts' === $type ) {
		return 'customizer_library_sanitize_google_font';
	}

	// If a custom option is being used, return false.
	return false;
}

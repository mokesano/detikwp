<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'customizer_library_demo_build_styles' ) && class_exists( 'Customizer_Library_Styles' ) ) :
	/**
	 * Process user options to generate CSS needed to implement the choices.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_build_styles() {
		$setting    = 'gmr_primary-font';
		$mod        = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$headerfont = '';
		if ( $mod ) {
			$headerfont = json_decode( $mod, true );
			if ( is_array( $headerfont ) ) {
				if ( ! empty( $headerfont['font'] ) ) {
					$font = $headerfont['font'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'h1',
								'h2',
								'h3',
								'h4',
								'h5',
								'h6',
								'.site-title',
								'.gmr-mainmenu ul > li > a',
								'.sidr ul li a',
								'.heading-text',
								'.gmr-mobilemenu ul li a',
								'#navigationamp ul li a',
							),
							'declarations' => array(
								'font-family' => $font,
							),
						)
					);
				}
				if ( ! empty( $headerfont['regularweight'] ) ) {
					$regularweight = $headerfont['regularweight'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'h1',
								'h2',
								'h3',
								'h4',
								'h5',
								'h6',
								'.site-title',
								'.gmr-mainmenu ul > li > a',
								'.sidr ul li a',
								'.heading-text',
								'.gmr-mobilemenu ul li a',
								'#navigationamp ul li a',
							),
							'declarations' => array(
								'font-weight' => $regularweight,
							),
						)
					);
				}
				if ( ! empty( $headerfont['boldweight'] ) ) {
					$boldweight = $headerfont['boldweight'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'h1 strong',
								'h2 strong',
								'h3 strong',
								'h4 strong',
								'h5 strong',
								'h6 strong',
							),
							'declarations' => array(
								'font-weight' => $boldweight,
							),
						)
					);
				}
			}
		}

		$setting  = 'gmr_secondary-font';
		$mod      = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$bodyfont = '';
		if ( $mod ) {
			$bodyfont = json_decode( $mod, true );
			if ( is_array( $bodyfont ) ) {
				if ( ! empty( $bodyfont['font'] ) ) {
					$font = $bodyfont['font'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'body',
							),
							'declarations' => array(
								'font-family' => $font,
							),
						)
					);
				}
				if ( ! empty( $bodyfont['regularweight'] ) ) {
					$regularweight = $bodyfont['regularweight'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'body',
							),
							'declarations' => array(
								'--font-reguler' => $regularweight,
							),
						)
					);
				}
				if ( ! empty( $bodyfont['boldweight'] ) ) {
					$boldweight = $bodyfont['boldweight'];
					Customizer_Library_Styles()->add(
						array(
							'selectors'    => array(
								'body',
							),
							'declarations' => array(
								'--font-bold' => $boldweight,
							),
						)
					);
				}
			}
		}

		// Single font size.
		$setting = 'gmr_single_size';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$size = absint( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.entry-content-single',
					),
					'declarations' => array(
						'font-size' => $size . 'px',
					),
				)
			);
		}

		// Header Background image.
		$url      = has_header_image() ? get_header_image() : get_theme_support( 'custom-header', 'default-image' );
		$setting  = 'gmr_active-headerimage';
		$thememod = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( 0 === $thememod && has_header_image() ) {
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'.site-branding',
					),
					'declarations' => array(
						'background-image' => 'url(' . $url . ')',
					),
				)
			);

			// Header Background Size.
			$setting = 'gmr_headerimage_bgsize';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$bgsize = wp_filter_nohtml_kses( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.site-branding',
						),
						'declarations' => array(
							'background-size' => $bgsize,
						),
					)
				);
			}

			// Header Background Repeat.
			$setting = 'gmr_headerimage_bgrepeat';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$bgrepeat = wp_filter_nohtml_kses( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.site-branding',
						),
						'declarations' => array(
							'background-repeat' => $bgrepeat,
						),
					)
				);
			}

			// Header Background Position.
			$setting = 'gmr_headerimage_bgposition';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$bgposition = wp_filter_nohtml_kses( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.site-branding',
						),
						'declarations' => array(
							'background-position' => $bgposition,
						),
					)
				);
			}

			// Header Background Position.
			$setting = 'gmr_headerimage_bgattachment';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$bgattachment = wp_filter_nohtml_kses( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'.site-branding',
						),
						'declarations' => array(
							'background-attachment' => $bgattachment,
						),
					)
				);
			}
		}

		// Color scheme.
		$setting = 'background_color';
		$mod     = get_theme_mod( $setting, get_theme_support( 'custom-background', 'default-color' ) );
		if ( $mod ) {
			$color = sanitize_hex_color_no_hash( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--background-color' => '#' . $color,
					),
				)
			);
		}

		// Color scheme.
		$setting = 'gmr_scheme-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
						'body.dark-theme',
					),
					'declarations' => array(
						'--scheme-color' => $color,
					),
				)
			);
		}

		// Color scheme.
		$setting = 'gmr_second-scheme-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--secondscheme-color' => $color,
					),
				)
			);
		}

		// Content Background Color.
		$setting = 'gmr_content-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--main-color' => $color,
					),
				)
			);
		}

		// Content Link Color.
		$setting = 'gmr_content-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--link-color-body' => $color,
					),
				)
			);
		}

		// Content Link Hover Color.
		$setting = 'gmr_content-linkhovercolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--hoverlink-color-body' => $color,
					),
				)
			);
		}

		// Content Link Hover Color.
		$setting = 'gmr_content-bordercolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--border-color' => $color,
					),
				)
			);
		}

		// Button BG Color.
		$setting = 'gmr_button-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--button-bgcolor' => $color,
					),
				)
			);
		}

		// Button BG Color.
		$setting = 'gmr_button-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--button-color' => $color,
					),
				)
			);
		}

		// Header Background Color.
		$setting = 'gmr_header-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--header-bgcolor' => $color,
					),
				)
			);
		}

		// Topnav Color.
		$setting = 'gmr_topnav-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--topnav-color' => $color,
					),
				)
			);
		}

		// Big Headline Color.
		$setting = 'gmr_big-headline-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--bigheadline-color' => $color,
					),
				)
			);
		}

		$setting = 'gmr_mainmenu-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
						'body.dark-theme',
					),
					'declarations' => array(
						'--mainmenu-bgcolor' => $color,
					),
				)
			);
		}

		// Menu text color.
		$setting = 'gmr_mainmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--mainmenu-color' => $color,
					),
				)
			);
		}

		// Hover text color.
		$setting = 'gmr_hovermenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--mainmenu-hovercolor' => $color,
					),
				)
			);
		}

		$setting = 'gmr_secondmenu-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );

		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--secondmenu-bgcolor' => $color,
					),
				)
			);
		}

		// Menu text color.
		$setting = 'gmr_secondmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--secondmenu-color' => $color,
					),
				)
			);
		}

		// Hover text color.
		$setting = 'gmr_hoversecondmenu-color';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--secondmenu-hovercolor' => $color,
					),
				)
			);
		}

		// Content Background Color.
		$setting = 'gmr_content-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--content-bgcolor' => $color,
					),
				)
			);
		}

		// Grey Color - Content.
		$setting = 'gmr_content-greycolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--content-greycolor' => $color,
					),
				)
			);
		}

		// Footer Background Color.
		$setting = 'gmr_footer-bgcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--footer-bgcolor' => $color,
					),
				)
			);
		}

		// Footer Font Color.
		$setting = 'gmr_footer-fontcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--footer-color' => $color,
					),
				)
			);
		}

		// Footer Link Color.
		$setting = 'gmr_footer-linkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--footer-linkcolor' => $color,
					),
				)
			);
		}

		// Footer Hover Link Color.
		$setting = 'gmr_footer-hoverlinkcolor';
		$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		if ( $mod ) {
			$color = sanitize_hex_color( $mod );
			Customizer_Library_Styles()->add(
				array(
					'selectors'    => array(
						'body',
					),
					'declarations' => array(
						'--footer-hover-linkcolor' => $color,
					),
				)
			);
		}

		if ( class_exists( 'WooCommerce' ) ) {
			// Price.
			$setting = 'gmr_price-color';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'body',
						),
						'declarations' => array(
							'--price-color' => $color,
						),
					)
				);
			}
			// Badge.
			$setting = 'gmr_badge-color';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'body',
						),
						'declarations' => array(
							'--badge-color' => $color,
						),
					)
				);
			}
			// Badge bg color.
			$setting = 'gmr_badge-bgcolor';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'body',
						),
						'declarations' => array(
							'--badge-bgcolor' => $color,
						),
					)
				);
			}
			// button.
			$setting = 'gmr_altbutton-color';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'body',
						),
						'declarations' => array(
							'--altbutton-color' => $color,
						),
					)
				);
			}
			// Button bg color.
			$setting = 'gmr_altbutton-bgcolor';
			$mod     = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
			if ( $mod ) {
				$color = sanitize_hex_color( $mod );
				Customizer_Library_Styles()->add(
					array(
						'selectors'    => array(
							'body',
						),
						'declarations' => array(
							'--altbutton-bgcolor' => $color,
						),
					)
				);
			}
		}
	}
endif; // endif gmr_library_customizer_build_styles.
add_action( 'customizer_library_styles', 'gmr_library_customizer_build_styles' );

if ( ! function_exists( 'customizer_library_demo_styles' ) ) :
	/**
	 * Generates the style tag and CSS needed for the theme options.
	 *
	 * By using the "Customizer_Library_Styles" filter, different components can print CSS in the header.
	 * It is organized this way to ensure there is only one "style" tag.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function gmr_library_customizer_styles() {
		do_action( 'customizer_library_styles' );
		// Echo the rules.
		$css = Customizer_Library_Styles()->build();
		if ( ! empty( $css ) ) {
			wp_add_inline_style( 'wpberita-style', $css );
		}
	}
endif; // endif gmr_library_customizer_styles.
add_action( 'wp_enqueue_scripts', 'gmr_library_customizer_styles' );

if ( ! function_exists( 'gmr_remove_customizer_register' ) ) :
	/**
	 * Add postMessage support for site title and description for the Theme Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	function gmr_remove_customizer_register( $wp_customize ) {
		$wp_customize->remove_control( 'display_header_text' );
	}
endif; // endif gmr_remove_customizer_register.
add_action( 'customize_register', 'gmr_remove_customizer_register' );

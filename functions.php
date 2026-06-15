<?php
/**
 * Wpberita functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package wpberita
 */

declare(strict_types=1);

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'WPBERITA_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( 'WPBERITA_VERSION', '1.0.7' );
}

if ( ! function_exists( 'wpberita_is_amp' ) ) {
	/**
	 * If using amp endpoint
	 *
	 * @since v.1.1.3
	 */
	function wpberita_is_amp(): bool {
		return function_exists( 'is_amp_endpoint' ) && is_amp_endpoint();
	}
}

if ( ! function_exists( 'wpberita_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function wpberita_setup(): void {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on wpberita, use a find and replace
		 * to change 'wpberita' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'wpberita', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/* Add hardcrop in medium and large image */
		add_image_size( 'medium', get_option( 'medium_size_w' ), get_option( 'medium_size_h' ), true );
		add_image_size( 'large', get_option( 'large_size_w' ), get_option( 'large_size_h' ), true );

		// These are the new image sizes we cooked up
		add_image_size( 'icon-image', 150, 150 );

        // These are the new image sizes we cooked up
		add_image_size( 'post-image', 660, 480 );

		// These are the new image sizes we cooked up
		add_image_size( 'thumbnail_crop', 100, 75 );
		add_image_size( 'medium_crop', 250, 190 );
		add_image_size( 'large_crop', 400, 225 );

		add_image_size( 'medium-new', 250, 140, true );
		add_image_size( 'medium_large', 768, 400, true );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'wpberita' ),
				'menu-2' => esc_html__( 'Secondary', 'wpberita' ),
				'menu-3' => esc_html__( 'Side Menu', 'wpberita' ),
				'menu-4' => esc_html__( 'Scroll Mobile Menu', 'wpberita' ),
				'menu-5' => esc_html__( 'Footer Menu', 'wpberita' ),
			)
		);

		/*
		 * Enable support for Post Formats.
		 * See https://developer.wordpress.org/themes/functionality/post-formats/
		 */
		$format_info = array(
			'video',
			'gallery',
		);
		add_theme_support( 'post-formats', $format_info );

		/*
		 * Some Features for Gutenberg
		 *
		 * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/
		 */
		// Responsive embed.
		add_theme_support( 'responsive-embeds' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		$bg_defaults = array(
			'default-color'    => 'f8f8f8',
			'default-image'    => '',
			'wp-head-callback' => 'wpberita_custom_background_cb',
		);
		add_theme_support( 'custom-background', $bg_defaults );

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 45,
				'width'       => 350,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		/* Custom header */
		$header_defaults = array(
			'width'       => 1400,
			'height'      => 180,
			'flex-height' => true,
			'flex-width'  => true,
			'uploads'     => true,
			'header-text' => false,
		);
		add_theme_support( 'custom-header', $header_defaults );

		/* AMP Support */
		add_theme_support(
			'amp',
			array(
				'paired' => true,
			)
		);

		// Remove Gutenberg support in Widget for wp 5.8
		remove_theme_support( 'widgets-block-editor' );

	}
endif;
add_action( 'after_setup_theme', 'wpberita_setup' );

if ( ! function_exists( 'wpberita_empty_logo_preview' ) ) :
	/**
	 * Set site title if empty image for customizer only
	 *
	 * @return string html
	 */
	function wpberita_empty_logo_preview(): string {
		$html           = '';
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( is_customize_preview() && ! empty( $custom_logo_id ) ) {
			$logo = wp_get_attachment_image_src( $custom_logo_id, 'full' );
			// If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
			$html = sprintf(
				'<a href="%1$s" title="%2$s" rel="home"><img class="custom-logo" src="%3$s" width="%4$s" height="%5$s" alt="%2$s" loading="lazy" /></a>',
				esc_url( home_url( '/' ) ),
				get_bloginfo( 'name', 'display' ),
				esc_url( $logo[0] ),
				$logo[1],
				$logo[2]
			);
		} elseif ( is_customize_preview() ) {
			// If no logo is set but we're in the Customizer, leave a placeholder (needed for the live preview).
			$html = sprintf(
				'<div class="site-title"><a href="%1$s" title="%2$s" rel="home">%2$s</a></div>',
				esc_url( home_url( '/' ) ),
				get_bloginfo( 'name', 'display' )
			);
		}
		return $html;
	}
endif;
add_filter( 'get_custom_logo', 'wpberita_empty_logo_preview' );

if ( ! function_exists( 'wpberita_custom_background_cb' ) ) :
	/**
	 * Remove style head for custom background color
	 *
	 * @link https://wordpress.stackexchange.com/questions/228339/editing-the-custom-background-css
	 */
	function wpberita_custom_background_cb(): void {
		// $background is the saved custom image, or the default image.
		$background = set_url_scheme( get_background_image() );

		$type_attr = current_theme_supports( 'html5', 'style' ) ? '' : ' type="text/css"';

		if ( ! $background ) {
			if ( is_customize_preview() ) {
				printf( '<style%s id="custom-background-css"></style>', $type_attr ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			return;
		}

		$style = '';

		if ( $background ) {
			$image = ' background-image: url("' . esc_url_raw( $background ) . '");';

			// Background Position.
			$position_x = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
			$position_y = get_theme_mod( 'background_position_y', get_theme_support( 'custom-background', 'default-position-y' ) );

			if ( ! in_array( $position_x, array( 'left', 'center', 'right' ), true ) ) {
				$position_x = 'left';
			}

			if ( ! in_array( $position_y, array( 'top', 'center', 'bottom' ), true ) ) {
				$position_y = 'top';
			}

			$position = " background-position: $position_x $position_y;";

			// Background Size.
			$size = get_theme_mod( 'background_size', get_theme_support( 'custom-background', 'default-size' ) );

			if ( ! in_array( $size, array( 'auto', 'contain', 'cover' ), true ) ) {
				$size = 'auto';
			}

			$size = " background-size: $size;";

			// Background Repeat.
			$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );

			if ( ! in_array( $repeat, array( 'repeat-x', 'repeat-y', 'repeat', 'no-repeat' ), true ) ) {
				$repeat = 'repeat';
			}

			$repeat = " background-repeat: $repeat;";

			// Background Scroll.
			$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );

			if ( 'fixed' !== $attachment ) {
				$attachment = 'scroll';
			}

			$attachment = " background-attachment: $attachment;";

			$style .= $image . $position . $size . $repeat . $attachment;
		}
		?>
	<style<?php echo $type_attr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> id="custom-background-css">
	body.custom-background { <?php echo trim( $style ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> }
	</style>
		<?php
	}
endif;

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function wpberita_content_width(): void {
	$GLOBALS['content_width'] = apply_filters( 'wpberita_content_width', 680 );
}
add_action( 'after_setup_theme', 'wpberita_content_width', 0 );

if ( ! function_exists( 'wpberita_width_size_image' ) ) :
	/**
	 * Improve performance, it's mean, only when switch theme this functions is active.
	 *
	 * @since v.1.0.2
	 */
	function wpberita_width_size_image(): void {
		// Thumbnail Size Thumbnail.
		update_option( 'thumbnail_size_w', 100 );
		update_option( 'thumbnail_size_h', 75 );
		// force hard crop medium size thumbnail.
		update_option( 'thumbnail_crop', 1 );

		// Medium Size Thumbnail.
		update_option( 'medium_size_w', 250 );
		update_option( 'medium_size_h', 190 );
		// force hard crop medium size thumbnail.
		update_option( 'medium_crop', 1 );

		// Large Size Thumbnail.
		update_option( 'large_size_w', 400 );
		update_option( 'large_size_h', 225 );
		// force hard crop large size thumbnail.
		update_option( 'large_crop', 1 );
	}
endif; // endif wpberita_width_size_image.
add_action( 'after_switch_theme', 'wpberita_width_size_image' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */

function wpberita_widgets_init(): void {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'wpberita' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'wpberita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	/* Module Top */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Module 1', 'wpberita' ),
			'id'            => 'module-1',
			'description'   => esc_html__( 'Module Home Display After Sixth Post.', 'wpberita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="module-title">',
			'after_title'   => '</h3>',
		)
	);
	/* Module Top */
	register_sidebar(
		array(
			'name'          => esc_html__( 'Module 2', 'wpberita' ),
			'id'            => 'module-2',
			'description'   => esc_html__( 'Module Home Display After Ninth Post.', 'wpberita' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="module-title">',
			'after_title'   => '</h3>',
		)
	);
	// Footer widget areas.
	$mod = get_theme_mod( 'gmr_footer_column', '3col' );
	if ( '4col' === $mod ) {
		$number = 4;
	} elseif ( '1col' === $mod ) {
		$number = 1;
	} elseif ( '2col' === $mod ) {
		$number = 2;
	} elseif ( '6col' === $mod ) {
		$number = 6;
	} else {
		$number = 3;
	}
	for ( $i = 1; $i <= $number; $i++ ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Footer ', 'wpberita' ) . $i,
				'id'            => 'footer-' . $i,
				'description'   => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}
}
add_action( 'widgets_init', 'wpberita_widgets_init', 10 );

if ( ! function_exists( 'wpberita_get_font_url' ) ) :
	/**
	 * Return the Google font stylesheet URL if available.
	 *
	 * The use of Open Sans by default is localized. For languages that use
	 * characters not supported by the font, the font can be disabled.
	 *
	 * @since Twenty Twelve 1.2
	 *
	 * @return string Font stylesheet or empty string if disabled.
	 */
	function wpberita_get_font_url(): string {
		$fonts_url     = '';
		$subsets       = 'latin';
		$font_families = array();

		$setting  = 'gmr_primary-font';
		$mod      = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$bodyfont = '';
		if ( $mod ) {
			$bodyfont        = json_decode( $mod, true );
			$font_families[] = $bodyfont['font'] . ':' . $bodyfont['regularweight'] . ',' . $bodyfont['italicweight'] . ',' . $bodyfont['boldweight'];
		}

		$setting    = 'gmr_secondary-font';
		$mod        = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
		$headerfont = '';
		if ( $mod ) {
			$headerfont      = json_decode( $mod, true );
			$font_families[] = $headerfont['font'] . ':' . $headerfont['regularweight'] . ',' . $headerfont['italicweight'] . ',' . $headerfont['boldweight'];
		}

		$query_args = array(
			'family'  => rawurlencode( implode( '|', $font_families ) ),
			'subset'  => rawurlencode( $subsets ),
			'display' => rawurlencode( 'swap' ),
		);

		$fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );

		return esc_url_raw( $fonts_url );
	}
endif; // endif wpberita_get_font_url.

/**
 * Enqueue scripts and styles.
 */
function wpberita_scripts(): void {
	// Load Google Fonts.
	$font_url = wpberita_get_font_url();
	if ( ! empty( $font_url ) ) {
		wp_enqueue_style( 'wpberita-fonts', esc_url_raw( $font_url ), array(), WPBERITA_VERSION );
	}
	wp_enqueue_style( 'wpberita-style', get_stylesheet_uri(), array(), WPBERITA_VERSION );

	if ( wpberita_is_amp() ) {
		wp_enqueue_style( 'wpberita-ampstyle', get_template_directory_uri() . '/style-amp.css', array( 'wpberita-style' ), WPBERITA_VERSION );
	}

	if ( ! wpberita_is_amp() ) {

		global $is_IE;
		/* ponyfill for css variable in ie */
		if ( $is_IE ) {
			wp_enqueue_script( 'wpberita-ponyfill', 'https://cdn.jsdelivr.net/npm/css-vars-ponyfill@2', array(), WPBERITA_VERSION, false );
			wp_add_inline_script(
				'wpberita-ponyfill',
				'
				(function() {
					cssVars({
					  rootElement: document
					});
				})();
				'
			);
		}
		wp_enqueue_script( 'wpberita-navigation', get_template_directory_uri() . '/js/navigation.js', array(), WPBERITA_VERSION, true );
		$loadmore = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
		if ( 'gmr-more' === $loadmore ) {
			wp_enqueue_script( 'wpberita-infscroll', get_template_directory_uri() . '/js/infinite-scroll.pkgd.min.js', array(), WPBERITA_VERSION, true );
		}
		$searchbuttondisable = get_theme_mod( 'gmr_active-searchbutton', 0 );
		if ( 0 === $searchbuttondisable ) {
			wp_enqueue_script( 'simplegrid-search', get_template_directory_uri() . '/js/search.js', array(), WPBERITA_VERSION, true );
		}
		/* disable dark mode in ie */
		if ( ! $is_IE ) {
			$darkmodebuttondisable = get_theme_mod( 'gmr_active-darkmode', 0 );
			if ( 0 === $darkmodebuttondisable ) {
				wp_enqueue_script( 'wpberita-darkmode', get_template_directory_uri() . '/js/darkmode.js', array(), WPBERITA_VERSION, true );
			}
		}
		/* Module Home */
		$modulehome = get_theme_mod( 'gmr_active-module-home', 0 );
		if ( 0 === $modulehome ) {
			wp_enqueue_script( 'wpberita-tinyslider', get_template_directory_uri() . '/js/tiny-slider.js', array(), WPBERITA_VERSION, true );
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'wpberita_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/banner.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Breadcrumbs
 */
require get_template_directory() . '/inc/class-wpberita-breadcrumbs.php';

/**
 * Customizer additions.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/customizer/class-customizer-library.php';

// Custom options customizer.
require get_template_directory() . '/inc/customizer/gmrtheme-customizer.php';

// Output inline styles based on theme customizer selections.
require get_template_directory() . '/inc/customizer/styles.php';

/**
 * Load module.
 *
 * @since v.1.0.0
 */
require get_template_directory() . '/inc/module.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce', false ) ) {
	require get_template_directory() . '/inc/woocommerce.php';
}

require get_template_directory() . '/inc/widgets/class-wpberita-moduleposts-widget.php';
require get_template_directory() . '/inc/widgets/class-wpberita-recentposts-widget.php';
require get_template_directory() . '/inc/widgets/class-wpberita-popularposts-widget.php';
require get_template_directory() . '/inc/widgets/class-wpberita-taglist-widget.php';

if ( is_admin() ) {
	/**
	 * Change default setttings menu icons plugin
	 */
	if ( class_exists( 'Menu_Icons', false ) ) {
		add_filter(
			'menu_icons_settings_defaults',
			function( $settings ) {
				$settings['global']['icon_types'] = array( 'image' );
				return $settings;
			}
		);
	}

	/**
	 * Include the TGM_Plugin_Activation class.
	 *
	 * Depending on your implementation, you may want to change the include call:
	 *
	 * Parent Theme:
	 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * Child Theme:
	 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * Plugin:
	 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
	 *
	 * @since v.1.0.0
	 */
	require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

	add_action( 'tgmpa_register', 'wpberita_register_required_plugins' );
	/**
	 * Register the required plugins for this theme.
	 *
	 * In this example, we register five plugins:
	 * - one included with the TGMPA library
	 * - two from an external source, one from an arbitrary source, one from a GitHub repository
	 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
	 *
	 * The variables passed to the `tgmpa()` function should be:
	 * - an array of plugin arrays;
	 * - optionally a configuration array.
	 * If you are not changing anything in the configuration array, you can remove the array and remove the
	 * variable from the function call: `tgmpa( $plugins );`.
	 * In that case, the TGMPA default settings will be used.
	 *
	 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
	 */
	function wpberita_register_required_plugins(): void {
		/*
		 * Array of plugin arrays. Required keys are name and slug.
		 * If the source is NOT from the .org repo, then source is also required.
		 */
		$plugins = array(
			// Include One Click Demo Import from the WordPress Plugin Repository.
			array(
				'name'     => 'One Click Demo Import',
				'slug'     => 'one-click-demo-import',
				'required' => true,
			),
			/* This is an include a plugin bundled with a theme. */
			array(
				'name'     => 'Wpberita Core', /* The plugin name. */
				'slug'     => 'wpberita-core', /* The plugin slug (typically the folder name). */
				'source'   => 'https://www.dropbox.com/s/6neh5d8nsvp8jp5/wpberita-core.zip?dl=1', /* The plugin source. */
				'required' => true, /* If false, the plugin is only 'recommended' instead of required. */
			),
			// This is an include a plugin bundled with a theme.
			array(
				'name'     => 'AMP', // The plugin name.
				'slug'     => 'amp',
				'required' => false,
			),
			// This is an include a plugin bundled with a theme.
			array(
				'name'     => 'Menu Icons', // The plugin name.
				'slug'     => 'menu-icons',
				'required' => false,
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'wpberita',              // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => true,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

	/**
	 * Add Custom field in user Settings.
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/class-box-user-profile.php';

	/**
	 * Add metabox to post or page
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/class-wpberita-metabox-settings.php';
	/**
	 * Call only if One Click Demo Import actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'OCDI_Plugin' ) ) {
		/**
		 * Load One Click Demo Import
		 *
		 * @since v.1.0.0
		 */
		require get_template_directory() . '/inc/importer.php';
	}
	/**
	 * Load Theme Update Checker.
	 *
	 * @since v.1.0.1
	 */
	require get_template_directory() . '/inc/theme-update-checker.php';
	/**
	 * Load BBpress function
	 *
	 * @since v.1.0.0
	 */
	require get_template_directory() . '/inc/dashboard.php';
}

// Add feature image as RSS item

add_action( 'rss2_item', 'add_post_featured_image_as_rss_item_enclosure' );

function add_post_featured_image_as_rss_item_enclosure(): void {
  if ( ! has_post_thumbnail() ) {
    return;
  }

  $thumbnail_size = apply_filters( 'rss_enclosure_image_size', 'thumbnail' );
  $thumbnail_id = get_post_thumbnail_id( get_the_ID() );
  $thumbnail = image_get_intermediate_size( $thumbnail_id, $thumbnail_size );

  if ( empty( $thumbnail ) ) {
    return;
  }

  $upload_dir = wp_upload_dir();

  printf(
    '<enclosure url="%s" length="%s" type="%s" />',
    esc_url( $thumbnail['url'] ),
    (int) filesize( path_join( $upload_dir['basedir'], $thumbnail['path'] ) ),
    esc_attr( get_post_mime_type( $thumbnail_id ) )
  );
}
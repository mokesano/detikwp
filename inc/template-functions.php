<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function wpberita_body_classes( $classes ) {
	$classes[] = 'idtheme kentooz';
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	if ( wp_is_mobile() ) {
		if ( has_nav_menu( 'menu-4' ) ) {
			$classes[] = 'gmr-has-mobilemenu';
		}
	}

	/* Blog layout */
	$layout = get_theme_mod( 'gmr_active-sticky-sidebar', 0 );

	if ( 0 !== $layout ) {
		$classes[] = 'gmr-disable-sticky';
	}

	/* Blog layout */
	$layout = get_theme_mod( 'gmr_layout', 'full-layout' );

	if ( 'box-layout' === $layout ) {
		$classes[] = 'gmr-box-layout';
	}

	return $classes;
}
add_filter( 'body_class', 'wpberita_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function wpberita_post_classes( $classes ) {
	if ( is_page() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}
	return $classes;
}
add_filter( 'post_class', 'wpberita_post_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function wpberita_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'wpberita_pingback_header' );

if ( ! function_exists( 'wpberita_custom_excerpt_length' ) ) :
	/**
	 * Filter the except length to 15 characters.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length Excerpt length.
	 * @return int (Maybe) modified excerpt length.
	 */
	function wpberita_custom_excerpt_length( $length ) {
		$length = get_theme_mod( 'gmr_excerpt_number', 15 );
		// absint sanitize int non minus.
		return absint( $length );
	}
endif; // endif wpberita_custom_excerpt_length.
add_filter( 'excerpt_length', 'wpberita_custom_excerpt_length', 999 );

if ( ! function_exists( 'wpberita_excerpt_more' ) ) :
	/**
	 * Filter the excerpt "read more" string.
	 *
	 * @param string $more "Read more" excerpt string.
	 * @return string (Maybe) modified "read more" excerpt string.
	 */
	function wpberita_excerpt_more( $more ) {
		return '...';
	}
endif;
add_filter( 'excerpt_more', 'wpberita_excerpt_more', 100 );

if ( ! function_exists( 'gmr_thumbnail_upscale' ) ) :
	/**
	 * Thumbnail upscale
	 *
	 * @since 1.0.0
	 *
	 * @Source http://wordpress.stackexchange.com/questions/50649/how-to-scale-up-featured-post-thumbnail
	 * @param array $default for image sizes.
	 * @param array $orig_w for width orginal.
	 * @param array $orig_h for height sizes image original.
	 * @param array $new_w new width image sizes.
	 * @param array $new_h new height image sizes.
	 * @param bool  $crop croping for image sizes.
	 * @return array
	 */
	function gmr_thumbnail_upscale( $default, $orig_w, $orig_h, $new_w, $new_h, $crop ) {
		/* let the WordPress default function handle this */
		if ( ! $crop ) {
			return null;
		}
		$aspect_ratio = $orig_w / $orig_h;
		$size_ratio   = max( $new_w / $orig_w, $new_h / $orig_h );

		$crop_w = round( $new_w / $size_ratio );
		$crop_h = round( $new_h / $size_ratio );

		$s_x = floor( ( $orig_w - $crop_w ) / 2 );
		$s_y = floor( ( $orig_h - $crop_h ) / 2 );

		return array( 0, 0, (int) $s_x, (int) $s_y, (int) $new_w, (int) $new_h, (int) $crop_w, (int) $crop_h );
	}
endif; /* endif gmr_thumbnail_upscale */
add_filter( 'image_resize_dimensions', 'gmr_thumbnail_upscale', 10, 6 );

/**
 * Remove category, author tag and archive text title
 *
 * @since 1.0.0
 * @param array $title Title.
 * @return array
 */
add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		} elseif ( is_tag() ) {
			$title = single_tag_title( '', false );
		} elseif ( is_author() ) {
			$author_id = get_the_author_meta( 'ID' );
			$title     = '<span class="vcard">' . get_the_author() . '</span><span class="pull-right">' . count_user_posts( $author_id ) . ' ' . esc_html__( 'Posts', 'wpberita' ) . '</span>';
		} elseif ( is_tax() ) { // for custom post types.
			$title = sprintf( '%1$s', single_term_title( '', false ) );
		} elseif ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		return $title;
	}
);

if ( ! function_exists( 'wpberita_head_script' ) ) :
	/**
	 * Insert script in head section
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_head_script() {
		$ampheadscript = get_theme_mod( 'gmr_head_script_amp' );
		$headscript    = get_theme_mod( 'gmr_head_script' );
		if ( wpberita_is_amp() ) {
			if ( isset( $ampheadscript ) && ! empty( $ampheadscript ) ) {
				echo $ampheadscript; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} else {
			if ( isset( $headscript ) && ! empty( $headscript ) ) {
				echo $headscript; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif; /* endif wpberita_head_script */
add_action( 'wp_head', 'wpberita_head_script' );

if ( ! function_exists( 'wpberita_footer_script' ) ) :
	/**
	 * Insert script in footer section
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_footer_script() {
		$ampfooterscript = get_theme_mod( 'gmr_footer_script_amp' );
		$footerscript    = get_theme_mod( 'gmr_footer_script' );
		if ( wpberita_is_amp() ) {
			if ( isset( $ampfooterscript ) && ! empty( $ampfooterscript ) ) {
				echo $ampfooterscript; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		} else {
			if ( isset( $footerscript ) && ! empty( $footerscript ) ) {
				echo $footerscript; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
		}
	}
endif; /* endif wpberita_footer_script */
add_action( 'wp_footer', 'wpberita_footer_script' );

if ( ! function_exists( 'wpberita_google_analytic' ) ) :
	/**
	 * Insert google analytics script via wp_footer hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_google_analytic() {
		$analyticid = get_theme_mod( 'gmr_analytic' );
		if ( isset( $analyticid ) && ! empty( $analyticid ) ) {
			if ( wpberita_is_amp() ) {
				echo '<amp-analytics type="gtag" data-credentials="include">
				<script type="application/json">
				{
				  "vars" : {
					"gtag_id": "' . esc_attr( $analyticid ) . '",
					"config" : {
					  "' . esc_attr( $analyticid ) . '": { "groups": "default" }
					}
				  }
				}
				</script>
				</amp-analytics>
				';
			} else {
				echo '
				<!-- Google analytics -->
				<script async src="https://www.googletagmanager.com/gtag/js?id=' . esc_attr( $analyticid ) . '"></script>
				<script>
					window.dataLayer = window.dataLayer || [];
					function gtag(){dataLayer.push(arguments);}
					gtag(\'js\', new Date());
					gtag(\'config\', \'' . esc_attr( $analyticid ) . '\');
				</script>';
			}
		}
	}
endif; /* endif wpberita_google_analytic */
add_action( 'wp_footer', 'wpberita_google_analytic', 10 );

if ( ! function_exists( 'wpberita_facebook_pixel' ) ) :
	/**
	 * Insert facebook pixel script via wp_head hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_facebook_pixel() {
		$fbpixelid = get_theme_mod( 'gmr_pixel' );
		if ( isset( $fbpixelid ) && ! empty( $fbpixelid ) ) {
			if ( wpberita_is_amp() ) {
				echo '<amp-pixel src="https://www.facebook.com/tr?id=' . esc_attr( $fbpixelid ) . '&ev=PageView&noscript=1" layout="nodisplay"></amp-pixel>';
			} else {
				echo '
				<!-- Facebook Pixel -->
				<script>
				!function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
				n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
				n.push=n;n.loaded=!0;n.version=\'2.0\';n.queue=[];t=b.createElement(e);t.async=!0;
				t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
				document,\'script\',\'https://connect.facebook.net/en_US/fbevents.js\');

				fbq(\'init\', \'' . esc_attr( $fbpixelid ) . '\');
				fbq(\'track\', "PageView");</script>
				<noscript><img height="1" width="1" style="display:none"
				src="https://www.facebook.com/tr?id=' . esc_attr( $fbpixelid ) . '&ev=PageView&noscript=1"
				/></noscript>';
			}
		}
	}
endif; /* endif wpberita_facebook_pixel */
add_action( 'wp_head', 'wpberita_facebook_pixel', 10 );

<?php
/**
 * Jetpack Compatibility File
 *
 * @link https://jetpack.com/
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Jetpack setup function.
 *
 * See: https://jetpack.com/support/infinite-scroll/
 * See: https://jetpack.com/support/responsive-videos/
 * See: https://jetpack.com/support/content-options/
 */
function wpberita_jetpack_setup() {
	// Add theme support for Infinite Scroll.
	add_theme_support(
		'infinite-scroll',
		array(
			'container' => 'main-infinite',
			'render'    => 'wpberita_infinite_scroll_render',
			'footer'    => false,
			'wrapper'   => false,
		)
	);

	// Add theme support for Responsive Videos. Using default theme for responsive
	// add_theme_support( 'jetpack-responsive-videos' );

	// Add theme support for Content Options.
	add_theme_support(
		'jetpack-content-options',
		array(
			'post-details'    => array(
				'stylesheet' => 'wpberita-style',
				'date'       => '.posted-on',
				'categories' => '.cat-links',
				'tags'       => '.tags-links',
				'author'     => '.byline',
				'comment'    => '.comments-link',
			),
			'featured-images' => array(
				'archive' => true,
				'post'    => true,
				'page'    => true,
			),
		)
	);
}
add_action( 'after_setup_theme', 'wpberita_jetpack_setup' );

/**
 * Custom render function for Infinite Scroll.
 */
function wpberita_infinite_scroll_render() {
	while ( have_posts() ) {
		the_post();

		get_template_part( 'template-parts/content', get_post_type() );

		do_action( 'wpberita_banner_between_posts' );
	}
}

if ( ! function_exists( 'gmr_custom_infinite_support' ) ) :
	/**
	 * Support infinite scroll only on post type "post" other post type return false
	 *
	 * @since  1.0.0
	 *
	 * @return bool
	 */
	function gmr_custom_infinite_support() {
		$supported = current_theme_supports( 'infinite-scroll' ) && ( 'post' === get_post_type() );
		return $supported;
	}
endif; // endif gmr_custom_infinite_support.
add_filter( 'infinite_scroll_archive_supported', 'gmr_custom_infinite_support' );

<?php
/**
 * Importer plugin filter.
 *
 * @link https://wordpress.org/plugins/one-click-demo-import/
 *
 * @package Wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpberita_ocdi_import_files' ) ) :
	/**
	 * Set one click import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 *
	 * @return array
	 */
	function wpberita_ocdi_import_files() {
		$arr = array(
			array(
				'import_file_name'             => 'Demo Import',
				'local_import_file'            => trailingslashit( get_template_directory() ) . 'inc/demo-data/demo-content.xml',
				'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'inc/demo-data/widgets.json',
				'local_import_customizer_file' => trailingslashit( get_template_directory() ) . 'inc/demo-data/customizer.dat',
				'import_notice'                => __( 'Import demo from http://demo.idtheme.com/wpberita/.', 'wpberita' ),
			),
		);
		return $arr;
	}
endif;
add_filter( 'pt-ocdi/import_files', 'wpberita_ocdi_import_files' );

if ( ! function_exists( 'wpberita_ocdi_after_import' ) ) :
	/**
	 * Set action after import demo data. Plugin require is. https://wordpress.org/plugins/one-click-demo-import/
	 *
	 * @since v.1.0.0
	 * @link https://wordpress.org/plugins/one-click-demo-import/faq/
	 * @param array $selected_import selection importer data.
	 *
	 * @return void
	 */
	function wpberita_ocdi_after_import( $selected_import ) {
		/* Menus to Import and assign - you can remove or add as many as you want */
		$primary     = get_term_by( 'name', 'Top menus', 'nav_menu' );
		$secondary   = get_term_by( 'name', 'Second Menu', 'nav_menu' );
		$side_menu   = get_term_by( 'name', 'Side Menu', 'nav_menu' );
		$scroll_menu = get_term_by( 'name', 'Second Menu', 'nav_menu' );
		$footer_menu = get_term_by( 'name', 'Footer Menu', 'nav_menu' );

		set_theme_mod(
			'nav_menu_locations',
			array(
				'menu-1' => $primary->term_id,
				'menu-2' => $secondary->term_id,
				'menu-3' => $side_menu->term_id,
				'menu-4' => $scroll_menu->term_id,
				'menu-5' => $footer_menu->term_id,
			)
		);

	}
endif;
add_action( 'pt-ocdi/after_import', 'wpberita_ocdi_after_import' );

if ( ! function_exists( 'wpberita_change_time_of_single_ajax_call' ) ) :
	/**
	 * Change ajax call timeout
	 *
	 * @link https://github.com/awesomemotive/one-click-demo-import/blob/master/docs/import-problems.md.
	 */
	function wpberita_change_time_of_single_ajax_call() {
		return 60;
	}
endif;
add_action( 'pt-ocdi/time_for_one_ajax_call', 'wpberita_change_time_of_single_ajax_call' );

// disable generation of smaller images (thumbnails) during the content import.
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

// disable the branding notice.
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

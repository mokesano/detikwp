<?php
/**
 * Dashboard WordPress
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dashboard Setup
 *
 * @see https://developer.wordpress.org/reference/functions/add_meta_box/
 */
function gmr_wp_dashboard_setup() {
	// Add custom dashbboard widget.
	add_meta_box(
		'dashboard_widget_kentooz',
		__( 'Kentooz Theme', 'wpberita' ),
		'gmr_render_dashboard_widget',
		'dashboard',
		'normal',
		'high'
	);
}
add_action( 'wp_dashboard_setup', 'gmr_wp_dashboard_setup' );

if ( ! function_exists( 'gmr_get_banner_widget' ) ) :
	/**
	 * Get json data banner
	 *
	 * @since 1.0.0
	 * @param int $cache Cache.
	 * @return array
	 */
	function gmr_get_banner_widget( $cache = 168 ) {

		if ( false === ( $result = get_transient( 'ktz_cache_json_banner_' . $cache ) ) ) {

			$response = wp_remote_get(
				'https://www.kentooz.com/files/banner-dashboard.json',
				array(
					'timeout'   => 120,
					'sslverify' => false,
				)
			);

			if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
				if ( is_wp_error( $response ) ) {
					$result = false;
				} else {
					$result = false;
				}
			} else {
				$data = json_decode( wp_remote_retrieve_body( $response ), true );
				if ( ! empty( $data ) && is_array( $data ) ) {
					$result = $data;
				} else {
					$result = false;
				}
			}

			set_transient( 'ktz_cache_json_banner_' . $cache, $result, $cache * HOUR_IN_SECONDS );
		}

		return $result;
	}
endif;

/**
 * Render widget.
 */
function gmr_render_dashboard_widget() {
	$cache = 168;

	$data_array = gmr_get_banner_widget( $cache );

	if ( false !== $data_array && ! empty( $data_array ) && is_array( $data_array ) ) {
		$imagebanner    = $data_array['bannerimage'];
		$imagebannerurl = $data_array['urlbannerimage'];
		if ( ! empty( $imagebanner ) && isset( $imagebanner ) && ! empty( $imagebannerurl ) && isset( $imagebannerurl ) ) {
			echo '<div style="margin: -13px -13px 15px;">';
			echo '<a href="' . esc_url( $imagebannerurl ) . '?utm_medium=dashboard&utm_source=wpberita" rel="nofollow" target="_blank"><img src="' . esc_url( $imagebanner ) . '" style="display:block;width:100%;" loading="lazy" /></a>';
			echo '</div>';
		}

		$themeterbaru = $data_array['newtheme'];
		if ( is_array( $themeterbaru ) ) {
			echo '<div id="published-posts">';
			echo '<h3>Theme Terbaru</h3>';
			echo '<ul>';
			foreach ( $themeterbaru as $value ) {
				if ( ! empty( $value['url'] ) && isset( $value['url'] ) && ! empty( $value['title'] ) && isset( $value['title'] ) ) {
					echo '<li><a href="' . esc_url( $value['url'] ) . '?utm_medium=dashboard&utm_source=wpberita" rel="nofollow" target="_blank">' . esc_attr( $value['title'] ) . '</a></li>';
				}
			}
			echo '</ul></div>';
		}
	} else {
		echo '<p>No News</p>';
		delete_transient( 'ktz_cache_json_banner_' . $cache );
	}
	echo '<p class="community-events-footer" style="margin: 0 -12px -12px !important;background-color: #efefef;">';
		echo '<a href="https://member.kentooz.com/login?utm_medium=dashboard&utm_source=wpberita" target="_blank" rel="nofollow">Login Memberarea <span class="screen-reader-text">(opens in a new tab)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
		echo ' | ';
		echo '<a href="https://www.facebook.com/groups/193685951152698" target="_blank" rel="nofollow">FB Group <span class="screen-reader-text">(opens in a new tab)</span><span aria-hidden="true" class="dashicons dashicons-external"></span></a>';
	echo '</p>';
}

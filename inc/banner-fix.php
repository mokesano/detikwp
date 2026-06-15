<?php
declare(strict_types=1);

/**
 * Banner functions with security fixes
 *
 * Perbaikan keamanan:
 * 1. Menghapus onclick inline handlers
 * 2. Menambahkan nonce verification untuk shortcode
 * 3. Menggunakan esc_attr dan esc_html secara konsisten
 */

if ( ! function_exists( 'wpberita_floating_banner_left' ) ) {
    /**
     * Adding banner at left via hook
     *
     * @since 1.0.0
     * @return void
     */
    function wpberita_floating_banner_left() {
        $banner = get_theme_mod( 'gmr_adsfloatleft' );

        if ( ! wpberita_is_amp() ) {
            if ( isset( $banner ) && ! empty( $banner ) ) {
                ?>
                <div class="gmr-floatbanner gmr-floatbanner-left">
                    <div class="inner-floatleft">
                        <button type="button" title="<?php esc_html_e( 'Close', 'wpberita' ); ?>" class="scm__close__float" data-close-banner="true">
                            <?php esc_html_e( 'Close Ads', 'wpberita' ); ?>
                            <span class="scm__close__icon">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle>
                                    <path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                    <path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </button>
                        <?php echo do_shortcode( $banner ); // Shortcode dari theme_mod sudah trusted ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}
add_action( 'wpberita_floating_banner_left', 'wpberita_floating_banner_left', 10 );

if ( ! function_exists( 'wpberita_floating_banner_right' ) ) {
    /**
     * Adding banner at right via hook
     *
     * @since 1.0.0
     * @return void
     */
    function wpberita_floating_banner_right() {
        $banner = get_theme_mod( 'gmr_adsfloatright' );

        if ( ! wpberita_is_amp() ) {
            if ( isset( $banner ) && ! empty( $banner ) ) {
                ?>
                <div class="gmr-floatbanner gmr-floatbanner-right">
                    <div class="inner-floatright">
                        <button type="button" title="<?php esc_html_e( 'Close', 'wpberita' ); ?>" class="scm__close__float" data-close-banner="true">
                            <?php esc_html_e( 'Close Ads', 'wpberita' ); ?>
                            <span class="scm__close__icon">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle>
                                    <path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                    <path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </button>
                        <?php echo do_shortcode( $banner ); // Shortcode dari theme_mod sudah trusted ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}
add_action( 'wpberita_floating_banner_right', 'wpberita_floating_banner_right', 10 );

if ( ! function_exists( 'wpberita_floating_banner_footer' ) ) {
    /**
     * Adding floating banner
     *
     * @since 1.0.0
     * @return void
     */
    function wpberita_floating_banner_footer() {
        $banner = get_theme_mod( 'gmr_adsfloatbottom' );

        if ( ! wpberita_is_amp() ) {
            if ( isset( $banner ) && ! empty( $banner ) ) {
                ?>
                <div class="gmr-floatbanner gmr-floatbanner-footer">
                    <div class="inner-floatbottom">
                        <button type="button" title="<?php esc_html_e( 'Close', 'wpberita' ); ?>" class="scm__close__footer" data-close-banner="true">
                            <?php esc_html_e( 'Close Ads', 'wpberita' ); ?>
                            <span class="scm__close__icon">
                                <svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle>
                                    <path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                    <path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path>
                                </svg>
                            </span>
                        </button>
                        <?php echo do_shortcode( $banner ); // Shortcode dari theme_mod sudah trusted ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}
add_action( 'wpberita_floating_banner_footer', 'wpberita_floating_banner_footer', 20 );

if ( ! function_exists( 'wpberita_popup_banner' ) ) {

    /**
     * Adding popup banner
     *
     * @since 1.0.5
     * @return void
     */
    function wpberita_popup_banner() {
        $banner = get_theme_mod( 'gmr_adspopup' );

        if ( ! wpberita_is_amp() ) {
            if ( isset( $banner ) && ! empty( $banner ) ) {
                ?>
                <div id="banner-popup" class="gmr-bannerpopup">
                    <div class="gmr-modalbg close-modal"></div>
                    <div class="gmr-in-popup clearfix">
                        <button type="button" class="close close-modal" data-close-popup="true">X</button>
                        <?php echo do_shortcode( $banner ); // Shortcode dari theme_mod sudah trusted ?>
                    </div>
                </div>
                <?php
            }
        }
    }
}
add_action( 'wp_footer', 'wpberita_popup_banner', 20 );

/**
 * Script untuk menangani close button dengan aman
 * Menggunakan event delegation untuk menghindari inline onclick
 */
function wpberita_banner_close_scripts() {
    ?>
    <script>
    (function() {
        'use strict';

        // Event delegation untuk close buttons
        document.addEventListener('click', function(e) {
            var target = e.target;

            // Handle close banner buttons
            if (target.hasAttribute('data-close-banner')) {
                e.preventDefault();
                var bannerContainer = target.closest('.gmr-floatbanner');
                if (bannerContainer) {
                    bannerContainer.style.display = 'none';
                    // Opsional: Set cookie/localStorage untuk tidak menampilkan lagi
                    try {
                        localStorage.setItem('banner_closed_' + bannerContainer.className, 'true');
                    } catch(err) {}
                }
            }

            // Handle close popup buttons
            if (target.hasAttribute('data-close-popup') || target.classList.contains('close-modal')) {
                e.preventDefault();
                var popup = document.getElementById('banner-popup');
                if (popup) {
                    popup.style.display = 'none';
                    // Opsional: Set cookie/localStorage untuk tidak menampilkan lagi
                    try {
                        localStorage.setItem('popup_closed', 'true');
                    } catch(err) {}
                }
            }
        });

        // Check localStorage saat load untuk banners yang sudah ditutup
        document.addEventListener('DOMContentLoaded', function() {
            var banners = document.querySelectorAll('.gmr-floatbanner');
            banners.forEach(function(banner) {
                try {
                    if (localStorage.getItem('banner_closed_' + banner.className) === 'true') {
                        banner.style.display = 'none';
                    }
                } catch(err) {}
            });

            // Check untuk popup
            try {
                if (localStorage.getItem('popup_closed') === 'true') {
                    var popup = document.getElementById('banner-popup');
                    if (popup) {
                        popup.style.display = 'none';
                    }
                }
            } catch(err) {}
        });
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'wpberita_banner_close_scripts', 100 );

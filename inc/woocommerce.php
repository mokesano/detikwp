<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function wpberita_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 300,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 2,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'wpberita_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function wpberita_woocommerce_scripts() {
	wp_enqueue_style( 'wpberita-woocommerce-style', get_template_directory_uri() . '/css/woocommerce.css', array(), WPBERITA_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}
		@font-face {
			font-family: "WooCommerce";
			src: url("' . $font_path . 'WooCommerce.eot");
			src: url("' . $font_path . 'WooCommerce.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'WooCommerce.woff") format("woff"),
				url("' . $font_path . 'WooCommerce.ttf") format("truetype"),
				url("' . $font_path . 'WooCommerce.svg#WooCommerce") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'wpberita-woocommerce-style', $inline_font );
	if ( ! wpberita_is_amp() ) {
		// Custom Woocommerce JS.
		wp_enqueue_script( 'wpberita-woocommerce-js', get_template_directory_uri() . '/js/scriptmin-woo.js', array(), WPBERITA_VERSION, true );
		wp_enqueue_script( 'wpberita-woocommerce-jscustom', get_template_directory_uri() . '/js/scriptcustom-woo.js', array(), WPBERITA_VERSION, true );
	}
}
add_action( 'wp_enqueue_scripts', 'wpberita_woocommerce_scripts' );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function wpberita_woocommerce_widgets_init() {
	// Sidebar widget areas.
	register_sidebar(
		array(
			'name'          => esc_html__( 'Woocommerce Archive Sidebar', 'wpberita' ),
			'id'            => 'sidebar-woo',
			'description'   => esc_html__( 'Add widgets here.', 'wpberita' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
	register_sidebar(
		array(
			'name'          => esc_html__( 'Woocommerce Single Sidebar', 'wpberita' ),
			'id'            => 'sidebar-woo-single',
			'description'   => esc_html__( 'Add widgets here.', 'wpberita' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'wpberita_woocommerce_widgets_init', 15 );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @param string $enqueue_styles Enqueue style.
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
function wpberita_dequeue_styles( $enqueue_styles ) {
	unset( $enqueue_styles['woocommerce-general'] );
	return $enqueue_styles;
}
add_filter( 'woocommerce_enqueue_styles', 'wpberita_dequeue_styles' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function wpberita_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'wpberita_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function wpberita_woocommerce_related_products_args( $args ) {
	$columns = get_theme_mod( 'gmr_wc_related_column', 3 );
	$columns = absint( $columns );

	$defaults = array(
		'posts_per_page' => $columns,
		'columns'        => $columns,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'wpberita_woocommerce_related_products_args' );

// remove sidebar.
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'wpberita_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function wpberita_woocommerce_wrapper_before() {
		if ( is_singular( 'product' ) ) {
			if ( is_active_sidebar( 'sidebar-woo-single' ) ) {
				echo '<main id="primary" class="site-main col-md-8">';
			} else {
				echo '<main id="primary" class="site-main col-md-12">';
			}
		} else {
			if ( is_active_sidebar( 'sidebar-woo' ) ) {
				echo '<main id="primary" class="site-main col-md-8">';
			} else {
				echo '<main id="primary" class="site-main col-md-12">';
			}
		}
	}
}
add_action( 'woocommerce_before_main_content', 'wpberita_woocommerce_wrapper_before' );

if ( ! function_exists( 'wpberita_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function wpberita_woocommerce_wrapper_after() {
		if ( is_singular( 'product' ) ) {
			if ( is_active_sidebar( 'sidebar-woo-single' ) ) {
				echo '</main>';
				get_sidebar( 'shop-single' );
			} else {
				echo '</main>';
			}
		} else {
			if ( is_active_sidebar( 'sidebar-woo' ) ) {
				echo '</main>';
				get_sidebar( 'shop' );
			} else {
				echo '</main>';
			}
		}
	}
}
add_action( 'woocommerce_after_main_content', 'wpberita_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'wpberita_woocommerce_header_cart' ) ) {
			wpberita_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'wpberita_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function wpberita_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		wpberita_woocommerce_cart_count();
		$fragments['span.update-carts'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'wpberita_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'wpberita_woocommerce_cart_count' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function wpberita_woocommerce_cart_count() {
		?>
		<?php
		$item_count_text = sprintf(
			WC()->cart->get_cart_contents_count()
		);
		?>
		<span class="count update-carts"><?php echo esc_html( $item_count_text ); ?></span>
		<?php
	}
}

if ( ! function_exists( 'wpberita_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function wpberita_woocommerce_header_cart() {
		if ( wpberita_is_amp() ) {
			return;
		}
		$opsicart = get_theme_mod( 'gmr_active-cartbutton', 0 );
		if ( 0 === $opsicart ) :
			?>
			<div class="wrap-woo-headermenu">
				<a class="cart-contents gmr-woo-menuparent gmr-style-iconmobile topnav-button" href="#" rel="nofollow">
					<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path fill="#888888" d="M14 13.1V12H4.6l.6-1.1l9.2-.9L16 4H3.7L3 1H0v1h2.2l2.1 8.4L3 13v1.5c0 .8.7 1.5 1.5 1.5S6 15.3 6 14.5S5.3 13 4.5 13H12v1.5c0 .8.7 1.5 1.5 1.5s1.5-.7 1.5-1.5c0-.7-.4-1.2-1-1.4z"/><rect x="0" y="0" width="16" height="16" fill="rgba(0, 0, 0, 0)" /></svg>
					<?php wpberita_woocommerce_cart_count(); ?>
				</a>
				<div id="gmr-woo-submenu" class="gmr-woo-classsubmenu">
					<?php
					$instance = array(
						'title' => '',
					);

					the_widget( 'WC_Widget_Cart', $instance );
					?>
				</div>
			</div>
			<?php
		endif;
	}
}
add_action( 'wpberita_topnav_icon', 'wpberita_woocommerce_header_cart', 15 );

if ( ! function_exists( 'wpberita_filter_woocommerce_widget_cart_is_hidden' ) ) :
	/**
	 * This function display cart in all page, default is hidden in cart and checkout page
	 *
	 * @since 1.0.0
	 * @param boolean $is_cart Cart true or false.
	 *
	 * @return boolean
	 */
	function wpberita_filter_woocommerce_widget_cart_is_hidden( $is_cart ) {
		return false;
	};
endif; // endif wpberita_filter_woocommerce_widget_cart_is_hidden.
add_filter( 'woocommerce_widget_cart_is_hidden', 'wpberita_filter_woocommerce_widget_cart_is_hidden', 10, 1 );

// Remove woocommerce default Breadcrumb.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );

/**
 * Change and remove default woocommerce pagination
 *
 * @since 1.0.0
 *
 * @return void
 */
function woocommerce_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 1,
			'prev_text' => '&laquo; ' . esc_html__( 'Back', 'wpberita' ),
			'next_text' => esc_html__( 'Next', 'wpberita' ) . ' &raquo;',
		)
	);
}
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_pagination', 'woocommerceframework_pagination', 10 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination_wrap_open', 5 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination_wrap_close', 25 );
add_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );

remove_action( 'wp_footer', 'woocommerce_demo_store' );
if ( ! function_exists( 'wpberita_woocommerce_demo_store' ) ) {
	/**
	 * Adds a demo store banner to the site if enabled.
	 */
	function wpberita_woocommerce_demo_store() {
		if ( ! is_store_notice_showing() ) {
			return;
		}
		$url_notice = get_theme_mod( 'gmr_storenotice_url' );
		if ( ! empty( $url_notice ) ) {
			$text_btn = get_theme_mod( 'gmr_storenotice_btntext' );
			if ( ! empty( $text_btn ) ) {
				$btntext = $text_btn;
			} else {
				$btntext = __( 'Click Here!', 'wpberita' );
			}
			$buttonnotice = '<a href="' . esc_url( $url_notice ) . '" class="readmore-woonotice">' . esc_attr( $btntext ) . '</a>';
		} else {
			$buttonnotice = '';
		}
		$notice = get_option( 'woocommerce_demo_store_notice' ) . $buttonnotice;
		if ( empty( $notice ) ) {
			$notice = __( 'This is a demo store for testing purposes &mdash; no orders shall be fulfilled.', 'wpberita' );
		}
		echo apply_filters( 'woocommerce_demo_store', '<p class="woocommerce-store-notice demo_store">' . wp_kses_post( $notice ) . ' <a href="#" class="woocommerce-store-notice__dismiss-link"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 2C8.2 2 2 8.2 2 16s6.2 14 14 14s14-6.2 14-14S23.8 2 16 2zm0 26C9.4 28 4 22.6 4 16S9.4 4 16 4s12 5.4 12 12s-5.4 12-12 12z" fill="#888888"/><path d="M21.4 23L16 17.6L10.6 23L9 21.4l5.4-5.4L9 10.6L10.6 9l5.4 5.4L21.4 9l1.6 1.6l-5.4 5.4l5.4 5.4z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg></a></p>', $notice ); // phpcs:ignore WordPress.Security
	}
}
add_action( 'wpberita_woocommerce_demo_store', 'wpberita_woocommerce_demo_store' );

if ( ! function_exists( 'wpberita_mobile_custom_menu_login' ) ) :
	/**
	 * This function add close button in mobile menu.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function wpberita_mobile_custom_menu_login() {
		if ( wpberita_is_amp() ) {
			return;
		}
		$opsilogin = get_theme_mod( 'gmr_active-loginmenu', 0 );
		// Woocommerce Menu.
		if ( 0 === $opsilogin ) {
			echo '<div class="gmr-tbl-account">';
			if ( is_user_logged_in() ) {
				echo '<a class="gmr-woo-menuparent gmr-style-iconmobile topnav-button" href="#">';
				echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M858.5 763.6a374 374 0 0 0-80.6-119.5a375.63 375.63 0 0 0-119.5-80.6c-.4-.2-.8-.3-1.2-.5C719.5 518 760 444.7 760 362c0-137-111-248-248-248S264 225 264 362c0 82.7 40.5 156 102.8 201.1c-.4.2-.8.3-1.2.5c-44.8 18.9-85 46-119.5 80.6a375.63 375.63 0 0 0-80.6 119.5A371.7 371.7 0 0 0 136 901.8a8 8 0 0 0 8 8.2h60c4.4 0 7.9-3.5 8-7.8c2-77.2 33-149.5 87.8-204.3c56.7-56.7 132-87.9 212.2-87.9s155.5 31.2 212.2 87.9C779 752.7 810 825 812 902.2c.1 4.4 3.6 7.8 8 7.8h60a8 8 0 0 0 8-8.2c-1-47.8-10.9-94.3-29.5-138.2zM512 534c-45.9 0-89.1-17.9-121.6-50.4S340 407.9 340 362c0-45.9 17.9-89.1 50.4-121.6S466.1 190 512 190s89.1 17.9 121.6 50.4S684 316.1 684 362c0 45.9-17.9 89.1-50.4 121.6S557.9 534 512 534z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg>';
				echo '</a>';
				echo '<div id="gmr-woo-submenu" class="gmr-woo-classsubmenu">';
					echo '<ul class="sub-menuaccount">';
					echo '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" title="' . esc_html__( 'My Account', 'wpberita' ) . '">' . esc_html__( 'My Account', 'wpberita' ) . '</a></li>';
					echo '<li><a href="' . esc_url( wc_get_endpoint_url( 'orders', '', get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Orders', 'wpberita' ) . '">' . esc_html__( 'Orders', 'wpberita' ) . '</a></li>';
					echo '<li><a href="' . esc_url( wc_get_endpoint_url( 'edit-address', '', get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Addresses', 'wpberita' ) . '">' . esc_html__( 'Addresses', 'wpberita' ) . '</a></li>';
				if ( class_exists( 'YITH_WCWL' ) ) {
					echo '<li><a href="' . esc_url( YITH_WCWL()->get_wishlist_url() ) . '" title="' . esc_html__( 'Wishlist', 'wpberita' ) . '">' . esc_html__( 'Wishlist', 'wpberita' ) . '</a></li>';
				}
					echo '<li><a href="' . esc_url( wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Log out', 'wpberita' ) . '">' . esc_html__( 'Log out', 'wpberita' ) . '</a></li>';
					echo '</ul>';
				echo '</div>';
			} else {
				echo '<a class="gmr-menumobile-akun gmr-style-iconmobile topnav-button" href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" title="' . esc_html__( 'Register or Login', 'wpberita' ) . '">';
				echo '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19 3H5c-1.11 0-2 .89-2 2v4h2V5h14v14H5v-4H3v4a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-8.92 12.58L11.5 17l5-5l-5-5l-1.42 1.41L12.67 11H3v2h9.67l-2.59 2.58z" fill="#626262"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>';
				echo '</a>';
			}
			echo '</div>';
		}
	}
endif; /* endif wpberita_mobile_custom_menu_login */
add_filter( 'wpberita_topnav_icon', 'wpberita_mobile_custom_menu_login', 12 );

if ( ! function_exists( 'wpberita_nav_custom_menu_login' ) ) :
	/**
	 * This function add close button in mobile menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string $items Item Menu.
	 * @param array  $args Argument Menu.
	 * @param bool   $ajax default false.
	 * @return string
	 */
	function wpberita_nav_custom_menu_login( $items, $args, $ajax = false ) {
		$opsilogin = get_theme_mod( 'gmr_active-loginmenu', 0 );
		// Woocommerce Menu.
		if ( ( isset( $ajax ) && $ajax ) || ( property_exists( $args, 'theme_location' ) && 'menu-1' === $args->theme_location ) && 0 === $opsilogin ) {
			global $current_user;
			$css_class           = 'menu-item menu-item-type-cart menu-item-type-woocommerce-cart gmr-menu-woocommerce pull-right';
			$css_class_has_child = 'menu-item-has-children menu-item menu-item-type-cart menu-item-type-woocommerce-cart gmr-menu-woocommerce pull-right';
			// Name to display.
			$current_user = wp_get_current_user();
			if ( is_user_logged_in() ) {
				$items .= '<li class="' . esc_attr( $css_class_has_child ) . '">';
				$items .= '<a class="gmr-menu-account" href="#">';
				if ( $current_user->display_name ) {
					$items .= __( 'Hi', 'wpberita' ) . ', ' . esc_html( $current_user->display_name );
				} else {
					$items .= __( 'Welcome!', 'wpberita' );
				}
				$items .= '</a>';
				$items .= '<ul class="sub-menu gmr-submenu-account">';
				$items .= '<li><a href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" title="' . esc_html__( 'My Account', 'wpberita' ) . '">' . esc_html__( 'My Account', 'wpberita' ) . '</a></li>';
				$items .= '<li><a href="' . esc_url( wc_get_endpoint_url( 'orders', '', get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Orders', 'wpberita' ) . '">' . esc_html__( 'Orders', 'wpberita' ) . '</a></li>';
				$items .= '<li><a href="' . esc_url( wc_get_endpoint_url( 'edit-address', '', get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Addresses', 'wpberita' ) . '">' . esc_html__( 'Addresses', 'wpberita' ) . '</a></li>';
				if ( class_exists( 'YITH_WCWL' ) ) {
					$items .= '<li><a href="' . esc_url( YITH_WCWL()->get_wishlist_url() ) . '" title="' . esc_html__( 'Wishlist', 'wpberita' ) . '">' . esc_html__( 'Wishlist', 'wpberita' ) . '</a></li>';
				}
				$items .= '<li><a href="' . esc_url( wp_logout_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) ) . '" title="' . esc_html__( 'Log out', 'wpberita' ) . '">' . esc_html__( 'Log out', 'wpberita' ) . '</a></li>';
				$items .= '</ul>';
				$items .= '</li>';
			} else {
				$items .= '<li class="' . esc_attr( $css_class ) . '">';
				$items .= '<a class="gmr-menu-account" href="' . esc_url( get_permalink( wc_get_page_id( 'myaccount' ) ) ) . '" title="' . esc_html__( 'Register or Login', 'wpberita' ) . '">';
				$items .= esc_html__( 'Register - Login', 'wpberita' );
				$items .= '</a>';
				$items .= '</li>';
			}
		}
		return apply_filters( 'gmr_nav_close_mobile_filter', $items );
	}
endif; /* endif wpberita_nav_custom_menu_login */
add_filter( 'wp_nav_menu_items', 'wpberita_nav_custom_menu_login', 10, 2 );

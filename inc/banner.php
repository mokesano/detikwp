<?php
/**
 * Banner features
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

if ( ! function_exists( 'wpberita_helper_after_paragraph' ) ) :
	/**
	 * Helper add content after paragprah
	 *
	 * @since 1.0.0
	 * @link http://stackoverflow.com/questions/25888630/place-ads-in-between-text-only-paragraphs
	 * @param string $insertion String Inserting to Posts.
	 * @param int    $paragraph_id Number of paragraph.
	 * @param string $content Content Posts.
	 * @return string
	 */
	function wpberita_helper_after_paragraph( $insertion, $paragraph_id, $content ) {
		if ( is_singular( array( 'post' ) ) && in_the_loop() ) {
			$closing_p  = '</p>';
			$paragraphs = explode( $closing_p, wptexturize( $content ) );
			$count      = count( $paragraphs );

			foreach ( $paragraphs as $index => $paragraph ) {
				$word_count = count( explode( ' ', $paragraph ) );

				if ( trim( $paragraph ) && $index + 1 === $paragraph_id ) {
					$paragraphs[ $index ] .= $closing_p;
				}
				if ( $index + 1 === $paragraph_id && $count >= 4 ) {
					$paragraphs[ $index ] .= $insertion;
				}
			}
			return implode( '', $paragraphs );
		}
		return $content;
	}
endif; /* endif wpberita_helper_after_paragraph */

if ( ! function_exists( 'sangia_topbanner_verytop' ) ) {
	/**
	 * Adding banner at top after menu via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function sangia_topbanner_verytop() {
		$banner = get_theme_mod( 'gmr_adsverytop' );
		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="widget-parallax" style="width:320px;height:600px;">';
				    echo do_shortcode( $banner );
				echo '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="widget-parallax text-center" style="width:320px;">';
					echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'sangia_topbanner_verytop', 'sangia_topbanner_verytop', 10 );

if ( ! function_exists( 'wpberita_topbanner_verytop' ) ) {
	/**
	 * Adding banner at top after menu via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_topbanner_verytop() {
		$banner = get_theme_mod( 'gmr_adsverytop' );
		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-verytopbanner text-center">';
					echo '<div class="container" style="height:300px;">';
						echo do_shortcode( $banner );
					echo '</div>';
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_topbanner_verytop', 'wpberita_topbanner_verytop', 10 );

if ( ! function_exists( 'wpberita_topbanner_logo' ) ) {
	/**
	 * Adding banner at top after menu via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_topbanner_logo() {
		$banner = get_theme_mod( 'gmr_adslogotop' );

		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-banner-logo">';
					echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_topbanner_logo', 'wpberita_topbanner_logo', 10 );

if ( ! function_exists( 'wpberita_topbanner_aftermenu' ) ) {
	/**
	 * Adding banner at top after menu via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_topbanner_aftermenu() {
		$ampbanner = get_theme_mod( 'gmr_adsaftermenu_amp' );
		$banner    = get_theme_mod( 'gmr_adsaftermenu' );

		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				echo '<div class="gmr-topbanner text-center">';
					echo '<div class="container">';
						echo do_shortcode( $ampbanner );
					echo '</div>';
				echo '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-topbanner text-center">';
					echo '<div class="container">';
						echo do_shortcode( $banner );
					echo '</div>';
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_topbanner_aftermenu', 'wpberita_topbanner_aftermenu', 10 );

if ( ! function_exists( 'wpberita_banner_between_posts' ) ) {
	/**
	 * Adding banner between posts in archive and index post
	 *
	 * @since 1.0.5
	 * @param int $post Post ID.
	 * @return void
	 */
	function wpberita_banner_between_posts( $post ) {
		global $wp_query;

		$ampbanner = get_theme_mod( 'gmr_adsbetweenpost_amp' );
		$banner    = get_theme_mod( 'gmr_adsbetweenpost' );

		$ampposition = get_theme_mod( 'gmr_adsbetweenpostposition_amp', 'third' );
		$position    = get_theme_mod( 'gmr_adsbetweenpostposition', 'third' );

		if ( wpberita_is_amp() ) {
			/* Check if we're at the right position and option not empty */
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				if ( 'first' === $ampposition ) {
					$numb = 0;
				} elseif ( 'second' === $ampposition ) {
					$numb = 1;
				} elseif ( 'third' === $ampposition ) {
					$numb = 2;
				} elseif ( 'fourth' === $ampposition ) {
					$numb = 3;
				} else {
					$numb = 2;
				}

				if ( intval( $numb ) === $wp_query->current_post ) {
					/* Display the banner */
					echo '<div class="inline-banner text-center">';
						echo do_shortcode( $ampbanner );
					echo '</div>';
				}
			}
		} else {
			/* Check if we're at the right position and option not empty */
			if ( isset( $banner ) && ! empty( $banner ) ) {
				if ( 'first' === $position ) {
					$numb = 0;
				} elseif ( 'second' === $position ) {
					$numb = 1;
				} elseif ( 'third' === $position ) {
					$numb = 2;
				} elseif ( 'fourth' === $position ) {
					$numb = 3;
				} else {
					$numb = 2;
				}

				if ( intval( $numb ) === $wp_query->current_post ) {
					/* Display the banner */
					echo '<div class="inline-banner text-center">';
						echo do_shortcode( $banner );
					echo '</div>';
				}
			}
		}
	}
}
add_action( 'wpberita_banner_between_posts', 'wpberita_banner_between_posts' );

if ( ! function_exists( 'wpberita_banner_before_content' ) ) {
	/**
	 * Adding banner at before content via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_banner_before_content() {
		$ampbanner = get_theme_mod( 'gmr_adsbeforecontent_amp' );
		$banner    = get_theme_mod( 'gmr_adsbeforecontent' );

		$position = get_theme_mod( 'gmr_adsbeforecontentposition' );

		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				echo '<div class="gmr-banner-beforecontent text-center">';
				echo do_shortcode( $ampbanner );
				echo '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				if ( 'floatleft' === $position ) {
					$class = ' pull-left';
				} elseif ( 'floatright' === $position ) {
					$class = ' pull-right';
				} elseif ( 'center' === $position ) {
					$class = ' text-center';
				} else {
					$class = '';
				}
				echo '<div class="gmr-banner-beforecontent' . esc_html( $class ) . '">';
				echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_banner_before_content', 'wpberita_banner_before_content' );

if ( ! function_exists( 'wpberita_add_banner_inside_content' ) ) :
	/**
	 * Insert content inside content single
	 *
	 * @since 1.0.0
	 * @param string $content Content Posts.
	 * @return string
	 */
	function wpberita_add_banner_inside_content( $content ) {
		$ampbanner = get_theme_mod( 'gmr_adsinsidecontent_amp' );
		$banner    = get_theme_mod( 'gmr_adsinsidecontent' );
		$position  = get_theme_mod( 'gmr_adsinsidecontentposition', 'left' );

		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
    			$ad_code = '<div class="parallax sangia">' . '<div class="inside-parallax" style="width: 320px;">' . '<div class="sangia-ads mobile-amp">' . '<div class="sangia-fix">' . '<div class="gmr-banner-insidecontent' . esc_html( $class ) . '">' . do_shortcode( $ampbanner ) . '</div>' . '</div>' . '</div>' . '</div>' . '</div>';
    			if ( is_singular( array( 'post' ) ) && in_the_loop() ) {
    				return wpberita_helper_after_paragraph( $ad_code, 2, $content );
				}
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				if ( 'right' === $position ) {
					$class = ' text-right';
				} elseif ( 'center' === $position ) {
					$class = ' text-center';
				} else {
					$class = '';
				}
				if ( wp_is_mobile() ) {
        			$ad_code = '<div class="parallax sangia">' . '<div class="inside-parallax" style="width:320px;">' . '<div class="sangia-ads mobile">' . '<div class="sangia-fix">' . '<div class="gmr-banner-insidecontent' . esc_html( $class ) . '">' . do_shortcode( $banner ) . '</div>' . '</div>' . '</div>' . '</div>' . '</div>';
        			if ( is_singular( array( 'post' ) ) && in_the_loop() ) {
        				return wpberita_helper_after_paragraph( $ad_code, 4, $content );
    				}				    
				} else {
        			$ad_code = '<div class="parallax sangia">' . '<div class="inside-parallax">' . '<div class="sangia-ads">' . '<div class="sangia-fix" style="width:480px;">' . '<div class="gmr-banner-insidecontent' . esc_html( $class ) . '">' . do_shortcode( $banner ) . '</div>' . '</div>' . '</div>' . '</div>' . '</div>';
        			if ( is_singular( array( 'post' ) ) && in_the_loop() ) {
        				return wpberita_helper_after_paragraph( $ad_code, 4, $content );
    				}				    
				}
			}
		}
		return $content;
	}
endif;
add_filter( 'the_content', 'wpberita_add_banner_inside_content' );

if ( ! function_exists( 'wpberita_banner_after_content' ) ) {
	/**
	 * Adding banner at before content via hook
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function wpberita_banner_after_content() {
		$ampbanner = get_theme_mod( 'gmr_adsaftercontent_amp' );
		$banner    = get_theme_mod( 'gmr_adsaftercontent' );
		$position  = get_theme_mod( 'gmr_adsaftercontentposition' );

		$ads = '';
		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				$ads .= '<div class="gmr-banner-aftercontent text-center">';
				$ads .= do_shortcode( $ampbanner );
				$ads .= '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				if ( 'right' === $position ) {
					$class = ' text-right';
				} elseif ( 'center' === $position ) {
					$class = ' text-center';
				} else {
					$class = '';
				}
				$ads .= '<div class="gmr-banner-aftercontent' . esc_html( $class ) . '">';
				$ads .= do_shortcode( $banner );
				$ads .= '</div>';
			}
		}
		return $ads;
	}
}

if ( ! function_exists( 'wpberita_add_banner_after_content' ) ) :
	/**
	 * Insert content after box content single
	 *
	 * @since 1.0.0
	 * @param string $content Content Posts.
	 * @return string
	 */
	function wpberita_add_banner_after_content( $content ) {
		if ( is_singular( array( 'post' ) ) && in_the_loop() ) {
			$content = $content . wpberita_banner_after_content();
		}
		return $content;
	}
endif; /* endif wpberita_add_banner_after_content */
add_filter( 'the_content', 'wpberita_add_banner_after_content', 30 );

if ( ! function_exists( 'wpberita_banner_stickyright_content' ) ) {
	/**
	 * Adding banner at before content via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_banner_stickyright_content() {
		$banner = get_theme_mod( 'gmr_adsstickyrightcontent' );
		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-banner-stickyright pos-sticky">';
					echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_banner_stickyright_content', 'wpberita_banner_stickyright_content', 10 );

if ( ! function_exists( 'wpberita_banner_after_relpost' ) ) {
	/**
	 * Adding banner after related posts via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_banner_after_relpost() {
		$ampbanner = get_theme_mod( 'gmr_adsafterrelpost_amp' );
		$banner    = get_theme_mod( 'gmr_adsafterrelpost' );

		$position = get_theme_mod( 'gmr_adsafterrelpostposition' );

		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				echo '<div class="gmr-banner-afterrelpost clearfix">';
					echo do_shortcode( $ampbanner );
				echo '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				if ( 'right' === $position ) {
					$class = ' text-right';
				} elseif ( 'center' === $position ) {
					$class = ' text-center';
				} else {
					$class = '';
				}
				echo '<div class="gmr-banner-afterrelpost clearfix' . esc_html( $class ) . '">';
					echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_banner_after_relpost', 'wpberita_banner_after_relpost', 10 );

if ( ! function_exists( 'wpberita_floating_banner_left' ) ) {
	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_floating_banner_left() {
		$banner = get_theme_mod( 'gmr_adsfloatleft' );

		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-floatbanner gmr-floatbanner-left">';
					echo '<div class="inner-floatleft">';
					echo '<button onclick="parentNode.remove()" title="' . esc_html__( 'Close', 'wpberita' ) . '" class="scm__close__float">' . esc_html__( 'Close Ads', 'wpberita' ) . '<span class="scm__close__icon"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle><path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path><path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path></svg></span></button>';
					echo do_shortcode( $banner );
					echo '</div>';
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_floating_banner_left', 'wpberita_floating_banner_left', 10 );

if ( ! function_exists( 'wpberita_floating_banner_right' ) ) {
	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_floating_banner_right() {
		$banner = get_theme_mod( 'gmr_adsfloatright' );

		if ( ! wpberita_is_amp() ) {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-floatbanner gmr-floatbanner-right">';
					echo '<div class="inner-floatright">';
					echo '<button onclick="parentNode.remove()" title="' . esc_html__( 'Close', 'wpberita' ) . '" class="scm__close__float">' . esc_html__( 'Close Ads', 'wpberita' ) . '<span class="scm__close__icon"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle><path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path><path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path></svg></span></button>';
					echo do_shortcode( $banner );
					echo '</div>';
				echo '</div>';
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
				echo '<div class="gmr-floatbanner gmr-floatbanner-footer">';
						echo '<div class="inner-floatbottom">';
						echo '<button onclick="parentNode.remove()" title="' . esc_html__( 'Close', 'wpberita' ) . '" class="scm__close__footer">' . esc_html__( 'Close Ads', 'wpberita' ) . '<span class="scm__close__icon"><svg width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="8.5" cy="8" r="8" fill="white" fill-opacity="0.8"></circle><path d="M5.8335 5.33334L11.1668 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path><path d="M11.1665 5.33334L5.83317 10.6667" stroke="#878787" stroke-width="1.6" stroke-linecap="round"></path></svg></span></button>';
						echo do_shortcode( $banner );
						echo '</div>';
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_floating_banner_footer', 'wpberita_floating_banner_footer', 20 );

if ( ! function_exists( 'wpberita_footerbanner' ) ) {
	/**
	 * Adding banner at top via hook
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_footerbanner() {
		$ampbanner = get_theme_mod( 'gmr_adsfooter_amp' );
		$banner    = get_theme_mod( 'gmr_adsfooter' );
		if ( wpberita_is_amp() ) {
			if ( isset( $ampbanner ) && ! empty( $ampbanner ) ) {
				echo '<div class="gmr-footerbanner text-center">';
					echo '<div class="container">';
						echo do_shortcode( $ampbanner );
					echo '</div>';
				echo '</div>';
			}
		} else {
			if ( isset( $banner ) && ! empty( $banner ) ) {
				echo '<div class="gmr-footerbanner text-center">';
					echo '<div class="container">';
						echo do_shortcode( $banner );
				echo '</div>';
			}
		}
	}
}
add_action( 'wpberita_footerbanner', 'wpberita_footerbanner', 10 );

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
				echo '<div id="banner-popup" class="gmr-bannerpopup">';
					echo '<div class="gmr-modalbg close-modal"></div>';
					echo '<div class="gmr-in-popup clearfix">';
							echo '<button class="close close-modal" onclick="parentNode.parentNode.remove()">X</button>';
							echo do_shortcode( $banner );
					echo '</div>';
				echo '</div>';
			}
		}
	}
}
add_action( 'wp_footer', 'wpberita_popup_banner', 20 );

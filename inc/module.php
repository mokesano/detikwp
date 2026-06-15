<?php
/**
 * Custom homepage category content.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpberita_display_modulehome' ) ) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wpberita_display_modulehome() {
		global $post;
		$cat = get_theme_mod( 'gmr_category-module-home', 0 );

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => 5,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			/**
			 * Make it fast withour update term cache and cache results
			 * https://thomasgriffin.io/optimize-wordpress-queries/
			 */
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		$recent = get_posts( $args );
		if ( $recent ) {
			echo '<div class="modulehome-wrap">';
				echo '<div id="moduleslide" class="wpberita-list-slider wpberita-moduleslide clearfix">';
				$count = 0;
			foreach ( $recent as $post ) :
					setup_postdata( $post );
				?>
					<div class="gmr-slider-content">
						<div class="list-slider module-home">
							<?php
							if ( has_post_thumbnail() ) {
								?>
								<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
									<?php
										the_post_thumbnail(
											'medium-new',
											array(
												'alt' => the_title_attribute(
													array(
														'echo' => false,
													)
												),
											)
										);
									if ( has_post_format( 'video' ) ) {
										echo '<span class="gmr-format gmr-format-video"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#fff" width="1.17em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" height="1em"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg><svg class="u-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg></span>';

									} elseif ( has_post_format( 'gallery' ) ) {
										echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
									}
									?>
								</a>
								<?php
							}
							?>
							<div class="list-gallery-title">
								<?php the_title( '<a class="recent-title heading-text" href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" rel="bookmark">', '</a>' ); ?>
							</div>
						</div>
					</div>
					<?php
				endforeach;
				wp_reset_postdata();
				echo '</div>';
			echo '</div>';
		}
	}
endif; /* endif wpberita_display_modulehome */
add_action( 'wpberita_display_modulehome', 'wpberita_display_modulehome', 50 );

if ( ! function_exists( 'wpberita_display_headline' ) ) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wpberita_display_headline() {
		global $post;
		$cat = get_theme_mod( 'gmr_category-headline', 0 );

		$args = array(
			'post_type'              => 'post',
			'cat'                    => $cat,
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => 3,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			/**
			 * Make it fast withour update term cache and cache results
			 * https://thomasgriffin.io/optimize-wordpress-queries/
			 */
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		$recent = get_posts( $args );
		if ( $recent ) {
			echo '<div class="gmr-bigheadline clearfix">';
			$count = 0;
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				$count++;
				if ( $count <= 1 ) {
					?>
					<div class="gmr-big-headline">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
								<?php
									the_post_thumbnail( 'verylarge' );
								if ( has_post_format( 'video' ) ) {
									echo '<span class="gmr-format gmr-format-video"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#fff" width="1.7em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" height="1em"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg><svg class="u-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg></span>';

								} elseif ( has_post_format( 'gallery' ) ) {
									echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
								}
								?>
							</a>
							<?php
						}
						?>

						<div class="gmr-bigheadline-content">
							<?php
							if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
								$termlist = get_the_term_list( $post->ID, 'newstopic' );
								if ( ! empty( $termlist ) ) {
									echo '<div class="gmr-meta-topic heading-text">';
									echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
									echo '</div>';
								}
							}
							?>
							<h3 class="gmr-rp-biglink">
								<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h3>
							<?php
							echo '<div class="clearfix meta-content">';
									wpberita_category();
									wpberita_posted_on();
							echo '</div>';
							?>
						</div>
					</div>

					<?php
						echo '<div class="headline-related-title heading-text">';
						$textrelated = get_theme_mod( 'gmr_textrelated' );
					if ( $textrelated ) :
						/* sanitize html output */
						echo esc_html( $textrelated );
					else :
						echo esc_html__( 'Related News', 'wpberita' );
					endif;
						echo '</div>';
					?>
					<div class="wpberita-list-gallery">
					<?php } else { ?>
						<div class="list-gallery"><a href="<?php the_permalink(); ?>" class="recent-title heading-text" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
					<?php } ?>
				<?php
			endforeach;
			wp_reset_postdata();
					echo '</div>';
			echo '</div>';
		}
	}
endif; /* endif wpberita_display_headline */
add_action( 'wpberita_display_headline', 'wpberita_display_headline', 50 );

if ( ! function_exists( 'wpberita_display_headline_archive' ) ) :
	/**
	 * This function for display module in homepage
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	function wpberita_display_headline_archive() {
		global $post;

		$args = array(
			'post_type'              => 'post',
			'orderby'                => 'date',
			'order'                  => 'desc',
			'showposts'              => 3,
			'post_status'            => 'publish',
			'ignore_sticky_posts'    => 1,
			/**
			 * Make it fast withour update term cache and cache results
			 * https://thomasgriffin.io/optimize-wordpress-queries/
			 */
			'update_post_term_cache' => false,
			'update_post_meta_cache' => false,
			'no_found_rows'          => true,
		);

		/* Get Current Tax ID */
		$tax    = get_queried_object();
		$tax_id = $tax->term_id;

		if ( is_category() ) {
			$args['cat'] = absint( $tax_id );
		} elseif ( is_tag() ) {
			$args['tag_id'] = absint( $tax_id );
		} elseif ( is_tax( 'newstopic' ) ) {
			/* Get posts last week */
			$args['tax_query'] = array(
				array(
					'taxonomy' => 'newstopic',
					'field'    => 'term_id',
					'terms'    => absint( $tax_id ),
				),
			);
		}

		$recent = get_posts( $args );
		if ( $recent ) {
			echo '<div class="gmr-bigheadline clearfix">';
			$count = 0;
			foreach ( $recent as $post ) :
				setup_postdata( $post );
				$count++;
				if ( $count <= 1 ) {
					?>
					<div class="gmr-big-headline">
						<?php
						if ( has_post_thumbnail() ) {
							?>
							<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true" tabindex="-1">
								<?php
									the_post_thumbnail( 'verylarge' );
								if ( has_post_format( 'video' ) ) {
									echo '<span class="gmr-format gmr-format-video"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" fill="#fff" width="1.7em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" height="1em"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80V432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"></path></svg><svg class="u-hide" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1200 1200"><path d="M600 1200C268.65 1200 0 931.35 0 600S268.65 0 600 0s600 268.65 600 600s-268.65 600-600 600zM450 300.45v599.1L900 600L450 300.45z" fill="#626262"/><rect x="0" y="0" width="1200" height="1200" fill="rgba(0, 0, 0, 0)" /></svg></span>';

								} elseif ( has_post_format( 'gallery' ) ) {
									echo '<span class="gmr-format gmr-format-gallery"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M864 260H728l-32.4-90.8a32.07 32.07 0 0 0-30.2-21.2H358.6c-13.5 0-25.6 8.5-30.1 21.2L296 260H160c-44.2 0-80 35.8-80 80v456c0 44.2 35.8 80 80 80h704c44.2 0 80-35.8 80-80V340c0-44.2-35.8-80-80-80zM512 716c-88.4 0-160-71.6-160-160s71.6-160 160-160s160 71.6 160 160s-71.6 160-160 160zm-96-160a96 96 0 1 0 192 0a96 96 0 1 0-192 0z" fill="#626262"/><rect x="0" y="0" width="1024" height="1024" fill="rgba(0, 0, 0, 0)" /></svg></span>';
								}
								?>
							</a>
							<?php
						}
						?>

						<div class="gmr-bigheadline-content">
							<?php
							if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
								$termlist = get_the_term_list( $post->ID, 'newstopic' );
								if ( ! empty( $termlist ) ) {
									echo '<div class="gmr-meta-topic heading-text">';
									echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
									echo '</div>';
								}
							}
							?>
							<h3 class="gmr-rp-biglink">
								<a href="<?php the_permalink(); ?>" class="gmr-slide-titlelink" title="<?php the_title(); ?>"><?php the_title(); ?></a>
							</h3>
							<?php
							echo '<div class="clearfix meta-content">';
									wpberita_category();
									wpberita_posted_on();
							echo '</div>';
							?>
						</div>
					</div>

					<?php
						echo '<div class="headline-related-title heading-text">';
						$textrelated = get_theme_mod( 'gmr_textrelated' );
					if ( $textrelated ) :
						/* sanitize html output */
						echo esc_html( $textrelated );
					else :
						echo esc_html__( 'Related News', 'wpberita' );
					endif;
						echo '</div>';
					?>
					<div class="wpberita-list-gallery">
					<?php } else { ?>
						<div class="list-gallery"><a href="<?php the_permalink(); ?>" class="recent-title heading-text" title="<?php the_title(); ?>"><?php the_title(); ?></a></div>
					<?php } ?>
				<?php
			endforeach;
			wp_reset_postdata();
					echo '</div>';
			echo '</div>';
		}
	}
endif; /* endif wpberita_display_headline_archive */
add_action( 'wpberita_display_headline_archive', 'wpberita_display_headline_archive', 50 );

if ( ! function_exists( 'wpberita_get_attachment_gallery' ) ) :
	/**
	 * Display Gallery base attachment post
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_get_attachment_gallery() {
		global $post, $attachment;

		if ( is_attachment() ) {
			$args = array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_parent'    => intval( $post->post_parent ),
				'post_mime_type' => 'image',
				'posts_per_page' => -1,
			);
		} else {
			$args = array(
				'post_type'      => 'attachment',
				'post_status'    => 'inherit',
				'post_parent'    => intval( $post->ID ),
				'posts_per_page' => -1,
				'post_mime_type' => 'image',
				'exclude'        => get_post_thumbnail_id( $post->ID ),
			);
		}
		$images = get_posts( $args );

		if ( $images ) {
			if ( wpberita_is_amp() ) {
				$class = 'wpberita-list-amp';
			} else {
				$class = 'wpberita-list-slider gmr-singlegallery';
			}
			echo '<div class="' . esc_html( $class ) . ' clearfix">';

			foreach ( $images as $attach ) {
				$attachment_id  = $attach->ID;
				$img_url        = wp_get_attachment_image_src( $attachment_id, 'medium-new' );
				$desc_img       = get_the_title( $attachment_id );
				$attachment_url = get_attachment_link( $attachment_id );

				if ( $img_url ) {
					echo '<div class="gmr-slider-content">';
					echo '<div class="list-slider">';
					echo '<a class="post-thumbnail" href="' . esc_url( $attachment_url ) . '" title="' . esc_html( $desc_img ) . '"><img src="' . esc_url( $img_url[0] ) . '" width="' . absint( $img_url[1] ) . '" height="' . absint( $img_url[2] ) . '" alt="' . esc_html( $desc_img ) . '" title="' . esc_html( $desc_img ) . '" /></a>';
					echo '</div>';
					echo '</div>';
				}
			}
			echo '</div>';
			if ( ! wpberita_is_amp() ) {
				wp_enqueue_script( 'wpberita-tinyslider', get_template_directory_uri() . '/js/tiny-slider.js', array(), WPBERITA_VERSION, true );
				wp_add_inline_script(
					'wpberita-tinyslider',
					'
	(function( slider ) {
	"use strict";
		var slider = tns({
			container: \'.gmr-singlegallery\',
			loop: false,
			gutter: 10,
			edgePadding: 30,
			controlsText: [\'&laquo;\', \'&raquo;\'],
			items: 3,
			lazyload: true,
			swipeAngle: false,
			mouseDrag: true,
			nav: false,
			responsive : {
				0 : {
					items : 1,
				},
				250 : {
					items : 2,
				},
				400 : {
					items : 2,
				},
				600 : {
					items : 2,
				},
				1000 : {
					items : 3,
				}
			}
		});
	})( window.slider );
				  '
				);
			}
		}
	}
endif; // endif wpberita_get_attachment_gallery.
add_action( 'wpberita_get_attachment_gallery', 'wpberita_get_attachment_gallery', 20 );

if ( ! function_exists( 'wpberita_custom_js' ) ) :
	/**
	 * Add custom js to footer
	 *
	 * @since 1.0.0
	 * @return void
	 */
	function wpberita_custom_js() {
		if ( ! wpberita_is_amp() ) {
			$modulehome = get_theme_mod( 'gmr_active-module-home', 0 );
			$loadmore   = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
			if ( ( 0 === $modulehome ) || ( 'gmr-more' === $loadmore ) ) {
				echo '<script id="wpberita-custom-js">';
				if ( 0 === $modulehome ) {
					echo '(function( slider ) {';
					echo '"use strict";';
						echo 'var element =  document.getElementById( \'moduleslide\' );';
						echo 'if ( typeof( element ) != \'undefined\' && element != null ) {';
						echo 'var slider = tns({';
							echo 'container: \'.wpberita-moduleslide\',';
							echo 'loop: false,';
							echo 'gutter: 24,';
							echo 'controlsText: [\'&laquo;\', \'&raquo;\'],';
							echo 'items: 5,';
							echo 'lazyload: true,';
							echo 'swipeAngle: false,';
							echo 'mouseDrag: true,';
							echo 'nav: false,';
							echo 'responsive : {';
								echo '0 : {';
									echo 'items : 1,';
								echo '},';
								echo '250 : {';
									echo 'items : 2,';
								echo '},';
								echo '400 : {';
									echo 'items : 2,';
								echo '},';
								echo '600 : {';
									echo 'items : 2,';
								echo '},';
								echo '1000 : {';
									echo 'items : 5,';
								echo '}';
							echo '}';
						echo '});';
						echo '}';
					echo '})( window.slider );';
				}
				if ( 'gmr-more' === $loadmore ) {
					echo '(function( infScroll ) {';
						echo '"use strict";';
						echo 'var elem = document.getElementById( \'infinite-container\' );';
						echo 'var elempag = document.querySelector( \'.inf-pagination .next\' );';
						echo 'if ( ( typeof( elem ) != \'undefined\' && elem != null ) && ( typeof( elempag ) != \'undefined\' && elempag != null ) ) {';
							echo 'var infScroll = new InfiniteScroll( elem, {';
								echo 'path: \'.inf-pagination .next\',';
								echo 'append: \'.post\',';
								echo 'history: false,';
								echo 'scrollThreshold: false,';
								echo 'button: \'.view-more-button\',';
								echo 'status: \'.page-load-status\',';
							echo '});';
						echo '} else {';
							echo 'var elembtn = document.querySelector( \'.view-more-button\' );';
							echo 'if ( typeof( elembtn ) != \'undefined\' && elembtn != null ) {';
								echo 'elembtn.style.display = \'none\';';
							echo '}';
						echo '}';
					echo '})( window.infScroll );';
				}
				echo '</script>';
			}
		}
	}
endif;
add_action( 'wp_footer', 'wpberita_custom_js', 25 );

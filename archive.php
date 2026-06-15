<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$pg = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

/* Home module */
if ( ! wpberita_is_amp() ) {
	$modulehome = get_theme_mod( 'gmr_active-module-home', 0 );
	if ( 0 === $modulehome ) {
		if ( is_tag() || is_category() || is_tax( 'newstopic' ) ) {
			if ( 1 === $pg ) {
				echo '<div class="col-md-12">';
				do_action( 'wpberita_display_modulehome' );
				echo '</div>';
			}
		}
	}
}
?>

	<main id="primary" class="site-main col-md-8">

		<?php
		if ( have_posts() ) {
			$count = 0;
			?>
			<header class="page-header">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* display only on category, tag or taxonomy newstopic */
			if ( is_tag() || is_category() || is_tax( 'newstopic' ) ) {
				if ( 1 === $pg ) {
					do_action( 'wpberita_display_headline_archive' );
				}
			}
			?>

			<?php

			echo '<div id="infinite-container">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				$count++;
				if ( ( is_tag() || is_category() || is_tax( 'newstopic' ) ) && 1 === $pg ) {
					if ( $count > 3 ) {
						/*
						 * Include the Post-Type-specific template for the content.
						 * If you want to override this in a child theme, then include a file
						 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
						 */
						get_template_part( 'template-parts/content', get_post_format() );
					}
				} else {
					/*
					 * Include the Post-Type-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				}

				do_action( 'wpberita_banner_between_posts' );

			endwhile;
			echo '</div>';

			$loadmore = get_theme_mod( 'gmr_blog_pagination', 'gmr-more' );
			if ( 'gmr-more' === $loadmore && ! wpberita_is_amp() ) {
				$class = 'inf-pagination';
			} else {
				$class = 'pagination';
			}

			the_posts_pagination(
				array(
					'class'     => esc_html( $class ),
					'mid_size'  => 1,
					'prev_text' => '&laquo; ' . esc_html__( 'Back', 'wpberita' ),
					'next_text' => esc_html__( 'Next', 'wpberita' ) . ' &raquo;',
				)
			);

			if ( 'gmr-more' === $loadmore && ! wpberita_is_amp() ) {
				echo '
				<div class="text-center">
					<div class="page-load-status">
						<div class="loader-ellips infinite-scroll-request gmr-ajax-load-wrapper gmr-loader">
							<div class="gmr-ajax-wrap">
								<div class="gmr-ajax-loader">
									<div></div>
									<div></div>
								</div>
							</div>
						</div>
						<p class="infinite-scroll-last">' . esc_attr__( 'No More Posts Available.', 'wpberita' ) . '</p>
						<p class="infinite-scroll-error">' . esc_attr__( 'No more pages to load.', 'wpberita' ) . '</p>
					</div>
					<p><button class="view-more-button heading-text">' . esc_attr__( 'View More', 'wpberita' ) . '</button></p>
				</div>
				';
			}
		} else {
			get_template_part( 'template-parts/content', 'none' );

		}
		?>

	</main><!-- #main -->

<?php
get_sidebar();
get_footer();

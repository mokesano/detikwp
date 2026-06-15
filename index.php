<?php
declare(strict_types=1);

/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
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
		if ( 1 === $pg ) {
			echo '<div class="col-md-12">';
			do_action( 'wpberita_display_modulehome' );
			echo '</div>';
		}
	}
}
?>

	<main id="primary" class="site-main col-md-8">

		<?php
		$headline = get_theme_mod( 'gmr_active-headline', 0 );
		if ( 0 === $headline ) {
			if ( 1 === $pg ) {
				wpberita_display_headline();
			}
		}
		if ( have_posts() ) {
			$count = 0;
			echo '<header class="page-header">';
			echo '<div class="widget-header">';
			if ( is_home() && ! is_front_page() ) :
				?>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				<?php
			endif;
			if ( is_front_page() && is_home() ) :
				?>
					<h1 class="page-title screen-reader-text"><?php bloginfo( 'name' ); ?></h1>
				<?php
			endif;
			echo '<h3 class="page-title">' . esc_html__( 'News Feed', 'wpberita' ) . '</h3>';
    			echo '<a href="' . esc_url( home_url( '/indeks' ) ) . '" class="index-link">Index <i class="icon icon-chevron-right"></i></a>';
			echo '</div>';
			echo '</header>';

			echo '<div id="infinite-container">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();
				$count++;
				/**
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

				do_action( 'wpberita_banner_between_posts' );

				if ( ! wpberita_is_amp() ) {
					if ( 6 === $count && 1 === $pg ) {
						/* Home module */
						if ( is_active_sidebar( 'module-1' ) ) {
							echo '<div class="module-widget">';
							dynamic_sidebar( 'module-1' );
							echo '</div>';
						}
					}

					if ( 9 === $count && 1 === $pg ) {
						/* Home module */
						if ( is_active_sidebar( 'module-2' ) ) {
							echo '<div class="module-widget">';
							dynamic_sidebar( 'module-2' );
							echo '</div>';
						}
					}
				}

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
						<div class="endLoadMore">
    						<div class="infinite-scroll-last">' . esc_attr__( 'No More Posts Available.', 'wpberita' ) . '</div>
    						<div class="infinite-scroll-error">' . esc_attr__( 'No more pages to load.', 'wpberita' ) . '</div>
						</div>
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

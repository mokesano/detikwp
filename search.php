<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

	<main id="primary" class="site-main col-md-8">

		<?php
		if ( have_posts() ) {
			?>

			<header class="page-header">
				<h1 class="page-title">
					<?php
					/* translators: %s: search query. */
					printf( esc_html__( 'Search Results for: %s', 'wpberita' ), '<span>' . get_search_query() . '</span>' );
					?>
				</h1>
			</header><!-- .page-header -->

			<?php

			echo '<div id="infinite-container">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/**
				 * Run the loop for the search to output the results.
				 * If you want to overload this in a child theme then include a file
				 * called content-search.php and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

				do_action( 'idblog_core_banner_between_posts' );

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

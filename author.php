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

$author_id = get_the_author_meta( 'ID' );
?>

<?php
if ( have_posts() ) :
	if ( ! empty( get_the_author_meta( 'image-authorpage', $author_id ) ) ) {
		$urlimage = get_the_author_meta( 'image-authorpage', $author_id );
	} else {
		$urlimage = get_template_directory_uri() . '/img/flat-bg.jpg';
	}
	?>
		<div class="col-md-12">
			<div class="author-box" style="background-size: cover;background-image: url(<?php echo esc_url( $urlimage ); ?>);">
				<div class="inside-author-box">
				<?php
				echo '<div class="gmr-ab-gravatar">';
				echo get_avatar( get_the_author_meta( 'user_email', $author_id ), '100' );
				echo '</div>';
				echo '<ul class="social-author">';
				if ( ! empty( get_the_author_meta( 'user_facebook', $author_id ) ) ) {
					echo '<li><a href="' . esc_url( get_the_author_meta( 'user_facebook', $author_id ) ) . '" class="facebook" target="_blank" rel="nofollow" title="' . esc_html__( 'Facebook', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13 9h4.5l-.5 2h-4v9h-2v-9H7V9h4V7.128c0-1.783.186-2.43.534-3.082a3.635 3.635 0 0 1 1.512-1.512C13.698 2.186 14.345 2 16.128 2c.522 0 .98.05 1.372.15V4h-1.372c-1.324 0-1.727.078-2.138.298c-.304.162-.53.388-.692.692c-.22.411-.298.814-.298 2.138V9z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				}
				if ( ! empty( get_the_author_meta( 'user_twitter', $author_id ) ) ) {
					echo '<li><a href="' . esc_url( get_the_author_meta( 'user_twitter', $author_id ) ) . '" class="twitter" target="_blank" rel="nofollow" title="' . esc_html__( 'Twitter', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 256 256"><path d="M80 224.001a136.12 136.12 0 0 1-65.904-17.008a8.008 8.008 0 0 1 3.767-15.006a119.454 119.454 0 0 0 55.93-14.792A136.21 136.21 0 0 1 28.931 35.589a8 8 0 0 1 14.415-2.226a119.686 119.686 0 0 0 76.65 52.24a48.003 48.003 0 0 1 87.12-26.51a120.51 120.51 0 0 0 30.341-6.015a8 8 0 0 1 9.101 12.172a135.61 135.61 0 0 1-30.842 31.607A136.009 136.009 0 0 1 80 224.001zm-30.944-20.048A120.48 120.48 0 0 0 80 208.001A120.003 120.003 0 0 0 199.924 92.309a8 8 0 0 1 3.45-6.301a119.039 119.039 0 0 0 14.69-11.976a136.421 136.421 0 0 1-14.963 1.27a8 8 0 0 1-7.288-4.217a32.014 32.014 0 0 0-59.201 22.173a8.005 8.005 0 0 1-8.905 9.776a135.408 135.408 0 0 1-86.75-46.25A121.28 121.28 0 0 0 40 72.002a120.026 120.026 0 0 0 52.506 99.234a8 8 0 0 1 0 13.222a135.259 135.259 0 0 1-43.45 19.496z" fill="#888888"/><rect x="0" y="0" width="256" height="256" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				}
				if ( ! empty( get_the_author_meta( 'user_youtube', $author_id ) ) ) {
					echo '<li><a href="' . esc_url( get_the_author_meta( 'user_youtube', $author_id ) ) . '" class="youtube" target="_blank" rel="nofollow" title="' . esc_html__( 'Youtube', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M19.606 6.995c-.076-.298-.292-.523-.539-.592C18.63 6.28 16.5 6 12 6s-6.628.28-7.069.403c-.244.068-.46.293-.537.592C4.285 7.419 4 9.196 4 12s.285 4.58.394 5.006c.076.297.292.522.538.59C5.372 17.72 7.5 18 12 18s6.629-.28 7.069-.403c.244-.068.46-.293.537-.592C19.715 16.581 20 14.8 20 12s-.285-4.58-.394-5.005zm1.937-.497C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5v-7l6 3.5l-6 3.5z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				}
				if ( ! empty( get_the_author_meta( 'user_whatsapp', $author_id ) ) ) {
					echo '<li><a href="' . esc_url( get_the_author_meta( 'user_whatsapp', $author_id ) ) . '" class="whatsapp" target="_blank" rel="nofollow" title="' . esc_html__( 'WhatsApp', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 512 512"><path d="M414.73 97.1A222.14 222.14 0 0 0 256.94 32C134 32 33.92 131.58 33.87 254a220.61 220.61 0 0 0 29.78 111L32 480l118.25-30.87a223.63 223.63 0 0 0 106.6 27h.09c122.93 0 223-99.59 223.06-222A220.18 220.18 0 0 0 414.73 97.1zM256.94 438.66h-.08a185.75 185.75 0 0 1-94.36-25.72l-6.77-4l-70.17 18.32l18.73-68.09l-4.41-7A183.46 183.46 0 0 1 71.53 254c0-101.73 83.21-184.5 185.48-184.5a185 185 0 0 1 185.33 184.64c-.04 101.74-83.21 184.52-185.4 184.52zm101.69-138.19c-5.57-2.78-33-16.2-38.08-18.05s-8.83-2.78-12.54 2.78s-14.4 18-17.65 21.75s-6.5 4.16-12.07 1.38s-23.54-8.63-44.83-27.53c-16.57-14.71-27.75-32.87-31-38.42s-.35-8.56 2.44-11.32c2.51-2.49 5.57-6.48 8.36-9.72s3.72-5.56 5.57-9.26s.93-6.94-.46-9.71s-12.54-30.08-17.18-41.19c-4.53-10.82-9.12-9.35-12.54-9.52c-3.25-.16-7-.2-10.69-.2a20.53 20.53 0 0 0-14.86 6.94c-5.11 5.56-19.51 19-19.51 46.28s20 53.68 22.76 57.38s39.3 59.73 95.21 83.76a323.11 323.11 0 0 0 31.78 11.68c13.35 4.22 25.5 3.63 35.1 2.2c10.71-1.59 33-13.42 37.63-26.38s4.64-24.06 3.25-26.37s-5.11-3.71-10.69-6.48z" fill-rule="evenodd" fill="#888888"/><rect x="0" y="0" width="512" height="512" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				}
				if ( ! empty( get_the_author_meta( 'url', $author_id ) ) ) {
					echo '<li><a href="' . esc_url( get_the_author_meta( 'url', $author_id ) ) . '" class="website" target="_blank" rel="nofollow" title="' . esc_html__( 'Website', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 32 32"><path d="M16 3C8.832 3 3 8.832 3 16s5.832 13 13 13s13-5.832 13-13S23.168 3 16 3zm0 2c2.103 0 4.063.605 5.736 1.633l-.236.566l1.176 1.176l-1.102 1.1L20 8h-2l-2 2.5l1 2.2l1-.7v-1h1l1.1.9L19 13l-4 2h-1v2h1l2-1l1 1h2v-1l.8-1.2L23 14v2h-2v1h2l2 3l1-1v-1h-1v-1h1l.96-.207A10.914 10.914 0 0 1 25 22.305V22h-1.1l-2.4-4l-2.5 1l-3-1l-3 1l-1 3l1 2h2l1-1l1 1v2.95c-.33.03-.662.05-1 .05c-6.065 0-11-4.935-11-11c0-.927.129-1.823.346-2.684L5.9 13H7V9.695c.167-.237.337-.472.521-.695h.899l.437-1.35a11.02 11.02 0 0 1 2.053-1.392L10 9h2l2-2V6h-1l-1 1V5.764A10.927 10.927 0 0 1 16 5zm-2 6v2h1v-2h-1z" fill="#888888"/><rect x="0" y="0" width="32" height="32" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				}
				echo '<li><a href="' . esc_url( get_author_feed_link( $author_id ) ) . '" class="feedlink" target="_blank" rel="nofollow" title="' . esc_html__( 'RSS Feed', 'wpberita' ) . '"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="vertical-align: -0.125em;-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M5.996 19.97a1.996 1.996 0 1 1 0-3.992a1.996 1.996 0 0 1 0 3.992zm-.876-7.993a.998.998 0 0 1-.247-1.98a8.103 8.103 0 0 1 9.108 8.04v.935a.998.998 0 1 1-1.996 0v-.934a6.108 6.108 0 0 0-6.865-6.06zM4 5.065a.998.998 0 0 1 .93-1.063c7.787-.519 14.518 5.372 15.037 13.158c.042.626.042 1.254 0 1.88a.998.998 0 1 1-1.992-.133c.036-.538.036-1.077 0-1.614c-.445-6.686-6.225-11.745-12.91-11.299A.998.998 0 0 1 4 5.064z" fill="#888888"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg></a></li>';
				echo '</ul>';
				?>
				</div>
			</div>
		</div>
		<?php
	endif;
?>
	<main id="primary" class="site-main col-md-8 col-md-offset-2">

		<?php
		if ( have_posts() ) {
			?>
			<header class="page-header">
				<?php
					the_archive_title( '<h1 class="author-title clearfix">', '</h1>' );
					the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->
			<?php

			echo '<div id="infinite-container">';
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				/*
				 * Include the Post-Type-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_type() );

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
get_footer();

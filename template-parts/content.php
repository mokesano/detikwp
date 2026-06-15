<?php
declare(strict_types=1);

/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$focus_display = get_post_meta( $post->ID, '_gmr_focus_key', true );

$focus = '';
if ( $focus_display ) {
	$focus = ' gmr-focus-news';
}

if ( $focus_display ) {
	$image_size = 'large';
} else {
	$image_size = 'medium';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="box-item<?php echo $focus; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>">
		<?php
		if ( has_post_thumbnail() ) {
			?>
			<a class="post-thumbnail" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" aria-hidden="true">
				<?php
					the_post_thumbnail(
						$image_size,
						array(
							'alt' => the_title_attribute(
								array(
									'echo' => false,
								)
							),
						)
					);
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
		<div class="box-content">
			<?php
			if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
				$termlist = get_the_term_list( $post->ID, 'newstopic' );
				if ( ! empty( $termlist ) ) {
					echo '<div class="sangia-meta-topic heading-text"><strong>';
					echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
					echo '</strong></div>';
				}
			}
			?>
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '" rel="bookmark">', '</a></h2>' ); ?>
			<footer class="entry-footer entry-footer-archive">
				<?php
				echo '<div class="meta-content clearfix">';
						wpberita_posted_by();
						wpberita_category();
						wpberita_posted_on();
				echo '</div>';
				?>
			</footer><!-- .entry-footer -->
			<?php
			$excerpt_opsi = get_theme_mod( 'gmr_active-excerpt', 1 );
			if ( 0 === $excerpt_opsi ) :
				?>
				<div class="entry-content entry-content-archive">
					<?php the_excerpt(); ?>
				</div><!-- .entry-content -->
				<?php
			endif;
			?>
		</div>
	</div>
</article><!-- #post-<?php the_ID(); ?> -->

<?php
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

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'content-single' ); ?>>
	<?php do_action( 'wpberita_view_breadcrumbs' ); ?>
	<header class="entry-header entry-header-single">
		<?php
		if ( ! is_wp_error( get_the_term_list( $post->ID, 'newstopic' ) ) ) {
			$termlist = get_the_term_list( $post->ID, 'newstopic' );
			if ( ! empty( $termlist ) ) {
				echo '<div class="sangia-meta-topic heading-text"><strong>';
				echo get_the_term_list( $post->ID, 'newstopic', '', ', ', '' );
				echo '</strong></div>';
			}
		}
		the_title( '<h1 class="entry-title">', '</h1>' );
		if ( function_exists( 'the_subtitle' ) ) {
			the_subtitle( '<h3 class="subtitle">', '</h3>' );
		} elseif ( class_exists( 'WPSubtitle' ) ) {
			do_action(
				'plugins/wp_subtitle/the_subtitle',
				array(
					'before'        => '<h3 class="subtitle">',
					'after'         => '</h3>',
					'post_id'       => get_the_ID(),
					'default_value' => '',
				)
			);
		}		

		echo '<div class="sangia-meta-content heading-text">';
		    $byline = ''; // Inisialisasi di awal
    		if ( function_exists( 'coauthors_posts_links' ) ) {
                coauthors_posts_links();
            } else {
    			$byline = sprintf(
    				/* translators: %s: post author. */
    				'%s',
    				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_html( get_the_author() ) . '">' . esc_html( get_the_author() ) . '</a></span>'
    			);
            }
    		echo $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    			/* translators: used between list items, there is a space after the comma */
    		/*	$categories_list = get_the_category_list( ', ' );
    			$category        = '';
    		/*  if ( $categories_list ) {
    				echo '<span class="cat-links-content">' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    			}
    		*/	
    			echo ' — <span class="cat-links-content source">';
    			    bloginfo( 'name' );
    			echo '</span>';
			echo '</div>';
			echo '<div class="meta-content gmr-content-metasingle">';
			wpberita_posted_on();
			post_read_time(get_the_ID());
			echo '</div>';
			?>
	</header><!-- .entry-header -->
	<?php
		echo '<div class="share-top">';
		    do_action( 'wpberita_comment_social' );
		echo '</div>';

		/* custom field using oembed https://codex.wordpress.org/Embeds */
		$oembed = get_post_meta( $post->ID, 'MAJPRO_Oembed', true );
		$iframe = get_post_meta( $post->ID, 'MAJPRO_Iframe', true );

	if ( ! empty( $oembed ) ) {
		echo '<div class="gmr-embed-responsive gmr-embed-responsive-16by9 single-thumbnail">';
		echo wp_oembed_get( $oembed );  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';

	} elseif ( ! empty( $iframe ) ) {
		echo '<div class="gmr-embed-responsive gmr-embed-responsive-16by9 single-thumbnail">';
		$var = do_shortcode( $iframe );
		echo $var;  // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo '</div>';

	} else {
		// Disable thumbnail options via customizer.
		$thumbnail = get_theme_mod( 'gmr_active-singlethumb', 0 );
		if ( 0 === $thumbnail && has_post_thumbnail() ) {
			?>
			<figure class="post-thumbnail gmr-thumbnail-single">
				<?php the_post_thumbnail(); ?>
				<?php
				$get_title = get_post( get_post_thumbnail_id() )->post_title;
				$get_description = get_post( get_post_thumbnail_id() )->post_excerpt;
				$get_content = get_post( get_post_thumbnail_id() )->post_content;
				if ( ! empty( $get_description ) || ( $get_content ) ) :
					?>
					<figcaption class="wp-caption-text">
					    <span class="fig_sangia-caption"><?php echo esc_html( $get_description ); ?></span>
					    <div class="fig_sangia-credit"><?php echo esc_html( $get_content ); ?></div>
					</figcaption>
				<?php endif; ?>
			</figure>
			<?php
		}
	}

	if ( has_post_format( 'gallery' ) ) {
		do_action( 'wpberita_get_attachment_gallery' );
	}
	$banner    = get_theme_mod( 'gmr_adsstickyrightcontent' );
	$classads  = '';
	if ( ! wpberita_is_amp() ) {
		if ( isset( $banner ) && ! empty( $banner ) ) {
			$classads = ' have-stickybanner';
		}
	}
	?>

	<div class="single-wrap">
		<div class="entry-content entry-content-single clearfix<?php echo esc_html( $classads ); ?>">
		    
			<?php
				the_content();
				// do_action( 'sangia_related_post_second' );
				add_action( 'the_content', 'gmr_move_post_navigation_second', 2 );
				wp_link_pages(
					array(
						'before' => '<div class="detail__multiple"><div class="flex-between detail__multiple-bg page-links"><div class="detail__anchor"><span class="text-page-link">' . esc_html__( 'Pages:', 'wpberita' ) . '</span>',
						'after'  => '</div>' . '</div>' . '</div>',
					)
					
				);			
				do_action( 'the_content', 'gmr_move_post_navigation_second' );
			?>

			<footer class="entry-footer entry-footer-single">
				<?php wpberita_entry_footer(); ?>
				<?php
				$post = get_post(); // Tambahkan ini jika belum ada
				$postparentid = $post->post_parent; // Definisikan variabel ini
				
				$majpro_source = get_post_meta( $post->ID, 'MAJPRO_Source', true );
				$majpro_writer = get_post_meta( $post->ID, 'MAJPRO_Writer', true );
				$majpro_editor = get_post_meta( $post->ID, 'MAJPRO_Editor', true );
				$majpro_contributor = get_post_meta( $postparentid, 'MAJPRO_Contributor', true );							
				echo '<div class="gmr-cf-metacontent">';
				if ( ! empty( $majpro_writer ) ) {
					echo '<span class="writer">';
					echo esc_attr__( 'Writer: ', 'wpberita' ) . esc_attr( $majpro_writer );
					echo '</span>';
				}
				if ( ! empty( $majpro_contributor ) ) {
					echo '<span class="reporter">';
					echo esc_attr__( 'Reporter: ', 'wpberita' ) . esc_attr( $majpro_contributor );
					echo '</span>';
				}				
				if ( ! empty( $majpro_editor ) ) {
					echo '<span class="editor">';
					echo esc_attr__( 'Editor: ', 'wpberita' ) . esc_attr( $majpro_editor );
					echo '</span>';
				}
				if ( ! empty( $majpro_source ) ) {
					echo '<span class="source">';
					echo '<a href="' . esc_url( $majpro_source ) . '" target="_blank" rel="nofollow">' . esc_attr__( 'Source News', 'wpberita' ) . '</a>';
					echo '</span>';
				}
				echo '</div>';
				?>
				<?php do_action( 'wpberita_floating_banner_right' ); ?>
			</footer><!-- .entry-footer -->
		</div><!-- .entry-content -->
		<?php do_action( 'wpberita_banner_stickyright_content' ); ?>
	</div>
	<?php
		do_action( 'wpberita_comment_social' );
		do_action( 'wpberita_banner_before_content' );
		do_action( 'wpberita_related_post_third' );
		do_action( 'wpberita_related_post_second' );
		do_action( 'wpberita_related_post' );
		do_action( 'wpberita_banner_after_relpost' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->

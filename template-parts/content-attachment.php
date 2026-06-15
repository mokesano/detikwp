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

$postparentid = absint( $post->post_parent );

?>

<article id="post-attachment" <?php post_class( 'content-single' ); ?>>
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
		the_title( '<h1 class="entry-title"><strong>', '</strong></h1>' );
		echo '<div class="sangia-meta-content heading-text">';
			$byline = sprintf(
				/* translators: %s: post author. */
				'%s',
				'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_html( get_the_author() ) . '">' . esc_html( get_the_author() ) . '</a></span>'
			);
			echo $byline; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( ', ', '', $postparentid );
			$category        = '';
			if ( $categories_list ) {
				echo ' - <span class="cat-links-content">' . $categories_list . '</span>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			}
			echo '</div>';
			echo '<div class="meta-content gmr-content-metasingle">';
			wpberita_posted_on();
			echo '</div>';
			?>
	</header><!-- .entry-header -->
	<?php
	    echo '<div class="share-top">';
		    do_action( 'wpberita_comment_social' );
		echo '</div>';

		$thumb = wp_get_attachment_image( $post->ID, 'full' );

	if ( '' !== $thumb ) {
		?>
		<figure class="post-thumbnail gmr-thumbnail-single">
			<?php echo $thumb; // phpcs:ignore WordPress.Security.EscapeOutput ?>
    		<?php
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

	if ( ! empty( $postparentid ) ) {
		do_action( 'wpberita_get_attachment_gallery' );
	}

	?>

	<div class="single-wrap">
		<div class="entry-content entry-content-single clearfix">
			<footer class="entry-footer entry-footer-single">
				<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', ' ', '', $postparentid );
				if ( $tags_list ) {
					/* translators: 1: list of tags. */
					printf( '<span class="tags-links heading-text">%1$s</span>', $tags_list ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}

				edit_post_link(
					sprintf(
						wp_kses(
							/* translators: %s: Name of current post. Only visible to screen readers */
							__( 'Edit <span class="screen-reader-text">%s</span>', 'wpberita' ),
							array(
								'span' => array(
									'class' => array(),
								),
							)
						),
						wp_kses_post( get_the_title() )
					),
					'<span class="edit-link">',
					'</span>'
				);

				$majpro_source = get_post_meta( $postparentid, 'MAJPRO_Source', true );
				$majpro_writer = get_post_meta( $postparentid, 'MAJPRO_Writer', true );
				$majpro_editor = get_post_meta( $postparentid, 'MAJPRO_Editor', true );
				$majpro_contributor = get_post_meta( $postparentid, 'MAJPRO_Contributor', true );				
				echo '<div class="gmr-cf-metacontent meta-content">';
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
			</footer><!-- .entry-footer -->
		</div><!-- .entry-content -->
	</div>
	<?php
		do_action( 'wpberita_comment_social' );
	if ( ! empty( $postparentid ) ) {
	    do_action( 'wpberita_related_post_third' );
		do_action( 'wpberita_related_post' );
		do_action( 'wpberita_related_post_second' );
		do_action( 'wpberita_banner_after_relpost' );
	}
	?>

</article><!-- #post-<?php the_ID(); ?> -->

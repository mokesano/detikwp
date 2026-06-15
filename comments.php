<?php
declare(strict_types=1);

/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fb_comment = get_theme_mod( 'gmr_comment', 'default-comment' );
if ( 'fb-comment' === $fb_comment ) {
	return get_template_part( '/inc/fb-comment', '' );
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );

	$fields = array(
		'author' =>
		'<p class="comment-form-author">' .
		'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
		'" placeholder="' . __( 'Name', 'wpberita' ) . ( $req ? '*' : '' ) . '" size="30"' . $aria_req . ' /></p>',

		'email'  =>
		'<p class="comment-form-email">' .
		'<input id="email" name="email" type="text" value="' . esc_attr( $commenter['comment_author_email'] ) .
		'" placeholder="' . __( 'Email', 'wpberita' ) . ( $req ? '*' : '' ) . '" size="30"' . $aria_req . ' /></p>',

		'url'    =>
		'<p class="comment-form-url">' .
		'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) .
		'" placeholder="' . __( 'Website', 'wpberita' ) . '" size="30" /></p>',
	);

	$args = array(
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="5" placeholder="' . _x( 'Comment', 'noun', 'wpberita' ) . '" aria-required="true">' .
		'</textarea></p>',

		'fields'        => apply_filters( 'comment_form_default_fields', $fields ),
	);
	comment_form( $args );

	// You can start editing here -- including this comment!
	if ( have_comments() ) :
		?>
		<h2 class="comments-title">
			<?php
			$wpberita_comment_count = get_comments_number();
			if ( '1' === $wpberita_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'Response (1)', 'wpberita' )
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( 'Response (%1$s)', 'Responses (%1$s)', $wpberita_comment_count, 'comments title', 'wpberita' ) ),
					number_format_i18n( $wpberita_comment_count ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				);
			}
			?>
		</h2><!-- .comments-title -->

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		if ( '0' === $wpberita_comment_count ) {
		    echo '<div class="komentar-iframe-min-comment-null"><i class="komentar-iframe-min-icon komentar-iframe-min-icon-comment-bg"></i><div class="komentar-iframe-min-font-bold komentar-iframe-min-color-black komentar-iframe-min-font-sm komentar-iframe-min-mgb-12">Belum ada komentar.</div>Jadilah yang pertama berkomentar di sini</div>';
		    }
		?>

		<?php
		the_comments_pagination();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			echo '<div class="komentar-iframe-min-comment-null"><i class="komentar-iframe-min-icon komentar-iframe-min-icon-comment-bg"></i><div class="komentar-iframe-min-font-bold komentar-iframe-min-color-black komentar-iframe-min-font-sm komentar-iframe-min-mgb-12">Belum ada komentar.</div>Jadilah yang pertama berkomentar di sini</div>';
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'wpberita' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	?>

</div><!-- #comments -->

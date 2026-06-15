<?php
/**
 * FB comments template file.
 * This replaces the theme's comment template when fb comments are enable
 *
 * @since 1.0.0
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/* option section, default */
$appid = get_theme_mod( 'gmr_fbappid', '1703072823350490' );
?>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/<?php bloginfo( 'language' ); ?>/sdk.js#xfbml=1&version=v9.0&appId=<?php echo esc_attr( $appid ); ?>&autoLogAppEvents=1" nonce="4G7nS4tr"></script>
<div id="comments" class="gmr-fb-comments">
	<div id="respond" class="comment-respond">
		<div class="fb-comments" data-href="<?php the_permalink(); ?>" data-lazy="true" data-numposts="5" data-width="100%"></div>
	</div>
</div>

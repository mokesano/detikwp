<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

?>
			</div>
		</div>
		<?php do_action( 'wpberita_footerbanner' ); ?>
	</div><!-- .gmr-content -->

	<footer id="colophon" class="site-footer">
		<?php
		$mod = get_theme_mod( 'gmr_footer_column', '3col' );
		if ( '4col' === $mod ) {
			$class = 'col-md-3';
		} elseif ( '1col' === $mod ) {
			$class = 'col-md-12';
		} elseif ( '2col' === $mod ) {
			$class = 'col-md-6';
		} elseif ( '6col' === $mod ) {
			$class = 'col-md-2';
		} else {
			$class = 'col-md-4';
		}

		if ( ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) || is_active_sidebar( 'footer-5' ) || is_active_sidebar( 'footer-6' ) ) && ! wpberita_is_amp() ) :
			?>
			<div id="footer-sidebar" class="footer widget-footer" role="complementary">
				<div class="container">
				<div class="grid-row">    
        			<div class="footer-brand site-info text-center heading-text">
        				<div class="gmr-footer-logo">
        					<?php
        					$custom_logo_id = get_theme_mod( 'custom_logo' );
        					$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
        					if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
        						$desc = get_bloginfo( 'name', 'display' );
        						echo '<a class="custom-logo-link" href="' . esc_url( get_home_url() ) . '" title="' . esc_html( $desc ) . '" rel="home">';
        						echo '<img class="custom-logo" src="' . esc_url( $logo[0] ) . '" width="' . (int) $logo[1] . '" height="' . (int) $logo[2] . '" alt="' . esc_html( $desc ) . '" loading="lazy" />';
        						echo '</a>';
        					} else {
        						?>
        						<div class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php bloginfo( 'name' ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
        							<?php
        							$wpberita_description = get_bloginfo( 'description', 'display' );
        							if ( $wpberita_description || is_customize_preview() ) :
        								?>
        							<div class="site-description screen-reader-text"><?php echo esc_html( $wpberita_description ); ?></div>
        						<?php endif; ?>
        					<?php } ?>
        					<div class="part-of">Part of <span class="part-caption-text"><img src="//assets.sangia.org/image/sangia.png" alt="img-alt" title="img-title" height="17px" style="margin-bottom: 0;vertical-align: sub;height: 17px;margin-left: 7px;"></span>
        					</div>
        					<caption>unless otherwise stated.</caption>
        					<figcaption class="wp-caption-text text-center"><?php echo esc_html( get_bloginfo( 'description' ) ); ?></figcaption>
        				</div>
        				
            			<?php if ( has_nav_menu( 'menu-5' ) ) {
                        	wp_nav_menu(
                        		array(
                        			'theme_location'  => 'menu-5',
                        			'container'       => 'div',
                        			'container_class' => 'footer-menu widget widget_pages',
                        			'depth'           => 1,
                        			)
                        		);
                        	}
                    	?>
                    				
        				<?php
        
        				echo '<div class="gmr-social-icons">';
        					echo '<div class="text-social">' . esc_html__( 'Connect With Us', 'wpberita' ) . '</div>';
        					echo '<ul class="social-icon">';
        						do_action( 'social_icon' );
        					echo '</ul>';
        				echo '</div>';
        
        				$copyright = get_theme_mod( 'gmr_copyright' );
        				if ( $copyright ) :
        				    echo '<div class="copyright">';
            					// sanitize html output than convert it again using htmlspecialchars_decode.
            					echo wp_kses_post( $copyright );
        					echo '</div>';
        				else :
        					?>
        					<a href="<?php echo esc_url( __( 'https://wordpress.org/', 'wpberita' ) ); ?>"><?php printf( esc_html__( 'Powered by WordPress', 'wpberita' ) ); ?></a>
        					<span class="sep"> - </span>
        					<a href="<?php echo esc_url( __( 'https://www.idtheme.com/wpberita', 'wpberita' ) ); ?>"><?php printf( esc_html__( 'Theme: wpberita.', 'wpberita' ) ); ?></a>
        				<?php endif; ?>
        				<div class="rights">All right reserved.</div>
        			</div><!-- .site-info -->
			
        			<div class="footer-nav site-info heading-text">
    					<div class="row">
    						<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-1' ); ?>
    							</div>
    						<?php endif; ?>
    						<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-3' ); ?>
    							</div>
    						<?php endif; ?>
    						<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-2' ); ?>
    							</div>
    						<?php endif; ?>
    						<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-4' ); ?>
    							</div>
    						<?php endif; ?>
    						<?php if ( is_active_sidebar( 'footer-5' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-5' ); ?>
    							</div>
    						<?php endif; ?>
    						<?php if ( is_active_sidebar( 'footer-6' ) ) : ?>
    							<div class="footer-column <?php echo esc_html( $class ); ?>">
    								<?php dynamic_sidebar( 'footer-6' ); ?>
    							</div>
    						<?php endif; ?>
    					</div>
					</div>
				</div>
			</div>
			</div>
		<?php endif; ?>
		<div class="container">
			<?php
			if ( wpberita_is_amp() ) :
				/* Add Non AMP Version using div id="site-version-switcher" and id="version-switch-link" */
				$nonamp_link = amp_remove_endpoint( amp_get_current_url() );
				echo '<div id="site-version-switcher" class="text-center"><a id="version-switch-link" href="' . esc_url( $nonamp_link ) . '" class="amp-wp-canonical-link" title="' . esc_html__( 'Non AMP Version', 'wpberita' ) . '" rel="noamphtml">' . esc_attr__( 'Non AMP Version', 'wpberita' ) . '</a></div>';
			endif;
			?>
		</div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php do_action( 'wpberita_woocommerce_demo_store' ); ?>

<?php
if ( wpberita_is_amp() ) {
	echo '<nav id="navigationamp" [class]="\'site-header-menu\' + ( navMenuExpanded ? \' toggled-on\' : \'\' )" aria-expanded="false" [aria-expanded]="navMenuExpanded ? \'true\' : \'false\'">';
} else {
	echo '<nav id="side-nav" class="gmr-sidemenu">';
}
wp_nav_menu(
	array(
		'theme_location' => 'menu-3',
		'container'      => 'ul',
		'menu_id'        => 'primary-menu',
	)
);
echo '</nav>';

do_action( 'wpberita_floating_banner_footer' );

wp_footer();
?>

</body>
</html>

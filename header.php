<?php
declare(strict_types=1);

/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
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
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'wpberita' ); ?></a>

	<?php
	if ( wp_is_mobile() ) {
	    echo '<div class="ads-box">';
    	    echo '<div class="billboard parallax">';
    	        echo '<div class="widget text-center">';
    			    do_action( 'sangia_topbanner_verytop' );
    			echo '</div>';
    		echo '</div>';
		echo '</div>';
	}
	?>

	<div id="page" class="site">

	<header id="topnavwrap" class="gmr-topnavwrap header clearfix">

		<div class="container">
			<div class="list-table">
				<div class="table-row">
					<div class="table-cell gmr-table-date">
						<?php
						if ( ! wpberita_is_amp() ) {
							echo '<a id="gmr-responsive-menu" title="' . esc_html__( 'Menus', 'wpberita' ) . '" href="#menus" rel="nofollow"><div class="ktz-i-wrap"><span class="ktz-i"></span><span class="ktz-i"></span><span class="ktz-i"></span></div><div id="textmenu-id" class="gmr-textmenu heading-text">' . esc_html__( 'Menu', 'wpberita' ) . '</div></a>';
						} else {
							echo '<amp-state id="navMenuExpanded">';
									echo '<script type="application/json">false</script>';
							echo '</amp-state>';
							echo '<button id="gmr-responsive-menu" class="menu-toggle" on="tap:AMP.setState( { navMenuExpanded: ! navMenuExpanded } )" [class]="\'menu-toggle\' + ( navMenuExpanded ? \' toggled-on\' : \'\' )" aria-expanded="false" [aria-expanded]="navMenuExpanded ? \'true\' : \'false\'"><div class="ktz-i-wrap"><span class="ktz-i"></span><span class="ktz-i"></span><span class="ktz-i"></span></div><div id="textmenu-id" class="gmr-textmenu heading-text">' . esc_html__( 'Menu', 'wpberita' ) . '</div></button>';
						}
						echo '<div class="gmr-logo-mobile">';
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
							$desc           = get_bloginfo( 'name', 'display' );
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
								<span class="site-description screen-reader-text"><?php echo esc_html( $wpberita_description ); ?></span>
							<?php endif; ?>
							<?php
						}
						echo '</div>';
						?>
					</div>

					<?php
					// Option remove search button.
					$setting    = 'gmr_active-searchbutton';
					$mod_search = get_theme_mod( $setting, customizer_library_get_default( $setting ) );
					if ( 0 === $mod_search ) :
						?>
						<div class="table-cell gmr-table-search">
							<form method="get" class="gmr-searchform searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
								<input type="text" name="s" id="s" placeholder="<?php echo esc_attr__( 'Search News', 'wpberita' ); ?>" />
								<input type="hidden" name="post_type" value="post" />
								<button type="submit" class="gmr-search-submit gmr-search-icon"><div class="ktz-is-wrap"><span class="ktz-is"></span><span class="ktz-is"></span></div></button>
							</form>
						</div>
					<?php endif; ?>

					<?php
					// Option remove search button.
					$f_text = get_theme_mod( 'gmr_first_topnavbtn_text' );
					$f_url  = get_theme_mod( 'gmr_first_topnavbtn_url' );
					$s_text = get_theme_mod( 'gmr_second_topnavbtn_text' );
					$s_url  = get_theme_mod( 'gmr_second_topnavbtn_url' );
					?>

					<div class="table-cell gmr-menuright">
					<?php
						echo '<div class="pull-right">';
						do_action( 'wpberita_topnav_icon' );
    					if ( $f_text && $f_url ) :
    						echo '<a href="' . esc_url( $f_url ) . '" class="topnav-button second-topnav-btn nomobile heading-text" title="' . esc_html( $f_text ) . '">' . esc_html( $f_text ) . '</a>';
    					endif;
    					if ( $s_text && $s_url ) :
    						echo '<a href="' . esc_url( $s_url ) . '" class="topnav-button nomobile heading-text" title="' . esc_html( $s_text ) . '">' . esc_html( $s_text ) . '</a>';
    					endif;
						echo '</div>';
					?>
					</div>
				</div>
			</div>
			<?php
			if ( wp_is_mobile() ) {
				if ( has_nav_menu( 'menu-4' ) ) {
					echo '<div class="gmr-mobilemenuwrap">';
						echo '<div class="gmr-mobilemenu clearfix">';
						wp_nav_menu(
							array(
								'theme_location' => 'menu-4',
								'fallback_cb'    => false,
								'container'      => 'ul',
								'menu_id'        => 'mobile-menu',
								'depth'          => 1,
								'link_before'    => '<span itemprop="name">',
								'link_after'     => '</span>',
							)
						);
						echo '</div>';
					echo '</div>';
				}
			}
			?>
		</div>

	</header>

		<?php do_action( 'wpberita_floating_banner_left' ); ?>
		<?php do_action( 'wpberita_floating_banner_right' ); ?>
		<?php if ( ! wpberita_is_amp() ) { ?>

			<header id="masthead" class="site-header">

			    <div class="top-banner parallax">
			        <?php do_action( 'wpberita_topbanner_verytop' ); ?>
			    </div>

				<div class="container">
					<div class="site-branding">
						<?php
						echo '<div class="gmr-logo">';
						if ( function_exists( 'the_custom_logo' ) && has_custom_logo() ) {
							$custom_logo_id = get_theme_mod( 'custom_logo' );
							$logo           = wp_get_attachment_image_src( $custom_logo_id, 'full' );
							$desc           = get_bloginfo( 'name', 'display' );
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
								<span class="site-description screen-reader-text"><?php echo esc_html( $wpberita_description ); ?></span>
							<?php endif; ?>
							<?php
						}
						echo '</div>';
						wpberita_topbanner_logo();
						?>
					</div><!-- .site-branding -->
				</div>
			</header><!-- #masthead -->
		<?php } ?>
		<?php
		if ( ! wpberita_is_amp() ) {
			?>
			<div id="main-nav-wrap" class="gmr-mainmenu-wrap">
				<div class="container">
					<nav id="main-nav" class="main-navigation gmr-mainmenu">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'menu-1',
								'container'      => 'ul',
								'menu_id'        => 'primary-menu',
							)
						);
						wp_nav_menu(
							array(
								'theme_location' => 'menu-2',
								'container'      => 'ul',
								'menu_id'        => 'secondary-menu',
							)
						);
						?>
					</nav><!-- #main-nav -->
				</div>
			</div>
			<?php
		}
		?>

		<div class="billboards parallax">
		    <?php do_action( 'wpberita_topbanner_aftermenu' ); ?>
		</div>

		<div id="content" class="gmr-content">

			<div class="container">
				<div class="row">

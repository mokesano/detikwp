<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! is_active_sidebar( 'sidebar-woo-single' ) || wpberita_is_amp() ) {
	return;
}
?>

<aside id="secondary" class="widget-area col-md-4 pos-sticky">
	<?php dynamic_sidebar( 'sidebar-woo-single' ); ?>
</aside><!-- #secondary -->

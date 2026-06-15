<?php
/**
 * Defines customizer options
 *
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wpberita_get_home' ) ) {
	/**
	 * Get homepage without http/https and www
	 *
	 * @since 1.0.0
	 * @return string
	 */
	function wpberita_get_home() {
		$protocols = array( 'http://', 'https://', 'http://www.', 'https://www.', 'www.' );
		return str_replace( $protocols, '', home_url() );
	}
}

/**
 * Option array customizer library
 *
 * @since 1.0.0
 */
function gmr_library_options_customizer() {

	// Prefix_option.
	$gmrprefix = 'gmr';

	/*
	 * Theme defaults
	 *
	 * @since v.1.0.0
	 */
	// General.
	$color_scheme           = '#21409a';
	$second_color_scheme    = '#ef672f';
	$bigheadline_scheme     = '#fcc43f';
	$content_bgcolor        = '#ffffff';
	$content_color          = '#000000';
	$content_greycolor      = '#888888';
	$content_linkcolor      = '#000000';
	$content_linkhovercolor = '#21409a';
	$content_bordercolor    = '#dddddd';
	$button_bgcolor         = '#ef672f';
	$button_color           = '#ffffff';

	// General.
	$body_fontsize   = '14';
	$single_fontsize = '16';

	/*
	 * Header Default Options
	 */
	$header_bgcolor  = '#ffffff';
	$topnav_color    = '#222222';
	$menu_bgcolor    = '#21409a';
	$menu_color      = '#ffffff';
	$menu_hovercolor = '#fcc43f';

	$secondmenu_bgcolor    = '#f0f0f0';
	$secondmenu_color      = '#000000';
	$secondmenu_hovercolor = '#21409a';

	// Footer.
	$footer_bgcolor        = '#f0f0f0';
	$footer_fontcolor      = '#666666';
	$footer_linkcolor      = '#666666';
	$footer_hoverlinkcolor = '#666666';

	// woocommerce color.
	$price_color       = '#d0011b';
	$badge_color       = '#ffffff';
	$badge_bgcolor     = '#d0011b';
	$altbutton_bgcolor = '#d0011b';
	$altbutton_color   = '#ffffff';

	// Add Lcs.
	$hm         = md5( wpberita_get_home() );
	$license    = trim( get_option( 'wpberita_core_license_key' . $hm ) );
	$upload_dir = wp_upload_dir();

	// Stores all the controls that will be added.
	$options = array();

	// Stores all the sections to be added.
	$sections = array();

	// Stores all the panels to be added.
	$panels = array();

	// Adds the sections to the $options array.
	$options['sections'] = $sections;

	/*
	 * General Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_general = 'panel-general';
	$panels[]      = array(
		'id'       => $panel_general,
		'title'    => __( 'General', 'wpberita' ),
		'priority' => '30',
	);

	$section    = 'layout_options';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'General Layout', 'wpberita' ),
		'priority' => 35,
		'panel'    => $panel_general,
	);

	$layout = array(
		'box-layout'  => __( 'Box', 'wpberita' ),
		'full-layout' => __( 'Fullwidth', 'wpberita' ),
	);

	$options[ $gmrprefix . '_layout' ] = array(
		'id'      => $gmrprefix . '_layout',
		'label'   => __( 'Select Layout', 'wpberita' ),
		'section' => $section,
		'type'    => 'select',
		'choices' => $layout,
		'default' => 'full-layout',
	);

	// Background Imaage.
	$section    = 'background_image';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Background Image', 'wpberita' ),
		'panel'       => $panel_general,
		'description' => __( 'Background Image only display, if using box layout.', 'wpberita' ),
		'priority'    => 45,
	);

	// Typography.
	$section    = 'typography';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Typography', 'wpberita' ),
		'panel'    => $panel_general,
		'priority' => 50,
	);

	$options[ $gmrprefix . '_primary-font' ] = array(
		'id'      => $gmrprefix . '_primary-font',
		'label'   => __( 'Heading Font', 'wpberita' ),
		'section' => $section,
		'type'    => 'googlefonts',
		'default' => wp_json_encode(
			array(
				'font'          => 'Montserrat',
				'regularweight' => '600',
				'italicweight'  => '600italic',
				'boldweight'    => '700',
			)
		),
	);

	$options[ $gmrprefix . '_secondary-font' ] = array(
		'id'      => $gmrprefix . '_secondary-font',
		'label'   => __( 'Body Font', 'wpberita' ),
		'section' => $section,
		'type'    => 'googlefonts',
		'default' => wp_json_encode(
			array(
				'font'          => 'Open Sans',
				'regularweight' => '400',
				'italicweight'  => 'italic',
				'boldweight'    => '600',
			)
		),
	);

	$options[ $gmrprefix . '_single_size' ] = array(
		'id'          => $gmrprefix . '_single_size',
		'label'       => __( 'Content single font size', 'wpberita' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => $single_fontsize,
		'input_attrs' => array(
			'min'  => 12,
			'max'  => 50,
			'step' => 1,
		),
	);

	/*
	 * Header Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_header = 'panel-header';
	$panels[]     = array(
		'id'       => $panel_header,
		'title'    => __( 'Header', 'wpberita' ),
		'priority' => '40',
	);

	// Logo.
	$section    = 'title_tagline';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Site Identity', 'wpberita' ),
		'priority'    => 30,
		'panel'       => $panel_header,
		'description' => __( 'Allow you to add icon, logo, change site-title and tagline to your website.', 'wpberita' ),
	);

	$section    = 'header_image';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Header Image', 'wpberita' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize header sections in home page.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_active-headerimage' ] = array(
		'id'          => $gmrprefix . '_active-headerimage',
		'label'       => __( 'Disable header image', 'wpberita' ),
		'section'     => $section,
		'type'        => 'checkbox',
		'default'     => 1,
		'priority'    => 25,
		'description' => __( 'If you disable header image, header section will replace with header color.', 'wpberita' ),
	);

	$bgsize = array(
		'auto'    => 'Auto',
		'cover'   => 'Cover',
		'contain' => 'Contain',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgsize' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgsize',
		'label'       => __( 'Background Size', 'wpberita' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgsize,
		'priority'    => 30,
		'description' => __( 'The background-size property specifies the size of the header images.', 'wpberita' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/css3_pr_background-size.asp', 'wpberita' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'wpberita' ) . '</a>',
		'default'     => 'auto',
	);

	$bgrepeat = array(
		'repeat'   => 'Repeat',
		'repeat-x' => 'Repeat X',
		'repeat-y' => 'Repeat Y',
		'initial'  => 'Initial',
		'inherit'  => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgrepeat' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgrepeat',
		'label'       => __( 'Background Repeat', 'wpberita' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgrepeat,
		'priority'    => 35,
		'description' => __( 'The background-repeat property sets if/how a header image will be repeated.', 'wpberita' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-repeat.asp', 'wpberita' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'wpberita' ) . '</a>',
		'default'     => 'repeat',
	);

	$bgposition = array(
		'left top'      => 'left top',
		'left center'   => 'left center',
		'left bottom'   => 'left bottom',
		'right top'     => 'right top',
		'right center'  => 'right center',
		'right bottom'  => 'right bottom',
		'center top'    => 'center top',
		'center center' => 'center center',
		'center bottom' => 'center bottom',
	);

	$options[ $gmrprefix . '_headerimage_bgposition' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgposition',
		'label'       => __( 'Background Position', 'wpberita' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgposition,
		'priority'    => 40,
		'description' => __( 'The background-position property sets the starting position of a header image.', 'wpberita' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-position.asp', 'wpberita' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'wpberita' ) . '</a>',
		'default'     => 'center top',
	);

	$bgattachment = array(
		'scroll'  => 'Scroll',
		'fixed'   => 'Fixed',
		'local'   => 'Local',
		'initial' => 'Initial',
		'inherit' => 'Inherit',
	);

	$options[ $gmrprefix . '_headerimage_bgattachment' ] = array(
		'id'          => $gmrprefix . '_headerimage_bgattachment',
		'label'       => __( 'Background Attachment', 'wpberita' ),
		'section'     => $section,
		'type'        => 'select',
		'choices'     => $bgattachment,
		'priority'    => 45,
		'description' => __( 'The background-attachment property sets whether a header image is fixed or scrolls with the rest of the page.', 'wpberita' ) . ' <a href="' . esc_url( __( 'http://www.w3schools.com/cssref/pr_background-attachment.asp', 'wpberita' ) ) . '" target="_blank" rel="nofollow">' . __( 'Learn more!', 'wpberita' ) . '</a>',
		'default'     => 'scroll',
	);

	$section    = 'menu_style';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Topbar & Menu', 'wpberita' ),
		'priority'    => 40,
		'panel'       => $panel_header,
		'description' => __( 'Allow you customize topbar & menu.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_active-searchbutton' ] = array(
		'id'      => $gmrprefix . '_active-searchbutton',
		'label'   => __( 'Remove search button', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-darkmode' ] = array(
		'id'      => $gmrprefix . '_active-darkmode',
		'label'   => __( 'Remove darkmode button', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_first_topnavbtn_text' ] = array(
		'id'          => $gmrprefix . '_first_topnavbtn_text',
		'label'       => __( 'First Top Navigation Button Text', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Fill with button text, example, Index, Signup, etc', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_first_topnavbtn_url' ] = array(
		'id'          => $gmrprefix . '_first_topnavbtn_url',
		'label'       => __( 'First Top Navigation Button URL', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill with button url, fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_second_topnavbtn_text' ] = array(
		'id'          => $gmrprefix . '_second_topnavbtn_text',
		'label'       => __( 'Second Top Navigation Button Text', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Fill with button text, example, Index, Signup, etc', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_second_topnavbtn_url' ] = array(
		'id'          => $gmrprefix . '_second_topnavbtn_url',
		'label'       => __( 'Second Top Navigation Button URL', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill with button url, fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	/**
	 * Module Homepage
	 */
	$panel_homepage = 'panel-homepage';
	$panels[]       = array(
		'id'       => $panel_homepage,
		'title'    => __( 'Homepage', 'wpberita' ),
		'priority' => '45',
	);

	$section    = 'module';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Module Home', 'wpberita' ),
		'priority' => 50,
		'panel'    => $panel_homepage,
	);

	$options[ $gmrprefix . '_active-module-home' ]   = array(
		'id'      => $gmrprefix . '_active-module-home',
		'label'   => __( 'Disable Module Home', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);
	$options[ $gmrprefix . '_category-module-home' ] = array(
		'id'      => $gmrprefix . '_category-module-home',
		'label'   => __( 'Insert Category Name', 'wpberita' ),
		'section' => $section,
		'type'    => 'category-select',
		'default' => '',
	);
	$section    = 'headline_content';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Headline', 'wpberita' ),
		'priority' => 50,
		'panel'    => $panel_homepage,
	);

	$options[ $gmrprefix . '_active-headline' ] = array(
		'id'      => $gmrprefix . '_active-headline',
		'label'   => __( 'Disable Headline In Homepage', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_category-headline' ] = array(
		'id'      => $gmrprefix . '_category-headline',
		'label'   => __( 'Select Headline Category', 'wpberita' ),
		'section' => $section,
		'type'    => 'category-select',
		'default' => '',
	);

	$options[ $gmrprefix . '_textrelated' ] = array(
		'id'          => $gmrprefix . '_textrelated',
		'label'       => __( 'Related text', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Add text related here. Default: Related News.', 'wpberita' ),
	);

	/*
	 * Blog Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_blog = 'panel-blog';
	$panels[]   = array(
		'id'       => $panel_blog,
		'title'    => __( 'Blog', 'wpberita' ),
		'priority' => '50',
	);

	$section    = 'bloglayout';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Layout', 'wpberita' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$options[ $gmrprefix . '_active-sticky-sidebar' ] = array(
		'id'      => $gmrprefix . '_active-sticky-sidebar',
		'label'   => __( 'Disable Sticky In Sidebar', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$blogpagination = array(
		'gmr-pagination' => __( 'Number Pagination', 'wpberita' ),
		'gmr-more'       => __( 'Button Click', 'wpberita' ),
	);

	$options[ $gmrprefix . '_blog_pagination' ] = array(
		'id'      => $gmrprefix . '_blog_pagination',
		'label'   => __( 'Blog Navigation Type', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $blogpagination,
		'default' => 'gmr-more',
	);

	$section    = 'blogcontent';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Blog Content', 'wpberita' ),
		'priority' => 50,
		'panel'    => $panel_blog,
	);

	$options[ $gmrprefix . '_active-singlethumb' ] = array(
		'id'      => $gmrprefix . '_active-singlethumb',
		'label'   => __( 'Disable Single Thumbnail', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-breadcrumb' ] = array(
		'id'      => $gmrprefix . '_active-breadcrumb',
		'label'   => __( 'Disable Breadcrumbs', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_active-relpost' ] = array(
		'id'      => $gmrprefix . '_active-relpost',
		'label'   => __( 'Disable Related Posts in single', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_relpost_number' ] = array(
		'id'          => $gmrprefix . '_relpost_number',
		'label'       => __( 'Number Related Posts', 'wpberita' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '12',
		'description' => __( 'How much number post want to display on related post.', 'wpberita' ),
		'input_attrs' => array(
			'min'  => 4,
			'max'  => 12,
			'step' => 4,
		),
	);

	$taxonomy = array(
		'gmr-tags'     => __( 'By Tags', 'wpberita' ),
		'gmr-category' => __( 'By Categories', 'wpberita' ),
		'gmr-topics'   => __( 'By Topics', 'wpberita' ),
	);

	$options[ $gmrprefix . '_relpost_taxonomy' ] = array(
		'id'      => $gmrprefix . '_relpost_taxonomy',
		'label'   => __( 'Related Posts Taxonomy', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $taxonomy,
		'default' => 'gmr-category',
	);

	$options[ $gmrprefix . '_active-relpostsecond' ] = array(
		'id'      => $gmrprefix . '_active-relpostsecond',
		'label'   => __( 'Disable Second Related Posts in single', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_relpostsecond_number' ] = array(
		'id'          => $gmrprefix . '_relpostsecond_number',
		'label'       => __( 'Number Second Related Posts', 'wpberita' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '12',
		'description' => __( 'How much number post want to display on second related post.', 'wpberita' ),
		'input_attrs' => array(
			'min'  => 2,
			'max'  => 12,
			'step' => 2,
		),
	);

	$options[ $gmrprefix . '_relpostsecond_taxonomy' ] = array(
		'id'      => $gmrprefix . '_relpostsecond_taxonomy',
		'label'   => __( 'Second Related Posts Taxonomy', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $taxonomy,
		'default' => 'gmr-category',
	);

	$options[ $gmrprefix . '_active-relpostthird' ] = array(
		'id'      => $gmrprefix . '_active-relpostthird',
		'label'   => __( 'Disable Third Related Posts in single', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_relpostthird_number' ] = array(
		'id'          => $gmrprefix . '_relpostthird_number',
		'label'       => __( 'Number Third Related Posts', 'wpberita' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '4',
		'description' => __( 'How much number post want to display on third related post.', 'wpberita' ),
		'input_attrs' => array(
			'min'  => 4,
			'max'  => 12,
			'step' => 4,
		),
	);

	$options[ $gmrprefix . '_relpostthird_taxonomy' ] = array(
		'id'      => $gmrprefix . '_relpostthird_taxonomy',
		'label'   => __( 'Third Related Posts Taxonomy', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $taxonomy,
		'default' => 'gmr-category',
	);

	$comments                           = array(
		'default-comment' => __( 'Default Comment', 'wpberita' ),
		'fb-comment'      => __( 'Facebook Comment', 'wpberita' ),
	);
	$options[ $gmrprefix . '_comment' ] = array(
		'id'      => $gmrprefix . '_comment',
		'label'   => __( 'Single Comment', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $comments,
		'default' => 'default-comment',
	);

	$options[ $gmrprefix . '_fbappid' ] = array(
		'id'          => $gmrprefix . '_fbappid',
		'label'       => __( 'Facebook App ID', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'If you using fb comment, you must insert your own Facebook App ID, if you not insert this options, so you will using Facebook App ID from us.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_active-excerpt' ] = array(
		'id'      => $gmrprefix . '_active-excerpt',
		'label'   => __( 'Disable excerpt in archive.', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 1,
	);

	$options[ $gmrprefix . '_excerpt_number' ] = array(
		'id'          => $gmrprefix . '_excerpt_number',
		'label'       => __( 'Excerpt length', 'wpberita' ),
		'section'     => $section,
		'type'        => 'number',
		'default'     => '15',
		'description' => __( 'If you choose excerpt, you can change excerpt lenght (default is 30).', 'wpberita' ),
		'input_attrs' => array(
			'min'  => 10,
			'max'  => 100,
			'step' => 1,
		),
	);

	/*
	 * Banner Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_banner = 'panel-banner';
	$panels[]     = array(
		'id'       => $panel_banner,
		'title'    => __( 'Banner', 'wpberita' ),
		'priority' => '50',
	);

	if ( ! empty( $upload_dir['basedir'] ) ) {
		$upldir = $upload_dir['basedir'] . '/' . $hm;

		if ( @file_exists( $upldir ) ) {
			$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
			if ( @file_exists( $fl ) ) {

				$section    = 'verytopads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Very Top Banner', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner before logo or very top location.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsverytop' ] = array(
					'id'                => $gmrprefix . '_adsverytop',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'logotopads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Side Logo Banner', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner side logo.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adslogotop' ] = array(
					'id'                => $gmrprefix . '_adslogotop',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'topads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Top Banner After Menu', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner after menu.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsaftermenu' ] = array(
					'id'                => $gmrprefix . '_adsaftermenu',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'betweenpostads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner Between Posts', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner between post in archive page.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsbetweenpost' ] = array(
					'id'                => $gmrprefix . '_adsbetweenpost',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$afterpostlocation                                 = array(
					'first'  => __( 'After First Post', 'wpberita' ),
					'second' => __( 'After Second Post', 'wpberita' ),
					'third'  => __( 'After Third Post', 'wpberita' ),
					'fourth' => __( 'After Fourth Post', 'wpberita' ),
				);
				$options[ $gmrprefix . '_adsbetweenpostposition' ] = array(
					'id'      => $gmrprefix . '_adsbetweenpostposition',
					'label'   => __( 'Banner Position', 'wpberita' ),
					'section' => $section,
					'type'    => 'radio',
					'choices' => $afterpostlocation,
					'default' => 'third',
				);

				$section    = 'beforecontentads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner Before Content', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner before single content.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsbeforecontent' ] = array(
					'id'                => $gmrprefix . '_adsbeforecontent',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$locationbanner                                      = array(
					'default'    => __( 'Default', 'wpberita' ),
					'floatleft'  => __( 'Float Left', 'wpberita' ),
					'floatright' => __( 'Float Right', 'wpberita' ),
					'center'     => __( 'Center', 'wpberita' ),
				);
				$options[ $gmrprefix . '_adsbeforecontentposition' ] = array(
					'id'      => $gmrprefix . '_adsbeforecontentposition',
					'label'   => __( 'Banner Position', 'wpberita' ),
					'section' => $section,
					'type'    => 'radio',
					'choices' => $locationbanner,
					'default' => 'default',
				);

				$section    = 'insidecontentads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner Inside Content', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner inside content in single post.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsinsidecontent' ] = array(
					'id'                => $gmrprefix . '_adsinsidecontent',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$locationbanner                                      = array(
					'left'   => __( 'Left', 'wpberita' ),
					'right'  => __( 'Right', 'wpberita' ),
					'center' => __( 'Center', 'wpberita' ),
				);
				$options[ $gmrprefix . '_adsinsidecontentposition' ] = array(
					'id'      => $gmrprefix . '_adsinsidecontentposition',
					'label'   => __( 'Banner Position', 'wpberita' ),
					'section' => $section,
					'type'    => 'radio',
					'choices' => $locationbanner,
					'default' => 'left',
				);

				$section    = 'aftercontentads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner After Content', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner after content in single post.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsaftercontent' ] = array(
					'id'                => $gmrprefix . '_adsaftercontent',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsaftercontentposition' ] = array(
					'id'      => $gmrprefix . '_adsaftercontentposition',
					'label'   => __( 'Banner Position', 'wpberita' ),
					'section' => $section,
					'type'    => 'radio',
					'choices' => $locationbanner,
					'default' => 'left',
				);

				$section    = 'singlerightbanner';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner Sticky Right Content (max width 120px)', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner sticky right content in single post. Please using banner 120px x 600px or maximal width 120px.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsstickyrightcontent' ] = array(
					'id'                => $gmrprefix . '_adsstickyrightcontent',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too. This banner only display in desktop.', 'wpberita' ),
				);

				$section    = 'afterrelpostads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Banner After Related Posts', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner after related posts in single post.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsafterrelpost' ] = array(
					'id'                => $gmrprefix . '_adsafterrelpost',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsafterrelpostposition' ] = array(
					'id'      => $gmrprefix . '_adsafterrelpostposition',
					'label'   => __( 'Banner Position', 'wpberita' ),
					'section' => $section,
					'type'    => 'radio',
					'choices' => $locationbanner,
					'default' => 'left',
				);

				$section    = 'floatleftads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Floating Left Ads', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner floating left in all page.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsfloatleft' ] = array(
					'id'                => $gmrprefix . '_adsfloatleft',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'floatrightads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Floating Right Ads', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner floating right in all page.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsfloatright' ] = array(
					'id'                => $gmrprefix . '_adsfloatright',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'floatbottomads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Floating Bottom Ads', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner floating bottom in all page.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsfloatbottom' ] = array(
					'id'                => $gmrprefix . '_adsfloatbottom',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);

				$section    = 'footerads';
				$sections[] = array(
					'id'          => $section,
					'title'       => __( 'Footer Banner Before Widget', 'wpberita' ),
					'priority'    => 50,
					'panel'       => $panel_banner,
					'description' => __( 'Insert your banner in footer before widget footer or copyright.', 'wpberita' ),
				);

				$options[ $gmrprefix . '_adsfooter' ] = array(
					'id'                => $gmrprefix . '_adsfooter',
					'label'             => __( 'HTML code.', 'wpberita' ),
					'section'           => $section,
					'type'              => 'textarea',
					'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
					'priority'          => 60,
					'description'       => __( 'Please insert your html code, adsense code or other ads code here. This option support shortcode too.', 'wpberita' ),
				);
			} else {
				$section    = 'BannerLicense';
				$sections[] = array(
					'id'       => $section,
					'title'    => __( 'Insert License Key', 'wpberita' ),
					'priority' => 50,
					'panel'    => $panel_banner,
				);

				$options[ $gmrprefix . '_licensekeybanner' ] = array(
					'id'          => $gmrprefix . '_licensekeybanner',
					'label'       => __( 'Insert License Key', 'wpberita' ),
					'section'     => $section,
					'type'        => 'content',
					'priority'    => 60,
					'description' => __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ),
				);

			}
		} else {
			$section    = 'BannerLicense';
			$sections[] = array(
				'id'       => $section,
				'title'    => __( 'Insert License Key', 'wpberita' ),
				'priority' => 50,
				'panel'    => $panel_banner,
			);

			$options[ $gmrprefix . '_licensekeybanner' ] = array(
				'id'          => $gmrprefix . '_licensekeybanner',
				'label'       => __( 'Insert License Key', 'wpberita' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => 60,
				'description' => __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ),
			);
		}
	}

	/*
	 * Color Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_color = 'panel-color';
	$panels[]    = array(
		'id'       => $panel_color,
		'title'    => __( 'Color', 'wpberita' ),
		'priority' => '50',
	);

	// General Colors.
	$section    = 'colors';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'General Colors', 'wpberita' ),
		'panel'    => $panel_color,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_scheme-color' ] = array(
		'id'       => $gmrprefix . '_scheme-color',
		'label'    => __( 'Base Color Scheme', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $color_scheme,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_second-scheme-color' ] = array(
		'id'       => $gmrprefix . '_second-scheme-color',
		'label'    => __( 'Second Color Scheme', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $second_color_scheme,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_big-headline-color' ] = array(
		'id'       => $gmrprefix . '_big-headline-color',
		'label'    => __( 'Big Headline Color', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $bigheadline_scheme,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-bgcolor' ] = array(
		'id'       => $gmrprefix . '_content-bgcolor',
		'label'    => __( 'Background Color - Content', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_bgcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-color' ] = array(
		'id'       => $gmrprefix . '_content-color',
		'label'    => __( 'Font Color - Body', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_color,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-greycolor' ] = array(
		'id'       => $gmrprefix . '_content-greycolor',
		'label'    => __( 'Grey Color - Body', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_greycolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-linkcolor' ] = array(
		'id'       => $gmrprefix . '_content-linkcolor',
		'label'    => __( 'Link Color - Body', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_linkcolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-linkhovercolor' ] = array(
		'id'       => $gmrprefix . '_content-linkhovercolor',
		'label'    => __( 'Link Hover Color - Body', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_linkhovercolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_content-bordercolor' ] = array(
		'id'       => $gmrprefix . '_content-bordercolor',
		'label'    => __( 'Border Color', 'wpberita' ),
		'section'  => $section,
		'type'     => 'color',
		'default'  => $content_bordercolor,
		'priority' => 40,
	);

	$options[ $gmrprefix . '_button-bgcolor' ] = array(
		'id'      => $gmrprefix . '_button-bgcolor',
		'label'   => __( 'Button Background Color', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $button_bgcolor,
	);

	$options[ $gmrprefix . '_button-color' ] = array(
		'id'      => $gmrprefix . '_button-color',
		'label'   => __( 'Button Color', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $button_color,
	);

	// Header color.
	$section    = 'header_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Header Colors', 'wpberita' ),
		'priority'    => 40,
		'panel'       => $panel_color,
		'description' => __( 'Allow you customize header color style.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_header-bgcolor' ] = array(
		'id'      => $gmrprefix . '_header-bgcolor',
		'label'   => __( 'Background Color - Top Navigation', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $header_bgcolor,
	);

	$options[ $gmrprefix . '_topnav-color' ] = array(
		'id'      => $gmrprefix . '_topnav-color',
		'label'   => __( 'Color - Top Navigation', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $topnav_color,
	);

	$options[ $gmrprefix . '_mainmenu-bgcolor' ] = array(
		'id'      => $gmrprefix . '_mainmenu-bgcolor',
		'label'   => __( 'Background Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_bgcolor,
	);

	$options[ $gmrprefix . '_mainmenu-color' ] = array(
		'id'      => $gmrprefix . '_mainmenu-color',
		'label'   => __( 'Text color - Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_color,
	);

	$options[ $gmrprefix . '_hovermenu-color' ] = array(
		'id'      => $gmrprefix . '_hovermenu-color',
		'label'   => __( 'Text hover color - Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $menu_hovercolor,
	);

	$options[ $gmrprefix . '_secondmenu-bgcolor' ] = array(
		'id'      => $gmrprefix . '_secondmenu-bgcolor',
		'label'   => __( 'Background Second Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_bgcolor,
	);

	$options[ $gmrprefix . '_secondmenu-color' ] = array(
		'id'      => $gmrprefix . '_secondmenu-color',
		'label'   => __( 'Text color - Second Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_color,
	);

	$options[ $gmrprefix . '_hoversecondmenu-color' ] = array(
		'id'      => $gmrprefix . '_hoversecondmenu-color',
		'label'   => __( 'Text hover color - Second Menu', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $secondmenu_hovercolor,
	);

	// Footer Colors.
	$section    = 'footer_color';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Footer Colors', 'wpberita' ),
		'priority'    => 40,
		'panel'       => $panel_color,
		'description' => __( 'Allow you customize footer color style.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_footer-bgcolor' ] = array(
		'id'      => $gmrprefix . '_footer-bgcolor',
		'label'   => __( 'Background Color - Footer', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_bgcolor,
	);

	$options[ $gmrprefix . '_footer-fontcolor' ] = array(
		'id'      => $gmrprefix . '_footer-fontcolor',
		'label'   => __( 'Font Color - Footer', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_fontcolor,
	);

	$options[ $gmrprefix . '_footer-linkcolor' ] = array(
		'id'      => $gmrprefix . '_footer-linkcolor',
		'label'   => __( 'Link Color - Footer', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_linkcolor,
	);

	$options[ $gmrprefix . '_footer-hoverlinkcolor' ] = array(
		'id'      => $gmrprefix . '_footer-hoverlinkcolor',
		'label'   => __( 'Hover Link Color - Footer', 'wpberita' ),
		'section' => $section,
		'type'    => 'color',
		'default' => $footer_hoverlinkcolor,
	);

	/*
	 * Footer Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_footer = 'panel-footer';
	$panels[]     = array(
		'id'       => $panel_footer,
		'title'    => __( 'Footer', 'wpberita' ),
		'priority' => '50',
	);

	$section    = 'widget_section';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Widgets Footer', 'wpberita' ),
		'priority'    => 50,
		'panel'       => $panel_footer,
		'description' => __( 'Footer widget columns.', 'wpberita' ),
	);

	$columns = array(
		'1col' => __( '1 Column', 'wpberita' ),
		'2col' => __( '2 Columns', 'wpberita' ),
		'3col' => __( '3 Columns', 'wpberita' ),
		'4col' => __( '4 Columns', 'wpberita' ),
		'6col' => __( '6 Columns', 'wpberita' ),
	);

	$options[ $gmrprefix . '_footer_column' ] = array(
		'id'      => $gmrprefix . '_footer_column',
		'label'   => __( 'Widgets Footer', 'wpberita' ),
		'section' => $section,
		'type'    => 'radio',
		'choices' => $columns,
		'default' => '3col',
	);

	$section    = 'social';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Footer Social', 'wpberita' ),
		'priority'    => 50,
		'panel'       => $panel_footer,
		'description' => __( 'Allow you add social icon.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_active-rssicon' ] = array(
		'id'      => $gmrprefix . '_active-rssicon',
		'label'   => __( 'Disable RSS icon in social', 'wpberita' ),
		'section' => $section,
		'type'    => 'checkbox',
		'default' => 0,
	);

	$options[ $gmrprefix . '_fb_url_icon' ] = array(
		'id'          => $gmrprefix . '_fb_url_icon',
		'label'       => __( 'FB Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_twitter_url_icon' ] = array(
		'id'          => $gmrprefix . '_twitter_url_icon',
		'label'       => __( 'Twitter Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_pinterest_url_icon' ] = array(
		'id'          => $gmrprefix . '_pinterest_url_icon',
		'label'       => __( 'Pinterest Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_tiktok_url_icon' ] = array(
		'id'          => $gmrprefix . '_tiktok_url_icon',
		'label'       => __( 'Tiktok Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_instagram_url_icon' ] = array(
		'id'          => $gmrprefix . '_instagram_url_icon',
		'label'       => __( 'Instagram Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_reddit_url_icon' ] = array(
		'id'          => $gmrprefix . '_reddit_url_icon',
		'label'       => __( 'Reddit Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_linkedin_url_icon' ] = array(
		'id'          => $gmrprefix . '_linkedin_url_icon',
		'label'       => __( 'Linkedin Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_youtube_url_icon' ] = array(
		'id'          => $gmrprefix . '_youtube_url_icon',
		'label'       => __( 'Youtube Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_twitch_url_icon' ] = array(
		'id'          => $gmrprefix . '_twitch_url_icon',
		'label'       => __( 'Twitch Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_spotify_url_icon' ] = array(
		'id'          => $gmrprefix . '_spotify_url_icon',
		'label'       => __( 'Spotify Url', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$options[ $gmrprefix . '_whatsapp_url_icon' ] = array(
		'id'          => $gmrprefix . '_whatsapp_url_icon',
		'label'       => __( 'WhatsApp URL', 'wpberita' ),
		'section'     => $section,
		'type'        => 'url',
		'description' => __( 'Fill using http:// or https://', 'wpberita' ),
		'priority'    => 90,
	);

	$section    = 'copyright_section';
	$sections[] = array(
		'id'       => $section,
		'title'    => __( 'Copyright', 'wpberita' ),
		'priority' => 60,
		'panel'    => $panel_footer,
	);

	if ( ! empty( $upload_dir['basedir'] ) ) {
		$upldir = $upload_dir['basedir'] . '/' . $hm;

		if ( @file_exists( $upldir ) ) {
			$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
			if ( @file_exists( $fl ) ) {
				$options[ $gmrprefix . '_copyright' ] = array(
					'id'          => $gmrprefix . '_copyright',
					'label'       => __( 'Footer Copyright.', 'wpberita' ),
					'section'     => $section,
					'type'        => 'textarea',
					'priority'    => 60,
					'description' => __( 'Display your own copyright text in footer.', 'wpberita' ),
				);
			} else {
				$options[ $gmrprefix . '_copyright' ] = array(
					'id'          => $gmrprefix . '_copyright',
					'label'       => __( 'Insert License Key', 'wpberita' ),
					'section'     => $section,
					'type'        => 'content',
					'priority'    => 60,
					'description' => __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ),
				);
			}
		} else {
			$options[ $gmrprefix . '_copyright' ] = array(
				'id'          => $gmrprefix . '_copyright',
				'label'       => __( 'Insert License Key', 'wpberita' ),
				'section'     => $section,
				'type'        => 'content',
				'priority'    => 60,
				'description' => __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ),
			);
		}
	}

	/*
	 * Call if only woocommerce actived
	 *
	 * @since v.1.0.0
	 */
	if ( class_exists( 'WooCommerce' ) ) {

		$panel_woo = 'woocommerce';
		$panels[]  = array(
			'id'       => $panel_woo,
			'title'    => __( 'WooCommerce', 'wpberita' ),
			'priority' => '200',
		);

		$columns = array(
			'2' => __( '2 Columns', 'wpberita' ),
			'3' => __( '3 Columns', 'wpberita' ),
			'4' => __( '4 Columns', 'wpberita' ),
			'5' => __( '5 Columns', 'wpberita' ),
			'6' => __( '6 Columns', 'wpberita' ),
		);

		$options[ $gmrprefix . '_wc_related_column' ] = array(
			'id'          => $gmrprefix . '_wc_related_column',
			'label'       => __( 'Related Columns', 'wpberita' ),
			'description' => __( 'How many products should be shown per row?', 'wpberita' ),
			'section'     => 'woocommerce_product_catalog',
			'type'        => 'select',
			'choices'     => $columns,
			'default'     => '3',
		);

		// Woocommerce options.
		$section    = 'woocommerce_layout';
		$sections[] = array(
			'id'       => $section,
			'title'    => __( 'Theme Settings', 'wpberita' ),
			'panel'    => $panel_woo,
			'priority' => 100,
		);

		$options[ $gmrprefix . '_active-cartbutton' ] = array(
			'id'      => $gmrprefix . '_active-cartbutton',
			'label'   => __( 'Remove cart button from header.', 'wpberita' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);

		$options[ $gmrprefix . '_active-loginmenu' ] = array(
			'id'      => $gmrprefix . '_active-loginmenu',
			'label'   => __( 'Remove login button from menu.', 'wpberita' ),
			'section' => $section,
			'type'    => 'checkbox',
			'default' => 0,
		);

		/*
		 * Woocommerce Color
		 */
		$section    = 'woocommerce_color';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Woocommerce Color', 'wpberita' ),
			'priority'    => 120,
			'panel'       => $panel_woo,
			'description' => __( 'Allow you customize custom color woocommerce.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_price-color' ] = array(
			'id'      => $gmrprefix . '_price-color',
			'label'   => __( 'Price Color', 'wpberita' ),
			'section' => $section,
			'type'    => 'color',
			'default' => $price_color,
		);

		$options[ $gmrprefix . '_badge-color' ] = array(
			'id'      => $gmrprefix . '_badge-color',
			'label'   => __( 'Badge Text Color', 'wpberita' ),
			'section' => $section,
			'type'    => 'color',
			'default' => $badge_color,
		);

		$options[ $gmrprefix . '_badge-bgcolor' ] = array(
			'id'      => $gmrprefix . '_badge-bgcolor',
			'label'   => __( 'Badge Background Color', 'wpberita' ),
			'section' => $section,
			'type'    => 'color',
			'default' => $badge_bgcolor,
		);

		$options[ $gmrprefix . '_altbutton-color' ] = array(
			'id'      => $gmrprefix . '_altbutton-color',
			'label'   => __( 'Second Button Color', 'wpberita' ),
			'section' => $section,
			'type'    => 'color',
			'default' => $altbutton_color,
		);

		$options[ $gmrprefix . '_altbutton-bgcolor' ] = array(
			'id'      => $gmrprefix . '_altbutton-bgcolor',
			'label'   => __( 'Second Button Background Color', 'wpberita' ),
			'section' => $section,
			'type'    => 'color',
			'default' => $altbutton_bgcolor,
		);

	}

	/*
	 * Call AMP exist
	 *
	 * @since v.1.0.0
	 */
	if ( function_exists( 'is_amp_endpoint' ) ) {
		$panel_amp = 'amppanel';
		$panels[]  = array(
			'id'       => $panel_amp,
			'title'    => __( 'AMP', 'wpberita' ),
			'priority' => '50',
		);

		$section    = 'head_script_amp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Head Script (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'You can insert amp page level adsense here or other amp script. Learn more here: https://amp.dev/documentation/components/amp-ad/. These scripts will be printed in the &lt;head&gt;&lt;/head&gt; section.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_head_script_amp' ] = array(
			'id'                => $gmrprefix . '_head_script_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'footer_script_amp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Footer Script (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'You can insert amp script here. These scripts will be printed before &lt;/body&gt; in amp page.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_footer_script_amp' ] = array(
			'id'                => $gmrprefix . '_footer_script_amp',
			'label'             => __( 'AMP code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'topadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Top Banner After Menu (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Display amp ads after menu. Learn more here: https://amp.dev/documentation/components/amp-ad/', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsaftermenu_amp' ] = array(
			'id'                => $gmrprefix . '_adsaftermenu_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'betweenpostadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Banner Between Posts (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Display amp ads between post in index and archive page. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsbetweenpost_amp' ] = array(
			'id'                => $gmrprefix . '_adsbetweenpost_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$afterpostlocationamp                                  = array(
			'first'  => __( 'After First Post', 'wpberita' ),
			'second' => __( 'After Second Post', 'wpberita' ),
			'third'  => __( 'After Third Post', 'wpberita' ),
			'fourth' => __( 'After Fourth Post', 'wpberita' ),
		);
		$options[ $gmrprefix . '_adsbetweenpostposition_amp' ] = array(
			'id'      => $gmrprefix . '_adsbetweenpostposition_amp',
			'label'   => __( 'Banner Position', 'wpberita' ),
			'section' => $section,
			'type'    => 'radio',
			'choices' => $afterpostlocationamp,
			'default' => 'third',
		);

		$section    = 'beforecontentadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Banner Before Content (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Display amp ads before single content. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsbeforecontent_amp' ] = array(
			'id'                => $gmrprefix . '_adsbeforecontent_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'insidecontentadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Banner Inside Content (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Insert your amp banner inside content in single post. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsinsidecontent_amp' ] = array(
			'id'                => $gmrprefix . '_adsinsidecontent_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'aftercontentadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Banner After Content (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Display amp ads after single content. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsaftercontent_amp' ] = array(
			'id'                => $gmrprefix . '_adsaftercontent_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'afterrelpostadsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Banner After Related Posts (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Display amp ads after related post in single. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsafterrelpost_amp' ] = array(
			'id'                => $gmrprefix . '_adsafterrelpost_amp',
			'label'             => __( 'Ads code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);

		$section    = 'footeradsamp';
		$sections[] = array(
			'id'          => $section,
			'title'       => __( 'Footer Banner Before Widget (AMP)', 'wpberita' ),
			'priority'    => 50,
			'panel'       => $panel_amp,
			'description' => __( 'Insert your banner in footer before widget footer or copyright. Learn more here: https://amp.dev/documentation/components/amp-ad/.', 'wpberita' ),
		);

		$options[ $gmrprefix . '_adsfooter_amp' ] = array(
			'id'                => $gmrprefix . '_adsfooter_amp',
			'label'             => __( 'HTML code.', 'wpberita' ),
			'section'           => $section,
			'type'              => 'textarea',
			'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
			'priority'          => 60,
		);
	}

	/*
	 * Other Section Options
	 *
	 * @since v.1.0.0
	 */
	$panel_other = 'panel-other';
	$panels[]    = array(
		'id'       => $panel_other,
		'title'    => __( 'Other', 'wpberita' ),
		'priority' => '50',
	);

	$section    = 'head_script';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Head Script', 'wpberita' ),
		'priority'    => 60,
		'panel'       => $panel_other,
		'description' => __( 'Allow you add script inside &lt;head&gt;&lt;/head&gt;.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_head_script' ] = array(
		'id'                => $gmrprefix . '_head_script',
		'label'             => __( 'HTML code.', 'wpberita' ),
		'section'           => $section,
		'type'              => 'textarea',
		'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
		'priority'          => 60,
		'description'       => __( 'Please insert your code here.', 'wpberita' ),
	);

	$section    = 'footer_script';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Footer Script', 'wpberita' ),
		'priority'    => 60,
		'panel'       => $panel_other,
		'description' => __( 'Allow you add script before &lt;/body&gt;.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_footer_script' ] = array(
		'id'                => $gmrprefix . '_footer_script',
		'label'             => __( 'HTML code.', 'wpberita' ),
		'section'           => $section,
		'type'              => 'textarea',
		'sanitize_callback' => 'customizer_library_sanitize_textareajsallowed',
		'priority'          => 60,
		'description'       => __( 'Please insert your code here.', 'wpberita' ),
	);

	$section    = 'analytic_script';
	$sections[] = array(
		'id'          => $section,
		'title'       => __( 'Analytic & Pixel', 'wpberita' ),
		'priority'    => 60,
		'panel'       => $panel_other,
		'description' => __( 'Allow you add google analytic and facebook pixel.', 'wpberita' ),
	);

	$options[ $gmrprefix . '_analytic' ] = array(
		'id'          => $gmrprefix . '_analytic',
		'label'       => __( 'Google Analytics ID', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Enter your Google Analytics ID (Ex: UA-XXXXX-X).', 'wpberita' ),
	);

	$options[ $gmrprefix . '_pixel' ] = array(
		'id'          => $gmrprefix . '_pixel',
		'label'       => __( 'Facebook Pixel ID', 'wpberita' ),
		'section'     => $section,
		'type'        => 'text',
		'description' => __( 'Enter your Facebook Pixel ID.', 'wpberita' ),
	);

	// Adds the sections to the $options array.
	$options['sections'] = $sections;
	// Adds the panels to the $options array.
	$options['panels']  = $panels;
	$customizer_library = Customizer_Library::Instance();
	$customizer_library->add_options( $options );
	// To delete custom mods use: customizer_library_remove_theme_mods();.
}
add_action( 'init', 'gmr_library_options_customizer' );

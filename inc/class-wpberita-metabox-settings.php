<?php
/**
 * Add functionally oembed metaboxes
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WpBerita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register a meta box using a class.
 *
 * @since 1.0.0
 */
class WpBerita_Metabox_Settings {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_footer', array( $this, 'wpberita_admin_enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'wpberita_admin_enqueue_style' ) );
		add_action( 'load-post.php', array( $this, 'post_metabox_setup' ) );
		add_action( 'load-post-new.php', array( $this, 'post_metabox_setup' ) );
	}

	/**
	 * Metabox setup function
	 */
	public function post_metabox_setup() {
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ), 10, 2 );
	}

	/**
	 * Register the JavaScript.
	 */
	public function wpberita_admin_enqueue_scripts() {
		global $post_type;
		if ( 'post' === $post_type ) {
			?>
			<script type="text/javascript">
				(function( $ ) {
					'use strict';
					/**
					 * From this point every thing related to metabox
					 */
					$('document').ready(function(){
						$('h3.nav-tab-wrapper span:first').addClass('current');
						$('.tab-content:first').addClass('current');
						$('h3.nav-tab-wrapper span').click(function(){
							var t = $(this).attr('id');

							$('h3.nav-tab-wrapper span').removeClass('current');
							$('.tab-content').removeClass('current');

							$(this).addClass('current');
							$('#'+ t + 'C').addClass('current');
						});
						// First tab inner
						$('ul.nav-tab-wrapper li:first').addClass('current');
						$('.tab-content-inner:first').addClass('current');
						$('ul.nav-tab-wrapper li').click(function(){
							var t = $(this).attr('id');

							$('ul.nav-tab-wrapper li').removeClass('current');
							$('.tab-content-inner').removeClass('current');

							$(this).addClass('current');
							$('#'+ t + 'C').addClass('current');
						});
					});
				})( jQuery );
			</script>
			<?php
		}
	}

	/**
	 * Register the Style CSS.
	 */
	public function wpberita_admin_enqueue_style() {
		global $post_type;
		if ( 'post' === $post_type ) {
			?>
			<style type="text/css">
			body.post-new-php #titlediv #title-prompt-text {display: none !important;}
			ul.nav-tab-wrapper {display:block;width: 100%;}
			ul.nav-tab-wrapper li{background: none;color: #0073aa;padding: 3px 5px;display: inline-block;cursor: pointer;margin-right:3px;}
			h3.nav-tab-wrapper span{background: none;color: #0073aa;display: inline-block;padding: 10px 15px;cursor: pointer;}
			ul.nav-tab-wrapper li.current,
			h3.nav-tab-wrapper span.current{background: #ededed;color: #222;cursor: default;}
			.tab-content-inner,
			.tab-content{display: none;}
			.tab-content-inner.current,
			.tab-content.current{display: inherit;padding-top: 20px;}
			.wpberita-metabox-common-fields p {margin-bottom: 20px;}
			.wpberita-metabox-common-fields input.display-block,
			.wpberita-metabox-common-fields textarea.display-block{display:block;width:100%;}
			.wpberita-metabox-common-fields input[type="button"].display-block {margin-top:10px;}
			.wpberita-metabox-common-fields label {display: block;margin-bottom: 5px;}
			.wpberita-metabox-common-fields input[disabled] {background: #ddd;}
			.wpberita-metabox-common-fields .nav-tab-active,
			.wpberita-metabox-common-fields .nav-tab-active:focus,
			.wpberita-metabox-common-fields .nav-tab-active:focus:active,
			.wpberita-metabox-common-fields .nav-tab-active:hover {border-bottom: 1px solid #ffffff !important;background: #ffffff !important;color: #000;}
			</style>
			<?php
		}
	}

	/**
	 * Adds the meta box.
	 *
	 * @param string $post_type post type name.
	 */
	public function add_meta_box( $post_type ) {
		$post_types = array( 'post' );
		if ( in_array( $post_type, $post_types, true ) ) {
			add_meta_box( 'wpberita_video_meta_metabox', esc_html__( 'Post Settings', 'wpberita' ), array( $this, 'metabox_callback' ), $post_type, 'advanced', 'default' );
		}
	}

	/**
	 * Save the meta box.
	 *
	 * @param int    $post_id Post ID.
	 * @param string $post Post.
	 * @return int $post_id
	 */
	public function save( $post_id, $post ) {
		/* Verify the nonce before proceeding. */
		if ( ! isset( $_POST['wpberita_video_meta_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['wpberita_video_meta_nonce'] ) ), basename( __FILE__ ) ) ) {
			return $post_id;
		}

		/* Get the post type object. */
		$post_type = get_post_type_object( $post->post_type );

		/* Check if the current user has permission to edit the post. */
		if ( ! current_user_can( $post_type->cap->edit_post, $post_id ) ) {
			return $post_id;
		}

		/* List of meta box fields (name => meta_key) */
		$fields = array(
			'source-value' => 'MAJPRO_Source',
			'writer-value' => 'MAJPRO_Writer',
			'editor-value' => 'MAJPRO_Editor',
			'eombed-value' => 'MAJPRO_Oembed',
			'iframe-value' => 'MAJPRO_Iframe',
		);

		foreach ( $fields as $name => $meta_key ) {
			/* Check if meta box fields has a proper value */
			if ( isset( $_POST[ $name ] ) && 'N/A' !== $_POST[ $name ] ) {
				$allowed = array(
					'iframe' => array(
						'align'           => array(),
						'allowfullscreen' => array(),
						'allow'           => array(),
						'width'           => array(),
						'height'          => array(),
						'frameborder'     => array(),
						'name'            => array(),
						'src'             => array(),
						'id'              => array(),
						'class'           => array(),
						'style'           => array(),
						'scrolling'       => array(),
						'marginwidth'     => array(),
						'marginheight'    => array(),
					),
				);

				$new_meta_value = wp_kses( wp_unslash( $_POST[ $name ] ), $allowed );
			} else {
				$new_meta_value = '';
			}

			/* Get the meta value of the custom field key */
			$meta_value = get_post_meta( $post_id, $meta_key, true );

			/* If a new meta value was added and there was no previous value, add it. */
			if ( $new_meta_value && empty( $meta_value ) ) :
				add_post_meta( $post_id, $meta_key, $new_meta_value, true );

				/* If the new meta value does not match the old value, update it. */
			elseif ( $new_meta_value && $new_meta_value !== $meta_value ) :
				update_post_meta( $post_id, $meta_key, $new_meta_value );

				/* If there is no new meta value but an old value exists, delete it. */
			elseif ( empty( $new_meta_value ) && $meta_value ) :
				delete_post_meta( $post_id, $meta_key, $meta_value );

			endif;

		}

		// Sanitize the user input using boolean.
		$mydata_focus = isset( $_POST['gmr_focus_field'] ) ? (bool) $_POST['gmr_focus_field'] : false;

		// Update the meta field.
		update_post_meta( $post_id, '_gmr_focus_key', $mydata_focus );

	}

	/**
	 * Meta box html view
	 *
	 * @param array  $object Object Post Type.
	 * @param string $box returning string.
	 */
	public function metabox_callback( $object, $box ) {
		global $post;
		// Add an nonce field so we can check for it later.
		wp_nonce_field( basename( __FILE__ ), 'wpberita_video_meta_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value_focus = get_post_meta( $post->ID, '_gmr_focus_key', true );
		
		$hm         = md5( wpberita_get_home() );
		$license    = trim( get_option( 'wpberita_core_license_key' . $hm ) );
		$upload_dir = wp_upload_dir();
		if ( ! empty( $upload_dir['basedir'] ) ) {
			$upldir = $upload_dir['basedir'] . '/' . $hm;

			if ( @file_exists( $upldir ) ) {
				$fl = $upload_dir['basedir'] . '/' . $hm . '/' . $license . '.json';
				if ( @file_exists( $fl ) ) {
					?>
					<div id="col-container">
						<div class="metabox-holder wpberita-metabox-common-fields">
							<h3 class="nav-tab-wrapper">
								<span class="nav-tab tab-link" id="tab-1"><?php esc_html_e( 'Post Settings:', 'wpberita' ); ?></span>
								<span class="nav-tab tab-link" id="tab-2"><?php esc_html_e( 'Video Settings:', 'wpberita' ); ?></span>
							</h3>
							<div id="tab-1C" class="group tab-content">
								<p>
									<label for="gmr_focus_field"><strong><?php esc_html_e( 'Focus News:', 'wpberita' ); ?></strong></label>
									<input type="checkbox" class="checkbox" id="gmr_focus_field" name="gmr_focus_field" <?php checked( $value_focus ); ?> />
									<span for="gmr_focus_field"><?php esc_html_e( 'Enable the focus for this news?', 'wpberita' ); ?></span>
								</p>
								<p>
									<label for="opsi-source"><strong><?php esc_html_e( 'Source URL:', 'wpberita' ); ?></strong></label>
									<input type="url" class="regular-text display-block" id="opsi-source" placeholder="http://" name="source-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'MAJPRO_Source', true ) ); ?>" />
									<span class="howto"><?php esc_html_e( 'Please insert post source URL.', 'wpberita' ); ?></span>
								</p>
								<p>
									<label for="opsi-writer"><strong><?php esc_html_e( 'News Writer:', 'wpberita' ); ?></strong></label>
									<input type="text" class="regular-text display-block" id="opsi-writer" placeholder="Writer" name="writer-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'MAJPRO_Writer', true ) ); ?>" />
									<span class="howto"><?php esc_html_e( 'Please insert name of news writer.', 'wpberita' ); ?></span>
								</p>
								<p>
									<label for="opsi-editor"><strong><?php esc_html_e( 'News Editor:', 'wpberita' ); ?></strong></label>
									<input type="text" class="regular-text display-block" id="opsi-editor" placeholder="Editor" name="editor-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'MAJPRO_Editor', true ) ); ?>" />
									<span class="howto"><?php esc_html_e( 'Please insert name of news editor.', 'wpberita' ); ?></span>
								</p>
							</div>
							<div id="tab-2C" class="group tab-content">
								<ul class="subsubsub nav-tab-wrapper">
									<li class="nav-tab tab-link" id="tabserver-1"><?php esc_html_e( 'Oembed', 'wpberita' ); ?></li>
									<li class="nav-tab tab-link" id="tabserver-2"><?php esc_html_e( 'Iframe', 'wpberita' ); ?></li>
								</ul>
								<div class="clear"></div>
								<p id="tabserver-1C" class="innergroup tab-content-inner">
									<label for="opsi-player1"><strong><?php esc_html_e( 'Oembed URL:', 'wpberita' ); ?></strong></label>
									<input type="url" class="regular-text display-block" id="opsi-player1" placeholder="http://" name="eombed-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'MAJPRO_Oembed', true ) ); ?>" />
									<span class="howto"><?php esc_html_e( 'Please insert full URL from youtube, vimeo or other oembed service, please see https://codex.wordpress.org/Embeds for information.', 'wpberita' ); ?></span>
								</p>
								<p id="tabserver-2C" class="innergroup tab-content-inner">
									<label for="opsi-player2"><strong><?php esc_html_e( 'Iframe Code:', 'wpberita' ); ?></strong></label>
									<textarea name="iframe-value" id="opsi-player2" rows="4" cols="55" class="regular-text display-block"><?php echo esc_html( get_post_meta( $object->ID, 'MAJPRO_Iframe', true ) ); ?></textarea>
									<span class="howto"><?php esc_html_e( 'Please insert html iframe here, if you using oembed url, this will not display. Only support iframe code.', 'wpberita' ); ?></span>
								</p>
							</div>
						</div>
					</div>
					<?php
				} else {
					?>
					<div id="col-container">
						<div class="metabox-holder wpberita-metabox-common-fields">
							<p>
								<?php echo __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ); ?>
							</p>
						</div>
					</div>
					<?php
				}
			} else {
				?>
				<div id="col-container">
					<div class="metabox-holder wpberita-metabox-common-fields">
						<p>
							<?php echo __( '<a href="plugins.php?page=wpberita-license" style="font-weight: 700;">Please insert your own license key here</a>.<br /><br /> If you bought from kentooz, you can get license key in your memberarea. <a href="https://member.kentooz.com/softsale/license" target="_blank">https://member.kentooz.com/softsale/license</a>', 'wpberita' ); ?>
						</p>
					</div>
				</div>
				<?php
			}
		}	
	}

}

/* Load only if dashboard */
if ( is_admin() ) {
	new WpBerita_Metabox_Settings();
}

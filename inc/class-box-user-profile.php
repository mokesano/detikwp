<?php
/**
 * Custom Options For User WordPress
 *
 * Author: Gian MR - http://www.gianmr.com
 *
 * @since 1.0.0
 * @package wpberita
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Classes for box profile
 */
class Box_User_Profile {
	/**
	 * Constract
	 */
	public function __construct() {
		// Social Links.
		add_action( 'show_user_profile', array( $this, 'add_image_authorpage' ) );
		add_action( 'edit_user_profile', array( $this, 'add_image_authorpage' ) );

		// Social Image Background.
		add_action( 'show_user_profile', array( $this, 'add_social_user' ) );
		add_action( 'edit_user_profile', array( $this, 'add_social_user' ) );

		add_action( 'personal_options_update', array( $this, 'save_user_profile' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_user_profile' ) );

		if ( is_admin() ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}
	}

	/**
	 * Add Image To Author Page
	 *
	 * @param string $user User.
	 */
	public function add_image_authorpage( $user ) {
		$default_url = get_template_directory_uri() . '/img/flat-bg.jpg';
		?>
			<h2><?php esc_html_e( 'Add Image In Author Page', 'wpberita' ); ?></h2>
			<table id="custom-profile-image" class="form-table">
				<tr>
					<th><label for="user_image_authorpage"><?php esc_html_e( 'Image', 'wpberita' ); ?></label></th>
					<td>
						<div id="current-image">
						<?php wp_nonce_field( 'image-authorpage', 'image-authorpage-nonce' ); ?>
						<p><img data-default="<?php echo esc_url_raw( $default_url ); ?>" src="<?php echo '' !== get_user_meta( $user->ID, 'image-authorpage', true ) ? esc_url_raw( get_user_meta( $user->ID, 'image-authorpage', true ) ) : esc_url_raw( $default_url ); ?>"></p>
						<p class="description"><?php esc_html_e( 'This will display in author archive. Recommended size is 1100x250', 'wpberita' ); ?></p>
						<p><input type="text" name="custom-image-ap" id="custom-image-ap" class="regular-text" value="<?php echo esc_attr( get_user_meta( $user->ID, 'image-authorpage', true ) ); ?>"></p>
						</div>
						<p class="actions">
						<a href="#" class="button-secondary" id="remove-image"><?php esc_html_e( 'Remove Image', 'wpberita' ); ?></a>
						<a href="#" class="button-primary" id="add-image"><?php esc_html_e( 'Upload Image', 'wpberita' ); ?></a>
						</p>
					</td>
				</tr>
			</table>
		<?php
	}

	/**
	 * Add Social To Author Page
	 *
	 * @param string $user User.
	 */
	public function add_social_user( $user ) {
		?>
		<h2><?php esc_html_e( 'Social Media', 'wpberita' ); ?></h2>
		<table class="form-table">
			<tr>
				<th>
					<label for="user_facebook"><?php esc_html_e( 'Facebook URL', 'wpberita' ); ?></label>
				</th>
				<td>
					<input type="url" name="user_facebook" id="user_facebook" value="<?php echo esc_url( get_the_author_meta( 'user_facebook', $user->ID ) ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Your Facebook URL.', 'wpberita' ); ?></p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="user_twitter"><?php esc_html_e( 'Twitter URL', 'wpberita' ); ?></label>
				</th>
				<td>
					<input type="url" name="user_twitter" id="user_twitter" value="<?php echo esc_url( get_the_author_meta( 'user_twitter', $user->ID ) ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Your Twitter URL.', 'wpberita' ); ?></p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="user_youtube"><?php esc_html_e( 'Youtube URL', 'wpberita' ); ?></label>
				</th>
				<td>
					<input type="url" name="user_youtube" id="user_youtube" value="<?php echo esc_url( get_the_author_meta( 'user_youtube', $user->ID ) ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Your Youtube URL.', 'wpberita' ); ?></p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="user_whatsapp"><?php esc_html_e( 'WhatsApp URL', 'wpberita' ); ?></label>
				</th>
				<td>
					<input type="url" name="user_whatsapp" id="user_whatsapp" value="<?php echo esc_url( get_the_author_meta( 'user_whatsapp', $user->ID ) ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Your WhatsApp URL Example: https://wa.me/62XXXXXXXXXX. Tutorial https://faq.whatsapp.com/general/chats/how-to-use-click-to-chat/', 'wpberita' ); ?></p>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Save User
	 *
	 * @param string $userid User id.
	 */
	public function save_user_profile( $userid ) {
		if ( ! current_user_can( 'edit_user', $userid ) ) {
			return;
		}

		if ( isset( $_REQUEST['user_facebook'] ) && ! empty( $_REQUEST['user_facebook'] ) ) {
			$fb = esc_url_raw( wp_unslash( $_REQUEST['user_facebook'] ) );
		} else {
			$fb = '';
		}

		if ( isset( $_REQUEST['user_twitter'] ) && ! empty( $_REQUEST['user_twitter'] ) ) {
			$twitter = esc_url_raw( wp_unslash( $_REQUEST['user_twitter'] ) );
		} else {
			$twitter = '';
		}

		if ( isset( $_REQUEST['user_youtube'] ) && ! empty( $_REQUEST['user_youtube'] ) ) {
			$ytb = esc_url_raw( wp_unslash( $_REQUEST['user_youtube'] ) );
		} else {
			$ytb = '';
		}

		if ( isset( $_REQUEST['user_whatsapp'] ) && ! empty( $_REQUEST['user_whatsapp'] ) ) {
			$wa = esc_url_raw( wp_unslash( $_REQUEST['user_whatsapp'] ) );
		} else {
			$wa = '';
		}

		update_user_meta( $userid, 'user_facebook', $fb );
		update_user_meta( $userid, 'user_twitter', $twitter );
		update_user_meta( $userid, 'user_youtube', $ytb );
		update_user_meta( $userid, 'user_whatsapp', $wa );

		if ( ! current_user_can( 'upload_files', $userid ) ) {
			return;
		}

		if ( ! isset( $_POST['image-authorpage-nonce'] ) || ! wp_verify_nonce( $_POST['image-authorpage-nonce'], 'image-authorpage' ) ) {
			return;
		}

		if ( isset( $_POST['custom-image-ap'] ) && '' !== $_POST['custom-image-ap'] ) {
			update_user_meta( $userid, 'image-authorpage', esc_url_raw( wp_unslash( $_POST['custom-image-ap'] ) ) );
		} else {
			delete_user_meta( $userid, 'image-authorpage' );
		}

	}

	/**
	 * Save User
	 *
	 * @param string $hook hook.
	 */
	public function admin_scripts( $hook ) {
		// loaded only on plugin page.
		if ( 'profile.php' === $hook || 'user-edit.php' === $hook ) {
			wp_enqueue_media();
			wp_enqueue_editor();
			wp_enqueue_script( 'wpberita-user-editor-js', get_template_directory_uri() . '/js/user-field-editor.js', array( 'jquery' ), '1.0.0', true );
		}
	}

}

new Box_User_Profile();

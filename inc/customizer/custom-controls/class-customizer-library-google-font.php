<?php
/**
 * Customize for dropdown categories, extend the WP customizer
 *
 * @package Customizer_Library
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return null;
}

/**
 * Google Font Select Custom Control
 *
 * @author Anthony Hortin <http://maddisondesigns.com>
 * @license http://www.gnu.org/licenses/gpl-2.0.html
 * @link https://github.com/maddisondesigns
 */
class Customizer_Library_Google_Font extends WP_Customize_Control {
	/**
	 * The type of control being rendered
	 *
	 * @var $type Fonts Type.
	 */
	public $type = 'google_fonts';
	/**
	 * The list of Google Fonts
	 *
	 * @var $fontlist List font Boolean.
	 */
	private $fontlist = false;
	/**
	 * The saved font values decoded from json
	 *
	 * @var $fontvalues Array.
	 */
	private $fontvalues = [];
	/**
	 * The index of the saved font within the list of Google fonts
	 *
	 * @var $fontlistindex Index font list.
	 */
	private $fontlistindex = 0;
	/**
	 * Get our list of fonts from the json file
	 *
	 * @param string $manager Manager.
	 * @param int    $id Font ID.
	 * @param array  $args Arguments.
	 * @param array  $options Options.
	 */
	public function __construct( $manager, $id, $args = array(), $options = array() ) {
		parent::__construct( $manager, $id, $args );
		$this->fontlist = $this->customizer_getGoogleFonts();
		// Decode the default json font value.
		$this->fontvalues = json_decode( $this->value() );
		// Find the index of our default font within our list of Google fonts.
		$this->fontlistindex = $this->customizer_getFontIndex( $this->fontlist, $this->fontvalues->font );
	}
	/**
	 * Enqueue our scripts and styles
	 */
	public function enqueue() {
		$path = str_replace( wp_normalize_path( WP_CONTENT_DIR ), WP_CONTENT_URL, wp_normalize_path( dirname( dirname( __FILE__ ) ) ) );

		wp_enqueue_script( 'wpberita-select2-js', $path . '/js/select2.full.min.js', array( 'jquery' ), '4.0.13', true );
		wp_enqueue_script( 'wpberita-custom-controls-js', $path . '/js/custom.js', array( 'wpberita-select2-js' ), '1.0', true );
		wp_enqueue_style( 'wpberita-custom-controls-css', $path . '/css/custom.css', array(), '1.1', 'all' );
		wp_enqueue_style( 'wpberita-select2-css', $path . '/css/select2.min.css', array(), '4.0.13', 'all' );
	}
	/**
	 * Export our List of Google Fonts to JavaScript
	 */
	public function to_json() {
		parent::to_json();
		$this->json['idthemefontslist'] = $this->fontlist;
	}
	/**
	 * Render the control in the customizer
	 */
	public function render_content() {
		$isfontinlist = false;
		$fontliststr  = '';

		if ( ! empty( $this->fontlist ) ) {
			?>

			<?php if ( ! empty( $this->label ) ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<?php if ( ! empty( $this->description ) ) { ?>
				<span class="customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>
			<div class="google_fonts_select_control">
				<input type="hidden" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_attr( $this->value() ); ?>" class="customize-control-google-font-selection" <?php $this->link(); ?> />
				<div class="google-fonts">
					<select class="google-fonts-list" control-name="<?php echo esc_attr( $this->id ); ?>">
						<?php
						foreach ( $this->fontlist as $key => $value ) {
							$fontliststr .= '<option value="' . $value->f . '" ' . selected( $this->fontvalues->font, $value->f, false ) . '>' . $value->f . '</option>';
							if ( $this->fontvalues->font === $value->f ) {
								$isfontinlist = true;
							}
						}
						if ( ! $isfontinlist && $this->fontlistindex ) {
							// If the default or saved font value isn't in the list of displayed fonts, add it to the top of the list as the default font.
							$fontliststr = '<option value="' . $this->fontlist[ $this->fontlistindex ]->f . '" ' . selected( $this->fontvalues->font, $this->fontlist[ $this->fontlistindex ]->f, false ) . '>' . $this->fontlist[ $this->fontlistindex ]->f . ' (default)</option>' . $fontliststr;
						}
						// Display our list of font options.
						echo $fontliststr; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
						?>
					</select>
				</div>
				<div class="customize-control-description"><?php esc_html_e( 'Select weight & style for regular text', 'wpberita' ); ?></div>
				<div class="weight-style">
					<select class="google-fonts-regularweight-style">
						<?php
						$optioncount = 0;
						foreach ( $this->fontlist[ $this->fontlistindex ]->v as $key => $value ) {
							// Only add options that aren't italic.
							if ( strpos( $value, 'italic' ) === false ) {
								echo '<option value="' . esc_html( $value ) . '" ' . selected( $this->fontvalues->regularweight, $value, false ) . '>' . esc_html( $value ) . '</option>';
								$optioncount++;
							}
						}
						// This should never evaluate as there'll always be at least a 'regular' weight.
						if ( 0 === $optioncount ) {
							echo '<option value="">Not Available for this font</option>';
						}
						?>
					</select>
				</div>
				<div class="customize-control-description"><?php esc_html_e( 'Select weight for', 'wpberita' ); ?> <italic><?php esc_html_e( 'italic text', 'wpberita' ); ?></italic></div>
				<div class="weight-style">
					<select class="google-fonts-italicweight-style" <?php disabled( in_array( 'italic', $this->fontlist[ $this->fontlistindex ]->v ), false ); ?>>
						<?php
						$optioncount = 0;
						foreach ( $this->fontlist[ $this->fontlistindex ]->v as $key => $value ) {
							// Only add options that are italic.
							if ( strpos( $value, 'italic' ) !== false ) {
								echo '<option value="' . esc_html( $value ) . '" ' . selected( $this->fontvalues->italicweight, $value, false ) . '>' . esc_html( $value ) . '</option>';
								$optioncount++;
							}
						}
						if ( 0 === $optioncount ) {
							echo '<option value="">Not Available for this font</option>';
						}
						?>
					</select>
				</div>

				<div class="customize-control-description"><?php esc_html_e( 'Select weight for', 'wpberita' ); ?> <strong><?php esc_html_e( 'bold text', 'wpberita' ); ?></strong></div>
				<div class="weight-style">
					<select class="google-fonts-boldweight-style">
						<?php
						$optioncount = 0;
						foreach ( $this->fontlist[ $this->fontlistindex ]->v as $key => $value ) {
							// Only add options that aren't italic.
							if ( strpos( $value, 'italic' ) === false ) {
								echo '<option value="' . esc_html( $value ) . '" ' . selected( $this->fontvalues->boldweight, $value, false ) . '>' . esc_html( $value ) . '</option>';
								$optioncount++;
							}
						}
						// This should never evaluate as there'll always be at least a 'regular' weight.
						if ( 0 === $optioncount ) {
							echo '<option value="">Not Available for this font</option>';
						}
						?>
					</select>
				</div>
			</div>
			<?php
		}
	}

	/**
	 * Find the index of the saved font in our multidimensional array of Google Fonts
	 *
	 * @param array $haystack Haystack.
	 * @param array $needle Needle.
	 */
	public function customizer_getFontIndex( $haystack, $needle ) {
		foreach ( $haystack as $key => $value ) {
			if ( $value->f == $needle ) {
				return $key;
			}
		}
		return false;
	}

	/**
	 * Return the list of Google Fonts from our json file. Unless otherwise specfied, list will be limited to 30 fonts.
	 */
	public function customizer_getGoogleFonts() {
		$path     = str_replace( wp_normalize_path( WP_CONTENT_DIR ), WP_CONTENT_URL, wp_normalize_path( dirname( dirname( __FILE__ ) ) ) );
		$fontfile = $path . '/google-fonts-alphabetical.json';

		$request = wp_remote_get( $fontfile );
		if ( is_wp_error( $request ) ) {
			return '';
		}

		$body    = wp_remote_retrieve_body( $request );
		$content = json_decode( $body );

		return $content->items;

	}
}

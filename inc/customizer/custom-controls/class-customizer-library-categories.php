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
 * Class to Customize for dropdown categories, extend the WP customizer.
 */
class Customizer_Library_Categories extends WP_Customize_Control {
	/**
	 * Control type.
	 *
	 * @var string
	 */
	public $type = 'category-select';

	/**
	 * Dropdown categories array for this control.
	 *
	 * @var array
	 */
	public $dropdown = array();

	/**
	 * Refresh the parameters passed to the JavaScript via JSON.
	 *
	 * @see WP_Customize_Control::to_json()
	 */
	public function to_json() {

		parent::to_json();

		$this->json['default'] = $this->setting->default;
		if ( isset( $this->default ) ) {
			$this->json['default'] = $this->default;
		}
		$this->json['value'] = $this->value();

		$this->json['link']        = $this->get_link();
		$this->json['id']          = $this->id;
		$this->json['label']       = esc_html( $this->label );
		$this->json['description'] = $this->description;

		$dropdown = wp_dropdown_categories(
			array(
				'echo'              => false,
				'name'              => '_customize-dropdown-categories-' . esc_attr( $this->id ),
				'show_option_none'  => __( '&mdash; Select &mdash;', 'wpberita' ),
				'option_none_value' => '0',
				'selected'          => esc_attr( $this->value() ),
			)
		);

		// Add in the data link parameter for dropdown categories.
		$dropdown = str_replace( '<select', '<select ' . $this->get_link(), $dropdown );

		$this->json['dropdown'] = $dropdown;

		$this->json['inputAttrs'] = '';
		foreach ( $this->input_attrs as $attr => $value ) {
			$this->json['inputAttrs'] .= $attr . '="' . esc_attr( $value ) . '" ';
		}

	}

	/**
	 * Don't render the control content from PHP, as it's rendered via JS on load.
	 */
	public function render_content() {
	}

	/**
	 * An Underscore (JS) template for this control's content (but not its container).
	 *
	 * Class variables for this control class are available in the `data` JS object;
	 * export custom variables by overriding {@see WP_Customize_Control::to_json()}.
	 *
	 * @see    WP_Customize_Control::print_template()
	 *
	 * @access protected
	 */
	protected function content_template() {
		?>

		<div class="customizer-text">
			<# if ( data.label ) { #>
			<span class="customize-control-title">{{{ data.label }}}</span>
			<# } #>

			<# if ( data.description ) { #>
			<span class="description customize-control-description">{{{ data.description }}}</span>
			<# } #>
		</div>

		<div class="customize-control-content">
			{{{ data.dropdown }}}
		</div>

		<?php
	}

}
